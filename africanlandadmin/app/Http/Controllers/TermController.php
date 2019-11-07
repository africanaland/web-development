<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Policy;
use App\User;

class TermController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth');
    }

    public function index()
    {
        $aRows = Policy::where('type','=','term')->get();        
        return view('admin.term.index',compact('aRows'));
    }

    public function create()
    { 
        $aRow = array();
        return view('admin.term.add',compact('aRow'));
    }
    public function store(Request $request)
    {
        $aVals = $this->manageaction($request);
        Policy::create($aVals);
        return redirect('term')->with('message', 'New term Added Successfully.');
    }

    
    public function show($id)
    {
        //
    }

    public function edit($id)
    {       
        $aRow = Policy::findOrFail($id);
        return view('admin.term.add',compact('aRow'));
    }

   
    public function update(Request $request, $id)
    {     
        $aVals = $this->manageaction($request, $id);
        $aRow = Policy::find($id);
        $aRow->update($aVals);
        return redirect('term')->with('message', 'term updated Successfully.');
    }


    private function manageaction(Request $request, $id = 0)
    {

        $aUserId = \Auth::guard('admin')->user()->id;
        $aUser = User::findOrFail($aUserId);

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
       
        $aVals = $request->all();      

        $imageName = "";
        if($image = request()->image)
        {       
            $imageName = \CustomHelper::uploadImage($image);
            $aVals['image'] = $imageName;
        }

        if($id == 0)
        {
            $aVals['role_id'] = $aUser->role_id; 
            $aVals['user_id'] = $aUser->id;
            $aVals['status'] = 1;
            $aVals['type'] = 'term';
        }        
        
        return $aVals;
    }
    
    public function destroy($id)
    {
        $aRow = Policy::findOrFail($id);
        $aRow->delete();
        return redirect('term')->with('message', 'term deleted Successfully.');
    }
        
}
