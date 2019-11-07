@extends('admin.layouts.app')

@php
    $page_name = $aRow ? "Edit Membership" : "Add Membership"
@endphp

@section('title') {{ $page_name }} @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="javascript:void(0);">{{ $page_name }}</a></li>
@endsection

@section('content')

<script>
    var getcityurl = '{{ route("getcity") }}';
</script>

<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2>{{ $page_name }}</h2>                        
                
            </div>
            <div class="body table-responsive">                       

                            @if($aRow)
                            <form method="POST"  action="{{ route('memberships.update',$aRow->id) }}" enctype="multipart/form-data">
                            @method('PUT')
                            @else
                            <form method="POST"  action="{{ route('memberships.store') }}" enctype="multipart/form-data">
                            @endif                           
                            
                                                               
                            @csrf

                               

                            <div class="row clearfix">
                                <div class="col-lg-6">
                                     <label for="name">{{ __('Name') }}</label>
                                    <div class="form-group">                          
                                        <input type="text" id="name" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $aRow ? $aRow->name : old('fname') }}" required placeholder="Name">
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div> 

                            <div class="row clearfix">
                                 <div class="col-lg-12">
                                    <label for="">{{ __('Description') }}</label>
                                    <div class="form-group">  
                                    <textarea style="height: 300px;" id="description" name="description" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}">
                                            {{ $aRow ? $aRow->description : old('description') }}
                                    </textarea>                   
                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                    </div>

                                </div>
                             </div>

                             <div class="row clearfix">
                                <div class="col-lg-6">
                                    <label for="name">{{ __('No of bookings') }}</label>
                                    <div class="form-group">                          
                                        <input type="number" id="no_bookings" name="no_bookings" class="form-control{{ $errors->has('no_bookings') ? ' is-invalid' : '' }}" value="{{ $aRow ? $aRow->no_bookings : old('no_bookings') }}" required min="0" @if($aRow)  @endif >
                                        @if ($errors->has('no_bookings'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('no_bookings') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>                                                                 
                             </div>


                             <div class="row clearfix">
                                <div class="col-lg-6">

                                    <label for="name">{{ __('Status') }}</label>
                                    <div class="form-group">                          
                                         {{ Form::select('status', ['' =>'Please Select','1' => 'Active','0' => 'Inactive'], $aRow ? $aRow->status : null , ['class' => 'form-control show-tick', 'required' => 'required']) }}
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

@endsection
