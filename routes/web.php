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
 * Customer Routes
 */
Route::group(['prefix'=>'u','as'=>'u.'], function(){
    // Route::get('/', ['as' => 'index', 'uses' => 'AccountController@index']);
    Route::get('{user}/orders', 'CustomerController@orders')->middleware('can:accessCustomerOnly,user')->name('orders');
    Route::get('{user}/profile', 'CustomerController@profile')->middleware('can:accessCustomerOnly,user')->name('profile');
    Route::get('{user}/settings', 'CustomerController@settings')->middleware('can:accessCustomerOnly,user')->name('settings');
    Route::get('{user}/payment-methods', 'CustomerController@payments')->middleware('can:accessCustomerOnly,user')->name('payments');
});


/**
 * Admin Routes
 */
Route::group(['prefix'=>'admin','as'=>'admin.'], function(){
    Route::get('{user}/users', 'UserController@index')->middleware('can:accessAdminModel,user')->name('users');
    Route::get('{user}/users/add', 'UserController@create')->middleware('can:accessAdminModel,user')->name('adduser');
    Route::get('{user}/settings', 'AdminController@settings')->middleware('can:accessAdminModel,user')->name('settings');
});