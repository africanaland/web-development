@extends('admin.layouts.app')

@php
    $page_name = "Memberships"
@endphp

@section('title') {{ $page_name }} @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="javascript:void(0);"> {{ $page_name }}</a></li>
@endsection

@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2> {{ $page_name }}</h2>  
                {{--                      
                <ul class="header-dropdown">
                    <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="{{ route('memberships.create') }}">Create</a></li>                            
                        </ul>
                    </li>
                </ul> --}}
            </div>
            <div class="body table-responsive">
                        @if(count($aRows))                       
                        <table class="table table-bordered table-striped js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>No of bookings</th> 
                                    <th>Default</th>                           
                                    {{--<th>Status</th>--}} 
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aRows as $aKey => $aRow)
                                <tr>
                                    <th scope="row">{{ $aKey+1 }}</th>                                    
                                    <td>{{$aRow->name}}</td>
                                    <td>{{$aRow->no_bookings}}</td> 
                                    <td>
                                        @if( $aRow->is_default == 1 )
                                            <span class="badge badge-success">Default</span></td>
                                        @else 
                                            <a class="btn btn-sm btn-danger" href="{{ route('makedefault',['membership_id' => $aRow->id]) }}" onclick="return confirm('Are you sure?');">Make Default</a>
                            
                                        @endif            
                                    {{--<td>
                                        @if( $aRow->status == 1 )
                                            <button class="btn btn-sm btn-success">Active</button>
                                        @else
                                            
                                        @endif
                                    </td>  --}}                 
                                    <td>
                                        <a title="View" href="{{ route('memberships.show',$aRow->id) }}"><i class="material-icons">remove_red_eye</i></a>
                                        <a href="{{ route('memberships.edit',$aRow->id) }}"><i class="material-icons">edit</i></a>
                                       {{-- <a href="javascript:void(0);" onclick="jQuery(this).parent('td').find('#delete-form').submit();"><i class="material-icons">delete</i>
                                        </a>
                                        <form id="delete-form" onsubmit="return confirm('Are you sure to delete?');" 
                                        action="{{ route('memberships.destroy',$aRow->id) }}" method="post" style="display: none;">
                                           {{ method_field('DELETE') }}
                                           {{ csrf_field() }}
                                               
                                        </form>--}}
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
