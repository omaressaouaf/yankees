<?php

namespace App\Http\Controllers;


use App\Models\Meal;
use App\Models\Category;
use Illuminate\Http\Request;


class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!request()->ajax()) {

            return view('pages.meals.index');
        }
        $categories = Category::with('meals' , 'meals.category' , 'meals.extras' , 'meals.extras.options')->orderBy('order')->get();

        return response()->json([
            'categories' => $categories
        ]);
    }
}
