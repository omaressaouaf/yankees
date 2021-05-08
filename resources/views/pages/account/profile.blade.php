@extends('layouts.account')
@section('account-content')
    <div class="mt-4">
        <h4 class="font-weight-bold"># {{ __('Your Profile') }}</h4>
        <p class="text-muted  mb-4">{{ __('Edit your personal information') }}</p>
        <form action="{{ route('account.profile.update') }}" method="POST">
            @method('PUT')
            @csrf
            @include('includes.alerts')
            <div class="form-group">
                <label for="exampleInputEmail1">{{ __('Name') }}</label>
                <input type="text" class="form-control " name="name" value="{{ old('name') ?? auth()->user()->name }}">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">{{ __('Email Address') }}</label>
                <input type="text" class="form-control " name="email" value="{{ old('email') ?? auth()->user()->email }}">

            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">{{ __('Phone') }}</label>
                <input type="text" class="form-control " name="phone" value="{{ old('phone') ?? auth()->user()->phone }}">
                <small id="emailHelp"
                    class="form-text text-muted">{{ __('We use this number to verify the order') }}.</small>
            </div>
            <button type="submit" class="btn-orange btn-square">{{ __('Save') }}</button>
        </form>

    </div>
@endsection
