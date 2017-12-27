<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
Use Auth;
class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'address'    => 'required|max:191',
            'city' => 'required|max:30',
            'psc' => 'required|min:4|max:6',
            'fname' => 'required|max:30',
            'lname' => 'required|max:30',
        ];
    }
}
