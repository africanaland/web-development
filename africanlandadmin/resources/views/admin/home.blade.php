@extends('admin.layouts.app')

@section('title') Admin Dashboard @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
@endsection
@php $aUser = Auth::guard('admin')->user() @endphp
@inject('getRole', 'App\Role')

@php $today = date('Y'); $start = $today-5; $last = $today+5; @endphp
@php $url_segment_type = Request::segment(2) @endphp
@if ($url_segment_type == 'year')
    @php $year = Request::segment(3) @endphp
@else
    @php $year = $today @endphp
@endif    

@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2>Admin Dashboard</h2>                        
               <!--  <ul class="header-dropdown">
                    <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="javascript:void(0);">Action</a></li>                            
                        </ul>
                    </li>
                </ul> -->
            </div>
            <div class="body py-4 px-2">
                <h4 class="mt-0 mb-2">Booking Detail</h4>
                <div class="row">
                    <div class="col-sm-3 col-xs-12">
                        <div class="small-box bg-info">
                            <div class="inner">            
                                <h3>{{$totalBookingHost}}</h3>
                                <p>Total Bookings</p>
                            </div>
                            <div class="icon">
                                <i class="zmdi zmdi-stackoverflow"></i>
                            </div>
                            <a href="{{route('bookings')}}" class="small-box-footer">More info<i class="ml-2 zmdi zmdi-caret-right-circle"></i></a>
                        </div>
                    </div>

                    <div class="col-sm-3 col-xs-12">
                        <div class="small-box bg-aqua">
                            <div class="inner">            
                                <h3>{{$pendingBooking}}</h3>
                                <p>Pending Booking</p>
                            </div>
                            <div class="icon">
                                <i class="zmdi zmdi-time-interval"></i>
                            </div>
                            <a href="{{route('bookings')}}" class="small-box-footer">More info<i class="ml-2 zmdi zmdi-caret-right-circle"></i></a>
                        </div>
                    </div>

                    <div class="col-sm-3 col-xs-12">
                        <div class="small-box bg-danger">
                            <div class="inner">            
                                <h3>{{$cancelBooking}}</h3>
                                <p>Reject Bookings</p>
                            </div>
                            <div class="icon">
                                <i class="zmdi zmdi-delete"></i>
                            </div>
                            <a href="{{route('bookings')}}" class="small-box-footer">More info<i class="ml-2 zmdi zmdi-caret-right-circle"></i></a>
                        </div>
                    </div>

                    <div class="col-sm-3 col-xs-12">
                        <div class="small-box bg-warning">
                            <div class="inner">            
                                <h3>{{$userCancelBooking}}</h3>
                                <p>Cancel Booking</p>
                            </div>
                            <div class="icon">
                                <i class="zmdi zmdi-smartphone-erase"></i>
                            </div>
                            <a href="{{route('bookings')}}" class="small-box-footer">More info<i class="ml-2 zmdi zmdi-caret-right-circle"></i></a>
                        </div>
                    </div>

                </div> {{-- end row --}}
                <hr>
                {{-- membership detail --}}
                <div class="row mt-3">
                    @if (!$hostLogin)                                
                    <div class="col-sm-6">
                        <h3 class="mb-2 mt-2 box-title">Membership detail</h3>
                        <div class="box-body">
                            <div id="donut-chart" style="height: 300px;"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <h3 class="mb-2 mt-2 box-title">Membership detail</h3>
                        <div class="box-body">
                            <table class="table-striped text-center table table-bordered" >
                                <thead class="ty-1">
                                    <tr>
                                        <th>Type</th>
                                        <th>Total User</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($aMemberData as $key => $item)
                                    <tr>
                                        <td>{{$key}}</td>
                                        <td>{{$item}}</td>                                            
                                    </tr>
                                    @empty
                                    <tr>
                                        <td></td>                                            
                                        <td></td>                                            
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                    <div class="col-sm-6">
                        <h3 class="mb-2 mt-2 box-title">Staff detail</h3>
                        @if($adminLogin || $staffLogin)
                        <div class="mb-3">
                            <div class="info-box">
                              <span class="info-box-icon bg-aqua"><i class="zmdi zmdi-account-circle"></i></span>
                              <div class="info-box-content">
                                  <span class="info-box-number d-block ml-3">Sub-Admin :- <small>{{$totalAdmin}}</small></span>
                                  <span class="info-box-number d-block ml-3">Ambasaddar :- <small>{{$totalAmbasaddar}}</small></span>
                                  <span class="info-box-text"><strong>Total Staff :-</strong> {{$totalStaff}}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="zmdi zmdi-account-circle"></i></span>
                                <div class="info-box-content">
                                    @php
                                        $temp = 0;
                                    @endphp
                                    @forelse ($totalHost as $key => $item) 
                                    @php $temp = $temp + (integer)$item->counter @endphp
                                        <span class="info-box-text ml-3"><span class="">{{$getRole->getRolename($item->role_id,'name')}} :- {{$item->counter}}</span></span>                                    
                                    @empty
                                        
                                    @endforelse
                                    <span class="info-box-text"><span class="p"><strong>Total Registered Host :-</strong> {{$temp}}</span></span>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="mb-3">
                            <div class="info-box">
                              <span class="info-box-icon bg-warning"><i class="zmdi zmdi-account-circle"></i></span>
                              <div class="info-box-content d-flex align-items-center">
                                    <span class="info-box-text"><span class="h6"><strong>Total Guest :-</strong> {{$totalGuest}}</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                            <h3 class="mb-2 mt-2 box-title">Extra Detail</h3>
                        <div class="row">
                            <div class="col-sm-6 col-xs-12 mb-2">
                                <div class="small-box bg-secondary">
                                    <div class="inner">            
                                        <h3>{{$totalProperty}}</h3>
                                        <p>Total Registered Property</p>
                                    </div>
                                    <div class="icon">
                                        <i class="zmdi zmdi-receipt"></i>
                                    </div>
                                    <a href="{{route('property.index')}}" class="small-box-footer">More info<i class="ml-2 zmdi zmdi-caret-right-circle"></i></a>
                                </div>
                            </div>
                        
                            @if (!$hostLogin)                                
                            <div class="col-sm-6 col-xs-12 mb-2">
                                <div class="small-box bg-danger">
                                    <div class="inner">            
                                        <h3>{{$totalReports}}</h3>
                                        <p>Guest Report</p>
                                    </div>
                                    <div class="icon">
                                        <i class="zmdi zmdi-alert-triangle"></i>
                                    </div>
                                    <a href="{{route('guestcarelist')}}" class="small-box-footer">More info<i class="ml-2 zmdi zmdi-caret-right-circle"></i></a>
                                </div>
                            </div>
                            @endif
                            
                            @if($adminLogin || $staffLogin)             
                            <div class="col-sm-6 col-xs-12 mb-2">
                                <div class="small-box bg-warning">
                                    <div class="inner">            
                                        <h3>{{$totalCountry}}</h3>
                                        <p>Registered Country</p>
                                    </div>
                                    <div class="icon">
                                        <i class="zmdi zmdi-google-earth"></i>
                                    </div>
                                    <a href="{{route('country.index')}}" class="small-box-footer">More info<i class="ml-2 zmdi zmdi-caret-right-circle"></i></a>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12 mb-2">
                                <div class="small-box bg-primary">
                                    <div class="inner">            
                                        <h3>{{$totalHostRequest}}</h3>
                                        <p>Host Request</p>
                                    </div>
                                    <div class="icon">
                                        <i class="zmdi zmdi-comments"></i>
                                    </div>
                                    <a href="{{route('hostsrequest')}}" class="small-box-footer">More info<i class="ml-2 zmdi zmdi-caret-right-circle"></i></a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="clearfix">
                            <div class="float-left">
                                <h3 class="mb-2 mt-2 box-title">Booking Detail</h3>
                            </div>
                            <div class="float-right">
                                <select name="" id="currentYear" data-value='year'>
                                    @for ($start; $start < $last; $start++)
                                        <option value="{{$start}}" @if($start == $year) selected @endif>{{$start}}</option>                                    
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="box-body">
                            <div id="bar-chart" style="height: 300px;"></div>
                        </div>
                    </div>

                </div>{{-- end row --}}
                <div class="row mt-5 pt-3">

                    

                </div> {{-- end row --}}
                <div class="row mt-4" >
                    <div class="col-sm-6">
                        <div class="">
                            <div class="bg-mostbooking">
                                <H5 class="m-0 text-white text-center">Most Five Booked Property</H5>
                                <div class=" p-2  text-white">
                                    @forelse ($mostBookingProperty as $key => $item)
                                    <div class="row mx-0">
                                        <div class="col-6">{{ $item['property']->name}}</div>
                                        <div class="col-4">
                                            <div class="ratings">
                                                <div class="empty-stars"></div>
                                                <div class="full-stars" style="width:{{\App\Review::ratings($item['property']->id)}}%"></div>
                                            </div>
                                        </div>                                        
                                        <div class="col-2">{{ $item->total}}</div>                                        
                                    </div>
                                    @empty
                                    <div class="row py-3 text-center">
                                        <div class="col-sm-12">{{" No Booking available"}}</div>
                                    </div>        
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('after-scripts')

