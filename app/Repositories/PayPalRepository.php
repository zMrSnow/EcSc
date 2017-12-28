<?php

namespace App\Repositories;

use App\Models\Info;
use App\Models\Order;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;

class PayPalRepository
{
    private $_api_context;

    /**
     * PayPalRepository constructor.
     */
    public function __construct()
    {
        $paypal_conf        = \Config::get("paypal");
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf["client_id"], $paypal_conf["secret"]));
        $this->_api_context->setConfig($paypal_conf["settings"]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function orderStatus()
    {
        //return Session::get("order_id");
        //return Session::get("paypal_payment_id");
        $order = Order::findOrFail(Session::get("order_id"));
        Session::forget("order_id");
        $order->status = 1;
        $order->payment_id = Session::get("paypal_payment_id");
        Session::forget("paypal_payment_id");
        $order->save();

        return redirect(route("auth.orders"))->with("", "Objednávka bola úspešne uhradená, expandovat budeme čo najskor.");
    }

    /**
     * @param $request
     * @param $t_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postPaymentWithpaypal($request, $t_id)
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
                //Session::put('error','Spojene sa prerušilo (dlhá neaktivita).');
                return redirect(route("auth.orders"));
                /** echo "Exception: " . $ex->getMessage() . PHP_EOL; **/
                /** $err_data = json_decode($ex->getData(), true); **/
                /** exit; **/
            } else {
                Session::put('msgDanger','Nastala chyba, opakujte prosim akciu neskôr.');
                //Session::put('error','Nastala chyba, opakujte prosim akciu neskôr.');
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

        /** add payment ID, order ID to session **/
        Session::put('paypal_payment_id', $payment->getId());
        Session::put('order_id', $t_id);
        if(isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }
        \Session::put('error','Unknown error occurred');
        return Redirect::route('auth.orders');

    }

    public function setPayPalInfo($request)
    {
        try {
            DB::beginTransaction();

            $client_id        = Info::where("name", "=", "paypal_client_id")->firstOrFail();
            $client_id->value = $request->input("paypal_id");
            $client_id->save();

            $secret        = Info::where("name", "=", "paypal_secret")->firstOrFail();
            $secret->value = $request->input("paypal_secret");
            $secret->save();

            DB::commit();
        } catch (ModelNotFoundException $e) {
            $client_id        = new Info();
            $client_id->name  = "paypal_client_id";
            $client_id->value = $request->input("paypal_id");
            $client_id->save();

            $secret        = new Info();
            $secret->name  = "paypal_secret";
            $secret->value = $request->input("paypal_secret");
            $secret->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with("msg", "Nastala Chyba!");
        }

        return redirect()->back()->with("msg", "PayPal client id a secret boli zmenené");
    }

}