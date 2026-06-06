<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
  protected $fillable = [
        'user_id', 'title', 'image', 'link', 'created_by', 'updated_by', 'is_active', 'category',
    ];

    // Relationship with the owner (main user who owns the banner)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with creator
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relationship with updater
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
