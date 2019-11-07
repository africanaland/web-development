@extends('admin.layouts.app')

@php
    $page_name = "Manage Notification"
@endphp

@section('title') {{ $page_name }} @endsection


@section('breadcrumb')
    <li class="breadcrumb-item"><a href="javascript:void(0);">{{ $page_name }}</a></li>
@endsection

@section('content')
@php $status = request('viewMode', 0) @endphp

@if ($adminLogin)
    @php $RoleType = 'admin' @endphp
@elseif($staffLogin)
    @php $RoleType = 'staff' @endphp    
@elseif($hostLogin)
    @php $RoleType = 'host' @endphp    
@endif
@php $aRows = App\notification::getNotification($RoleType,$status) @endphp
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2>{{ $page_name }}</h2>
                @if (!$hostLogin)                    
                <ul class="header-dropdown">
                    <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="{{ url('notification/create') }}">Create</a></li>
                        </ul>
                    </li>
                </ul>
                @endif
            </div>

            <div class="body table-responsive">
            @if (!$hostLogin)                
                <form method="get" class="searchlist"> 
                    <div class="row"><div class="col-md-12">Filter:</div></div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="input-group m-b-0">
                                {{ Form::select('viewMode', ['' =>'Select type','0' =>'Notification','1' =>'Send notification'], $status ?? 0 , ['class' => 'form-control ms']) }}
                            </div>
                        </div>
                    </div>
                </form>
            @endif
                        
                        @if(count($aRows))
                       <table class="table table-bordered table-striped js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>Msg status</th>
                                    @if ($status)
                                    <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aRows as $aKey => $aRow)
                                <tr>
                                    {{-- <th scope="row">{{ $aRow->id }}</th> --}}
                                    <th scope="row">{{ $aKey+1 }}</th>
                                    <td>{{$aRow->title}}</td>
                                    @php $detail = App\Helpers\CustomHelper::getNotificationMgs($aRow->id,$aRow->n_key) @endphp                            
                                    <td><?PHP echo $detail ?></td>
                                    <td>{{ date('M/d Y',strtotime($aRow->created_at))}}</td>
                                    @if ($status)
                                    <td>
                                        <a title="View" href="{{ route('notification.show',$aRow->id) }}"><i class="material-icons">remove_red_eye</i></a>
                                        <a href="javascript:void(0);" onclick="jQuery(this).parent('td').find('#delete-form').submit();"><i class="material-icons">delete</i>
                                        </a>
                                        <form id="delete-form" onsubmit="return confirm('Are you sure to delete?');" action="{{ route('notification.destroy',$aRow->id) }}" method="post" style="display: none;">
                                           {{ method_field('DELETE') }}
                                           {{ csrf_field() }}
                                        </form>
                                    </td>
                                    @endif
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

{{-- 
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2>{{ $page_name }}</h2>
                <ul class="header-dropdown">
                    <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="{{ url('notification/create') }}">Create</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="body table-responsive">
                        @if(count($aRows))
                       <table class="table table-bordered table-striped js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User Name</th>
                                    <th>Type</th>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>Msg status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aRows as $aKey => $aRow)
                                @if($aRow->r_id == 0)
                                    @php continue @endphp
                                @else
                                <tr>
                                    <th scope="row">{{ $aKey+1 }}</th>
                                    <td>
                                        {{$aRow->user['fname']}},<br>{{$aRow->user['email']}}
                                    </td>
                                    <td></td>
                                    <td>{{$aRow->title}}</td>
                                    <td>{{ date('M/d Y',strtotime($aRow->created_at))}}</td>
                                    <td>
                                        @if ($aRow->r_id != 0 && $aRow->status == 1)
                                                Seen
                                        @else
                                                Unseen
                                        @endif
                                    </td>
                                    <td>
                                        <a title="View" href="{{ route('notification.show',$aRow->id) }}"><i class="material-icons">remove_red_eye</i></a>
                                        <a href="{{ route('notification.update',$aRow->id) }}"><i class="material-icons">edit</i></a>
                                        <a href="javascript:void(0);" onclick="jQuery(this).parent('td').find('#delete-form').submit();"><i class="material-icons">delete</i>
                                        </a>
                                        <form id="delete-form" onsubmit="return confirm('Are you sure to delete?');" action="{{ route('notification.destroy',$aRow->id) }}" method="post" style="display: none;">
                                           {{ method_field('DELETE') }}
                                           {{ csrf_field() }}

                                        </form>
                                    </td>
                                </tr>
                                @endif
                                 @endforeach
                            </tbody>
                        </table>
                        @else
                        No data found
                        @endif
                    </div>
        </div>
    </div>
</div> --}}

@endsection
