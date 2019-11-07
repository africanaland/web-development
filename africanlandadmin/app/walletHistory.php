<?php

namespace App;
use App\wallet;

use Illuminate\Database\Eloquent\Model;

class walletHistory extends Model
{
    const mark1 = 'add to wallet';
    const mark2 = 'Use in booking';
    const mark3 = 'Registerted New Host';
    const mark4 = 'booking commission';
    const mark5 = 'Admin pay';
    const mark6 = 'Host pay';
 
    protected $fillable = ['user_id','sender_id', 'mark', 'trId', 'amount', 'token','status'];

    
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public static function userWalletHistory($userId = 0)
    {
        return walletHistory::where([['user_id', $userId], ['status', 1]])->orderBy('id','DESC')->get() ?? null;
    }

    public static function countWallet($userId = 0)
    {
        return wallet::select(\DB::raw('sum(amount) as userAmount, user_id'))->where([['user_id', $userId], ['status', 1]])->groupBy('user_id')->first() ?? null;
    }

    public static function countExpanse($userId = 0)
    {
        return walletHistory::select(\DB::raw('sum(amount) as userAmount'))->where([['sender_id', $userId], ['status', 1]])->groupBy('sender_id')->first() ?? null;
    }
    
    public static function countIncome($userId = 0)
    {
        return walletHistory::select(\DB::raw('sum(amount) as userAmount'))->where([['user_id', $userId], ['status', 1]])->groupBy('user_id')->first() ?? null;
    }

}
