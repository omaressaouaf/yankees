<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Spatie\OpeningHours\OpeningHours;
use Illuminate\Support\Facades\Storage;
use Akaunting\Setting\Facade as Setting;
use Spatie\OpeningHours\Exceptions\OverlappingTimeRanges;

class SettingController extends Controller
{

    public function index()
    {
        return response()->json([
            "settings" => Setting::all()
        ]);
    }
    public function app(Request $request)
    {

        $contact = json_decode($request->contact);
        $request->validate(['name' => "required", 'newLogo' => "nullable|image|dimensions:max_width=300,max_height=200"]);
        Setting::set(['app.name' => $request->name, 'app.contact' => $contact]);
        $res = ['msg' => "general settings updated successfully"];
        if ($request->hasFile('newLogo')) {
            $path = $this->uploadLogo($request->file('newLogo'));
            Setting::set('app.logo', $path);
            $res['logo'] =  $path;
        }

        return response()->json($res);
    }
    public function delivery(Request $request)
    {
        $request->validate([
            'price' => "required|integer|min:0",
            "time" => "required|integer|min:0",
            "zone_bounds" => "required",
            "newZoneBounds" => 'nullable',
            "newZoneBounds.south_west.longitude" => 'required_unless:newZoneBounds,null|numeric',
            "newZoneBounds.south_west.latitude" => 'required_unless:newZoneBounds,null|numeric',
            "newZoneBounds.north_east.longitude" => 'required_unless:newZoneBounds,null|numeric',
            "newZoneBounds.north_east.latitude" => 'required_unless:newZoneBounds,null|numeric'
        ]);

        Setting::set(['delivery.price' => $request->price, 'delivery.time' => $request->time]);
        if ($request->newZoneBounds) {
            Setting::set('delivery.zone_bounds', $request->newZoneBounds);
        }
        return response()->json([
            'msg' => "delivery settings updated successfully",
            "zone_bounds" => Setting::get('delivery.zone_bounds')
        ]);
    }
    public function cart(Request $request)
    {
        $request->validate(['tax' => "required|integer|min:0|max:100", "min_order_price" => "required|integer|min:0"]);
        Setting::set(['cart.tax' => $request->tax, 'cart.min_order_price' => $request->min_order_price]);
        return response()->json([
            'msg' => "cart settings updated successfully"
        ]);
    }
    public function schedule(Request $request)
    {
        try {

            $request->validate(['schedule.forcedClose' => "nullable|boolean"]);
            // validate if there is an overlaping
            OpeningHours::create($request->openingHours);
            Setting::set(['schedule' => ['openingHours' => $request->openingHours, "forcedClose" => $request->forcedClose]]);
        } catch (OverlappingTimeRanges $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
    private function uploadLogo($file)
    {
        // upload
        $fileName = "logo_" . Str::random(10) . ".jpg";
        $file->storeAs('public/images/design/', $fileName);
        $path = '/storage/images/design/' . $fileName;
        // resize to logo
        // $img = Image::make(public_path($path))->canvas(219, 161)->resize(219, 161, function ($constraint) {
        //     // maintain the aspect so the image won't be cropped
        //     $constraint->aspectRatio();
        // });
        // $img->save(public_path($path));

        // delete old logo
        $oldLogoExploded = explode('/storage/images/design/', Setting::get('app.logo'));
        if (count($oldLogoExploded) > 1) {
            $oldLogoStoragePath =  "/public/images/design/" . $oldLogoExploded[1];
            Storage::delete($oldLogoStoragePath);
        }
        return $path;
    }
}
