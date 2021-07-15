<?php

namespace App\Http\Controllers\API\V1\Client;

use App\Models\Category;
use App\Http\Controllers\Controller;

class MealController extends Controller
{
    public function __invoke()
    {
        $categories = Category::with('meals', 'meals.category', 'meals.extras', 'meals.extras.options')->orderBy('order')->get();

        return response()->json([
            'categories' => $categories
        ]);
    }
}
