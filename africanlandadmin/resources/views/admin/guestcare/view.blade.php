@extends('admin.layouts.app')

@php
    $page_name = "Guestcare Details"
@endphp
@inject('userObj', 'App\User')

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
            </div>
            <div class="body table-responsive">
                @if(count((array)$aRow))
                <form method="POST"  action="{{ route('postguestcaredetail',$aRow->id) }}">
                    @csrf
                    <table class="table m-b-0">
                        <tbody>
                            <tr><th width="150px;">Id</th><td style="border-top: none;">#{{$aRow->id}}</td></tr>
                            <tr><th>Username</th><td>{{$aRow->username }}</td></tr>
                            <tr><th>Name</th><td>{{$aRow->name }}</td></tr>
                            <tr><th>Department</th><td>{{$aRow->department }}</td></tr>
                            <tr><th>Subject</th><td>{{$aRow->subject }}</td></tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($aRow->status == "Waiting")
                                    {{ Form::select('status', ['' =>'Please Select',"Waiting" => "Waiting", "Solved" => "Solved","Rejected" => "Rejected"] ,  $aRow ? $aRow->status : old('status') , ['class' => 'form-control', 'required' => 'required']) }}
                                    @else
                                    {{$aRow->status }}
                                    @endif

                                </td>
                            </tr>

                            @if ($aRow->reply_by)
                            @php $userdata = $userObj->getUserData($aRow->reply_by,array('username')) @endphp
                            <tr>
                                <th>Reply By</th>
                                <td>{{$userdata->username ?? "pending"}}</td>
                            </tr>
                            @endif

                            <tr><th>Message</th><td>{{$aRow->message }}</td></tr>
                            <tr>
                                <th valign="top">Reply</th>
                                <td>
                                    @if($aRow->status == "Waiting")
                                    <textarea id="reply" name="reply" class="form-control" required >
                                             {{ $aRow ? $aRow->reply : old('reply') }}
                                    </textarea>
                                    <br>
                                    <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Save</button>
                                    @else
                                    {{$aRow->reply }}
                                    @endif

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                @else
                No data found
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
