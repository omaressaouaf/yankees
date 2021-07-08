<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Meal;
use App\Models\Section;
use Illuminate\Support\Facades\Gate;
use Spatie\OpeningHours\OpeningHours;



class PageController extends Controller
{
    public function home()
    {
        $latestMeals = Meal::latest()->with('category' , 'extras' , 'extras.options')->where('active', 1)->get();
        $categories = Category::all();
        return view('pages.home' , compact('latestMeals' , 'categories'));
    }
    public function about()
    {
        return view('pages.about');
    }
}
