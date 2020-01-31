<?php

namespace App\Http\Controllers;

use App\User;
use App\Product_fields;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductFieldsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('auth')->except(['productFieldsAPI']);
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
        // $productfields = Product_fields::all();
        // dd($productfields);
        // return view('admin.product.field.index', compact('productfields'));
        return view('admin.product.field.index');
    }
    public function productFieldsAPI()
    {
        // $productfields = Product_fields::all();
        $productfields = Product_fields::orderBy('id', 'DESC')->paginate(10);
        return $productfields;

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
        // $slug = Str::slug($request['pf_key'], '-');
        // if( Product_fields::where('pf_key', $slug)->exists() ){
        //     return response()->json([
        //         'errorMessage' => 'Product Key already exists!'
        //     ], 403);
        // }
        
        // // validate request
        // $this->validate($request, [
        //     'pf_key' => ['required', 'string', 'min:3', 'max:50', 'unique:product_fields'],
        //     'pf_value' => ['required', 'string', 'max:50', 'unique:product_fields']
        // ]);

        // $pf = Product_fields::create([
        //     'pf_key' => $slug,
        //     'pf_value' => $request['pf_value']
        // ]);
        /* Automatic Slug */

        $pf = Product_fields::create($this->validateRequest()); // Working

        // return request
        return response()->json([
            'slug' => $request->pf_key,
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
        // $productField = Product_fields::find($request->id);
        $productField = Product_fields::where('id', '=', $request->id)->firstOrFail();
        
        // Validate and Update Request
        $productField->update($this->validateRequest());

        // Return Response
        return response()->json([
            'message' => 'Product field has been updated'
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
        $productfields = Product_fields::where('id', '=', $id)->firstOrFail();
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
            'pf_key' => ['min:3', 'max:50', 'string', 'alpha_dash', 'unique:product_fields'],
            'pf_value' => ['required', 'min:3', 'max:50', 'string']
        ]);

    }
}
