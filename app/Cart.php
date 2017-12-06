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
    public $info;
    public $totalQty = 0;
    public $totalPrice = 0;

    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->items      = $oldCart->items;
            $this->totalQty   = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }

    /**
     * @param $item product object ( Produkt )
     * @param $id product id ( Produkt->id )
     * @param $size  product size number (Sizer) 1-8
     */
    public function add($item, $id, $size)
    {
        switch ($size) {
            case 1:
                $size = "XS";
                break;
            case 2:
                $size = "S";
                break;
            case 3:
                $size = "M";
                break;
            case 4:
                $size = "L";
                break;
            case 5:
                $size ="XL";
                break;
            case 6:
                $size ="XXL";
                break;
            default:
                $size = "zlá veľskosť";
        }
        $storedItems = ["qty" => 0, "price" => $item->price, "item" => $item, "info" => $this->info]; // nastavyme default na 0
        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $storedItems = $this->items[$id];
            }
        }
        $storedItems["qty"]++;
        $storedItems["price"] = $item->price * $storedItems["qty"];
        $storedItems["info"]  .= $this->info .= $size . ", ";
        $this->items[$id]     = $storedItems;
        $this->totalQty++;
        $this->totalPrice += $item->price;
    }
}