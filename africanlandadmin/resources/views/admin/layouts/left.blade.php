<aside class="right_menu">
<div id="" class="sidebar">
<div class="menu">
@if ($adminLogin)
    @php $RoleType = 'admin' @endphp
@elseif($staffLogin)
    @php $RoleType = 'staff' @endphp    
@elseif($hostLogin)
    @php $RoleType = 'host' @endphp    
@endif


<ul class="list">
<li>
<div class="user-info m-b-20">
<div class="image">
    @php $aUser = Auth::guard('admin')->user() @endphp
  <a href="{{ url('/') }}">
    @if($aUser->image)
      <img src="{{ App\Helpers\CustomHelper::displayImage($aUser->image) }}" alt="User" style="width:100px ;height:100px">
    @else
      <img src="{{ asset('public/images/profile.png') }}" alt="User" style="width:100px ;height:100px">
    @endif
  </a>
</div>
  <div class="detail">
      <h6 style="text-transform: capitalize;">{{ $aUser->fname }} {{ $aUser->lname }}</h6>
    @if($staffLogin)
      <p class="m-b-0">{{ App\Country::getCountryName($aUser->country,'name') }}</p>
    @endif
      <p class="m-b-0" style="text-transform: capitalize;">{{ $aUser->username }}</p>
      {{-- <p class="m-b-0">ID #{{ $aUser->id }}</p> --}}
  </div>
</div>
</li>
<li><a href="{{ url('/') }}"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a></li>
@if( $adminLogin || $staffLogin || $hostLogin)
  @if($adminLogin)
    <li><a href="{{ route('country.index') }}"><i class="zmdi zmdi-delicious"></i><span>Location Manage</span></a></li>{{-- country management --}}
  @endif
  @if($staffLogin)
    <li><a href="{{ route('city.index') }}"><i class="zmdi zmdi-delicious"></i><span>Location Manage</span></a></li>{{-- city management --}}
  @endif  
  @if($adminLogin)
    <li><a href="{{ route('userlist','staff') }}"><i class="material-icons">perm_identity</i><span>Staff</span></a></li>
    <li><a href="{{ route('users.index') }}"><i class="material-icons">perm_identity</i><span>Guests</span></a></li>
  @endif
  @if($adminLogin || $staffLogin)
    <li><a href="{{ route('userlist','hosts') }}"><i class="material-icons">perm_identity</i><span>Hosts</span></a></li>
  @endif

    @php $countNoti = App\notification::getNotification($RoleType,0,true) @endphp
    <li><a href="{{ url('notification/') }}"><i class="material-icons">notifications</i>
        <span>Notification
          @if ($countNoti>0)
            <span class="badge badge-pill  bg-danger text-white border-danger">{{  $countNoti }}</span>
          @endif
        </span>
      </a>
    </li>

    @php $countMgs = App\chat::getMessage(0,true) @endphp
    <li><a href="{{ url('message/') }}"><i class="zmdi zmdi-email"></i>
        <span>Chat
          @if ($countMgs>0)
            <span class="badge badge-pill  bg-danger text-white border-danger">{{  $countMgs }}</span>
          @endif
        </span>
      </a>
    </li>

    <li><a href="{{ route('wallet.index') }}"><i class="zmdi zmdi-balance-wallet"></i><span>Finance</span></a></li>
  @if($adminLogin || $hostLogin)
    <li><a href="{{ route('challan.index') }}"><i class="zmdi zmdi-money"></i><span>Challan</span></a></li>
  @endif

  @if($adminLogin)
    <li><a href="{{ route('commission.index') }}"><i class="zmdi zmdi-money"></i><span>Commission Detail</span></a></li>
    <li><a href="{{ route('pageview','policy') }}"><i class="zmdi zmdi-copy"></i><span>Privacy Policy</span></a></li>
    <li><a href="{{ route('pageview','terms') }}"><i class="zmdi zmdi-copy"></i><span>Terms & Condition</span></a></li>
    <li><a href="{{ route('policy.index') }}"><i class="zmdi zmdi-copy"></i><span>Policy & agreement</span></a></li>
  @endif
    <li><a href="{{ route('property.index') }}"><i class="zmdi zmdi-apps"></i><span>Properties</span></a></li>
    <li><a href="{{ route('amenity.index') }}"><i class="zmdi zmdi-swap-alt"></i><span>Amenities</span></a></li>
    <li><a href="{{ route('services.index') }}"><i class="zmdi zmdi-attachment-alt"></i><span>Additional Services</span></a></li>
  @if($adminLogin || $staffLogin)
    <li><a href="{{ route('memberships.index') }}"><i class="zmdi zmdi-lock"></i><span>Memberships</span></a></li>
    <li><a href="{{ route('offers.index') }}"><i class="zmdi zmdi-grid"></i><span>Offers</span></a></li>
  @endif
  @if($adminLogin)
    <li><a href="{{ route('coupons.index') }}"><i class="zmdi zmdi-grid"></i><span>Coupons</span></a></li>
  @endif
  @if($adminLogin || $staffLogin)
    <li><a href="{{ route('hostsrequest') }}"><i class="zmdi zmdi-grid"></i><span>Hosts Request</span></a></li>
    <li><a href="{{ route('guestcarelist') }}"><i class="zmdi zmdi-grid"></i><span>GuestCare</span></a></li>
  @endif
    <li><a href="{{ route('bookings') }}"><i class="zmdi zmdi-grid"></i><span>Bookings</span></a></li>
@endif


</div>
</div>
</aside>
