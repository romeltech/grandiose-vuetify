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
 * User Pages
 */
Route::group(['prefix'=>'u','as'=>'u.'], function(){
    // Route::get('/', ['as' => 'index', 'uses' => 'AccountController@index']);
    Route::get('{user}/orders', 'UserController@orders')->name('orders');
    Route::get('{user}/profile', 'UserController@profile')->name('profile');
    Route::get('{user}/settings', 'UserController@settings')->name('settings');
    Route::get('{user}/payment-methods', 'UserController@payments')->name('payments');
});