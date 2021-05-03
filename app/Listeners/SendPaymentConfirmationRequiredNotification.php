<?php

namespace App\Listeners;

use App\Notifications\OrderNotification;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\PaymentConfirmationRequired;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Cashier\Payment;

class SendPaymentConfirmationRequiredNotification
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
     * @param  PaymentConfirmationRequired  $event
     * @return void
     */
    public function handle(PaymentConfirmationRequired $event)
    {
        $event->order->user->notify(
            new OrderNotification($event->order, "paymentConfirmationRequired" , $event->payment)
        );
    }
}
