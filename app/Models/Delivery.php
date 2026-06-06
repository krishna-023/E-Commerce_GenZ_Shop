<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'order_id',
        'customer_id',
        'delivery_type',
        'delivery_address',
        'delivery_zipcode',
        'delivery_charge',
        'delivery_date',
        'deliveryNote',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }

    // Accessor to get expected delivery date
    public function getExpectedDeliveryAttribute()
    {
        if (!$this->delivery_date) {
            return null;
        }

        $date = Carbon::parse($this->delivery_date);

        if ($this->delivery_type === 'Express') {
            return $date->addDays(2)->format('d M Y');
        } elseif ($this->delivery_type === 'Normal') {
            return $date->addDays(4)->format('d M Y');
        }

        return $date->format('d M Y');
    }
}
