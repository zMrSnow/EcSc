<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;

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
        return redirect("/")->with("msg", "Práve si sa úspešne zaregistroval, teraz sa možeš prihlásiť");
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email|max:255',
            'password' => 'required|max:255',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
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
        return view("auth.userOrders");
    }
}
