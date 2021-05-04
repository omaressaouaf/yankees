<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Gate;



class PageController extends Controller
{
    public function home()
    {

        return view('pages.home');
    }
    public function about()
    {
        return view('pages.about');
    }
}
