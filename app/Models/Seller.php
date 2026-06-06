<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;
    protected $fillable = [
        'seller_name',
        'seller_email',
        'seller_phone',
        'seller_address',
        'gallery', // JSON column to store multiple images

    ];

    // Cast JSON column to array
    protected $casts = [
        'gallery' => 'array',
    ];

    // Define the relationship with Category
   public function items()
{
    return $this->belongsToMany(Item::class, 'item_seller', 'seller_id', 'item_id')->withTimestamps();
}


}
