@extends('layouts.account')
@section('title')
Tableau de bord -
@endsection
@section('account-content')

    <div class="row py-4">
        <div class="col-lg-6">
            <div class="card bg-c-green dashboard-card">
                <div class="card-block">
                    <h2 class="text-right"><i
                            class="fa fa-shopping-bag float-left"></i><span>{{ auth()->user()->orders()->count() }}</span>
                    </h2>
                    <p class="m-b-0">{{ __('Orders') }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card dashboard-card bg-c-yellow">
                <div class="card-block">
                    <h2 class="text-right"><i class="fa fa-shopping-cart float-left"></i><span>{{ Cart::count() }}</span>
                    </h2>
                    <p class="m-b-0">{{ __('Your Cart') }}</p>
                </div>
            </div>
        </div>



    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <h4> <i class="fa fa-shopping-bag text-light bg-success p-2" style="border-radius: 50%"></i>
                {{ __('Your Latest Orders') }}</h4>
            <div class="table-responsive mt-3">

                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">{{ __('front.total') }}</th>
                            <th scope="col">Email</th>
                            <th scope="col">{{ __('admin.paymentMode') }}</th>
                            <th scope="col">{{ __('admin.status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($latestAuthUserOrders as $order)

                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->total }} dhs</td>
                                <td>{{ $order->email }}</td>
                                <td class="text-capitalize">{{ $order->payment_mode }}</td>
                                <td>
                                <h6> <span class="badge p-2 @if ($order->status == 'delivered') badge-success @elseif($order->status == "failed")
                                        badge-danger @else badge-primary @endif">{{ __('admin.'.$order->status) }}</span></h6>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>
@endsection
