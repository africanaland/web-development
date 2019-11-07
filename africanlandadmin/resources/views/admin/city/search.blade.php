<form method="get"> 
	<div class="row">
		<div class="col-md-3">
			<div class="input-group m-b-0">
				<input type="text" value="{{ isset($aQvars['keyword']) ? $aQvars['keyword'] : ''}}" name="keyword" class="form-control" placeholder="Search...">
			</div>
		</div>
		

		@if($aCountries)
		<div class="col-md-3">
			<div class="input-group m-b-0">
				{{ Form::select('country', ['' =>'Please Select'] + $aCountries, $aQvars ? $aQvars['country'] : 0 , ['class' => 'form-control ms']) }}
			</div>
		</div>
		@endif
		<div class="col-md-3">
			<button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Search</button>
		</div>
	</div>
</form>