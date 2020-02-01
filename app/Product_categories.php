<?php

namespace App;

use App\Product;
use App\Field_metas;
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
    public function field_metas()
    {
        return $this->hasMany(Field_metas::class);
    }
}
