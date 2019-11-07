<?php

namespace App\Http\Controllers;

use App\CommissionDetail;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class CommissionController extends Controller
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
        if( $CurrentLogin != 'adminLogin' )
            return redirect('home');

        $aRows = CommissionDetail::leftJoin('users', 'users.id', '=', 'commission_details.user_id')
            ->leftJoin('roles', 'roles.id', '=', 'commission_details.role_id')
            ->select('roles.name as roleType','roles.id as roleId', 'users.fname as userName', 'commission_details.*')
            ->get();
        return view('admin.commission.index', compact('aRows'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aUser = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUser->role_id);
        if( $CurrentLogin != 'adminLogin' )
            return redirect('home');

        $aRow = array();
        $userArray = array(User::ROLE_AGENT, User::ROLE_HOST_COMPANY, User::ROLE_HOST_INDIVIDUAL, User::ROLE_HOTEL);
        $uRole = Role::whereIn('id', $userArray)->pluck('name', 'id')->toArray();
        return view('admin.commission.add', compact('aRow', 'uRole'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $aData = $request->all();
        $this->validate($request, [
            'role_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'percent' => 'required|numeric',
            'type'    => 'required|numeric',
        ]);
        if( (User::ROLE_AGENT != $request->role_id) &&  ($request->type == 2)){
            return back()->withInput()->with('error', 'select Valid payment type');
        }
        $check = CommissionDetail::where(['role_id' => $request->role_id, 'user_id' => $request->user_id,'type'=>$request->type])->first();
        if ($check) {
            return back()->withInput()->with('error', 'commission already set on this user');
        }
        CommissionDetail::create($aData);
        return redirect('commission')->with('message', 'Commission Successfully set');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CommissionDetail  $commissionDetail
     * @return \Illuminate\Http\Response
     */
    public function show(CommissionDetail $commissionDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CommissionDetail  $commissionDetail
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aUser = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUser->role_id);
        if( $CurrentLogin != 'adminLogin' )
            return redirect('home');

        $aRow = CommissionDetail::where('commission_details.id', $id)->first();
        return view('admin.commission.add', compact('aRow'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CommissionDetail  $commissionDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $aVal = $request->all();
        $this->validate($request, [
            'percent' => 'required|numeric|min:1|max:100',
        ]);
        if( (User::ROLE_AGENT != $request->role_id) &&  ($request->type == 2)){
            return back()->withInput()->with('error', 'select Valid payment type');
        }

        $aData = CommissionDetail::where(['id' => $id])->first();
        $aData->update($aVal);
        return redirect('commission')->with('message', 'Commission Update Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CommissionDetail  $commissionDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $aUser = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUser->role_id);
        if( $CurrentLogin != 'adminLogin' )
            return redirect('home');

        $aRow = CommissionDetail::where('id',$id)->delete();
        return redirect('commission')->with('message', 'property deleted Successfully.');
    }

    public function getUsers(Request $request)
    {
        $roleId = $request['roleId'];
        $aRows = User::where('role_id', '=', $roleId)->pluck('fname', 'id')->toArray();

        $html = '<option value="">Please Select</option>';
        $html .= '<option value="0">For All</option>';
        if ($aRows) {
            foreach ($aRows as $aKey => $aRow) {
                $html .= '<option value="' . $aKey . '">' . $aRow . '</option>';
            }
        }
        echo $html;
        exit;
    }

}
