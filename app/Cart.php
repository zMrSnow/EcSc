<?php
/**
 * Created by PhpStorm.
 * User: Snezn
 * Date: 5. 12. 2017
 * Time: 15:24
 */

namespace App;


use App\Models\Sizer;

class Cart
{
    public $items; // array contains all products in card
    public $info;
    public $totalQty = 0;
    public $totalPrice = 0;
    public $totalWeight = 0;

    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->items      = $oldCart->items;
            $this->totalQty   = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
            $this->totalWeight = $oldCart->totalWeight;
        }
    }

    /**
     * @param $item product object ( Produkt )
     * @param $id product id ( Produkt->id )
     * @param $size  product size number (Sizer) 1-8
     */
    public function add($item, $id, $size)
    {
        $size = Sizer::findOrFail($size)->name;

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
        $this->totalWeight += $item->weight;
    }

    public function reduceByOne($id) {
        $this->items[$id]["qty"]--;
        $this->items[$id]["price"] -= $this->items[$id]["item"]["price"];
        $this->totalQty--;
        $this->totalPrice -= $this->items[$id]["item"]["price"];
        $this->totalWeight -= $this->items[$id]["item"]["weight"];
        if ($this->items[$id]["qty"] <= 0) {
            unset($this->items[$id]);
        }
    }

    public function reducebyItem($id) {
        $this->totalQty -= $this->items[$id]["qty"];
        $this->totalPrice -= $this->items[$id]["price"];
        unset($this->items[$id]);
    }
}