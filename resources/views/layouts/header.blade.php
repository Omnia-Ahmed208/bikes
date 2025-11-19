<html lang="{{ AppLang() }}" dir="{{ AppDir() }}"
    class="light-style layout-menu-fixed layout-compact" data-theme="theme-default"
    data-assets-path="{{url('backend')}}/assets/" data-template="vertical-menu-template-free" data-style="light">
    <head>
        <meta charset="utf-8" />
        <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title> {{ config('app.name') }} </title>

        <meta name="description" content="" />

        <!-- db -->
        @yield('db_css')

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ url('backend') }}/img/fav.png" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

        <link rel="stylesheet" href="{{url('backend')}}/assets/vendor/fonts/boxicons.css" />

        <link rel="stylesheet" href="{{url('backend')}}/assets/vendor/css/core-rtl.css" class="template-customizer-core-css" />
        <link rel="stylesheet" href="{{url('backend')}}/assets/vendor/css/theme-default-rtl.css" class="template-customizer-theme-css" />

        {{-- @if (AppLang() == 'ar')
            <!-- Core CSS -->
            <link rel="stylesheet" href="{{url('backend')}}/assets/vendor/css/core-rtl.css" class="template-customizer-core-css" />
            <link rel="stylesheet" href="{{url('backend')}}/assets/vendor/css/theme-default-rtl.css" class="template-customizer-theme-css" />
            <link rel="stylesheet" href="{{url('backend')}}/assets/css/demo-rtl.css" />
        @else
            <!-- Core CSS -->
            <link rel="stylesheet" href="{{url('backend')}}/assets/vendor/css/core.css" class="template-customizer-core-css" />
            <link rel="stylesheet" href="{{url('backend')}}/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
            <link rel="stylesheet" href="{{url('backend')}}/assets/css/demo.css" />
        @endif --}}

        <!-- Vendors CSS -->
        <link rel="stylesheet" href="{{url('backend')}}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
        <link rel="stylesheet" href="{{url('backend')}}/assets/vendor/libs/apex-charts/apex-charts.css" />

        <!-- Page CSS -->
        <link rel="stylesheet" href="{{url('backend')}}/css/swiper-bundle.min.css" />
        {{-- version number and this is the last update for this file (custom.css) --}}
        <link rel="stylesheet" href="{{ url('backend') }}/css/custom.css?v={{ filemtime(public_path('backend/css/custom.css')) }}" />

       <!-- Helpers -->
        <script src="{{ url('backend') }}/assets/vendor/js/helpers.js"></script>

        <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
        <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
        <script src="{{ url('backend') }}/assets/vendor/js/template-customizer.js"></script>
        <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
        <script src="{{ url('backend') }}/assets/js/config.js"></script>
        {{-- custom css --}}
        <link rel="stylesheet" href="{{ url('backend') }}/css/config.css?v={{ filemtime(public_path('backend/css/config.css')) }}" />

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
