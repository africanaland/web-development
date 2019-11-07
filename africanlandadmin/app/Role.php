<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Role extends Authenticatable
{   

   protected $fillable = [];
   
	public static  function getRolename($role_id = "", $col)
	{
		$role = "";
		$aRow = Role::where("id", "=",$role_id)->first();
		if($aRow)
		{
			$role = $aRow[$col];
		}
		return $role;
	}
   
}
