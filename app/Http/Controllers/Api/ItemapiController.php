<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Exports\ItemsExport;
use App\Imports\ItemsImport;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Gallery;
use App\Models\Item;
use App\Models\Opening_Time;
use App\Models\SocialIcon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
// use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class ItemapiController extends Controller
{
    /**
     * Display a listing of items with filters
     */
  public function index(Request $request)
{
    // Start building the query with relationships
    $query = Item::with(['category', 'contacts', 'opening_Time', 'socialIcons', 'galleries']);

    // Apply category filter if provided
    if ($request->has('category_id') && $request->category_id != null) {
        $query->where('category_id', $request->category_id);
    }

    // Apply other filters if you have them
    $this->applyFilters($query, $request);

    // Paginate results
    $perPage = $request->input('per_page', 10);
    $items = $query->paginate($perPage);

    return response()->json([
        'success' => true,
        'data' => $items
    ]);
}

public function categories()
    {
        $categories = Category::all();

        return response()->json([
            'success' => true,
            'data' => $categories,
            'message' => 'Categories retrieved successfully',
        ]);
    }
    /**
     * Store a newly created item
     */
    public function store(Request $request)
    {
    $validator = Validator::make($request->all(), [
        'reference_id' => 'required|integer',
        'title' => 'required|string|max:255',
        'subtitle' => 'nullable|string|max:255',
        'content' => 'nullable|string|max:255',
        'item_featured' => 'nullable|string|max:255',
        'collection_date' => 'nullable|date',
        'permalink' => 'nullable|url|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
        'displayGallery' => 'sometimes|boolean',
        'gallery' => 'nullable|url|max:255',
        'category_id' => 'nullable|integer|exists:categories,id',
        'category_name' => 'nullable|string|max:255',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422);
    }

    // Find or create category
    if ($request->filled('category_id')) {
        $category = Category::find($request->category_id);
    } elseif ($request->filled('category_name')) {
        $category = Category::firstOrCreate(
            ['Category_Name' => $request->category_name],
            ['reference_id' => $request->reference_id]
        );
    } else {
        $category = null;
    }

    $categoryId = $category ? $category->id : null;

    // Store image if exists
    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('images', 'public');
    }

    // Create Item
    $item = Item::create([
        'category_id' => $categoryId,
        'reference_id' => $request->reference_id,
        'title' => $request->title,
        'subtitle' => $request->subtitle,
        'content' => $request->content,
        'item_featured' => $request->item_featured,
        'collection_date' => $request->collection_date,
        'permalink' => $request->permalink,
        'image' => $imagePath,
        'author_username' => $request->author_username,
        'author_email' => $request->author_email,
        'author_first_name' => $request->author_first_name,
        'author_last_name' => $request->author_last_name,
        'slug' => $request->slug,
        'parent' => $request->parent,
        'parent_slug' => $request->parent_slug,
    ]);

    if (!$item) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to create item',
        ], 500);
    }

    // Create related models

    Contact::create([
        'item_id' => $item->id,
        'telephone' => $request->telephone,
        'phone1' => $request->phone1,
        'phone2' => $request->phone2,
        'email' => $request->email,
        'contactOwnerBtn' => $request->contactOwnerBtn,
        'web' => $request->web,
        'webLinkLabel' => $request->webLinkLabel,
        'address' => $request->address,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'streetview' => $request->streetview,
        'swheading' => $request->swheading,
        'swpitch' => $request->swpitch,
        'swzoom' => $request->swzoom,
    ]);

    Opening_Time::create([
        'item_id' => $item->id,
        'displayOpeningHours' => $request->displayOpeningHours,
        'openingHoursMonday' => $request->openingHoursMonday,
        'openingHoursTuesday' => $request->openingHoursTuesday,
        'openingHoursWednesday' => $request->openingHoursWednesday,
        'openingHoursThursday' => $request->openingHoursThursday,
        'openingHoursFriday' => $request->openingHoursFriday,
        'openingHoursSaturday' => $request->openingHoursSaturday,
        'openingHoursSunday' => $request->openingHoursSunday,
        'openingHoursNote' => $request->openingHoursNote,
    ]);

    SocialIcon::create([
        'item_id' => $item->id,
        'displaySocialIcons' => $request->displaySocialIcons,
        'socialIconsOpenInNewWindow' => $request->socialIconsOpenInNewWindow,
        'socialIcons' => $request->socialIcons,
        'socialIcons_url' => $request->socialIcons_url,
    ]);

    Gallery::create([
        'item_id' => $item->id,
        'displayGallery' => $request->displayGallery,
        'gallery' => $request->gallery,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Item added successfully',
        'data' => $item->load('contacts', 'opening_Time', 'socialIcons', 'gallery')
    ]);
}


