<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Section;
use Illuminate\Support\Facades\Gate;
use Spatie\OpeningHours\OpeningHours;



class PageController extends Controller
{
    public function home()
    {
        $latestMeals = Meal::latest()->with('category' , 'extras' , 'extras.options')->take(12)->get();
        return view('pages.home' , compact('latestMeals'));
    }
    public function about()
    {
        return view('pages.about');
    }
}
