@extends('admin.layouts.app')

@php
    $page_name = $aRow ? "Edit ".$type : "Add ".$type
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
                            <form method="POST"  action="{{ route('users.update',$aRow->id) }}" enctype="multipart/form-data">
                            @method('PUT')
                            @else
                            <form method="POST"  action="{{ route('users.store') }}" enctype="multipart/form-data">
                            @endif                           
                            @csrf
                            @if( isset($profilePage) && $profilePage)
                            <input type="hidden" name="role_id" value="{{$aRow ? $aRow->role_id : NULL}}">
                            @else
                            <div class="row clearfix"> 
                                @if($type != "guest") 
                                <div class="col-lg-6">
                                    <label for="name">{{ __('Select Role') }}</label>

                                    <div class="form-group"> 
                                        {{ Form::select('role_id', ['' =>'Please Select'] + $aRoles, $aRow ? $aRow->role_id : null , ['class' => 'form-control ms', 'required' => 'required','disabled' => $aRow ? false : false]) }}
                                    </div>
                                </div>
                                @endif

                                 @if($type == "guest") 
                                 <div class="col-lg-4">
                                    <label for="name">{{ __('Country') }}</label>

                                    <div class="form-group"> 
                                        {{ Form::select('country', ['' =>'Please Select'] + $aCountries,  $aRow ? $aRow->country : old('country') , ['class' => 'form-control ms', 'required' => 'required','onchange' => 'getcity(this)']) }}
                                    </div>
                                </div>
                                
                                 <div class="col-lg-4">
                                    <label for="name">{{ __('City') }}</label>
                                    <div class="form-group">  
                                        {{ Form::select('city', ['' =>'Please Select'] + $aCities, $aRow ? $aRow->city : old('city') , ['class' => 'citywrap form-control ms', ]) }}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label for="name">{{ __('Membership Type') }}</label>

                                    <div class="form-group"> 
                                        {{ Form::select('role_id', $aRoles, $aRow ? $aRow->role_id : null , ['class' => 'form-control ms d-none', 'required' => 'required','disabled' => $aRow ? false : false]) }}
                                        {{ Form::select('membership_id', ['' =>'Please Select'] + $aMemberships, $aRow ? $aRow->membership_id : null , ['class' => 'form-control ms', 'required' => 'required']) }}
                                    </div>
                                </div>
                                @endif
                             </div>   
                              @endif




                             <div class="row clearfix">
                                <div class="col-lg-6">
                                     <label for="name">{{ __('First Name') }}</label>
                                    <div class="form-group">                          
                                        <input type="text" id="fname" name="fname" class="form-control{{ $errors->has('fname') ? ' is-invalid' : '' }}" value="{{ $aRow ? $aRow->fname : old('fname') }}" required placeholder="First Name">
                                        @if ($errors->has('fname'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('fname') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>

                                 <div class="col-lg-6">

                                    <label for="name">{{ __('Last Name') }}</label>
                                    <div class="form-group">                          
                                        <input type="text" id="lname" name="lname" class="form-control{{ $errors->has('lname') ? ' is-invalid' : '' }}" value="{{ $aRow ? $aRow->lname : old('lname') }}" required placeholder="Last Name">
                                        @if ($errors->has('lname'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('lname') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>
                             </div>

                             <div class="row clearfix">
                                <div class="col-lg-6">

                                    <label for="name">{{ __('User Name') }}</label>
                                    <div class="form-group">                          
                                        <input type="text" id="username" name="username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" value="{{ $aRow ? $aRow->username : old('username') }}" required placeholder="User Name">
                                        @if ($errors->has('username'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('username') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>
                                <div class="col-lg-6">
                                    <label for="name">{{ __('Email') }}</label>
                                    <div class="form-group">                          
                                        <input type="email" id="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ $aRow ? $aRow->email : old('email') }}" required placeholder="Email" @if($aRow)  @endif >
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                                                 
                             </div>

                            @if(empty($aRow))
                               <div class="row clearfix">
                                <div class="col-lg-6">
                                    <label for="name">{{ __('Password') }}</label>
                                    <div class="form-group">                          
                                        <input type="password" id="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" value="" required placeholder="Password">
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                 <div class="col-lg-6">
                                    <label for="name">{{ __('Confirm Password') }}</label>
                                    <div class="form-group">                          
                                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" value="" required placeholder="Confirm Password"> 
                                    </div>
                                </div>
                             </div>
                             @endif

                             @if($type != "guest")
                             <div class="row clearfix">
                                <div class="col-lg-6">
                                    <label for="name">{{ __('Country') }}</label>

                                    <div class="form-group"> 
                                        {{ Form::select('country', ['' =>'Please Select'] + $aCountries,  $aRow ? $aRow->country : old('country') , ['class' => 'form-control ms', 'required' => 'required','onchange' => 'getcity(this)']) }}
                                    </div>
                                </div>
                                
                                 <div class="col-lg-6">
                                    <label for="name">{{ __('City') }}</label>
                                    <div class="form-group">  
                                        {{ Form::select('city', ['' =>'Please Select'] + $aCities, $aRow ? $aRow->city : old('city') , ['class' => 'citywrap form-control ms', ]) }}
                                    </div>
                                </div>
                             </div>
                            @endif
                           
                             <div class="row clearfix">

                                <div class="col-lg-6">

                                <label for="name">{{ __('Address') }}</label>
                                <div class="form-group">                          
                                    <input type="text" id="address" name="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" value="{{ $aRow ? $aRow->address : old('address') }}" placeholder="Address">
                                    @if ($errors->has('address'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                </div>

                                <div class="col-lg-6">
                                    <label for="name">{{ __('Mobile') }}</label>
                                    <div class="form-group">
                                        <input type="text" id="mobile" name="mobile" class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}" value="{{ $aRow ? $aRow->mobile : old('mobile') }}" required placeholder="Mobile">
                                        @if ($errors->has('mobile'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('mobile') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>
                            </div>
                            <div class="row clearfix">
                                 <div class="col-lg-6">
                                    <label for="name">{{ __('Profile Image') }}</label>
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
                                @if( isset($profilePage) && $profilePage)
                                    @if(!$adminLogin)

                                        <div class="col-lg-6">
                                            <label for="paypalId">{{ __('paypal Id') }}</label>
                                            <div class="form-group">                          
                                                <input type="text" id="paypalId" name="paypalId" class="form-control{{ $errors->has('paypalId') ? ' is-invalid' : '' }}" value="{{ $aRow ? $aRow->paypalId : old('paypalId') }}" placeholder="Enter paypal client id">
                                                @if ($errors->has('paypalId'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('paypalId') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="paypalClientId">{{ __('paypal Client Id') }}</label>
                                            <div class="form-group">
                                                <input type="text" id="paypalClientId" name="paypalClientId" class="form-control{{ $errors->has('paypalClientId') ? ' is-invalid' : '' }}" value="{{ $aRow ? $aRow->paypalClientId : old('paypalClientId') }}"  placeholder="Enter paypal key">
                                                @if ($errors->has('paypalClientId'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('paypalClientId') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                         <div class="col-lg-6">
                                            <label for="paypalSecKey">{{ __('paypal App Secret Key') }}</label>
                                            <div class="form-group">
                                                <input type="text" id="paypalSecKey" name="paypalSecKey" class="form-control{{ $errors->has('paypalSecKey') ? ' is-invalid' : '' }}" value="{{ $aRow ? $aRow->paypalSecKey : old('paypalSecKey') }}" placeholder="Enter Paypal Secret key">
                                                @if ($errors->has('paypalSecKey'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('paypalSecKey') }}</strong>
                                                    </span>
                                                @endif
                                            </div>        
                                        </div>
                                    
                                    
                                    @endif
                                @endif
                            </div>


                              @if( isset($profilePage) && $profilePage)
                              @else                              
                                 <div class="row clearfix">
                                    <div class="col-lg-6 @if(($type == 'guest') || $staffLogin ) {{ 'd-none' }}  @endif">
                                        <label for="name">{{ __('Agreement Status') }}</label>
                                        <div class="form-group">                          
                                             {{ Form::select('agreement', ['' =>'Please Select','2' => 'Accepted','1' => 'Accepted pending','0' => 'Not Accepted'], $aRow ? $aRow->agreement : 0 , ['class' => 'form-control show-tick', 'required' => 'required']) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="name">{{ __('User Status') }}</label>
                                        <div class="form-group">                          
                                             {{ Form::select('status', ['' =>'Please Select','1' => 'Active','0' => 'Inactive'], $aRow ? $aRow->status : 1 , ['class' => 'form-control show-tick', 'required' => 'required']) }}
                                        </div>
                                    </div>

                                </div>
                            @endif
                              <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Save</button>
                            </form>        



                            
                        </div>
                    </div>
        </div>
    </div>
</div>

@endsection
