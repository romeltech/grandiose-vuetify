<?php

namespace App\Http\Controllers;

use App\Product_categories;
use App\Product_category_fields;
use Illuminate\Http\Request;

class ProductCategoryFieldsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $productfield = Product_categories::find($id);
        $productCategory = Product_categories::where('product_category_slug', '=', $id)->get();
        // dd($id);
        // dd($categoryFields[0]->id);
        // dd($productfield->field_metas->field_meta_value);
        return view('admin.product.category.field.show', compact('productCategory'));
    }
    public function categoryFieldsAPI($id)
    {
        return Product_category_fields::where('product_category_id', '=', $id)->orderBy('id', 'DESC')->paginate(3);
        
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
    public function update(Request $request, $id)
    {
        //
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
}
