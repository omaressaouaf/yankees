<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CheckoutService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Gloudemans\Shoppingcart\Facades\Cart;


class CheckoutController extends Controller
{
    public $checkoutService;
    public function __construct(CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }
    public function index()
    {
        if (Gate::denies('checkout')) {
            return redirect()->route('meals.index');
        }

        /** @var \App\Models\User */
        $authUser = auth()->user();
        return view('pages.checkout')->with('intent', $authUser->createSetupIntent());
    }

    public function store(Request $request)
    {
        $this->authorize('checkout');
        $request->validate([
            'address_id' => "required",
            "paymentMode" => "required|string",
            "nameOnCard" => "required_if:paymentMode,stripe",
            "paymentMethod" => "required_if:paymentMode,stripe"
        ]);
        ['msg' => $msg, 'status' => $status] =$this->checkoutService->checkout($request->address_id, $request->nameOnCard, $request->paymentMode, $request->paymentMethod);
        return response()->json([
            'msg' => __($msg)
        ], $status);
    }
}
