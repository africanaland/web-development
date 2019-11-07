<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{

    protected $fillable = ['property_id','booking_id','user_id','review','rating'];
    public $timestamps = false;

    public static function ratings($productid){
        $stars = Review::where('property_id',$productid)->avg('rating');
        $ratings = number_format((float)$stars, 1, '.', '')*20;
        return $ratings;
    }

    public static function reviewCount($productid , $userId = false){
        $total = Review::where('property_id',$productid);
        if($userId){
            $total->where('user_id',$userId);
        }
        $result = $total->count();
        return $result;
    }
}
