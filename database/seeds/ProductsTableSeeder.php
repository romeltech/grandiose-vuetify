<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = new \App\Product([
            'imagepath'     => 'img/product/basmati-rice.jpg',
            'title'         => 'Product 1',
            'slug'          => 'product-1',
            'description'   => 'Product 1 description',
            'price'         => 10.00
        ]);
        $product->save();

        $product = new \App\Product([
            'imagepath'     => 'img/product/bread.jpg',
            'title'         => 'Product 2',
            'slug'          => 'product-2',
            'description'   => 'Product 2 description',
            'price'         => 12.00
        ]);
        $product->save();

        $product = new \App\Product([
            'imagepath'     => 'img/product/basmati-rice.jpg',
            'title'         => 'Product 3',
            'slug'          => 'product-3',
            'description'   => 'Product 3 description. This is a very very long description for Product 3. Product 3 description. This is a very very long description for Product 3.',
            'price'         => 100.00
        ]);
        $product->save();

        $product = new \App\Product([
            'imagepath'     => 'img/product/nutella.jpg',
            'title'         => 'Product 4',
            'slug'          => 'product-4',
            'description'   => 'Product 4 description',
            'price'         => 11.00
        ]);
        $product->save();

        $product = new \App\Product([
            'imagepath'     => 'img/product/nutella.jpg',
            'title'         => 'Product 5',
            'slug'          => 'product-5',
            'description'   => 'Product 5 description',
            'price'         => 30.00
        ]);
        $product->save();

        $product = new \App\Product([
            'imagepath'     => 'img/product/basmati-rice.jpg',
            'title'         => 'Product 6',
            'slug'          => 'product-6',
            'description'   => 'Product 6 description',
            'price'         => 10.00
        ]);
        $product->save();

        $product = new \App\Product([
            'imagepath'     => 'img/product/nutella.jpg',
            'title'         => 'Product 7',
            'slug'          => 'product-7',
            'description'   => 'Product 7 description',
            'price'         => 30.00
        ]);
        $product->save();

        $product = new \App\Product([
            'imagepath'     => 'img/product/bread.jpg',
            'title'         => 'Product 8',
            'slug'          => 'product-8',
            'description'   => 'Product 8 description',
            'price'         => 10.00
        ]);
        $product->save();

        $product = new \App\Product([
            'imagepath'     => 'img/product/bread.jpg',
            'title'         => 'Product 9',
            'slug'          => 'product-9',
            'description'   => 'Product 9 description',
            'price'         => 20.00
        ]);
        $product->save();

        $product = new \App\Product([
            'imagepath'     => 'img/product/basmati-rice.jpg',
            'title'         => 'Product 10',
            'slug'          => 'product-10',
            'description'   => 'Product 10 description',
            'price'         => 10.00
        ]);
        $product->save();
        $product = new \App\Product([
            'imagepath'     => 'img/product/basmati-rice.jpg',
            'title'         => 'Product 11',
            'slug'          => 'product-11',
            'description'   => 'Product 11 description',
            'price'         => 10.00
        ]);
        $product->save();

        $product = new \App\Product([
            'imagepath'     => 'img/product/bread.jpg',
            'title'         => 'Product 12',
            'slug'          => 'product-12',
            'description'   => 'Product 12 description',
            'price'         => 12.00
        ]);
        $product->save();

        $product = new \App\Product([
            'imagepath'     => 'img/product/basmati-rice.jpg',
            'title'         => 'Product 13',
            'slug'          => 'product-13',
            'description'   => 'Product 13 description. This is a very very long description for Product 3. Product 3 description. This is a very very long description for Product 3.',
            'price'         => 100.00
        ]);
        $product->save();

        $product = new \App\Product([
            'imagepath'     => 'img/product/nutella.jpg',
            'title'         => 'Product 14',
            'slug'          => 'product-14',
            'description'   => 'Product 14 description',
            'price'         => 11.00
        ]);
        $product->save();

        $product = new \App\Product([
            'imagepath'     => 'img/product/nutella.jpg',
            'title'         => 'Product 15',
            'slug'          => 'product-15',
            'description'   => 'Product 15 description',
            'price'         => 30.00
        ]);
        $product->save();

        $product = new \App\Product([
            'imagepath'     => 'img/product/basmati-rice.jpg',
            'title'         => 'Product 16',
            'slug'          => 'product-16',
            'description'   => 'Product 16 description',
            'price'         => 10.00
        ]);
        $product->save();

        $product = new \App\Product([
            'imagepath'     => 'img/product/nutella.jpg',
            'title'         => 'Product 17',
            'slug'          => 'product-17',
            'description'   => 'Product 17 description',
            'price'         => 30.00
        ]);
        $product->save();

        $product = new \App\Product([
            'imagepath'     => 'img/product/bread.jpg',
            'title'         => 'Product 18',
            'slug'          => 'product-18',
            'description'   => 'Product 18 description',
            'price'         => 10.00
        ]);
        $product->save();

        $product = new \App\Product([
            'imagepath'     => 'img/product/bread.jpg',
            'title'         => 'Product 19',
            'slug'          => 'product-19',
            'description'   => 'Product 19 description',
            'price'         => 20.00
        ]);
        $product->save();

        $product = new \App\Product([
            'imagepath'     => 'img/product/basmati-rice.jpg',
            'title'         => 'Product 20',
            'slug'          => 'product-20',
            'description'   => 'Product 20 description',
            'price'         => 10.00
        ]);
        $product->save();
        $product = new \App\Product([
            'imagepath'     => 'img/product/basmati-rice.jpg',
            'title'         => 'Product 21',
            'slug'          => 'product-21',
            'description'   => 'Product 21 description',
            'price'         => 10.00
        ]);
        $product->save();

        $product = new \App\Product([
            'imagepath'     => 'img/product/bread.jpg',
            'title'         => 'Product 22',
            'slug'          => 'product-22',
            'description'   => 'Product 22 description',
            'price'         => 12.00
        ]);
        $product->save();

        $product = new \App\Product([
            'imagepath'     => 'img/product/basmati-rice.jpg',
            'title'         => 'Product 23',
            'slug'          => 'product-23',
            'description'   => 'Product 23 description. This is a very very long description for Product 3. Product 3 description. This is a very very long description for Product 3.',
            'price'         => 100.00
        ]);
        $product->save();

        $product = new \App\Product([
            'imagepath'     => 'img/product/nutella.jpg',
            'title'         => 'Product 24',
            'slug'          => 'product-24',
            'description'   => 'Product 24 description',
            'price'         => 11.00
        ]);
        $product->save();

        $product = new \App\Product([
            'imagepath'     => 'img/product/nutella.jpg',
            'title'         => 'Product 25',
            'slug'          => 'product-25',
            'description'   => 'Product 25 description',
            'price'         => 30.00
        ]);
        $product->save();

        $product = new \App\Product([
            'imagepath'     => 'img/product/basmati-rice.jpg',
            'title'         => 'Product 26',
            'slug'          => 'product-26',
            'description'   => 'Product 26 description',
            'price'         => 10.00
        ]);
        $product->save();

        $product = new \App\Product([
            'imagepath'     => 'img/product/nutella.jpg',
            'title'         => 'Product 27',
            'slug'          => 'product-27',
            'description'   => 'Product 27 description',
            'price'         => 30.00
        ]);
        $product->save();

        $product = new \App\Product([
            'imagepath'     => 'img/product/bread.jpg',
            'title'         => 'Product 28',
            'slug'          => 'product-28',
            'description'   => 'Product 28 description',
            'price'         => 10.00
        ]);
        $product->save();

        $product = new \App\Product([
            'imagepath'     => 'img/product/bread.jpg',
            'title'         => 'Product 29',
            'slug'          => 'product-29',
            'description'   => 'Product 29 description',
            'price'         => 20.00
        ]);
        $product->save();

        $product = new \App\Product([
            'imagepath'     => 'img/product/basmati-rice.jpg',
            'title'         => 'Product 30',
            'slug'          => 'product-30',
            'description'   => 'Product 30 description',
            'price'         => 10.00
        ]);
        $product->save();
    }
}
