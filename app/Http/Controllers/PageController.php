<?php

namespace App\Http\Controllers;

use App\Models\Category;


class PageController extends Controller
{
    public function home()
    {
        $categoriesWithMeals = Category::with('meals' , 'meals.category' , 'meals.extras' , 'meals.extras.options')->orderBy('order')->get();

        return view('pages.home', compact('categoriesWithMeals'));
    }
    public function about()
    {
        return view('pages.about');
    }
}
