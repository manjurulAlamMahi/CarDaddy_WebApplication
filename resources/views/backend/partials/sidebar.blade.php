<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row align-items-center">
            <li class="nav-item mr-auto">
                <a class="navbar-brand m-0" href="{{ route('dashboard') }}">
                    <img src="{{ asset($setting->admin_logo ?? 'backend/app-assets/images/logo/logo.png') }}"
                        width="40" alt="logo">
                    <h2 class="brand-text">{{ $setting->admin_title ?? 'My Admin' }}</h2>
                </a>
            </li>
            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                    <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i>
                    <i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc"
                        data-ticon="disc"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('dashboard') }}">
                    <i data-feather="home"></i>
                    <span class="menu-item text-truncate" data-i18n="Analytics">
                        Home
                    </span>
                </a>
            </li>

            <li class=" navigation-header" style="margin-top: 15px;">
                <span data-i18n="Charts &amp; Maps">
                    CMS
                </span>
                <i data-feather="more-horizontal"></i>
            </li>

            <li class="nav-item {{ request()->routeIs('about.index') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('about.index') }}">
                    <i data-feather="cloud"></i>
                    <span class="menu-item text-truncate" data-i18n="Analytics">
                        About Us
                    </span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('blog.index') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('blog.index') }}">
                    <i data-feather="edit"></i>
                    <span class="menu-item text-truncate" data-i18n="Analytics">
                        Blog
                    </span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('testimonial.index') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('testimonial.index') }}">
                    <i data-feather="twitch"></i>
                    <span class="menu-item text-truncate" data-i18n="Analytics">
                        Testimonial
                    </span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('faq.index') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('faq.index') }}">
                    <i data-feather="help-circle"></i>
                    <span class="menu-title text-truncate" data-i18n="ag-grid">
                        FAQ
                    </span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('dynamicpages.index') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('dynamicpages.index') }}">
                    <i data-feather="layers"></i>
                    <span class="menu-title text-truncate">
                        Dynamic Pages
                    </span>
                </a>
            </li>


            <li class=" navigation-header" style="margin-top: 15px;">
                <span data-i18n="Charts &amp; Maps">
                    Vehicle
                </span>
                <i data-feather="more-horizontal"></i>
            </li>

            {{-- <li class="nav-item {{ request()->routeIs('vehicle.create') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('vehicle.create') }}">
                    <i data-feather="truck"></i>
                    <span class="menu-title text-truncate">
                        Create Vehicle
                    </span>
                </a>
            </li> --}}

            <li class="nav-item {{ request()->routeIs('vehicle.list') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('vehicle.list') }}">
                    <i data-feather="list"></i>
                    <span class="menu-title text-truncate">
                        Vehicle List
                    </span>
                </a>
            </li>

            <li class=" navigation-header">
                <span data-i18n="Charts &amp; Maps">
                    Vehicle Details
                </span>
                <i data-feather="more-horizontal"></i>
            </li>

            <li class="{{ request()->routeIs('brand.index') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('brand.index') }}">
                    <i data-feather="command"></i>
                    <span class="menu-item text-truncate" data-i18n="Analytics">
                        Brand
                    </span>
                </a>
            </li>

            <li class="{{ request()->routeIs('category.index') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('category.index') }}">
                    <i data-feather="grid"></i>
                    <span class="menu-item text-truncate" data-i18n="Analytics">
                        Category
                    </span>
                </a>
            </li>


            <li class="nav-item {{ request()->routeIs('bodyType.index') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="sliders"></i>
                    <span class="menu-title text-truncate" data-i18n="ag-grid">
                        Specifications
                    </span>
                </a>
                <ul class="menu-content">
                    <li class="{{ request()->routeIs('bodyType.index') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('bodyType.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Chartjs">
                                Body Type
                            </span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('color.index') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('color.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Chartjs">
                                Color
                            </span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('cylinder.index') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('cylinder.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Chartjs">
                                Cylinder
                            </span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('door.index') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('door.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Chartjs">
                                Door
                            </span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('drivetrain.index') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('drivetrain.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Chartjs">
                                Drivetrain
                            </span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('fuelType.index') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('fuelType.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Chartjs">
                                Fuel Type
                            </span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('mileage.index') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('mileage.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Chartjs">
                                Mileage
                            </span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('mpg.index') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('mpg.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Chartjs">
                                MPG
                            </span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('size.index') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('size.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Chartjs">
                                Size
                            </span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('transmission.index') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('transmission.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Chartjs">
                                Transmission
                            </span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="{{ request()->routeIs('image.index') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('image.index') }}">
                    <i data-feather="image"></i>
                    <span class="menu-item text-truncate" data-i18n="Analytics">
                        Image Type
                    </span>
                </a>
            </li>

            {{-- <li class="{{ request()->routeIs('declaration.index') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('declaration.index') }}">
                    <i data-feather="check-square"></i>
                    <span class="menu-item text-truncate" data-i18n="Analytics">
                        Declaration
                    </span>
                </a>
            </li> --}}

            <li class="{{ request()->routeIs('tag.index') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('tag.index') }}">
                    <i data-feather="tag"></i>
                    <span class="menu-item text-truncate" data-i18n="Analytics">
                        Tag
                    </span>
                </a>
            </li>


            <li class=" navigation-header">
                <span data-i18n="Charts &amp; Maps">
                    Settings
                </span>
                <i data-feather="more-horizontal"></i>
            </li>

            <li
                class="nav-item {{ request()->routeIs(['admin.setting.*', 'profile.*', 'dynamicpages.*']) ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="settings"></i>
                    <span class="menu-title text-truncate" data-i18n="Charts">
                        System Settings
                    </span>
                    {{-- <span class="badge badge-light-success badge-pill ml-auto mr-2">
                        4
                    </span> --}}
                </a>
                <ul class="menu-content">
                    <li class="{{ request()->routeIs('profile') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('profile') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Chartjs">
                                Profile Settings
                            </span>
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('system.setting') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('system.setting') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Chartjs">
                                System Setting
                            </span>
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('admin.setting') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('admin.setting') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Chartjs">
                                Admin Setting
                            </span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('admin.setting.stripe') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('admin.setting.stripe') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Chartjs">
                                Stripe Setting
                            </span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('admin.setting.paypal') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('admin.setting.paypal') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Chartjs">
                                Paypal Setting
                            </span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('admin.setting.mail') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('admin.setting.mail') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Chartjs">
                                Mail Setting
                            </span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="shield"></i>
                    <span class="menu-title text-truncate" data-i18n="Charts">
                        Role Permissions
                    </span>
                </a>
                <ul class="menu-content">
                    <li class="{{ request()->routeIs('admin.role.*') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('admin.role.list') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Apex">
                                Role
                            </span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('admin.permissions.list') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('admin.permissions.list') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Chartjs">
                                Permissions
                            </span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item {{ request()->routeIs('user.list') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="users"></i>
                    <span class="menu-title text-truncate" data-i18n="ag-grid">
                        Users
                    </span>
                </a>
                <ul class="menu-content">
                    <li class="{{ request()->routeIs('user.create') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('user.create') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Chartjs">
                                Create User
                            </span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('user.list') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('user.list') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Chartjs">
                                User List
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
