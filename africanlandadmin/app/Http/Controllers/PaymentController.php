<?php

namespace App\Http\Controllers;

use App\challan;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Events\sendNotification;
use App\walletHistory;
use Config;


class PaymentController extends Controller
{

    public function store(Request $request)
    {

        // host  pay to admin no booking                 || code = 1
        // admin pay to ambassador for new registration  || code = 2
        // admin pay to ambassador no booking            || code = 3

        $this->validate($request, [
            'id' => 'required|numeric',
            'code' => 'required|numeric',
        ], [
            'required' => 'try again',
            'numeric' => 'try again',
        ]);

        $challan = challan::findOrFail($request->id);
        $aUser = \Auth::guard('admin')->user();
        
        if (in_array($request->code, [2, 3])) {/* admin pay */
            $amount = $challan->admin_amount;
            $senderId = $challan->creator_id;
            $paypal_email = Config::get('services.paypal.id');
        } elseif ($request->code == 1) { /* host pay */
            $amount = $challan->host_amount;
            $senderId = 1;
            if (empty($aUser->paypalId)) {
                return back()->with('error', 'papal service not registered for this user');
            } else {
                $paypal_email = $aUser->paypalId;
            }    
        } else {
            return back()->with('error', 'error to load data');
        }


        $item_name = $challan->mark;
        $item_number = base64_encode(time());
        $item_amount = $amount;
        $return_url = action('PaymentController@payreturn', ['code' => $request->code,'token' => $item_number]);
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
        // Append paypal return addresses
        $querystring .= "return=" . urlencode(stripslashes($return_url)) . "&";
        $querystring .= "cancel_return=" . urlencode(stripslashes($cancel_url)) . "&";

        $querystring .= "custom=" . $request->customer;

        $challan->token = $item_number;
        $challan->update();

        header('location:https://www.sandbox.paypal.com/cgi-bin/webscr' . $querystring);

        // header('location:https://www.paypal.com/cgi-bin/webscr' . $querystring);
        exit();
    }

    public function paycancel()
    {
        echo '<script> alert("error in transaction") </script>';
        return redirect()->back();
    }

    public function payreturn($code,$token)
    {
        $aUser = \Auth::guard('admin')->user();
        $challan = Challan::where('token', $token)->first();
        $aData = array();
        if (empty($challan)) {
            return redirect('challan')->with('error', 'Invalid Token Error');
        }
        if (in_array($code, [2, 3])) {
            $challan->admin_pay_status = 1;
            $challan->token = '';
            event(new sendNotification(0,$challan->creator_id,12,$challan->id));
            $aData['user_id'] = $challan->creator_id;
            $aData['sender_id'] = 1;
            $aData['mark'] = walletHistory::mark5;
            $aData['amount'] = $challan->admin_amount;
            $aData['status'] = 1;

        } elseif ($code == 1) {
            $challan->host_pay_status = 1;
            $challan->token = '';
            event(new sendNotification(0,0,13,$challan->id));
            $aData['user_id'] = 1;
            $aData['sender_id'] = $aUser->id;
            $aData['mark'] = walletHistory::mark6;
            $aData['amount'] = $challan->host_amount;
            $aData['status'] = 1;
        }
        $challan->update();
        walletHistory::create($aData);

        return redirect()->route('challan.show',$challan->id)->with('message','payment complete successfully');
    }

}
