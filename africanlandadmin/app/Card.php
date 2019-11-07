<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{


    protected $fillable = [
        'user_id','card_type','card_no', 'cardholder_name', 'expiration_date','business_booking','reward_booking'
    ];
}
 