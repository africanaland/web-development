@extends('admin.layouts.app')

@php
    $page_name = $aRow ? "Edit Offer" : "Add Offer"
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
                <h2>{{$page_name}}</h2>                        
                
            </div>
            <div class="body table-responsive">
                        <div class="row clearfix">
                            <div class="col-lg-12">
                                @if($aRow)
                            <form method="POST"  action="{{ route('offers.update',$aRow->id) }}" enctype="multipart/form-data">
                            @method('PUT')
                            @else
                            <form method="POST"  action="{{ route('offers.store') }}" enctype="multipart/form-data">
                            @endif 

                                
                                @csrf

                                <div class="row clearfix">
                                    <div class="col-lg-6">
                                        <label for="name">{{ __('Membership Type') }}</label>
                                        <div class="form-group">
                                            {{ Form::select('membership_id', ['' =>'Please Select'] + $aMemberships, $aRow ? $aRow->membership_id : null , ['class' => 'form-control ms', 'required' => 'required']) }}
                                        </div>
                                    </div>
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
                                    <div class="col-lg-8">
                                        <label for="name">{{ __('Image') }}</label>
                                        <div class="form-group d-flex">                          
                                            <input type="file" id="image" name="image" class="form-control w-50"  style="height:50px">
                                            @if ($errors->has('image'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('image') }}</strong>
                                                </span>
                                            @endif
                                            <div>
                                                @if ($aRow && $aRow->image)
                                                <img src="{{  App\Helpers\CustomHelper::displayImage($aRow->image) }}" height="100px" width="100px" >
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
       

                                 <div class="row clearfix">
                                    <div class="col-lg-12">
                               
                                        <label for="name">{{ __('Description') }}</label>
                                        <div class="form-group">                               
                                            <textarea id="description" name="description" class="ckeditor form-control" required>
                                                {{ $aRow ? $aRow->description : old('description') }}
                                            </textarea>                                                                
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
