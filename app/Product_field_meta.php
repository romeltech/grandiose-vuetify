<?php

namespace App;

use App\Product_fields;
use Illuminate\Database\Eloquent\Model;

class Product_field_meta extends Model
{
    protected $guarded = [];

    public function product_fields()
    {
        return $this->belongsTo(Product_fields::class);
    }
    
}
