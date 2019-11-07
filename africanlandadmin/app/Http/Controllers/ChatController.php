<?php

namespace App\Http\Controllers;

use App\chat;
use function GuzzleHttp\json_encode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Role;
use App\User;


class ChatController extends Controller
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
    public function index($userId = 0)
    {
        $aUserId = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUserId->role_id);
        $hostLogin = $staffLogin = $adminLogin = false;
        if ($CurrentLogin == "staffLogin") {
            $staffLogin = true;
            $listArray = array(User::ROLE_SUBADMIN,User::ROLE_AGENT,User::ROLE_HOST_COMPANY, User::ROLE_HOST_INDIVIDUAL, User::ROLE_HOTEL, User::ROLE_GUEST);
        }
        if ($CurrentLogin == "hostLogin") {
            $hostLogin = true;
            $listArray = array(User::ROLE_SUBADMIN,User::ROLE_AGENT, User::ROLE_GUEST);
        }
        if ($CurrentLogin == "adminLogin") {
            $adminLogin = true;
            if($aUserId->role_id == User::ROLE_ADMIN)
                $listArray = array(User::ROLE_SUBADMIN,User::ROLE_AGENT,User::ROLE_HOST_COMPANY, User::ROLE_HOST_INDIVIDUAL, User::ROLE_HOTEL,User::ROLE_GUEST);
            if($aUserId->role_id == User::ROLE_SUBADMIN)
                $listArray = array(User::ROLE_ADMIN,User::ROLE_SUBADMIN,User::ROLE_AGENT,User::ROLE_HOST_COMPANY, User::ROLE_HOST_INDIVIDUAL, User::ROLE_HOTEL,User::ROLE_GUEST);
        }
        


        $roleList = Role::whereIn('id',$listArray)->pluck('name','id')->toArray();
        $history = chat::where('s_id', $aUserId->id)->orderBy('updated_at', 'DESC')->get();
        
        $messageData = array();
        if ($userId) {
            $messageData = chat::where('rooms.s_id', $aUserId->id)
                ->Where('rooms.r_id', $userId)
                ->Join('message', 'rooms.roomId', '=', 'message.roomId')
                ->orderBy('message.created_at', 'ASC')
                ->get();

            \DB::table('message')->where('r_id', $aUserId->id)->Where('s_id', $userId)->update(['seen' => '1']);
        }
        return view('admin.users.chat', compact('history', 'messageData', 'aUserId','roleList'));
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
        $ErrorMessage = array(
            'message.required' => "Message field is empty",
            'receiver.required' => "'Error Refresh page",
            'img' => "file must be jpg,png,jpeg and size 2048.",
        );

        $this->validate($request, array(
            'message' => 'required',
            'receiver' => 'required|integer',
            'img' => 'image|mimes:jpg,png,jpeg,gif|max:2048',

        ), $ErrorMessage);

        $aUserId = \Auth::guard('admin')->user();

        if($aUserId->id == $request->receiver){

            return back()->with('message','Select Valid User');
            die();
        }

        $message['text'] = json_encode($request->message);
        $lastRoomId = 0;
        $imageName = "";

        $checkUser = chat::whereIn('s_id', [$aUserId->id, $request->receiver])->whereIn('r_id', [$aUserId->id, $request->receiver])->first();
        if (empty($checkUser)) {
            $chatData = chat::select('roomId')->get();
            foreach ($chatData as $value) {
                $lastRoomId = $value['roomId'];
            }

            $data = array(
                array(
                    's_id' => $aUserId->id,
                    'r_id' => $request->receiver,
                    'roomId' => $lastRoomId + 1,
                ),
                array(
                    's_id' => $request->receiver,
                    'r_id' => $aUserId->id,
                    'roomId' => $lastRoomId + 1,
                ),
            );
            chat::insert($data);

            if ($image = $request->img) {
                $imageName = \CustomHelper::uploadImage($image);
                $message['img'] = $imageName;
            }

            $finalMsg = implode(',', $message);

            $messageData = array(
                's_id' => $aUserId->id,
                'r_id' => $request->receiver,
                'roomId' => $lastRoomId + 1,
                'message' => $finalMsg,
            );

            \DB::table('message')->insert($messageData);

        } else {

            $checkUser->update(['updated_at' => date('Y-m-d h:i:s')]);

            if ($image = $request->img) {
                $imageName = \CustomHelper::uploadImage($image);
                $message['img'] = $imageName;
            }

            $finalMsg = implode(',', $message);

            $roomId = $checkUser->roomId;
            $messageData = array(
                's_id' => $aUserId->id,
                'r_id' => $request->receiver,
                'roomId' => $roomId,
                'message' => $finalMsg,
            );

            \DB::table('message')->insert($messageData);

        }
        return redirect(route('showmessage', $request->receiver));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show(chat $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit(chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(chat $chat)
    {
        //
    }


    public function getUsers(Request $request)
    {
        $uData = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($uData->role_id);
        $hostLogin = $staffLogin = $adminLogin = false;
        if ($CurrentLogin == "staffLogin") {
            $staffLogin = true;
        }
        if ($CurrentLogin == "hostLogin") {
            $hostLogin = true;
        }
        if ($CurrentLogin == "adminLogin") {
            $adminLogin = true;
        }

        $roleId = $request['roleId'];

        $aRowsObj = User::where([['status', 1], ['role_id', $roleId],['id','!=', $uData->id] ]);
        if(($staffLogin || $hostLogin) &&  $roleId!=User::ROLE_SUBADMIN)
            $aRowsObj->where('country',$uData->country);
    
        $aRows = $aRowsObj->pluck('fname', 'id')->toArray();

        $html = '<option value="">Please Select</option>';
        if ($aRows) {
            foreach ($aRows as $aKey => $aRow) {
                $html .= '<option value="' . $aKey . '">' . $aRow . '</option>';
            }
        }
        echo $html;
        exit;
    }


}
