<?php

namespace App\Repositories;

use App\Models\Info;
use App\Models\Order;
use Auth;
use DB;

class OrderRepository
{
    /*protected $shipping;

    public function __construct(Order $shipping)
    {
        $this->shipping = $shipping;
    }*/


    public function changeOrderStatus($id)
    {
        $order = Order::findOrFail($id);
        if ($order->status == 0) {
            try {
                DB::beginTransaction();

                $order         = Order::findOrFail($id);
                $order->status = 1;
                $order->save();

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
            }
        } else {
            try {
                DB::beginTransaction();

                $order         = Order::findOrFail($id);
                $order->status = 2;
                $order->save();

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
            }
        }
        return redirect()->back()->with("msg", "Status objednávky s číslom #$id bol zmenený.");
    }

    public function deleteOrder($id)
    {
        try {
            DB::beginTransaction();

            $order = Order::findOrFail($id);
            $order->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return redirect()->back()->with("msg", "Obejnávka s číslom #$id bola vymazaný.");
    }

    public function loggedUserOrders()
    {
        $orders = Auth::user()->orders;
        $orders->transform(function ($order, $key) {
            $order->cart = unserialize($order->cart);
            return $order;
        });
        $info = Info::findOrFail(1);
        return view("auth.userOrders", compact("orders", "info"));
    }

    public function showPaydOrders()
    {
        $orders = Order::all()->where("status", "=", "1");
        $orders->transform(function ($order, $key) {
            $order->cart = unserialize($order->cart);
            return $order;
        });
        return view("auth.acp.paydOrders", compact("orders"));
    }
}