<script src="{{asset('public/js/jquery.flot.js')}}"></script>
<script src="{{asset('public/js/jquery.flot.pie.js')}}"></script>
<script src="{{asset('public/js/jquery.flot.categories.js')}}"></script>
<script >
    var memberShipArray =  @php echo json_encode($aMemberData) @endphp;


 $(function () {
    var colorArray = [ '#86939c', '#cacaca', '#ffd700', '#0073b7', '#00c0ef'];
    var i = 0;
    var donutData = new Array();
    for (let index in memberShipArray) {
        donutData[i] = {label : index, data : memberShipArray[index], color : colorArray[i] };
        i++;
    }
    $.plot('#donut-chart', donutData, {
      series: {
        pie: {
          show       : true,
          radius     : 1,
          innerRadius: 0.5,
          label      : {
            show     : true,
            radius   : 2 / 3,
            formatter: labelFormatter,
            threshold: 0.1
          }

        }
      },
      legend: {
        show: false
      }
    })

    
    var bookingConfirm1  =  @php  echo json_encode($chartTotalBooking) @endphp;
    var bookingCancel1   =  @php echo json_encode($chartTotalCancelBooking) @endphp;

    var bookingConfirm = new Array();
    var bookingCancel = new Array();
    var i = 0;
    for (let index in bookingConfirm1) {
        bookingConfirm[i] = bookingConfirm1[index];
        i++;
    }
    for (let index in bookingCancel1) {
        bookingCancel[i] = bookingCancel1[index];
        i++;
    }
    
    $.plot('#bar-chart',  [{
        data: bookingConfirm,
        label: "Confirm Booking",
        bars: {
                show: true,
                barWidth: 0.4,
                align: "left"
            }
        
    }, {
        data: bookingCancel,
        label: "Canceil Booking",
        bars: {
                show: true,
                barWidth: 0.4,
                align: "right"
            }
    }],{
        series: {
          bars: {
            show    : true,
            barWidth: 0.6,
            align   : 'center'
          }
        },
        xaxis : {
          mode  : 'categories',
          tickLength: 5
        },
        grid: { hoverable: true, clickable: true }

    })
    
 })

    function labelFormatter(label, series) {
    return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
      + label
      + '<br>'
      + Math.round(series.percent) + '%</div>'
  }

  $(document).ready(function(){
      $('#currentYear').change(function(){
          var id = $(this).val();
          var type = $(this).data('value');
          window.location="{{ url('/home')}}"+'/'+type+'/'+id;
      })
  })
    </script>
@endpush
