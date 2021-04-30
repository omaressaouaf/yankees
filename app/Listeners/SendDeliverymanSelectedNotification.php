<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\DeliverymanSelected;
use App\Notifications\OrderNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendDeliverymanSelectedNotification
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
     * @param  DeliverymanSelected  $event
     * @return void
     */
    public function handle(DeliverymanSelected $event)
    {
        $event->order->deliveryman->notify(new OrderNotification($event->order, "deliverymanSelected"));
    }
}
