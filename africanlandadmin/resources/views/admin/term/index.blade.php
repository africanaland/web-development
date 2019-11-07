@extends('admin.layouts.app')

@php
    $page_name = "Term & Conditions"
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
                <ul class="header-dropdown">
                    <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="{{ route('term.create') }}">Create</a></li>                            
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body table-responsive">
                        @if(count($aRows))                       
                        <table class="table m-b-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>                          
                                    <th>Name</th>                                     
                                    <th>Date Added</th>                            
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aRows as $aKey => $aRow)
                                <tr>
                                    <th scope="row">{{ $aKey+1 }}</th>
                                    <td>
                                        @if ($aRow->image)
                                        <img src="{{ asset('public/uploads/'.$aRow->image)  }}" height="30px" width="30px" >
                                        @else
                                        <img src="{{ asset('public/images/profile.png')  }}" height="30px" width="30px" >
                                        @endif
                                    </td>                         
                                    <td>{{$aRow->name}}</td>                                   
                                    {{--<td>
                                        @if( $aRow->status == 1 )
                                            <button class="btn btn-sm btn-success">Active</button>
                                        @else
                                            <button class="btn btn-sm btn-danger">Inactive</button>
                                        @endif
                                    </td>--}}   
                                    <td>{{ date("d/m/Y",strtotime($aRow->created_at)) }}</td>
                                    <td>
                                        <a href="{{ route('term.edit',$aRow->id) }}"><i class="material-icons">edit</i></a>
                                        <a href="javascript:void(0);" onclick="jQuery(this).parent('td').find('#delete-form').submit();"><i class="material-icons">delete</i>
                                        </a>
                                        <form id="delete-form" onsubmit="return confirm('Are you sure to delete?');" 
                                        action="{{ route('term.destroy',$aRow->id) }}" method="post" style="display: none;">
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
