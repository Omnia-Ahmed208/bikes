<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-navbar-fixed layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ url('backend') }}/assets/"
  data-template="vertical-menu-template">
  <head>

    <!-- Icons -->
    <link rel="stylesheet" href="{{ url('backend') }}/assets/vendor2/fonts/fontawesome.css" />
    <link rel="stylesheet" href="{{ url('backend') }}/assets/vendor2/fonts/tabler-icons.css" />
    <link rel="stylesheet" href="{{ url('backend') }}/assets/vendor2/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ url('backend') }}/assets/vendor2/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ url('backend') }}/assets/vendor2/css/rtl/theme-default.css" class="template-customizer-theme-css" />

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
                        </a>
                        </li>
                        <!--/ Style Switcher -->
                    </ul>

            </nav>
        </div>

    </div>

    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ url('backend') }}/assets/vendor2/libs/jquery/jquery.js"></script>
    <script src="{{ url('backend') }}/assets/vendor2/libs/popper/popper.js"></script>
    <script src="{{ url('backend') }}/assets/vendor2/js/bootstrap.js"></script>

    <!-- Main JS -->
    <script src="{{ url('backend') }}/assets/js/main.js"></script>
  </body>
</html>
