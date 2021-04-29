
@extends('layouts.account')
@section('account-content')

<div class="row py-4">
    <div class="col-lg-6">
        <div class="card bg-c-green dashboard-card">
            <div class="card-block">
                <h2 class="text-right"><i class="fa fa-shopping-bag float-left"></i><span>486</span>
                </h2>
                <p class="m-b-0">{{ __('Completed orders') }}<span class="float-right">351</span></p>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card dashboard-card bg-c-yellow">
            <div class="card-block">
                <h2 class="text-right"><i class="fa fa-shopping-cart float-left"></i><span>486</span>
                </h2>
                <p class="m-b-0">{{ __('Your Cart') }}<span class="float-right">351</span></p>
            </div>
        </div>
    </div>



</div>
<div class="row mt-4">
    <div class="col-md-12">
        <h4> <i class="fa fa-shopping-bag text-light bg-success p-2" style="border-radius: 50%"></i> Your Latest Orders</h4>
        <div class="table-responsive mt-3">

            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Total</th>
                        <th scope="col">Tax</th>
                        <th scope="col">Payment Method</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2932</td>
                        <td>70 dhs</td>
                        <td>10 %</td>
                        <td>Cash on Delivery</td>
                        <td> <h5> <span class="badge badge-danger">Pending</span></h5> </td>
                    </tr>
                    <tr>
                        <td>2932</td>
                        <td>70 dhs</td>
                        <td>10 %</td>
                        <td>Cash on Delivery</td>
                        <td> <h5> <span class="badge badge-success">Delivered</span></h5> </td>
                    </tr>
                    <tr>
                        <td>2932</td>
                        <td>70 dhs</td>
                        <td>10 %</td>
                        <td>Cash on Delivery</td>
                        <td> <h5> <span class="badge badge-primary  ">Shipped</span></h5> </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


</div>
@endsection
