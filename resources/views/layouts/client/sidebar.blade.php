<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ url('/') }}" class="app-brand-link">
            {{-- <span class="app-brand-logo demo">
                <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                        fill="#0077b6" />
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
                    fill="#0077b6" />
                </svg>
            </span> --}}
            <span class="app-brand-text demo menu-text fw-bold">Logo</span>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-item">
            <a href="{{ UrlLang('client/dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-layout-dashboard"></i>
                <div>{{ __('trans.dashboard.title') }}</div>
            </a>
        </li>

        <!-- live_tracking -->
        <li class="menu-item">
            <a href="javascript:void(0)" class="menu-link">
                <i class="menu-icon tf-icons ti ti-map"></i>
                <div>{{ __('trans.live_tracking.title') }}</div>
            </a>
        </li>

        <!-- fleet_management -->
        <li class="menu-item">
            <a href="javascript:void(0)" class="menu-link">
                <i class="menu-icon tf-icons ti ti-route"></i>
                <div>{{ __('trans.fleet_management.title') }}</div>
            </a>
        </li>

        <!-- smart_maintenance -->
        <li class="menu-item">
            <a href="javascript:void(0)" class="menu-link">
                <i class="menu-icon tf-icons ti ti-tools"></i>
                <div>{{ __('trans.maintenance.smart_maintenance') }}</div>
            </a>
        </li>

        <!-- energy_monitoring -->
        <li class="menu-item">
            <a href="javascript:void(0)" class="menu-link">
                <i class="menu-icon tf-icons ti ti-dashboard"></i>
                <div>{{ __('trans.energy_monitoring.title') }}</div>
            </a>
        </li>

        <!-- ads -->
        <li class="menu-item">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-ad"></i>
                <div>{{ __('trans.ads.mobile_ads') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ UrlLang('client/campaigns') }}" class="menu-link">
                        <div="Tabler">{{ __('trans.campaign.title') }}</div=>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link">
                        <div="Fontawesome">{{ __('trans.schedule.title') }}</div=>
                    </a>
                </li>
            </ul>
        </li>

        <!-- geographical_area -->
        <li class="menu-item">
            <a href="javascript:void(0)" class="menu-link">
                <i class="menu-icon tf-icons ti ti-map-pin"></i>
                <div>{{ __('trans.geographical_area.title') }}</div>
            </a>
        </li>

        <!-- camera -->
        <li class="menu-item">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-camera"></i>
                <div>{{ __('trans.camera.title') }}</div>
            </a>
            {{-- <ul class="menu-sub">
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link">
                        <div="Tabler">{{ __('trans.campaign.title') }}</div=>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link">
                        <div="Fontawesome">{{ __('trans.schedule.title') }}</div=>
                    </a>
                </li>
            </ul> --}}
        </li>

        <!-- statistics -->
        <li class="menu-item">
            <a href="javascript:void(0)" class="menu-link">
                <i class="menu-icon tf-icons ti ti-chart-bar"></i>
                <div>{{ __('trans.statistic.title') }}</div>
            </a>
        </li>

        <!-- notifications -->
        <li class="menu-item">
            <a href="javascript:void(0)" class="menu-link">
                <i class="menu-icon tf-icons ti ti-bell"></i>
                <div>{{ __('trans.notification.title') }}</div>
            </a>
        </li>

        <!-- setting -->
        <li class="menu-item">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-settings"></i>
                <div>{{ __('trans.setting.title') }}</div>
            </a>
            {{-- <ul class="menu-sub">
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link">
                        <div="Tabler">Tabler</div=>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link">
                        <div="Fontawesome">Fontawesome</div=>
                    </a>
                </li>
            </ul> --}}
        </li>

    </ul>
</aside>
