<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{

    public function __invoke()
    {

        /** @var \App\Models\User */
        $authUser = auth()->user();
        if (config('payment.stripeEnabled')) {
            return view('pages.checkout')->with('intent', $authUser->createSetupIntent(['usage' => "off_session"]));
        }
        return view('pages.checkout');
    }
}
