<?php

namespace App\Repositories;


use App\Cart;
use App\Models\Image;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\Size;
use App\Models\Sizer;
use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Session;

class ProductRepository
{
    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function productsAll()
    {
        return $this->model::all();
    }

    public function addToCardAjax($request, $id, $size)
    {

        $item    = $this->model::findOrFail($id);
        $oldCart = Session::has("cart") ? Session::get("cart") : null;
        $cart    = new Cart($oldCart);
        $cart->add($item, $item->id, $size);

        $request->session()->put("cart", $cart);
    }

    public function shoppingCart()
    {
        if (!Session::has("cart")) {
            return view("shop.shopingCart");
        }
        return $cart = new Cart(Session::get("cart"));
    }

    public function reduceByOne($id)
    {
        $oldCart = Session::has("cart") ? Session::get("cart") : null;
        $cart    = new Cart($oldCart);
        $cart->reduceByOne($id);

        Session::put("cart", $cart);
    }

    public function reduceByItem($id)
    {
        $oldCart = Session::has("cart") ? Session::get("cart") : null;
        $cart    = new Cart($oldCart);
        $cart->reducebyItem($id);

        if (count($cart->items) > 0) {
            Session::put("cart", $cart);
        } else {
            Session::forget("cart");
        }
    }

    public function checkout()
    {
        if (!Session::has("cart")) {
            return redirect()->back();
        }
        $oldCart = Session::get("cart");
        return $cart = new Cart($oldCart);
    }

    public function parcialCheckoutShipping($totalWeight) {
        return Shipping::all()->where("max_weight", ">=", $totalWeight);
    }

    public function postCheckout($request)
    {
        if (!Session::has("cart")) {
            return redirect()->back();
        }
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
    }

    public function postCreateProductType($request)
    {
        $sizer = new Sizer();
        $sizer->name = $request->input("name");
        $sizer->save();
    }

    public function postCreateProduct($request)
    {
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
    }

    public function addProductStock($request)
    {
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
    }

    public function postCreateShippingOption($request)
    {
        $shipping = new Shipping();
        $shipping->text = $request->input("name");
        $shipping->max_weight = $request->input("weight");
        $shipping->price = $request->input("price");
        $shipping->save();
    }
}