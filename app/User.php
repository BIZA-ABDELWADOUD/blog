<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'FullName', 'email', 'password','role_id'
    ];

    public function role() {
        return $this->belongsTo('App\Role');
    }

  
}
