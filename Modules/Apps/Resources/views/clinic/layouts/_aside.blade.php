<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">

        <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">

            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>

            <li class="nav-item {{ active_menu('clinic.home') }}">
                <a href="{{ url(route('clinic.home')) }}" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">{{ __('apps::clinic.index.title') }}</span>
                    <span class="selected"></span>
                </a>
            </li>

            @permission('clinic_access')
            <li class="nav-item {{ active_menu('clinic.users.index') }}">
                <a href="{{ url(route('clinic.users.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::clinic._layout.aside.users') }}</span>
                </a>
            </li>
            @endpermission

            @permission('clinic_access')
            <li class="nav-item {{ active_menu('clinic.staffs.index') }}">
                <a href="{{ url(route('clinic.staffs.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::clinic._layout.aside.staffs') }}</span>
                </a>
            </li>
            @endpermission

            @permission('clinic_access')
            <li class="nav-item {{ active_menu('clinic.doctors.index') }}">
                <a href="{{ url(route('clinic.doctors.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::clinic._layout.aside.doctors') }}</span>
                </a>
            </li>
            @endpermission


            @permission('clinic_access')
            <li class="nav-item {{ active_menu('clinic.operators.index') }}">
                <a href="{{ url(route('clinic.operators.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::clinic._layout.aside.operators') }}</span>
                </a>
            </li>
            @endpermission

            @permission('clinic_access')
            <li class="nav-item {{ active_menu('clinic.rooms.index') }}">
                <a href="{{ url(route('clinic.rooms.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::clinic._layout.aside.rooms') }}</span>
                </a>
            </li>
            @endpermission

            @permission('clinic_access')
            <li class="nav-item {{ active_menu('clinic.categories.index') }}">
                <a href="{{ url(route('clinic.categories.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::clinic._layout.aside.categories') }}</span>
                </a>
            </li>
            @endpermission

            @permission('clinic_access')
            <li class="nav-item {{ active_menu('clinic.services.index') }}">
                <a href="{{ url(route('clinic.services.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::clinic._layout.aside.services') }}</span>
                </a>
            </li>
            @endpermission

            @permission('clinic_access')
            <li class="nav-item {{ active_menu('clinic.coupons.index') }}">
                <a href="{{ url(route('clinic.coupons.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::clinic._layout.aside.coupons') }}</span>
                </a>
            </li>
            @endpermission

            @permission('clinic_access')
            <li class="nav-item {{ active_menu('clinic.offers.index') }}">
                <a href="{{ url(route('clinic.offers.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::clinic._layout.aside.offers') }}</span>
                </a>
            </li>
            @endpermission

            @permission('clinic_access')
            <li class="nav-item {{ active_menu('clinic.booked_offers.index') }}">
                <a href="{{ url(route('clinic.booked_offers.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::clinic._layout.aside.booked_offers') }}</span>
                </a>
            </li>
            @endpermission

            <li class="nav-item {{ active_menu('clinic.orders.index') }}">
                <a href="{{ url(route('clinic.orders.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::clinic._layout.aside.orders') }}</span>
                </a>
            </li>

            <li class="nav-item {{ active_menu('clinic.orders.calendar') }}">
                <a href="{{ url(route('clinic.orders.calendar')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::clinic._layout.aside.orders_calendar') }}</span>
                </a>
            </li>

            @permission('clinic_access')
            <li class="nav-item {{ active_menu('clinic.blogs.index') }}">
                <a href="{{ url(route('clinic.blogs.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::clinic._layout.aside.blogs') }}</span>
                </a>
            </li>
            @endpermission

        </ul>
    </div>
</div>
