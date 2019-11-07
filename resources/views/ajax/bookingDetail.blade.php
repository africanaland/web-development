<div class="modal-header border-bottom">
  <h5 class="modal-title text-left px-4" id="exampleModalLabel">Booking Detail</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
  
  </div>

<div class="modal-body p-0">
  <div class="modal-error px-2 mt-2"></div>
  
<div class="my-2 mx-3">
  <form method="post" action="{{ route('bookingUpdate')}}" class="paymentForm" onsubmit="return submitFrm(this);">
  {{ csrf_field() }}      
  <input type="hidden" name="bookingId" value="{{$aRow->id}}">
  <div class="form-group">
      <div class="row">
        <div class="col-6 my-sm-0 py-2">
          <label for="">CheckIn Date</label>
          <div class="input-group date" data-provide="datepicker">
            <input type="text" name="checkin" value="{{ date('m/d/Y',strtotime($aRow->checkin)) }}" id="" class="form-control">
            <div class="input-group-addon">
            </div>
          </div>
        </div>
        <div class="col-6 my-sm-0 py-2">
          <label for="">Checkout Date</label>
          <div class="input-group date" data-provide="datepicker">
            <input type="text" name="checkout" value="{{ date('m/d/Y',strtotime($aRow->checkout)) }}" id="" class="form-control">
            <div class="input-group-addon">
            </div>
          </div>
        </div>
      </div>
  </div>
  <hr>
  <div class="h6">Additional Services</div>
  <?php  $ProServices = $aRow->get_property_fields($aRow->proServices, 'services');
          $UserService = json_decode($aRow->services);
          if(!empty($UserService)){
          foreach($ProServices as $key1 => $item1){
            foreach ($UserService as $key2 => $item2) {
              if($item1['id'] == $item2->id){
                $ProServices[$key1]['UserStatus'] = '4';
                if(isset($item2->hrs) && $item2->hrs > 0){
                  $ProServices[$key1]['UserHrs'] = $item2->hrs;
                }
              }
            }
          }
        }
  ?>
    @if(!empty($ProServices))
    <div class="row">
    @foreach($ProServices as $service)
    <div class="col-sm-6 mb-3">
    <div class="text-center border radio-control px-2 add-service">
        <div class="d-flex">
            <div>
                <p class="py-1 my-0 text-left">
                    <input type="checkbox" value="{{ $service['id'] }}" @if(@$service['UserStatus']) checked @endif name="add_service[{{ $service['id'] }}][id]">                      
                    <input type="hidden" value="{{ $service['price'] }}" name="add_service[{{ $service['id'] }}][price]">
                </p>
                <p class="py-1"><img class="proOverviewImg" src="@if ($service['image']){{ asset('public/uploads/'.$service['image'])  }} @else {{ asset('public/images/noimage.png')  }} @endif" class="" ></p>
            </div>
            <div class="p-2 pr-3"><p class="border-right border-left" style="height: 100%;"></p></div>
            <div class="text-left">
                <h6 class="py-1 my-0 text-dark"><b>{{ $service['name'] }}</b></h6>
                @if($service['type'] == 'calculable')
                <p class="pt-1 my-0  text-dark">
                    <input class="form-control p-1" type="number" min="1" @if(@$service['UserHrs']) value="{{@$service['UserHrs']}}" @else value="1" @endif name="add_service[{{ $service['id'] }}][hrs]" size="10" style="width: 40px;display: inline-block;"> Hour/daily
                </p>
                @endif
                <p class="pb-1 my-0 servicePrice" >$ {{ $service['price'] }}</p>
            </div>
        </div>
    </div>
    </div>
    @endforeach
    @endif
  <div class="w-100 d-sm-flex justify-content-center border-top pt-2 text-center">
      <button type="submit" class=" w-25 mr-sm-2 mr-0  btn btn-afland btn-afland-white">Update</button>
      <button type="button" class=" w-25 btn btn-afland btn-afland-white" data-dismiss="modal" aria-label="Close">Cancel</button>
  </div>
</form>
</div>
<div class="modal-loader"><i class="fa fa-spinner fa-spin"></i></div>
</div>