<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{

    public function products() {
        return $this->hasMany(Product::class);
    }
    public function sizerName($id) {
        $sizer = Sizer::findOrFail($id);
        return $sizer->name;
    }
    public function sizers() {
        return $this->hasMany(Sizer::class);
    }
}
