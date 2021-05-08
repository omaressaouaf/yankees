<?php

namespace App\Http\Controllers;

use App\Events\ClientCancelledOrder;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {

        /** @var \App\Models\User */
        $authUser =  auth()->user();
        $authUserOrders = $authUser->orders()->latest()->paginate(5);
        return view('pages.account.orders.index', compact('authUserOrders'));
    }
    public function track(Order $order)
    {

        $this->authorize('track_order', $order->status);
        return view('pages.account.orders.track', compact('order'));
    }
    public function cancel(Order $order)
    {

        $this->authorize('cancel_order', $order);
        $order->update([
            'status' => 'cancelled'
        ]);
        ClientCancelledOrder::dispatch($order);
        return response()->json(['msg' => 'Success']);

    }
}
