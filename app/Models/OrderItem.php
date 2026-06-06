<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',      // FK to orders table
        'item_id',       // FK to items table
        'price',
        'quantity',
    ];

    // Each order item belongs to one order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // Each order item belongs to one product/item
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
