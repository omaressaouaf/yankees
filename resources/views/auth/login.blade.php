@extends('layouts.app')
@section('title')
Connexion -
@endsection
@section('description')
Rejoignez notre site Web pour des coupons gratuits et un délicieux menu smashburger
@endsection
@section('canonical')
https://yankees.ma/login
@endsection
@section('content')
@include('includes.breadcrumb' , ['pageName'=> 'Login'])

<article>
    <section class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card">
                    @include('includes.login-form' , ['redirect_to_checkout' => false])
                </div>
            </div>
        </div>
    </section>
</article>
@endsection
