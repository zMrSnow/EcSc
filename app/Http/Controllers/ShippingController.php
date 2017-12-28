<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddShippingOptionRequest;
use App\Models\Shipping;
use App\Repositories\ShippingRepository;

class ShippingController extends Controller
{
    protected $shippingRepository;

    public function __construct(ShippingRepository $shippingRepository)
    {
        $this->shippingRepository = $shippingRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shipping = Shipping::all();
        return view("auth.acp.shippingMethods", compact("shipping"));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddShippingOptionRequest $request)
    {
        return $this->shippingRepository->createShippingMethod($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->shippingRepository->postDeleteShippingMethod($id);
    }
}
