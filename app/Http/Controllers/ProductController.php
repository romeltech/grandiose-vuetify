<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\Product_categories;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Products Web Routes
     */
    public function index()
    {
        // $products = Product::take(10)->get();
        // $products = Product::all();
        return view('shop.index');
    }

    /**
     * Products API Routes
     */
    public function productListAPI()
    {
        $products = Product::paginate(10);
        return $products;
    }

    /**
     * Products API Routes
     */
    public function adminProductList()
    {
        // $products = Product::paginate(10);
        // return $products;
        return view('admin.product.index');
    }

    /**
     * Admin Products API Routes
     */
    public function adminProductListAPI(){
        $products = Product::paginate(10);
        return $products;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::where('slug', '=', $id)->get();
        return view('admin.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $product = Product::find($request->id);
        // $product->update();
        // $category = Category::all();
        $category = Category::find($request->categories);
        // $category = Product_categories::find([1,2]);
        // $product->product_categories()->sync($category);
        $product->categories()->sync($category);
        return response()->json([
            'product' => $product,
            'category' => $category,
            'request_categories' => $request->categories,
            'id' => $product->id,
            'message' => 'Product has been updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * Payment
     */
    public function checkout()
    {
        // return view('shop.checkout', ['products' => $products]);
        return view('shop.checkout');
    }
}
