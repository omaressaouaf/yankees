<?php

namespace App\Http\Controllers\API\V1\Shared;

use App\Models\User;
use App\Models\Address;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\AddressStoreRequest;

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
        abort_if(($request->userId != auth()->id()) && Gate::denies('manage-fully'), 401, 'Unauthorized');

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
        abort_if(($address->user_id != auth()->id()) && Gate::denies('manage-fully'), 401, 'Unauthorized');
        $address->delete();
        return response()->json([
            'msg' => "address deleted successfully"
        ]);
    }
}
