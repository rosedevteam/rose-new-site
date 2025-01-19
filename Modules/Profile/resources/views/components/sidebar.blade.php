<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="#" class="app-brand-link">
            <img src="/assets/admin/img/branding/logo.svg" alt="logo">
        </a>

        <a class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx menu-toggle-icon d-none d-xl-block fs-4 align-middle"></i>
            <i class="bx bx-x d-block d-xl-none bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-divider mt-0"></div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

    </ul>
</aside>

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme rose-side-menu">
    <div class="app-brand demo">
        <a href="https://roseoj.com" class="app-brand-link">
              <span class="app-brand-logo demo" style="width: 100%; height: auto">
                <img src="/assets/admin/img/branding/logo.svg" width="100%">
              </span>
        </a>
    </div>

    <div class="menu-divider mt-0"></div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

{{--        @foreach(\Module::collections() as $module)--}}
{{--            @if(\View::exists("{$module->getLowerName()}::front.sidebar"))--}}
{{--                @if(\Nwidart\Modules\Module::isEnable($module->getName()))--}}
{{--                    @include("{$module->getLowerName()}::front.sidebar")--}}
{{--                @endif--}}
{{--            @endif--}}
{{--        @endforeach--}}
        <li class="menu-item @if(URL::current() == route('profile.index')) active @endif">
            <a href="{{route('profile.index')}}" class="menu-link">
                <svg width="20" height="20" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M19.842 8.79925L13.842 4.13225C12.759 3.28925 11.242 3.28925 10.158 4.13225L4.158 8.79925C3.427 9.36725 3 10.2413 3 11.1673V18.5002C3 20.1572 4.343 21.5002 6 21.5002H18C19.657 21.5002 21 20.1572 21 18.5002V11.1673C21 10.2413 20.573 9.36725 19.842 8.79925Z" stroke="#737887" stroke-width="1.5"></path>
                    <path d="M9 17.5H15" stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>

                <div>پیشخوان</div>
            </a>
        </li>
        <li class="menu-item @if(URL::current() == route('profile.orders')) active @endif">
            <a href="{{route('profile.orders')}}" class="menu-link">
                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 9.5H17" stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M7 17.5H9" stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M12 17.5H17" stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M19 4.5C20.105 4.5 21 5.395 21 6.5V19.5C21 20.605 20.105 21.5 19 21.5H5C3.895 21.5 3 20.605 3 19.5V6.5C3 5.395 3.895 4.5 5 4.5" stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M7 13.5H9" stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M12 13.5H17" stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10 3.5H8C7.448 3.5 7 3.948 7 4.5V9.5L9 8.5L11 9.5V4.5C11 3.948 10.552 3.5 10 3.5Z" stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M5 4.5H7" stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M11 4.5H19" stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                <div>دوره های من</div>
            </a>
        </li>
    </ul>

    <ul class="menu-inner py-1 justify-content-end">
{{--            <li class="menu-item @if(url()->current() == route('user.settings')) active @endif">--}}
{{--                <a href="{{route('user.settings')}}" class="menu-link">--}}
{{--                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                        <path d="M13.7678 10.7322C14.7441 11.7085 14.7441 13.2915 13.7678 14.2678C12.7915 15.2441 11.2085 15.2441 10.2322 14.2678C9.25592 13.2915 9.25592 11.7085 10.2322 10.7322C11.2085 9.75592 12.7915 9.75592 13.7678 10.7322" stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>--}}
{{--                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.8489 4.62002L15.4319 4.81402C15.9659 4.99202 16.3269 5.49202 16.3269 6.05502V6.89202C16.3269 7.60402 16.8949 8.18502 17.6069 8.20002L18.4449 8.21802C18.9299 8.22802 19.3699 8.50702 19.5869 8.94102L19.8619 9.49102C20.1139 9.99502 20.0149 10.603 19.6169 11.001L19.0249 11.593C18.5219 12.096 18.5129 12.909 19.0049 13.423L19.5849 14.029C19.9209 14.38 20.0349 14.887 19.8809 15.348L19.6869 15.931C19.5089 16.465 19.0089 16.826 18.4459 16.826H17.6089C16.8969 16.826 16.3159 17.394 16.3009 18.106L16.2829 18.944C16.2729 19.429 15.9939 19.869 15.5599 20.086L15.0099 20.361C14.5059 20.613 13.8979 20.514 13.4999 20.116L12.9079 19.524C12.4049 19.021 11.5919 19.012 11.0779 19.504L10.4719 20.084C10.1209 20.42 9.61391 20.534 9.15291 20.38L8.56991 20.186C8.03591 20.008 7.67491 19.508 7.67491 18.945V18.108C7.67491 17.396 7.10691 16.815 6.39491 16.8L5.55691 16.782C5.07191 16.772 4.63191 16.493 4.41491 16.059L4.13991 15.509C3.88791 15.005 3.98691 14.397 4.38491 13.999L4.97691 13.407C5.47991 12.904 5.48891 12.091 4.99691 11.577L4.41691 10.971C4.07991 10.619 3.96591 10.111 4.11991 9.65102L4.31391 9.06802C4.49191 8.53402 4.99191 8.17302 5.55491 8.17302H6.39191C7.10391 8.17302 7.68491 7.60502 7.69991 6.89302L7.71791 6.05502C7.72991 5.57002 8.00791 5.13002 8.44191 4.91302L8.99191 4.63802C9.49591 4.38602 10.1039 4.48502 10.5019 4.88302L11.0939 5.47502C11.5969 5.97802 12.4099 5.98702 12.9239 5.49502L13.5299 4.91502C13.8809 4.58002 14.3889 4.46602 14.8489 4.62002V4.62002Z" stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>--}}
{{--                    </svg>--}}

{{--                    <div>تنظیمات</div>--}}
{{--                </a>--}}
{{--            </li>--}}

{{--        <li class="menu-item">--}}
{{--            <button onclick="logout()" class="menu-link" style="color: #E92C56; border: none !important; background: none !important;">--}}
{{--                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                    <path d="M9.86011 12.5H20.0001" stroke="#E92C56" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>--}}
{{--                    <path d="M10.8641 20.481L6.69605 20.5C5.50105 20.506 4.52905 19.548 4.52905 18.365V6.635C4.52905 5.456 5.49405 4.5 6.68605 4.5H11.0001" stroke="#E92C56" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>--}}
{{--                    <path d="M16 16.5L20 12.5L16 8.5" stroke="#E92C56" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>--}}
{{--                </svg>--}}
{{--                خروج--}}
{{--            </button>--}}
{{--        </li>--}}
    </ul>
</aside>
