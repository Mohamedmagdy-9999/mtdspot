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

Route::get('setting','ApiController@setting');
Route::get('categories','ApiController@categories');
Route::get('sliders','ApiController@sliders');
Route::get('products/{id?}','ApiController@products');
Route::post('register','ApiController@register');
Route::post('login','ApiController@login');
Route::post('create_order','ApiController@create_order');
Route::get('coupons','ApiController@coupons');
Route::get('verify_coupon','ApiController@verify_coupon');
Route::post('add_address','ApiController@add_address');
Route::get('user_address','ApiController@user_address');
Route::delete('delete_address/{id}','ApiController@delete_address');

Route::post('edit_profile','ApiController@editProfile');
Route::post('verify','ApiController@verify');
Route::post('toggleFavorite/{productId}','ApiController@toggleFavorite');
Route::get('my_favorites', 'ApiController@myFavorites');

Route::post('add_comment','ApiController@addComment');
Route::get('product_details/{id}', 'ApiController@product_details');

Route::post('add_to_cart', 'ApiController@addtocart');
Route::get('get_cart', 'ApiController@getcart');
Route::post('remove_from_cart', 'ApiController@removefromcart');
Route::get('order_history', 'ApiController@order_history');
Route::get('order_history_details/{id}', 'ApiController@order_history_details');
Route::get('governorates', 'ApiController@governorates');
Route::get('about_us', 'ApiController@about_us');
Route::get('terms', 'ApiController@terms');
Route::get('notifications', 'ApiController@notifications');

Route::post('delete_account/{id}', 'ApiController@delete_account');