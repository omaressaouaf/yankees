    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">
        <div class="container position-relative text-center text-lg-left" data-aos="zoom-in" data-aos-delay="100">
            <div class="row">
                <div class="col-lg-8">
                    <h1>{{$header['title_'.App::getLocale()]}} <span>{{ config('app.name') }}</span></h1>
                    <h2>{{$header['content_'.App::getLocale()]}}</h2>

                    <div class="btns">
                        <a href="{{ route('meals.index') }}" class="btn-menu animated fadeInUp scrollto">{{__('Our menus')}}</a>
                        <a href="{{ route('about') }}" class="btn-book animated fadeInUp scrollto">{{__('About Us')}}</a>
                    </div>
                </div>
                <div class="col-lg-4 d-flex align-items-center justify-content-center" data-aos="zoom-in"
                    data-aos-delay="200">
                    <a href="https://www.youtube.com/watch?v=GlrxcuEDyF8" class="venobox play-btn" data-vbtype="video"
                        data-autoplay="true"></a>
                </div>

            </div>
        </div>
    </section><!-- End Hero -->
