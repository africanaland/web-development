<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
   
    public static function getSetting($aKey)
    {
        $aRow = Setting::where('meta_key','=',$aKey)->first();
        return $aRow ? $aRow->meta_value : "";
    }
}