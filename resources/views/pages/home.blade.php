@extends('layouts.app')
@section('head')
<style>
    .cards-wrapper {
        display: flex;
        justify-content: center;
    }

    .card img {
        max-width: 100%;
        max-height: 100%;
    }

    .card {
        margin: 0 0.5em;
        box-shadow: 2px 6px 8px 0 rgba(22, 22, 26, 0.18);
        border: none;
        border-radius: 0;
    }

    .carousel-inner {
        padding: 1em;
    }

    .carousel-control-prev,
    .carousel-control-next {
        background-color: #e1e1e1;
        width: 5vh;
        height: 5vh;
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
    }

    @media (min-width: 768px) {
        .card img {
            height: 11em;
        }
    }
</style>

@endsection
@section('description')
Commandez le meilleur smash burger
@endsection
@section('content')
@include('includes.hero')
<main id="main">
    {{-- preloader --}}
    {{-- <div id="preloader"></div> --}}


    <!--  Menu Section -->
    <section id="menu" class="menu">
        <div class="container" style="padding: 0px 30px" data-aos="fade-up">
            <div class="section-title">
                <h2>Menu</h2>
            </div>
            <meals-list :categories="{{$categories}}"></meals-list>
        </div>
    </section>
    <meals-single> </meals-single>
    <!-- End Menu Section -->

    <!-- ======= About Section ======= -->
    @include('includes.about-section')
    <!-- End About Section -->
    <!-- ======= Contact Section ======= -->
    @include('includes.contact-section')
    <!-- End Contact Section -->

</main><!-- End #main -->
@endsection
