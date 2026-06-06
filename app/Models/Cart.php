<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    use HasFactory;
    protected $fillable = [
        'item_id',
        'customer_id',
        'item_quantity',
        'item_price',
        'item_image',
    ];
 public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }

}
