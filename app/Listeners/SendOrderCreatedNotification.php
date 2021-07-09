<?php

namespace App\Listeners;

use App\Models\Role;
use App\Models\User;
use App\Events\OrderCreated;
use App\Notifications\OrderNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendOrderCreatedNotification
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
     * @param  OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        $adminsAndManagers = Role::whereIn('name', ['admin', 'manager'])->first()->users;
        Notification::send($adminsAndManagers, new OrderNotification($event->order,  'orderCreated'));
    }
}
