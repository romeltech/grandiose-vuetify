<?php

namespace App\Http\Controllers;

use App\User;
use App\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['categoriesTreeAPI','categoriesListAPI']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $this->authorize('accessAdmin', $user);
        return view('admin.product.category.index');
    }

    public function categoriesListAPI()
    {
        $productCategories = Category::all();
        return collect($productCategories);
    }  

    public function categoriesTreeAPI()
    {
        $productCategories = Category::all();

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
        $productCategories = Category::create($this->validateRequest()); // Working
        // return request
        return response()->json([
            'message' => 'Product category has been added'
        ], 200);
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
        $productCategories = Category::where('id', '=', $request->id)->firstOrFail();        

        // Validate and Update Request
        $productCategories->update($this->validateRequest());

        // Return Response
        return response()->json([
            'message'   => 'Product Category has been updated',
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
        $parentCheck = Category::where('parent', '=', $id)->doesntExist();
        $responseMsg = '';
        $responseCode = 0;
        if($parentCheck){
            Category::where('id', '=', $id)->firstOrFail()->delete();
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
            'slug' => ['min:1', 'max:50', 'string', 'alpha_dash', 'unique:categories'],
            'title' => ['required', 'min:1', 'max:50', 'string'],
            'parent' => ['required', 'numeric'],
        ]);

    }
}
