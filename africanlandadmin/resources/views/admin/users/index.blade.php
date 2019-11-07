@extends('admin.layouts.app')

@php
    $page_name = $pageName;
@endphp

@section('title') {{ $page_name }} @endsection

@inject('userMembership', 'App\Membership')


@section('breadcrumb')
    <li class="breadcrumb-item"><a href="javascript:void(0);"> {{ $page_name }}</a></li>
@endsection
@php
    $url_segment = Request::segment(2);
@endphp
@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2> {{ $page_name }}</h2>
                <ul class="header-dropdown">
                    <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="{{ route('usercreate',$type) }}">Create</a></li>                            
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body table-responsive">
                @include('admin.layouts.search')
                @if(count($aRows))                       
                <table class="table table-bordered table-striped js-basic-example dataTable">
                    <thead>
                        <tr>
                            <th>#</th>                                 
                            <th>Role</th>
                            <th>Username</th>
                            <th>Name</th>
                            @if ($url_segment)
                            <th>Agreement</th>                                    
                            @else
                            <th>MembershipId</th>
                            @endif
                            <th>Status</th>                                                                
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($aRows as $aKey => $aRow)
                        <tr>
                            <th scope="row">{{ $aKey+1 }}</th>
                            {{-- <td><img src="{{  App\Helpers\CustomHelper::displayImage($aRow->image) }}" height="30px" width="30px" ></td>    --}}                                
                            <td>{{$aRow->role['name']}}</td>
                            <td>{{$aRow->username}}</td>
                            <td>{{$aRow->fname}} {{$aRow->lname}}</td>
                            @if ($url_segment)
                            <td>
                                @if ($aRow->agreement == 2)
                                    <span class="badge badge-success">{{"Accept"}}</span>
                                @else
                                    <span class="badge badge-warning">{{"Not Accept"}}</span>
                                @endif
                            </td>
                            @else
                            @php $data1 = $userMembership->getMembershipData($aRow->membership_id,array('name')) @endphp
                            <td>{{ $data1[0]->name }}</td>
                            @endif
                            <td>
                                @if( $aRow->status == 1 )
                                    <a class="btn btn-sm btn-success" href="{{ route('userstatus',['user_id' => $aRow->id, 'status' =>0]) }}" onclick="return confirm('Are you sure?');">Active</a>
                                    
                                @else
                                <a class="btn btn-sm btn-danger" href="{{ route('userstatus',['user_id' => $aRow->id, 'status' =>1]) }}" onclick="return confirm('Are you sure?');">Inactive</a>
                                    
                                @endif
                            </td>                                   
                            <td>
                                <a title="View" href="{{ route('users.show',$aRow->id) }}"><i class="material-icons">remove_red_eye</i></a>
                                <a title="Edit" href="{{ route('users.edit',$aRow->id) }}"><i class="material-icons">edit</i></a>
                                <a title="Delete" href="javascript:void(0);" onclick="jQuery(this).parent('td').find('#delete-form').submit();"><i class="material-icons">delete</i>
                                </a>
                                <form id="delete-form" onsubmit="return confirm('Are you sure to delete?');" 
                                action="{{ route('users.destroy',$aRow->id) }}" method="post" style="display: none;">
                                   {{ method_field('DELETE') }}
                                   {{ csrf_field() }}
                                       
                                </form>
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
