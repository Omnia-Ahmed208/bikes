@php
    $user = auth()->guard('doctor')->user();
@endphp

<nav class="navbar doctor-navbar navbar-expand-lg bg-white shadow-sm p-0">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="{{ url('backend') }}/img/logo.svg" width="100" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav navbar-nav-center me-auto mb-2 mb-lg-0 w-100 justify-content-center">
                <li class="nav-item m-1">
                    <a class="nav-link btn btn-primary text-white d-inline-block shadow-none px-3 {{ Route::currentRouteName() == 'doctor.dashboard' ? 'active' : '' }}" aria-current="page" href="{{ UrlLang('doctor/dashboard') }}">{{ __('trans.dashboard.title') }}</a>
                </li>
                <li class="nav-item m-1">
                    <a class="nav-link btn btn-primary text-white d-inline-block shadow-none px-3
                        {{ request()->is(AppLang().'/doctor/patients*')
                        || request()->is(AppLang().'/doctor/medical-tests*')
                        || request()->is(AppLang().'/doctor/radiologys*')
                        || request()->is(AppLang().'/doctor/medicines*') ? 'active' : '' }}"
                        href="{{ UrlLang('doctor/patients') }}">
                        {{ __('trans.patient.title') }}
                    </a>
                </li>
                <li class="nav-item m-1">
                    {{-- {{ request()->is(AppLang().'/doctor/appointments') ? 'active' : '' }}" --}}
                    <a class="nav-link btn btn-primary text-white d-inline-block shadow-none px-3
                        {{-- {{ UrlLang('doctor/appointments') == url()->current() ? 'active' : '' }}" --}}
                        {{ request()->is(AppLang().'/doctor/appointments*')
                        || request()->is(AppLang().'/doctor/consultations*') ? 'active' : '' }}"
                        href="{{ UrlLang('doctor/appointments') }}">
                        {{ __('trans.appointment.title') }}
                    </a>

                </li>
                <li class="nav-item m-1">
                    <a class="nav-link btn btn-primary text-white d-inline-block shadow-none px-3
                        {{ UrlLang('doctor/reports') == url()->current() ? 'active' : '' }}"
                        href="{{ UrlLang('doctor/reports') }}">
                        {{ __('trans.report.title') }}
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
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

                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle text-dark d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bx bx-bell mx-2"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end py-0 position-absolute">
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);">
                                {{-- <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <img src="{{ asset('backend/assets/img/user.svg') }}" alt class="w-px-40 h-auto rounded-circle">
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-semibold d-block text-dark">title</span>
                                        <small class="text-muted">4 minutes ago</small>
                                    </div>
                                </div> --}}
                                {{ __('trans.notification.no_notification') }}
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle text-dark d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-online avatar-navbar">
                                    @if ($user->image)
                                        <img src="{{ asset($user->image) }}" alt="" class="rounded-circle">
                                    @else
                                        <div class="avatar-fallback mb-4 me-5" style="width:40px; height:40px; font-size:20px">
                                            {{ Str::upper(mb_substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-grow-1 d-lg-block d-none">
                                <span class="fw-semibold d-block text-dark">{{ $user->name }}</span>
                                <small class="text-dark">{{ $user->category->translation->title }}</small>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end position-absolute px-3">
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online avatar-navbar">
                                            @if ($user->image)
                                                <img src="{{ asset($user->image) }}" alt="" class="rounded-circle">
                                            @else
                                                <div class="avatar-fallback mb-4 me-5" style="width:40px; height:40px; font-size:20px">
                                                    {{ Str::upper(mb_substr($user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-semibold d-block text-dark">{{ $user->name }}</span>
                                        <small class="text-dark">{{ $user->category->translation->title }}</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item rounded text-dark" href="{{ UrlLang('doctor/profile') }}">
                                <span class="align-middle">{{ __('trans.doctor.profile') }}</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item rounded text-dark" href="{{ UrlLang('doctor/bank-account') }}">
                                <span class="align-middle">{{ __('trans.doctor.bank_account') }}</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item rounded text-dark" href="{{ UrlLang('doctor/appointments/create') }}">
                                <span class="align-middle">{{ __('trans.doctor.appointments') }}</span>
                            </a>
                        </li>
                         <li>
                            <a class="dropdown-item rounded text-dark" href="{{ UrlLang('doctor/reviews') }}">
                                <span class="align-middle">{{ __('trans.doctor.reviews') }}</span>
                            </a>
                        </li>
                         <li>
                            <a class="dropdown-item rounded text-dark" href="{{ UrlLang('doctor/privacy-terms') }}">
                                <span class="align-middle">{{ __('trans.doctor.privacy_terms') }}</span>
                            </a>
                        </li>
                         <li>
                            <a class="dropdown-item rounded text-dark" href="{{ UrlLang('doctor/contact-us') }}">
                                <span class="align-middle">{{ __('trans.doctor.contact_us') }}</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item rounded text-dark" href="{{ UrlLang('doctor/logout') }}">
                                <span class="align-middle">{{ __('trans.auth.logout') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>
