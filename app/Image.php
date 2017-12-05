<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

    public function product() {
        $this->belongsTo(Product::class);
    }
}
