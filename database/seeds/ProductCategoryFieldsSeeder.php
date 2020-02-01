<?php

use Illuminate\Database\Seeder;

class ProductCategoryFieldsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pc = new \App\Product_category_fields([
            'category_field_slug'     => 'Fruits and Vegetables',
            'category_field_title'    => 'fruits-and-vegetables',
            'product_category_id'     => 1
        ]);
        $pc->save();
        $pc = new \App\Product_category_fields([
            'category_field_slug'     => 'Bakery',
            'category_field_title'    => 'bakery',
            'product_category_id'     => 1
        ]);
        $pc->save();
        $pc = new \App\Product_category_fields([
            'category_field_slug'     => 'Meat and Poultry',
            'category_field_title'    => 'meat-and-poultry',
            'product_category_id'     => 1
        ]);
        $pc->save();
        $pc = new \App\Product_category_fields([
            'category_field_slug'     => 'Dairy and Eggs',
            'category_field_title'    => 'dairy-and-eggs',
            'product_category_id'     => 1
        ]);
        $pc->save();
        $pc = new \App\Product_category_fields([
            'category_field_slug'     => 'Fish and Seafoods',
            'category_field_title'    => 'fish-and-seafoods',
            'product_category_id'     => 1
        ]);
        $pc->save();
        $pc = new \App\Product_category_fields([
            'category_field_slug'     => 'Chilled Food Counter',
            'category_field_title'    => 'chilled-food-counter',
            'product_category_id'     => 1
        ]);
        $pc->save();
        $pc = new \App\Product_category_fields([
            'category_field_slug'     => 'Water',
            'category_field_title'    => 'water',
            'product_category_id'     => 2
        ]);
        $pc->save();
        $pc = new \App\Product_category_fields([
            'category_field_slug'     => 'Soft Drinks',
            'category_field_title'    => 'soft-drinks',
            'product_category_id'     => 2
        ]);
        $pc->save();
        $pc = new \App\Product_category_fields([
            'category_field_slug'     => 'Tea',
            'category_field_title'    => 'tea',
            'product_category_id'     => 2
        ]);
        $pc->save();
        $pc = new \App\Product_category_fields([
            'category_field_slug'     => 'Coffee',
            'category_field_title'    => 'coffee',
            'product_category_id'     => 2
        ]);
        $pc->save();
        $pc = new \App\Product_category_fields([
            'category_field_slug'     => 'Chips Dips and Snacks',
            'category_field_title'    => 'chips-dips-and-snacks',
            'product_category_id'     => 3
        ]);
        $pc->save();
        $pc = new \App\Product_category_fields([
            'category_field_slug'     => 'Chocolates',
            'category_field_title'    => 'chocolates',
            'product_category_id'     => 3
        ]);
        $pc->save();
        $pc = new \App\Product_category_fields([
            'category_field_slug'     => 'Dental Care',
            'category_field_title'    => 'dental-care',
            'product_category_id'     => 4
        ]);
        $pc->save();
        $pc = new \App\Product_category_fields([
            'category_field_slug'     => 'Skin Care',
            'category_field_title'    => 'skin-care',
            'product_category_id'     => 4
        ]);
        $pc->save();
        $pc = new \App\Product_category_fields([
            'category_field_slug'     => 'Hair Care',
            'category_field_title'    => 'hair-care',
            'product_category_id'     => 4
        ]);
        $pc->save();
    }
}
