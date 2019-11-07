<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class challan extends Model
{
    protected $fillable = ['user_id','totalBooking','mark','start_date','end_date','total','host_cms_amount','host_amount','host_pay_status','creator_id','creator_cms_amount','admin_amount','admin_pay_status'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
