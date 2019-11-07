<form method="get" class="searchlist"> 
	<div class="row"><div class="col-md-12">Filter:</div></div>
	<div class="row">
		{{-- <div class="col-md-3">
			<div class="input-group m-b-0">
				<input type="text" value="{{ $aQvars ? $aQvars['keyword'] : ''}}" name="keyword" class="form-control" placeholder="Search...">
			</div>
		</div> --}}

		
		
		@if(isset($aMemberships) && $aMemberships)
		<div class="col-md-3">
			<div class="input-group m-b-0">
				{{ Form::select('membership', ['' =>'Select Membership'] + $aMemberships, $aQvars ? $aQvars['membership'] : 0 , ['class' => 'form-control ms']) }}
			</div>
		</div>
		@endif

		

		@if(isset($aCountries) && $aCountries)
		<div class="col-md-3">
			<div class="input-group m-b-2">
				{{ Form::select('country', ['' =>'Please Select Country'] + $aCountries,  isset($aQvars['country']) ? $aQvars['country'] : null , ['class' => 'form-control ms','onchange' => 'getcity(this)']) }}
			</div>
		</div>
		@endif

		@if(isset($aCities) && isset($aCountries) && $aCountries)
		<div class="col-md-3">
			<div class="input-group m-b-2">
				{{ Form::select('city', ['' =>'Please Select City'] + $aCities,  isset($aQvars['city']) ? $aQvars['city'] : null , ['class' => 'citywrap form-control ms','onchange' => 'getcity(this)']) }}
			</div>
		</div>
		@endif


		@if(isset($aHosttypes) && $aHosttypes)
		<div class="col-md-3">
			<div class="input-group m-b-2">
				{{ Form::select('host_type', ['' =>'Select Host Type'] + $aHosttypes, isset($aQvars['host_type']) ? $aQvars['host_type'] : null , ['class' => 'form-control ms']) }}
			</div>
		</div>
		@endif

		@if(isset($aProptypes))
		<div class="col-md-3">
			<div class="input-group m-b-2">
				{{ Form::select('property_type', ['' =>'Select Property Type'] + $aProptypes, isset($aQvars['property_type']) ? $aQvars['property_type'] : null , ['class' => 'subtypewrap form-control ms']) }}
			</div>
		</div>
		@endif

		@if(isset($aRoles) && $aRoles)
		<div class="col-md-3">
			<div class="input-group m-b-0">
				{{ Form::select('role_id', ['' =>'Please Select'] + $aRoles, $aQvars ? $aQvars['role_id'] : 0 , ['class' => 'form-control ms']) }}
			</div>
		</div>
		@endif

		@if(isset($aHostLists) && $aHostLists)
		<div class="col-md-3">
			<div class="input-group m-b-0">
				{{ Form::select('host_id', ['' =>'Please Select'] + $aHostLists, $aQvars ? $aQvars['host_id'] : 0 , ['class' => 'form-control ms']) }}
			</div>
		</div>
		@endif

		@if(isset($aDepartments) && $aDepartments)
		<div class="col-md-3">
			<div class="input-group m-b-0">
				{{ Form::select('department', ['' =>'Please Select'] + $aDepartments, $aQvars ? $aQvars['department'] : 0 , ['class' => 'form-control ms']) }}
			</div>
		</div>
		@endif


		


		{{--<div class="col-md-3">
			<button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Search</button>
		</div>--}}
	</div>
</form>

