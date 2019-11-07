<div class="propertyBox mb-4 pb-2" style="">
	<div class="proImg">
		@if ($aRow->image)
		<img src="{{ asset('public/uploads/'.$aRow->image)  }}" class="pro_img" height="200px" width="100%" >
		@else
		<img src="{{ asset('public/images/property.png')  }}" class="pro_img" height="200px" width="100%" >
		@endif

	</div>
	<div class="proBody">
		<div class="d-flex justify-content-between pl-3 pr-3">
				<div class="p-2">
				<img src="@if ($aRow->user['image']){{ asset('public/uploads/'.$aRow->user['image'])  }} @else {{ asset('public/images/profile.png')  }} @endif" class="rounded-circle" height="50px" width="50px" >
			</div>
			<div class="p-2 flex-fill">
				<b>{{ @$aRow->user['fname'] }} {{ @$aRow->user['lname'] }}</b> <br>
				<div class="proRate">
					<span class="fa fa-star fillStar"></span>
					<span class="fa fa-star fillStar"></span>
					<span class="fa fa-star fillStar"></span>
					<span class="fa fa-star"></span>
					<span class="fa fa-star"></span>
					Review
				</div>
			</div>
		</div>
		<div class="d-flex justify-content-between border-bottom pl-3 pr-3">
			<div class="p-2"><b>{{ $aRow->name }}</b></div>
		</div>

		<div class="d-flex justify-content-between border-bottom pl-3 pr-3">
			<div class="p-2">{{ $aRow->address }}</div>
		</div>
		<div class="d-flex justify-content-between border-bottom pl-3 pr-3">
			<div class="p-2">Type : {{ $aRow->property_type }}</div>
			<div class="p-2">Per Night : {{ $aRow->daily_rate }}</div>
		</div>

		<div class="d-flex justify-content-center pl-3 pr-3">
			<div class="p-2">
				<a href="{{ route('viewproperty', $aRow->id )}}" class="booking_icon"><i class="fa fa-eye"></i></a>
			</div>
			{{-- <div class="p-2">
				<a href="javascript:void(0);" class="booking_icon"><i class="fa fa-home "></i></a>
			</div> --}}
			{{-- <div class="p-2">
				<a href="javascript:void(0);" title="" class="booking_icon" ><i class="fa fa-trash"></i></a>
            </div> --}}
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
                        <a href="javascript:void(0);" title="Remove Favorite" class="booking_icon " onclick="makeFavorite('{{ $aRow->id }}','0');"><i class="fa fa-heart activefavourites"></i></a>
                    @else
                        <a href="javascript:void(0);" title="Add Favorite" class="booking_icon " onclick="makeFavorite('{{ $aRow->id }}','1');"><i class="fa fa-heart "></i></a>
                    @endif
                @endif
            </div>
            @endguest
		</div>


	</div>
</div>


