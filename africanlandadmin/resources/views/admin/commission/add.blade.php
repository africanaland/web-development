@extends('admin.layouts.app')

@php
    $page_name = $aRow ? "Edit User Commission" : "Add Commission"
@endphp

@section('title') {{ $page_name }} @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="javascript:void(0);">{{ $page_name }}</a></li>
@endsection

@inject('userData', 'App\User')


@section('content')
<script>
    var getDataUrl = '{{ route('getUserData')}}';
</script>
    
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2>{{ $page_name }}</h2>                        
            </div>
            <div class="body table-responsive">                       
                @if($aRow)
                <form method="POST"  action="{{ route('commission.update',$aRow->id) }}" enctype="multipart/form-data">
                @method('PUT')
                @else
                <form method="POST"  action="{{ route('commission.store') }}" enctype="multipart/form-data">
                @endif                           
                @csrf
                    @if($aRow)
                    <div class="row clearfix">
                        <div class="col-6">
                            <label for="user_id">{{ __('User Role') }}</label>
                            <div class="form-group">
                                <input type="text" name="" value="{{ App\Role::getRolename($aRow->role_id,'name')}}" disabled class="form-control" id=""> 
                                <input type="hidden" name="" value="{{ $aRow->role_id }}" disabled class="form-control userRole" id=""> 
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-6">
                            <label for="user_id">{{ __('User') }}</label>
                            <div class="form-group">
                                @if($aRow->user_id == 0)
                                <input type="text" name="" value="{{ "For All" }}" disabled class="form-control " id=""> 
                                @else
                                @php
                                    $data = $userData->getUserData($aRow->user_id,array('fname'))
                                @endphp
                                <input type="text" name="" value="{{ $data->fname }}" disabled class="form-control" id="">
                                @endif
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="row clearfix">
                       <div class="col-6">
                           <label for="role_id">{{ __('Select User Role') }}</label>
                           <div class="form-group"> 
                               {{ Form::select('role_id', ['' =>'Please Select'] + $uRole,  $aRow ? $aRow->role_id : old('role_id') , ['class' => 'form-control ms userRole', 'id' => 'getData','data-value'=>'user_id']) }}
                           </div>
                           @if ($errors->has('role_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('role_id') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div> 
                    <div class="row clearfix">
                       <div class="col-6">
                           <label for="user_id">{{ __('Select User') }}</label>
                           <div class="form-group"> 
                               {{ Form::select('user_id', ['' =>'Please Select'],  $aRow ? $aRow->user_id : old('user_id') , ['class' => 'form-control ms', 'id'=>'user_id']) }}
                           </div>
                           @if ($errors->has('user_id'))
                           <span class="invalid-feedback" role="alert">
                               <strong>{{ $errors->first('user_id') }}</strong>
                           </span>
                           @endif
                       </div>
                    </div>
                    @endif
                    <div class="row clearfix">
                       <div class="col-6">
                           <label for="type">{{ __('Select Payment type') }}</label>
                           <div class="form-group">
                               {{ Form::select('type', ['' =>'Please Select','1'=>'Present Amount','2'=>'Fixed amount'],  $aRow ? $aRow->type : old('type') , ['class' => 'form-control ms paymentType']) }}
                           </div>
                           @if ($errors->has('type'))
                           <span class="invalid-feedback" role="alert">
                               <strong>{{ $errors->first('type') }}</strong>
                           </span>
                           @endif
                       </div>
                    </div>
                    <div class="row clearfix">
                       <div class="col-6">
                           <label for="percent">{{ __('Add Commission percent') }}</label>
                           <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text icon1">%</span>
                                    <span class="input-group-text icon2 d-none"><i class="zmdi zmdi-money"></i></span>
                                </div>
                                <input type="text" class="form-control inputTag" name="percent" value="{{$aRow ? $aRow->percent : old('percent')}}" placeholder="Enter precent in number like 5">
                            </div>
                            @if ($errors->has('percent'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('percent') }}</strong>
                                </span>
                            @endif 
                       </div>
                    </div>
                            


                    <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Save</button>
                    </form>                                    
            </div>
        </div>
    </div>
</div>
@push('add-css')
<style type="text/css">
    .form-control[readonly]{ background-color: #fff!important; }
</style>    
@endpush
@push('after-scripts')
    <script>
        var checkRole = @php echo App\User::ROLE_AGENT @endphp;
        $(document).ready(function(){
            $('.paymentType').change(function(){
                var userRole =  $('.userRole').val();
                var type =  $(this).val();
                if(userRole == checkRole){
                    if(type == 2){
                        $('.inputTag').attr('placeholder','Enter Commission Amount');
                        $('.icon2').removeClass('d-none');
                        $('.icon1').addClass('d-none');
                    }else{
                        $('.inputTag').attr('placeholder','Enter precent in number like 5');
                        $('.icon1').removeClass('d-none');
                        $('.icon2').addClass('d-none');
                    }
                }
            })
        })
    
    </script>
@endpush
@endsection
