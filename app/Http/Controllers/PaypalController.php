<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;

class PaypalController extends Controller
{
    private $_api_context;

    public function __construct()
    {

        $paypal_conf        = \Config::get("paypal");
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf["client_id"], $paypal_conf["secret"]));
        $this->_api_context->setConfig($paypal_conf["settings"]);
    }

    public function orderStatus()
    {
        return 1;
    }

    public function postPaymentWithpaypal(Request $request, $t_id)
    {
        $order = Order::findOrFail($t_id);

        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $itemList = new ItemList();

        // dat do loopu nepovinne
        $item = new Item();
        $item->setName("Objednávka číslo : #" . $order->id)
            ->setCurrency("EUR")
            ->setQuantity("1")
            ->setPrice($order->price);
        $itemList->addItem($item);
        // koniec loopu

        $amount = new Amount();
        $amount->setCurrency("EUR")
            ->setTotal($order->price);

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

        /*dd($payment->create($this->_api_context));
        exit;*/

        try {
            $payment->create($this->_api_context);
        } catch (PayPalConnectionException $e) {
            if (\Config::get('app.debug')) {
                Session::put('msgDanger','Spojene sa prerušilo (dlhá neaktivita).');
                Session::put('error','Spojene sa prerušilo (dlhá neaktivita).');
                return redirect(route("auth.orders"));
                /** echo "Exception: " . $ex->getMessage() . PHP_EOL; **/
                /** $err_data = json_decode($ex->getData(), true); **/
                /** exit; **/
            } else {
                Session::put('msgDanger','Nastala chyba, opakujte prosim akciu neskôr.');
                Session::put('error','Nastala chyba, opakujte prosim akciu neskôr.');
                return redirect(route('product.home'));
                /** die('Some error occur, sorry for inconvenient'); **/
            }
        }

        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());
        if(isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }
        \Session::put('error','Unknown error occurred');
        return Redirect::route('auth.orders');


    }
}
