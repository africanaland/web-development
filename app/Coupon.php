<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
     protected $fillable = [
        'name','code','start_date','end_date','is_used','status','discount'
    ];

}
