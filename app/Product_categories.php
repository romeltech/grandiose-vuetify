<?php

namespace App;

use App\Product;
use App\Product_category_fields;
use Illuminate\Database\Eloquent\Model;

class Product_categories extends Model
{
    protected $guarded = [];

    // Relationship to Products
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relationship to Product Field Meta
    public function product_category_fields()
    {
        return $this->hasMany(Product_category_fields::class);
    }
}
