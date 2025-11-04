<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">{{ config('app.name') }}</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item dropdown {{ Request::routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>

            {{-- Users Menu --}}
            @can('user-list')
                <li class="nav-item dropdown {{ Request::routeIs('users.*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i class="fa-solid fa-users"></i> <span>Users</span></a>
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
            @endcan

            {{-- Roles Menu --}}
            @can('role-list')
                <li class="nav-item dropdown {{ Request::routeIs('roles.*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i class="fa-solid fa-user-shield"></i>
                        <span>Roles</span></a>
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
            @endcan

            {{-- Products Menu --}}
            @can('product-list')
                <li class="nav-item dropdown {{ Request::routeIs('products.*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i class="fa-solid fa-box"></i>
                        <span>Products</span></a>
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
            @endcan

            <!-- Existing Blogs Menu -->
            @can('blog-list')
                <li class="nav-item dropdown {{ Request::routeIs('blog.*') ? 'active' : '' }}"> <a href="#"
                        class="nav-link has-dropdown"><i class="fa-solid fa-blog"></i><span>Blogs</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ Request::routeIs('blog.create') ? 'active' : '' }}"> <a class="nav-link"
                                href="{{ route('blog.create') }}">Add Blog</a> </li>
                        <li class="{{ Request::routeIs('blog.list') ? 'active' : '' }}"> <a class="nav-link"
                                href="{{ route('blog.list') }}">Blog List</a> </li>
                    </ul>
                </li>
            @endcan
            {{-- Settings Menu --}}
            @can('settings-list')
                <li class="nav-item dropdown {{ Request::routeIs('settings.*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fa-solid fa-gear"></i>
                        <span>Settings</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ Request::routeIs('settings.basic') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('settings.basic') }}">Basic Settings</a>
                        </li>
                        <li class="{{ Request::routeIs('settings.banner') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('settings.banner') }}">Banner Settings</a>
                        </li>
                        <li class="{{ Request::routeIs('settings.contactShow') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('settings.contactShow') }}">Contact Message</a>
                        </li>
                    </ul>
                </li>
            @endcan

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
