<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function home() {
        $products = Product::all();
        return view('shop.home', compact("products"));
    }
}
