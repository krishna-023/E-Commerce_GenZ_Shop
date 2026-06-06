<?php

namespace App\Http\Controllers\Web;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Gallery;
use App\Models\Item;
use App\Models\Opening_Time;
use App\Models\SocialIcon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Banner;
use App\Models\Seller;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use App\Models\Visitor;
use App\Models\VisitorAction;


class UserController extends Controller
{
    // public function index(Request $request)
    // {
    //     $user = Auth::user();
    //     $query = Item::query();

    //     if ($request->filled('category_id')) {
    //         $query->where('category_id', $request->category_id);
    //     }
    //     if ($request->filled('title')) {
    //         $query->where('title', 'like', '%' . $request->title . '%');
    //     }
    //     if ($request->filled('subtitle')) {
    //         $query->where('subtitle', 'like', '%' . $request->subtitle . '%');
    //     }
    //     if ($request->filled('item_featured')) {
    //         $query->where('item_featured', $request->item_featured);
    //     }
    //     if ($request->filled('collection_date')) {
    //         $query->whereDate('collection_date', $request->collection_date);
    //     }

    //     $items = $query->with(['category.parent', 'contacts'])->paginate(10);

    //     $categories = Category::with('children')->whereNull('parent_id')->get();

    //     return view('admin.items.index', compact('user', 'items', 'categories'));
    // }

    public function create()
{
    $categories = Category::with('children')->whereNull('parent_id')->get();
    $sellers = Seller::all(); // fetch all sellers for dropdown
    return view('web.items.webadd', compact('categories', 'sellers'));
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

    return redirect()->route('home')->with('success', 'Item created successfully!');
}



