<div class="propertyBox mb-4 pb-2" style="">
	<div class="proImg">
		@if ($aRow->image)
		<img src="{{ asset('public/uploads/'.$aRow->image)  }}" class="pro_img" height="200px" width="100%" >
		@else
		<img src="{{ asset('public/images/property.png')  }}" class="pro_img" height="200px" width="100%" >
		@endif
		<div class="proPrice">
			<div class="d-flex justify-content-between align-items-center">
			  <div class="p-2 pb-0"><span class="price">${{ $aRow->daily_rate }}</span>/Night</div>
			  <div class="p-2 pb-0">
			  	<img src="@if ($aRow->user['image']){{ asset('public/uploads/'.$aRow->user['image'])  }} @else {{ asset('public/images/profile.png')  }} @endif" class="rounded-circle " height="50px" width="50px" >
			  </div>
			</div>
		</div>
	</div>
	<div class="proBody">
		<div class="border-bottom pl-3 pr-3">
			<div class="p-2">
				<div class="row mx-0 w-100">
					<div class="col-6 p-0">
						<b><a href="{{ route('viewproperty', $aRow->id )}}" class="text-decoration-none"> {{ $aRow->name }}</b></a>
					</div>
					@if(!empty($aRow->gallery_images))
					<div class="col-6 p-0 text-right">
							<b><a href="javascript::void(0)" onclick="openPopup('{{ route('propertiegallery', $aRow->id )}}')" class="text-decoration-none"> gallery</b></a>
					</div>
					@endif
				</div>
				{{ $aRow->address }}
			</div>
		</div>
		<div class="d-flex justify-content-between border-bottom pl-3 pr-3">
		<div class="p-2">Rooms : {{$aRow->no_bedrooms}}</div>
			<div class="p-2">Adults : 2</div>
			<div class="p-2">Childs : 2</div>
		</div>
		<div class="d-flex justify-content-between pl-3 pr-3">
			<div class="p-2">
				<b>{{ @$aRow->user['fname'] }} {{ @$aRow->user['lname'] }}</b> <br>
				<div class="ratings">
				<div class="empty-stars"> <span class="ml-1">Review</span></div>
					<div class="full-stars" style="width:{{\App\Review::ratings($aRow->id )}}%"></div>					
				</div>
      </div>
            @guest
            @else
            <div class="p-2">
                @if(!empty($favorite))
                    @php $status = false @endphp
                    @foreach ($favorite as $item)
                        @if ($item['property_id'] == $aRow->id)
                        @php $status = true @endphp
                        @php break @endphp
                        @endif
                    @endforeach
                    @if ($status)
                        <a href="javascript:void(0);" title="Remove Favorite" class="booking_icon " onclick="makeFavorite('{{ $aRow->id }}','0');"><i class="fa fa-heart favouritesBtn activefavourites"></i></a>
                    @else
                        <a href="javascript:void(0);" title="Add Favorite" class="booking_icon " onclick="makeFavorite('{{ $aRow->id }}','1');"><i class="fa fa-heart favouritesBtn"></i></a>
                    @endif
                @endif
            </div>
            @endguest

		</div>
	</div>
</div>


