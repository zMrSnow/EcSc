<?php

namespace App\Http\Controllers;

use App\Http\Requests\SetPayPalRequest;
use App\Repositories\PayPalRepository;
use Illuminate\Http\Request;

class PaypalController extends Controller
{
    protected $paypalRepository;

    public function __construct(PayPalRepository $payPalRepository)
    {
        $this->paypalRepository = $payPalRepository;
    }

    public function orderStatus()
    {
        return $this->paypalRepository->orderStatus();
    }

    public function postPaymentWithpaypal(Request $request, $t_id)
    {
        return $this->paypalRepository->postPaymentWithpaypal($request, $t_id);
    }

    public function setPayPalInfo(SetPayPalRequest $request)
    {
        return $this->paypalRepository->setPayPalInfo($request);
    }
}
