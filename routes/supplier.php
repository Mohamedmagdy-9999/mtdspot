<?php

    Route::group(['middleware' => 'supplier'], function () {
      Route::group(['middleware' => 'locale'], function () {

            Route::get('switch_language/{locale}', function ($locale) {
                session()->put('locale', $locale);
                \App::setLocale(session()->get('locale'));
                return redirect()->back();
            })->name('switch_language');
           Route::get('dashboard', 'HomeController@supplier_dashbaord')->name('dashboard');
          Route::post('logout', 'HomeController@logout_supplier')->name('logout_supplier');
         Route::get('supplier_order_products', 'SupplierController@supplier_order_products')->name('supplier_order_products');
         Route::put('delivered/{id}', 'SupplierController@delivered')->name('delivered');
       
      });
      
      

    });