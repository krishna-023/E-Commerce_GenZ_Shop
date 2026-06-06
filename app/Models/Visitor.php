<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Visitor extends Model
{
protected $fillable = ['ip','user_agent','browser','platform','device'];

    public function actions()
    {
        return $this->hasMany(VisitorAction::class);
    }
}
