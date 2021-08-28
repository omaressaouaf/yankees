@extends('layouts.app')

@section('description')
Livraison gratuite de Smashburger et hot-dogs des yankees et plus de fast food à casablanca. Commandez maintenant auprès
du meilleur restaurant de smashburger.
@endsection
@section('canonical')
https://yankees.ma/
@endsection
@section('content')
@include('includes.hero')
<article>

    <!--  Menu Section -->
    <section id="menu" class="menu">
        <div class="container" style="padding: 0px 30px">
            <div class="section-title">
                <h2>Menu</h2>
            </div>
            <div v-cloak>
                <meals-list :categories="{{$categoriesWithMeals}}"></meals-list>
            </div>
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
</article>

@endsection
