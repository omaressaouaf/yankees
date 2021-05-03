<?php

namespace App\Listeners;

use App\Events\UserRefunded;
use App\Notifications\OrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendUserRefundedNotification
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
     * @param  UserRefunded  $event
     * @return void
     */
    public function handle(UserRefunded $event)
    {
         $event->order->user->notify(new OrderNotification($event->order , 'userRefunded'));
    }
}
