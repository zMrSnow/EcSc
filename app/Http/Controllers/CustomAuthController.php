<?php

namespace App\Http\Controllers;

use App\Image;
use App\Info;
use App\Order;
use App\Product;
use App\Shipping;
use App\Size;
use App\Sizer;
use Auth;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\In;
use Mockery\Exception;
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
        try {
            DB::beginTransaction();

            $this->validation($request);

            $request['password'] = bcrypt($request->password);
            $user                = User::create($request->all());
            Auth::login($user);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect("/")->with("msg", "Nastala chyba skús to nesôr.");
        }

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
        $b_account         = Info::find(1);
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
        $storage          = 0;
        $shipping         = count(Shipping::all());
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
        foreach (Size::all() as $item) {
            $storage += $item->quantities;
        }

        try {
            $client_id = Info::where("name", "=", "paypal_client_id")->firstOrFail();
            $client_id = $client_id->value;
            $secret    = Info::where("name", "=", "paypal_secret")->firstOrFail();
            $secret    = $secret->value;
        } catch (ModelNotFoundException $e) {
            $client_id = "";
            $secret    = "";
        }


        return view("auth.adminControlPanel",
            compact("products",
                "availble_products",
                "orders",
                "unpayd_orders",
                "payd_orders",
                "expand_order",
                "completed_orders",
                "storage",
                "shipping",
                "b_account",
                "client_id",
                "secret"
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


    public function getAdminOrders()
    {
        $orders = Order::all();

        return view("auth.acp.orders", compact("orders"));
    }

    public function getAdminPaydOrders()
    {
        $orders = Order::all()->where("status", "=", "1");
        $orders->transform(function ($order, $key) {
            $order->cart = unserialize($order->cart);
            return $order;
        });
        return view("auth.acp.paydOrders", compact("orders"));
    }

    public function getAdminProoducts()
    {
        $products = Product::all();
        $sizers   = Sizer::all();

        return view("auth.acp.products", compact("products", "sizers"));
    }

    public function getAdminEditProduct($id)
    {
        $product = Product::findOrFail($id);


        return $product;
    }

    public function postAdminEditProduct(Request $request, $id)
    {

        try {
            DB::beginTransaction();

            $product = Product::findOrFail($id);

            $this->validate($request, [
                "product_name"        => "max:60",
                "product_description" => "max:191",
            ]);

            $product->name        = $request->input("product_name");
            $product->description = $request->input("product_description");
            $product->weight      = $request->input("product_weight");
            $product->price       = $request->input("product_price");

            $product->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return redirect(route("auth.adminProoducts"));
    }

    public function postAdminDeleteProduct($id)
    {
        try {
            DB::beginTransaction();
            $product = Product::findOrFail($id);
            $product->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return redirect()->back()->with("msg", "Produkt s číslom #$id - $product->name bol vymazaný.");
    }

    public function getAdminProductImages($id)
    {
        $images = Image::all()->where("product_id", "=", "$id");

        return $images;
        //return view("acp.images", compact("images"));
    }

    public function postAdminDeleteOrder($id)
    {
        try {
            DB::beginTransaction();

            $order = Order::findOrFail($id);
            $order->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return redirect()->back()->with("msg", "Obejnávka s číslom #$id bola vymazaný.");
    }

    public function postAdminChangeOrderToPayd($id)
    {
        try {
            DB::beginTransaction();

            $order         = Order::findOrFail($id);
            $order->status = 1;
            $order->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return redirect()->back()->with("msg", "Status objednávky s číslom #$id bol zmeneny na Zaplatené.");
    }

    public function postAdminChangeOrderToShipped($id)
    {
        try {
            DB::beginTransaction();

            $order         = Order::findOrFail($id);
            $order->status = 2;
            $order->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return redirect()->back()->with("msg", "Status objednávky s číslom #$id bol zmeneny na Odoslané.");
    }

    public function getShippingMethods()
    {
        $shipping = Shipping::all();

        return view("auth.acp.shippingMethods", compact("shipping"));
    }

    public function addShippingMethod(Request $request)
    {

        $shipping             = new Shipping();
        $shipping->text       = $request->input("text");
        $shipping->max_weight = $request->input("weight");
        $shipping->price      = $request->input("price");

        return redirect()->back()->with("msg", "Nový sposob dopravy bol úspešne pridaný.");
    }

    public function postAdminSetBankAccountNumber(Request $request)
    {
        $this->validate($request, [
            "value" => "required|min:24|max:24"
        ]);

        try {
            DB::beginTransaction();

            $b_account        = Info::where("name", "=", "bank")->firstOrFail();
            $b_account->value = $request->input("value");
            $b_account->save();

            DB::commit();
        } catch (ModelNotFoundException $e) {
            $b_account = new Info();
            $b_account->name = "bank";
            $b_account->value = $request->input("value");
            $b_account->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with("msg", "Nastala Chyba!");
        }

        return redirect()->back()->with("msg", "Číslo účtu bolo úspešne upravené");
    }

    public function postAdminSetPayPalDev(Request $request) {
        $this->validate($request, [
            "paypal_id" => "required",
            "paypal_secret" => "required"
        ]);

        try {
            DB::beginTransaction();

            $client_id = Info::where("name", "=", "paypal_client_id")->firstOrFail();
            $client_id->value = $request->input("paypal_id");
            $client_id->save();

            $secret    = Info::where("name", "=", "paypal_secret")->firstOrFail();
            $secret->value    = $request->input("paypal_secret");
            $secret->save();

            DB::commit();
        } catch (ModelNotFoundException $e) {
            $client_id = new Info();
            $client_id->name = "paypal_client_id";
            $client_id->value = $request->input("paypal_id");
            $client_id->save();

            $secret    = new Info();
            $secret->name = "paypal_secret";
            $secret->value    = $request->input("paypal_secret");
            $secret->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with("msg", "Nastala Chyba!");
        }

        return redirect()->back()->with("msg", "PayPal client id a secret boli zmenené");
    }


}
