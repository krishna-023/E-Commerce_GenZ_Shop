<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorAction extends Model
{
    protected $fillable = ['visitor_id','action','url','details'];

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }
}

