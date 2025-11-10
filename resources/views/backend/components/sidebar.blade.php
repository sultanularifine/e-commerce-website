<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('home') }}">{{ config('app.name') }}</a>
        </div>

        <ul class="sidebar-menu">
            {{-- Dashboard --}}
            <li class="menu-header">Dashboard</li>
            <li class="nav-item {{ Request::routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <i class="fas fa-fire"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            {{-- Users --}}
            @canany(['user-list', 'user-create', 'user-edit', 'user-delete'])
                <li class="nav-item dropdown {{ Request::routeIs('users.*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fa-solid fa-users"></i>
                        <span>Users</span>
                    </a>
                    <ul class="dropdown-menu">
                        @can('user-create')
                            <li class="{{ Request::routeIs('users.create') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('users.create') }}">Add User</a>
                            </li>
                        @endcan
                        <li class="{{ Request::routeIs('users.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('users.index') }}">User List</a>
                        </li>
                    </ul>
                </li>
            @endcanany

            {{-- Roles --}}
            @canany(['role-list', 'role-create', 'role-edit', 'role-delete'])
                <li class="nav-item dropdown {{ Request::routeIs('roles.*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fa-solid fa-user-shield"></i>
                        <span>Roles</span>
                    </a>
                    <ul class="dropdown-menu">
                        @can('role-create')
                            <li class="{{ Request::routeIs('roles.create') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('roles.create') }}">Add Role</a>
                            </li>
                        @endcan
                        <li class="{{ Request::routeIs('roles.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('roles.index') }}">Role List</a>
                        </li>
                    </ul>
                </li>
            @endcanany
            {{-- Orders --}}
            @canany(['order-list', 'order-view', 'order-status', 'order-delete'])
                <li class="nav-item dropdown {{ Request::routeIs('admin.orders.*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fa fa-shopping-cart"></i>
                        <span>Orders</span>
                    </a>
                    <ul class="dropdown-menu">
                        @can('order-list')
                            <li class="{{ Request::routeIs('admin.orders.index') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('admin.orders.index') }}">All Orders</a>
                            </li>
                        @endcan
                        @can('order-list')
                            <li class="{{ Request::routeIs('admin.orders.pending') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('admin.orders.pending') }}">Pending</a>
                            </li>
                        @endcan
                        @can('order-list')
                            <li class="{{ Request::routeIs('admin.orders.processing') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('admin.orders.processing') }}">Processing</a>
                            </li>
                        @endcan
                        @can('order-list')
                            <li class="{{ Request::routeIs('admin.orders.completed') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('admin.orders.completed') }}">Completed</a>
                            </li>
                        @endcan
                        @can('order-list')
                            <li class="{{ Request::routeIs('admin.orders.cancelled') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('admin.orders.cancelled') }}">Cancelled</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany


            {{-- Products --}}
            @canany(['product-list', 'product-create', 'product-edit', 'product-delete'])
                <li class="nav-item dropdown {{ Request::routeIs('products.*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fa-solid fa-box"></i>
                        <span>Products</span>
                    </a>
                    <ul class="dropdown-menu">
                        @can('product-create')
                            <li class="{{ Request::routeIs('products.create') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('products.create') }}">Add Product</a>
                            </li>
                        @endcan
                        <li class="{{ Request::routeIs('products.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('products.index') }}">Product List</a>
                        </li>
                    </ul>
                </li>
            @endcanany

            {{-- Categories --}}
            @canany(['category-list', 'category-create', 'category-edit', 'category-delete'])
                <li class="nav-item dropdown {{ Request::routeIs('categories.*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fa-solid fa-tags"></i>
                        <span>Categories</span>
                    </a>
                    <ul class="dropdown-menu">
                        @can('category-create')
                            <li class="{{ Request::routeIs('categories.create') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('categories.create') }}">Add Category</a>
                            </li>
                        @endcan
                        <li class="{{ Request::routeIs('categories.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('categories.index') }}">Category List</a>
                        </li>
                    </ul>
                </li>
            @endcanany

            {{-- Brands --}}
            @canany(['brand-list', 'brand-create', 'brand-edit', 'brand-delete'])
                <li class="nav-item dropdown {{ Request::routeIs('brands.*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fa-solid fa-copyright"></i>
                        <span>Brands</span>
                    </a>
                    <ul class="dropdown-menu">
                        @can('brand-create')
                            <li class="{{ Request::routeIs('brands.create') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('brands.create') }}">Add Brand</a>
                            </li>
                        @endcan
                        <li class="{{ Request::routeIs('brands.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('brands.index') }}">Brand List</a>
                        </li>
                    </ul>
                </li>
            @endcanany

            {{-- Blogs --}}
            @canany(['blog-list', 'blog-create', 'blog-edit', 'blog-delete'])
                <li class="nav-item dropdown {{ Request::routeIs('blog.*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fa-solid fa-blog"></i>
                        <span>Blogs</span>
                    </a>
                    <ul class="dropdown-menu">
                        @can('blog-create')
                            <li class="{{ Request::routeIs('blog.create') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('blog.create') }}">Add Blog</a>
                            </li>
                        @endcan
                        <li class="{{ Request::routeIs('blog.list') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('blog.list') }}">Blog List</a>
                        </li>
                    </ul>
                </li>
            @endcanany
            {{-- Contact Page & Contact Messages --}}
            @canany(['contact-page-list', 'contact-page-edit', 'contact-messages-list', 'contact-messages-view',
                'contact-messages-delete'])
                <li
                    class="nav-item dropdown {{ Request::routeIs('contact-page.*') || Request::routeIs('admin.contact.*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fas fa-envelope"></i>
                        <span>Contact</span>
                    </a>
                    <ul class="dropdown-menu">
                        {{-- Contact Page --}}
                        @canany(['contact-page-list', 'contact-page-edit'])
                            <li class="{{ Request::routeIs('contact-page.index') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('contact-page.index') }}">Manage Contact Page</a>
                            </li>
                        @endcanany

                        {{-- Contact Messages --}}
                        @can('contact-messages-list')
                            <li class="{{ Request::routeIs('admin.contact.index') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('admin.contact.index') }}">Contact Messages</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany

            <li class="menu-header">Home</li>
            {{-- Header Settings --}}
            @canany(['header-setting-list', 'header-settings-create', 'header-setting-edit', 'header-settings-delete'])
                <li class="nav-item dropdown {{ Request::routeIs('header-settings.*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fa-solid fa-header"></i>
                        <span>Header Settings</span>
                    </a>
                    <ul class="dropdown-menu">
                        @can('header-setting-create')
                            <li class="{{ Request::routeIs('header-settings.create') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('header-settings.create') }}">Add Header Item</a>
                            </li>
                        @endcan
                        <li class="{{ Request::routeIs('header-settings.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('header-settings.index') }}">Header List</a>
                        </li>
                    </ul>
                </li>
            @endcanany

            {{-- Sliders --}}
            @canany(['slider-list', 'slider-create', 'slider-edit', 'slider-delete'])
                <li class="nav-item dropdown {{ Request::routeIs('slider.*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fa-solid fa-images"></i>
                        <span>Sliders</span>
                    </a>
                    <ul class="dropdown-menu">
                        @can('slider-create')
                            <li class="{{ Request::routeIs('slider.create') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('slider.create') }}">Add Slider</a>
                            </li>
                        @endcan
                        <li class="{{ Request::routeIs('slider.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('slider.index') }}">Slider List</a>
                        </li>
                    </ul>
                </li>
            @endcanany
            <!-- Footer Settings -->
            @canany(['footer-list', 'footer-create', 'footer-edit', 'footer-delete'])
                <li class="nav-item dropdown {{ Request::routeIs('footer.*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fas fa-shoe-prints"></i>
                        <span>Footer Settings</span>
                    </a>
                    <ul class="dropdown-menu">
                        @can('footer-create')
                            <li class="{{ Request::routeIs('footer.create') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('footer.create') }}">Add Footer Item</a>
                            </li>
                        @endcan
                        <li class="{{ Request::routeIs('footer.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('footer.index') }}">Footer List</a>
                        </li>
                    </ul>
                </li>
            @endcanany
            <li class="menu-header">About</li>
            <!-- About Menu -->
            <ul class="sidebar-menu">
                @canany(['about-list'])
                    <li class="nav-item dropdown {{ Request::routeIs('about.*') ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown">
                            <i class="fas fa-info-circle"></i>
                            <span>About Settings</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="{{ Request::routeIs('about.index') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('about.index') }}">About List</a>
                            </li>
                        </ul>
                    </li>
                @endcanany

                @canany(['stats-list', 'stats-create', 'stats-edit', 'stats-delete'])
                    <li class="nav-item dropdown {{ Request::routeIs('stats.*') ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown">
                            <i class="fas fa-chart-bar"></i>
                            <span>Website Stats</span>
                        </a>
                        <ul class="dropdown-menu">
                            @can('stats-create')
                                <li class="{{ Request::routeIs('stats.create') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('stats.create') }}">Add Stat</a>
                                </li>
                            @endcan
                            <li class="{{ Request::routeIs('stats.index') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('stats.index') }}">Stats List</a>
                            </li>
                        </ul>
                    </li>
                @endcanany

                @canany(['team-members-list', 'team-members-create', 'team-members-edit', 'team-members-delete'])
                    <li class="nav-item dropdown {{ Request::routeIs('team-members.*') ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown">
                            <i class="fas fa-users"></i>
                            <span>Team Members</span>
                        </a>
                        <ul class="dropdown-menu">
                            @can('team-members-create')
                                <li class="{{ Request::routeIs('team-members.create') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('team-members.create') }}">Add Member</a>
                                </li>
                            @endcan
                            <li class="{{ Request::routeIs('team-members.index') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('team-members.index') }}">Team List</a>
                            </li>
                        </ul>
                    </li>
                @endcanany
            </ul>
            <div class="hide-sidebar-mini mt-4 mb-4 p-3">
                <a href="{{ route('logout') }}" class="btn btn-primary btn-lg btn-block btn-icon-split"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa-solid fa-right-from-bracket"></i> Sign Out
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
    </aside>
</div>
