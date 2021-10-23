<!-- ======= Footer ======= -->
<footer id="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 col-md-6">
                    <div class="footer-info">
                        <h3>{{ config('app.name') }}</h3>
                        <p>
                            {{ config('app.contact.address') }} <br>
                            <strong>Phone:</strong> {{ config('app.contact.phone') }}<br>
                            <strong>Email:</strong>{{ config('app.contact.email') }}<br>
                        </p>
                        <div class="social-links mt-3">
                            @if (strlen(config('app.contact.social_media.facebook')))
                            <a href="{{ config('app.contact.social_media.facebook') }}" class="facebook"
                                rel="noopener noreferrer" aria-label="Facebook" target="_blank"><i
                                    class="bx bxl-facebook"></i></a>
                            @endif
                            @if (strlen(config('app.contact.social_media.instagram')))
                            <a href="{{ config('app.contact.social_media.instagram') }}" class="instagram"
                                rel="noopener noreferrer" aria-label="Instagram" target="_blank"><i
                                    class="bx bxl-instagram"></i></a>
                            @endif

                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 footer-links">
                    <h4>{{ __('Quick Links') }}</h4>
                    <ul>
                        <li><i class="bx bx-chevron-right"></i> <a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="{{ route('meals') }}">{{ __('Our menus') }}</a>
                        </li>
                        <li><i class="bx bx-chevron-right"></i> <a href="{{ route('about') }}">{{ __('About') }}</a>
                        </li>

                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 footer-links">
                    <h4>{{ __('admin.openingHours') }}</h4>

                    @foreach ($openingHours as $firstDayInGroup => $schedule)
                    <p class="text-capitalize">
                        <span class="">
                            {{ __('admin.' . $schedule['days'][0] ) }} -
                            {{-- if there is more than one day print the last one --}}
                            @if (count($schedule['days']) > 1)
                            {{__('admin.' . $schedule['days'][count($schedule['days']) - 1]) }}
                            @endif
                            :
                        </span>
                        {{ strlen($schedule['opening_hours'])  ? $schedule['opening_hours'] :  __('admin.closed')}}
                    </p>
                    @endforeach
                </div>

                <div class="col-lg-4 col-md-6 ">
                    <h4>{{ __('Membership') }}</h4>
                    @if (auth()->check())
                    <div class="d-flex">
                        <a href="/account/dashboard" class="btn-orange mr-4">{{__('Dashboard')}}</a>
                    </div>
                    @else
                    <div class="d-flex">
                        <a href="/login" class="btn-orange mr-4">{{__('Login')}}</a>
                        <a href="/register" class="btn-orange">{{__('Register')}}</a>
                    </div>
                    @endif

                </div>

            </div>
        </div>
    </div>

    <div class="container">
        <div class="copyright">
            &copy; Copyright <strong><span>{{config('app.name')}}</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/restaurantly-restaurant-template/ -->
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            Developed by <a href="https://www.sourceup.ma/">Source Up Team</a>
        </div>
    </div>
</footer><!-- End Footer -->

