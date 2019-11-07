@push('add-css')
    <link href="{{ asset('public/admin/css/emojionearea.min.css') }}" rel="stylesheet">
@endpush

@php
$page_name = "AfricanLand Chat"
@endphp

@section('title') {{ $page_name }} @endsection
@extends('admin.layouts.app')
@section('content')
@php $url_segment = Request::segment(1) @endphp
@inject('CustomHelper', 'App\Helpers\CustomHelper')
<script>
    var getDataUrl = '{{ route('chatGetUser')}}';
</script>
    
<form action="{{ route('startchat')}}" method="post">
@csrf
<div class="row mb-3">
    <div class="col-sm-3">
        <label for="roleId">Select User To start Chat</label>
        <select name="roleId" id="getData" class="form-control" data-value="userName" required>
            <option value="">--Select User--</option>
            @foreach ($roleList as $key => $item)
                <option value="{{$key}}">@if($item) {{$item}} @else {{ 'No Name' }} @endif</option>                 
            @endforeach
        </select>
    </div>
    <div class="col-sm-5">
            <label for="userId">Select User To start Chat</label>
            <div class="d-flex">
                <select name="userId" id="userName" class="form-control ms" required>
                    <option value="">--Select User--</option>
                </select>
                <div class="col-sm-6"><input type="submit" value="submit" class="btn btn-default"></div>
            </div>
        </div>
    </div>
</form>

<div class="mb-5">
    <div class="">
        <div class="row mx-0 bg-white chat-box">
            <div class="col-sm-3 p-0 nav-panel">
                <div class="chat-head border-right-0">
                    <h4>Chat</h4>
                </div>
                <div class="chat-body left border-right-0 border-top-0">

                    @forelse ($history as $item)
                    @php $userdata = App\User::getUserData($item->r_id,array('fname','image')) @endphp
                    <a href="{{ route('showmessage',$item->r_id)}}" class="text-decoration-none text-dark {{(Request::is($url_segment.'/'.$item->r_id)? 'active' : '') }}">
                        <div class="chat-users-panel">
                            <div class="row">
                                <div class="col-7 d-flex align-items-center ">
                                    @php $countMgs = App\chat::getMessage($item->r_id,true) @endphp
                                    <div style="background:url(@if(empty($userdata['image'])) {{asset('public/images/profile.png')}} @else {{ $CustomHelper->displayImage($userdata['image'])}} @endif)" class="chatUser user-border" ></div>
                                    <h5>{{ $userdata['fname'] }}</h5>
                                    @if ($countMgs>0)
                                        <span class="badge badge-pill msgCount-badge bg-danger text-white border-danger">{{  $countMgs }}</span>
                                    @endif                              
                                </div>
                                <div class="col-5 text-right">
                                    <h6 class="text-secondary">{{ date('H:i A',strtotime($item->updated_at))}}</h6>
                                </div>
                            </div>
                        </div>
                    </a>
                    @empty

                    @endforelse
                </div>
            </div> <!-- chat left panel end -->
            <div class="col-sm-9 p-0">
                <div class="chat-head">
                    <div class="d-flex">
                        <div class="user-profile ">
                            <img src="@if( $aUserId->image ) {{ $CustomHelper->displayImage($aUserId->image)  }}  @else {{ asset('public/images/profile.png') }}  @endif" alt="" height="40px" width="40px" srcset="" class="user-border mr-2  rounded-circle">
                            <div class="user-online"></div>
                        </div>
                        <div class="activeUserDetail ml-2">
                            <h5 class="mb-1 text-dark">{{$aUserId->fname}}</h5>
                            <h6 class="m-0 text-secondary">Active <span class="zmdi zmdi-circle ml-2 text-success"></span></h6>
                        </div>
                        <div class="chat-nav d-block d-sm-none border">
                            <i class="icon1 zmdi zmdi-square" aria-hidden="true"></i>
                            <i class="icon2 zmdi zmdi-arrow-left d-none" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="chat-body middle  border-top-0">

                @if (!empty($messageData))
                    <div class="chat-body-div scrollDown">
                        <div class="chat-content">
                            <ul class="list-unstyled message-Box">

                                @forelse ($messageData as $item)
                                <?php
                                    $userdata = App\User::getUserData($item->s_id,array('image'));
                                    $finalMessage = explode(',',$item->message);
                                ?>
                                <li class="@if ($item->s_id == $aUserId->id) sender @else  receiver @endif ">
                                    <div>

                                        <img src="@if(!empty($userdata['image'])) {{ $CustomHelper->displayImage($userdata['image'])  }}  @else {{ asset('public/images/profile.png') }}  @endif" alt="" height="40px" width="40px" srcset="" class="user-img user-border mr-2 mb-2 rounded-circle">
                                    </div>
                                    @if (!empty($finalMessage[1]))
                                    <div>
                                        <a href="{{ $CustomHelper->displayImage($finalMessage[1]) }}">
                                            <img src="{{ $CustomHelper->displayImage($finalMessage[1]) }}" alt=""  srcset="" class="img-thumbnail w-50 mb-2 mr-2">
                                        </a>
                                    </div>
                                    @endif
                                    <h6 class="text-secondary">{{ date('H:i A',strtotime($item->created_at)) }} <img src="@if($item->seen) {{ asset('public/images/message_read.png') }}  @else {{ asset('public/images/message_send.png') }}  @endif" alt="" height="10px" width="16px" srcset="" class=""></h6>
                                    <p>{{ json_decode($finalMessage[0]) }}</p>
                                </li>

                                @empty

                                <li>
                                    <div class="d-flex justify-content-center align-items-center flex-column">
                                        <div class="inbox_icon"><i class="zmdi zmdi-inbox" aria-hidden="true"></i></div>
                                        <h3>No Message</h3>
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
                                    <span class="mr-3 chat-upload-image"><i class="zmdi zmdi-comment-image" aria-hidden="true"></i></span>
                                </div>
                                <input type="file" class="chat-upload-image-tag d-none" name="img" id="">
                                <input type="hidden"  name="receiver" value="{{Request::segment(2)}}" id="">
                                <input type="text" name="message" id="emoji-content" class="shadow-none border border-right-0 border-top-0 border-bottom-0 rounded-0 form-control">
                                <button class="btn rounded-circle "><i class="zmdi zmdi-mail-send" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </form>

                    @else
                    <div class="chat-body-div d-flex justify-content-center align-items-center flex-column">
                        <div class="inbox_icon"><i class="zmdi zmdi-inbox" aria-hidden="true"></i></div>
                        <h3>Chat Box</h3>
                    </div>

                    @endif

                </div>
            </div> <!-- chat middle panel end -->

        </div>
    </div>

</div>


@endsection

@push('after-scripts')
<script src="{{ asset('public/admin/js/emojionearea.min.js') }}"></script>
<script>
/* scrollDown chatPanal */
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
  $(document).ready(function(){

$(".chat-upload-image").click(function(){
    $(".chat-upload-image-tag").click();
    $('.chat-upload-image-tag').change(function(e){
        $('.chat-upload-image').addClass('active');
    $('.upload-file-name').html(e.target.files[0].name);
    });
   });

});

</script>
@endpush
