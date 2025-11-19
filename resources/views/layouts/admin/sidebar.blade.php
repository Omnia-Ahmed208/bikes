 <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo py-4">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
                {{-- img --}}
            </span>
            <span class="app-brand-text demo menu-text fw-bold">Logo</span>
        </a>

        {{-- <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a> --}}
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        {{-- <li class="menu-item active open">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-smart-home"></i>
            <div data-i18n="Dashboards">Dashboards</div>
            <div class="badge bg-label-primary rounded-pill ms-auto">3</div>
            </a>
            <ul class="menu-sub">
            <li class="menu-item active">
                <a href="index.html" class="menu-link">
                <div data-i18n="Analytics">Analytics</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="dashboards-crm.html" class="menu-link">
                <div data-i18n="CRM">CRM</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="dashboards-ecommerce.html" class="menu-link">
                <div data-i18n="eCommerce">eCommerce</div>
                </a>
            </li>
            </ul>
        </li> --}}
        <!-- Dashboard -->
        <li class="menu-item">
            <a href="{{ UrlLang('admin/dashboard') }}" class="menu-link">
                {{-- <i class="menu-icon tf-icons bx bx-dashboard"></i> --}}
                <svg  xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                fill="currentColor" viewBox="0 0 24 24"  class="menu-icon tf-icons">
                <!--Boxicons v3.0 https://boxicons.com | License  https://docs.boxicons.com/free-->
                <path d="m20,11h-6c-.55,0-1,.45-1,1v8c0,.55.45,1,1,1h6c.55,0,1-.45,1-1v-8c0-.55-.45-1-1-1Zm-1,8h-4v-6h4v6Z"></path><path d="m10,15h-6c-.55,0-1,.45-1,1v4c0,.55.45,1,1,1h6c.55,0,1-.45,1-1v-4c0-.55-.45-1-1-1Zm-1,4h-4v-2h4v2Z"></path><path d="m20,3h-6c-.55,0-1,.45-1,1v4c0,.55.45,1,1,1h6c.55,0,1-.45,1-1v-4c0-.55-.45-1-1-1Zm-1,4h-4v-2h4v2Z"></path><path d="m10,3h-6c-.55,0-1,.45-1,1v8c0,.55.45,1,1,1h6c.55,0,1-.45,1-1V4c0-.55-.45-1-1-1Zm-1,8h-4v-6h4v6Z"></path>
                </svg>
                <div data-i18n="Analytics">{{ __('trans.dashboard.title') }}</div>
            </a>
        </li>

                <!-- account_management -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Layouts">{{ __('trans.account_management.title') }}</div>
            </a>

            {{-- <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ UrlLang('admin/patients') }}" class="menu-link">
                        <div data-i18n="Without menu">{{ __('trans.patient.title') }}</div>
                    </a>
                </li>
            </ul> --}}
        </li>

        <li class="menu-item">
            <a href="{{ UrlLang('admin/statistics') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bar-chart-alt-2"></i>
                <div data-i18n="Basic">{{ __('trans.statistic.title') }}</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bell"></i>
                <div data-i18n="Basic">{{ __('trans.notification.title') }}</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div data-i18n="Layouts">{{ __('trans.setting.title') }}</div>
            </a>
            {{-- <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ UrlLang('admin/setting') }}" class="menu-link">
                        <div data-i18n="Without menu">{{ __('trans.setting.title') }}</div>
                    </a>
                </li>
            </ul> --}}
        </li>
    </ul>
</aside>














