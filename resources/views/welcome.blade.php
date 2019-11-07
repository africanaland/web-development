@extends('layouts.appHome')
@section('title') Home @endsection
@section('content')

<div class="container homeMainDiv">
	<div class="row">
		<div class="col-xl-4 col-md-6 ml-sm-5">
			<form method="post" action="{{ route('searchproperty') }}">
				 @csrf
			<div class="afShadowBox mt-4 mb-5">

				<div class="container-fluid pl-0 pr-0 homeSearchBlock">
					<div class="row ">
						<div class="col-md-12">
							<h3>Book & Expereience <br> Amazing Places</h3>
							<p>Lorem Ipsum is simply dummy text of the printing.</p>
						</div>
					</div>
					<div class="row homeForm mx-0">
						<div class="col-md-6 p-1">
							<div class="form-group">
								{{ Form::select('country', ['' =>'Select Country'] + $aCountries,  old('country') , ['class' => 'form-control show-tick', 'required' => 'required','onchange' => 'getcity(this)']) }}
  							</div>
						</div>
						<div class="col-md-6 p-1">
							<div class="form-group citywrap">
								{{ Form::select('city', ['' =>'City'], old('city') , ['class' => 'form-control ', ]) }}
  							</div>
						</div>

						<div class="col-md-6 p-1">
							<div class="form-group">
    							<div class="input-group ">
								  <div class="input-group-prepend">
								    <span class="input-group-text border-right-0">
								    	<img src="{{ asset('public/images/cal.png')  }}" alt="">
								    </span>
								  </div>
								  <input type="text" autocomplete="false" name="checkin" class="border-left-0 form-control datepicker-input" id="" placeholder="Check In">
								</div>
  							</div>
						</div>
						<div class="col-md-6 p-1">
							<div class="form-group">
    							<div class="input-group ">
								  <div class="input-group-prepend">
								    <span class="input-group-text border-right-0">
								    	<img src="{{ asset('public/images/cal.png')  }}" alt="">
								    </span>
								  </div>
								  <input type="text" autocomplete="false" name="checkout" class="border-left-0 form-control datepicker-input" id="" placeholder="Check Out">
								</div>
  							</div>
						</div>

						<div class="col-md-6 p-1">
							<div class="form-group">
								<input type="number" name="adults" class="form-control" id="" placeholder="Adults" min="1">
  							</div>
						</div>
						<div class="col-md-6 p-1">
							<div class="form-group">
								<input type="number" name="children" class="form-control" id="" placeholder="Children" min="1">
  							</div>
						</div>


						<div class="col-md-6 p-1">
							<div class="form-group">
								<input type="number" name="rooms" class="form-control" id="" placeholder="Rooms" min="1">
  							</div>
						</div>
						<div class="col-md-6 p-1">
							<div class="form-group ">
								{{ Form::select('host', ['' =>'ALL'] + $aHosts,  old('host') , ['class' => 'form-control show-tick']) }}
  							</div>
						</div>

						<div class="col-md-12 p-1">
							<button class="btn btn-afland" type="submit">Search</button>
						</div>
					</div>
				</div>
			</div>
		</form>
		</div>
	</div>
</div>


@endsection

