@extends('layouts.app')
@section('title')
À propos de nous -
@endsection
@section('description')
Apprenez à connaître Yankees
@endsection
@section('content')
@include('includes.breadcrumb' , ['pageName'=> 'About'])
<main id="main">
    <!-- ======= About Section ======= -->
    @include('includes.about-section' )
    <!-- End About Section -->
     <br>
     <br>
</main><!-- End #main -->
@endsection
