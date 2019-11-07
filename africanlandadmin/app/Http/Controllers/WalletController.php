<?php

namespace App\Http\Controllers;

use App\wallet;
use App\walletHistory;
use App\Booking;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aUser = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUser->role_id);
        $hostLogin = $staffLogin = $adminLogin = false;
        if ($CurrentLogin == "staffLogin") {
            $staffLogin = true;
        }elseif ($CurrentLogin == "hostLogin") {
            $hostLogin = true;
        }elseif ($CurrentLogin == "adminLogin") {
            $adminLogin = true;
        }else{
            return redirect('home');
        }
        $expanse = walletHistory::countExpanse($aUser->id);
        $income = walletHistory::countIncome($aUser->id);
       

        $aRow = walletHistory::where('sender_id',$aUser->id)->orWhere('user_id',$aUser->id);
            if($adminLogin)
                $aRow->orWhere('mark',walletHistory::mark1);
            $aRows = $aRow->get();
        return view('admin.wallet.index',compact('aRows','expanse','income'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function show(wallet $wallet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function edit(wallet $wallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, wallet $wallet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(wallet $wallet)
    {
        //
    }
}
