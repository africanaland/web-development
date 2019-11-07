<?php

namespace App\Listeners;

use App\Events\sendNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\notification;

class notificationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  sendNotification  $event
     * @return void
     */
    public function handle(sendNotification $event)
    {
        $aRow['s_id'] = $event->sender_id;
        $aRow['r_id'] = $event->receiver_id;
        $aRow['text_id'] = $event->text_id;
        $aRow['data_id'] = $event->data_id;

        notification::create($aRow);
    }
}
