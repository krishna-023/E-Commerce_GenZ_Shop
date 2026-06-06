<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'gateway',        // e.g., eSewa, Khalti, Stripe
        'transaction_id', // unique transaction reference
        'amount',         // paid amount
        'status',         // pending, paid, failed
        'payload',        // raw API response
    ];

    protected $casts = [
        'payload' => 'array',   // automatically converts JSON to array
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship back to order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Scope for successful payments
    public function scopeSuccessful($query)
    {
        return $query->where('status', 'paid');
    }

    // Scope for failed payments
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }
}
