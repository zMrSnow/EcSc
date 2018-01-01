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

    /**
     * ProductController constructor.
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getHome()
    {
        $products = $this->productRepository->productsAll();
        return view('shop.home', compact("products"));
    }

    public function indexACP()
    {
        return $this->productRepository->indexACP();
    }

    /**
     * @param Request $request
     * @param $id
     * @param $size
     */
    public function postAjaxAddToCart(Request $request, $id, $size)
    {
        $this->productRepository->addToCardAjax($request, $id, $size);

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getShopingCart()
    {
        return $values =  $this->productRepository->shoppingCart();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getReduceByOneItem($id) {
        $this->productRepository->reduceByOne($id);
        return redirect()->back()->with("msg","Produkt bol odobraný.");
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getReduceByItems($id) {
        $this->productRepository->reduceByItem($id);
        return redirect()->back()->with("msg","Produkt bol úspešne odobraný z vašeho nákupného košíka.");
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function checkout() {
       return $this->productRepository->checkout();
    }

    /**
     * @param CheckoutRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCheckout(CheckoutRequest $request) {
        $this->productRepository->postCheckout($request);
        return redirect()->route("auth.orders")->with("msg", "Úspešne si vytvoril objednávku, o potvrdeni vás budeme informovať.");
    }

    /**
     * @param CreateProductTypeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAdminAddProductType(CreateProductTypeRequest $request) {
        $this->productRepository->postCreateProductType($request);
        return redirect()->back()->with("msg","Typ/Veľkosť produktu bol vytvorený.");
    }

    /**
     * @param CreateProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAdminAddProduct(CreateProductRequest $request) {
        $this->productRepository->postCreateProduct($request);
        return redirect()->back()->with("msg","Produkt bol úspešne vytvorený.");
    }

    /**
     * @param AddProductStockRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAdminAddProductStock(AddProductStockRequest $request) {
        $this->productRepository->addProductStock($request);
        return redirect()->back()->with("msg","Bolo pridane množstvo do skladu.");
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        return $this->productRepository->destroy($id);
    }
}
