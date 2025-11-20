<!DOCTYPE html>
<html lang="{{ AppLang() }}" dir="{{ AppDir() }}"
    class="light-style layout-navbar-fixed layout-menu-fixed"
    data-theme="theme-default"
    data-assets-path="{{ url('backend') }}/assets/"
    data-template="vertical-menu-template">

       <head>
        <meta charset="utf-8" />
        <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <meta name="description" content="" />

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ url('backend') }}/assets/img/favicon/favicon.ico" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

        <!-- Icons -->
        <link rel="stylesheet" href="{{ url('backend') }}/assets/vendor/fonts/fontawesome.css" />
        <link rel="stylesheet" href="{{ url('backend') }}/assets/vendor/fonts/tabler-icons.css" />
        <link rel="stylesheet" href="{{ url('backend') }}/assets/vendor/fonts/flag-icons.css" />
        {{-- <link rel="icon" type="image/x-icon" href="{{ url('backend') }}/img/fav.png" /> --}}

        <!-- Core CSS -->
        <link rel="stylesheet" href="{{ url('backend') }}/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
        <link rel="stylesheet" href="{{ url('backend') }}/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
        <link rel="stylesheet" href="{{ url('backend') }}/assets/css/demo.css" />

        <!-- Vendors CSS -->
        {{-- <link rel="stylesheet" href="{{ url('backend') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" /> --}}
        {{-- <link rel="stylesheet" href="{{ url('backend') }}/assets/vendor/libs/swiper/swiper.css" /> --}}

        <!-- db -->
        @yield('db_css')
        {{--
            <link rel="stylesheet" href="{{ url('backend') }}/assets/vendor/libs/node-waves/node-waves.css" />
            <link rel="stylesheet" href="{{ url('backend') }}/assets/vendor/libs/typeahead-js/typeahead.css" />
            <link rel="stylesheet" href="{{ url('backend') }}/assets/vendor/libs/apex-charts/apex-charts.css" />
            <link rel="stylesheet" href="{{ url('backend') }}/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
            <link rel="stylesheet" href="{{ url('backend') }}/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
            <link rel="stylesheet" href="{{ url('backend') }}/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
        --}}

        <!-- Page CSS -->
        {{-- <link rel="stylesheet" href="{{ url('backend') }}/assets/vendor/css/pages/cards-advance.css" /> --}}

        <!-- Helpers -->
        <script src="{{ url('backend') }}/assets/vendor/js/helpers.js"></script>

        <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
        <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
        <script src="{{ url('backend') }}/assets/vendor/js/template-customizer.js"></script>
        <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
        <script src="{{ url('backend') }}/assets/js/config.js"></script>

        <link rel="stylesheet" href="{{ url('backend') }}/css/custom.css?v={{ filemtime(public_path('backend/css/custom.css')) }}" />

        <style>
            @font-face {
                font-family: 'noto';
                src: url("{{ asset('backend/fonts/NotoSansArabic-Regular.ttf') }}") format('truetype');
                font-weight: normal;
                font-style: normal;
            }
            body{font-family: 'noto';}
        </style>

        @yield('css')
    </head>

    @yield('body')

</html>
