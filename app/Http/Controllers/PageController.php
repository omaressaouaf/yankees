<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Section;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Spatie\OpeningHours\OpeningHours;



class PageController extends Controller
{
    public function home()
    {
        $categories = Category::with('meals' , 'meals.category' , 'meals.extras' , 'meals.extras.options')->orderBy('order')->get();

        return view('pages.home', compact('categories'));
    }
    public function about()
    {
        return view('pages.about');
    }
}
