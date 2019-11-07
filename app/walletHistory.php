<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class walletHistory extends Model
{
    const mark1 = 'add to wallet';
    const mark2 = 'Use in booking';

    protected $fillable = ['user_id', 'mark', 'trId', 'amount', 'token','status'];

    public static function allWallet($userId = 0)
    {
        return \DB::table('wallets')->where([['user_id', $userId], ['status', 1]])->get() ?? null;
    }

    public static function countWallet($userId = 0)
    {
        return \DB::table('wallets')->select(\DB::raw('sum(amount) as userAmount, user_id'))->where([['user_id', $userId], ['status', 1]])->groupBy('user_id')->first() ?? null;
    }

    public static function countDeposits($userId = 0)
    {
        return walletHistory::select(\DB::raw('sum(amount) as userAmount, user_id'))->where([['user_id', $userId], ['status', 1]])->groupBy('user_id')->first() ?? null;
    }

    public static function updateWallet($reqId, $column, $value)
    {
        $aRow = \DB::table('wallets')->where('id', $reqId)->update([$column => \DB::raw($value)]);
        return true;
    }

    public static function useCoinForBooking($UserId, $amount)
    {
        $allActiveAmount = self::allWallet($UserId);
        $flagCoin = $amount;
        $flagId = 0;
        foreach ($allActiveAmount as $key => $value) {
            $flagId = $value->id;
            $usedStatus = $value->status;
            if ($usedStatus == 1) {
                $tempCoin = $value->amount;
                $flagCoin = $tempCoin - $flagCoin;
                if ($flagCoin < 0) {
                    $flagCoin = abs($flagCoin);
                    self::updateWallet($flagId, 'status', '0');
                    continue;
                }
                if ($flagCoin > 0) {
                    self::updateWallet($flagId, 'amount', $flagCoin);
                    break;
                }
                if ($flagCoin == 0) {
                    self::updateWallet($flagId, 'status', '0');
                    break;
                }
            } else {
                continue;
            }
        }

        $aData['user_id'] = $UserId;
        $aData['amount'] = $amount;
        $aData['mark'] = self::mark2;
        $aData['status'] = 1;
        walletHistory::create($aData);

    }

}
