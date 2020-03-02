<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/**
 * Products
 */
Route::get('/', 'ProductController@index')->name('shop');

/**
 * Payment
 */
Route::get('/checkout', 'ProductController@checkout')->name('checkout');

/**
 * 
 * Customer Routes
 * 
 */
Route::group(['prefix'=>'u','as'=>'u.'], function(){
    // Route::get('/', ['as' => 'index', 'uses' => 'AccountController@index']);
    // Route::get('{user}/profile', 'CustomerController@profile')->middleware('can:accessCustomerOnly,user')->name('profile');
    Route::get('/orders', 'CustomerController@orders')->name('orders');
    Route::get('/profile', 'CustomerController@profile')->name('profile');
    Route::get('/settings', 'CustomerController@settings')->name('settings');
    Route::get('/payment-methods', 'CustomerController@payments')->name('payments');
});


/**
 * 
 * Admin Routes
 * 
 */
Route::group(['prefix'=>'admin','as'=>'admin.'], function(){
    // Users Routes
    // ->middleware('can:accessAdminModel,user')
    Route::get('/users', 'UserController@index')->name('users');
    Route::get('/user/add', 'UserController@create')->name('adduser');
    Route::post('/user/store', 'UserController@store')->name('store');
    Route::get('/users/edit/{user}', 'UserController@edit')->name('edituser');
    Route::delete('/user/destroy/{user}', 'UserController@destroy')->name('user.destroy');

    // Categories
    Route::get('/product/categories', 'CategoryController@index')->name('p.categories');
    Route::post('/product/category/store', 'CategoryController@store')->name('p.addcategory');
    Route::post('/product/category/update', 'CategoryController@update')->name('p.updatecategory');
    Route::delete('/product/category/destroy/{id}', 'CategoryController@destroy')->name('p.destroycategory');

    // Product Category Routes
    // Route::get('/product/categories', 'ProductCategoriesController@index')->name('p.categories');
    // Route::post('/product/category/store', 'ProductCategoriesController@store')->name('p.addcategory');
    // Route::post('/product/category/update', 'ProductCategoriesController@update')->name('p.updatecategory');
    // Route::delete('/product/category/destroy/{id}', 'ProductCategoriesController@destroy')->name('p.destroycategory');

    // Product Category Fields Routes
    Route::get('/product/category/field/{key}', 'ProductCategoryFieldsController@show')->name('p.showcategoryfields');
    Route::post('/product/category/field/store', 'ProductCategoryFieldsController@store')->name('p.addcategoryfields');
    Route::post('/product/category/field/update', 'ProductCategoryFieldsController@update')->name('p.updatecategoryfields');
    Route::delete('/product/category/field/destroy/{id}', 'ProductCategoryFieldsController@destroy')->name('p.destroycategoryfields');
    
    // Product Routes
    Route::get('/products', 'ProductController@adminProductList')->name('p.list');
    Route::post('/product/update', 'ProductController@update')->name('p.update');
    Route::get('/product/{id}', 'ProductController@show')->name('p.show');
    
    // Settings Routes
    Route::get('/settings', 'AdminController@settings')->name('settings');

    // ->middleware('can:accessAdminModel,user')
});
// })->middleware('can:accessAdmin,User::class');
