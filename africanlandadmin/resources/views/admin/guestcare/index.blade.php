@extends('admin.layouts.app')

@php
    $page_name = "Guestcare"
@endphp

@section('title') {{ $page_name }} @endsection
@inject('userObj', 'App\User')


@section('breadcrumb')
    <li class="breadcrumb-item"><a href="javascript:void(0);"> {{ $page_name }}</a></li>
@endsection

@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2> {{ $page_name }}</h2>                      
            </div>
            <div class="body table-responsive">



                       @include('admin.layouts.search') 
                        @if(count($aRows))                       
                        <table class="table table-bordered table-striped js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>Name</th>                    
                                    <th>Department</th>
                                    <th>Subject</th> 
                                    <th>Date</th>
                                    <th>Status</th>                                                                 
                                    <th>Solve by</th>                                                                 
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aRows as $aKey => $aRow)
                                <tr>
                                    <td scope="row">{{ $aKey+1 }}</td>   
                                    <td>{{$aRow->username }} </td>
                                    <td>{{$aRow->name }} </td>                       
                                    <td>{{$aRow->department }} </td> 
                                    <td>{{$aRow->subject }} </td>  
                                    <td> {{ date("d/m/Y",strtotime($aRow->created_at)) }} </td>
                                    <td>{{$aRow->status }} </td>                                        
                                    @if ($aRow->reply_by)
                                    @php $userdata = $userObj->getUserData($aRow->reply_by,array('username')) @endphp
                                    <td>{{$userdata->username}}</td>
                                    @else
                                    <td>{{"pending"}}</td>
                                    @endif
                                    <td class="text-center">                                        
                                        <a href="{{ route('guestcaredetail', $aRow->id)}}"><i class="zmdi zmdi-eye"></i></a>   
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
