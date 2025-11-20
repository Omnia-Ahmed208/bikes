<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ url('/') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                        fill="#7367F0" />
                    <path
                        opacity="0.06"
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z"
                        fill="#161616" />
                    <path
                        opacity="0.06"
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z"
                        fill="#161616" />
                    <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                    fill="#7367F0" />
                </svg>
            </span>
            <span class="app-brand-text demo menu-text fw-bold">Logo</span>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-item active">
            <a href="{{ UrlLang('admin/dashboard') }}" class="menu-link text-dark">
                <i class="menu-icon tf-icons ti ti-home"></i>
                <div>{{ __('trans.dashboard.title') }}</div>
            </a>
        </li>

        <!-- account_management -->
        <li class="menu-item">
            <a href="javascript:void(0)" class="menu-link text-dark menu-toggle">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div>{{ __('trans.account_management.title') }}</div>
            </a>
            {{-- <ul class="menu-sub">
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link text-dark">
                        <div="Tabler">Tabler</div=>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link text-dark">
                        <div="Fontawesome">Fontawesome</div=>
                    </a>
                </li>
            </ul> --}}
        </li>

        <!-- statistics -->
        <li class="menu-item">
            <a href="javascript:void(0)" class="menu-link text-dark">
                <i class="menu-icon tf-icons ti ti-chart-bar"></i>
                <div>{{ __('trans.statistic.title') }}</div>
            </a>
        </li>

        <!-- notifications -->
        <li class="menu-item">
            <a href="{{ UrlLang('admin/notifications') }}" class="menu-link text-dark">
                <i class="menu-icon tf-icons ti ti-bell"></i>
                <div>{{ __('trans.notification.title') }}</div>
            </a>
        </li>

        <!-- setting -->
        <li class="menu-item">
            <a href="javascript:void(0)" class="menu-link text-dark menu-toggle">
                <i class="menu-icon tf-icons ti ti-settings"></i>
                <div>{{ __('trans.setting.title') }}</div>
            </a>
            {{-- <ul class="menu-sub">
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link text-dark">
                        <div="Tabler">Tabler</div=>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link text-dark">
                        <div="Fontawesome">Fontawesome</div=>
                    </a>
                </li>
            </ul> --}}
        </li>

    </ul>
</aside>
