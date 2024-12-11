<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('admin.index') }}" class="app-brand-link">
            <img src="/assets/admin/img/branding/logo.svg" alt="logo">
        </a>

        <a class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx menu-toggle-icon d-none d-xl-block fs-4 align-middle"></i>
            <i class="bx bx-x d-block d-xl-none bx-sm align-middle"></i>
        </a>
    </div>
@php
$route = explode('.', Route::currentRouteName())[1];
@endphp
    <div class="menu-divider mt-0"></div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @can('view-users')
            <li @class(["menu-item", 'active' => $route == 'user'])>
                <a href="{{ route("admin.user.index") }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="کاربران">کاربران</div>
                </a>
            </li>
        @endcan
        @can('view-comments')
            <li @class(["menu-item", 'active' => $route == 'comment'])>
                <a href="{{ route("admin.comment.index") }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-chat"></i>
                    <div data-i18n="نظرات">نظرات</div>
                </a>
            </li>
        @endcan
        @can('view-orders')
            <li @class(["menu-item", 'active' => $route == 'order'])>
                <a href="{{ route("admin.order.index") }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-food-menu"></i>
                    <div data-i18n="سفارش ها">سفارش ها</div>
                </a>
            </li>
        @endcan
        @can('view-products')
            <li @class(["menu-item", 'active' => $route == 'product'])>
                <a href="{{ route("admin.product.index") }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-layout"></i>
                    <div data-i18n="دوره ها">دوره ها</div>
                </a>
            </li>
        @endcan
        @can('view-posts')
            <li @class(["menu-item", 'active' => $route == 'post'])>
                <a href="{{ route("admin.post.index") }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-detail"></i>
                    <div data-i18n="پست ها">پست ها</div>
                </a>
            </li>
        @endcan
        @can('view-daily-reports')
            <li @class(["menu-item", 'active' => $route == 'dailyreport'])>
                <a href="{{ route("admin.dailyreport.index") }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-chart"></i>
                    <div data-i18n="گزارش روزانه بازار">گزارش روزانه بازار</div>
                </a>
            </li>
        @endcan
        @can('view-job-offers')
            <li @class(["menu-item", 'active' => $route == 'joboffer'])>
                <a href="{{ route("admin.joboffer.index") }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxl-linkedin"></i>
                    <div data-i18n="فرصت های شغلی">فرصت های شغلی</div>
                </a>
            </li>
        @endcan
        @can('view-job-applications')
            <li @class(["menu-item", 'active' => $route == 'jobapplication'])>
                <a href="{{ route("admin.jobapplication.index") }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-receipt"></i>
                    <div data-i18n="رزومه های ارسال شده">رزومه های ارسال شده</div>
                </a>
            </li>
        @endcan
        @can('menu-entries')
            <li @class(["menu-item", 'active' => $route == 'menuentry'])>
                <a href="{{ route("admin.menuentry.index") }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-menu"></i>
                    <div data-i18n="منو">منو</div>
                </a>
            </li>
        @endcan
        @can('view-logs')
            <li @class(["menu-item", 'active' => $route == 'log'])>
                <a href="{{ route("admin.log.index") }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-file"></i>
                    <div data-i18n="لاگ">لاگ</div>
                </a>
            </li>
        @endcan
    </ul>
</aside>
