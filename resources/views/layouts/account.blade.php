@extends('layouts.app')

@section('content')
    @include('includes.breadcrumb' , ['pageName'=> 'Dashboard'])
    <main id="main">

        <section class="container">

            <div class="row ">
                <div class="col-md-4 ">
                    @include('includes.account-sidebar')
                </div>
                <div class="col-md-8 " >
                  @yield('account-content')
                </div>
            </div>
        </section>
    @endsection
