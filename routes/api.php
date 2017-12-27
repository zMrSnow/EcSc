<?php

use Illuminate\Http\Request;



Route::get("/products", "api\ProductsController@index")->name("api.products.index");