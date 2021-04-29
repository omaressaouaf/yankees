<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExtraStoreRequest;
use App\Http\Requests\ExtraUpdateRequest;
use App\Models\Extra;
use App\Models\Option;
use Illuminate\Support\Facades\DB;

class ExtraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $extras =  Extra::latest()->with('options')->withCount('options')->get();
        return response()->json([
            'extras' => $extras
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExtraStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $extra =  Extra::create([
                'name' => $request->name,
                "label" => $request->label,
                'title' => $request->title,
            ]);
            $extra->options()->createMany($request->newOptions);
            DB::commit();
            return response()->json([
                'message' => 'extra created succefully',
                'extra' => $extra
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => "Error Occured ! extra wasn't created"], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Extra $extra)
    {


        return response()->json([
            'extra' => $extra->load('options')
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExtraUpdateRequest $request, Extra $extra)
    {
        try {
            DB::beginTransaction();
            $extra->update([
                'name' => $request->name,
                "label" => $request->label,
                'title' => $request->title,
            ]);

            if ($request->newOptions) {
                $extra->options()->createMany($request->newOptions);
            }
            if ($request->deletedOptions) {
                // deleting the options from the options table
                foreach ($request->deletedOptions as $optionId) {
                    Option::findOrFail($optionId)->delete();
                }
                // filtering  the deleted options out of the pivot table
                foreach ($extra->meals as $meal) {

                    $filteredSelectedOptions = array_diff($meal->pivot->admin_selected_options, $request->deletedOptions);
                    if (count($filteredSelectedOptions) == 0) {
                        $extra->meals()->detach($meal->id);
                    } else {
                        $extra->meals()->updateExistingPivot($meal->id, [
                            'admin_selected_options' => [...$filteredSelectedOptions]
                        ]);
                    }
                }
            }
            DB::commit();
            return response()->json([
                'message' => 'extra updated succefully',
                'extra' => $extra
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => "Error Occured ! extra wasn't updated ." . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Extra $extra)
    {
        $extra->delete();
        return response()->json([
            'message' => 'extra deleted succefully'
        ], 200);
    }
    public function bulk_destroy($ids)
    {

        $idsExploded = explode(',', $ids);
        foreach ($idsExploded as $id) {
            $extra =  Extra::findOrFail($id);
            $extra->delete();
        }
        return response()->json([
            'message' => "extra(s) have been deleted",
        ], 200);
    }
}
