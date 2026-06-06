<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $fillable = [
        'Category_Name',
        'parent_id',
        'reference_id',
        'slug', // add slug to fillable
    ];

    // Automatically generate slug when setting category name
    public function setCategoryNameAttribute($value)
    {
        $this->attributes['Category_Name'] = $value;
        if (!isset($this->attributes['slug']) || empty($this->attributes['slug'])) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }

    // Direct children
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Recursive children
    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    // Parent category
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Items under this category
    public function items()
    {
        return $this->hasMany(Item::class, 'category_id','id');
    }
}
