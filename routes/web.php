<?php


use App\Product;

Route::get('/', "ProductController@getHome")
    ->name("product.home");
Route::post('/add-to-cart/{id}/{size}', "ProductController@postAjaxAddToCart")
    ->name("product.addToCartAjax");
Route::get('/shoping-cart', "ProductController@getShopingCart")
    ->name("product.shopingCart");
Route::get('/shoping-cart/reduce-item/{id}', "ProductController@getReduceByItems")
    ->name("product.reduceByItemCart");

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
            // GET - CustomAuthController
            Route::get("/acp", "CustomAuthController@getAdminControlPanel")
                ->name("auth.adminControlPanel");
            Route::get("/acp/orders", "OrderController@index")
                ->name("auth.adminOrders");
            Route::get("/acp/paydd-orders", "OrderController@showPayd")
                ->name("auth.adminPaydOrders");
            Route::get("/acp/shipping-methods", "ShippingCOntroller@index")
                ->name("admin.shippingMethods");
            Route::get("/acp/products-show", "ProductController@indexACP")
                ->name("auth.adminProoducts");
            Route::get("acp/product/image/{id}", "CustomAuthController@getAdminProductImages")
                ->name("auth.adminProductImage");

            // POST - CustomAuthController
            // delete product based on ID
            Route::post("acp/product/delete/{id}", "ProductController@destroy")
                ->name("auth.deleteAdminProduct");
            // delete order based on ID
            Route::post("acp/order/delete/{id}", "OrderController@destroy")
                ->name("auth.deleteAdminOrder");
            // delete shipping method based on ID
            Route::post("acp/shipping/delete/{id}", "ShippingController@destroy")
                ->name("auth.deleteAdminShipping");
            // Order status change from Ordered -> Payd based on ID
            Route::post("acp/order/status-1/{id}", "OrderController@update")
                ->name("auth.changeOrderToPayd");
            // Order status change from Payd -> Shipped based on ID
            Route::post("acp/order/status-2/{id}", "OrderController@update")
                ->name("auth.changeOrderToShipped");
            // Set IBAN
            Route::post("acp/infos/set-bankNumber/", "CustomAuthController@postAdminSetBankAccountNumber")
                ->name("auth.setBankAccountNumber");
            // Set PayPal
            Route::post("acp/infos/set-paypal-dev/", "PayPalController@setPayPalInfo")
                ->name("auth.setPayPalDev");

            // POST - ProductController
            // Add PRODUCT type / category
            // Required to add Stock
            Route::post("acp/productType/add", "ProductController@postAdminAddProductType")
                ->name("admin.addProductType");
            // Add PRODUCT
            Route::post("acp/product/add", "ProductController@postAdminAddProduct")
                ->name("admin.addProduct");
            // Add PRODUCT Stock
            // Required to list product
            Route::post("acp/product/stock/add", "ProductController@postAdminAddProductStock")
                ->name("admin.addProductStock");
            // Add SHIPPING Option
            // Required to make checkout
            Route::post("acp/shipping/add", "ShippingController@store")
                ->name("admin.addShippingOption");

            // not yet done
            Route::get("/acp/product/edit/{id}", "ProductController@edit")
                ->name("auth.adminEditProduct");
            // not yet done
            Route::post("/acp/product/edit", "CustomAuthController@postAdminEditProduct")
                ->name("auth.postAdminEditProduct");
        });

        // logout
        Route::get('/logout', 'CustomAuthController@logOut')
            ->name('auth.logout');
        // Signed user only
        Route::get("/orders", "OrderController@showLoggedUser")
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



