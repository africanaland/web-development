<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
     protected $fillable = [
        'name','membership_id','start_date','end_date','image','is_used','status','description'
    ];

    public function membership()
    {
        return $this->hasOne(Membership::class, 'id', 'membership_id');
    }
}