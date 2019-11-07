<?php

namespace App\Http\Controllers;

use App\chat;
use Illuminate\Http\Request;
use function GuzzleHttp\json_encode;

class ChatController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userId = 0)
    {
        $history = chat::where('s_id',\Auth::user()->id)->orderBy('updated_at','DESC')->get();

        $messageData = array();
        if($userId){
            $messageData = chat::where('rooms.s_id',\Auth::user()->id)
                            ->Where('rooms.r_id',$userId)
                            ->Join('message','rooms.roomId','=','message.roomId')
                            ->orderBy('message.created_at','ASC')
                            ->get();

            \DB::table('message')->where('r_id',\Auth::user()->id)->Where('s_id',$userId)->update(['seen'=>'1']);
        }


        return view('users.chat',compact('history','messageData'));
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
        $aUserId = \Auth::user();
        $ErrorMessage = array(
            'required' => "Message field is empty",
            'integer' => 'error Refresh page',
            'img' => "file must be jpg,png,jpeg and size 2048."
        );

        $this->validate($request,array(
            'message' => 'required',
            'receiver' => 'required|integer',
            'img' => 'image|mimes:jpg,png,jpeg,gif|max:2048'

        ),$ErrorMessage);

        if($aUserId->id == $request->receiver){

            return back()->with('message','Select Valid User');
            die();
        }


        $message['text'] = json_encode($request->message);
        $lastRoomId = 0;
        $imageName = "";

        $checkUser = chat::whereIn('s_id', [$aUserId->id,$request->receiver])->whereIn('r_id',[$aUserId->id,$request->receiver])->first();
        if (empty($checkUser)) {
            $chatData = chat::select('roomId')->get();
            foreach ($chatData as $value) {
                $lastRoomId = $value['roomId'];
            }

            $data = array(
                array(
                    's_id' => $aUserId->id,
                    'r_id' => $request->receiver,
                    'roomId' => $lastRoomId + 1
                ),
                array(
                    's_id' => $request->receiver,
                    'r_id' => $aUserId->id,
                    'roomId' => $lastRoomId + 1
                )
            );
            chat::insert($data);

            if($image = $request->img)
            {
                $imageName = \CustomHelper::uploadImage($image);
                $message['img'] = $imageName;
            }

            $finalMsg = implode(',',$message);



            $messageData = array(
                's_id' => $aUserId->id,
                'r_id' => $request->receiver,
                'roomId' => $lastRoomId + 1,
                'message' => $finalMsg
            );

            \DB::table('message')->insert($messageData);

        } else {

            $checkUser->update(['updated_at' => date('Y-m-d h:i:s')]);

            if($image = $request->img)
            {
                $imageName = \CustomHelper::uploadImage($image);
                $message['img'] = $imageName;
            }

            $finalMsg = implode(',',$message);

            $roomId = $checkUser->roomId;
            $messageData = array(
                's_id' => $aUserId->id,
                'r_id' => $request->receiver,
                'roomId' => $roomId,
                'message' => $finalMsg
            );

            \DB::table('message')->insert($messageData);

        }
        return redirect(route('showmessage',$request->receiver));

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
}
