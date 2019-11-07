@extends('admin.layouts.app')

@php
    $page_name = "Countries"
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
                            <li><a href="{{ route('country.create') }}">Create Country</a></li> 
                            <li><a href="{{ route('city.create') }}">Create City</a></li>                             
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
                                    <th>Country Name</th>   
                                    <!-- <th>African</th> --> 
                                    <th>City Number</th>
                                    <th>Hotel Apartments</th>
                                    <th>Individuals</th>
                                    <th>Hotels</th>
                                    <th>Status</th>                            
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aRows as $aKey => $aRow)
                                <tr>
                                    <th scope="row">{{ $aKey+1 }}</th>
                                    <td>{{$aRow->name}}</td>
                                    {{-- <td>@if($aRow->is_african == 1) Yes @else No @endif</td> --}}
                                    <td>{{  App\Country::count_city($aRow->id) }}</td>
                                    <td>{{  App\Country::count_host($aRow->id,0, App\User::ROLE_HOST_COMPANY) }}</td>
                                    <td>{{  App\Country::count_host($aRow->id,0, App\User::ROLE_HOST_INDIVIDUAL) }}</td>
                                    <td>{{  App\Country::count_host($aRow->id,0, App\User::ROLE_HOTEL) }}</td>
                                    <td>
                                        @if( $aRow->status == 1 )
                                            <a class="btn btn-sm btn-success" href="{{ route('countrytatus',['country_id' => $aRow->id, 'status' =>0]) }}" onclick="return confirm('Are you sure?');">Active</a>
                                            
                                        @else
                                        <a class="btn btn-sm btn-danger" href="{{ route('countrytatus',['country_id' => $aRow->id, 'status' =>1]) }}" onclick="return confirm('Are you sure?');">Inactive</a>
                                            
                                        @endif
                                    </td>    
                                    <td>
                                        <a href="{{ route('country.edit',$aRow->id) }}"><i class="material-icons">edit</i></a>
                                        <a href="javascript:void(0);" onclick="jQuery(this).parent('td').find('#delete-form').submit();"><i class="material-icons">delete</i>
                                        </a>
                                        <form id="delete-form" onsubmit="return confirm('Are you sure to delete?');" action="{{ route('country.destroy',$aRow->id) }}" method="post" style="display: none;">
                                           {{ method_field('DELETE') }}
                                           {{ csrf_field() }}
                                               
                                        </form>

                                        <a href="{{ route('country.index','country='.$aRow->id ) }}" title="view city">
                                           <i class="zmdi zmdi-eye"></i> <!--  <i class="material-icons">location_city</i>-->
                                        </a>

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
