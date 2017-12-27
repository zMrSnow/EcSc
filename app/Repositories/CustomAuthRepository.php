<?php

namespace App\Repositories;


use App\Cart;
use App\Models\Image;
use App\Models\Info;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\Size;
use App\Models\Sizer;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Session;

class CustomAuthRepository
{

    public function postRegisterUser($request)
    {
        try {
            DB::beginTransaction();

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

    public function postLogin($request)
    {
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

    public function viewACP()
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

    public function viewOrders()
    {
        $orders = Auth::user()->orders;
        $orders->transform(function ($order, $key) {
            $order->cart = unserialize($order->cart);
            return $order;
        });
        $info = Info::findOrFail(1);
        return view("auth.userOrders", compact("orders", "info"));
    }

    public function viewPaydOrders()
    {
        $orders = Order::all()->where("status", "=", "1");
        $orders->transform(function ($order, $key) {
            $order->cart = unserialize($order->cart);
            return $order;
        });
        return view("auth.acp.paydOrders", compact("orders"));
    }

    public function viewACPProducts()
    {
        $products = Product::all();
        $sizers   = Sizer::all();

        return view("auth.acp.products", compact("products", "sizers"));
    }

    public function postEditProduct($request, $id)
    {
        try {
            DB::beginTransaction();

            $product              = Product::findOrFail($id);
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

    public function postDeleteProduct($id)
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

    public function postDeleteOrder($id)
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

    public function orderToPayd($id)
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

    public function orderToShipped($id)
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

    public function createShippingMethod($request)
    {
        $shipping             = new Shipping();
        $shipping->text       = $request->input("text");
        $shipping->max_weight = $request->input("weight");
        $shipping->price      = $request->input("price");

        return redirect()->back()->with("msg", "Nový sposob dopravy bol úspešne pridaný.");
    }

    public function setIBAN($request)
    {
        try {
            DB::beginTransaction();

            $b_account        = Info::where("name", "=", "bank")->firstOrFail();
            $b_account->value = $request->input("value");
            $b_account->save();

            DB::commit();
        } catch (ModelNotFoundException $e) {
            $b_account        = new Info();
            $b_account->name  = "bank";
            $b_account->value = $request->input("value");
            $b_account->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with("msg", "Nastala Chyba!");
        }

        return redirect()->back()->with("msg", "Číslo účtu bolo úspešne upravené");
    }

    public function setPayPal($request)
    {
        try {
            DB::beginTransaction();

            $client_id        = Info::where("name", "=", "paypal_client_id")->firstOrFail();
            $client_id->value = $request->input("paypal_id");
            $client_id->save();

            $secret        = Info::where("name", "=", "paypal_secret")->firstOrFail();
            $secret->value = $request->input("paypal_secret");
            $secret->save();

            DB::commit();
        } catch (ModelNotFoundException $e) {
            $client_id        = new Info();
            $client_id->name  = "paypal_client_id";
            $client_id->value = $request->input("paypal_id");
            $client_id->save();

            $secret        = new Info();
            $secret->name  = "paypal_secret";
            $secret->value = $request->input("paypal_secret");
            $secret->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with("msg", "Nastala Chyba!");
        }

        return redirect()->back()->with("msg", "PayPal client id a secret boli zmenené");
    }

    public function postDeleteShippingMethod($id)
    {
        try {
            DB::beginTransaction();
            $shipp = Shipping::findOrFail($id);
            $shipp->delete();
            DB::commit();
            return redirect()->back()->with("msg", "Úspešne si vymazal/a typ poštovného");
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->back()->with("msg", "Prístuk k neexistujucému typu poštovného nieje možný");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with("msg", "Nastala chyba skús to neskôr");
        }

    }
}