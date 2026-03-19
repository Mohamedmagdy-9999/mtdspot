<?php

    Route::group(['middleware' => 'admin'], function () {
      Route::group(['middleware' => 'locale'], function () {

            Route::get('switch_language/{locale}', function ($locale) {
                session()->put('locale', $locale);
                \App::setLocale(session()->get('locale'));
                return redirect()->back();
            })->name('switch_language');
           Route::get('dashboard', 'HomeController@dashbaord')->name('dashboard');
          Route::post('logout', 'HomeController@logout_admin')->name('logout_admin');
          Route::resource('slider', 'SliderController');
         
          Route::get('settings', 'SettingController@index')->name('setting');
          Route::put('settings/update/{id}', 'SettingController@update')->name('update_setting');
         Route::resource('supplier', 'SupplierController');
          Route::resource('category', 'CategoryController');
          Route::resource('color', 'ColorController');
          Route::resource('product', 'ProductController');
          Route::resource('order', 'UserPurchaseController');
          Route::resource('coupon', 'CouponController');
          Route::resource('governorate', 'GovernorateController');
          Route::resource('city', 'CityController');
          Route::resource('about', 'AboutController');
          Route::resource('terms', 'TermController');
           Route::resource('notifications', 'NotificationController');

           Route::get('upload_supplier',function(){
            return view('admin.upload_supplier');
           })->name('upload_supplier');

           Route::post('supplier_import_excel' , 'HomeController@supplierImportExcel')->name('supplier_import_excel');
           Route::post('product_import_excel' , 'HomeController@productImportExcel')->name('product_import_excel');
           Route::resource('user', 'UserController');
           Route::put('suspend/{id}', 'UserController@suspend')->name('suspend_user');
          Route::post('start_order/{id}' , 'UserPurchaseController@start_order')->name('start_order');
      });
      
      

    });