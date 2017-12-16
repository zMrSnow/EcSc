<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Order;
use App\Product;
use App\Shipping;
use Auth;
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
        if (!Session::has("cart")) {
            return redirect()->back();
        }
        $oldCart = Session::get("cart");
        $cart = new Cart($oldCart);
        $total = $cart->totalPrice;
        $totalWeight = $cart->totalWeight;

        $shippings = Shipping::all()->where("max_weight", ">=", $totalWeight);

        return view("shop.checkout", compact("oldCart", "total", "totalWeight", "shippings"));
    }
    public function postCheckout(Request $request) {
        if (!Session::has("cart")) {
            return redirect()->back();
        }
        $oldCart = Session::get("cart");
        $cart = new Cart($oldCart);

        $order = new Order();
        $order->cart = serialize($cart);
        $order->adress = $request->input("adress");
        $order->city = $request->input("city");
        $order->psc = $request->input("psc");
        $order->name = $request->input("fname") . " " . $request->input("lname");

        $shippingPrice = Shipping::findOrFail($request->input("shipping_type"))->price;

        $order->price = $cart->totalPrice + $shippingPrice;
        $order->weight = $cart->totalWeight;
        $order->shipping_type = $request->input("shipping_type");

        Auth::user()->orders()->save($order);

        Session::forget("cart");
        return redirect()->route("auth.orders")->with("msg", "Úspešne si vytvoril objednávku, o potvrdeni vás budeme informovať.");
    }
}
