@extends('admin.layouts.app')

@php
$page_name = $aRow ? "Edit Notification" : "Add Notification"
@endphp

@section('title') {{ $page_name }} @endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="javascript:void(0);">{{ $page_name }}</a></li>
@endsection
<script>
    var getDataUrl = '{{ route('getname')}}';
</script>
    
@section('content')

<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2>{{ $page_name }}</h2>

            </div>
            <div class="body table-responsive">
                <div class="row clearfix">
                    <div class="col-lg-6">
                        @if($aRow)
                        <form method="POST" action="{{ route('notification.update',$aRow->id) }}" enctype="multipart/form-data">
                            @method('PUT')
                            @else
                            <form method="POST" action="{{ route('notification.store') }}" enctype="multipart/form-data">
                                @endif
                                {{ csrf_field() }}
                                @if(empty($aRow))
                                <label for="user">{{ __('Select User Type') }}</label>

                                <div class="form-group">
                                    <select name="roleId" id="getData" class="form-control ms" data-value="userName" required>
                                        <option value="" selected>-----select-----</option>
                                        @foreach ($userRoll as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('user'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('user') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <label for="user">{{ __('Select User') }}</label>
                                <div class="form-group">
                                    <select name="user" id="userName" class="form-control ms {{ $errors->has('type') ? ' is-invalid' : '' }}" required>
                                        <option value="" selected>-----select-----</option>
                                        <option value="0">To BroadCast</option>
                                    </select>
                                    @if ($errors->has('user'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('user') }}</strong>
                                    </span>
                                    @endif
                                </div>


                            @else
                            <label for="name">{{ __('User Name') }}</label>
                            <div class="form-group">
                                <input type="text" readonly class="form-control" value="{{ $aRow ? $aRow->user['fname'] : old('title') }}" placeholder="Add Title">
                            </div>
                            @endif


                                <label for="title">{{ __('Title') }}</label>
                                <div class="form-group">

                                    <input type="text" id="title" name="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ $aRow ? $aRow->title : old('title') }}" required placeholder="Add Title">

                                    @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <label for="message">{{ __('Message') }}</label>
                                <div class="form-group">

                                    <textarea id="message" rows="5" name="message" class="form-control{{ $errors->has('message') ? ' is-invalid' : '' }}" required placeholder="Add Message">{{ $aRow ? $aRow->detail : old('message') }}</textarea>

                                    @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <label for="urlCheck">{{ __('Click to Add BroadCast Date') }}</label>
                                <div class="d-flex" style='height:20px'>
                                    <div>
                                        <input type="checkbox" name="addData" value="addData" id="clickShow" class="mr-3">
                                    </div>
                                    <div class="form-group w-100" id="castDate" style="display:none">    
                                        <input type="text" id="castDate" name="castDate" class="datetimepicker form-control{{ $errors->has('castDate') ? ' is-invalid' : '' }}" value="{{ $aRow ? $aRow->castDate : old('castDate') }}"  placeholder="DD/MM/YYYY" data-dtp="dtp_4Hwzl">
                                        @if ($errors->has('castDate'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('castDate') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                </div>



                                <br><br>

                                <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Save</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
