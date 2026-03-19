<?php

use Illuminate\Support\Facades\Route;
use MTGofa\Paytabs\Facades\Paytabs;
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

Route::get('admin/login', function () {
    return view('admin.login');
})->name('signin');

Auth::routes();





 Route::match(['get','post'],'payment/verify/{payment_ref}', 'HomeController@verify')->name('payment.verify')
 ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

// Route::get('paytabs/create-payment-page', 'HomeController@create_payment_page');
// Route::get('paytabs/query_transactions', 'HomeController@query_transaction')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
// Route::group(['namespace' => 'Auth'], function()
// {
//     Route::get('forget-password', 'ForgotPasswordController@showForgetPasswordForm')->name('forget.password.get');
//     Route::post('forget-password', 'ForgotPasswordController@submitForgetPasswordForm')->name('forget.password.post'); 
//     Route::get('reset-password/{token}', 'ForgotPasswordController@showResetPasswordForm')->name('reset.password.get');
//     Route::post('reset-password', 'ForgotPasswordController@submitResetPasswordForm')->name('reset.password.post');
// });

Route::get('', 'HomeController@index')->name('home');
Route::get('category/{id}', 'HomeController@single_category')->name('single_category');
Route::get('product/{id}', 'HomeController@single_product')->name('single_product');
Route::get('about_us', 'HomeController@about')->name('website_about_us');

Route::get('login', function(){
    return view('website.login');
})->name('login');

Route::get('register', function(){
    return view('website.register');
})->name('register');


Route::post('postLogin', 'HomeController@postLogin')->name('postLogin');
Route::post('create_account', 'HomeController@create_account')->name('create_account');

Route::middleware('auth')->group(function () {

    Route::get('/profile', 'HomeController@profile')->name('profile');

    Route::post('/profile/update', 'HomeController@update_profile')
        ->name('profile.update');

    Route::post('/profile/address/add', 'HomeController@addAddress')
        ->name('profile.address.add');

    Route::post('/profile/address/delete/{id}', 'HomeController@deleteAddress')
        ->name('profile.address.delete');

        Route::get('/cities/{gov_id}', 'HomeController@getCities')
        ->name('profile.getCities');

        Route::post('user_logout', 'HomeController@user_logout')->name('user_logout');

       Route::post('add_to_cart', 'HomeController@addtocart')->name('addtocart');
        Route::get('cart_items', 'HomeController@getCartItems')->name('getCartItems');
        Route::delete('cart_item/remove/{id}', 'HomeController@removeCartItem')->name('removeCartItem');
       Route::get('user_cart', function() {
            return view('website.cart');
        })->name('user_cart');

        Route::get('checkout', function() {
            return view('website.checkout');
        })->name('checkout');

         Route::post('create_order', 'HomeController@create_order')->name('create_order');
         Route::get('coupons', 'HomeController@coupons')->name('coupons');
         Route::post('verify_coupon', 'HomeController@verify_coupon')->name('verify_coupon');
         Route::get('/user/addresses', 'HomeController@user_address')
    ->name('user.addresses');
    Route::post('/user/address/store', 'HomeController@add_address')
    ->name('user.address.store');
    Route::post('toggleFavorite', 'HomeController@toggleFavorite')->name('toggleFavorite');
    Route::get('user_wishlist', function() {
            return view('website.wishlist');
        })->name('user_wishlist');
    Route::get('myFavorites', 'HomeController@myFavorites')->name('myFavorites');
});

Route::post('admin/log', 'HomeController@log')->name('log');
