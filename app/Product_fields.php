<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class Product_fields extends Model
{
    protected $guarded = [];

    // Relationship to Products
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
