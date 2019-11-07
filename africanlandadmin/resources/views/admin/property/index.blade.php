@extends('admin.layouts.app')

@php
    $page_name = "Properties"
@endphp

@section('title') {{ $page_name }} @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="javascript:void(0);"> {{ $page_name }}</a></li>
@endsection

@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            @if ($adminLogin || $hostLogin)                
            <div class="header">
                <h2> {{ $page_name }}</h2>                        
                <ul class="header-dropdown">
                    <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="{{ route('property.create') }}">Create</a></li>                            
                        </ul>
                    </li>
                </ul>
            </div>
            @endif
            <div class="body table-responsive">
                        @include('admin.layouts.search')
                        @if(count($aRows))                       
                        <table class="table table-bordered table-striped js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th>#</th>                                                   
                                    <th>Name</th>
                                    <th>Hosts</th>
                                    <th>Host By</th>
                                    <th>Rating</th>
                                    <th>Status</th>  
                                                          
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aRows as $aKey => $aRow)
                                <tr>
                                    <th scope="row">{{ $aKey+1 }}</th>                                                         
                                    <td>{{$aRow->name}}</td>
                                    <td>{{$aRow->host_detail['fname']}} {{$aRow->host_detail['lname']}}</td>
                                    <td>{{ App\Role::getRolename($aRow->host_type,'name') }}</td>      
                                    <td>
                                        <div class="ratings">
                                            <div class="empty-stars"></div>
                                            <div class="full-stars" style="width:{{\App\Review::ratings($aRow->id )}}%"></div>
                                        </div>
                                    </td>                                                          
                                    <td>
                                       @if( $aRow->status == 1 )
                                            <a class="btn btn-sm btn-success" href="{{ route('propertystatus',['property_id' => $aRow->id, 'status' =>0]) }}" onclick="return confirm('Are you sure?');">Active</a>
                                            
                                        @else
                                        <a class="btn btn-sm btn-danger" href="{{ route('propertystatus',['property_id' => $aRow->id, 'status' =>1]) }}" onclick="return confirm('Are you sure?');">Inactive</a>
                                            
                                        @endif
                                    </td>
                          
                                    <td>
                                        <a title="View" href="{{ route('property.show',$aRow->id) }}"><i class="material-icons">remove_red_eye</i></a>
                                        @if($aRow->user_id == Auth::guard('admin')->user()->id || $adminLogin)
                                        <a href="{{ route('property.edit',$aRow->id) }}"><i class="material-icons">edit</i></a>
                                        <a href="javascript:void(0);" onclick="jQuery(this).parent('td').find('#delete-form').submit();"><i class="material-icons">delete</i>
                                        </a>
                                        <form id="delete-form" onsubmit="return confirm('Are you sure to delete?');" 
                                        action="{{ route('property.destroy',$aRow->id) }}" method="post" style="display: none;">
                                           {{ method_field('DELETE') }}
                                           {{ csrf_field() }}
                                               
                                        </form>
                                        @endif

                                        {{-- <a title="Property Gallery" href="{{ route('propertygallery',$aRow->id) }}"><i class="material-icons">perm_media</i></a> --}}
                                        

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
