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
        $meals = Meal::latest();

        if (request()->search_query) {
            $meals = $meals->where('title', 'like', '%' . request()->search_query . '%')->orWhere('desc', 'like', '%' . request()->search_query . '%');
        }
        if (request()->category) {
            $category_id = Category::where('slug', request()->category)->pluck('id')->first();
            $meals = $meals->where('category_id', $category_id);
        }
        if (request()->max_price) {
            $meals = $meals->where('price', '<=', request()->max_price);
        }
        return response()->json([
            'meals' => $meals->with(['category', 'extras', 'extras.options'])->paginate(9)
        ]);
    }
}
