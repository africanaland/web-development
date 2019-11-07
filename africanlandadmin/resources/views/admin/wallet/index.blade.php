@extends('admin.layouts.app')

@php
$page_name = "Finance Detail"
@endphp
@inject('wallet', 'App\walletHistory')
@inject('roleDetail', 'App\Role')
@php
$aUser = Auth::guard('admin')->user();
 $balance = $wallet->countWallet($aUser->id);
@endphp
@section('title') {{ $page_name }} @endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="javascript:void(0);">{{ $page_name }}</a></li>
@endsection

@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2>{{ $page_name }}</h2>
            </div>

                <div class="row mx-0 body justify-content-center">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="d-sm-flex justify-content-between pt-4 addRightBorder">
                                <div class="text-center flex-fill py-sm-3 py-1"><b>Balance</b> <br> ${{$balance->userAmount ?? '0'}}</div>
                                <div class="text-center flex-fill py-sm-3 py-1"><b>Income</b> <br> ${{$income->userAmount ?? '0'}}</div>
                                <div class="text-center flex-fill py-sm-3 py-1"><b>Expanse</b> <br> ${{$expanse->userAmount ?? '0'}}</div>
                            </div>
                        </div>
                        @if (count($aRows))
                            
                        <div class="card border-top">
                            <h4>All transaction</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>MARK</th>
                                            <th>Pay to</th>
                                            <th>Role</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($aRows as $key => $item)                                
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $item->mark }}</td>
                                            <td>{{ $item['user']->fname.' '.$item['user']->lname }}</td>
                                            <td>{{ $roleDetail->getRolename($item['user']->role_id,'name') }}</td>
                                            <td>{{ $item->amount }}
                                                @if(($item->user_id == $aUser->id) || $item->mark == App\walletHistory::mark1)
                                                <i class="material-icons text-danger text-bold">arrow_downward</i>
                                                @else
                                                <i class="material-icons text-success text-bold">arrow_upward</i>
                                                @endif
                                            </td>
                                            <td>{{ date('d/M/y',strtotime($item->created_at)) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        @endif

                    </div>
                </div>
        </div>
    </div>
</div>

@endsection