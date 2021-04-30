<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use App\Events\OrderCreated;
use App\Listeners\SendOrderCreatedNotification;
use App\Events\DeliverymanSelected;
use App\Listeners\SendDeliverymanSelectedNotification;
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
