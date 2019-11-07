<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Events\sendNotification;
use App\Card;
use Config;
use App\walletHistory;


class PaymentController extends Controller
{

    public function store(Request $request)
    {

        $aUser = \Auth::user();

        $this->validate($request, [
            'cardId' => 'required|numeric',
            'amount' => 'required|numeric',
        ], [
            'required' => 'Select valid card',
            'numeric' => 'try again',
        ]);


        $paypal_email = Config::get('services.paypal.id');

        $item_name = 'wallet';
        $item_number = base64_encode(time());
        $item_amount = $request->amount;

        $return_url = action('PaymentController@payreturn', ['token' => $item_number]);
        $cancel_url = action('PaymentController@paycancel');

        $querystring = '';

        $querystring .= "?business=" . urlencode($paypal_email) . "&";
        $querystring .= "item_name=" . urlencode($item_name) . "&";
        $querystring .= "amount=" . urlencode($item_amount) . "&";
        $querystring .= "item_number=" . urlencode($item_number) . "&";
        $querystring .= "cmd=" . urlencode(stripslashes($request->cmd)) . "&";
        $querystring .= "bn=" . urlencode(stripslashes($request->bn)) . "&";
        $querystring .= "lc=" . urlencode(stripslashes($request->lc)) . "&";
        $querystring .= "currency_code=" . urlencode(stripslashes($request->currency_code)) . "&";
        $querystring .= "return=" . urlencode(stripslashes($return_url)) . "&";
        $querystring .= "cancel_return=" . urlencode(stripslashes($cancel_url)) . "&";
        $querystring .= "custom=" . $request->customer;

        // echo $querystring;
        // die;
        $aData['user_id'] = $aUser->id;
        $aData['mark'] = walletHistory::mark1;
        $aData['amount']= $item_amount;
        $aData['token']= $item_number;

        walletHistory::insert($aData);

        header('location:https://www.sandbox.paypal.com/cgi-bin/webscr' . $querystring);

        // header('location:https://www.paypal.com/cgi-bin/webscr' . $querystring);
        exit();
    }

    public function paycancel()
    {
        echo '<script> alert("error in transaction") </script>';
        return redirect()->route('userwallet');
    }

    public function payreturn($token)
    {
        $aUser = \Auth::user();
        $aRow = walletHistory::where('token', $token)->first();
        if (empty($aRow)) {
            return redirect()->route('userwallet')->with('error', 'Invalid Token Error');
        }
        $aData['user_id'] = $aUser->id;
        $aData['amount']= $aRow->amount;

        \DB::table('wallets')->insert($aData);

        $aRow->status = 1;
        $aRow->update();

        return redirect()->route('userwallet')->with('message','add Money successfully');
    }

}
