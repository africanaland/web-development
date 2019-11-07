<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth');
    }

    public function index()
    {
        $aUser = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUser->role_id);
        if ($CurrentLogin != "adminLogin")
            return redirect('home');

        $aRows = Coupon::get();

        return view('admin.coupons.index', compact('aRows'));
    }

    public function create()
    {
        $aUser = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUser->role_id);
        if ($CurrentLogin != "adminLogin")
            return redirect('home');

        $aRow = array();
        return view('admin.coupons.add', compact('aRow'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'code' => 'required|string|max:255|unique:coupons',
            'start_date' => 'required',
            'end_date' => 'required|after:start_date',
            'discount' => 'required|numeric|min:0',
        ]);

        Coupon::create($request->all());
        return redirect('coupons')->with('message', 'New coupon Added Successfully.');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $aUser = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUser->role_id);
        if ($CurrentLogin != "adminLogin")
            return redirect('home');

        $aRow = Coupon::findOrFail($id);
        return view('admin.coupons.add', compact('aRow'));
    }

    public function update(Request $request, $id)
    {
        $aVals = $request->all();
        $this->validate($request, [
            'code' => 'required|string|max:255|unique:coupons,name,' . $id,
        ]);

        $aRow = Coupon::find($id);
        $aRow->update($aVals);
        return redirect('coupons')->with('message', 'coupon updated Successfully.');
    }

    public function destroy($id)
    {
        $aUser = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUser->role_id);
        if ($CurrentLogin != "adminLogin")
            return redirect('home');

        $aRow = Coupon::findOrFail($id);
        $aRow->delete();
        return redirect('coupons')->with('message', 'coupon deleted Successfully.');
    }

}
