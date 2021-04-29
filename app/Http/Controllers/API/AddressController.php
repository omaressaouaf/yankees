<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\AddressStoreRequest;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AddressController extends Controller
{

    public function index()
    {
        $user = User::findOrFail(request()->userId);
        return response()->json([
            'addresses' => $user->addresses
        ]);
    }

    public function store(AddressStoreRequest $request)
    {
        $user = User::findOrFail($request->userId);
        $address = $user->addresses()->create([
            'line' => $request->line,
            'details' => $request->details,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);
        return response()->json([
            'address' => $address,
            'msg' => "address created successfully"
        ]);
    }

    public function destroy(Address $address)
    {
        abort_unless($address->user_id == auth()->id() || auth()->user(), 401, 'Unauthorized');
        $address->delete();
        return response()->json([
            'msg' => "address deleted successfully"
        ]);
    }
}
