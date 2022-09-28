<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- SEO -->
    @hasSection ('title')
    <title>@yield('title'){{ config('app.name') }}</title>
    @else
    <title>{{ config('app.name') }} - Commandez le meilleur smashburger à casablanca</title>
    @endif
    <meta content="@yield('description')" name="description">
    <link rel="canonical" href="@yield('canonical')" />
    <meta property="og:type" content="article" />
    @hasSection ('title')
    <meta property="og:title" content="@yield('title'){{ config('app.name') }}" />
    @else
    <meta property="og:title" content="{{ config('app.name') }} - Commandez le meilleur smashburger à casablanca" />
    @endif
    <meta property="og:description" content="@yield('description')" />
    <meta property="og:image" content="/storage/images/design/logo-original.jpg" />
    <meta property="og:url" content="@yield('canonical')" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta property="og:site_name" content="{{config('app.name')}}" />
    <meta name="twitter:image:alt" content="{{config('app.name')}} Logo" />
    <meta name="keywords"
        content="yankees, Yankees, yankees smashburger, smash burger, yankees burger, yankees restaurant, smashburger restaurant, smashburger restaurants, smashburger menu,smashes burger, best smashburger,smashburger casablanca,fast food casablanca livraison, smashburger livraison casablanca,fast food casablanca Livraison gratuite casablanca, healthy food, nourriture, shake shack smashburger, american smash burgers, smashburger near me, fast food, fast food casablanca, fast food restaurant, fast food restaurant near me, burger, smashburger, hot dogs, submarine, sides, milkshake, fast food restaurants, mcdonalds, chicken burger, cheese burger, king burger, burger king, jumia food, tacos, snacks, ice cream, sandwich, dessert, chicken, big mac, food morocco, moroccan food, jumia food maroc, kfc menu, menu, new york yankees official website" />
    <meta name="google-site-verification" content="IbQbDVr2xhS3jDB5pBSaWbdSpuugemzUrAIF3I7hRE8" />
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "FastFoodRestaurant",
          "name": "Yankees",
          "image": "https://yankees.ma/storage/images/design/logo-original.jpg",
          "@id": "https://yankees.ma/",
          "url": "https://yankees.ma/",
          "telephone": "05 29 29 9000 - 07 07 07 2928",
          "priceRange": "6-100",
          "menu": "https://yankees.ma/meals",
          "servesCuisine": "smashburger",
          "acceptsReservations": "false",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "42 bis Rue Abbas Mahmoud Al Akkad",
            "addressLocality": "Casablanca",
            "postalCode": "",
            "addressCountry": "MA"
          },
          "geo": {
            "@type": "GeoCoordinates",
            "latitude": 33.595301058434536,
            "longitude": -7.633085138387365
          },
          "openingHoursSpecification": {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": [
              "Monday",
              "Tuesday",
              "Wednesday",
              "Thursday",
              "Friday",
              "Saturday",
              "Sunday"
            ],
            "opens": "12:00",
            "closes": "21:00"
          }
        }
    </script>

    {{-- fav icons --}}
    <link rel="apple-touch-icon" sizes="180x180" href="/storage/images/design/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/storage/images/design/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/storage/images/design/favicons/favicon-16x16.png">
    <link rel="manifest" href="/storage/images/design/favicons/site.webmanifest">
    <link rel="mask-icon" href="/storage/images/design/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <!--     Fonts      -->
    {{--
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet"> --}}

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">



    {{-- styles --}}


    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{-- mapbox --}}
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.css' rel='stylesheet' />
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.min.js">
    </script>
    <link rel="stylesheet"
        href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.css"
        type="text/css">

    <!-- Promise polyfill script is required -->
    <!-- to use Mapbox GL Geocoder in IE 11. -->
    <script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script>

    @yield('head')

</head>


<body>

    <script>
        // get the count if we are not on the meals page
        window.initialCartCount = @json(Cart::count());
        window.currentLocale = '{{ config('app.locale') }}';
        window.availableLocales = @json(config('app.available_locales'));
        window.deliveryZoneBounds = @json(config('delivery.zone_bounds'));
        window.deliveryPrice = @json(config('delivery.price'));
        window.deliveryTime = @json(config('delivery.time'));
        window.minOrderPrice = @json(config('cart.min_order_price'));
        const authUser = @json(auth()->user());
        if(authUser) {

            authUser['roles'] = @json(auth()->check() ? auth()->user()->roles()->pluck('name') : []) ;
        }
        window.authUser = authUser;
        window.appName = '{{ config('app.name') }}';
        window.appLogo = '{{ config('app.logo') }}';
        window.canShop = @json(Gate::allows('shop'));
        window.canCheckoutWithStripe = @json(Gate::allows('checkout-with-stripe'))

    </script>

    <div id="app">
        {{-- Navbar --}}
        @include('includes.navbar')
        {{-- Content --}}
        <main id="main">
            @yield('content')
            {{--cart sidebar modal --}}
            @include('includes.cart-sidebar-modal')
            {{-- Auth modal --}}
            @include('includes.auth-modal')
        </main>

        {{-- Footer --}}
        @include('includes.footer')

        {{-- Floating buttons --}}
        <a href="#" class="back-to-top"><i class="bx bx-up-arrow-alt"></i></a>
        @if (!Route::is('checkout.index'))
        <cart-floating-button :cart-initial-count={{Cart::count()}} />
        @endif



    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    {{-- Determine whether to show the auth modal and which tab should be open based on the errors session --}}
    @if(!Route::is('login'))
    @error('email')
    <script>
        $('#authModal').modal('show')
        $('#authTab a[href="#login"]').tab('show')
    </script>
    @enderror
    @endif

    @if(!Route::is('register') && ($errors->has('register_name') || $errors->has('register_email') ||
    $errors->has('register_phone') ||
    $errors->has('register_password') ))
    <script>
        $('#authModal').modal('show')
        $('#authTab a[href="#register"]').tab('show')
    </script>
    @endif

    @yield('scripts')
</body>

</html>
