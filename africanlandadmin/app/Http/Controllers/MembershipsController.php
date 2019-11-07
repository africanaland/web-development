<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Membership;

class MembershipsController extends Controller
{
    public function __construct()
    {
       
    }

    public function index()
    {
        $aUserData = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUserData->role_id);
        if ($CurrentLogin == "hostLogin") {
            return redirect('home');
        }


        $aRows = Membership::get();        
        return view('admin.memberships.index',compact('aRows'));
    }

    public function create()
    {       
        return redirect('memberships');
                // $aRow = array();
        // return view('admin.memberships.add',compact('aRow'));
    }
    public function store(Request $request)
    {
       /* $this->validate($request, [
            'name' => 'required|string|max:255|unique:memberships', 
            'description' => 'required', 
            'no_bookings' => 'required',
        ]);

        $aVals = $request->all();       
        Membership::create($aVals);
        return redirect('memberships')->with('message', 'New Membership Added Successfully.');*/
    }

    
    public function show($id)
    {
        $aRow = Membership::findOrFail($id);
        return view('admin.memberships.show',compact('aRow'));
    }

    public function edit($id)
    {
        $aUserData = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUserData->role_id);
        if ($CurrentLogin == "hostLogin") {
            return redirect('home');
        }

        $aRow = Membership::findOrFail($id);             
        return view('admin.memberships.add',compact('aRow'));
    }

    public function makedefault($id)
    {
        $aUserData = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUserData->role_id);
        if ($CurrentLogin == "hostLogin") {
            return redirect('home');
        }

        Membership::query()->update(['is_default' => 0]);
        $aRow = Membership::findOrFail($id);
        $aRow->update(array('is_default' => 1));
        return redirect('memberships')->with('message', 'Default membership changed Successfully.');
    }

   
    public function update(Request $request, $id)
    {        
       
       $this->validate($request, [
            'name' => 'required|string|max:255|unique:memberships,name,'.$id, 
            'description' => 'required', 
            'no_bookings' => 'required',
        ]);


        $aVals = $request->all();
        $aRow = Membership::find($id);
        $aRow->update($aVals);
        return redirect('memberships')->with('message', 'Membership updated Successfully.');
    }

    
    public function destroy($id)
    {
        return redirect('memberships');
        // $aRow = Membership::findOrFail($id);
        // $aRow->delete();
        // return redirect('memberships')->with('message', 'Membership deleted Successfully.');
    }
        
}
