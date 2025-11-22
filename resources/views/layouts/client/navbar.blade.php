<nav
    class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme rounded-0 m-0 px-4"
    id="layout-navbar">

    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="ti ti-menu-2 ti-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Style Switcher -->
            <li class="nav-item me-2 me-xl-0">
                <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);">
                    <i class="ti ti-md"></i>
                </a>
            </li>
            <!--/ Style Switcher -->

            <!-- Notification -->
            <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
                <a
                    class="nav-link dropdown-toggle hide-arrow"
                    href="javascript:void(0);"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="outside"
                    aria-expanded="false">
                    <i class="ti ti-bell ti-md"></i>
                    {{-- <span class="badge bg-danger rounded-pill badge-notifications">5</span> --}}
                </a>

                <ul class="dropdown-menu dropdown-menu-end py-0">
                    <li class="dropdown-notifications-list scrollable-container">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item list-group-item-action dropdown-notifications-item text-center">
                                {{ __('trans.notification.no_notifications') }}
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <!--/ Notification -->

            <!-- Language -->
            <li class="nav-item dropdown-language dropdown me-2 me-xl-0">
                <a class="nav-link dropdown-toggle hide-arrow d-flex align-items-center" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <i class="ti ti-world rounded-circle me-1 fs-3"></i>
                    <span class="d-none d-sm-block">{{ AppLang() == 'ar' ? __('trans.arabic') : __('trans.english') }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ switchLang('ar') }}">
                            <input type="checkbox" class="form-check-input rounded-circle" id="arabicLang"
                            onclick="location.href='{{ switchLang('ar') }}'"
                            @if (AppLang() == 'ar') checked @endif>

                            <span class="align-middle">{{ __('trans.arabic') }}</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ switchLang('en') }}">
                            <input type="checkbox" class="form-check-input rounded-circle" id="englishLang"
                            onclick="location.href='{{ switchLang('en') }}'"
                            @if (AppLang() == 'en') checked @endif>

                            <span class="align-middle">{{ __('trans.english') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--/ Language -->

            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        @if (auth()->guard('admin')->user()->image)
                            <img src="{{ asset(auth()->guard('admin')->user()->image) }}" alt="" class="h-auto rounded-circle">
                        @else
                            <div class="avatar-fallback mb-4 me-5" style="width:40px; height:40px; font-size:20px">
                                {{ Str::upper(mb_substr(auth()->guard('admin')->user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);">
                            <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-online">
                                    @if (auth()->guard('admin')->user()->image)
                                        <img src="{{ asset(auth()->guard('admin')->user()->image) }}" alt="" class="h-auto rounded-circle">
                                    @else
                                        <div class="avatar-fallback mb-4 me-5" style="width:40px; height:40px; font-size:20px">
                                            {{ Str::upper(mb_substr(auth()->guard('admin')->user()->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <span class="fw-semibold d-block">{{ auth()->guard('admin')->name }}</span>
                                <small class="text-muted">{{ __('trans.guard.admin') }}</small>
                            </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);">
                            <i class="ti ti-user-check me-2 ti-sm"></i>
                            <span class="align-middle">{{ __('trans.auth.profile') }}</span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ UrlLang('admin/logout') }}" target="_blank">
                            <i class="ti ti-logout me-2 ti-sm"></i>
                            <span class="align-middle">{{ __('trans.auth.logout') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>

</nav>
