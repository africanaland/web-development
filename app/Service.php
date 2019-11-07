<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'creator_id','name', 'type', 'price', 'status',
    ];

    public static function getData($id = 0, $val = array(), $count = false)
    {
        $data = Service::where('status', '1');

        if (!empty($val)) {
            $result = $data->select($val);
        } else {
            $result = $data->select('*');
        }

        if ($id != 0) {
            $result = $data->where('id', $id)->first();
        } else {
            if ($count) {
                $result = $data->count();
            } else {
                $result = $data->get();
            }
        }

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
}
