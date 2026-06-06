<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\Category;
use App\Models\Specification;
use App\Models\Order;
use App\Models\Item;
use App\Models\Seller;
use App\Models\Delivery;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Exports\ItemsExport;
use App\Models\Banner;
use App\Models\User;
use App\Models\Contacts;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException as ExcelValidationException;
use App\Imports\ItemsImport;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Excel as ExcelType;


class ItemController extends Controller
{
   // ItemController.php
public function index(Request $request)
{
    $query = Item::with(['category']); // Removed 'contacts'

    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }
    if ($request->filled('title')) {
        $query->where('title', 'like', '%' . $request->title . '%');
    }
    if ($request->filled('subtitle')) {
        $query->where('subtitle', 'like', '%' . $request->subtitle . '%');
    }

    $items = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
    $categories = Category::all();

    return view('admin.items.index', compact('items', 'categories'));
}


    public function create()
    {
$categories = Category::with('children.children')->whereNull('parent_id')->get();
    $sellers = Seller::all(); // fetch all existing sellers

        return view('admin.items.add', compact('categories', 'sellers'));
    }

 public function store(Request $request)
{
    // --- Validate request ---
    $request->validate([
        'category_id' => 'required|exists:categories,id',
        'title' => 'required|string|max:255',
        'subtitle' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'item_features' => 'nullable|string',
        'collection_date' => 'required|date',
        'price' => 'required|numeric',
        'actual_price' => 'nullable|numeric',
        'discount_percentage' => 'nullable|numeric',
        'stocks' => 'required|integer',
        'image' => 'nullable|image',
        'seller_id' => 'nullable|exists:sellers,id',
        'seller_name_new' => 'nullable|string|max:255',
        'gallery.*' => 'nullable|image',
        'size' => 'nullable|string',
        'weight' => 'nullable|string',
        'height' => 'nullable|string',
        'width' => 'nullable|string',
        'thickness' => 'nullable|string',
        'color' => 'nullable|string',
        'quantity' => 'nullable|string',
        'item_details' => 'nullable|string'
    ]);

    // --- Handle Category ---
    $category = Category::find($request->category_id);

    if ($request->child_category_name) {
        $category = Category::create([
            'Category_Name' => $request->child_category_name,
            'parent_id'     => $request->category_id,
            'reference_id'  => $request->reference_id ?? null
        ]);
    }

    // --- Handle Item Image ---
    $imagePath = $request->hasFile('image') ? $request->file('image')->store('items', 'public') : null;

    // --- Create Item ---
    $item = Item::create([
        'category_id' => $category->id,
        'title' => $request->title,
        'subtitle' => $request->subtitle,
        'description' => $request->description,
        'item_features' => $request->item_features,
        'collection_date' => $request->collection_date,
        'price' => $request->price,
        'actual_price' => $request->actual_price,
        'discount_percentage' => $request->discount_percentage,
        'stocks' => $request->stocks,
        'image' => $imagePath
    ]);

    // --- Handle Seller ---
    if ($request->seller_id) {
        // Attach existing seller
        $item->sellers()->syncWithoutDetaching([$request->seller_id]);
    } elseif ($request->seller_name_new) {
        // Upload seller gallery
        $sellerGallery = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $galleryImage) {
                $sellerGallery[] = $galleryImage->store('gallery', 'public');
            }
        }

        // Create new seller
        $seller = Seller::create([
            'seller_name' => $request->seller_name_new,
            'seller_email' => $request->seller_email_new,
            'seller_phone' => $request->seller_phone_new,
            'seller_address' => $request->seller_address_new,
            'gallery' => $sellerGallery
        ]);

        // Attach seller to item
        $item->sellers()->attach($seller->id);
    }

    // --- Handle Specifications ---
    if ($request->size || $request->weight || $request->height || $request->width || $request->thickness || $request->color || $request->quantity || $request->item_details) {
        $item->specifications()->create([
            'size' => $request->size,
            'weight' => $request->weight,
            'height' => $request->height,
            'width' => $request->width,
            'thickness' => $request->thickness,
            'color' => $request->color,
            'quantity' => $request->quantity,
            'item_details' => $request->item_details
        ]);
    }

    return redirect()->route('item.index')->with('success', 'Item created successfully!');
}



    public function edit($id)
{
    $item = Item::with(['sellers', 'specifications'])->findOrFail(decrypt($id));
    $categories = Category::with('children')->whereNull('parent_id')->get();
     $sellers = Seller::all(); // fetch all existing sellers
    $seller = $item->sellers->first();

    return view('admin.items.add', compact('item', 'categories', 'sellers', 'seller'));
}

 public function update(Request $request, $id)
{
    // Validate input
    $request->validate([
        'category_id' => 'required|exists:categories,id',
        'title' => 'required|string|max:255',
        'price' => 'nullable|numeric',
        'actual_price' => 'nullable|numeric',
        'discount_percentage' => 'nullable|numeric',
        'stocks' => 'nullable|integer',
        'image' => 'nullable|image|max:2048',
        'gallery.*' => 'nullable|image|max:2048',
        'seller_name_new' => 'nullable|string|max:255',
        'seller_email_new' => 'nullable|email|max:255',
        'seller_phone_new' => 'nullable|string|max:20',
        'seller_address_new' => 'nullable|string|max:255',
    ]);

    // Fetch the item
    $item = Item::with(['sellers', 'specifications'])->findOrFail($id);

    // --- Update main image ---
    if ($request->hasFile('image')) {
        if ($item->image && Storage::disk('public')->exists($item->image)) {
            Storage::disk('public')->delete($item->image);
        }
        $item->image = $request->file('image')->store('items', 'public');
    }

    // --- Update item details ---
    $item->update([
        'category_id' => $request->category_id,
        'reference_id' => $request->reference_id ?? null,
        'title' => $request->title,
        'subtitle' => $request->subtitle,
        'description' => $request->description,
        'item_features' => $request->item_features,
        'collection_date' => $request->collection_date,
        'price' => $request->price,
        'actual_price' => $request->actual_price,
        'discount_percentage' => $request->discount_percentage,
        'stocks' => $request->stocks,
    ]);

    // --- Handle existing seller update ---
    if ($request->seller_id) {
        $seller = Seller::find($request->seller_id);
        if ($seller) {
            $sellerGallery = $seller->gallery ?? [];
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $file) {
                    $sellerGallery[] = $file->store('sellers', 'public');
                }
            }
            $seller->update([
                'seller_name' => $request->seller_name,
                'seller_email' => $request->seller_email,
                'seller_phone' => $request->seller_phone,
                'seller_address' => $request->seller_address,
                'gallery' => $sellerGallery,
            ]);

            // Sync pivot (ensure item-seller relation exists)
            $item->sellers()->syncWithoutDetaching([$seller->id]);
        }
    }

    // --- Handle new seller creation ---
    if ($request->seller_name_new) {
        $sellerGallery = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $sellerGallery[] = $file->store('sellers', 'public');
            }
        }

        $newSeller = Seller::create([
            'seller_name' => $request->seller_name_new,
            'seller_email' => $request->seller_email_new,
            'seller_phone' => $request->seller_phone_new,
            'seller_address' => $request->seller_address_new,
            'gallery' => $sellerGallery,
        ]);

        $item->sellers()->attach($newSeller->id);
    }

    // --- Update specifications ---
    $spec = $item->specifications->first();
    if ($spec) {
        $spec->update([
            'size' => $request->size,
            'weight' => $request->weight,
            'height' => $request->height,
            'width' => $request->width,
            'thickness' => $request->thickness,
            'color' => $request->color,
            'quantity' => $request->quantity,
            'item_details' => $request->item_details,
        ]);
    }

    return redirect()->route('item.index')->with('success', 'Item updated successfully!');
}

   public function view($id)
{
    // Decrypt the ID if you are encrypting URLs
    $itemId = is_numeric($id) ? $id : decrypt($id);

    // Fetch the item with its seller and specification
    $item = Item::with(['sellers', 'specifications', 'category'])->findOrFail($itemId);
        return view('admin.items.view', compact('item'));
    }

    public function destroy($encryptedId)
{
    $id = decrypt($encryptedId); // Decrypt the ID

    $item = Item::with(['contacts', 'opening_Time', 'socialIcons', 'galleries'])->findOrFail($id);

    // Delete main image
    if ($item->image) {
        Storage::disk('public')->delete($item->image);
    }

    // Delete gallery images
    // if ($item->galleries) {
    //     foreach ($item->galleries as $gallery) {
    //         $images = is_array($gallery->gallery) ? $gallery->gallery : json_decode($gallery->gallery, true);
    //         if ($images) {
    //             foreach ($images as $image) {
    //                 Storage::disk('public')->delete($image);
    //             }
    //         }
    //     }
    // }

    // Delete item and its relations
    $item->delete();

    return redirect()->route('item.index')
        ->with('success', 'Item deleted successfully!');
}


   public function deleteSelected(Request $request)
{
    $ids = $request->input('ids');

    if (!empty($ids)) {
        $items = Item::with('galleries')->whereIn('id', $ids)->get();

        foreach ($items as $item) {
            // Delete main image
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }

            // Delete gallery images
            if ($item->galleries) {
                foreach ($item->galleries as $gallery) {
                    $images = is_array($gallery->gallery) ? $gallery->gallery : json_decode($gallery->gallery, true);
                    if ($images) {
                        foreach ($images as $image) {
                            Storage::disk('public')->delete($image);
                        }
                    }
                }
            }
        }

        Item::whereIn('id', $ids)->delete();

        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false], 400);
}

    public function show()
    {
        $user = Auth::user();
        return view('admin.items.profile.profile', compact('user'));
    }

    public function profilesetting()
{
    // Use authenticated user instead of undefined $id
    $user = Auth::user();

    // If you have a permissions table or config
    $permissions = config('role_permissions.permissions'); // or fetch from DB
    $roles = config('role_permissions.roles'); // or fetch from DB
    $userPermissions = $user->permissions ?? [];

    return view('admin.items.profile.settings', compact('user', 'permissions', 'userPermissions'));
}


    public function import(Request $request)
 {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        // Queue the import job
        Excel::queueImport(new ItemsImport, $request->file('file'));

        return redirect()->back()->with('success', 'Excel import has started. Check logs for errors.');
    }
