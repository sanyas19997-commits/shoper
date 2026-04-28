<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="msapplication-TileColor" content="#0E0E0E">
        <meta name="template-color" content="#0E0E0E">
        <meta name="description" content="{{ config('app.name', 'Billaro Store') }}">

        <title inertia>{{ config('app.name', 'Billaro Store') }}</title>

        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('kidify/imgs/template/favicon.svg') }}">

        {{-- Kidify CSS --}}
        <link rel="stylesheet" href="{{ asset('kidify/css/vendors/normalize.css') }}">
        <link rel="stylesheet" href="{{ asset('kidify/css/vendors/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('kidify/css/vendors/uicons-regular-rounded.css') }}">
        <link rel="stylesheet" href="{{ asset('kidify/css/vendors/uicons-regular-straight.css') }}">
        <link rel="stylesheet" href="{{ asset('kidify/css/plugins/animate.min.css') }}">
        <link rel="stylesheet" href="{{ asset('kidify/css/plugins/swiper-bundle.min.css') }}">
        <link rel="stylesheet" href="{{ asset('kidify/css/plugins/slick.css') }}">
        <link rel="stylesheet" href="{{ asset('kidify/css/plugins/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('kidify/css/plugins/perfect-scrollbar.css') }}">
        <link rel="stylesheet" href="{{ asset('kidify/css/plugins/magnific-popup.css') }}">
        <link rel="stylesheet" href="{{ asset('kidify/css/plugins/glightbox.min.css') }}">
        <link rel="stylesheet" href="{{ asset('kidify/css/plugins/jquery-ui.css') }}">
        <link rel="stylesheet" href="{{ asset('kidify/css/style.css') }}">

        {{-- Scripts --}}
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body>
        @inertia

        {{-- jQuery & Kidify vendor scripts --}}
        <script src="{{ asset('kidify/js/vendors/modernizr-3.6.0.min.js') }}"></script>
        <script src="{{ asset('kidify/js/vendors/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('kidify/js/vendors/jquery-migrate-3.3.0.min.js') }}"></script>
        <script src="{{ asset('kidify/js/vendors/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('kidify/js/vendors/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('kidify/js/vendors/slick.js') }}"></script>
        <script src="{{ asset('kidify/js/vendors/select2.min.js') }}"></script>
        <script src="{{ asset('kidify/js/vendors/waypoints.js') }}"></script>
        <script src="{{ asset('kidify/js/vendors/wow.js') }}"></script>
        <script src="{{ asset('kidify/js/vendors/perfect-scrollbar.min.js') }}"></script>
        <script src="{{ asset('kidify/js/vendors/magnific-popup.js') }}"></script>
        <script src="{{ asset('kidify/js/vendors/glightbox.min.js') }}"></script>
        <script src="{{ asset('kidify/js/vendors/counterup.js') }}"></script>
        <script src="{{ asset('kidify/js/vendors/scrollup.js') }}"></script>
        <script src="{{ asset('kidify/js/vendors/jquery.countdown.min.js') }}"></script>
        <script src="{{ asset('kidify/js/vendors/jquery.elevatezoom.js') }}"></script>
        <script src="{{ asset('kidify/js/vendors/noUISlider.js') }}"></script>
        <script src="{{ asset('kidify/js/vendors/isotope.js') }}"></script>
        <script src="{{ asset('kidify/js/vendors/images-loaded.js') }}"></script>
        <script src="{{ asset('kidify/js/main.js') }}"></script>
    </body>
</html>
