<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Becomehost extends Model
{
    protected $table = 'host_requests';

    protected $fillable = [
        'fname', 'lname', 'email', 'company_name', 'role_id', 'email_token', 'mobile', 'country', 'city', 'country2', 'city2', 'status', 'services', 'property_type', 'service_other', 'reply', 'reply_attachment',
    ];

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }
    public function country_name()
    {
        return $this->hasOne(Country::class, 'id', 'country');
    }
    public function city_name()
    {
        return $this->hasOne(City::class, 'id', 'city');
    }

    public function get_services_name($services)
    {
        $values = "";
        if ($services) {
            $array = array();
            if (strpos($services, ",") !== false) {
                $explodes = explode(",", $services);
                foreach ($explodes as $key => $explode) {
                    $service_nameObj = Service::where("id", "=", $explode)->first();
                    if ($service_nameObj) {
                        $service_name = $service_nameObj->toArray();
                    } else {
                        $service_name['name'] = "service_Removed";
                    }
                    $array[] = $service_name['name'];
                }
            } else {
                $service_name = Service::where("id", "=", $services)->first();
                if ($service_nameObj) {
                    $service_name = $service_nameObj->toArray();
                } else {
                    $service_name['name'] = "service_Removed";
                }
                $array[] = $service_name['name'];
            }

            $values = implode(",", $array);
        }
        return $values;

    }
}
