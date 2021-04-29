<?php

namespace App\Http\Controllers\API;

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

    public function index()
    {
        $orders = auth()->user()->role == "admin"  ? Order::latest()->with('user')->get() : auth()->user()->deliveryorders;
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
        if ($request->status != $order->status) {
            // TODO : OrderStatusChanged event . broadcast notification to user
        }
        if ($request->deliveryman_id != $order->deliveryman_id) {
            // TODO : DeliverymanSelected event . broadcast notification to deliveryman
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
        ['msg' => $msg, 'status' => $status] = (new CheckoutService)->chargeUser($order);
        return response()->json([
            'msg' => __($msg)
        ], $status);
    }
    public function refundUser(Request $request, Order $order)
    {
        $this->authorize('refund', $order);
        ['msg' => $msg, 'status' => $status] = (new CheckoutService)->refundUser($order);
        return response()->json([
            'msg' => __($msg)
        ], $status);
    }
}
