<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Page;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth');
    }


    public function index($pagename, Request $request)
    {
        $aUserId = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUserId->role_id);
        if ($CurrentLogin != "adminLogin") {
            return redirect('home');
        }

        if ($request->isMethod('post'))
        {
            $aVals = $request->all();
            $aRow = Page::where('page_name','=',$pagename)->first();
            $aRow->update($aVals);
            return back()->with('message', 'Your page update successfully.');
        }

        $aRow = Page::where('page_name','=',$pagename)->first();
        return view('admin.pages.index',compact('aRow'));
    }



}
