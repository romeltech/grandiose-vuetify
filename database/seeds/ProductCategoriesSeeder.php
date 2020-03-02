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
            'id'                        => 1,
            'product_category_title'    => 'Fresh Food',
            'product_category_slug'     => 'fresh-food',
            'parent'                    => 0
        ]);
        $pc->save();
        $pc = new \App\Product_categories([
            'id'                        => 2,
            'product_category_title'    => 'Drinks Tea and Coffee',
            'product_category_slug'     => 'drinks-tea-and-coffee',
            'parent'                    => 0
        ]);
        $pc->save();
        $pc = new \App\Product_categories([
            'id'                        => 3,
            'product_category_title'    => 'Food Cupboard',
            'product_category_slug'     => 'food-cupboard',
            'parent'                    => 0
        ]);
        $pc->save();
        $pc = new \App\Product_categories([
            'id'                        => 4,
            'product_category_title'    => 'Personal Care',
            'product_category_slug'     => 'personal-care',
            'parent'                    => 0
        ]);
        $pc->save();


        $pc = new \App\Product_categories([
            'id'                        => 5,
            'product_category_title'    => 'Fruits and Vegetables',
            'product_category_slug'     => 'fruits-and-vegetables',
            'parent'                    => 1
        ]);
        $pc->save();
        $pc = new \App\Product_categories([
            'id'                        => 6,
            'product_category_title'    => 'Bakery',
            'product_category_slug'     => 'bakery',
            'parent'                    => 1
        ]);
        $pc->save();
        $pc = new \App\Product_categories([
            'id'                        => 7,
            'product_category_title'    => 'Meat and Poultry',
            'product_category_slug'     => 'meat-and-poultry',
            'parent'                    => 1
        ]);
        $pc->save();
        $pc = new \App\Product_categories([
            'id'                        => 8,
            'product_category_title'    => 'Dairy and Eggs',
            'product_category_slug'     => 'dairy-and-eggs',
            'parent'                    => 1
        ]);
        $pc->save();
        $pc = new \App\Product_categories([
            'id'                        => 9,
            'product_category_title'    => 'Fish and Seafoods',
            'product_category_slug'     => 'fish-and-seafoods',
            'parent'                    => 1
        ]);
        $pc->save();
        $pc = new \App\Product_categories([
            'id'                        => 10,
            'product_category_title'    => 'Chilled Food Counter',
            'product_category_slug'     => 'chilled-food-counter',
            'parent'                    => 1
        ]);
        $pc->save();
        $pc = new \App\Product_categories([
            'id'                        => 11,
            'product_category_title'    => 'Water',
            'product_category_slug'     => 'water',
            'parent'                    => 2
        ]);
        $pc->save();
        $pc = new \App\Product_categories([
            'id'                        => 12,
            'product_category_title'    => 'Soft Drinks',
            'product_category_slug'     => 'soft-drinks',
            'parent'                    => 2
        ]);
        $pc->save();
        $pc = new \App\Product_categories([
            'id'                        => 13,
            'product_category_title'    => 'Tea',
            'product_category_slug'     => 'tea',
            'parent'                    => 2
        ]);
        $pc->save();
        $pc = new \App\Product_categories([
            'id'                        => 14,
            'product_category_title'    => 'Coffee',
            'product_category_slug'     => 'coffee',
            'parent'                    => 2
        ]);
        $pc->save();
        $pc = new \App\Product_categories([
            'id'                        => 15,
            'product_category_title'    => 'Chips Dips and Snacks',
            'product_category_slug'     => 'chips-dips-and-snacks',
            'parent'                    => 3
        ]);
        $pc->save();
        $pc = new \App\Product_categories([
            'id'                        => 16,
            'product_category_title'    => 'Chocolates',
            'product_category_slug'     => 'chocolates',
            'parent'                    => 3
        ]);
        $pc->save();
        $pc = new \App\Product_categories([
            'id'                        => 17,
            'product_category_title'    => 'Dental Care',
            'product_category_slug'     => 'dental-care',
            'parent'                    => 4
        ]);
        $pc->save();
        $pc = new \App\Product_categories([
            'id'                        => 18,
            'product_category_title'    => 'Skin Care',
            'product_category_slug'     => 'skin-care',
            'parent'                    => 4
        ]);
        $pc->save();
        $pc = new \App\Product_categories([
            'id'                        => 19,
            'product_category_title'    => 'Hair Care',
            'product_category_slug'     => 'hair-care',
            'parent'                    => 4
        ]);
        $pc->save();

        $pc = new \App\Product_categories([
            'id'                        => 20,
            'product_category_title'    => 'Shampoo',
            'product_category_slug'     => 'shampoo',
            'parent'                    => 19
        ]);
        $pc->save();
        $pc = new \App\Product_categories([
            'id'                        => 21,
            'product_category_title'    => 'Conditionare',
            'product_category_slug'     => 'conditionare',
            'parent'                    => 19
        ]);
        $pc->save();
    }
}
