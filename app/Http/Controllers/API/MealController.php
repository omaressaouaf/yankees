<?php

namespace App\Http\Controllers\API;

use App\Models\Meal;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Http\Requests\MealStoreRequest;
use App\Http\Requests\MealUpdateRequest;

class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $meals =  Meal::latest()->with('category')->withCount('extras')->get();
        return response()->json([
            'meals' => $meals
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MealStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $meal =  Meal::create([
                'title' => $request->title,
                'desc' => $request->desc,
                'price' => $request->price,
                'active' => $request->active,
                'category_id' => $request->category_id
            ]);
            if ($request->hasFile('newImage')) {
                // file upload
                $fileNameToDB = $this->uploadFile($request, $meal->id);
                $meal->image = $fileNameToDB[0];
                $meal->resized_image = $fileNameToDB[1];
                $meal->save();
            }
            if ($request->extras) {
                foreach ($request->extras as $extra) {

                    $meal->extras()->attach(
                        $extra['id'],
                        [
                            'admin_selected_options' => $extra['pivot']['admin_selected_options'],
                            'min' => $extra['pivot']['min'],
                            'max' => $extra['pivot']['max']
                        ]
                    );
                }
            }
            DB::commit();

            return response()->json([
                'message' => 'meal created succefully',
                'meal' => $meal
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => "Error Occured ! meal wasn't created"], 500);
        }
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function show(Meal $meal)
    {

        return response()->json([
            'meal' => $meal->load(['category', 'extras', 'extras.options'])
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MealUpdateRequest $request, Meal $meal)
    {
        try {
            DB::beginTransaction();
            $meal->update([
                'title' => $request->title,
                'desc' => $request->desc,
                'price' => $request->price,
                'active' => $request->active,
                'category_id' => $request->category_id,
            ]);
            $meal->extras()->detach();
            if ($request->extras) {
                foreach ($request->extras as $extra) {
                    $meal->extras()->attach(
                        $extra['id'],
                        [
                            'admin_selected_options' => $extra['pivot']['admin_selected_options'],
                            'min' => $extra['pivot']['min'],
                            'max' => $extra['pivot']['max']
                        ]
                    );
                }
            }

            // file upload
            if ($request->hasFile('newImage')) {
                if ($meal->image !== "/storage/images/meals/noimage.jpg") {
                    $meal->deleteOldImages();
                }
                $fileNameToDB = $this->uploadFile($request, $meal->id);
                $meal->image = $fileNameToDB[0];
                $meal->resized_image = $fileNameToDB[1];
                $meal->save();
            }
            DB::commit();
            return response()->json([
                'message' => 'meal updated succefully',
                'meal' => $meal
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => "Error Occured ! meal wasn't updated"] , 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meal $meal)
    {
        $meal->deleteOldImages();
        $meal->delete();
        return response()->json([
            'message' => 'meal deleted succefully'
        ], 200);
    }
    public function bulk_destroy($ids)
    {

        $idsExploded = explode(',', $ids);
        foreach ($idsExploded as $id) {
            $meal =  Meal::findOrFail($id);
            $meal->deleteOldImages();
            $meal->delete();
        }
        return response()->json([
            'message' => "meal(s) have been deleted",
        ], 200);
    }
    private function uploadFile($request, $meal_id)
    {
        $fileNameWithExt = $request->file('newImage')->getClientOriginalName();
        $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('newImage')->getClientOriginalExtension();

        // normal size upload
        $fileNameToStore = $filename . '_' . time() . Str::random(10) . '.' . $extension;
        $request->file('newImage')->storeAs('public/images/meals/' . $meal_id, $fileNameToStore);
        // resized upload
        $fileNameToStoreResized = $filename . '_resized_' . time() . Str::random(10) . '.' . $extension;
        $request->file('newImage')->storeAs('public/images/meals/' . $meal_id, $fileNameToStoreResized);
        Image::make(public_path('storage/images/meals/' . $meal_id . '/' . $fileNameToStoreResized))->fit(800, 600)->save();

        // save normal and resized in database
        $fileNameToDB = '/storage/images/meals/' . $meal_id . '/' . $fileNameToStore;
        $fileNameToDBResized = '/storage/images/meals/' . $meal_id . '/' . $fileNameToStoreResized;
        return [$fileNameToDB, $fileNameToDBResized];
    }
}
