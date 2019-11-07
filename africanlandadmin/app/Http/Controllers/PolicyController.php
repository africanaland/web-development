<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Policy;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth');

    }

    public function index()
    {
        $aUserId = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUserId->role_id);
        if ($CurrentLogin != "adminLogin") {
            return redirect('home');
        }

        $aUser = User::findOrFail($aUserId->id);
        if ($aUser->role_id == 1) {
            $aRows = Policy::all();
        } else {
            $aRows = policy::with('username')->where([['role_id', '=', $aUserId->role_id], ['type', '=', 'agreement']])->get();
        }

        return view('admin.policy.index', compact('aRows', 'aUser'));
    }

    public function create()
    {
        $aUserId = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUserId->role_id);
        if ($CurrentLogin != "adminLogin") {
            return redirect('home');
        }

        $aRow = array();
        if ($aUserId->role_id == 1 || $aUserId->role_id == 2) {
            $aUser = Role::whereNotIn('id', [User::ROLE_ADMIN,User::ROLE_SUBADMIN,User::ROLE_GUEST])->pluck('name', 'id')->toArray();
            return view('admin.policy.add', compact('aRow', 'aUser'));
        }
    }
    public function store(Request $request)
    {
        $result = $urlAttribute = '';
        $aUserId = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUserId->role_id);
        if ($CurrentLogin == "adminLogin") {

            $this->validate($request, [
                'role_id' => 'required|numeric|unique:policies',
            ]);

            $aVals = $request->all();

            $aVals['details'] = json_encode($request->details);
            $aVals['status'] = 1;

            $result = policy::create($aVals);

            if(isset($request->addcolumn)){
                $urlAttribute = '?addcolumn=1';
            }

            return redirect('policy/'.$result->id.'/edit'.$urlAttribute)->with('message', 'New policy Added Successfully.');
        }
        return redirect('home/')->with('message', 'You are no eligible for this process');

    }

    public function show($id)
    {
        //
    }

    public function edit($id,Request $request)
    {

        $aUserId = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUserId->role_id);
        if ($CurrentLogin != "adminLogin") {
            return redirect('home');
        }

        $aRow = policy::findOrFail($id);
        if(isset($request->addcolumn)){
            $detailArray = json_decode($aRow->details);
            $blankArray = '';
            array_push($detailArray,$blankArray);
            $aRow->details = json_encode($detailArray);
            $aRow->update();
        }
        $aUser = Role::where('id',$aRow->role_id)->pluck('name', 'id')->toArray();
        return view('admin.policy.add', compact('aRow', 'aUser'));
    }

    // private function manageaction(Request $request, $id = 0)
    // {

    //     $aUserId = \Auth::guard('admin')->user()->id;
    //     $aUser = User::findOrFail($aUserId);

    //     $this->validate($request, [
    //         'name' => 'required|string|max:255',
    //         'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
    //     ]);

    //     $aVals = $request->all();

    //     $imageName = "";
    //     if ($image = request()->image) {
    //         $imageName = \CustomHelper::uploadImage($image);
    //         $aVals['image'] = $imageName;
    //     }

    //     if ($id == 0) {
    //         $aVals['role_id'] = $aUser->role_id;
    //         $aVals['user_id'] = $aUser->id;
    //         $aVals['status'] = 1;
    //         $aVals['type'] = 'policy';
    //     }

    //     return $aVals;
    // }

    public function update(Request $request, $id)
    {
        $aUserId = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUserId->role_id);
        if ($CurrentLogin == "adminLogin") {

            $this->validate($request, [
                'role_id' => 'required|numeric',
                'details' => 'required',
            ]);
            $aVals = $request->all();
            $aVals['details'] = json_encode($request->details);
            $aRow = policy::find($id);
            $aRow->update($aVals);
            return redirect('policy/'.$id.'/edit')->with('message', 'Policy Update Successfully.');
        }

        return redirect('home/')->with('message', 'You are no eligible for this process');
    }

    public function destroy($id)
    {
        $aUserId = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUserId->role_id);
        if ($CurrentLogin != "adminLogin") {
            return redirect('home');
        }

        $aRow = policy::findOrFail($id);
        $aRow->delete();
        return redirect('policy')->with('message', 'policy deleted Successfully.');
    }

}
