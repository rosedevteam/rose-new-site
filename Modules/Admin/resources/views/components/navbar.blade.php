<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="container-fluid">
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4">
                <i class="bx bx-menu bx-sm"></i>
            </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <ul class="navbar-nav flex-row align-items-center ms-auto">
                <li class="nav-item me-2">
                    <a class="dropdown-item" href="{{ route("admin.users.edit", auth()->user()) }}">
                    <span class="fw-semibold d-block">{{ auth()->user()->name() }}</span>
                    </a>
                    <small>{{ auth()->user()->role() }}</small>
                </li>
                <li class="nav-item me-2">
                    <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);">
                        <i class="bx bx-sm" style="font-size: 2rem !important;"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <form id="logout" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="bx bx-power-off me-2 exit-button" style="font-size: 2rem !important;"></i>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
