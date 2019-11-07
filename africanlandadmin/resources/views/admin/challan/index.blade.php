@extends('admin.layouts.app')

@php
$page_name = "Challan"
@endphp

@section('title') {{ $page_name }} @endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="javascript:void(0);">{{ $page_name }}</a></li>
@endsection

@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2>{{ $page_name }}</h2>
                <ul class="header-dropdown">
                    <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"
                            role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="{{ route('amenity.create') }}">Create</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body table-responsive">
                @if(count($aRows))
                <table class="table table-bordered table-striped js-basic-example dataTable ">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            @if($adminLogin)
                            <th>User Type</th>
                            <th>User name</th>
                            <th>For</th>
                            @endif
                            <th>Total Booking</th>
                            <th>@if($adminLogin) host @endif Commission</th>
                            <th>@if($adminLogin) host @endif pay Amount</th>
                            <th>Due Date</th>
                            <th>@if($adminLogin) host @endif pay status</th>
                            @if($adminLogin)
                            <th>Admin pay Amount</th>
                            <th>Pay status</th>
                            @endif
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($aRows as $aKey => $aRow)
                        <tr>
                            <th scope="row">{{ $aKey+1 }}</th>
                            @if($adminLogin)
                            <td>{{App\Role::getRolename($aRow['user']->role_id,'name')}}</td>
                            <td>{{$aRow['user']->fname}}</td>
                            <td>{{$aRow->mark}}</td>
                            @endif
                            <td>{{$aRow->totalBooking ?? 'NaN'}}</td>
                            <td>{{$aRow->host_cms_amount ?? 'NaN'}}</td>
                            <td>{{$aRow->host_amount ?? 'NaN'}}</td>
                            <td>{{date('d/m/y',strtotime($aRow->created_at))}}</td>
                            <td>
                                @if (!empty($aRow->host_amount))
                                    @if ($aRow->host_pay_status == 0)
                                        <span class="badge badge-danger">UnPayed</span>
                                    @else
                                        <span class="badge badge-success">Payed</span>
                                    @endif
                                @else
                                {{'NaN'}}
                                @endif
                            </td>
                            @if($adminLogin)
                            <td>{{$aRow->admin_amount}}</td>
                            <td>
                                @if ($aRow->admin_pay_status == 0)
                                <span class="badge badge-danger">UnPayed</span>
                                @else
                                <span class="badge badge-success">Payed</span>
                                @endif
                            </td>
                            @endif

                            <td>
                                <a href="{{route('challan.show',$aRow->id)}}"><i class="zmdi zmdi-eye"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                No data found
                @endif
            </div>
        </div>
    </div>
</div>

@endsection