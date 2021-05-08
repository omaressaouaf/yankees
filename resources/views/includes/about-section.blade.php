<section id="about" class="about">

    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2>{{__('About')}}</h2>
            <p>{{__('Find our More About us')}}</p>
        </div>
        <div class="row">
            <div class="col-lg-6 order-1 order-lg-2" data-aos="zoom-in" data-aos-delay="100">
                <div class="about-img">
                    <img src="/storage/images/design/template/about.jpg" alt="">
                </div>
            </div>
            <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content">
                <h3>{{$about['title_'.App::getLocale()]}}</h3>
                <p>
                    {{$about['content_'.App::getLocale()]}}

                </p>
            </div>
        </div>

    </div>
</section>
