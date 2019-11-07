@extends('admin.layouts.app')
@php $page_name = "Settings" @endphp
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
<form method="POST"  action="" enctype="multipart/form-data">
@csrf
<div class="row clearfix">                               
    <div class="col-lg-6">
        <label for="name">{{ __('Site Title') }}</label>
        <div class="form-group">                          
        <input type="text" name="val[site_title]" class="form-control" placeholder="Site Title"
         value="{{  old('site_title') ? old('site_title') : @$aSettings['site_title'] }}" >
        </div>
    </div>
</div> 

<div class="row clearfix">                               
        <div class="col-lg-6">
            <label for="name">{{ __('Site MObile No.') }}</label>
            <div class="form-group">                          
            <input type="text" name="val[site_phone]" class="form-control" placeholder="Site Mobile no"
             value="{{  old('site_phone') ? old('site_phone') : @$aSettings['site_phone'] }}" >
            </div>
        </div>
        <div class="col-lg-6">
            <label for="name">{{ __('Site Email') }}</label>
            <div class="form-group">                          
            <input type="text" name="val[site_email]" class="form-control" placeholder="Site Email"
             value="{{  old('site_email') ? old('site_email') : @$aSettings['site_email'] }}" >
            </div>
        </div>
    </div> 
    

<div class="row clearfix">                               
    <div class="col-lg-12">
        <label for="name">{{ __('Profile') }}</label>
        <div class="form-group">                          
        <textarea id="details" name="val[site_profile]" class="form-control" >{{  old('site_profile') ? old('site_profile') : @$aSettings['site_profile'] }}</textarea> 
        </div>
    </div>
</div> 

<div class="row clearfix">                               
    <div class="col-lg-6">
        <label for="name">{{ __('Facebook Link') }}</label>
        <div class="form-group">                          
        <input type="url" name="val[facebook_link]" class="form-control" value="{{  old('facebook_link') ? old('facebook_link') : @$aSettings['facebook_link'] }}"  placeholder="Site Title">
        </div>
    </div>
    <div class="col-lg-6">
        <label for="name">{{ __('Twitter Link') }}</label>
        <div class="form-group">                          
        <input type="url" name="val[twitter_link]" class="form-control" value="{{  old('twitter_link') ? old('twitter_link') : @$aSettings['twitter_link'] }}"  placeholder="Site Title">
        </div>
    </div>
</div> 

<div class="row clearfix">                               
    <div class="col-lg-6">
        <label for="name">{{ __('Instagram Link') }}</label>
        <div class="form-group">                          
        <input type="url" name="val[instagram_link]" class="form-control" value="{{  old('instagram_link') ? old('instagram_link') : @$aSettings['instagram_link'] }}" placeholder="Site Title">
        </div>
    </div>
</div> 


<div class="row clearfix">
    <div class="col-lg-6">
        <label for="name">{{ __('Site Logo') }}</label>
        <div class="form-group">                          
            <input type="file" name="site_logo" class="form-control"  >
        </div>
        @if (isset($aSettings['site_logo']))
            <img src="{{  App\Helpers\CustomHelper::displayImage($aSettings['site_logo']) }}" width="100px" >
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
