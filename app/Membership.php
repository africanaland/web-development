<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
     protected $fillable = [
        'name','description','no_bookings','is_default','status'
    ];

    static function getDefault()
    {
    	$is_default = 0;
    	$aRow = Membership::where("is_default", "=",1)->first()->toArray();
    	if($aRow)
    	{
    		$is_default = $aRow['id'];
    	}
    	return $is_default;
    }

    public static function getMembershipData($id = 0 , $val = array('*')){

        $data = Membership::where('status',1)
                        ->select($val);
        if($id != 0)
        $data->where('id',$id);

        $result = $data->get();

        if(!empty($result->toArray()))
            return $result;
        else
            return false;
    }
}
