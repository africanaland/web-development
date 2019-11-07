<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
     protected $fillable = [
        'name','is_african'
    ];

    static function count_city($country_id)
    {
    	$rows = City::where('country_id','=',$country_id)->count(); 
    	return $rows;
    }

    static function count_host($country_id,$city_id = 0,$type = 0)
    {
    	$aQry = User::select(['*']);
    	$aQry->where("country", "=",$country_id);
    	if($city_id > 0)
    	{
    		$aQry->where("city", "=",$city_id);
    	}
    	if($type > 0)
    	{
    		$aQry->where("role_id", "=",$type);
    	}
    	$rows = $aQry->count();
    	return $rows;
		}
		
		public static  function getCountryName($id = "", $col)
		{
			$role = "";
			$aRow = Country::where("id", "=",$id)->first();
			if($aRow)
			{
				$role = $aRow[$col];
			}
			return $role;
		}
}
