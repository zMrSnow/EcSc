<?php


use App\Product;

Route::get('/', "ProductController@home")->name("product.home");
Route::get('/add-to-cart/{id}/{size}', "ProductController@addToCartAjax")->name("product.addToCartAjax");
Route::get('/shoping-cart', "ProductController@shopingCart")->name("product.shopingCart");


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

        // PayPal checkout
        Route::get("/orderStatus", "PaypalController@orderStatus")
            ->name("paypal.orderStatus");

        // checkout

        Route::get('/checkout', "ProductController@checkout")
            ->name("product.checkout");
        Route::post('/checkout', "ProductController@postCheckout")
            ->name("product.postCheckout");
    });
});

