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
        $this->middleware('auth')->except(['productCategoriesTreeAPI','productCategoriesListAPI']);
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

    public function productCategoriesListAPI()
    {
        $productCategories = Product_categories::all();

        return collect($productCategories);
    }  

    public function productCategoriesTreeAPI()
    {
        $productCategories = Product_categories::all();

        function recurse_uls($array, $parent)
        {
            $return = array();
            foreach ($array as $c => $p)  {
                if ($p['parent'] != $parent) continue;
                $return[] = $p;
                $data = recurse_uls ($array, $p['id']);
                if($data) {
                    $length = count($return);
                    $return[$length - 1]['children'] = $data;
                }
            }
            return empty($return) ? null : $return;
        }
        
        $data = recurse_uls ($productCategories, 0);

        return $data;
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

        $productCategories = Product_categories::create($this->validateRequest()); // Working

        // return request
        return response()->json([
            // 'slug' => $request->product_category_slug,
            'message' => 'Product category has been added'
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
        $productCategories = Product_categories::where('id', '=', $request->id)->firstOrFail();
        
        $requestChildren = Product_categories::where('parent', '=', $request->id)->get();
        // Validate and Update Request
        $productCategories->update($this->validateRequest());

        // Return Response
        return response()->json([
            'message'   => 'Product Category has been updated',
            'children'  => $requestChildren
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
        $parentCheck = Product_categories::where('parent', '=', $id)->doesntExist();
        $responseMsg = '';
        $responseCode = 0;
        if($parentCheck){
            Product_categories::where('id', '=', $id)->firstOrFail()->delete();
            $responseMsg = 'Product category has been Deleted';
            $responseCode = 200;
        }else{
            $responseMsg = 'Unable to delete category with children associated';
            $responseCode = 422;
        }
        return response()->json([
            'message' => $responseMsg
        ], $responseCode);
    }

    /**
     * Form Validation
     */
    public function validateRequest()
    {
        return request()->validate([
            'product_category_slug' => ['min:1', 'max:50', 'string', 'alpha_dash', 'unique:product_categories'],
            'product_category_title' => ['required', 'min:1', 'max:50', 'string'],
            'parent' => ['required', 'numeric'],
        ]);

    }
}
