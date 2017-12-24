<?php


use App\Product;

Route::get('/', "ProductController@home")->name("product.home");
Route::post('/add-to-cart/{id}/{size}', "ProductController@addToCartAjax")->name("product.addToCartAjax");
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
        Route::group(["middleware" => "admin"], function () {
            Route::get("/acp", "CustomAuthController@adminControlPanel")
                ->name("auth.adminControlPanel");
            Route::get("/acp/orders", "CustomAuthController@adminOrders")
                ->name("auth.adminOrders");
            Route::get("/acp/paydd-orders", "CustomAuthController@adminPaydOrders")
                ->name("auth.adminPaydOrders");
            Route::get("/acp/shipping-methods", "CustomAuthController@shippingMethods")
                ->name("admin.shippingMethods");

            Route::get("/acp/products-show", "CustomAuthController@adminProoducts")
                ->name("auth.adminProoducts");

            // not yet
            Route::get("/acp/product/edit/{id}", "CustomAuthController@adminEditProduct")
                ->name("auth.adminEditProduct");
            Route::post("/acp/product/edit", "CustomAuthController@postAdminEditProduct")
                ->name("auth.postAdminEditProduct");
            Route::post("acp/product/delete/{id}", "CustomAuthController@deleteAdminProduct")
                ->name("auth.deleteAdminProduct");


            Route::post("acp/order/delete/{id}", "CustomAuthController@deleteAdminOrder")
                ->name("auth.deleteAdminOrder");
            Route::post("acp/order/status-1/{id}", "CustomAuthController@changeOrderToPayd")
                ->name("auth.changeOrderToPayd");
            Route::post("acp/order/status-2/{id}", "CustomAuthController@changeOrderToShipped")
                ->name("auth.changeOrderToShipped");

            Route::post("acp/productType/add", "ProductController@addProductType")
                ->name("admin.addProductType");
            Route::post("acp/product/add", "ProductController@addProduct")
                ->name("admin.addProduct");
            Route::post("acp/product/stock/add", "ProductController@addProductStock")
                ->name("admin.addProductStock");




            Route::get("acp/product/image/{id}", "CustomAuthController@adminProductImage")
                ->name("auth.adminProductImage");
        });

        // logout
        Route::get('/logout', 'CustomAuthController@logOut')
            ->name('auth.logout');
        // Signed user only
        Route::get("/orders", "CustomAuthController@orders")
            ->name("auth.orders");

        // PayPal checkout
        Route::get("/orderStatus", "PaypalController@orderStatus")
            ->name("paypal.orderStatus");

        // PayPal payment
        Route::post("/pay/{t_id}", "PaypalController@postPaymentWithpaypal")
            ->name("paypal.pay");

        // checkout

        Route::get('/checkout', "ProductController@checkout")
            ->name("product.checkout");
        Route::post('/checkout', "ProductController@postCheckout")
            ->name("product.postCheckout");
    });
});



