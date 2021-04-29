<?php

namespace App\Http\Controllers;



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
