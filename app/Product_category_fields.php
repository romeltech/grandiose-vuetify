<?php

namespace App;

use App\Product_categories;
use Illuminate\Database\Eloquent\Model;

class Product_category_fields extends Model
{
    protected $guarded = [];
    
    public function product_categories()
    {
        return $this->belongsTo(Product_categories::class);
    }
    
}
