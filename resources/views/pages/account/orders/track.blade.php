@extends('layouts.account')
@section('account-content')
    <div class="mt-4">
        <h4 class="font-weight-bold"># {{ __('Order Tracker') }}</h4>
        <p class="text-muted  mb-5">{{ __('Track your Order') }}</p>
        <order-tracker :tracked-order="{{ $order }}"></order-tracker>
        
    </div>
@endsection
