<?php

namespace App\Http\Controllers;

use App\User;
use App\Product_categories;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductCategoriesController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('auth')->except(['productCategoriesAPI']);
        // $this->middleware('auth')->only(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $this->authorize('accessAdmin', $user);
        // $productfields = Product_categories::all();
        // dd($productfields);
        // return view('admin.product.field.index', compact('productfields'));
        return view('admin.product.category.index');
    }
    public function productCategoriesAPI()
    {
        $productCategories = Product_categories::all();
        return collect($productCategories);
        
        // return Product_categories::all()->groupBy('parent');
        // $productfields = Product_categories::orderBy('id', 'DESC')->paginate(10);
        // $productfields = Product_categories::orderBy('id', 'DESC')->all();
        // $grouped = [];
        // foreach ($productCategories as $pc) {
        //     if($pc->parent === 0){
        //         return 'meh';
        //     }
        // }
        

        // return collect($productCategories)->groupBy('parent');
        // return collect($productCategories);
        // return $productfields;
        // $productCategories = collect($productCategories);
        // $productCategories = collect($productCategories)->map(function ($item) {
        //     return (object) $item;
        // });

    }    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * Automatic Slug
         */
        
        // // Check Key First
        // $slug = Str::slug($request['product_category_slug'], '-');
        // if( Product_categories::where('product_category_slug', $slug)->exists() ){
        //     return response()->json([
        //         'errorMessage' => 'Product Key already exists!'
        //     ], 403);
        // }
        
        // // validate request
        // $this->validate($request, [
        //     'product_category_slug' => ['required', 'string', 'min:3', 'max:50', 'unique:product_categories'],
        //     'product_category_title' => ['required', 'string', 'max:50', 'unique:product_categories']
        // ]);

        // $pf = Product_categories::create([
        //     'product_category_slug' => $slug,
        //     'product_category_title' => $request['product_category_title']
        // ]);
        /* Automatic Slug */

        $pf = Product_categories::create($this->validateRequest()); // Working

        // return request
        return response()->json([
            'slug' => $request->product_category_slug,
            'message' => 'Product field has been added'
          ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($key)
    // {
    //     return view('admin.product.field.show');
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Check Requested Data if Exist
        // $productField = Product_categories::find($request->id);
        $productField = Product_categories::where('id', '=', $request->id)->firstOrFail();
        
        // Validate and Update Request
        $productField->update($this->validateRequest());

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
        $productfields = Product_categories::where('id', '=', $id)->firstOrFail();
        $productfields->delete();
        return response()->json([
            'requestData' => $productfields,
            'message' => 'Product field has been Deleted'
        ], 200);
    }

    /**
     * Form Validation
     */
    public function validateRequest()
    {
        return request()->validate([
            'product_category_slug' => ['min:3', 'max:50', 'string', 'alpha_dash', 'unique:product_categories'],
            'product_category_title' => ['required', 'min:3', 'max:50', 'string']
        ]);

    }
}
