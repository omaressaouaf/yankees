<?php

namespace App\Listeners;

use App\Models\Role;
use App\Events\ClientCancelledOrder;
use App\Notifications\OrderNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendClientCancelledOrderNotification
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
     * @param  ClientCancelledOrder  $event
     * @return void
     */
    public function handle(ClientCancelledOrder $event)
    {
        $admins =Role::where('name' , 'admin')->first()->users;
        Notification::send($admins , new OrderNotification($event->order ,  'clientCancelledOrder'));
    }
}
