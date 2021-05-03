<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    {{-- fav icon --}}
    <link href="/storage/images/design/favicon.png" rel="icon">
    <link rel="apple-touch-icon" sizes="180x180" href="/storage/images/design/favicon.png">
    <!--     Fonts      -->
    {{-- <link
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
        window.authUser = @json(auth()->user());
        window.appName = '{{ config('app.name') }}';
        window.appLogo = '{{ config('app.logo') }}';

    </script>
    <div id="app">
        {{-- Navbar --}}
        @include('includes.navbar')
        {{-- Content --}}
        @yield('content')
        {{-- Footer --}}
        @include('includes.footer')
    </div>

    <script src="{{ asset('js/app.js') }}"></script>

    @yield('scripts')
</body>

</html>
