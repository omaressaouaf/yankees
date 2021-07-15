<?php

namespace App\Http\Controllers\API\V1\Management;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories =  Category::latest()->withCount('meals')->orderBy('order')->get();
        return response()->json([
            'categories' => $categories
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request)
    {
        $category =  Category::create([
            'name' => $request->name,
            'slug' => $request->slug
        ]);
        return response()->json([
            'message' => 'category created succefully',
            'category' => $category
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {

        return response()->json([
            'category' => $category
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category->update([
            'name' => $request->name,
            'slug' => $request->slug
        ]);
        return response()->json([
            'message' => 'category updated succefully',
            'category' => $category

        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            'message' => 'category deleted succefully'
        ], 200);
    }
    public function bulk_destroy($ids)
    {
        $idsExploded = explode(',', $ids);
        foreach ($idsExploded as $id) {
            $category =  Category::findOrFail($id);
            $category->delete();
        }
        return response()->json([
            'message' => "categorie(s) have been deleted",
        ], 200);
    }
    public function updateOrders(Request $request)
    {
        foreach ($request->categories as $category) {
            Category::find($category['id'])->update(['order' => $category['order']]);
        }
        return response()->json([
            'message' => "orders updated"
        ], 200);
    }
}
