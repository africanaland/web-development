<form method="get" class="searchlist"> 
	<div class="row">
		{{-- <div class="col-md-3">
			<div class="input-group m-b-0">
				<input type="text" value="{{ $aQvars ? $aQvars['keyword'] : ''}}" name="keyword" class="form-control" placeholder="Search...">
			</div>
		</div>

		<div class="col-md-3">
			<button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Search</button>
		</div>
		--}} 
		
		<div class="col-md-3">
			<div class="input-group m-b-0">
				{{ Form::select('membership', ['' =>'Select Membership'] + $aMemberships, $aQvars ? $aQvars['membership'] : 0 , ['class' => 'form-control ms']) }}
			</div>
		</div>
		
		
	</div>
</form>