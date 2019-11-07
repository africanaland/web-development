<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
     protected $fillable = [
        'creator_id','name','image'
    ];
}
