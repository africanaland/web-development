{{ Form::select('city', ['' =>'Please Select'] + $aCities, old('city') , ['class' => 'form-control', ]) }}