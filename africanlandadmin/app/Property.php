<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Property extends Authenticatable
{
  
    protected $fillable = [
        'name','property_type','host_type','host_name' ,'max_guest', 'no_bedrooms','no_kitchens','no_beds','no_bathrooms','daily_rate','services',  'amenities','code','address','country','city','overview','details','image','status','gallery_images','policy','user_id','tax_rate','have_tax','no_parking','no_reception','latitude','longitude'
    ];

    const Standard = 'Standard';
    const Twin = 'Twin';
    const Family = 'Family';
    const Studio = 'Studio';
    const Villa = 'Villa';
    const Apartment = 'Apartment';

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function country_name()
    {
        return $this->hasOne(Country::class, 'id', 'country');
    }
    public function city_name()
    {
        return $this->hasOne(City::class, 'id', 'city');
    }
    public function user_detail()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function host_detail()
    {
        return $this->hasOne(User::class, 'id', 'host_name');
    }

   public static function getTypes($type = "")
   {
        $aTypes['Hotel apartment'] = "Hotel apartment";
        $aTypes['Individuals'] = "Individuals";

        $aSubTypes[User::ROLE_HOST_COMPANY][self::Standard] = self::Standard;
        $aSubTypes[User::ROLE_HOST_COMPANY][self::Twin] = self::Twin;
        $aSubTypes[User::ROLE_HOST_COMPANY][self::Family] = self::Family;
        $aSubTypes[User::ROLE_HOST_COMPANY][self::Studio] = self::Studio;
        $aSubTypes[User::ROLE_HOST_INDIVIDUAL][self::Villa] = self::Villa;
        $aSubTypes[User::ROLE_HOST_INDIVIDUAL][self::Apartment] = self::Apartment;

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
    			foreach ($fields as $key => $field)
    			{
    				if($type == "amenities")
					{
						$field_name = Amenity::where("id", "=",$field)->first()->toArray();
					} 
    				if($type == "services")
    				{
    					$field_name = Service::where("id", "=",$field)->first()->toArray();
    				}

    				$values[] =  $field_name['name']; 
    			}
    			//$values = implode(",", $array);	
    		}    		
    	}
    	
    	return $values;
    	
    }
}
