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
                                    <a href="{{ config('app.contact.social_media.facebook') }}" class="facebook"><i
                                            class="bx bxl-facebook"></i></a>
                                @endif
                                @if (strlen(config('app.contact.social_media.instagram')))
                                    <a href="{{ config('app.contact.social_media.instagram') }}" class="instagram"><i
                                            class="bx bxl-instagram"></i></a>
                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6 footer-links">
                        <h4>{{ __('Quick Links') }}</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a
                                    href="{{ route('home') }}">{{ __('Home') }}</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a
                                    href="{{ route('meals.index') }}">{{ __('Our menus') }}</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a
                                    href="{{ route('about') }}">{{ __('About') }}</a></li>

                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>{{ __('admin.openingHours') }}</h4>

                        @foreach ($openingHours as $firstDay => $schedule)
                            <p class="text-capitalize">
                                <span class="">
                                    {{-- First Day is the actual key in each element in the array --}}
                                    {{ __('admin.' . $firstDay) }} -
                                    {{-- Last Day is the last element in the days array --}}
                                    {{ __('admin.' . $schedule['days'][count($schedule['days']) - 1]) }} :
                                </span>
                                {{-- The Actual opening Hours --}}
                                {{ strlen($schedule['opening_hours'])  ? $schedule['opening_hours'] :  __('admin.closed')}}
                            </p>
                        @endforeach
                    </div>

                    <div class="col-lg-4 col-md-6 footer-newsletter">
                        <h4>Our Newsletter</h4>
                        <p>Tamen quem nulla quae legam multos aute sint culpa legam noster magna</p>
                        <form>
                            <input type="email" name="email"><input type="submit" value="Subscribe">
                        </form>

                    </div>

                </div>
            </div>
        </div>

        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span>Restaurantly</span></strong>. All Rights Reserved
            </div>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/restaurantly-restaurant-template/ -->
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
        </div>
    </footer><!-- End Footer -->
    <a href="#" class="back-to-top"><i class="bx bx-up-arrow-alt"></i></a>
