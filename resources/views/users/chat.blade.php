@push('add-css')
<link href="{{ asset('public/css/emojionearea.min.css') }}" rel="stylesheet">
@endpush

@extends('layouts.app')
@section('content')
@php $url_segment = Request::segment(1) @endphp

<div class="">
    <div class="">
        <div class="row mx-0 bg-white chat-box">
            <div class="col-sm-3 p-0 nav-panel">
                <div class="chat-head">
                    <h4>Chat</h4>
                </div>
                <div class="chat-body left">

                    @forelse ($history as $item)
                    @php $userdata = App\User::getUserData($item->r_id,array('fname','image')) @endphp
                    <a href="{{ route('showmessage',$item->r_id)}}" class="text-decoration-none text-dark {{(Request::is($url_segment.'/'.$item->r_id)? 'active' : '') }}">
                        <div class="chat-users-panel">
                            <div class="row">
                                <div class="col-7 d-flex align-items-center ">
                                    <div style="background:url(@if(empty($userdata['image'])) {{asset('public/images/profile.png')}} @else {{asset('public/uploads/'.$userdata['image'])}} @endif)" class="chatUser user-border" ></div>
                                    <h5>{{ $userdata['fname'] }}</h5>
                                </div>
                                <div class="col-5 text-right">
                                    <h6>{{ date('H:i A',strtotime($item->updated_at))}}</h6>
                                </div>
                            </div>
                        </div>
                    </a>

                    @empty

                    @endforelse





                </div>
            </div> <!-- chat left panel end -->
            <div class="col-sm-8 p-0">
                <div class="chat-head">
                    <div class="d-flex">
                        <div class="user-profile ">
                            <img src="@if( Auth::user()->image ) {{ asset('public/uploads/'.Auth::user()->image)  }}  @else {{ asset('public/images/profile.png') }}  @endif" alt="" height="40px" width="40px" srcset="" class="user-border mr-2  rounded-circle">
                            <div class="user-online"></div>
                        </div>
                        <div class="activeUserDetail ml-2">
                            <h5 class="mb-1">{{Auth::user()->fname}}</h5>
                            <h6 class="m-0">Active <span class="fa fa-circle ml-2 text-success"></span></h6>
                        </div>
                        <div class="chat-nav d-block d-sm-none border">
                            <i class="icon1 fa fa-bars" aria-hidden="true"></i>
                            <i class="icon2 fa fa-times d-none" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="chat-body middle">

                @if (!empty($messageData))
                    <div class="chat-body-div scrollDown">
                        <div class="chat-content">
                            <ul class="list-unstyled message-Box">

                                @forelse ($messageData as $item)
                                <?php
                                    $userdata = App\User::getUserData($item->s_id,array('image'));
                                    $finalMessage = explode(',',$item->message);
                                ?>
                                <li class="@if ($item->s_id == Auth::user()->id) sender @else  receiver @endif ">
                                    <div>

                                        <img src="@if(!empty($userdata['image'])) {{ asset('public/uploads/'.$userdata['image'])  }}  @else {{ asset('public/images/profile.png') }}  @endif" alt="" height="40px" width="40px" srcset="" class="user-img user-border mr-2 mb-2 rounded-circle">
                                    </div>
                                    @if (!empty($finalMessage[1]))
                                    <div>
                                        <a href="{{ asset('public/uploads/'.$finalMessage[1]) }}">
                                            <img src="{{ asset('public/uploads/'.$finalMessage[1]) }}" alt=""  srcset="" class="img-thumbnail w-50 mb-2 mr-2">
                                        </a>
                                    </div>
                                    @endif
                                    <h6>{{ date('H:i A',strtotime($item->created_at)) }} <img src="@if($item->seen) {{ asset('public/images/message_read.png') }}  @else {{ asset('public/images/message_send.png') }}  @endif" alt="" height="10px" width="16px" srcset="" class=""></h6>
                                    <p>{{ json_decode($finalMessage[0]) }}</p>
                                </li>

                                @empty
                                <li>
                                    <div class="chat-body-div d-flex justify-content-center align-items-center flex-column">
                                        <div class="inbox_icon"><i class="fa fa-inbox" aria-hidden="true"></i></div>
                                        <h3>No messages</h3>
                                    </div>                
                                </li>
                                @endforelse


                            </ul>
                        </div>
                    </div>
                    <form action="{!! action('ChatController@store') !!}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="chat-footer py-3">
                            <div class="d-flex form-control w-95 mx-auto border border-0 shadow-lg rounded-0">
                                <div class="d-flex align-items-center">
                                    <span class="mr-3 chat-upload-image"><i class="fa fa-picture-o" aria-hidden="true"></i></span>
                                </div>
                                <input type="file" class="chat-upload-image-tag d-none" name="img" id="">
                                <input type="hidden"  name="receiver" value="{{Request::segment(2)}}" id="">
                                <input type="text" name="message" id="emoji-content" class="shadow-none border border-right-0 border-top-0 border-bottom-0 rounded-0 form-control">
                                <button type="submit" class="btn rounded-circle "><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </form>

                    @else
                    <div class="chat-body-div d-flex justify-content-center align-items-center flex-column">
                        <div class="inbox_icon"><i class="fa fa-inbox" aria-hidden="true"></i></div>
                        <h3>Chat Box</h3>
                    </div>

                    @endif

                </div>
            </div> <!-- chat middle panel end -->
            <div class="col-sm-1 d-none d-sm-block p-0">
                <div class="chat-head right">
                    <h4>Active</h4>
                </div>
                <div class="chat-body right text-center">


                    <a href="#">
                        <div class="chat-users-panel">
                            <div class="user-online"> {{-- add class if user online --}}
                                <div class="user-online-profile user-border" style="background: url({{asset('public/images/profile.png') }} )"></div>
                            </div>
                        </div>
                    </a>

                    <a href="#">
                        <div class="chat-users-panel">
                            <div class=""> {{-- add class if user online --}}
                                <div class="user-online-profile user-border" style="background: url( @if( Auth::user()->image ) {{ asset('public/uploads/'.Auth::user()->image)  }}  @else {{ asset('public/images/profile.png') }}  @endif)"></div>
                            </div>
                        </div>
                    </a>

                    <a href="#">
                        <div class="chat-users-panel">
                            <div class="user-online"> {{-- add class if user online --}}
                                <div class="user-online-profile user-border" style="background: url( @if( Auth::user()->image ) {{ asset('public/uploads/'.Auth::user()->image)  }}  @else {{ asset('public/images/profile.png') }}  @endif)"></div>
                            </div>
                        </div>
                    </a>

                </div>
            </div> <!-- chat right panel end -->
        </div>
    </div>

</div>
@endsection

@push('after-scripts')
<script src="{{ asset('public/js/emojionearea.min.js') }}"></script>
<script>
/* scrollDown chatPanal  */
$(document).ready(function(){
    $('.scrollDown').stop().animate({
        scrollTop: $('.scrollDown')[0].scrollHeight
    });
})

/* load emoji on chat page */
$(document).ready(function() {
    $("#emoji-content").emojioneArea({
        useSprite: false,
      autocomplete: false,
      hideSource: true,
      template: "<textarea/>"
    });
  });

</script>
@endpush
