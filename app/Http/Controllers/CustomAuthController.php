<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditProductRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\SetBankAccountRequest;
use App\Models\Image;
use App\Models\Product;
use App\Repositories\CustomAuthRepository;
use Auth;

class CustomAuthController extends Controller
{
    protected $customAuthRepository;

    public function __construct(CustomAuthRepository $customAuthRepository)
    {
        return $this->customAuthRepository = $customAuthRepository;
    }

    public function postRegister(RegisterUserRequest $request)
    {
        return $this->customAuthRepository->postRegisterUser($request);
    }

    public function postLogin(LoginUserRequest $request)
    {
        return $this->customAuthRepository->postLogin($request);
    }

    public function logOut()
    {
        Auth::logout();
        return redirect("/")->with("registered", "Práve si sa úspešne odhlásil.");
    }


    public function getAdminControlPanel()
    {
        return $this->customAuthRepository->viewACP();
    }

    public function postAdminEditProduct(EditProductRequest $request, $id)
    {
        return $this->customAuthRepository->postEditProduct($request, $id);
    }


    public function getAdminProductImages($id)
    {
        $images = Image::all()->where("product_id", "=", "$id");

        return $images;
        //return view("acp.images", compact("images"));
    }


    public function postAdminSetBankAccountNumber(SetBankAccountRequest $request)
    {
        return $this->customAuthRepository->setIBAN($request);
    }


}
