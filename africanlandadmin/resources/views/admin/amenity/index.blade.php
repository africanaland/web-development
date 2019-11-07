@extends('admin.layouts.app')

@php
    $page_name = "Amenity"
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
                    <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="{{ route('amenity.create') }}">Create</a></li>                            
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
                                    <th>Name</th> 
                                    <th>Image</th>                            
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aRows as $aKey => $aRow)
                                <tr>
                                    <th scope="row">{{ $aKey+1 }}</th>
                                    <td>{{$aRow->name}}</td>
                                    <td>                                    
                                        <img src="{{  App\Helpers\CustomHelper::displayImage($aRow->image) }}" height="30px" width="30px" >                                       
                                    </td> 
                                    <td>
                                        @if(Auth::guard('admin')->user()->id == $aRow->creator_id)
                                        <a href="{{ route('amenity.edit',$aRow->id) }}"><i class="material-icons">edit</i></a>
                                        <a href="javascript:void(0);" onclick="jQuery(this).parent('td').find('#delete-form').submit();"><i class="material-icons">delete</i>
                                        </a>
                                        <form id="delete-form" onsubmit="return confirm('Are you sure to delete?');" action="{{ route('amenity.destroy',$aRow->id) }}" method="post" style="display: none;">
                                           {{ method_field('DELETE') }}
                                           {{ csrf_field() }} 
                                        </form>
                                        @endif
                                   

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
