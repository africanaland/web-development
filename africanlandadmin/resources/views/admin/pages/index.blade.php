@extends('admin.layouts.app')

@php
    $page_name = $aRow->title;
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
                            <form method="POST"  action="{{ route('pagepost',$aRow->page_name) }}" >
                            @csrf
                            <div class="row clearfix">
                                    <div class="col-lg-12">
                               
                                        <label for="name">{{ __('Page Description') }}</label>
                                        <div class="form-group">                               
                                            <textarea id="description" style="height: 800px;" name="description" class="ckeditor form-control" required>
                                                {{ $aRow ? $aRow->description : old('description') }}
                                            </textarea>                                                                
                                        </div> 
                                    </div>
                                </div>  

                                <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Update</button>
                            </form>
                            </div>
                        </div>
                    </div>
        </div>
    </div>
</div>

@endsection
