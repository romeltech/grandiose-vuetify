<?php

namespace App\Http\Controllers;

use App\User;
use App\Product_fields;
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('admin.product.field.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate request
        // $this->validate($request, [
        //     'id' => ['required'],
        //     'pf_key' => ['required', 'string', 'max:50', 'unique:product_fields'],
        //     'pf_value' => ['required', 'string', 'max:50', 'unique:product_fields']
        // ]);

        // save request
        // $pf = Product_fields::create([
        //     'pf_key' => $request['pf_key'],
        //     'pf_value' => $request['pf_value']
        // ]);

        $pf = Product_fields::create($this->validateRequest());

        // return request
        return response()->json([
            'productfields' => $pf,
            'message' => 'Product field has been added'
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
        //
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
        // Check Requested Data if Exist
        // $productField = Product_fields::find($request->id);
        $productField = Product_fields::where('id', '=', $request->id)->firstOrFail();
        
        // Validate and Update Request
        $productField->update($this->validateRequest());

        // Return Response
        return response()->json([
            // 'currentKey' => $productField->pf_key,
            // 'requestKey' => $request->pf_key,
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
        //
    }

    /**
     * Form Validation
     */
    public function validateRequest()
    {
        return request()->validate([
            'pf_key' => ['min:3', 'max:50', 'string', 'unique:product_fields'],
            'pf_value' => ['required', 'string', 'max:50']
        ]);

    }
}
