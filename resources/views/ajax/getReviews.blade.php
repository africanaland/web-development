<div class="">
  <div class="text-right p-relative">
    
    <div class="ajaxPropertyImg" style="background : url( @if($property->image) {{ asset('public/uploads/'.$property->image) }} @else {{ asset('public/images/property.png') }} @endif)"></div>
    <div class="ReviewBtn">
        <span  class="fa fa-times" data-dismiss="modal" aria-label="Close"></span>
    </div>
    <div class="ajaxContent">
      <h4 class="mb-1">{{ $property->name}}</h4>
    </div>
  </div>
  <div class="py-2">
    <div class="w-95 mx-auto addReview">
      @forelse ($aRows as $aRow) 
      <div class="py-2">   
        <div class="clearfix">
          <div class="float-left d-flex">
            <div class="chatUser" style="background: url({{ asset('public/uploads/'.$aRow->image) }})"></div>
            <div>
              <h6 class="mb-0">{{$aRow->fname}}</h6>
              <div class="proRate" id="RatingProperty">
                @php $reviews = $aRow->rating @endphp
                @for ($i = 0; $i < 5; $i++)
                  <span class="text-size12 fa fa-star @if($reviews>0) fillStar @endif"></span>                
                  @php $reviews-- @endphp
                @endfor
              </div>
            </div>
          </div>
          <div class="float-right text-size12 mb-0 mt-2">
            <p>{{date('d/M/y',strtotime($aRow->created_at))}}</p>
          </div>
        </div>
        <p class="userReview">{{$aRow->review}}</p>
      </div>  
      @empty
      
      @endforelse
    </div>
  </div>
</div>