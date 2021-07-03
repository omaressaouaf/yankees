<?php

namespace App\Http\Controllers\API;

use App\Events\DeliverymanSelected;
use App\Events\OrderStatusChanged;
use Exception;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Services\CheckoutService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Laravel\Cashier\Exceptions\PaymentFailure;
use Laravel\Cashier\Exceptions\PaymentActionRequired;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderController extends Controller
{
    public $checkoutService;
    public function __construct(CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }

    public function index()
    {
        /** @var \App\Models\User */
        $authUser = auth()->user();
        $orders = $authUser->hasRole('admin')  ? Order::latest()->with('user')->get() : $authUser->deliveryorders;
        return response()->json([
            'orders' => $orders
        ], 200);
    }
    public function show(Order $order)
    {

        $this->authorize('read-order', $order);
        $order['meals'] = $order->detailsWithRemovedMeals();
        return response()->json([
            'order' => $order->load('user', 'deliveryman')
        ], 200);
    }

    public function update(Request $request, Order $order)
    {
        $this->authorize('update-order', [$order, $request->deliveryman_id, $request->status]);
        $request->validate([
            'status' => ['required', Rule::in(['pending', 'processing', 'out_for_delivery', 'delivered', 'cancelled'])],
        ]);

        $order->update([
            'status' => $request->status,
            "deliveryman_id" => $request->deliveryman_id
        ]);
        $changes = $order->getChanges();
        if (array_key_exists('status', $changes) &&  $order->user_id != null && auth()->id() !=  $order->user_id) {
            OrderStatusChanged::dispatch($order);
        }
        if (array_key_exists('deliveryman_id', $changes) &&  $order->deliveryman_id != null && auth()->id() !=  $order->deliveryman_id) {
            DeliverymanSelected::dispatch($order);
        }
        return response()->json([
            'message' => 'order updated succefully',
            "order" => $order->load('user', 'deliveryman')
        ], 200);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json([
            'message' => 'extra deleted succefully'
        ], 200);
    }
    public function bulk_destroy($ids)
    {
        $idsExploded = explode(',', $ids);
        foreach ($idsExploded as $id) {
            $order =  Order::findOrFail($id);
            $order->delete();
        }
        return response()->json([
            'message' => "order(s) have been deleted",
        ], 200);
    }
    public function chargeUser(Request $request, Order $order)
    {
        $this->authorize('charge', $order);

        ['msg' => $msg, 'status' => $status] = $this->checkoutService->chargeUser($order);
        return response()->json([
            'msg' => __($msg)
        ], $status);
    }
    public function refundUser(Request $request, Order $order)
    {
        $this->authorize('refund', $order);

        ['msg' => $msg, 'status' => $status] = $this->checkoutService->refundUser($order);
        return response()->json([
            'msg' => __($msg)
        ], $status);
    }
}
