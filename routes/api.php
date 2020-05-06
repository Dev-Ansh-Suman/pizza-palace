<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/product-list','user\ProductController@index')->name('product_list');//done
Route::get('/order-list','user\OrderController@index')->name('order_list');
Route::get('/order/{token}','user\OrderController@show')->name('order_detail');
Route::get('/refresh-cart','user\ProductController@refreshCart')->name('refresh_cart');
Route::post('/update-cart','user\ProductController@updateCart')->name('update_cart');
Route::post('/store-address','user\OrderController@storeAddress')->name('store_address');
Route::post('/place-order','user\OrderController@placeOrder')->name('place_order');
Route::post('/get-currency','user\ProductController@getCurrency')->name('get_currency');