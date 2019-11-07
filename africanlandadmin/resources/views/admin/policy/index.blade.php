@extends('admin.layouts.app')

@php
    $page_name = "Agreements"
@endphp

@section('title') {{ $page_name }} @endsection
@inject('userRole', 'App\Role')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="javascript:void(0);"> {{ $page_name }}</a></li>
@endsection

@section('content')

<div class="overlay"></div>

<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2> {{ $page_name }}</h2>
                @if($aUser->role_id == 1 || $aUser->role_id == 2 )                        
                <ul class="header-dropdown">
                    <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="{{ route('policy.create') }}">Create</a></li>                            
                        </ul>
                    </li>
                </ul>
                @endif
            </div>
            <div class="body table-responsive">
                        @if(count($aRows))                       
                        <table class="table m-b-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User Type</th>                          
                                    <th>Policy name</th>
                                    <th>Date Added</th>                            
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aRows as $aKey => $aRow)
                                <tr>
                                    <th scope="row">{{ $aKey+1 }}</th>
                                    @php
                                        $roledata = $userRole->getRolename($aRow->role_id,'name');
                                    @endphp
                                    <td>{{ $roledata }}</td>
                                    <td>{{ $aRow->type }}</td>                                   
                                    {{--<td>
                                        @if( $aRow->status == 1 )
                                            <button class="btn btn-sm btn-success">Active</button>
                                        @else
                                            <button class="btn btn-sm btn-danger">Inactive</button>
                                        @endif
                                    </td>--}}   
                                    <td>{{ date("d/m/Y",strtotime($aRow->created_at)) }}</td>
                                    <td> 
                                        {{-- <a href="#policyModal{{ $aRow->id }}" data-toggle="modal" title="View Policy" data-target="#policyModal{{ $aRow->id }}"><i class="material-icons">remove_red_eye</i> </a> --}}
                                        <a href="{{ route('policy.edit',$aRow->id) }}"><i class="material-icons">edit</i></a>
                                        <a href="javascript:void(0);" onclick="jQuery(this).parent('td').find('#delete-form').submit();"><i class="material-icons">delete</i>
                                        </a>
                                        <form id="delete-form" onsubmit="return confirm('Are you sure to delete?');" 
                                        action="{{ route('policy.destroy',$aRow->id) }}" method="post" style="display: none;">
                                           {{ method_field('DELETE') }}
                                           {{ csrf_field() }}
                                               
                                        </form>
                                        {{-- <div class="modal fade" id="policyModal{{ $aRow->id }}" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="title" id="defaultModalLabel">{{$aRow->type}}</h4>
                                                    </div>
                                                    <div class="modal-body"> 
                                                        {!! $aRow->details !!}
                                                    </div>
                                                    <div class="modal-footer">               
                                                        <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
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
<style type="text/css">
    .modal-backdrop
    {
        z-index: 1!important;
    }
</style>
@endsection

