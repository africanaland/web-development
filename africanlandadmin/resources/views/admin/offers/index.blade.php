@extends('admin.layouts.app')

@php
    $page_name = "Offers"
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
                {{-- <ul class="header-dropdown">
                    <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="{{ route('offers.create') }}">Create</a></li>                            
                        </ul>
                    </li>
                </ul> --}}
            </div>
            <div class="body table-responsive">
                @include('admin.layouts.search')
                        @if(count($aRows))                       
                        <table class="table table-bordered table-striped js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>  
                                    <th>Membership Type</th>  
                                    <th>Offer Start Date</th> 
                                    <th>Offer End Date</th>                             
                                    @if ($adminLogin)
                                    <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($aRows as $aKey => $aRow)
                                <tr>
                                    <th scope="row">{{ $aKey+1 }}</th>
                                    <td>{{$aRow->name}}</td>
                                    <td>{{ $aRow->membership['name'] }}</td>
                                    <td>{{ date('d/m/Y',strtotime($aRow->start_date)) }}</td>
                                    <td>{{ date('d/m/Y',strtotime($aRow->end_date)) }}</td>
                                    @if ($adminLogin)
                                    <td>
                                        <a title="View" href="{{ route('offers.show',$aRow->id) }}"><i class="material-icons">remove_red_eye</i></a>
                                        
                                        <a href="{{ route('offers.edit',$aRow->id) }}"><i class="material-icons">edit</i></a>
                                        <a href="javascript:void(0);" onclick="jQuery(this).parent('td').find('#delete-form').submit();"><i class="material-icons">delete</i>
                                        </a>
                                        <form id="delete-form" onsubmit="return confirm('Are you sure to delete?');" action="{{ route('offers.destroy',$aRow->id) }}" method="post" style="display: none;">
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

@endsection
