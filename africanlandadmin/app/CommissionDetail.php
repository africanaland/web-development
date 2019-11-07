<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommissionDetail extends Model
{
    protected $fillable = ['user_id','type','role_id','percent'];
}
