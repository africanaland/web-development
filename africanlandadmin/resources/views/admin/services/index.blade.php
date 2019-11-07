@extends('admin.layouts.app')

@php
    $page_name = "Additional Services"
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
                            <li><a href="{{ route('services.create') }}">Create</a></li>                            
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
                                    <th>Price Type</th>  
                                    <th>Price</th>                             
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
                                    <td>@if($aRow->type == "calculable") Per/hour  @else {{ ucfirst($aRow->type) }} @endif</td>
                                    <td>{{$aRow->price}}</td>
                                    <td>
                                        <a title="View" href="{{ route('services.show',$aRow->id) }}"><i class="material-icons">remove_red_eye</i></a>
                                        @if(Auth::guard('admin')->user()->id == $aRow->creator_id)
                                        <a href="{{ route('services.edit',$aRow->id) }}"><i class="material-icons">edit</i></a>
                                        <a href="javascript:void(0);" onclick="jQuery(this).parent('td').find('#delete-form').submit();"><i class="material-icons">delete</i>
                                        </a>
                                        <form id="delete-form" onsubmit="return confirm('Are you sure to delete?');" action="{{ route('services.destroy',$aRow->id) }}" method="post" style="display: none;">
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
