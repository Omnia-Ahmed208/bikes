<!DOCTYPE html>

<html
  lang="ar"
  class="light-style layout-menu-fixed"
  dir="rtl"
  data-theme="theme-default"
  data-assets-path="{{ url('backend') }}/assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>{{ $setting->site_name ?? env('app_name') }}</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ url($setting->icon ?? 'backend/asstes/img/logo.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap"
        rel="stylesheet"
    />

    {{-- db --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ url('backend') }}/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ url('backend') }}/assets/vendor/css/core-ar.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ url('backend') }}/assets/vendor/css/theme-default-ar.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ url('backend') }}/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ url('backend') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="{{ url('backend') }}/assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{url('backend')}}/css/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Helpers -->
    <script src="{{ url('backend') }}/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ url('backend') }}/assets/js/config.js"></script>

    @yield('css')
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        @include('layouts.back.sidebar')

        <!-- Layout container -->
        <div class="layout-page">

          @include('layouts.back.navbar')

          <!-- Content wrapper -->
          <div class="content-wrapper">

            <!-- Content -->
            @yield('content')
            <!-- / Content -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ url('backend') }}/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="{{ url('backend') }}/assets/vendor/libs/popper/popper.js"></script>
    <script src="{{ url('backend') }}/assets/vendor/js/bootstrap.js"></script>
    <script src="{{ url('backend') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="{{ url('backend') }}/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ url('backend') }}/assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="{{ url('backend') }}/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="{{ url('backend') }}/assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    {{-- db --}}
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>

    {{-- Swiper --}}
    <script src="{{url('backend')}}/js/swiper-bundle.min.js"></script>

    @if(session()->has('success'))
        <script>
            Swal.fire({
                title: "{{ session()->get('success') }}!",
                icon: "success",
                draggable: true
            });
        </script>
    @endif

    @if(session()->has('error'))
        <script>
            Swal.fire({
                title: "{{ session()->get('error') }}!",
                icon: "error",
                draggable: true
            });
        </script>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Get current page URL
            const currentUrl = window.location.href;
            // Find all menu links
            const menuLinks = document.querySelectorAll(".menu-link");
            menuLinks.forEach(link => {
                if (link.href === currentUrl) {
                    // Add 'active' class to the current link
                    link.parentElement.classList.add("active");
                    // Check if the active link is inside a submenu
                    let parentMenu = link.closest(".menu-sub");
                    if (parentMenu) {
                        // Open the dropdown menu by adding 'active' and 'open' classes
                        parentMenu.parentElement.classList.add("active", "open");
                    }
                }
            });
        });
    </script>

    @yield('js')

  </body>
</html>
