<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'customer_name',
        'customer_phone',
        'delivery_address',
        'delivery_option',
        'delivery_charge',
        'payment_method',
        'order_date',
        'order_status',
        'payment_status',
        'delivery_date',
        'delivery_status',
        'total',
        'seller_id',
    ];

    protected $casts = [
        'order_date' => 'datetime',
                'delivery_date' => 'datetime',
    ];

    // An order has many order items
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    // Link to customer
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    public function seller()
{
    return $this->belongsTo(User::class, 'seller_id');
}
// app/Models/Order.php
public function payments()
{
    return $this->hasMany(Payment::class);
}


}
