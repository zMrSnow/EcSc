<?php
/**
 * Created by PhpStorm.
 * User: Snezn
 * Date: 5. 12. 2017
 * Time: 15:24
 */

namespace App;


class Cart
{
    public $items; // array contains all products in card
    public $totalQty = 0;
    public $totalPrice = 0;

    public function __construct($oldCart) {
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }

    /**
     * @param $item product object ( Produkt )
     * @param $id product id ( Produkt->id )
     * @param $size  product size number (Sizer) 1-8
     */
    public function add($item, $id, $size) {
        $storedItems = ["qty" => 0, "price" => $item->price, "item" => $item]; // nastavyme default na 0
        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $storedItems = $this->items[$id];
            }
        }
        $storedItems["qty"]++;
        $storedItems["price"] = $item->price * $storedItems["qty"];
        $this->items[$id] = $storedItems;
        $this->totalQty++;
        $this->totalPrice += $item->price;
    }
}