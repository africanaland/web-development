@extends('admin.layouts.app')

@php
    $page_name = $aRow ? "Challan Detail" : "Challan Detail"
@endphp

@section('title') {{ $page_name }} @endsection
@inject('userDetail', 'App\User')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="javascript:void(0);">{{ $page_name }}</a></li>
@endsection
@php $payNow = $adminPay = true; @endphp
@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2> {{ $page_name }}</h2>
            </div>
            <div class="body table-responsive">
                @if(count((array)$aRow))
                <table class="table m-b-0">
                    <tbody>
                        <tr><th width="150px;">Id</th><td style="border-top: none;">#{{$aRow->id}}</td></tr>
                        <tr><th>challan for</th><td>{{$aRow->mark}}</td></tr>
                        <tr><th>Role type</th><td>{{App\Role::getRolename($aRow['user']->role_id,'name')}}</td></tr>
                        <tr><th>User name</th><td>{{ $aRow['user']->fname }}</td></tr>
                        @if($aRow->start_date)
                        <tr><th>From</th><td>{{date('d/m/Y',strtotime($aRow->start_date))}}</td></tr>
                        <tr><th>To</th><td>{{date('d/m/Y',strtotime($aRow->end_date))}}</td></tr>
                        <tr><th>Total Booking</th><td>{{$aRow->totalBooking}}</td></tr>
                        <tr><th>Host commission data</th><td>{{$aRow->host_cms_amount}}</td></tr>
                        <tr><th>Total amount</th><td>{{$aRow->host_amount}}</td></tr>
                        <tr><th>Host Payment Status</th>
                            <td>
                                @if ($aRow->host_pay_status == 0)
                                    <span class="badge badge-danger">UnPayed</span>
                                @else
                                    <span class="badge badge-success">Payed</span>
                                    @php $payNow = false; @endphp
                                @endif      
                            </td>
                        </tr>
                        @endif
                        @if($adminLogin)
                            @if(!empty($aRow->creator_id))
                            @php
                                $data2 = $userDetail->getUserData($aRow->creator_id,array('fname'))
                            @endphp
                            <tr><th>Ambassador id</th><td>{{$data2->fname}}</td></tr>
                            <tr><th>Ambassador Commission detail</th><td>{{$aRow->creator_cms_amount}}</td></tr>
                            <tr><th>Total pay Amount</th><td>{{$aRow->admin_amount}}</td></tr>
                            <tr><th>Admin payment Status</th>
                                <td>
                                    @if ($aRow->admin_pay_status == 0)
                                        <span class="badge badge-danger">UnPayed</span>
                                    @else
                                        <span class="badge badge-success">Payed</span>
                                        @php $adminPay = false; @endphp
                                    @endif 
                                </td>
                            </tr>
                            @endif
                        @endif

                    </tbody>
                </table>
                @if (($payNow && $hostLogin) || ($adminPay  && $adminLogin))                    
                    {!! Form::open(['action'=>'PaymentController@store']) !!}
                    <input type="hidden" name="id" value="{{$aRow->id}}">
                    @if($aRow->start_date && $adminLogin)
                    <input type="hidden" name="code" value="3">
                    @elseif($adminLogin)
                    <input type="hidden" name="code" value="2">
                    @elseif($hostLogin)
                    <input type="hidden" name="code" value="1">
                    @endif
                    <input type="hidden" name="currency_code" value="USD">
                    <input type="hidden" name="cmd" value="_xclick" />
                    <input type="hidden" name="no_note" value="1" />
                    <input type="hidden" name="lc" value="UK" />
                    <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
                    <button type="submit" class="btn bg-aqua">PayNow</button>
                    {!! Form::close() !!}         
                @endif
                   
                @else
                No data found
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
