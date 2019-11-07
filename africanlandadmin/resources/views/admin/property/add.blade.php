@extends('admin.layouts.app')

@php
    $page_name = $aRow ? "Edit Property" : "Add Property"
@endphp

@section('title') {{ $page_name }} @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="javascript:void(0);">{{ $page_name }}</a></li>
@endsection

@section('content')

<script>
    var getcityurl = '{{ route("getcity") }}';
    var getsubtypeurl = '{{ route("getsubtype") }}';
    var gethostlistsurl = '{{ route("gethostlists") }}';
    var gethosttypeurl = '{{ route("gethosttype") }}';

</script>

<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2>{{ $page_name }}</h2>                        
                
            </div>
            <div class="body table-responsive">                       

                            @if($aRow)
                            <form method="POST"  action="{{ route('property.update',$aRow->id) }}" enctype="multipart/form-data">
                            @method('PUT')
                            @else
                            <form method="POST"  action="{{ route('property.store') }}" enctype="multipart/form-data">
                            @endif                                                         
                            @csrf
                            <div class="row clearfix">
                            @if($hostLogin)
                                <input type="hidden" name="country" value="{{ $aCountries }}">
                                <input type="hidden" name="city" value="{{ $aCities }}">
                                <input type="hidden" name="host_name" value="{{ $aHostLists }}">
                                <input type="hidden" name="host_type" value="{{ $aHosttypes }}">
                            @else
                                <div class="col-lg-2">
                                    <label for="name">{{ __('Country') }}</label>

                                    <div class="form-group"> 
                                        {{ Form::select('country', ['' =>'Please Select'] + $aCountries,  $aRow ? $aRow->country : old('country') , ['class' => 'form-control ms', 'required' => 'required','onchange' => 'getcity(this)']) }}
                                    </div>
                                </div>
                                
                                 <div class="col-lg-2">
                                    <label for="name">{{ __('City') }}</label>
                                    <div class="form-group ">  
                                        {{ Form::select('city', ['' =>'Please Select'] + $aCities, $aRow ? $aRow->city : old('city') , ['class' => 'citywrap form-control ms', 'onchange' => 'gethostlists(this)' ]) }}
                                    </div>
                                </div>
                            
                                <div class="col-lg-2">
                                    <label for="name">{{ __('Select Host') }}</label>
                                    <div class="form-group"> 
                                        {{ Form::select('host_name', ['' =>'Please Select'] + $aHostLists, $aRow ? $aRow->host_name : null , ['class' => 'hostlistwrap form-control ms', 'required' => 'required','onchange' => 'gethosttype(this)']) }}
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <label for="name">{{ __('Select Host Type') }}</label>
                                    <div class="form-group"> 
                                        {{ Form::select('host_type', ['' =>'Please Select'] + $aHosttypes, $aRow ? $aRow->host_type : null , ['class' => 'hosttypewrap form-control ms', 'required' => 'required','readonly' => true,'onchange' => 'getsubtype(this)']) }}
                                    </div>
                                </div>
                                @endif

                                <div class="col-lg-2">
                                    <label for="name">{{ __('Property Type') }}</label>
                                    <div class="form-group">                          
                                        {{ Form::select('property_type', ['' =>'Please Select'] + $aProptypes, $aRow ? $aRow->property_type : null , ['class' => 'subtypewrap form-control ms', 'required' => 'required','disabled' => $aRow ? false : false]) }}
                                    </div>
                                </div>

                             </div> 


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

                             {{--
 
                             <div class="row clearfix">
                                <div class="col-lg-12">
                                    <label for="name">{{ __('Overview') }}</label>
                                    <div class="form-group"> 
                                        <textarea id="overview" name="overview" class="form-control{{ $errors->has('overview') ? ' is-invalid' : '' }}" required >         {{ $aRow ? $aRow->overview : old('overview') }}   
                                        </textarea>   
                                        @if ($errors->has('overview'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('overview') }}</strong>
                                            </span>
                                        @endif                      
                                       
                                        
                                    </div>
                                </div>
                                                                 
                                </div>  --}}  

                            <div class="row clearfix">

                                <div class="col-lg-3">
                                    <label for="name">{{ __('No of bedrooms') }}</label>
                                    <div class="form-group">                          
                                        <input type="number" id="no_bedrooms" name="no_bedrooms" class="form-control{{ $errors->has('no_bedrooms') ? ' is-invalid' : '' }}" value="{{ $aRow ? $aRow->no_bedrooms : old('no_bedrooms') }}" required placeholder="No of bedrooms">
                                        @if ($errors->has('no_bedrooms'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('no_bedrooms') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>


                                <div class="col-lg-3">
                                    <label for="name">{{ __('No of kitchens') }}</label>
                                    <div class="form-group">                          
                                        <input type="number" id="no_kitchens" name="no_kitchens" class="form-control{{ $errors->has('no_kitchens') ? ' is-invalid' : '' }}" value="{{ $aRow ? $aRow->no_kitchens : old('no_kitchens') }}" required placeholder="No of kitchens">
                                        @if ($errors->has('no_kitchens'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('no_kitchens') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <label for="name">{{ __('No of beds') }}</label>
                                    <div class="form-group">                          
                                        <input type="number" id="no_beds" name="no_beds" class="form-control{{ $errors->has('no_beds') ? ' is-invalid' : '' }}" value="{{ $aRow ? $aRow->no_beds : old('no_beds') }}" required placeholder="No of beds">
                                        @if ($errors->has('no_beds'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('no_beds') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-lg-3">
                                    <label for="name">{{ __('No of bathrooms') }}</label>
                                    <div class="form-group">                          
                                        <input type="number" id="no_bathrooms" name="no_bathrooms" class="form-control{{ $errors->has('no_bathrooms') ? ' is-invalid' : '' }}" value="{{ $aRow ? $aRow->no_bathrooms : old('no_bathrooms') }}" required placeholder="No of bathrooms">
                                        @if ($errors->has('no_bathrooms'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('no_bathrooms') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>


                            </div>

                             <div class="row clearfix">


                                <div class="col-lg-3">
                                    <label for="name">{{ __('No of parking') }}</label>
                                    <div class="form-group">                          
                                        <input type="number" id="no_parking" name="no_parking" class="form-control" value="{{ $aRow ? $aRow->no_parking : old('no_parking') }}" required placeholder="No of parking">                                        
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <label for="name">{{ __('No of reception') }}</label>
                                    <div class="form-group">                          
                                        <input type="number" id="no_reception" name="no_reception" class="form-control" value="{{ $aRow ? $aRow->no_reception : old('no_reception') }}" required placeholder="No of reception">                                        
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <label for="name">{{ __('Max no of guests') }}</label>
                                    <div class="form-group">                          
                                        <input type="number" min="0" id="max_guest" name="max_guest" class="form-control{{ $errors->has('max_guest') ? ' is-invalid' : '' }}" value="{{ $aRow ? $aRow->max_guest : old('max_guest') }}" required placeholder="Max no of guests">
                                        @if ($errors->has('max_guest'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('max_guest') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-lg-3">
                                    <label for="name">{{ __('Rate per night') }}</label>
                                    <div class="form-group">                          
                                        <input type="text" id="daily_rate" name="daily_rate" class="form-control{{ $errors->has('daily_rate') ? ' is-invalid' : '' }}" value="{{ $aRow ? $aRow->daily_rate : old('daily_rate') }}" required placeholder="Rack rate per night">
                                        @if ($errors->has('daily_rate'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('daily_rate') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>

                                 <div class="col-lg-4">
                                   {{--  <label for="name">{{ __('Property Code') }}</label>
                                    <div class="form-group">                          
                                        <input type="text" id="code" name="code" class="form-control{{ $errors->has('code') ? ' is-invalid' : '' }}" value="{{ $aRow ? $aRow->code : old('code') }}"  placeholder="Code">                                      
                                    </div>--}}
                                </div>

                             </div>

@php
    $tax_class = "d-none";
    if(isset($aRow['have_tax']) && $aRow['have_tax'] == 1)
    {
        $tax_class = "";
    }
@endphp

  <div class="row clearfix">
    <div class="col-lg-4">
        <label for="name">{{ __('Property have tax') }}</label>
        <div class="form-group">                          
            <input type="radio" @if(isset($aRow['have_tax']) && $aRow['have_tax'] == 1) checked @endif  onclick="show_tax_rate(this);" name="have_tax" value="1"> Yes
            <input type="radio" @if(isset($aRow['have_tax']) && $aRow['have_tax'] == 0) checked @endif   onclick="show_tax_rate(this);" name="have_tax" value="0"> No
        </div>
    </div>


    <div class="col-lg-4">
        <div class="taxrate_box {{ $tax_class }} ">
        <label for="name">{{ __('Tax Rate') }}</label>
        <div class="form-group">                          
            <input type="text" id="tax_rate" name="tax_rate" class="form-control{{ $errors->has('tax_rate') ? ' is-invalid' : '' }}" value="{{ $aRow ? $aRow->tax_rate : old('tax_rate') }}" required placeholder="Tax rate per night">

            @if ($errors->has('tax_rate'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('tax_rate') }}</strong>
                                            </span>
                                        @endif

        </div>
    </div>
    </div>
</div>                           

{{--
<div class="row clearfix">
<div class="col-lg-12">
    <label for="name">{{ __('Details') }}</label>
    <div class="form-group"> 
        <textarea id="details" name="details" class="form-control{{ $errors->has('details') ? ' is-invalid' : '' }}" required >  {{ $aRow ? $aRow->details : old('details') }}</textarea>   
    </div>
</div>                               
</div>
 --}}
<div class="row clearfix">

<div class="col-lg-6">
    <label for="name">{{ __('Amenities') }}</label>
    <div class="form-group"> 
        {{ Form::select('amenities[]', ['' =>'Please Select'] + $aAmenities, $aRow ? explode(",",$aRow->amenities) : old('amenities') , ['class' => 'form-control ms', 'multiple' => true ]) }}       
    </div>
</div> 

<div class="col-lg-6">
    <label for="name">{{ __('Additional Services') }}</label>
    <div class="form-group"> 
        {{ Form::select('services[]', ['' =>'Please Select'] + $aServices, $aRow ? explode(",",$aRow->services) : old('services') , ['class' => 'form-control ms', 'multiple' => true ]) }}       
    </div>
</div>  

</div>

 
<div class="row clearfix">
<div class="col-lg-12">
    <label for="name">{{ __('Internal Policy') }}</label>
    <div class="form-group"> 
        <textarea id="policy" style="height: 400px;"  name="policy" class="ckeditor form-control{{ $errors->has('policy') ? ' is-invalid' : '' }}" required >  {{ $aRow ? $aRow->policy : old('policy') }}</textarea>   
    </div>
</div>                               
</div>


                            

                            

                           
                             <div class="row clearfix">
                                <div class="col-lg-4">

                                    <label for="name">{{ __('Location on map') }}</label>
                                    <div class="form-group">                          
                                        <input type="text" id="address" name="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" value="{{ $aRow ? $aRow->address : old('address') }}" required placeholder="Location on map">
                                        @if ($errors->has('address'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('address') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-lg-4">

<label for="name">{{ __('Latitude') }}</label>
<div class="form-group">                          
    <input type="text" id="latitude" name="latitude" class="form-control{{ $errors->has('latitude') ? ' is-invalid' : '' }}" value="{{ $aRow ? $aRow->latitude : old('latitude') }}" required placeholder="latitude">
   
</div>

</div>

<div class="col-lg-4">

<label for="name">{{ __('Longitude') }}</label>
<div class="form-group">                          
    <input type="text" id="longitude" name="longitude" class="form-control{{ $errors->has('longitude') ? ' is-invalid' : '' }}" value="{{ $aRow ? $aRow->longitude : old('longitude') }}" required placeholder="longitude">
   
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
                                   <img src="{{  App\Helpers\CustomHelper::displayImage($aRow->image) }}" height="30px" width="30px" >
                                     @endif
                                </div>
                             </div>

                             <!-- <div class="row clearfix">
                                <div class="col-lg-6">

                                    <label for="name">{{ __('Status') }}</label>
                                    <div class="form-group">                          
                                         {{ Form::select('status', ['' =>'Please Select','1' => 'Active','0' => 'Inactive'], $aRow ? $aRow->status : null , ['class' => 'form-control show-tick', 'required' => 'required']) }}
                                    </div>

                                </div>

                            </div> -->
<?php
    $aImages = isset($aRow->gallery_images) ? unserialize($aRow->gallery_images) : array();
 
    ?>

                            <div class="row clearfix">
                                <div class="col-lg-6">

                                    <label for="name">{{ __('Property images') }}</label>
                                    <div class="form-group">                          
                                            <input type="file" id="property" name="property[]" multiple class="form-control"  >
                                    </div>
                                </div>
                            </div>


                            @if($aImages)
                <div class="list-unstyled row clearfix">
                    @foreach($aImages as $iKey => $aImage)
                    <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 m-b-20 text-center"> 
                        <img class="img-fluid img-thumbnail" src="{{  App\Helpers\CustomHelper::displayImage($aImage) }}" alt=""> 
                        <a href="{{ route('removegallery',array('property' => $aRow->id, 'gallery_id' => $iKey)) }}" class="m-t-10">Remove Image</a> 
                    </div>                    
                    @endforeach
                </div>    
            @endif








                              <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Save</button>
                            </form>        



                            
                        </div>
                    </div>
        </div>
    </div>
</div>

<style type="text/css">
    .form-control[readonly]
    {
        background-color: #fff!important;
    }
</style>

@endsection
