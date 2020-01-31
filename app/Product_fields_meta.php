<?php

namespace App;

use App\Product_fields;
use Illuminate\Database\Eloquent\Model;

class Product_fields_meta extends Model
{
    protected $guarded = [];

    // Relationship to Products Fields
    public function product_fields()
    {
        return $this->belongsTo(Product_fields::class);
    }
}
