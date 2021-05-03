<?php

namespace App\Http\Controllers;

use App\Events\PaymentConfirmationObtained;
use App\Models\Order;
use App\Events\UserCharged;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;


class WebhookController extends CashierController
{

    public function handleChargeSucceeded($payload)
    {
        $orderId = $payload['data']['object']['metadata']['order_id'];
        $order = Order::find($orderId);
        $order->update([
            'user_charged' => true,
        ]);
        PaymentConfirmationObtained::dispatch($order);
        UserCharged::dispatch($order);
        return response('Webhook handled', 200);
    }
}
