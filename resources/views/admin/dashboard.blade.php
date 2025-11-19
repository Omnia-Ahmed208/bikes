{{-- <!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-navbar-fixed layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ url('backend') }}/assets/"
  data-template="vertical-menu-template">
  <head>

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ url('backend') }}/assets/vendor/css/core-rtl.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ url('backend') }}/assets/vendor/css/theme-default-rtl.css" class="template-customizer-theme-css" />

    <!-- Helpers -->
    <script src="{{ url('backend') }}/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ url('backend') }}/assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ url('backend') }}/assets/js/config.js"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">

        <div class="layout-page">
            <nav
                class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                id="layout-navbar">


                    <ul class="navbar-nav flex-row align-items-center ms-auto">
                        <!-- Style Switcher -->
                        <li class="nav-item me-2 me-xl-0">
                            <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);">
                                <i class="ti ti-md"></i>
                                light
                            </a>
                        </li>
                        <!--/ Style Switcher -->
                    </ul>

            </nav>
        </div>

    </div>

    </div>
    <!-- / Layout wrapper -->

    <!-- Main JS -->
    <script src="{{ url('backend') }}/assets/js/main.js"></script>
  </body>
</html> --}}



@extends('layouts.admin.app')

@section('content')

   <!-- Content -->
   <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
            <h5 class="text-md-start text-center">{{ __('trans.dashboard.title') }}</h5>
        </div>
   </div>
    <!-- / Content -->
@endsection
