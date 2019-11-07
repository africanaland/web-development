<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
     protected $fillable = [
        'user_id','property_id','checkin','checkout','daily_rate','services','payment_status','booking_amount','paid_amount','status','payment_method','transaction_id','p_payerID'
    ];

    public function property()
    {
        return $this->hasOne(Property::class, 'id', 'property_id');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    // public function PropertyTitle()
    // {
    //     return $this->hasOne(Property::class, 'name', 'user_id');
    // }

}