public function home(Request $request)
{
    // Categories
    $categories = Category::all();

    // Deals of the Day
    $dealsOfTheDay = Item::where('discount_percentage', '>', 0)
                          ->latest()
                          ->take(10)
                          ->get();
// Banners by category
    $dealBanners = Banner::where('is_active', true)->where('category', 'deals')->latest()->get();
    $recommendedBanners = Banner::where('is_active', true)->where('category', 'recommended')->latest()->get();
    $latestBanners = Banner::where('is_active', true)->where('category', 'latest')->latest()->get();
    // Featured, Recommended, Latest
    $recommendedItems = Item::inRandomOrder()->take(10)->get();
    $latestItems = Item::latest()->paginate(12);

    // Flash Sale end time
    $flashSaleEnd = now()->endOfDay()->toIso8601String();

    // Pass banners to the view
    return view('home', compact(
        'categories',
        'dealsOfTheDay',
        'recommendedItems',
        'latestItems',
        'flashSaleEnd',
        'dealBanners',
        'recommendedBanners',
        'latestBanners'
    ));
}


public function shopByCategory($id)
{
    $category = Category::findOrFail($id);

    // Get items in this category
    $items = Item::where('category_id', $id)->latest()->get();

    return view('web.partials.shopbyCategory', compact('category', 'items'));
}
public function search(Request $request)
    {
        $query = Item::with('category');

        // Search by title or subtitle
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('subtitle', 'like', '%' . $search . '%');
            });
        }

        // Optional: filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $items = $query->orderBy('id', 'desc')->paginate(12)->withQueryString();

        return view('web.partials.search_results', compact('items'));
    }

public function showItem($id)
{
    // Find the item with its category
    $item = Item::with('category')->findOrFail($id);

    // Get related items from same category
    $relatedItems = Item::where('category_id', $item->category_id)
                        ->where('id', '!=', $item->id)
                        ->take(4)
                        ->get();

    return view('web.partials.show', compact('item', 'relatedItems'));
}

public function ajaxSearch(Request $request)
{
    $query = $request->get('q');

    $items = Item::where('title', 'like', '%' . $query . '%')
                ->orWhere('subtitle', 'like', '%' . $query . '%')
                ->take(5) // limit results
                ->get();

    return response()->json($items);
}

// public function testweb()
// {
//     return view('web.items.index');
// }

}