    public function edit($encryptedId)
{
    $id = decrypt($encryptedId);
    $item = Item::with(['contacts', 'opening_Time', 'socialIcons', 'galleries', 'sellers', 'specifications'])->findOrFail($id);
    $categories = Category::with('children')->whereNull('parent_id')->get();
    $sellers = Seller::all(); // fetch all sellers
    return view('admin.items.add', compact('item', 'categories', 'sellers', 'id'));
}


public function update(Request $request, $encryptedId)
{
    $id = decrypt($encryptedId);
    $item = Item::findOrFail($id);

    try {
        // 1️⃣ Validation
        $request->validate([
            'reference_id' => 'nullable|integer',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'item_featured' => 'nullable|string|max:255',
            'collection_date' => 'nullable|date',
            'permalink' => 'nullable|url|max:255',
            'category_id' => 'required|exists:categories,id',
            'category_name' => 'nullable|string|max:255',
            'child_category_name' => 'nullable|string|max:255',

            'author_username' => 'nullable|string|max:255',
            'author_email' => 'nullable|email|max:255',
            'author_first_name' => 'nullable|string|max:255',
            'author_last_name' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255',
            'parent' => 'nullable|string|max:255',
            'parent_slug' => 'nullable|string|max:255',

            'telephone' => 'nullable|string|max:255',
            'phone1' => 'nullable|string|max:255',
            'phone2' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'contactOwnerBtn' => 'sometimes|boolean',
            'web' => 'nullable|url|max:255',
            'webLinkLabel' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'latitude' => 'nullable|string|max:20',
            'longitude' => 'nullable|string|max:20',
            'streetview' => 'nullable|string|max:255',
            'swheading' => 'nullable|string|max:255',
            'swpitch' => 'nullable|string|max:255',
            'swzoom' => 'nullable|string|max:255',

            'displayOpeningHours' => 'sometimes|boolean',
            'openingHoursMonday' => 'nullable|string|max:255',
            'openingHoursTuesday' => 'nullable|string|max:255',
            'openingHoursWednesday' => 'nullable|string|max:255',
            'openingHoursThursday' => 'nullable|string|max:255',
            'openingHoursFriday' => 'nullable|string|max:255',
            'openingHoursSaturday' => 'nullable|string|max:255',
            'openingHoursSunday' => 'nullable|string|max:255',
            'openingHoursNote' => 'nullable|string',

            'displaySocialIcons' => 'sometimes|boolean',
            'socialIconsOpenInNewWindow' => 'sometimes|boolean',
            'socialIcons' => 'nullable|string|max:255',
            'socialIcons_url' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'displayGallery' => 'sometimes|boolean',
            'gallery' => 'nullable|array',
            'gallery.*' => 'nullable|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
        ]);

        // 2️⃣ Handle category selection or creation
        $categoryId = $request->category_id;

        if ($request->filled('category_name')) {
            $category = Category::firstOrCreate(['Category_Name' => $request->category_name]);
            $categoryId = $category->id;
        }

        if ($request->filled('child_category_name')) {
            $childCategory = Category::firstOrCreate([
                'Category_Name' => $request->child_category_name,
                'parent_id' => $categoryId
            ]);
            $categoryId = $childCategory->id;
        }

        // 3️⃣ Handle main image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items/images', 'public');
            $item->image = $imagePath;
        }

        // 4️⃣ Update main item
        $item->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'content' => $request->content,
            'item_featured' => $request->item_featured,
            'collection_date' => $request->collection_date,
            'permalink' => $request->permalink,
            'category_id' => $categoryId,
            'author_username' => $request->author_username,
            'author_email' => $request->author_email,
            'author_first_name' => $request->author_first_name,
            'author_last_name' => $request->author_last_name,
            'slug' => $request->slug,
            'parent' => $request->parent,
            'parent_slug' => $request->parent_slug,
        ]);

        // 5️⃣ Update or create contacts
        $item->contacts()->updateOrCreate(
            ['item_id' => $item->id],
            [
                'telephone' => $request->telephone,
                'phone1' => $request->phone1,
                'phone2' => $request->phone2,
                'email' => $request->email,
                'contactOwnerBtn' => $request->boolean('contactOwnerBtn'),
                'web' => $request->web,
                'webLinkLabel' => $request->webLinkLabel,
                'address' => $request->address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'streetview' => $request->streetview,
                'swheading' => $request->swheading,
                'swpitch' => $request->swpitch,
                'swzoom' => $request->swzoom,
            ]
        );

        // 6️⃣ Update or create opening hours
        $item->opening_Time()->updateOrCreate(
            ['item_id' => $item->id],
            [
                'display_opening_hours' => $request->boolean('displayOpeningHours'),
                'openingHoursMonday' => $request->openingHoursMonday,
                'openingHoursTuesday' => $request->openingHoursTuesday,
                'openingHoursWednesday' => $request->openingHoursWednesday,
                'openingHoursThursday' => $request->openingHoursThursday,
                'openingHoursFriday' => $request->openingHoursFriday,
                'openingHoursSaturday' => $request->openingHoursSaturday,
                'openingHoursSunday' => $request->openingHoursSunday,
                'openingHoursNote' => $request->openingHoursNote,
            ]
        );

        // 7️⃣ Update social icons
        if ($request->filled('socialIcons') && $request->filled('socialIcons_url')) {
            $item->socialIcons()->updateOrCreate(
                ['item_id' => $item->id],
                [
                    'displaySocialIcons' => $request->displaySocialIcons ?? 1,
                    'openInNewWindow' => $request->socialIconsOpenInNewWindow ?? 1,
                    'socialIcons' => $request->socialIcons,
                    'socialIcons_url' => $request->socialIcons_url,
                ]
            );
        }

        // 8️⃣ Update gallery
        if ($request->hasFile('gallery')) {
            $paths = [];
            foreach ($request->file('gallery') as $file) {
                $fileName = Str::slug($request->title) . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('gallery', $fileName, 'public');
                $paths[] = $fileName;
            }

            // Optionally delete existing galleries or keep
            $item->galleries()->create([
                'display_gallery' => $request->boolean('displayGallery', true),
                'gallery' => $paths,
            ]);
        }

        return redirect()->route('home')->with('success', 'Item updated successfully!');

    } catch (\Exception $e) {
        dd($e->getMessage());
        return redirect()->back()->with('danger', 'Error: ' . $e->getMessage());
    }
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
        $user = Auth::user();
        return view('admin.items.profile.settings', compact('user'));
    }

    public function profileupdate(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'username'=>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:users,email,'.$user->id,
            'password'=>'nullable|string|min:8|confirmed',
            'profile_picture'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->username;
        $user->email = $request->email;

        if($request->filled('password')){
            $user->password = bcrypt($request->password);
        }

        if($request->hasFile('profile_picture')){
            if($user->profile_picture){
                Storage::disk('public')->delete($user->profile_picture);
            }
            $user->profile_picture = $request->file('profile_picture')->store('profile_pictures','public');
        }

        //$user->save();
        return redirect()->route('item.profile')->with('status','Profile updated successfully!');
    }
    public function userview($id)
    {
        // Fetch item with sellers and specifications
        $item = Item::with(['sellers', 'specifications'])->findOrFail($id);

        // Return view using web.layouts.master
        return view('web.items.userview', compact('item'));
    }


    public function categoryItems($slug)
{
    $category = \App\Models\Category::where('slug', $slug)->firstOrFail();

    // Get items belonging to this category
    $items = \App\Models\Item::where('category_id', $category->id)
        ->with(['contacts', 'galleries', 'category'])
        ->latest()
        ->paginate(12); // Pagination for modern card layout

    return view('web.category.items', compact('items', 'category'));
}

