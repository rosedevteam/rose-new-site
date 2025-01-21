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
        $route2 = explode('.', Route::currentRouteName())[2];
    @endphp
    <div class="menu-divider mt-0"></div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @can('view-users')
            <li @class(["menu-item", 'active' => $route == 'users'])>
                <a href="{{ route("admin.users.index") }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="کاربران">کاربران</div>
                </a>
            </li>
        @endcan
        @can('view-comments')
            <li @class(["menu-item", 'active' => $route == 'comments'])>
                <a href="{{ route("admin.comments.index") }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-chat"></i>
                    <div data-i18n="نظرات">نظرات</div>
                </a>
            </li>
        @endcan
        @can('view-orders')
            <li @class(["menu-item", 'active' => $route == 'orders'])>
                <a href="{{ route("admin.orders.index") }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-receipt"></i>
                    <div data-i18n="سفارش ها">سفارش ها</div>
                </a>
            </li>
        @endcan
        @can('view-products')
            <li @class(["menu-item", 'active' => $route == 'products'])>
                <a href="{{ route("admin.products.index") }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-layout"></i>
                    <div data-i18n="دوره ها">دوره ها</div>
                </a>
            </li>
        @endcan
        @can('view-posts')
            <li @class(["menu-item", 'active' => $route == 'posts'])>
                <a href="{{ route("admin.posts.index") }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-detail"></i>
                    <div data-i18n="پست ها">پست ها</div>
                </a>
            </li>
        @endcan
        @can('view-podcasts')
            <li @class(["menu-item", 'active' => $route == 'podcasts'])>
                <a href="{{ route("admin.podcasts.index") }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-podcast"></i>
                    <div data-i18n="پادکست ها">پادکست ها</div>
                </a>
            </li>
        @endcan
        @can('view-discounts')
            <li @class(["menu-item", 'active' => $route == 'discounts'])>
                <a href="{{ route("admin.discounts.index") }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-offer"></i>
                    <div data-i18n="تخفیف ها">تخفیف ها</div>
                </a>
            </li>
        @endcan
        @can('view-daily-reports')
            <li @class(["menu-item", 'active' => $route == 'dailyreports'])>
                <a href="{{ route("admin.dailyreports.index") }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-chart"></i>
                    <div data-i18n="گزارش روزانه بازار">گزارش روزانه بازار</div>
                </a>
            </li>
        @endcan
        @can('view-student-reports')
            <li @class(["menu-item", 'active' => $route == 'studentreports'])>
                <a href="{{ route("admin.studentreports.index") }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-abacus"></i>
                    <div data-i18n="تحلیل ها">تحلیل ها</div>
                </a>
            </li>
        @endcan
        @can('view-job-offers')
            <li @class(["menu-item", 'active' => $route == 'joboffers'])>
                <a href="{{ route("admin.joboffers.index") }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxl-linkedin"></i>
                    <div data-i18n="فرصت های شغلی">فرصت های شغلی</div>
                </a>
            </li>
        @endcan
        @can('view-job-applications')
            <li @class(["menu-item", 'active' => $route == 'jobapplications'])>
                <a href="{{ route("admin.jobapplications.index") }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-food-menu"></i>
                    <div data-i18n="رزومه های ارسال شده">رزومه های ارسال شده</div>
                </a>
            </li>
        @endcan
        @can('view-menus')
            <li @class(["menu-item", 'active' => $route == 'menus'])>
                <a href="{{ route("admin.menus.index") }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-menu"></i>
                    <div data-i18n="منو">منو</div>
                </a>
            </li>
        @endcan
        @can('view-categories')
            <li @class(["menu-item", 'active' => $route == 'categories'])>
                <a href="{{ route("admin.categories.index") }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-category"></i>
                    <div data-i18n="دسته بندی ها">دسته بندی ها</div>
                </a>
            </li>
        @endcan
        @can('manage-channels')
                <li @class(["menu-item", 'active open' => $route == 'channels'])>
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-message-square-dots"></i>
                    <div>کانال ها</div>
                </a>
                <ul class="menu-sub">
                    @can('add-channel')
                        <li @class(["menu-item", 'active' => $route == 'channels' && $route2 == "create"])>
                            <a href="{{route('admin.channels.create')}}" class="menu-link">
                                <div>افزودن کانال جدید</div>
                            </a>
                        </li>
                    @endcan
                    <li @class(["menu-item", 'active' => $route == 'channels' && $route2 == "index"])>
                        <a href="{{route('admin.channels.index')}}" class="menu-link">
                            <div>همه کانال ها</div>
                        </a>
                    </li>

                </ul>
            </li>
        @endcan
            @can('view-logs')
                <li @class(["menu-item", 'active' => $route == 'logs'])>
                    <a href="{{ route("admin.logs.index") }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-file"></i>
                        <div data-i18n="لاگ">لاگ</div>
                    </a>
                </li>
            @endcan
    </ul>
</aside>
