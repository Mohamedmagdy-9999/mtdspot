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

Route::prefix('v-admin')->group(function () {
    
   
    Route::post('admin_login', 'AdminApiController@admin_login');
        Route::middleware(['auth:api_admins', 'api_admins'])->group(function () {
            
                Route::get('setting','AdminApiController@setting');
                Route::post('update_setting/{id}', 'AdminApiController@update_setting');

                Route::get('about_us','AdminApiController@about_us');
                Route::post('update_about_us/{id}', 'AdminApiController@update_about_us');

                Route::get('sliders','AdminApiController@sliders');
                Route::post('add_slider', 'AdminApiController@add_slider');
                Route::get('slider_single/{id}','AdminApiController@slider_single');
                Route::post('update_slider/{id}', 'AdminApiController@update_slider');
                Route::post('delete_slider/{id}', 'AdminApiController@delete_slider');


                Route::get('users','AdminApiController@users');
                Route::post('suspend_user/{id}','AdminApiController@suspend_user');
                Route::post('unsuspend_user/{id}', 'AdminApiController@unsuspend_user');

                Route::get('categories','AdminApiController@categories');
                Route::post('add_category', 'AdminApiController@add_category');
                Route::get('single_category/{id}','AdminApiController@single_category');
                Route::post('update_category/{id}', 'AdminApiController@update_category');
                Route::post('delete_category/{id}', 'AdminApiController@delete_category');


                Route::get('products','AdminApiController@products');
                Route::post('add_product', 'AdminApiController@add_product');
                Route::get('single_product/{id}','AdminApiController@single_product');
                Route::post('update_product/{id}', 'AdminApiController@update_product');
            
        });

});