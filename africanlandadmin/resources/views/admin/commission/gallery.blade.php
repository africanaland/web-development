@extends('admin.layouts.app')

@php $page_name = "Manage Gallery"; @endphp

@section('title') {{ $page_name }} @endsection

@section('breadcrumb') <li class="breadcrumb-item"><a href="javascript:void(0);">{{ $page_name }}</a></li> @endsection

@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header"><h2>{{ $page_name }}</h2></div>
            <div class="body table-responsive">                      
                <form method="POST"  action="{{ route('updategallery',$aRow->id) }}" enctype="multipart/form-data">        
                @csrf           
                <div class="col-lg-6">
                    <label for="name">{{ __('Image') }}</label>
                    <div class="form-group">                          
                        <input type="file" id="image" name="image" required class="form-control">
                    </div> 
                    @if ($errors->has('image'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('image') }}</strong>
                        </span>
                    @endif                                  
                </div>
                <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Upload</button>
                </form>        
            </div>

            <div class="body table-responsive m-t-10">
            @if($aImages)
                <div class="list-unstyled row clearfix">
                    @foreach($aImages as $iKey => $aImage)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 m-b-20 text-center"> 
                        <img class="img-fluid img-thumbnail" src="{{  App\Helpers\CustomHelper::displayImage($aImage) }}" alt=""> 
                        <a href="{{ route('removegallery',array('property' => $aRow->id, 'gallery_id' => $iKey)) }}" class="m-t-10">Remove Image</a> 
                    </div>                    
                    @endforeach
                </div>    
            @else
            No images uploaded yet
            @endif
            </div>

        </div>
    </div>
</div>
@endsection
