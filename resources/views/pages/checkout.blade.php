@extends('layouts.app')
@section('head')
<script src="https://js.stripe.com/v3/"></script>
@endsection
@section('content')
@include('includes.breadcrumb' , ['pageName'=> __('front.checkout')])
<main id="main">
    <section class="container ">
        <div class="row">
            <div class="col-md-5 order-md-2 mb-4">
                <div class="p-2 ">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-dark ">{{ __('Your Cart') }}</span>
                        <span class="text-secondary"><i class="fa fa-shopping-cart fa-lg"></i></span>
                    </h4>
                </div>
                <div class=" z-depth-1 px-2 py-2">
                    @foreach (Cart::content() as $item)
                    <div class="d-flex py-2">
                        <img width="50" height="50" class="mr-3" src="{{ $item->model->resizedImage }}" alt="">
                        <div class="" style="flex-basis: 80%">

                            <h6 class="my-0">
                                {{ $item->model->title }}
                            </h6>
                            <small class="text-muted"> {!! $item->options->user_selected_options !!}</small>
                            <p class="lead">{{ $item->price }} dhs</p>
                        </div>
                        <span class="text-muted ">X{{ $item->qty }}</span>

                    </div>

                    <hr>
                    @endforeach
                </div>
                <div class="py-2 px-2 d-flex justify-content-between">
                    <span>SubTotal</span>
                    <strong>{{ Cart::SubTotal() }} dhs</strong>

                </div>
                <div class="py-2 px-2 d-flex justify-content-between text-danger">
                    <span>Tax </span>
                    <strong>{{ Cart::tax() }} dhs</strong>
                </div>
                <div class="py  -2 px-2 d-flex justify-content-between text-success ">
                    <h6 class="font-weight-bold">{{ __('front.total') }}</h6>
                    <h6><strong>{{ Cart::total() }} dhs</strong></h6>
                </div>

            </div>
            <div class="col-md-7 order-md-1">
                <h4 class="mb-3 mt-2">{{ __('Order Summary') }}</h4>
                <checkout-form :client-secret="'{{ config('payment.stripeEnabled') ?  $intent->client_secret  : null}}'"
                    :auth-user="{{ auth()->user() }}" :auth-user-addresses="{{ auth()->user()->addresses }}" />
            </div>
        </div>

    </section>


</main>
<!-- End #main -->
@endsection
