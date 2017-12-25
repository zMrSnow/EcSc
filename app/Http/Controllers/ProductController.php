<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Image;
use App\Order;
use App\Product;
use App\Shipping;
use App\Size;
use App\Sizer;
use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Mockery\Exception;
use Session;

class ProductController extends Controller
{

    public function getHome()
    {
        $products = Product::all();
        return view('shop.home', compact("products"));
    }

    public function postAjaxAddToCart(Request $request, $id, $size)
    {
        $product = Product::findOrFail($id);
        $oldCart = Session::has("cart") ? Session::get("cart") : null;
        $cart    = new Cart($oldCart);
        $cart->add($product, $product->id, $size);

        $request->session()->put("cart", $cart);
    }



    public function getShopingCart()
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

    public function getReduceByOneItem($id) {
        $oldCart = Session::has("cart") ? Session::get("cart") : null;
        $cart    = new Cart($oldCart);
        $cart->reduceByOne($id);

        Session::put("cart", $cart);
        return redirect()->back()->with("msg","Produkt bol odobraný.");
    }

    public function getReduceByItems($id) {
        $oldCart = Session::has("cart") ? Session::get("cart") : null;
        $cart    = new Cart($oldCart);
        $cart->reducebyItem($id);

        if (count($cart->items) > 0) {
            Session::put("cart", $cart);
        } else {
            Session::forget("cart");
        }

        return redirect()->back()->with("msg","Produkt bol úspešne odobraný z vašeho nákupného košíka.");
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

        $this->validate($request, [
            'address'    => 'required|max:191',
            'city' => 'required|max:30',
            'psc' => 'required|min:4|max:6',
            'fname' => 'required|max:30',
            'lname' => 'required|max:30',
        ]);



        $oldCart = Session::get("cart");
        $cart = new Cart($oldCart);

        $order = new Order();
        $order->cart = serialize($cart);
        $order->adress = $request->input("address");
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

    public function postAdminAddProductType(Request $request) {
        $this->validate($request, [
            "name" => "required|unique:sizers"
        ]);
        $sizer = new Sizer();
        $sizer->name = $request->input("name");
        $sizer->save();
        return redirect()->back()->with("msg","Typ produktu s názvom $sizer->name bol vytvorený.");
    }

    public function postAdminAddProduct(Request $request) {
        $this->validate($request, [
           "name" => "required|max:191",
            "description" => "required",
            "weight" => "required",
            "img" => "required"
        ]);
        $product = new Product();
        $product->name = $request->input("name");
        $product->description = $request->input("description");
        $product->weight = $request->input("weight");
        $product->price = $request->input("price");
        $product->save();

        $image = new Image();
        $image->product_id = $product->id;
        $image->img = $request->input("img");
        $image->save();

        return redirect()->back()->with("msg","Produkt s názvom $product->name bol vytvorený.");
    }

    public function postAdminAddProductStock(Request $request) {
        $this->validate($request, [
            "product" => ""
        ]);

        try {
            $size = Size::where("product_id", "=", $request->input("product"))
                ->where("sizer_id", "=", $request->input("size"))
                ->firstOrFail();

            $size->quantities += $request->input("qty");
        } catch (ModelNotFoundException $e) {
            $size = new Size();
            $size->product_id = $request->input("product");
            $size->sizer_id = $request->input("size");
            $size->quantities = $request->input("qty");
        }

        $size->save();

        return redirect()->back()->with("msg","Bolo pridane množstvo do skladu.");
    }

    public function postAdminAddShippingOption(Request $request) {
        $this->validate($request, [
            "name" => "required",
            "weight" => "required",
            "price" => "required"
        ]);

        $shipping = new Shipping();
        $shipping->text = $request->input("name");
        $shipping->max_weight = $request->input("weight");
        $shipping->price = $request->input("price");
        $shipping->save();

        return redirect()->back()->with("msg","Bola pridaná dalšia možnosť dopravy");
    }
}
