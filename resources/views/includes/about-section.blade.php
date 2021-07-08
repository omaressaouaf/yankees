<section id="about">


    <div class="about-container">
        <div id="aboutCarousel" class="carousel slide carousel-fade" data-interval="8000" data-ride="carousel">

            <ol class="carousel-indicators" id="about-carousel-indicators"></ol>

            <div class="carousel-inner" role="listbox">

                @for ($i = 1; $i <= 3; $i++) <div class="carousel-item @if($i ===1) active @endif"
                    style="background: url(/storage/images/design/sliders/slide{{$i}}.jpg);">
                    <div class="carousel-container">

                        <div class="carousel-content pl-5">
                            <h2 class="animate__animated animate__fadeInDown">{{$about['title_'.App::getLocale()]}}
                            </h2>
                            <p class="animate__animated animate__fadeInUp">{{$about['content_'.App::getLocale()]}}
                            </p>
                        </div>
                    </div>

            </div>
            @endfor

            <a class="carousel-control-prev" href="#aboutCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon icofont-simple-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>

            <a class="carousel-control-next" href="#aboutCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon icofont-simple-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>

        </div>
    </div>
</section><!-- End about -->
