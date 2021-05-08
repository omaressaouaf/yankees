@extends('layouts.app')
@section('content')
    @include('includes.hero')
    <main id="main">
        {{-- preloader --}}
        <div id="preloader"></div>
        <!-- ======= About Section ======= -->
        @include('includes.about-section')
        <!-- End About Section -->

        <!-- ======= Menu Section ======= -->
        <section id="menu" class="menu section-bg">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Menu</h2>
                    <p>{{__('Check Our Latest Menus')}}</p>
                </div>

                <div class="row menu-container" data-aos="fade-up" data-aos-delay="200">
                    @foreach ($latestMeals as $meal)
                        <div class="col-lg-6 menu-item filter-starters">
                            <img src="{{$meal->resizedImage}}" width="100" height="70" class="menu-img" alt="">
                            <div class="menu-content" >
                                <a  href="#" style="background: transparent">{{$meal->title}}</a><span >{{$meal->price}} dhs</span>
                            </div>
                            <div class="menu-ingredients">
                                {{$meal->desc}}
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section><!-- End Menu Section -->



        <!-- ======= Chefs Section ======= -->
        <section id="chefs" class="chefs">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Chefs</h2>
                    <p>{{ __('Our Professional Chefs') }}</p>
                </div>

                <div class="row">

                    <div class="col-lg-4 col-md-6">
                        <div class="member" data-aos="zoom-in" data-aos-delay="100">
                            <img src="/storage/images/design/template/chefs/chefs-1.jpg" class="img-fluid" alt="">
                            <div class="member-info">
                                <div class="member-info-content">
                                    <h4>Walter White</h4>
                                    <span>Master Chef</span>
                                </div>
                                <div class="social">
                                    <a href=""><i class="icofont-twitter"></i></a>
                                    <a href=""><i class="icofont-facebook"></i></a>
                                    <a href=""><i class="icofont-instagram"></i></a>
                                    <a href=""><i class="icofont-linkedin"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="member" data-aos="zoom-in" data-aos-delay="200">
                            <img src="/storage/images/design/template/chefs/chefs-2.jpg" class="img-fluid" alt="">
                            <div class="member-info">
                                <div class="member-info-content">
                                    <h4>Sarah Jhonson</h4>
                                    <span>Patissier</span>
                                </div>
                                <div class="social">
                                    <a href=""><i class="icofont-twitter"></i></a>
                                    <a href=""><i class="icofont-facebook"></i></a>
                                    <a href=""><i class="icofont-instagram"></i></a>
                                    <a href=""><i class="icofont-linkedin"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="member" data-aos="zoom-in" data-aos-delay="300">
                            <img src="/storage/images/design/template/chefs/chefs-3.jpg" class="img-fluid" alt="">
                            <div class="member-info">
                                <div class="member-info-content">
                                    <h4>William Anderson</h4>
                                    <span>Cook</span>
                                </div>
                                <div class="social">
                                    <a href=""><i class="icofont-twitter"></i></a>
                                    <a href=""><i class="icofont-facebook"></i></a>
                                    <a href=""><i class="icofont-instagram"></i></a>
                                    <a href=""><i class="icofont-linkedin"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section><!-- End Chefs Section -->

        <!-- ======= Contact Section ======= -->
        @include('includes.contact-section')
        <!-- End Contact Section -->

    </main><!-- End #main -->
@endsection
