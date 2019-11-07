<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
     protected $fillable = [
        'meta_key','meta_value','status'
    ];

    public static function getSetting($aKey)
    {
        $aRow = Setting::where('meta_key','=',$aKey)->first();
        return $aRow ? $aRow->meta_value : "";
    }

}
