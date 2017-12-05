<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use Illuminate\Http\Request;
use Session;

class ProductController extends Controller
{

    public function home() {
        $products = Product::all();
        return view('shop.home', compact("products"));
    }

    public function addToCartAjax(Request $request, $id) {
        $product = Product::findOrFail($id);
        $oldCart = Session::has("cart") ? Session::get("cart") : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);

        $request->session()->put("cart", $cart);
    }
}
