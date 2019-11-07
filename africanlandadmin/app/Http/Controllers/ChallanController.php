<?php

namespace App\Http\Controllers;

use App\Booking;
use App\challan;
use App\CommissionDetail;
use App\Property;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\walletHistory;

class ChallanController extends Controller
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

        if ($CurrentLogin == "adminLogin") {
            $adminLogin = true;
            $AllRigisteredHost = User::select('id', 'role_id', 'creator_id')
                ->whereIn('role_id', [User::ROLE_HOST_COMPANY, User::ROLE_HOST_INDIVIDUAL, User::ROLE_HOTEL])
                ->where([['status', 1], ['agreement', 2]])
                ->get();
            foreach ($AllRigisteredHost as $key => $value) {
                $userData = array('id' => $value->id, 'role_id' => $value->role_id, 'creator_id' => $value->creator_id);
                $this->prePareFunction($userData);
                $this->prePareStaffChallan($userData);
            }
        } else if ($CurrentLogin == "hostLogin") {
            $hostLogin = true;
            $AllRigisteredProperty = Property::where('user_id', $aUser->id)->pluck('id')->toArray();
            $userData = array('id' => $aUser->id, 'role_id' => $aUser->role_id, 'creator_id' => $aUser->creator_id);
            $this->prePareFunction($userData);
        }
        else{
            return redirect('home'); 
        }

        $aData = challan::select('*');
        if ($hostLogin) {
            $aData->where([['user_id', $aUser->id], ['mark', 'like',walletHistory::mark4]]);
        }

        $aRows = $aData->with('user')->orderBy('id', 'DESC')->get();
        return view('admin.challan.index', compact('aRows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function prePareStaffChallan($aUser)
    {

        if (in_array($aUser['creator_id'], [0, 1])) {
            return;
        }
        $checkChallan = challan::where([['user_id', $aUser['id']], ['creator_id', $aUser['creator_id']], ['mark', 'like', walletHistory::mark3]])->first();
        if (!empty($checkChallan)) {
            return;
        }
        $commissionStaff = CommissionDetail::where([['role_id', User::ROLE_AGENT], ['type', 2]])->get();
        foreach ($commissionStaff as $key => $value) {
            if ($value['user_id'] == $aUser['creator_id']) {
                $staffCommission = $value['percent'];
                break;
            } else {
                $staffCommission = $value['percent'];
            }
        }

        $aData['user_id'] = $aUser['id'];
        $aData['mark'] = walletHistory::mark3;
        $aData['creator_id'] = $aUser['creator_id'];
        $aData['creator_cms_amount'] = $staffCommission;
        $aData['admin_amount'] = $staffCommission;
        challan::create($aData);
        return;

    }

    public function prePareFunction($aUser)
    {
        $now = Carbon::now();

        $AllRigisteredProperty = Property::where('user_id', $aUser['id'])->pluck('id')->toArray();

        $flag = false;
        $returnDate = '';
        while (true) {
            $totalBooking = Booking::whereIn('property_id', $AllRigisteredProperty)
                ->where([['bookingStatus', 1], ['status', 2]])
                ->where('checkout', '<', $now)
                ->get();

            $userChallan = challan::where([['user_id', $aUser['id']],['mark','like',walletHistory::mark4]])->orderBy('id', 'DESC')->get();
            if ($flag) {
                $tempDate = $returnDate;
                $startPayDate = Carbon::parse($tempDate)->addDay('1');
                $lastPayDate = Carbon::parse($startPayDate)->addDay('6');
            } elseif (count($userChallan)) {
                $tempData = $userChallan[0]['end_date'];
                $startPayDate = Carbon::parse($tempData)->addDay('1');
                $lastPayDate = Carbon::parse($startPayDate)->addDay('6');
            } elseif (count($totalBooking)) {
                $firstdate = $totalBooking[0]['created_at'];
                $startPayDate = Carbon::parse($firstdate)->startOfWeek();
                $lastPayDate = Carbon::parse($firstdate)->startOfWeek()->addDay('6');
            } else {
                return;
            }
            if (($startPayDate > $now) || (($startPayDate < $now) && ($lastPayDate > $now))) {
                break;
            }
        $returnData = $this->genrateChallan($startPayDate, $lastPayDate, $AllRigisteredProperty, $aUser);
            if ($returnData) {
                $returnDate = $returnData;
                $flag = true;
            } else {
                $flag = false;
                continue;
            }
        }

    }

    public function genrateChallan($sDate, $eDate, $pId = array(), $aUser = array())
    {
        $now = Carbon::now();
        $userCommission = $staffCommission = '';
        $staffEntry = false;

        $commission = CommissionDetail::where([['role_id', $aUser['role_id']], ['type', 1]])->get();
        foreach ($commission as $key => $value) {
            if ($value['user_id'] == $aUser['id']) {
                $userCommission = $value['percent'];
                break;
            } else {
                $userCommission = $value['percent'];
            }
        }
        if (!in_array($aUser['creator_id'], [0, 1])) {
            $staffEntry = true;
            $commissionStaff = CommissionDetail::where([['role_id', User::ROLE_AGENT], ['type', 1]])->get();
            foreach ($commissionStaff as $key => $value) {
                if ($value['user_id'] == $aUser['creator_id']) {
                    $staffCommission = $value['percent'];
                    break;
                } else {
                    $staffCommission = $value['percent'];
                }
            }

        }

        $getAllBooking = Booking::select(\DB::raw("count(paid_amount) as total, sum(paid_amount) as totalAmount "))
            ->whereIn('property_id', $pId)
            ->where([['bookingStatus', 1], ['status', 2]])
            ->where('checkout', '<', $now)
            ->whereBetween('created_at', array($sDate, $eDate))
            ->get();

        if (count($getAllBooking)) {
            $finalAmount = ($getAllBooking[0]['totalAmount'] - (($getAllBooking[0]['totalAmount'] * $userCommission) / 100));
            $aData['user_id'] = $aUser['id'];
            $aData['start_date'] = date($sDate);
            $aData['end_date'] = date($eDate);
            $aData['host_cms_amount'] = $userCommission;
            $aData['totalBooking'] = $getAllBooking[0]['total'];
            $aData['total'] = $getAllBooking[0]['totalAmount'] ?? 0;
            $aData['mark'] = walletHistory::mark4;
            $aData['host_amount'] = $finalAmount;
        }
        if ($staffEntry) {
            $aData['creator_id'] = $aUser['creator_id'];
            $aData['creator_cms_amount'] = $staffCommission;
            $aData['admin_amount'] = ($finalAmount - (($finalAmount * $staffCommission) / 100));
        }
        if ($aData['total'] == 0) {
            return $eDate;
        } else {
            challan::create($aData);
            return false;
        }
    }

    public function create()
    {

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
     * @param  \App\challan  $challan
     * @return \Illuminate\Http\Response
     */
    public function show(challan $challan)
    {
        $aRow = $challan;
        return view('admin.challan.view', compact('aRow'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\challan  $challan
     * @return \Illuminate\Http\Response
     */
    public function edit(challan $challan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\challan  $challan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, challan $challan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\challan  $challan
     * @return \Illuminate\Http\Response
     */
    public function destroy(challan $challan)
    {
        //
    }

    public function delete()
    {
        challan::where('pay_status', 0)->delete();
        challan::truncate();
    }
}
