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
        $products = Product::all();
        try {
            $b_account = Info::where("name", "=", "bank")->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $b_account        = new Info();
            $b_account->name  = "bank";
            $b_account->value = "";
            $b_account->save();
        }

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

}