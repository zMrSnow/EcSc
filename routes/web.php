<?php


use App\Product;

Route::get('/', "ProductController@home")->name("product.home");
Route::get('/add-to-cart/{id}', "ProductController@addToCartAjax")->name("product.addToCartAjax");
Route::get('/shoping-cart', "ProductController@shopingCart")->name("product.shopingCart");
Route::get('/checkout', "ProductController@checkout")->name("product.checkout");


Route::group(["prefix" => "auth"], function () {
    Route::group(["middleware" => "guest"], function () {
        // register
        Route::post('/register', 'CustomAuthController@postRegister')
            ->name('auth.register');
        // login
        Route::post('/login', 'CustomAuthController@postLogin')
            ->name('auth.login');
    });

    Route::group(["middleware" => "auth"], function () {
        // logout
        Route::get('/logout', 'CustomAuthController@logOut')
            ->name('auth.logout');
        // Signed user only
        Route::get("/profile", "CustomAuthController@profile")
            ->name("auth.profile");
        Route::get("/orders", "CustomAuthController@orders")
            ->name("auth.orders");
    });
});

