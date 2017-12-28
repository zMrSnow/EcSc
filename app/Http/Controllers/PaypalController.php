<?php

namespace App\Http\Controllers;

use App\Http\Requests\SetPayPalRequest;
use App\Repositories\PayPalRepository;
use Illuminate\Http\Request;

class PaypalController extends Controller
{
    protected $paypalRepository;

    /**
     * PaypalController constructor.
     * @param PayPalRepository $payPalRepository
     */
    public function __construct(PayPalRepository $payPalRepository)
    {
        $this->paypalRepository = $payPalRepository;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function orderStatus()
    {
        return $this->paypalRepository->orderStatus();
    }

    /**
     * @param Request $request
     * @param $t_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postPaymentWithpaypal(Request $request, $t_id)
    {
        return $this->paypalRepository->postPaymentWithpaypal($request, $t_id);
    }

    /**
     * @param SetPayPalRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setPayPalInfo(SetPayPalRequest $request)
    {
        return $this->paypalRepository->setPayPalInfo($request);
    }
}
