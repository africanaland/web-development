<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Guestcare extends Model
{
    protected $fillable = [
        'user_id','username', 'email', 'name','mobile','department','subject','message','status','reply','reply_by',
    ];  
}
