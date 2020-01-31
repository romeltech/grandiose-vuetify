<?php

namespace App;

use App\Product;
use App\Product_field_meta;
use Illuminate\Database\Eloquent\Model;

class Product_fields extends Model
{
    protected $guarded = [];

    // Relationship to Products
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relationship to Product Field Meta
    public function product_field_meta()
    {
        return $this->hasMany(Product_field_meta::class);
    }
}
