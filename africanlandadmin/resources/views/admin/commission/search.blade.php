<script>
    var getcityurl = '{{ route("getcity") }}';
    var getsubtypeurl = '{{ route("getsubtype") }}';
</script>
<form method="get"> 
	<div class="row">
		<div class="col-md-3">
			<div class="input-group m-b-2">
				<input type="text" value="{{ $aQvars ? $aQvars['keyword'] : ''}}" name="keyword" class="form-control" placeholder="Search...">
			</div>
		</div>
		<div class="col-md-3">
			<div class="input-group m-b-2">
				{{ Form::select('type', ['' =>'Please Select Hosts'] + $aTypes, isset($aQvars['type']) ? $aQvars['type'] : null , ['class' => 'form-control ms','onchange' => 'getsubtype(this)']) }}
			</div>
		</div>
		<div class="col-md-3">
			<div class="input-group m-b-2">
				{{ Form::select('subtype', ['' =>'Please Select Property Type'] + $aSubTypes, isset($aQvars['subtype']) ? $aQvars['subtype'] : null , ['class' => 'subtypewrap form-control ms']) }}
			</div>
		</div>

		<div class="col-md-3">
			<div class="input-group m-b-2">
				{{ Form::select('country', ['' =>'Please Select Country'] + $aCountries,  isset($aQvars['country']) ? $aQvars['country'] : null , ['class' => 'form-control ms','onchange' => 'getcity(this)']) }}
			</div>
		</div>

		<div class="col-md-3">
			<div class="input-group m-b-2">
				{{ Form::select('city', ['' =>'Please Select City'] + $aCities,  isset($aQvars['city']) ? $aQvars['city'] : null , ['class' => 'citywrap form-control ms','onchange' => 'getcity(this)']) }}
			</div>
		</div>

		
		<div class="col-md-3">
			<button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Save</button>
		</div>
	</div>
</form>