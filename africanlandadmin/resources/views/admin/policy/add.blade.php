@extends('admin.layouts.app')
@php $page_name = $aRow ? "Edit Policy" : "Add Policy" @endphp
@section('title') {{ $page_name }} @endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="javascript:void(0);">{{ $page_name }}</a></li>
@endsection

@section('content')


<script> var siteUrl = '{{ Request::url()}}'; </script>

@if ($aRow)
@php $details = json_decode($aRow->details); @endphp    
@endif



<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2>{{ $page_name }}</h2>

            </div>
            <div class="body table-responsive">
                @if($aRow)
                <form method="POST" action="{{ route('policy.update',$aRow->id) }}" enctype="multipart/form-data" id="agreement_form">
                @method('PUT')
                @else
                <form method="POST" action="{{ route('policy.store') }}" enctype="multipart/form-data" id="agreement_form">
                @endif
                @csrf

                <div class="row clearfix">
                    <div class="col-lg-6">
                        <label for="role_id">{{ __('Select User type') }}</label>
                        <div class="form-group">
                            {{ Form::select('role_id', [$aUser], $aRow ? $aRow->role_id : null , ['class' => 'form-control show-tick', 'required' => 'required','disabled' => $aRow ? false : false] ) }}
                            @if ($errors->has('role_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('role_id') }}</strong>
                            </span>
                            @endif
                            {!! Form::hidden('type', 'agreement') !!}
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-lg-12">
                        <label for="name">{{ __('Details') }}</label>
                        <div class="form-group">
                            @if ($aRow)
                                @foreach ($details as $key => $item)
                                    @php $counter = $key + 1 @endphp
                                    <div class="row mx-0" id="content-div{{$key}}">
                                        <div class="col-sm-6 mb-3" id="count-column">
                                            <div class="border agreement-div p-2">
                                                <div class="row mx-0 mb-0 ">
                                                    <div class="col-sm-6 p-0" id="pageName">page {{$counter}}</div>
                                                    <div class="col-sm-6 p-0 d-flex justify-content-end">
                                                        <i class="cursor-pointer material-icons mr-2 callModel" data-target="#editModel{{$key}}" >edit</i>
                                                        <i class="cursor-pointer material-icons mr-2 deleteRow" data-target="#content-div{{$key}}">delete</i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12" id="value-div">
                                            <div class="d-none" id="editModel{{$key}}" >
                                                <div class="data-headding">
                                                    <label for="name">{{ __('Details') }}</label>
                                                </div>
                                                <div class="form-group">
                                                    <textarea id="details" name="details[]" class="ckeditor form-control" > {{ $item }} </textarea>
                                                </div>
                                            </div>
                                        </div>{{-- end col-12 --}}
                                    </div>{{-- end row --}}
                                @endforeach
                            @else
                                <div class="row mx-0" id="content-div">
                                    <div class="col-sm-6 mb-3" id="count-column">
                                        <div class="border agreement-div p-2">
                                            <div class="row mx-0 mb-0 ">
                                                <div class="col-sm-6 p-0" id="pageName">page 1</div>
                                                <div class="col-sm-6 p-0 d-flex justify-content-end">
                                                    <i class="cursor-pointer material-icons mr-2 callModel" data-target="#editModel" >edit</i>
                                                    <i class="cursor-pointer material-icons mr-2 deleteRow" data-target="#content-div">delete</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12" id="value-div">
                                        <div class="d-none" id="editModel" >
                                            <div class="data-headding">
                                                <label for="name">{{ __('Details') }}</label>
                                            </div>
                                            <div class="form-group">
                                                <textarea id="details" name="details[]" class="ckeditor form-control" > {{ " " }} </textarea>
                                            </div>
                                        </div>
                                    </div>{{-- end col-12 --}}
                                </div>{{-- end row --}}
                            @endif
                        </div>{{-- end form-group div --}}
                        <div id="add-content"></div>
                        @if($aRow)
                        <div class="row mx-0">
                            <div class="col-sm-6 text-right"><button class="btn btn-secondary" id="addColumnUpdate">Add</button></div>
                        </div>
                        @else
                        <div class="row mx-0">
                            <div class="col-sm-6 text-right"><button type="submit" class="btn btn-secondary" name="addcolumn" value="1" id="addColumnStore">Add</button></div>
                        </div>
                        @endif
                    </div> {{-- end col-12 --}}
                </div> {{-- end row --}}

                
                <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Save</button>
                {!! Form::close() !!}

            </div>
                
            </div>
        </div>
    </div>


@endsection
@push('after-scripts')
<script>
    $(document).ready(function(){
    /* when update data */
      $("#addColumnUpdate").click(function(e){
        e.preventDefault();
        window.location.href=siteUrl+'?addcolumn=1'; 
      });
      
      $(".callModel").click(function(e){
          e.preventDefault();
          var targetDiv = $(this).data('target');
          if($(targetDiv).hasClass('d-none')){
              $('#value-div>div').addClass('d-none');
              $(targetDiv).removeClass('d-none');
          }
        });

        $(".deleteRow").click(function(e){
          e.preventDefault();
          var targetDiv = $(this).data('target');
          $(targetDiv).remove();
        });


       

    });
        
</script>
        
@endpush