/**
     * Display the specified item with all related info.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        // Load item with relationships: category, contacts, galleries, opening_time, author (if user), etc.
        $item = Item::with([
            'category',           // Assuming relationship 'category' exists
            'contacts',           // Assuming relationship 'contacts' exists
            'galleries',          // Assuming relationship 'galleries' exists
            'opening_time'        // Assuming relationship 'opening_time' exists
        ])->find($id);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found',
            ], 404);
        }

        // If you want to format or add extra data here, do it before returning

        return response()->json([
            'success' => true,
            'data' => $item,
            'message' => 'Item retrieved successfully',
        ]);
    }
    /**
     * Update the specified item
     */
    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $validator = Validator::make($request->all(), $this->validationRules($item));

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Process category
        $category = $this->processCategory($request);
        $item->category_id = $category->id;

        // Update item
        $item->update($this->getItemData($request));

        // Update or create related records
        $this->updateRelatedRecords($item, $request);

        return response()->json([
            'success' => true,
            'data' => $item->fresh(['category', 'contacts', 'opening_Time', 'socialIcons', 'galleries'])
        ]);
    }

    /**
     * Remove the specified item
     */
    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item deleted successfully'
        ]);
    }

    /**
     * Bulk delete items
     */
    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:items,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        Item::whereIn('id', $request->ids)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Selected items deleted successfully'
        ]);
    }

    /**
     * Import items from Excel
     */

    // Helper methods

    protected function applyFilters($query, $request)
    {
        $filters = [
            'category_id', 'title', 'subtitle', 'item_featured', 'collection_date',
            'author_username', 'author_email', 'author_first_name', 'author_last_name',
            'slug', 'parent', 'parent_slug', 'id'
        ];

        foreach ($filters as $filter) {
            if ($request->filled($filter)) {
                $value = $request->input($filter);
                if (in_array($filter, ['title', 'subtitle', 'author_username', 'author_email',
                    'author_first_name', 'author_last_name', 'slug', 'parent', 'parent_slug'])) {
                    $query->where($filter, 'like', '%' . $value . '%');
                } else {
                    $query->where($filter, $value);
                }
            }
        }

        if ($request->filled('telephone')) {
            $query->whereHas('contacts', function ($q) use ($request) {
                $q->where('telephone', 'like', '%' . $request->telephone . '%');
            });
        }

        if ($request->filled('address')) {
            $query->whereHas('contacts', function ($q) use ($request) {
                $q->where('address', 'like', '%' . $request->address . '%');
            });
        }
    }

    protected function validationRules($item = null)
    {
        return [
            'reference_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string|max:255',
            'item_featured' => 'nullable|string|max:255',
            'collection_date' => 'nullable|date',
            'permalink' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            'displayGallery' => 'sometimes|boolean',
            'gallery' => 'nullable|url|max:255',
        ];
    }

    protected function processCategory($request)
    {
        if ($request->has('category_name')) {
            $category = Category::where('Category_Name', $request->category_name)->first();
        }

        if ($request->has('category_id') && empty($category)) {
            $category = Category::find($request->category_id);
        }

        if (empty($category)) {
            $category = Category::create([
                'Category_Name' => $request->category_name,
                'reference_id' => $request->reference_id,
            ]);
        }

        return $category;
    }

    protected function getItemData($request)
    {
        return [
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'content' => $request->content,
            'item_featured' => $request->item_featured,
            'collection_date' => $request->collection_date,
            'permalink' => $request->permalink,
            'image' => $request->file('image') ? $request->file('image')->store('images', 'public') : null,
            'author_username' => $request->author_username,
            'author_email' => $request->author_email,
            'author_first_name' => $request->author_first_name,
            'author_last_name' => $request->author_last_name,
            'slug' => $request->slug,
            'parent' => $request->parent,
            'parent_slug' => $request->parent_slug,
        ];
    }

    protected function createRelatedRecords($item, $request)
    {
        Contact::create([
            'item_id' => $item->id,
            'telephone' => $request->telephone,
            'phone1' => $request->phone1,
            'phone2' => $request->phone2,
            'email' => $request->email,
            'contactOwnerBtn' => $request->contactOwnerBtn,
            'web' => $request->web,
            'webLinkLabel' => $request->webLinkLabel,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'streetview' => $request->streetview,
            'swheading' => $request->swheading,
            'swpitch' => $request->swpitch,
            'swzoom' => $request->swzoom,
        ]);

        Opening_Time::create([
            'item_id' => $item->id,
            'displayOpeningHours' => $request->displayOpeningHours,
            'openingHoursMonday' => $request->openingHoursMonday,
            'openingHoursTuesday' => $request->openingHoursTuesday,
            'openingHoursWednesday' => $request->openingHoursWednesday,
            'openingHoursThursday' => $request->openingHoursThursday,
            'openingHoursFriday' => $request->openingHoursFriday,
            'openingHoursSaturday' => $request->openingHoursSaturday,
            'openingHoursSunday' => $request->openingHoursSunday,
            'openingHoursNote' => $request->openingHoursNote,
        ]);

        SocialIcon::create([
            'item_id' => $item->id,
            'displaySocialIcons' => $request->displaySocialIcons,
            'socialIconsOpenInNewWindow' => $request->socialIconsOpenInNewWindow,
            'socialIcons' => $request->socialIcons,
            'socialIcons_url' => $request->socialIcons_url,
        ]);

        Gallery::create([
            'item_id' => $item->id,
            'displayGallery' => $request->displayGallery,
            'gallery' => $request->gallery,
        ]);
    }

    protected function updateRelatedRecords($item, $request)
    {
        Contact::updateOrCreate(
            ['item_id' => $item->id],
            [
                'telephone' => $request->telephone,
                'phone1' => $request->phone1,
                'phone2' => $request->phone2,
                'email' => $request->email,
                'contactOwnerBtn' => $request->contactOwnerBtn,
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

        Opening_Time::updateOrCreate(
            ['item_id' => $item->id],
            [
                'displayOpeningHours' => $request->displayOpeningHours,
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

        SocialIcon::updateOrCreate(
            ['item_id' => $item->id],
            [
                'displaySocialIcons' => $request->displaySocialIcons,
                'socialIconsOpenInNewWindow' => $request->socialIconsOpenInNewWindow,
                'socialIcons' => $request->socialIcons,
                'socialIcons_url' => $request->socialIcons_url,
            ]
        );

        Gallery::updateOrCreate(
            ['item_id' => $item->id],
            [
                'displayGallery' => $request->displayGallery,
                'gallery' => $request->gallery,
            ]
        );
    }
    public function getTotalCategories()
    {


        $totalCategories = Category::count();

        return response()->json([
            'success' => true,
            'total_categories' => $totalCategories,
            'message' => 'Total categories retrieved successfully',
        ]);

}
}
