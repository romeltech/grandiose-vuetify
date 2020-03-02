<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    // Relationship to Products
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
