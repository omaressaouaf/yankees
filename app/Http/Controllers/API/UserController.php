<?php

namespace App\Http\Controllers\API;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users =  User::latest()->with('roles')->get();
        return response()->json([
            'users' => $users
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {


        try {
            DB::beginTransaction();
            $user =  User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);
            $user->roles()->sync(array_column($request->roles, 'id'));
            DB::commit();
            return response()->json([
                'message' => 'user created succefully',
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => "user wasn't created. " . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json([
            'user' => $user->load('roles')
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        try {
            DB::beginTransaction();
            $user->update($request->only(['name', 'email', 'phone']));
            $user->roles()->sync(array_column($request->roles, 'id'));
            DB::commit();
            return response()->json([
                'message' => 'user updated succefully',
                'user' => $user
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => "user wasn't updated. " . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'message' => 'user deleted succefully'
        ], 200);
    }
    public function bulk_destroy($ids)
    {
        $idsExploded = explode(',', $ids);
        foreach ($idsExploded as $id) {
            User::findOrFail($id)->delete();
        }
        return response()->json([
            'message' => "user(s) have been deleted",
        ], 200);
    }
    public function getDeliverymen()
    {
        $deliverymen =  Role::where('name', 'deliveryman')->first()->users;
        return response()->json([
            'deliverymen' => $deliverymen
        ], 200);
    }
    public function getRoles()
    {
        $roles = Role::all();
        return response()->json([
            'roles' => $roles
        ]);
    }
}
