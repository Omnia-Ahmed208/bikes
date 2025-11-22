@extends('layouts.header')

@section('body')

<body>

    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            @include('layouts.client.sidebar')

            <div class="layout-page">
                <!-- Navigation -->
                @include('layouts.client.navbar')

                <div class="content-wrapper">
                    @yield('content')
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    // showCloseButton: true
                });
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    text: "{{ session('error') }}",
                    showConfirmButton: false,
                    // confirmButtonText: 'حسناً'
                });
            });
        </script>
    @endif


    @include('layouts.footer')

    {{-- @yield('scripts') --}}

</body>

@endsection

