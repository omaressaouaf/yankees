    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center hero-meals @cannot('shop') dark-hero @endcannot">
        <div class="container position-relative text-center text-lg-left" data-aos="zoom-in" data-aos-delay="100">
            <div class="row">
                <div class="col-lg-12 text-center text-light">
                    @can('shop')
                        <h4>{{ __('Desire and we are here to Serve') }}</h4>
                    @else
                        <h4 class="text-dark">
                            <i class="fa fa-ban fa-4x text-danger"></i>
                        </h4>
                        <h4>{{ __('We are closed now . we will open at ') . $nextOpen }}
                        </h4>
                    @endcan

                </div>
            </div>
        </div>

    </section><!-- End Hero -->
