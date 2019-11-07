<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Service;
use App\User;
use Illuminate\Http\Request;

class servicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth');
    }

    public function index()
    {
        $aRows = Service::orderBy('id', 'DESC')->get();
        return view('admin.services.index', compact('aRows'));
    }

    public function create()
    {
        $aRow = array();
        return view('admin.services.add', compact('aRow'));
    }
    public function store(Request $request)
    {
        $aUser = \Auth::guard('admin')->user();
        $this->validate($request, [
            'name' => 'required|string|max:255|unique:services',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $aVals = $request->all();
        $roleArray = array(User::ROLE_ADMIN, User::ROLE_SUBADMIN);
        if (!in_array($aUser->role_id, $roleArray)) {
            $aVals['creator_id'] = $aUser->id;
        }

        $imageName = "";
        if ($image = request()->image) {
            $imageName = \CustomHelper::uploadImage($image);
            $aVals['image'] = $imageName;
        }

        Service::create($aVals);
        return redirect('services')->with('message', 'New service Added Successfully.');
    }

    public function show($id)
    {
        $aRow = Service::findOrFail($id);
        return view('admin.services.show', compact('aRow'));
    }

    public function edit($id)
    {
        $aRow = Service::findOrFail($id);
        return view('admin.services.add', compact('aRow'));
    }

    public function update(Request $request, $id)
    {
        $aUser = \Auth::guard('admin')->user();
        $aRow = Service::findOrFail($id);
        $roleArray = array(User::ROLE_ADMIN, User::ROLE_SUBADMIN);
        if (in_array($aUser->role_id, $roleArray) || ($aUser->id == $aRow->creator_id)) {} 
        else {
            return redirect('services')->with('error', 'Unauthorized Request');
        }

        $aVals = $request->all();
        $this->validate($request, [
            'name' => 'required|string|max:255|unique:services,name,' . $id,
            'price' => 'required|numeric|min:0',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $aVals = $request->all();

        $imageName = "";
        if ($image = request()->image) {
            $imageName = \CustomHelper::uploadImage($image);
            $aVals['image'] = $imageName;
        }

        $aRow->update($aVals);
        return redirect('services')->with('message', 'service updated Successfully.');
    }

    public function destroy($id)
    {
        $aUser = \Auth::guard('admin')->user();
        $aRow = Service::findOrFail($id);
        $roleArray = array(User::ROLE_ADMIN, User::ROLE_SUBADMIN);
        if (in_array($aUser->role_id, $roleArray) || ($aUser->id == $aRow->creator_id)) {} 
        else {
            return redirect('services')->with('error', 'Unauthorized Request');
        }
        $aRow->delete();
        return redirect('services')->with('message', 'service deleted Successfully.');
    }

}
