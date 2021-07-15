<?php

namespace App\Http\Controllers\API\V1\Client;

use Illuminate\Http\Request;
use App\Services\CheckoutService;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;



class CheckoutController extends Controller
{
    public $checkoutService;
    public function __construct(CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }
    public function __invoke(Request $request)
    {
        $this->authorize('checkout');
        $request->validate([
            'address_id' => "required",
            "paymentMode" => "required|string",
            "nameOnCard" => "required_if:paymentMode,stripe",
            "paymentMethod" => "required_if:paymentMode,stripe"
        ]);
        ['msg' => $msg, 'status' => $status] = $this->checkoutService->checkout($request->address_id, $request->nameOnCard, $request->paymentMode, $request->paymentMethod);
        return response()->json([
            'msg' => __($msg)
        ], $status);
    }
}
