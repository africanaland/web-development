@extends('admin.layouts.app')

@php
    $page_name = $aRow ? "Edit Coupon" : "Add Coupon"
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
                        <div class="row clearfix">
                            <div class="col-lg-12">
                                @if($aRow)
                            <form method="POST"  action="{{ route('coupons.update',$aRow->id) }}" enctype="multipart/form-data">
                            @method('PUT')
                            @else
                            <form method="POST"  action="{{ route('coupons.store') }}" enctype="multipart/form-data">
                            @endif 

                                
                                @csrf

                                <div class="row clearfix">
<div class="col-lg-6">
    <label for="name">{{ __('Name') }}</label>
    <div class="form-group">
        <input type="text" id="name" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $aRow ? $aRow->name : old('name') }}" required placeholder="Name">
        @if ($errors->has('name'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
</div>
<div class="col-lg-6">
    <label for="name">{{ __('Code') }}</label>
    <div class="form-group">
        <input type="text" id="code" name="code" class="form-control{{ $errors->has('code') ? ' is-invalid' : '' }}" value="{{ $aRow ? $aRow->code : old('code') }}" required placeholder="Code">
        @if ($errors->has('code'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('code') }}</strong>
            </span>
        @endif
    </div>
</div>

</div>

                                <div class="row clearfix">
                                    <div class="col-lg-6">                                        
                                        <label for="start_date">{{ __('Start Date') }}</label>
                                        <div class="form-group">
                                            <input type="text" id="start_date" name="start_date" class="datetimepicker form-control{{ $errors->has('start_date') ? ' is-invalid' : '' }}" value="{{ $aRow ? date('Y-m-d', strtotime($aRow->start_date)) : old('start_date') }}" required placeholder="start date">
                                            @if ($errors->has('start_date'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('start_date') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="end_date">{{ __('End Date') }}</label>
                                        <div class="form-group">
                                            <input type="text" id="end_date" name="end_date" class="datetimepicker form-control{{ $errors->has('end_date') ? ' is-invalid' : '' }}" value="{{ $aRow ? date('Y-m-d', strtotime($aRow->end_date)) : old('end_date') }}" required placeholder="End Date">
                                            @if ($errors->has('end_date'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('end_date') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                 <div class="row clearfix">
                                    <div class="col-lg-6">
                               
                                        <label for="name">{{ __('Discount') }}</label>
                                        <div class="form-group">  

                                            <input type="text" id="discount" name="discount" class="form-control{{ $errors->has('discount') ? ' is-invalid' : '' }}" value="{{ $aRow ? $aRow->discount : old('discount') }}" required placeholder="Discount">         
                                           @if ($errors->has('discount'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('discount') }}</strong>
                                                </span>
                                            @endif                                                        
                                        </div> 
                                    </div>
                                </div>  





                                <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Save</button>
                            </form>
                            </div>
                        </div>
                    </div>
        </div>
    </div>
</div>

@endsection
