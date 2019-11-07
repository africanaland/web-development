<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img class="logoImg" src="{{ asset('public/uploads').'/'.$siteSettings[5]->meta_value }}" alt="{{ config('app.name', 'Laravel') }}">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('becomehost') }}">{{ __('Become a host') }}</a>
                </li>
                @else
                <li class="nav-item">
                        <a class="nav-link" href="#">{{ __('Become a host') }}</a>
                </li>
                @endguest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('privacy-policy') }}">{{ __('Privacy Policy') }}</a>
                </li>
                @guest

                <li class="nav-item">
                    <span class="nav-inline-item">
                        <!-- <a class="nav-link pr-0" href="{{ route('login') }}">{{ __('Login') }}</a>
<a class='loginPopup nav-link pr-0' href="{{ route('login') }}">{{ __('Login') }}</a>-->
                        <a class='nav-link pr-0' onclick="openPopup('{{ route("ajaxlogin") }}');" href="javascript:void(0);" id="homeLogin">{{ __('Login') }}</a>
                    </span>
                    <span class="nav-inline-item">/</span>
                    <span class="nav-inline-item">
                        <a class="nav-link pl-0" onclick="openPopup('{{ route("register") }}');" href="javascript:void(0);">{{ __('Sign up') }}</a>
                    </span>
                </li>

                @else

                <li class="nav-item dropdown ">

                    <a id="msgDropdown" class="notifyBeg nav-link pt-3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <i class="fa fa-bell-o"></i>
                        @php $counter = App\notification::getNotification(true) @endphp
                        @if($counter>0)
                        <span class="badge badge-pill badge-danger">{{$counter}}</span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-right w-mlg" aria-labelledby="msgDropdown">
                        <span class="arrow_top"></span>
                        <a class="dropdown-item active" href="javascript:void(0);">Notifications</a>

                        @php $notifyData = App\notification::getNotification() @endphp
                        @forelse (@$notifyData as $key => $aRow)
                        @php $key++ @endphp
                        @if ($key == 4) @php break @endphp  @endif
                        <a class="dropdown-item px-0" href="javascript:void(0);">
                            <div class="row mx-0">
                                <div class="col-8">
                                    <h5 class="mb-0 text-size15 text-dark">{{$aRow->title}}</h5>
                                </div>
                                <div class="col-3 pr-2 text-right ">
                                    <h6 class="mb-0 text-size10 notifyTime">
                                        {{ App\Helpers\CustomHelper::getNotificationTime($aRow->created_at)}}
                                    </h6>
                                </div>
                            </div>
                            <div class="row mx-0">
                                <div class="col-12">
                                    @if ($aRow->n_key == "text")
                                        <p class="mb-0 text-secondary notifyText">{{substr($aRow->detail,0,30).'...'}}</p>                            
                                    @else
                                        @php $detail = App\Helpers\CustomHelper::getNotificationMgs($aRow->id,$aRow->n_key) @endphp                            
                                        <p class="mb-0 text-secondary notifyText">{{substr($detail,0,30).'...'}}</p>
                                    @endif
                                </div>
                            </div>
                        </a>

                        @empty
                            <a class="dropdown-item px-0" href="javascript:void(0);">
                                <div class="row mx-0">
                                    <div class="col-12">
                                        <h5 class="mb-0 text-dark">No Notification</h5>
                                    </div>
                                </div>
                            </a>

                        @endforelse


                        <a class="dropdown-item active text-center border-bottom-0" href="{{ url('notification') }}">View All</a>
                    </div>
                </li>


                <li class="nav-item dropdown">
                    <a id="msgDropdown" class="notifyBeg nav-link pt-3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <i class="fa fa-envelope-o"></i>
                        @php $countMgs = App\chat::getMessage(0,true) @endphp
                        @if ($countMgs>0)
                            <span class="badge badge-pill badge-danger">{{  $countMgs }}</span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-right w-mlg" aria-labelledby="msgDropdown">
                        <span class="arrow_top"></span>
                        <a class="dropdown-item active" href="javascript:void(0);">Messages</a>

                        @php $allMessage = App\chat::getMessage(0) @endphp

                        @forelse ($allMessage as $item)
                        @php
                             $userdata = App\User::getUserData($item->s_id,array('image','fname'));
                            $finalMessage = explode(',',$item->message);
                        @endphp
                            <a class="dropdown-item px-0" href="{{ route('showmessage',$item->s_id) }}">
                                <div class="row mx-0">
                                    <div class="col-3 content-c">
                                        <img src="@if(!empty($userdata['image'])) {{ asset('public/uploads/'.$userdata['image'])  }}  @else {{ asset('public/images/profile.png') }}  @endif" alt="" style="height: 34px;" class="w-100 img-fluid rounded-circle" srcset="">
                                    </div>
                                    <div class="col-9 pl-2">
                                        <h5 class=" text-dark notifyText">{{$userdata['fname']}}</h5>
                                        <p class="mb-0 text-secondary notifyText">{{ substr(json_decode($finalMessage[0]),0,45)}}</p>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <a class="dropdown-item px-0" href="javascript:void(0);">
                                <h5 class="mb-0 text-center">NO Message</h5>
                            </a>
                        @endforelse
                        <a class="dropdown-item active text-center border-bottom-0" href="{{ route('showmessage') }}">View All</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <img class="profilePic" src="@if( Auth::user()->image ) {{ asset('public/uploads/'.Auth::user()->image)  }}  @else {{ asset('public/images/profile.png') }}  @endif">
                        {{ Auth::user()->fname }}
                        <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navDropDown" aria-labelledby="navbarDropdown">
                        <span class="arrow_top"></span>
                        <a class="dropdown-item" href="javascript:void(0);">{{ __('Guest Id :') }} <span>{{ Auth::user()->id }}</span></a>
                        <a class="dropdown-item" href="javascript:void(0);">{{ __('Username:') }} <span>{{ Auth::user()->username }}</span></a>
                        @php $rolData = App\Membership::getMembershipData(Auth::user()->membership_id,array('name')); @endphp
                        @if(!empty($rolData))
                        <a class="dropdown-item" href="javascript:void(0);">{{ __('Class:') }} <span>{{ $rolData[0]['name'] }}</span></a>
                        @endif
                        <a class="dropdown-item" href="{{ route('userbookings','previous') }}">{{ __('Bookings') }}</a>
                        <a class="dropdown-item" href="{{ route('userwallet') }}">{{ __('Wallet') }}</a>
                        <a class="dropdown-item" href="{{ route('myfavorite') }}">{{ __('Favorites') }}</a>
                        <a class="dropdown-item" href="{{ route('useroffers') }}">{{ __('Offers') }}</a>
                        <a class="dropdown-item" href="{{ route('guestcare') }}">{{ __('Guest Care') }}</a>
                        <a class="dropdown-item" href="{{ route('userprofile') }}">{{ __('Setting') }}</a>
                        <!-- <a class="dropdown-item" href="{{ route('properties') }}">{{ __('Properties') }}</a> -->
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
                <li class="nav-item dropdown">
                    <a id="msgDropdown" class="nav-link pt-3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>EN&nbsp;&nbsp;<i class="fa fa-caret-down" aria-hidden="true"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="msgDropdown">
                        <span class="arrow_top"></span>
                        <a class="dropdown-item text-center" href="#">EN</a>
                        <a class="dropdown-item text-center" href="#">HI</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
