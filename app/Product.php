<?php

namespace App;

use App\Product_fields;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    // protected $fillable = ['imagepath', 'title', 'price', 'description'];
    protected $guarded = [];

    // Relationship to Product Fields 'pf_'
    public function product_fields()
    {
        return $this->hasMany(Product_fields::class);
    }
}

