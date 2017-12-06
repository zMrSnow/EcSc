<?php

namespace App\Http\Controllers;

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
        $user = User::create($request->all());
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


    public function profile() {

        return view("auth.userProfile");
    }
    public function orders() {
        $orders = Auth::user()->orders;
        $orders->transform(function ($order, $key) {
            $order->cart = unserialize($order->cart);
            return $order;
        });
        return view("auth.userOrders", compact("orders"));
    }
}
