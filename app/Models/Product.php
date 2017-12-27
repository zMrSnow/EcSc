<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{


    public function images() {
        return $this->hasMany(Image::class);
    }
    public function sizes() {
        return $this->hasMany(Size::class);
    }
}
