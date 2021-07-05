<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center ">

    <div class="container-fluid">
        <div class="row mt-5 ">
            <div class="d-flex justify-content-center pl-5 col-lg-6  order-1  hero-img" data-aos="zoom-in" data-aos-delay="200">
                    <img height="500" width="500" src="/storage/images/design/hero-image.png" class="img-fluid animated" alt="">
            </div>
            <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2" data-aos="fade-up"
                data-aos-delay="200">
                    <h1>{{$header['title_'.App::getLocale()]}} <span>{{ config('app.name') }}</span></h1>
                    <h2>{{$header['content_'.App::getLocale()]}}</h2>
                <div class="btns d-flex flex-wrap justify-content-start">
                    <a href="{{ route('meals.index') }}"
                        class="btn-menu animated fadeInUp scrollto">{{__('Our menus')}}</a>
                    <a href="{{ route('about') }}" class="btn-book animated fadeInUp scrollto">{{__('About Us')}}</a>
                </div>
            </div>

        </div>
    </div>

</section><!-- End Hero -->
