<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
     protected $fillable = [
        'name','country_id'
    ];

    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }
}
