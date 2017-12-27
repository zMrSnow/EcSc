<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProductStockRequest;
use App\Http\Requests\AddShippingOptionRequest;
use App\Http\Requests\CheckoutRequest;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\CreateProductTypeRequest;
use App\Repositories\ProductRepository;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getHome()
    {
        $products = $this->productRepository->productsAll();
        return view('shop.home', compact("products"));
    }

    public function postAjaxAddToCart(Request $request, $id, $size)
    {
        $this->productRepository->addToCardAjax($request, $id, $size);

    }

    public function getShopingCart()
    {
        $values =  $this->productRepository->shoppingCart();
        $products   = $values->items;
        $totalPrice = $values->totalPrice;
        $totalQty   = $values->totalQty;
        return view("shop.shopingCart", compact("products", "totalPrice", "totalQty"));

    }

    public function getReduceByOneItem($id) {
        $this->productRepository->reduceByOne($id);
        return redirect()->back()->with("msg","Produkt bol odobraný.");
    }

    public function getReduceByItems($id) {
        $this->productRepository->reduceByItem($id);
        return redirect()->back()->with("msg","Produkt bol úspešne odobraný z vašeho nákupného košíka.");
    }

    public function checkout() {
        $cart = $this->productRepository->checkout();
        $total = $cart->totalPrice;
        $totalWeight = $cart->totalWeight;
        $shippings = $this->productRepository->parcialCheckoutShipping($totalWeight);
        return view("shop.checkout", compact("oldCart", "total", "totalWeight", "shippings"));
    }
    public function postCheckout(CheckoutRequest $request) {
        $this->productRepository->postCheckout($request);
        return redirect()->route("auth.orders")->with("msg", "Úspešne si vytvoril objednávku, o potvrdeni vás budeme informovať.");
    }

    public function postAdminAddProductType(CreateProductTypeRequest $request) {
        $this->productRepository->postCreateProductType($request);
        return redirect()->back()->with("msg","Typ/Veľkosť produktu bol vytvorený.");
    }

    public function postAdminAddProduct(CreateProductRequest $request) {
        $this->productRepository->postCreateProduct($request);
        return redirect()->back()->with("msg","Produkt bol úspešne vytvorený.");
    }

    public function postAdminAddProductStock(AddProductStockRequest $request) {
        $this->productRepository->addProductStock($request);
        return redirect()->back()->with("msg","Bolo pridane množstvo do skladu.");
    }

    public function postAdminAddShippingOption(AddShippingOptionRequest $request) {
        $this->productRepository->postCreateShippingOption($request);
        return redirect()->back()->with("msg","Bola pridaná dalšia možnosť dopravy");
    }
}
