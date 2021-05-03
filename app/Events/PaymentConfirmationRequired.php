<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Laravel\Cashier\Payment;

class PaymentConfirmationRequired
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $payment;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Order $order ,Payment $payment)
    {
        $this->order = $order;
        $this->payment  = $payment;
    }

    // /**
    //  * Get the channels the event should broadcast on.
    //  *
    //  * @return \Illuminate\Broadcasting\Channel|array
    //  */
    // public function broadcastOn()
    // {
    //     return new PrivateChannel('channel-name');
    // }
}
