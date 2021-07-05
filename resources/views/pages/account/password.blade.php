@extends('layouts.account')
@section('title')
Changement de mot de passe -
@endsection
@section('account-content')
    <div class="mt-4">
        <h4 class="font-weight-bold"># {{ __('Your Password') }}</h4>
        <p class="text-muted  mb-4">{{ __('Edit Your Password') }}</p>
        <form action="{{ route('account.password.update') }}" method="POST">
            @method('PUT')
            @csrf
            @include('includes.alerts')
            <div class="form-group">
                <label for="exampleInputEmail1">{{ __('Current Password') }}</label>
                <input type="password" class="form-control " name="current_password" value="{{ old('current_password') }}">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">{{ __('New Password') }}</label>
                <input type="password" class="form-control " name="new_password" value="{{ old('new_password')}}">

            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">{{ __('Confirm New Password') }}</label>
                <input type="password" class="form-control " name="new_password_confirm" value="{{ old('new_password_confirm')}}">

            </div>
            <button type="submit" class="btn-orange btn-square">{{ __('Save') }}</button>
        </form>

    </div>
@endsection
