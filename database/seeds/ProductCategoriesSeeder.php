<?php

use Illuminate\Database\Seeder;

class ProductCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pc = new \App\Product_categories([
            'product_category_title'     => 'Fresh Food',
            'product_category_slug'    => 'fresh-food',
            'product_id'                => 1
        ]);
        $pc->save();
        $pc = new \App\Product_categories([
            'product_category_title'     => 'Drinks Tea and Coffee',
            'product_category_slug'    => 'drinks-tea-and-coffee',
            'product_id'                => 2
        ]);
        $pc->save();
        $pc = new \App\Product_categories([
            'product_category_title'     => 'Food Cupboard',
            'product_category_slug'    => 'food-cupboard',
            'product_id'                => 3
        ]);
        $pc->save();
        $pc = new \App\Product_categories([
            'product_category_title'     => 'Personal Care',
            'product_category_slug'    => 'personal-care',
            'product_id'                => 4
        ]);
        $pc->save();
    }
}
