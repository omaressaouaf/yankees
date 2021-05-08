<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AccountController extends Controller
{
    public function dashboard()
    {
        /** @var \App\Models\User */
        $authUser =  auth()->user();
        $latestAuthUserOrders = $authUser->orders()->latest()->take(4)->get();
        return view('pages.account.dashboard', compact('latestAuthUserOrders'));
    }
    public function profile()
    {
        return view('pages.account.profile');
    }
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'required',
        ]);
        /** @var \App\Models\User */
        $authUser =  auth()->user();
        $authUser->update(request()->only(['name', 'email', 'phone']));
        return back()->with('success_message', __('Profile Updated successfully'));
    }

    public function addresses()
    {
        return view('pages.account.addresses');
    }
    public function password()
    {
        return view('pages.account.password');
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'new_password_confirm' => 'required|same:new_password',
        ]);

        $current_password = auth()->user()->password;
        if (!Hash::check(request()->current_password, $current_password)) {
            throw ValidationException::withMessages([__('The provided password does not match your current password.')]);
        }
        /** @var \App\Models\User */
        $authUser =  auth()->user();
        $authUser->password = Hash::make(request()->new_password);
        $authUser->save();
        return back()->with('success_message', __('Password Updated successfully'));
    }
}
