<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Property extends Authenticatable
{

    protected $fillable = [
        'name','type', 'max_guest', 'no_bedrooms','no_kitchens','no_beds','no_bathrooms','daily_rate','services',
        'amenities','code','address','country','city','overview','details','image','status','gallery_images','policy','user_id'
    ];


    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function favorite()
    {
        return $this->hasOne(user_property::class , 'property_id', 'id' , 'user_id' , 'user_id');
    }



    public static function getPropertyTypes($type = "")
   {
        $aTypes['Hotel apartment'] = "Hotel apartment";
        $aTypes['Individuals'] = "Individuals";

        $aSubTypes[User::ROLE_HOST_COMPANY]['Standard'] = "Standard";
        $aSubTypes[User::ROLE_HOST_COMPANY]['Twin'] = "Twin";
        $aSubTypes[User::ROLE_HOST_COMPANY]['Family'] = "Family";
        $aSubTypes[User::ROLE_HOST_COMPANY]['Studio'] = "Studio";
        $aSubTypes[User::ROLE_HOST_INDIVIDUAL]['Villa'] = "Villa";
        $aSubTypes[User::ROLE_HOST_INDIVIDUAL]['Apartment'] = "Apartment";

        if($type)
        {
            return isset($aSubTypes[$type]) ? $aSubTypes[$type] : array();
        }

        return $aTypes;
   }

   public function get_property_fields($vals,$type)
    {
    	$values = array();
    	if($vals)
    	{
    		$fields = $array = array();
    		if( strpos($vals, ",") !== false )
    		{
    			$fields = explode(",", $vals);
    		}
    		else
    		{
    			$fields[] = $vals;
    		}

    		if($fields)
    		{
                $values = array();
    			foreach ($fields as $key => $field)
    			{
    				if($type == "amenities")
					{
                        if(Amenity::where("id",$field)->first()){
                            $field_name = Amenity::where("id", "=",$field)->first()->toArray();
                            $values[] =  $field_name;
                        }
					}
    				if($type == "services")
    				{
                        if(Service::where("id",$field)->first()){
                            $field_name = Service::where("id", "=",$field)->first()->toArray();
                            $values[] =  $field_name;
                        }
    				}

    			}
    			//$values = implode(",", $array);
    		}
    	}

    	return $values;

    }

}
