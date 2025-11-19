<nav class="layout-navbar navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme m-0 w-100 rounded-0" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
            <i class="bx bx-menu bx-md"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center justify-content-between w-100" id="navbar-collapse">
        <div class="navbar-nav align-items-center d-none d-lg-block">
            <h5 class="nav-item d-flex align-items-center m-0 mb-1 text-dark fw-bold">
                {{ __('trans.welcome') }} {{ auth()->guard('admin')->name }}
            </h5>
            <div>
                {{ __('trans.welcome_text') }}
            </div>
        </div>

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            {{-- dark mode --}}
            {{-- <li class="nav-item dropdown me-2 me-xl-0">
                <a class="nav-link dropdown-toggle hide-arrow"
                id="nav-theme" href="javascript:void(0);" data-bs-toggle="dropdown"
                aria-label="Toggle theme (light)" aria-expanded="false">
                    <i class="bx-sun icon-base bx icon-md theme-icon-active"></i>
                    <span class="d-none ms-0" id="nav-theme-text">Toggle theme</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="nav-theme-text">
                    <li>
                        <button type="button" class="dropdown-item align-items-center active" data-bs-theme-value="light" aria-pressed="true">
                            <span><i class="icon-base bx bx-sun icon-md me-3" data-icon="sun"></i>Light</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item align-items-center" data-bs-theme-value="dark" aria-pressed="false">
                            <span><i class="icon-base bx bx-moon icon-md me-3" data-icon="moon"></i>Dark</span>
                        </button>
                    </li>
                </ul>
            </li> --}}

            <li class="nav-item me-2 me-xl-0">
                <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);">
                    <i class="ti ti-md"></i>
                    light
                </a>
            </li>

            {{-- notification --}}
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle text-dark d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bx bx-bell mx-0"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end py-0 position-absolute">
                    <li>
                        <a class="dropdown-item" href="#">
                            {{ __('trans.notification.no_notifications') }}
                        </a>
                    </li>
                </ul>
            </li>

            {{-- language --}}
            <li class="nav-item navbar-dropdown dropdown-user dropdown me-2">
                <a class="nav-link dropdown-toggle text-dark d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bx bx-globe mx-2"></i>
                    <span class="d-none d-sm-block">{{ AppLang() == 'ar' ? __('trans.arabic') : __('trans.english') }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end position-absolute">
                    <li>
                        <a class="dropdown-item" href="{{ switchLang('ar') }}">
                            <input type="checkbox" class="form-check-input rounded-circle" id="arabicLang"
                            onclick="location.href='{{ switchLang('ar') }}'"
                            @if (AppLang() == 'ar') checked @endif>
                            {{ __('trans.arabic') }}
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ switchLang('en') }}">
                            <input type="checkbox" class="form-check-input rounded-circle" id="englishLang"
                            onclick="location.href='{{ switchLang('en') }}'"
                            @if (AppLang() == 'en') checked @endif>
                            {{ __('trans.english') }}
                        </a>
                    </li>
                </ul>
            </li>

            {{-- user --}}
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle text-dark d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                                @if (auth()->guard('admin')->user()->image)
                                    <img src="{{ asset(auth()->guard('admin')->user()->image) }}" alt="" class="rounded-circle">
                                @else
                                    <div class="avatar-fallback mb-4 me-5" style="width:40px; height:40px; font-size:20px">
                                        {{ Str::upper(mb_substr(auth()->guard('admin')->user()->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <span class="fw-semibold d-block text-dark">{{ auth()->guard('admin')->name }}</span>
                            <small class="text-muted">{{ __('trans.guard.admin') }}</small>
                        </div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end position-absolute">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar">
                                        @if (auth()->guard('admin')->user()->image)
                                            <img src="{{ asset(auth()->guard('admin')->user()->image) }}" alt="" class="rounded-circle">
                                        @else
                                            <div class="avatar-fallback mb-4 me-5" style="width:40px; height:40px; font-size:20px">
                                                {{ Str::upper(mb_substr(auth()->guard('admin')->user()->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block text-dark">{{ auth()->guard('admin')->name }}</span>
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
                            <i class="bx bx-cog me-2"></i>
                            <span class="align-middle">{{ __('trans.setting.title') }}</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ UrlLang('admin/logout') }}">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle">{{ __('trans.auth.logout') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>

    </div>
</nav>
