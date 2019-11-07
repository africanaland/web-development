@php
    $imageArray = unserialize($aRow->gallery_images);
@endphp
<div class="modal-header ">
    <h4 class="modal-title text-left">Gallery</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="owl-carousel owl-theme" id="propertyGallery">
  @foreach ($imageArray as $item)
      <div style="background:url({{asset('public/uploads/'.$item)}})" class="divImage galleryImage"></div>
  @endforeach
</div>
    
<script>
$('#propertyGallery').owlCarousel({
    items:1,
    loop:true,
    responsiveClass:true,
    center:true,
    lazyLoad:true,
    autoplay:true,
    autoplayTimeout:3000,
    autoplaySpeed:2000,
    margin:10,
})
</script>