@extends('admin.layouts.app')

@php
    $page_name = "Host Requests"
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
                
            </div>
            <div class="body table-responsive">
                        @include('admin.layouts.search')
                        @if(count($aRows))                       
                        <table class="table table-bordered table-striped js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Host Type</th>
                                    <th>Name</th>
                                    <th>Country</th>
                                    <th>City</th>                                                          
                                    <th>Request Date</th>
                                    <th>Status</th>
                                    <th>Action</th>  
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aRows as $aKey => $aRow)
                                <tr>
                                    <th scope="row">{{ $aKey+1 }}</th>
                                    <td>{{$aRow->role['name']}}</td>
                                    <td>{{$aRow->fname}} {{$aRow->lname}}</td>
                                    <td>
                                        @if (!empty($aRow->country_name['name']))
                                            {{$aRow->country_name['name']}}
                                        @else
                                            {{$aRow->country2}}
                                        @endif
                                    </td>
                                    <td>
                                        @if (!empty($aRow->city_name['name']))
                                            {{$aRow->city_name['name']}}
                                        @else
                                            {{$aRow->city2}}
                                        @endif
                                    </td>
                                    <td>{{ date("d-m-Y",strtotime($aRow->created_at)) }}</td>
                                    <td>
                                        @if($aRow->status == 1) 
                                            <span class="badge badge-success">Replied</span>
                                        @else 
                                            <span class="badge badge-danger">Pending</span>
                                        @endif</td>
                                    <td>
                                        <a title="View" href="{{ route('hostshow',$aRow->id) }}"><i class="material-icons">remove_red_eye</i></a>
                                        <a href="{{ route('hostreply',$aRow->id)}}" title="@if($aRow->status == 1) View Reply @else Send Reply  @endif"><i class="material-icons">reply</i></a>
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

