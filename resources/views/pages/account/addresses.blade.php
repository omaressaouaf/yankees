@extends('layouts.account')
@section('account-content')
    <div class="mt-4">
        <h4 class="font-weight-bold"># {{ __('Your Address Book') }}</h4>
        <p class="text-muted mb-4">
            {{ __('Here you can register your addresses') }}
        </p>
        <address-list :user-id="{{ auth()->id() }}" :apply-front-theme="{{true}}" />
    </div>
@endsection
@section('scripts')
    @parent
    <script>

    </script>
@endsection
