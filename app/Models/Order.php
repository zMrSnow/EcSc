<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ["cart", "adress", "adress", "city", "psc","name", "price" ];

    public function user() {
        $this->belongsTo(User::class);
    }
}
