    <!-- ======= Top Bar ======= -->

    <div id="topbar" class="d-flex align-items-center fixed-top py-4">
        <div class="container d-flex">
            <div class="contact-info  d-none d-sm-block">

                <i class="fa fa-phone-alt"></i> +1 5589 55488 55
                <span class="d-none d-lg-inline-block"><i class=" ml-3 fa fa-calendar-check"></i> Mon-Sat:
                    11:00 AM - 23:00 PM</span>
            </div>
            <ul class="nav ml-auto ">
                @auth
                    @if (auth()->user()->hasAnyRole(['admin', 'deliveryman']))
                        <li class="nav-item ">
                            <a href="/admin/dashboard" class="nav-link "> <i class="fa fa-lock fa-lg"></i>
                                </a>
                        </li>
                    @endif
                    <notifications-list> </notifications-list>
                @endauth
                <locale-switcher> </locale-switcher>
            </ul>
        </div>
    </div>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top {{ request()->is('/') ? '' : 'darkheader' }}">
        <div class="container d-flex align-items-center">

            <h1 class="logo mr-auto"><a href="{{ route('home') }}">{{ config('app.name') }}</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html" class="logo mr-auto"><img src="/storage/images/design/template/logo.png" alt="" class="img-fluid"></a>-->

            <nav class="nav-menu d-none d-lg-block">
                <ul>

                    <li class=" {{ request()->is('meals') ? 'active' : '' }} "><a href="{{ route('about') }}"><a
                                href="{{ route('meals.index') }}" class="normal-nav-link"><i
                                    class="fa fa-utensils mr-2"></i>{{ __('Our menus') }}</a>
                    </li>
                    <li class=" {{ request()->is('about') ? 'active' : '' }} "><a class="normal-nav-link"
                            href="{{ route('about') }}"><i class="fa fa-user-friends mr-2"></i>
                            {{ __('About') }}</a></li>
                    @auth
                        <li class="nav-item dropdown ">
                            <a class="nav-link dropdown-toggle   book-a-table" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user-circle mr-2"></i> {{ auth()->user()->name }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item"
                                    href="{{ route('account.dashboard') }}">{{ __('Dashboard') }}</a>
                                <a class="dropdown-item" href="#">Profil</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#"
                                    onclick="event.preventDefault();
                                                                                                                                                                                    document.querySelector('.logout-form').submit();">Se
                                    déconnecter</a>
                                <form class="logout-form" action="{{ route('logout') }}" method="post">
                                    @csrf</form>
                            </div>
                        </li>
                    @else
                        <li class=" {{ request()->is('login') ? 'active' : '' }} ">
                            <a href="{{ route('login') }}" class="normal-nav-link"> <i
                                    class="fa fa-sign-in-alt mr-2"></i>{{ __('Login') }}</a>
                        </li>
                        <li class=" {{ request()->is('register') ? 'active' : '' }} ">
                            <a href="{{ route('register') }}" class="normal-nav-link"> <i
                                    class="fa fa-user-plus mr-2"></i>{{ __('Register') }}</a>
                        </li>
                    @endauth


                </ul>
            </nav><!-- .nav-menu -->

        </div>
    </header><!-- End Header -->
