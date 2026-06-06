<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
    'category_id', 'title', 'subtitle', 'description', 'item_features',
    'collection_date', 'price', 'image', 'actual_price', 'discount_percentage', 'stocks'
];
    protected $casts = [
    'collection_date' => 'date', // or 'datetime' if you need time
];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function parentCategory()
{
    return $this->belongsTo(Category::class, 'parent', 'id');
}

    public function orders()
    {
        return $this->hasMany(Order::class, 'item_id', 'id');
    }

    public function sellers()
{
    return $this->belongsToMany(Seller::class, 'item_seller', 'item_id', 'seller_id')->withTimestamps();
}

    public function specifications()
    {
        return $this->hasMany(Specification::class, 'item_id', 'id');
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'item_id', 'id');
    }
    public function carts()
    {
        return $this->hasMany(Cart::class, 'item_id', 'id');
    }

    public function getGalleryUrlsAttribute()
{
    return $this->galleries->map(function($g) {
        return asset('storage/gallery/' . $g->gallery);
    });
}

}
