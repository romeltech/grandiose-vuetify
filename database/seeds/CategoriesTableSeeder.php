<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pc = new \App\Category([
            'id'       => 1,
            'title'    => 'Fresh Food',
            'slug'     => 'fresh-food',
            'parent'   => 0
        ]);
        $pc->save();
        $pc = new \App\Category([
            'id'       => 2,
            'title'    => 'Drinks Tea and Coffee',
            'slug'     => 'drinks-tea-and-coffee',
            'parent'   => 0
        ]);
        $pc->save();
        $pc = new \App\Category([
            'id'       => 3,
            'title'    => 'Food Cupboard',
            'slug'     => 'food-cupboard',
            'parent'   => 0
        ]);
        $pc->save();
        $pc = new \App\Category([
            'id'       => 4,
            'title'    => 'Personal Care',
            'slug'     => 'personal-care',
            'parent'   => 0
        ]);
        $pc->save();
        $pc = new \App\Category([
            'id'       => 5,
            'title'    => 'Fruits and Vegetables',
            'slug'     => 'fruits-and-vegetables',
            'parent'   => 1
        ]);
        $pc->save();
        $pc = new \App\Category([
            'id'       => 6,
            'title'    => 'Bakery',
            'slug'     => 'bakery',
            'parent'   => 1
        ]);
        $pc->save();
        $pc = new \App\Category([
            'id'       => 7,
            'title'    => 'Meat and Poultry',
            'slug'     => 'meat-and-poultry',
            'parent'   => 1
        ]);
        $pc->save();
        $pc = new \App\Category([
            'id'       => 8,
            'title'    => 'Dairy and Eggs',
            'slug'     => 'dairy-and-eggs',
            'parent'   => 1
        ]);
        $pc->save();
        $pc = new \App\Category([
            'id'       => 9,
            'title'    => 'Fish and Seafoods',
            'slug'     => 'fish-and-seafoods',
            'parent'   => 1
        ]);
        $pc->save();
        $pc = new \App\Category([
            'id'       => 10,
            'title'    => 'Chilled Food Counter',
            'slug'     => 'chilled-food-counter',
            'parent'   => 1
        ]);
        $pc->save();
        $pc = new \App\Category([
            'id'       => 11,
            'title'    => 'Water',
            'slug'     => 'water',
            'parent'   => 2
        ]);
        $pc->save();
        $pc = new \App\Category([
            'id'       => 12,
            'title'    => 'Soft Drinks',
            'slug'     => 'soft-drinks',
            'parent'   => 2
        ]);
        $pc->save();
        $pc = new \App\Category([
            'id'       => 13,
            'title'    => 'Tea',
            'slug'     => 'tea',
            'parent'   => 2
        ]);
        $pc->save();
        $pc = new \App\Category([
            'id'       => 14,
            'title'    => 'Coffee',
            'slug'     => 'coffee',
            'parent'   => 2
        ]);
        $pc->save();
        $pc = new \App\Category([
            'id'       => 15,
            'title'    => 'Chips Dips and Snacks',
            'slug'     => 'chips-dips-and-snacks',
            'parent'   => 3
        ]);
        $pc->save();
        $pc = new \App\Category([
            'id'       => 16,
            'title'    => 'Chocolates',
            'slug'     => 'chocolates',
            'parent'   => 3
        ]);
        $pc->save();
        $pc = new \App\Category([
            'id'       => 17,
            'title'    => 'Dental Care',
            'slug'     => 'dental-care',
            'parent'   => 4
        ]);
        $pc->save();
        $pc = new \App\Category([
            'id'       => 18,
            'title'    => 'Skin Care',
            'slug'     => 'skin-care',
            'parent'   => 4
        ]);
        $pc->save();
        $pc = new \App\Category([
            'id'       => 19,
            'title'    => 'Hair Care',
            'slug'     => 'hair-care',
            'parent'   => 4
        ]);
        $pc->save();

        $pc = new \App\Category([
            'id'       => 20,
            'title'    => 'Shampoo',
            'slug'     => 'shampoo',
            'parent'   => 19
        ]);
        $pc->save();
        $pc = new \App\Category([
            'id'       => 21,
            'title'    => 'Conditionare',
            'slug'     => 'conditionare',
            'parent'   => 19
        ]);
        $pc->save();
    }
}