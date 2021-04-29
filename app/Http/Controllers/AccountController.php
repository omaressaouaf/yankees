<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function dashboard()
    {
        return view('pages.account.dashboard');
    }
    public function profile()
    {
        return view('pages.account.profile');
    }
    public function orders()
    {
        return view('pages.account.orders');
    }
    public function addresses()
    {
        return view('pages.account.addresses');
    }

}
