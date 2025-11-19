<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ url($setting->logo ?? 'backend/assets/img/user.svg') }}" class="rounded-circle" width="50" alt="logo">
            </span>
            {{-- <span class="app-brand-text demo menu-text fw-bolder ms-2" style="font-size: 1.2rem;">
                {{ $setting->site_name ?? env("APP_NAME") }}
            </span> --}}
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">{{ __('trans.global.dashboard') }}</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('admin.users.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-user"></i>
            <div data-i18n="Basic">{{ __('trans.user.title') }}</div>
            </a>
        </li>
{{--
        <li class="menu-item">
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="menu-link">
                <i class="menu-icon tf-icons bx bx-log-out"></i>
                <div data-i18n="Logout">{{ __('trans.auth.logout') }}</div>
            </a>
        </li> --}}
    </ul>
</aside>
