<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
{

    public function getIbanAttribute()
    {
        $key = $this->value;
        $value = substr($key, 0, 4) . " " . substr($key, 4, 4) . " " . substr($key, 8, 6). " " . substr($key, 14);

        return $value;
    }
}
