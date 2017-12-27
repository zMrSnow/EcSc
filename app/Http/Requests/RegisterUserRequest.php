<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::check()) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'     => 'required|max:255',
            'email'    => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:4|max:255',
        ];
    }

    public function messages()
    {
        return [
          "name.required" => "Je nutné zadať meno.",
          "name.max" => "Maximalný počet znakov pre meno je 255.",
          "email.required" => "Je nutné zadať email.",
          "email.email" => "Neplatný formát emailu, email musi byt v tvare email@domena.sk",
          "email.max" => "Maximalný počet znakov pre email je 255.",
          "password.required" => "Je nutné zadať heslo.",
          "password.min" => "Minimalny počet znakov pre heslo je aspoň 4.",
          "password.max" => "Maximalný počet znakov pre heslo je 255.",
        ];
    }
}
