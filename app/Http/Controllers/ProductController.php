<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use Illuminate\Http\Request;
use Session;

class ProductController extends Controller
{

    public function home()
    {
        $products = Product::all();
        return view('shop.home', compact("products"));
    }

    public function addToCartAjax(Request $request, $id, $size)
    {
        $product = Product::findOrFail($id);
        $oldCart = Session::has("cart") ? Session::get("cart") : null;
        $cart    = new Cart($oldCart);
        $cart->add($product, $product->id, $size);

        $request->session()->put("cart", $cart);
    }

    public function shopingCart()
    {
        if (!Session::has("cart")) {
            return view("shop.shopingCart");
        }
        $cart = new Cart(Session::get("cart"));
        $products = $cart->items;
        $totalPrice = $cart->totalPrice;
        $totalQty = $cart->totalQty;
        //return $products;
        return view("shop.shopingCart", compact("products", "totalPrice", "totalQty"));

    }

    public function checkout() {

    }
}
