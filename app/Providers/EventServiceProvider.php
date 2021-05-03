<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use App\Events\OrderCreated;
use App\Listeners\SendOrderCreatedNotification;
use App\Events\DeliverymanSelected;
use App\Listeners\SendDeliverymanSelectedNotification;
use App\Events\OrderStatusChanged;
use App\Listeners\SendOrderStatusChangedNotification;
use App\Events\PaymentConfirmationRequired;
use App\Listeners\SendPaymentConfirmationRequiredNotification;
use App\Events\UserCharged;
use App\Listeners\SendUserChargedNotification;
use App\Events\UserRefunded;
use App\Events\PaymentConfirmationObtained;
use App\Listeners\SendPaymentConfirmationObtainedNotification;
use App\Listeners\SendUserRefundedNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OrderCreated::class => [
            SendOrderCreatedNotification::class,
        ],
        DeliverymanSelected::class => [
            SendDeliverymanSelectedNotification::class,
        ],
        OrderStatusChanged::class => [
            SendOrderStatusChangedNotification::class,
        ],
        PaymentConfirmationRequired::class => [
            SendPaymentConfirmationRequiredNotification::class,
        ],
        UserCharged::class => [
            SendUserChargedNotification::class,
        ],
        UserRefunded::class => [
            SendUserRefundedNotification::class,
        ],
        PaymentConfirmationObtained::class =>  [
            SendPaymentConfirmationObtainedNotification::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
