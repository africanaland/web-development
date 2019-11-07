@extends('layouts.app')

@section('title') Notifications @endsection

@section('content')
<div class="container pageWrapper">
    <div class="row justify-content-center">
        <div class="col-md-10 col-sm-11">
            <div class="card">
                <div class="card-header border-bottom-0">All Notifications</div>
                <div class="card-body px-0 notifyBorder">
                    @php $notifyData = App\notification::getNotification() @endphp
                    @forelse ($notifyData as $key => $aRow)
                    <div class="content mb-3">
                        <div class="clearfix mb-2">
                            <div class="float-left">
                                <h5 class="mb-0 font-weight-bold text-size15 notifyTitle">{{$aRow->title}}</h5>
                            </div>
                            <div class="float-right text-right">
                                <h6 class="mb-0 notifyTime">
                                    {{ App\Helpers\CustomHelper::getNotificationTime($aRow->created_at)}}
                                </h6>
                            </div>
                        </div>
                        @if ($aRow->n_key == "text")
                            <p class="text-secondary text-justify notifyText mb-2"><?PHP echo $aRow->detail ?></p>                            
                        @else
                            @php $detail = App\Helpers\CustomHelper::getNotificationMgs($aRow->id,$aRow->n_key) @endphp                            
                            <p class="text-secondary text-justify notifyText mb-2"><?PHP echo $detail ?></p>
                        @endif
                        <h5 class="notifyColor mb-3">
                        @if ($aRow->s_id == 1)
                            By Admin
                        @elseif($aRow->s_id == 0)
                            Broadcast
                        @else
                        @php $userData = App\User::getUserData($aRow->s_id,array('fname')) @endphp
                        {{$userData->fname}}
                        @endif
                        </h5>
                    </div>{{-- end content --}}

                    @empty
                        No Notification
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
