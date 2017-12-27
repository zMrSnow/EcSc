<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditProductRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\SetBankAccountRequest;
use App\Http\Requests\SetPayPalRequest;
use App\Models\Image;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shipping;
use App\Repositories\CustomAuthRepository;
use Auth;
use Illuminate\Http\Request;

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

    public function orders()
    {
        return $this->customAuthRepository->viewOrders();
    }


    public function getAdminOrders()
    {
        $orders = Order::all();
        return view("auth.acp.orders", compact("orders"));
    }

    public function getAdminPaydOrders()
    {
        return $this->customAuthRepository->viewPaydOrders();
    }

    public function getAdminProoducts()
    {
        return $this->customAuthRepository->viewACPProducts();
    }

    public function getAdminEditProduct($id)
    {
        $product = Product::findOrFail($id);
        return $product;
    }

    public function postAdminEditProduct(EditProductRequest $request, $id)
    {
        return $this->customAuthRepository->postEditProduct($request, $id);
    }

    public function postAdminDeleteProduct($id)
    {
        return $this->customAuthRepository->postDeleteProduct($id);
    }

    public function getAdminProductImages($id)
    {
        $images = Image::all()->where("product_id", "=", "$id");

        return $images;
        //return view("acp.images", compact("images"));
    }

    public function postAdminDeleteOrder($id)
    {
        return $this->customAuthRepository->postDeleteOrder($id);
    }

    public function postAdminChangeOrderToPayd($id)
    {
        return $this->customAuthRepository->orderToPayd($id);
    }

    public function postAdminChangeOrderToShipped($id)
    {
        return $this->customAuthRepository->orderToShipped($id);
    }

    public function getShippingMethods()
    {
        $shipping = Shipping::all();
        return view("auth.acp.shippingMethods", compact("shipping"));
    }

    public function addShippingMethod(Request $request)
    {
        return $this->customAuthRepository->createShippingMethod($request);
    }

    public function postAdminSetBankAccountNumber(SetBankAccountRequest $request)
    {
        return $this->customAuthRepository->setIBAN($request);
    }

    public function postAdminSetPayPalDev(SetPayPalRequest $request) {
        return $this->customAuthRepository->setPayPal($request);
    }

    public function postAdminDeleteShippingMethod($id) {
        return $this->postAdminDeleteShippingMethod($id);
    }
}
