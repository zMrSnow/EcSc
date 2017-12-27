<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin() {
        try {
            Role::where("user_id", "=", $this->id)->where("role", "=", "333")->firstOrFail();
            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }
}
