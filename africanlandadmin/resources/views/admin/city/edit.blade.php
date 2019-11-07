@extends('admin.layouts.app')

@php
    $page_name = "Edit City"
@endphp

@section('title') {{$page_name}} @endsection

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
                            <div class="col-lg-6">
                                <form method="POST"  action="{{ route('city.update',$aRow->id) }}">
                                    @csrf
                                    @method('PUT')

                                    <label for="name">{{ __('Country') }}</label>

                                    <div class="form-group"> 
                                        {{ Form::select('country_id', ['' =>'Please Select'] + $aCountries, $aRow->country_id , ['class' => 'form-control show-tick', 'required' => 'required']) }}
                                    </div>

                                    <label for="name">{{ __('Name') }}</label>
                                    <div class="form-group">                               
                                       
                                        <input type="text" id="name" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $aRow->name }}" required placeholder="Name">

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                                                
                                    <button type="submir" class="btn btn-raised btn-primary btn-round waves-effect">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
        </div>
    </div>
</div>

@endsection
