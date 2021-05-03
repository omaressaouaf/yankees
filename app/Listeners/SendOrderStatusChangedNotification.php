<?php

namespace App\Listeners;

use App\Events\OrderStatusChanged;
use App\Notifications\OrderNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderStatusChangedNotification
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
     * @param  OrderStatusChanged  $event
     * @return void
     */
    public function handle(OrderStatusChanged $event)
    {
        $event->order->user->notify(new OrderNotification($event->order, "orderStatusChanged"));
    }
}
