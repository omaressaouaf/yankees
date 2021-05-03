<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;



class PageController extends Controller
{
    public function home()
    {
        // return redirect()->route(
        //     'cashier.payment',
        //     ['pi_1ImMfJBO6k85rNghthpYEAOZ', 'redirect' => route('home')]
        // );
        return view('pages.home');
    }
    public function about()
    {
        return view('pages.about');
    }
}