// Show form
    public function bannercreate()
    {
        return view('web.bannercreate');
    }

    // Store banner
   public function bannerstore(Request $request)
{
    $request->validate([
        'title'     => 'nullable|string|max:255',
        'image'     => 'required|image|max:2048', // 2MB limit
        'link'      => 'nullable|url|max:255',
        'category'  => 'required|string|in:deals,recommended,latest', // restrict allowed categories
    ]);

    $path = $request->file('image')->store('banners', 'public');

    Banner::create([
        'user_id'    => Auth::id(),
        'title'      => $request->title,
        'image'      => $path,
        'link'       => $request->link,
        'category'   => $request->category,   // ✅ new
        'created_by' => Auth::id(),
        'updated_by' => Auth::id(),
    ]);

    return redirect()->route('banners.index')->with('success', '✅ Banner posted successfully!');
}

    // Admin Index: Show all banners (active + inactive)
public function bannerIndex()
{
    $banners = Banner::with(['user', 'creator', 'updater'])
        ->latest()
        ->paginate(10);

    return view('admin.banners.index', compact('banners'));
}

 public function bannerShow($id)
    {
        $banner = Banner::with(['user', 'creator', 'updater'])->findOrFail($id);
        return view('admin.banners.show', compact('banner'));
    }

    // ✅ Edit form
    public function bannerEdit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.edit', compact('banner'));
    }

    // ✅ Update banner
   public function bannerUpdate(Request $request, $id)
{
    $banner = Banner::findOrFail($id);

    $request->validate([
        'title'     => 'nullable|string|max:255',
        'image'     => 'nullable|image|max:2048',
        'link'      => 'nullable|url|max:255',
        'is_active' => 'boolean',
        'category'  => 'required|string|in:deals,recommended,latest', // ✅ validate category
    ]);

    $data = $request->only(['title', 'link', 'is_active', 'category']);
    $data['updated_by'] = Auth::id();

    if ($request->hasFile('image')) {
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }
        $data['image'] = $request->file('image')->store('banners', 'public');
    }

    $banner->update($data);

    return redirect()->route('banners.index')->with('success', '✅ Banner updated successfully!');
}

    // ✅ Delete banner
    public function bannerDestroy($id)
    {
        $banner = Banner::findOrFail($id);

        // Delete image
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return redirect()->route('banners.index')->with('success', '🗑️ Banner deleted successfully!');
    }

    public function userstore(Request $request)
     {
        $visitorId = $request->track['visitor_id'] ?? null;
        $action = $request->track['action'] ?? $request->method().' '.$request->path();
        $url = $request->track['url'] ?? $request->fullUrl();
        $details = $request->track['details'] ?? null;

        VisitorAction::create([
            'visitor_id' => $visitorId,
            'action' => $action,
            'url' => $url,
            'details' => $details ? json_encode($details) : null,
        ]);

        return response()->json(['status' => 'success']);
    }
}
