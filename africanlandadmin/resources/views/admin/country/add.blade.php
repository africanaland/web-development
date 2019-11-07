@extends('admin.layouts.app')
z
@php
    $page_name = $aRow ? "Edit Country" : "Add Country"
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

            </div>
            <div class="body table-responsive">
                        <div class="row clearfix">
                            <div class="col-lg-6">
                                @if($aRow)
                            <form method="POST"  action="{{ route('country.update',$aRow->id) }}" enctype="multipart/form-data">
                            @method('PUT')
                            @else
                            <form method="POST"  action="{{ route('country.store') }}" enctype="multipart/form-data">
                            @endif


                                    @csrf
                                    <label for="name">{{ __('Name') }}</label>
                                    <div class="form-group">

                                        <input type="text" id="name" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $aRow ? $aRow->name : old('name') }}" required placeholder="Name">

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>

{{--
                                    <label for="name">{{ __('African') }}</label>
                                    <div class="form-group">
                                        <input type="radio" name="is_african"  value="1" required
                                        @if($aRow && $aRow->is_african == 1) checked="" @endif >&nbsp; Yes  &nbsp;&nbsp;
                                        <input type="radio" name="is_african"  value="0" required
                                        @if($aRow && $aRow->is_african == 0) checked="" @endif >&nbsp; No
                                    </div>

--}}


                                    <button type="submir" class="btn btn-raised btn-primary btn-round waves-effect">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
        </div>
    </div>
</div>

@endsection
