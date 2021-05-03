<?php

namespace App\Listeners;

use App\Models\Role;
use App\Notifications\OrderNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendPaymentConfirmationObtainedNotification
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $admins = Role::where('name', 'admin')->first()->users;
        Notification::send($admins, new OrderNotification($event->order,  'paymentConfirmationObtained'));
    }
}
