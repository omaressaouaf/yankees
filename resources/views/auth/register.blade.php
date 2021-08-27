@extends('layouts.app')
@section('title')
Inscription -
@endsection
@section('description')
Rejoignez-nous pour le dîner
@endsection
@section('content')
@include('includes.breadcrumb' , ['pageName'=> "Register"])

<main id="main">
    <section class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card">
                    @include('includes.register-form' , ['redirect_to_checkout' => false])
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
