<div class="modal fade" id="addition_service" tabindex="-1" role="dialog" aria-labelledby="afModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="document">
<div class="modal-content">
<div class="modal-header border-bottom">
<h5 class="modal-title text-left text-size15" id="exampleModalLabel">Additional Services</h5>
</div>
<div class="modal-body">
@if($services)
<div class="row">
@foreach($services as $service)
<div class="col-sm-6 mb-3">
<div class="text-center border radio-control px-2 add-service">
    <div class="d-flex">
        <div>
            <p class="py-1 my-0 text-left">
                <input type="checkbox" value="{{ $service['id'] }}" name="add_service[{{ $service['id'] }}][id]">
                <input type="hidden" value="{{ $service['price'] }}" name="add_service[{{ $service['id'] }}][price]">
            </p>
            <p class="py-1"><img class="proOverviewImg" src="@if ($service['image']){{ asset('public/uploads/'.$service['image'])  }} @else {{ asset('public/images/noimage.png')  }} @endif" class="" ></p>
        </div>
        <div class="p-2 pr-3"><p class="border-right border-left" style="height: 100%;"></p></div>
        <div class="text-left">
            <h6 class="py-1 my-0 text-dark"><b>{{ $service['name'] }}</b></h6>
            @if($service['type'] == 'calculable')
            <p class="pt-1 my-0  text-dark">
                <input class="form-control p-1" type="number" min="1" value="1" name="add_service[{{ $service['id'] }}][hrs]" size="10" style="width: 40px;display: inline-block;"> Hour/daily
            </p>
            @endif
            <p class="pb-1 my-0 servicePrice" >$ {{ $service['price'] }}</p>
        </div>
    </div>
</div>
</div>
@endforeach
</div>

<div class="row">
<div class="w-100 d-flex justify-content-center">
<!-- <a href="javascript:void(0);" class="btn btn-afland  mr-3">Done</a> -->
<button type="button" class="w-25 btn btn-afland mr-3" data-dismiss="modal" aria-label="Done">Done</button>
<button type="button" class="w-25 btn btn-afland btn-afland-white" data-dismiss="modal" aria-label="Close">
    Cancel
    </button>
</div>
</div>

@endif
</div>
</div>
</div>
</div>
