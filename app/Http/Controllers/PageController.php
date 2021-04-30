<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;



class PageController extends Controller
{
    public function landing()
    {
         
        return view('pages.landing');
    }
    public function about()
    {
        return view('pages.about');
    }
}
