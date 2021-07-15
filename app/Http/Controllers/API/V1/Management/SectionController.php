<?php

namespace App\Http\Controllers\API\V1\Management;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::all();
        return response()->json([
            'sections' => $sections
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section)
    {
        foreach (config('app.available_locales') as $locale) {
            $section->update([
                'title_' . $locale => $request['title_' . $locale],
                'content_' . $locale => $request['content_' . $locale]
            ]);
        }
        return response()->json([
            'section' => $section,
            'message' => 'section updated successfully'
        ], 200);
    }
}
