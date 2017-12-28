<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditProductRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\SetBankAccountRequest;
use App\Models\Image;
use App\Repositories\CustomAuthRepository;
use Auth;

class CustomAuthController extends Controller
{
    protected $customAuthRepository;

    /**
     * CustomAuthController constructor.
     * @param CustomAuthRepository $customAuthRepository
     */
    public function __construct(CustomAuthRepository $customAuthRepository)
    {
        return $this->customAuthRepository = $customAuthRepository;
    }

    /**
     * @param RegisterUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRegister(RegisterUserRequest $request)
    {
        return $this->customAuthRepository->postRegisterUser($request);
    }

    /**
     * @param LoginUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin(LoginUserRequest $request)
    {
        return $this->customAuthRepository->postLogin($request);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logOut()
    {
        Auth::logout();
        return redirect("/")->with("registered", "Práve si sa úspešne odhlásil.");
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAdminControlPanel()
    {
        return $this->customAuthRepository->viewACP();
    }

    /**
     * @param EditProductRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postAdminEditProduct(EditProductRequest $request, $id)
    {
        return $this->customAuthRepository->postEditProduct($request, $id);
    }


    /**
     * @param $id
     * @return static
     */
    public function getAdminProductImages($id)
    {
        $images = Image::all()->where("product_id", "=", "$id");

        return $images;
        //return view("acp.images", compact("images"));
    }


    /**
     * @param SetBankAccountRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAdminSetBankAccountNumber(SetBankAccountRequest $request)
    {
        return $this->customAuthRepository->setIBAN($request);
    }


}
