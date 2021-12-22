<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['id','roleName','Permission'];

    public function users() {
        return $this->hasMany('App\User');
    }
}
