<div class="my-2">
    <div class="h4 mx-3">Add Review</div>
    <form action="{{route('addReview',$aRow->bookingId)}}" method="post" onsubmit="return submitFrm(this);">
        {{ csrf_field() }}
    <div class="">
      <div class="text-right p-relative">
        <div class="ajaxPropertyImg" style="background : url( @if($aRow->image) {{ asset('public/uploads/'.$aRow->image) }} @else {{ asset('public/images/property.png') }} @endif)"></div>
        <div class="ajaxContent">
          <h4 class="mb-1">{{ $aRow->name}}</h4>
          <h6 class="mb-0">{{ "Booking Id - ".$aRow->bookingId}}</h6>
        </div>
      </div>
        <div class="row mx-0 mt-2">
          <div class="col-12">
            <div class="mb-2 d-flex ">
              <label for="name" class="font-weight-bold">Email :-&nbsp;&nbsp;</label><div class="h5 text-secondary mb-0 ">{{$userDetail->email}}</div>
            </div>
            <div class="mb-2 d-flex">
              <label for="name" class="font-weight-bold">Name :-&nbsp;&nbsp;</label><div class="h5 text-secondary mb-0 ">{{$userDetail->fname}}</div>
            </div>
          </div>
          <div class="col-12">
            <div class="mb-2 d-flex">
              <label for="RatingProperty" class="font-weight-bold mr-3">Rating*</label>
              <div class="proRate" id="RatingProperty" >
                <span title="bad" class="fa fa-star" data-value="1"></span>
                <span title="poor" class="fa fa-star" data-value="2"></span>
                <span title="regular" class="fa fa-star" data-value="3"></span>
                <span title="good" class="fa fa-star" data-value="4"></span>
                <span title="gorgeous" class="fa fa-star" data-value="5"></span>
                <input type="hidden" name="rating" id="value" value="0" required>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="mb-2 ">
              <label for="Review" class="font-weight-bold">Share your Experience</label>
              <textarea id="Review" name="Review" cols="60" rows="5"  class="form-control"></textarea>
            </div>
          </div>
        </div>
      </div>
      
      <div class="w-100 d-sm-flex justify-content-center border-top pt-2 text-center">
        <button type="submit" class=" w-25 mr-sm-2 mr-0  btn btn-afland btn-afland-white">Submit</button>
        <button type="button" class=" w-25 btn btn-afland btn-afland-white" data-dismiss="modal" aria-label="Close">Cancel</button>
    </div>  
    </form>
</div>

<script>
$(document).ready(function(){
    $('#RatingProperty > span').mouseover(function() {
        $(this).addClass('fillStar').prevAll().addClass('fillStar');
        $(this).nextAll().removeClass('fillStar'); 
        var value = $(this).data('value');
        $('#RatingProperty > #value').val(value);
      })
});
</script>