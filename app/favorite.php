<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class favorite extends Model
{

    protected $table = 'favorite_properties';
    protected $fillable = [
        'id','user_id','property_id'
    ];


}
