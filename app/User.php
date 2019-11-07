<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    const ROLE_ADMIN = 1;
    const ROLE_SUBADMIN = 2;
    const ROLE_AGENT = 3;
    const ROLE_HOST_COMPANY = 4;
    const ROLE_HOST_INDIVIDUAL = 5;
    const ROLE_GUEST = 6;
    const ROLE_HOTEL = 7;

    const PREV_ADMIN = 1;
    const PREV_HOST = 2;
    const PREV_GUEST = 3;



    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'creator_id','role_id','membership_id','fname','lname','username','email_token','email','gender','dob','countryCode','password','mobile','country','city','address','image','paypalSecKey','paypalId','paypalClientId','agreement'
    ];




    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function membership()
    {
        return $this->hasOne(Membership::class, 'id', 'membership_id');
    }

    public static function getUserData($Id = 0, $val = array() )
    {
        $data = User::where('status',1);
        if(!empty($val)){
            $data->select($val);
        }
        if ($Id != 0) {
            $data->where('id', $Id);
            $result = $data->first();
        }
        else
            $result = $data->get();

        if($result)
            return $result;
        else {
            return false;
        }
    }

}
