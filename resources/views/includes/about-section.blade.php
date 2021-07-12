<section id="about">


    <div class="about-container">
        <div id="aboutCarousel" class="carousel slide carousel-fade" data-interval="12000" data-ride="carousel">

            <ol class="carousel-indicators" id="about-carousel-indicators"></ol>

            <div class="carousel-inner" role="listbox">
                @foreach ($slides as $slide)
                <div class="carousel-item @if($loop->first) active @endif"
                    style="background: url({{$slide['image']}});">
                    <div class="carousel-container">

                        <div class="carousel-content pl-5">
                            <h2 class="animate__animated animate__fadeInDown">{{__('About Us')}}
                            </h2>
                            <p class="animate__animated animate__fadeInUp">{{$slide['text']}}
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach

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
