<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center hero-meals @cannot('shop') dark-hero @endcannot">
    <div class="container position-relative text-center text-lg-left" >
        <div class="row">
            <div class="col-lg-12 text-center text-light">
                @can('shop')
                <h4>{{ __('Desire and we are here to Serve') }}</h4>
                @else
                <h4 class="text-dark">
                 <span class="badge badge-danger"> <i class="fa fa-ban"></i> {{__('Closed')}} </span>
                    {{-- <i class="fa fa-ban fa-4x text-danger"></i> --}}
                </h4>

                <h4>
                    {{ __('We are closed now.') }}
                    @if (!$forcedClose)
                    <span class="ml-1"> {{__('we will open on ') . $nextOpen}} </span>
                    @endif
                    <span></span>
                </h4>

                @endcan

            </div>
        </div>
    </div>

</section><!-- End Hero -->
