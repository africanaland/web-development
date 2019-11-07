@extends('admin.layouts.app')

@php
    $page_name = $aRow ? "Edit Terms" : "Add Terms"
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

                            @if($aRow)
                            <form method="POST"  action="{{ route('term.update',$aRow->id) }}" enctype="multipart/form-data">
                            @method('PUT')
                            @else
                            <form method="POST"  action="{{ route('term.store') }}" enctype="multipart/form-data">
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

                             </div> 

                             

                            

                             <div class="row clearfix">
<div class="col-lg-12">
    <label for="name">{{ __('Details') }}</label>
    <div class="form-group"> 
        <textarea id="details" name="details" class="form-control{{ $errors->has('details') ? ' is-invalid' : '' }}" required >         {{ $aRow ? $aRow->details : old('details') }}   
        </textarea>   
        @if ($errors->has('details'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('details') }}</strong>
            </span>
        @endif                      
       
        
    </div>
</div>
                                 
</div>

                            


                           
                             <div class="row clearfix">
                               
                                
                                 <div class="col-lg-6">
                                    <label for="name">{{ __('Image') }}</label>
                                    <div class="form-group">                          
                                        <input type="file" id="image" name="image" class="form-control"  >
                                        @if ($errors->has('image'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('image') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    @if ($aRow && $aRow->image)
                                    <img src="{{ asset('public/uploads/'.$aRow->image)  }}" height="30px" width="30px" >
                                     @endif
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
