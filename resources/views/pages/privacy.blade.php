@extends('layouts.app')

@section('title') Privacy Policy @endsection

@section('content')
<div class="container pageWrapper">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card  shadow-md">
                <div class="card-header">Privacy Policy</div>
                <div class="py-4">
                    <div class="cke_wrapper policyContent">{!!html_entity_decode($aPrivacy->description)!!}</div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-5">
            <div class="card shadow-md">
                <div class="card-header">Terms & Conditions</div>
                <div class="py-4">
                    <div class="cke_wrapper policyContent">{!!html_entity_decode($aTerms->description)!!}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
