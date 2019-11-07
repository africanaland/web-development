<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\CustomPasswordReset;

class User extends Authenticatable
{
    use Notifiable;

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomPasswordReset($token));
    }



    const ROLE_ADMIN = 1;
    const ROLE_SUBADMIN = 2;
    const ROLE_AGENT = 3;
    const ROLE_HOST_COMPANY = 4;
    const ROLE_HOST_INDIVIDUAL = 5;
    const ROLE_GUEST = 6;
    const ROLE_HOTEL = 7;

    const PREV_ADMIN = 1; // admin,sub admin,Ambassador
    const PREV_HOST = 2;    // host
    const PREV_GUEST = 3;   // guest


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'creator_id','fname','lname', 'email', 'username', 'password','role_id','email_token','membership_id','mobile','country','city','image','status','address','paypalSecKey' ,'paypalClientId' ,'paypalId','agreement'];
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
    public function country_name()
    {
        return $this->hasOne(Country::class, 'id', 'country');
    }
    public function city_name()
    {
        return $this->hasOne(City::class, 'id', 'city');
    }

    public function membership()
    {
        return $this->hasOne(Membership::class, 'id', 'membership_id');
    }


    public static function getUserData($Id = 0, $val = array('*') )
    {
        $data = User::where('status',1)->select($val);
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
