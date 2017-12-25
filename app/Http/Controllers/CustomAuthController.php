<?php

namespace App\Http\Controllers;

use App\Image;
use App\Info;
use App\Order;
use App\Product;
use App\Shipping;
use App\Sizer;
use Auth;
use App\User;
use Illuminate\Http\Request;
use Session;

class CustomAuthController extends Controller
{

    /*
     * Custom validation
     * fnction
     */
    public function validation(Request $request)
    {
        return $this->validate($request, [
            'name'     => 'required|max:255',
            'email'    => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:4|max:255',
        ]);
    }

    public function postRegister(Request $request)
    {
        $this->validation($request);
        $request['password'] = bcrypt($request->password);
        $user                = User::create($request->all());
        Auth::login($user);
        if (Session::has("oldUrl")) {
            $oldUrl = Session::get("oldUrl");
            Session::forget("oldUrl");
            return redirect()->to($oldUrl)->with("msg", "Práve si sa úspešne zaregistroval, už si aj prihlásený.");
        }
        return redirect("/")->with("msg", "Práve si sa úspešne zaregistroval, už si aj prihlásený.");
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email|max:255',
            'password' => 'required|max:255',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            if (Session::has("oldUrl")) {
                $oldUrl = Session::get("oldUrl");
                Session::forget("oldUrl");
                return redirect()->to($oldUrl)->with("msg", "Práve si sa úspešne prihlásil.");
            }
            return redirect("/")->with("msg", "Práve si sa úspešne prihlásil.");
        }
        return redirect("/")->with("msgDanger", " Neplatný email alebo heslo.");
    }

    public function logOut()
    {
        Auth::logout();
        return redirect("/")->with("registered", "Práve si sa úspešne odhlásil.");
    }


    public function getAdminControlPanel()
    {

        $products          = Product::all();
        $availble_products = 0;
        foreach ($products as $product) {
            if (count($product->sizes) > 0) {
                $availble_products++;
            }
        }
        $orders           = Order::all();
        $completed_orders = 0;
        $expand_order     = 0;
        $payd_orders      = 0;
        $unpayd_orders    = 0;
        foreach ($orders as $order) {
            switch ($order->status) {
                case 0:
                    $unpayd_orders++;
                    break;
                case 1:
                    $payd_orders++;
                    break;
                case 2:
                    $expand_order++;
                    break;
                case 3:
                    $completed_orders++;
                    break;
            }
        }

        return view("auth.adminControlPanel",
            compact("products",
                "availble_products",
                "orders",
                "unpayd_orders",
                "payd_orders",
                "expand_order",
                "completed_orders"
            ));
    }

    public function orders()
    {
        $orders = Auth::user()->orders;
        $orders->transform(function ($order, $key) {
            $order->cart = unserialize($order->cart);
            return $order;
        });
        $info = Info::findOrFail(1);
        return view("auth.userOrders", compact("orders", "info"));
    }


    public function getAdminOrders() {
        $orders = Order::all();

        return view("auth.acp.orders", compact("orders"));
    }

    public function getAdminPaydOrders() {
        $orders = Order::all()->where("status", "=", "1");
        $orders->transform(function ($order, $key) {
            $order->cart = unserialize($order->cart);
            return $order;
        });
        return view("auth.acp.paydOrders", compact("orders"));
    }

    public function getAdminProoducts() {
        $products = Product::all();
        $sizers = Sizer::all();

        return view("auth.acp.products", compact("products", "sizers"));
    }

    public function getAdminEditProduct($id) {
        $product = Product::findOrFail($id);


        return $product;
    }

    public function postAdminEditProduct(Request $request, $id) {

        $product = Product::findOrFail($id);

        $this->validate($request, [
            "product_name" => "max:60",
            "product_description" => "max:191",
        ]);

        $product->name = $request->input("product_name");
        $product->description = $request->input("product_description");
        $product->weight = $request->input("product_weight");
        $product->price = $request->input("product_price");

        $product->save();

        return redirect(route("auth.adminProoducts"));
    }
    public function postAdminDeleteProduct($id) {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->back()->with("msg","Produkt s číslom #$id - $product->name bol vymazaný.");
    }

    public function getAdminProductImages($id) {
        $images = Image::all()->where("product_id", "=", "$id");

        return $images;
        //return view("acp.images", compact("images"));
    }

    public function postAdminDeleteOrder($id) {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->back()->with("msg","Obejnávka s číslom #$id bola vymazaný.");
    }

    public function postAdminChangeOrderToPayd($id) {
        $order = Order::findOrFail($id);
        $order->status = 1;
        $order->save();

        return redirect()->back()->with("msg","Status objednávky s číslom #$id bol zmeneny na Zaplatené.");
    }

    public function postAdminChangeOrderToShipped($id) {
        $order = Order::findOrFail($id);
        $order->status = 2;
        $order->save();

        return redirect()->back()->with("msg","Status objednávky s číslom #$id bol zmeneny na Odoslané.");
    }

    public function getShippingMethods() {
        $shipping = Shipping::all();

        return view("auth.acp.shippingMethods", compact("shipping"));
    }
    public function  addShippingMethod(Request $request) {

        $shipping = new Shipping();
        $shipping->text = $request->input("text");
        $shipping->max_weight = $request->input("weight");
        $shipping->price = $request->input("price");

        return redirect()->back()->with("msg","Nový sposob dopravy bol úspešne pridaný.");
    }


}
