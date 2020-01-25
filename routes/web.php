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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/**
 * Products
 */
Route::get('/shop', 'ProductController@index')->name('shop');

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

    // Product Routes
    Route::get('/product/fields', 'ProductFieldsController@index')->name('p.fields');
    // Route::get('/product/fields/add', 'ProductFieldsController@create')->name('p.field.add');
    Route::post('/product/fields/store', 'ProductFieldsController@store')->name('p.addfield');

    // Product Fields Routes
    Route::post('/product/fields/update', 'ProductFieldsController@update')->name('p.updatefield');
    

    // Settings Routes
    Route::get('/settings', 'AdminController@settings')->name('settings');

    // ->middleware('can:accessAdminModel,user')
});
// })->middleware('can:accessAdmin,User::class');
