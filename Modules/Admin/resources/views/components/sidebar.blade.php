<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('admin.index') }}" class="app-brand-link">
              <span class="app-brand-logo demo">
                  <img src="/assets/admin/img/branding/logo.svg" width="100%">
              </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">رز</span>
        </a>

        <a class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx menu-toggle-icon d-none d-xl-block fs-4 align-middle"></i>
            <i class="bx bx-x d-block d-xl-none bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-divider mt-0"></div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @can('view-daily-reports')
        <li class="menu-item">
            <a href="{{ route("admin.daily-report.index") }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-map-alt"></i>
                <div data-i18n="گزارش روزانه بازار">گزارش روزانه بازار</div>
            </a>
        </li>
        @endcan
    </ul>
</aside>

