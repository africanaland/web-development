<form method="get" class="searchlist"> 
	<div class="row"><div class="col-md-12">Filter:</div></div>
	<div class="row">
		{{-- <div class="col-md-3">
			<div class="input-group m-b-0">
				<input type="text" value="{{ $aQvars ? $aQvars['keyword'] : ''}}" name="keyword" class="form-control" placeholder="Search...">
			</div>
		</div> --}}

		@if($type == "guest")
		<div class="col-md-3">
			<div class="input-group m-b-0">
				{{ Form::select('country', ['' =>'Select Country'] + $aCountries, $aQvars ? $aQvars['country'] : 0 , ['class' => 'form-control ms']) }}
			</div>
		</div>
		<div class="col-md-3">
			<div class="input-group m-b-0">
				{{ Form::select('membership', ['' =>'Select Membership'] + $aMemberships, $aQvars ? $aQvars['membership'] : 0 , ['class' => 'form-control ms']) }}
			</div>
		</div>
		@endif

		@if($aRoles)
		<div class="col-md-3">
			<div class="input-group m-b-0">
				{{ Form::select('role_id', ['' =>'Please Select'] + $aRoles, $aQvars ? $aQvars['role_id'] : 0 , ['class' => 'form-control ms']) }}
			</div>
		</div>
		@endif
		{{--<div class="col-md-3">
			<button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Search</button>
		</div>--}}
	</div>
</form>