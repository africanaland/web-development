<?php

namespace App\Http\Controllers;

use App\notification;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;


class notifyController extends Controller
{

    public function __construct()
    {

        $this->middleware('admin.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $now = Carbon::now();
        $aUser = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUser->role_id);
        $hostLogin = $staffLogin = $adminLogin = false;
        if ($CurrentLogin == "staffLogin")
            $staffLogin = true;
        if ($CurrentLogin == "hostLogin") 
            $hostLogin = true;
        if ($CurrentLogin == "adminLogin") 
            $adminLogin = true;


        $today = Carbon::now();
        $aRow = notification::where('status',1);
        $aRow->whereRaw("NOT FIND_IN_SET($aUser->id,castStatus)");

        if ($adminLogin) {
            $aRow->where(function($query){
                $query->where('notifications.s_id', 0); // from host
                $query->whereNotIn('notifications.text_id',[12,5]);
            });
        }
        if ($staffLogin) {
            $AllRigisteredHost = User::where('creator_id', $aUser->id)->pluck('id')->toArray();
            $aRow->where(function($query) use ($aUser,$AllRigisteredHost){
                $query->whereIn('notifications.r_id',$AllRigisteredHost); // from host
                $query->orWhere('notifications.r_id',$aUser->id);
            });
            $aRow->where('notifications.castDate','<=',$today);
        }
        if ($hostLogin) {
            $aRow->where(function($query) use ($aUser){
                $query->Where('notifications.r_id','=',$aUser->id); // send by admin
                $query->orWhere('notifications.broadcast',$aUser->role_id);
            });
            $aRow->where('notifications.castDate', '<=', $today);
        }
        // $result = $aRow->get();
        // echo '<pre>';
        // print_r($result->toArray());
        // die();

        $data['castStatus'] = \DB::raw("CONCAT_WS(',',castStatus, $aUser->id)");
        $aRow->update($data);

        $aRows = array();
        return view('admin.notification.index', compact('aRows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aUserData = \Auth::guard('admin')->user();
        $hostLogin = $staffLogin = $adminLogin = false;
        $CurrentLogin = $this->UserLoginType($aUserData->role_id);
        if ($CurrentLogin == "staffLogin") {
            $staffLogin = true;
            $userList = array(User::ROLE_HOST_COMPANY, User::ROLE_HOST_INDIVIDUAL, User::ROLE_HOTEL);
        }
        if ($CurrentLogin == "hostLogin") {
            return redirect('notification');
        }
        if ($CurrentLogin == "adminLogin") {
            $adminLogin = true;
            $userList = array(User::ROLE_AGENT, User::ROLE_HOST_COMPANY, User::ROLE_HOST_INDIVIDUAL, User::ROLE_GUEST, User::ROLE_HOTEL);
        }

        $aRow = array();
        $userRoll = Role::whereIn('id', $userList)
            ->where('status', '1')->get();
        return view('admin.notification.add', compact('userRoll', 'aRow'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $aUser = \Auth::guard('admin')->user();

        $this->validate(
            $request, [
                'roleId' => 'required|numeric',
                'user' => 'required|numeric',
                'title' => 'required',
                'message' => 'required',
            ]
        );

        $hostLogin = $staffLogin = $adminLogin = false;
        $CurrentLogin = $this->UserLoginType($aUser->role_id);
        if ($CurrentLogin == "staffLogin") {
            $staffLogin = true;
        }

        if ($CurrentLogin == "adminLogin") {
            $adminLogin = true;
        }

        $hostList = array(User::ROLE_HOST_COMPANY, User::ROLE_HOST_INDIVIDUAL, User::ROLE_HOTEL);
        $staffList = array(User::ROLE_AGENT);
        $gustList = array(User::ROLE_GUEST);

        $aRow['title'] = $request->title;
        $aRow['detail'] = $request->message;
        $aRow['n_key'] = "text";
        $notifyId = \DB::table('notification_detail')->insertGetId($aRow);

        if ($request->user == 0) {
            $aRow['r_id'] = 0;
            $aRow['broadcast'] = $request->roleId;
        } else {
            $aRow['r_id'] = $request->user;
        }

        if ($adminLogin) {
            $aRow['s_id'] = 1;
        } else {
            $aRow['s_id'] = $aUser->id;
        }

        $aRow['text_id'] = $notifyId;
        $aRow['castStatus'] = " ";
        if ($request->addData) {
            $aRow['caseDate'] = $request->caseDate;
        }

        notification::create($aRow);

        return redirect('notification')->with('message', 'Send Notification Successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $aRow = notification::join('notification_detail', 'notification_detail.id', '=', 'notifications.text_id')
            ->where('notifications.id', $id)
            ->select('notifications.id as id', 'notification_detail.*', 'notifications.*')
            ->with('user')
            ->first();

        return view('admin.notification.show', compact('aRow'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, notification $notification)
    {

        // $this->validate($request,[
        // 'title' => 'required',
        // 'message' => 'required'
        // ]);

        // $notifyDetail = \DB::table('notification_detail')->where('id',$notification->text_id)->update([
        //     'title'  => $request->title,
        //     'detail' => $request->message,
        // ]);

        // return redirect('notification')->with('message', 'Notification Update Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(notification $notification)
    {
        $aRow = $notification->delete();
        if ($aRow) {
            $notifyDetail = \DB::table('notification_detail')->where('id', $notification->text_id)->delete();
        }

        return redirect()->back()->with('message', 'Notification Removed Successfully.');
    }

    public function getUsers(Request $request)
    {
        $roleId = $request['roleId'];
        $uData = \Auth::guard('admin')->user();
        $hostLogin = $staffLogin = $adminLogin = false;
        $CurrentLogin = $this->UserLoginType($uData->role_id);
        if ($CurrentLogin == "staffLogin") {
            $staffLogin = true;
        }

        $aRowsObj = User::where([['status', 1], ['role_id', $roleId]]);
        if ($staffLogin) {
            $aRowsObj->where('creator_id', '=', $uData->id);
        }

        $aRows = $aRowsObj->pluck('fname', 'id')->toArray();

        $html = '<option value="">Please Select</option>';
        $html .= '<option value="0">For Broadcast</option>';
        if ($aRows) {
            foreach ($aRows as $aKey => $aRow) {
                $html .= '<option value="' . $aKey . '">' . $aRow . '</option>';
            }
        }
        echo $html;
        exit;
    }

}
