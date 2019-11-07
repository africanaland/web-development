@if($aProptypes)
@foreach($aProptypes as $pKey => $aProptype)
<label class="checkbox orange d-sm-inline d-flex mr-2">
        <input type="radio" class=" mr-1" name="property_type" id="{{$aProptype}}"  value="{{$aProptype}}" required>
        <label class="font-weight-normal" for="{{$aProptype}}">{{$aProptype}}</label>
    </label>
@endforeach
@else 
<div>No Service</div>
@endif
