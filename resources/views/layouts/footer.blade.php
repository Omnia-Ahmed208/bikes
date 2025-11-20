<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->

<script src="{{url('backend')}}/assets/vendor/libs/jquery/jquery.js"></script>
<script src="{{url('backend')}}/assets/vendor/libs/popper/popper.js"></script>
<script src="{{url('backend')}}/assets/vendor/js/bootstrap.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{url('backend')}}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="{{ url('backend') }}/assets/vendor/libs/node-waves/node-waves.js"></script>

<script src="{{ url('backend') }}/assets/vendor/libs/hammer/hammer.js"></script>
<script src="{{ url('backend') }}/assets/vendor/libs/i18n/i18n.js"></script>
<script src="{{ url('backend') }}/assets/vendor/libs/typeahead-js/typeahead.js"></script>

<script src="{{url('backend')}}/assets/vendor/js/menu.js"></script>

<!-- DB JS -->
@yield('db_js')

<!-- Vendors JS -->
<script src="{{url('backend')}}/assets/vendor/libs/apex-charts/apexcharts.js"></script>
<script src="{{ url('backend') }}/assets/vendor/libs/swiper/swiper.js"></script>
<script src="{{ url('backend') }}/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>

<!-- Main JS -->
<script src="{{ url('backend') }}/assets/js/main.js"></script>

<!-- Page JS -->
<script src="{{url('backend')}}/assets/js/dashboards-analytics.js"></script>

<!-- Place this tag before closing body tag for github widget button. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

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

<!-- sidebar links -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        setTimeout(function(){
            if(document.getElementById("loader")){
                document.getElementById("loader").style.display = "none";
            }
        }, 1000);


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

{{-- @yield('js') --}}
@stack('js')
