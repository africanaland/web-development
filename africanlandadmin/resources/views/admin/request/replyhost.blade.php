@extends('admin.layouts.app')
@php
    $page_name = "Reply Host Request"
@endphp
@section('title') {{ $page_name }} @endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="javascript:void(0);">{{ $page_name }}</a></li>
@endsection
@section('content')
<div class="row clearfix">
<div class="col-lg-12">
<div class="card">
    <div class="header"><h2>{{ $page_name }}</h2></div>
    <div class="body table-responsive">
        <div class="row clearfix">
            <div class="col-lg-12"> 
                @if($aRow->status == 1)
                <label for="name"><b>{{ __('Reply') }}</b></label>
                <div class="form-group">{{ $aRow->reply }}</div>
                
                <label for="name"><b>{{ __('Attachment') }}</b></label>
                @if($aRow->reply_attachment)
                    <div class="form-group">{{ $aRow->reply_attachment }} <a href="{{ asset('public/uploads/'.$aRow->reply_attachment)  }}" target="_blank">View Attachment </a></div>
                @else
                    <div class="form-group">No attachment</div>
                @endif
                @else

                <form method="POST"  action="{{ route('posthostreply',$aRow->id) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                    <label for="name">{{ __('Reply') }}</label>
                    <div class="form-group">                               
                        <textarea name="reply" class="form-control" required>{{ old('reply') }}</textarea>
                    </div>
                    <label for="name">{{ __('Attachment') }}</label>
                    <div class="form-group">                               
                        <input type="file" name="image">
                    </div>
                                    
                    <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Save</button>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>

@endsection
