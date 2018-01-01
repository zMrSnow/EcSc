<?php

namespace App\Repositories;

use App\Models\Shipping;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ShippingRepository
{
    /*protected $shipping;

    public function __construct(Shipping $shipping)
    {
        $this->shipping = $shipping;
    }*/

    public function createShippingMethod($request)
    {
        $shipping             = new Shipping();
        $shipping->text       = $request->input("name");
        $shipping->max_weight = $request->input("weight");
        $shipping->price      = $request->input("price");
        $shipping->save();

        return redirect()->back()->with("msg", "Nový sposob dopravy bol úspešne pridaný.");
    }

    public function postDeleteShippingMethod($id)
    {
        try {
            DB::beginTransaction();
            $shipp = Shipping::findOrFail($id);
            $shipp->delete();
            DB::commit();
            return redirect()->back()->with("msg", "Úspešne si vymazal/a typ poštovného");
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->back()->with("msg", "Prístuk k neexistujucému typu poštovného nieje možný");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with("msg", "Nastala chyba skús to neskôr");
        }

    }

}