<?php

namespace App;


use App\Product_categories;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    // protected $fillable = ['imagepath', 'title', 'price', 'description'];
    protected $guarded = [];

    // Relationship to Product Categories
    public function product_categories()
    {
        return $this->hasMany(Product_categories::class);
    }
}

