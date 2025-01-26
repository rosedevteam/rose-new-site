<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="container-fluid">
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4">
                <i class="bx bx-menu bx-sm"></i>
            </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <ul class="navbar-nav flex-row align-items-center ms-auto">
                <li class="nav-item me-2 me-xl-0">
                    <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);">
                        <i class="bx bx-sm" style="font-size: 2rem !important;"></i>
                    </a>
                </li>
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <div class="avatar avatar-md me-2 d-flex align-items-center justify-content-center">
                            <div class="avatar avatar-online">
                                <img src="/assets/admin/img/avatars/user.png" alt="" class="rounded-circle">
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                        <li>
                            <a class="dropdown-item" href="{{ route("admin.users.edit", auth()->user()) }}">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <img src="/assets/admin/img/avatars/user.png" alt="" class="rounded-circle">
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span
                                            class="fw-semibold d-block">{{ auth()->user()->name() }}</span>
                                        <small>{{ auth()->user()->role() }}</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <form id="logout" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="bx bx-power-off me-2"></i>
                                    <span class="align-middle">خروج</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                <li>
                    <span class="fw-semibold d-block">{{ auth()->user()->name() }}</span>
                    <small>{{ auth()->user()->role() }}</small>
                </li>
            </ul>
        </div>
    </div>
</nav>
