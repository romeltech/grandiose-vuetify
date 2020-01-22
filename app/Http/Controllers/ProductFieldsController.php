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
        $productfields = Product_fields::paginate(10);;
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
        $this->validate($request, [
            'pf_key' => ['required', 'string', 'max:50', 'unique:product_fields'],
            'pf_value' => ['required', 'string', 'max:50', 'unique:product_fields']
        ]);

        // save request
        $pf = Product_fields::create([
            'pf_key' => $request['pf_key'],
            'pf_value' => $request['pf_value']
        ]);

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
