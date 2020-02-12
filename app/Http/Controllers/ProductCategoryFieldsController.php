<?php

namespace App\Http\Controllers;

use App\Product_categories;
use App\Product_category_fields;
use Illuminate\Http\Request;

class ProductCategoryFieldsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('auth')->except(['productCategoriesAPI']);
        // $this->middleware('auth')->only(['index']);
    }
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
        // Create
        $categorie_fields = Product_category_fields::create($this->validateRequest());

        // return request
        return response()->json([
            'slug' => $request->category_field_slug,
            'message' => 'Category field has been added'
          ], 200);
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
        return Product_category_fields::where('product_category_id', '=', $id)->orderBy('id', 'DESC')->paginate(5);
        
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
        $categoryFields = Product_category_fields::where('id', '=', $request->id)->firstOrFail();
        
        // Validate and Update Request
        $categoryFields->update($this->validateRequest());

        // Return Response
        return response()->json([
            'message' => 'Product Category has been updated'
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
        $categoryFields = Product_category_fields::where('id', '=', $id)->firstOrFail();
        $categoryFields->delete();
        return response()->json([
            'requestData' => $categoryFields,
            'message' => 'Category field has been Deleted'
        ], 200);
    }
    
    /**
     * Form Validation
     */
    public function validateRequest()
    {
        return request()->validate([
            'product_category_id' => ['exists:product_categories,id'],
            'category_field_slug' => ['min:3', 'max:50', 'string', 'alpha_dash', 'unique:product_category_fields'],
            'category_field_title' => ['required', 'min:3', 'max:50', 'string']
        ]);

    }
}
