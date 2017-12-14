<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

class PaypalController extends Controller
{

    public function orderStatus() {
        return 1;
    }

    public function postPaymentWithpaypal(Request $request) {
        $payer = new Payer();
        $payer->setPaymentMethod("credit_cart");

        $itemList = new ItemList();

        // dat do loopu
        $item = new Item();
        $item->setName("name")
            ->setCurrency("EUR")
            ->setQuantity("1")
            ->setPrice("10");
        $itemList->addItem($item);
        // koniec loopu

        $amount = new Amount();
        $amount->setCurrency("EUR")
            ->setTotal("10");

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Nakup na dekoja.sk");

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(route("paypal.orderStatus"))
            ->setCancelUrl(route("auth.orders"));

        $payment = new Payment();
        $payment->setIntent("Sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; **/


    }
}
