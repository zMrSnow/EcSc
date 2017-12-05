<?php


use App\Product;

Route::get('/', "ProductController@home")->name("product.home");


// Singet user only
Route::get("/auth/profile", "CustomAuthController@profile")->name("auth.profile");


// register
Route::post('/auth/register', 'CustomAuthController@postRegister')->name('auth.register');
// login
Route::post('/auth/login', 'CustomAuthController@postLogin')->name('auth.login');
// logout
Route::get('/auth/logout', 'CustomAuthController@logOut')->name('auth.logout');
