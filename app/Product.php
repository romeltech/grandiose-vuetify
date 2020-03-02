<?php

namespace App;


use App\Category;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $guarded = [];

    // Relationship to Product Categories
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}

