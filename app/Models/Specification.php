<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_id',
        'size',
        'weight',
        'height',
        'width',
        'thickness',
        'color',
        'quantity',
        'item_details',

    ];
    // Contact.php
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }



}
