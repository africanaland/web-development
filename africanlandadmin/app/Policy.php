<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Policy extends Authenticatable
{
   
    protected $fillable = [
        'name','details', 'image','status','role_id','user_id','type'
    ];

    public function username()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
   	
}
