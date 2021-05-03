<?php

namespace App\Listeners;

use App\Events\UserCharged;
use App\Notifications\OrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendUserChargedNotification
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
     * @param  UserCharged  $event
     * @return void
     */
    public function handle(UserCharged $event)
    {
        $event->order->user->notify(new OrderNotification($event->order , 'userCharged'));
    }
}
