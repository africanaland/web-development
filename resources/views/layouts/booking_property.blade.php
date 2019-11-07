<div class="propertyBox mb-4 " style="">
		<div class="proImg mb-3">
			@if ($aRow->property['image'])
			<img src="{{ asset('public/uploads/'.$aRow->property['image'])  }}" class="pro_img" height="200px" width="100%" >
			@else
			<img src="{{ asset('public/images/property.png')  }}" class="pro_img" height="200px" width="100%" >
			@endif
	
		</div>
		<div class="proBody">
			<div class="d-flex justify-content-between pl-3 pr-3">
				<div class="p-2">
					<img src="@if (@$aRow->property['user']['image']){{ asset('public/uploads/'.@$aRow->property['user']['image'])  }} @else {{ asset('public/images/profile.png')  }} @endif" class="rounded-circle" height="50px" width="50px" >
				</div>
				<div class="py-2 flex-fill">
					<b>{{ @$aRow->property['user']['fname'] }} {{ @$aRow->property['user']['lname'] }}</b> <br>
					<div class="ratings">
							<div class="empty-stars"></div>
							<div class="full-stars" style="width:{{\App\Review::ratings($aRow->property['id'])}}%"></div>
					</div>
					@php $review = \App\Review::reviewCount($aRow->property['id']) @endphp
					@if ($review)
					<a href="javascript:void(0);" class="text-decoration-none" onclick="openPopup('{{ route('getReviews', $aRow->property['id'] )}}')" title="Review">	
						<span class="mt-2">Review ({{$review}})</span>
					</a>							
					@endif
				</div>
			</div>
			<div class="d-flex justify-content-between border-bottom pl-3 pr-3">
				<div class="py-2"><b>{{ $aRow->property['name'] }}</b></div>
			</div>
	
			<div class="d-flex justify-content-between border-bottom pl-3 pr-3">
				<div class=" py-3"><i class="fa fa-map-marker mr-1" aria-hidden="true"></i>{{ $aRow->property['address'] }}</div>
			</div>
			<div class="d-flex justify-content-between border-bottom pl-3 pr-3">
				<div class="py-3">
					<strong>Booking Id :</strong> {{ $aRow->id }} <br>
					<strong>Check In :</strong> {{ date("d M Y",strtotime($aRow->checkin)) }} <br>
					<strong>Check Out :</strong> {{ date("d M Y",strtotime($aRow->checkout)) }} <br>
				</div>
			</div>
			@if($status)
			<div class="pl-3 pr-3">
				<div class="py-2">
						@if($aRow->status == 0)
								<span class="text-danger font-weight-bold"><i class="font-weight-normal fa fa-ban mr-2" aria-hidden="true"></i>Rejected</span>
						@elseif($aRow->status == 2)
								<span class="text-success font-weight-bold"><i class="font-weight-normal fa fa-check-circle-o mr-2" aria-hidden="true"></i>Accepted</span>
						@else
								<span class="text-secondary font-weight-bold"><i class="font-weight-normal fa-pulse fa fa-spinner mr-2" aria-hidden="true"></i>Pending</span>
						@endif
				</div>
			</div>
			<div class="d-flex justify-content-center pl-3 pr-3 pb-2">
				<div class="p-2">
					<a href="javascript:void(0);" class="booking_icon" onclick="openPopup('{{ route('getBookingDetail', $aRow->id )}}')" title="Update Booking"><i class="fa fa-pencil"></i></a>
				</div>
				<div class="p-2">
					<a href="javascript:void(0);" class="booking_icon" onclick="openPopup('{{ route('getUserDetail', $aRow->property['user']['id'] )}}')" title="Owner detail"><i class="fa fa-user"></i></a>
				</div>
				<div class="p-2">
					<a href="{{ route('bookingdelete', $aRow->id )}}" onclick="return confirm('Do you want to delete this booking');" title="Delete Booking" class="booking_icon"><i class="fa fa-trash"></i></a>
				</div>
				<div class="p-2">
					<a href="{{ route('showmessage',$aRow->property['user']['id'])}}" class="booking_icon" title="Message to Owner"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
				</div>
			</div>
			@else
			@php $reviewStatus = \App\Review::reviewCount($aRow->property['id'],\Auth::user()->id) @endphp
				@if(!$reviewStatus)
			<div class="d-flex justify-content-center pl-3 pr-3 pb-2">
				<div class="p-2">
					<a href="{{route('viewproperty',$aRow->property['id'])}}" class="booking_icon" title="view detail"><i class="fa fa-eye"></i></a>
				</div>
				<div class="p-2">
						<a href="javascript:void(0);" class="booking_icon" onclick="openPopup('{{ route('addReview', $aRow->id )}}')" title="Add Review"><i class="fa fa-star fillstar"></i></a>
				</div>		
				<div class="p-2">
					<a href="javascript:void(0);" class="booking_icon" onclick="openPopup('{{ route('getUserDetail', $aRow->property['user']['id'] )}}')" title="Owner detail"><i class="fa fa-user"></i></a>
				</div>
			</div>
				@endif
			@endif
		</div>
	</div>		
			