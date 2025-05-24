<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>

            <li class="nav-item {{ active_menu('dashboard.home') }}">
                <a href="{{ url(route('dashboard.home')) }}" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">{{ __('apps::dashboard.index.title') }}</span>
                    <span class="selected"></span>
                </a>
            </li>

            <li class="heading">
                <h3 class="uppercase">{{ __('apps::dashboard._layout.aside._tabs.roles_permissions') }}</h3>
            </li>

            @permission('show_roles')
            <li class="nav-item {{ active_menu('roles') }}">
                <a href="{{ url(route('dashboard.roles.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.roles') }}</span>
                </a>
            </li>
            @endpermission


            <li class="heading">
                <h3 class="uppercase">{{ __('apps::dashboard._layout.aside._tabs.users') }}</h3>
            </li>

            @permission('show_users')
            <li class="nav-item {{ active_menu('dashboard.users.index') }}">
                <a href="{{ url(route('dashboard.users.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.users') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_admins')
            <li class="nav-item {{ active_menu('dashboard.admins.index') }}">
                <a href="{{ url(route('dashboard.admins.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.admins') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_staffs')
            <li class="nav-item {{ active_menu('dashboard.staffs.index') }}">
                <a href="{{ url(route('dashboard.staffs.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.staffs') }}</span>
                </a>
            </li>
            @endpermission

            <li class="heading">
                <h3 class="uppercase">{{ __('apps::dashboard._layout.aside._tabs.areas') }}</h3>
            </li>

            {{-- @permission('show_countries')
            <li class="nav-item {{ active_menu('dashboard.countries.index') }}">
                <a href="{{ url(route('dashboard.countries.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.countries') }}</span>
                </a>
            </li>
            @endpermission --}}

            @permission('show_cities')
            <li class="nav-item {{ active_menu('dashboard.cities.index') }}">
                <a href="{{ url(route('dashboard.cities.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.cities') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_states')
            <li class="nav-item {{ active_menu('dashboard.states.index') }}">
                <a href="{{ url(route('dashboard.states.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.states') }}</span>
                </a>
            </li>
            @endpermission

            <li class="heading">
                <h3 class="uppercase">{{ __('apps::dashboard._layout.aside._tabs.clinics') }}</h3>
            </li>

            @permission('show_specialties')
            <li class="nav-item {{ active_menu('dashboard.specialties.index') }}">
                <a href="{{ url(route('dashboard.specialties.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.specialties') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_clinics')
            <li class="nav-item {{ active_menu('dashboard.clinics.index') }}">
                <a href="{{ url(route('dashboard.clinics.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.clinics') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_doctors')
            <li class="nav-item {{ active_menu('dashboard.doctors.index') }}">
                <a href="{{ url(route('dashboard.doctors.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.doctors') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_operators')
            <li class="nav-item {{ active_menu('dashboard.operators.index') }}">
                <a href="{{ url(route('dashboard.operators.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.operators') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_rooms')
            <li class="nav-item {{ active_menu('dashboard.rooms.index') }}">
                <a href="{{ url(route('dashboard.rooms.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.rooms') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_blogs')
            <li class="nav-item {{ active_menu('dashboard.blogs.index') }}">
                <a href="{{ url(route('dashboard.blogs.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.blogs') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_categories')
            <li class="nav-item {{ active_menu('dashboard.categories.index') }}">
                <a href="{{ url(route('dashboard.categories.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.categories') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_services')
            <li class="nav-item {{ active_menu('dashboard.services.index') }}">
                <a href="{{ url(route('dashboard.services.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.services') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_offers')
            <li class="nav-item {{ active_menu('dashboard.offers.index') }}">
                <a href="{{ url(route('dashboard.offers.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.offers') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_coupons')
            <li class="nav-item {{ active_menu('dashboard.coupons.index') }}">
                <a href="{{ url(route('dashboard.coupons.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.coupons') }}</span>
                </a>
            </li>
            @endpermission

            <li class="heading">
                <h3 class="uppercase">{{ __('apps::dashboard._layout.aside._tabs.orders') }}</h3>
            </li>


            {{-- @permission('show_order_statuses')
            <li class="nav-item {{ active_menu('dashboard.order-statuses.index') }}">
                <a href="{{ url(route('dashboard.order-statuses.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.order_statuses') }}</span>
                </a>
            </li>
            @endpermission --}}

            @permission('show_orders')
            <li class="nav-item">
                <li class="nav-item {{ active_menu('dashboard.orders.index') }}">
                    <a href="{{ url(route('dashboard.orders.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.orders') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_orders')
            <li class="nav-item {{ active_menu('dashboard.orders.calendar') }}">
                <a href="{{ url(route('dashboard.orders.calendar')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.orders_calendar') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_offers')
            <li class="nav-item {{ active_menu('dashboard.booked_offers.index') }}">
                <a href="{{ url(route('dashboard.booked_offers.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.booked_offers') }}</span>
                </a>
            </li>
            @endpermission

            <li class="heading">
                <h3 class="uppercase">{{ __('apps::dashboard._layout.aside._tabs.other') }}</h3>
            </li>

            @permission('show_notifications')
            <li class="nav-item {{ active_menu('dashboard.notifications.index') }}">
                <a href="{{ url(route('dashboard.notifications.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.notifications') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_pages')
            <li class="nav-item {{ active_menu('dashboard.pages.index') }}">
                <a href="{{ url(route('dashboard.pages.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.pages') }}</span>
                </a>
            </li>
            @endpermission

            @permission('edit_settings')
            <li class="nav-item {{ active_menu('dashboard.setting.index') }}">
                <a href="{{ url(route('dashboard.setting.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.setting') }}</span>
                </a>
            </li>
            @endpermission

            @permission('show_telescope')
            <li class="nav-item {{ active_menu('telescope') }}">
                <a href="{{ url(route('telescope')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.telescope') }}</span>
                </a>
            </li>
            @endpermission
        </ul>
    </div>
</div>
