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
            'category_field_title'     => 'Fruits and Vegetables',
            'category_field_slug'    => 'fruits-and-vegetables',
            'product_category_id'     => 1
        ]);
        $pc->save();
        $pc = new \App\Product_category_fields([
            'category_field_title'     => 'Bakery',
            'category_field_slug'    => 'bakery',
            'product_category_id'     => 1
        ]);
        $pc->save();
        $pc = new \App\Product_category_fields([
            'category_field_title'     => 'Meat and Poultry',
            'category_field_slug'    => 'meat-and-poultry',
            'product_category_id'     => 1
        ]);
        $pc->save();
        $pc = new \App\Product_category_fields([
            'category_field_title'     => 'Dairy and Eggs',
            'category_field_slug'    => 'dairy-and-eggs',
            'product_category_id'     => 1
        ]);
        $pc->save();
        $pc = new \App\Product_category_fields([
            'category_field_title'     => 'Fish and Seafoods',
            'category_field_slug'    => 'fish-and-seafoods',
            'product_category_id'     => 1
        ]);
        $pc->save();
        $pc = new \App\Product_category_fields([
            'category_field_title'     => 'Chilled Food Counter',
            'category_field_slug'    => 'chilled-food-counter',
            'product_category_id'     => 1
        ]);
        $pc->save();
        $pc = new \App\Product_category_fields([
            'category_field_title'     => 'Water',
            'category_field_slug'    => 'water',
            'product_category_id'     => 2
        ]);
        $pc->save();
        $pc = new \App\Product_category_fields([
            'category_field_title'     => 'Soft Drinks',
            'category_field_slug'    => 'soft-drinks',
            'product_category_id'     => 2
        ]);
        $pc->save();
        $pc = new \App\Product_category_fields([
            'category_field_title'     => 'Tea',
            'category_field_slug'    => 'tea',
            'product_category_id'     => 2
        ]);
        $pc->save();
        $pc = new \App\Product_category_fields([
            'category_field_title'     => 'Coffee',
            'category_field_slug'    => 'coffee',
            'product_category_id'     => 2
        ]);
        $pc->save();
        $pc = new \App\Product_category_fields([
            'category_field_title'     => 'Chips Dips and Snacks',
            'category_field_slug'    => 'chips-dips-and-snacks',
            'product_category_id'     => 3
        ]);
        $pc->save();
        $pc = new \App\Product_category_fields([
            'category_field_title'     => 'Chocolates',
            'category_field_slug'    => 'chocolates',
            'product_category_id'     => 3
        ]);
        $pc->save();
        $pc = new \App\Product_category_fields([
            'category_field_title'     => 'Dental Care',
            'category_field_slug'    => 'dental-care',
            'product_category_id'     => 4
        ]);
        $pc->save();
        $pc = new \App\Product_category_fields([
            'category_field_title'     => 'Skin Care',
            'category_field_slug'    => 'skin-care',
            'product_category_id'     => 4
        ]);
        $pc->save();
        $pc = new \App\Product_category_fields([
            'category_field_title'     => 'Hair Care',
            'category_field_slug'    => 'hair-care',
            'product_category_id'     => 4
        ]);
        $pc->save();
    }
}
