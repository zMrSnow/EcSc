<?php


use App\Product;

Route::get('/', function () {
    $products = Product::all();
    return view('shop.home', compact("products"));
});
