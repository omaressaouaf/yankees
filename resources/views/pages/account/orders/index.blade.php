@extends('layouts.account')
@section('title')
Vos commandes -
@endsection
@section('account-content')
<div class="mt-4">
    <h4 class="font-weight-bold"># {{ __('Your Latest Orders') }}</h4>
    <p class="text-muted  mb-5">{{ __('Consult your Orders') }}</p>
    @foreach ($authUserOrders as $order)
    <div class="col-md-12 ">
        <div class="d-flex" class="order-flex-div">
            <div class="@if (!$loop->last) col-step @endif">
                <i class="fa fa-clock bg-success text-light p-2 mr-2 col-step-element"></i>
            </div>
            <div class="mx-2">
                <p class="text-muted">{{ $order->created_at }}</p>
                <div class="card p-3 mb-4 ">
                    <div class="row">
                        <div class="col-md-2 pr-0">
                            <img class="w-100" src="{{ $order->detailsWithRemovedMeals()[0]->resized_image }}" alt="Order Items Image">
                        </div>
                        <div class="col-md-6">
                            <h3>
                                <h1 class="lead ">
                                    {{ $order->detailsWithRemovedMeals()[0]->title }} ....</h1>
                                <p class="lead text-muted mb-2">{{ __('admin.order') }} #{{ $order->id }}</p>
                                <a class="btn-link mr-3" data-toggle="collapse" href="#orderDetails{{ $order->id }}"
                                    role="button" aria-expanded="false"
                                    aria-controls="orderDetails{{ $order->id }}">{{ __('Details') }}</a>
                                @can('track_order', $order->status)
                                <a class="btn-link"
                                    href="{{ route('account.orders.track', ['order' => $order->id]) }}">{{ __('Track') }}</a>
                                @endcan

                                <div class="collapse" id="orderDetails{{ $order->id }}">
                                    <ul class="mt-2 px-0" style="list-style: none">
                                        @foreach ($order->detailsWithRemovedMeals() as $meal)

                                        <li class="d-flex justify-content-between">
                                            <span>
                                                {{ $meal->pivot->qty }} x {{ $meal->title }}
                                            </span> <span
                                                class="float-right">{{ $meal->pivot->meal_subtotal }}dhs</span>
                                        </li>
                                        @endforeach

                                        <li class="font-weight-bold mt-2 text-success">
                                            {{ __('front.total') }}<span
                                                class="float-right ">{{ $order->total }}dhs</span> </li>
                                    </ul>
                                </div>


                            </h3>

                        </div>
                        <div class="col-md-2 ml-auto">
                            <h5> <span class="badge p-2   @if ($order->status ==
                                          'delivered') badge-success @elseif($order->status ==
                                              " failed") badge-danger @else badge-primary @endif
                                    float-right">{{ __('admin.' . $order->status) }}</span> </h5>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endforeach
    {{ $authUserOrders->links() }}
</div>
@endsection
