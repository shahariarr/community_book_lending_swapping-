@php
    $user = Auth::user();
@endphp
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">
                {{-- <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('backend/assets/img/avatar/xyz.png') }}"
                    alt="Profile Image" style="width: 30px; height: 30px; border-radius: 50%;"> --}}
                <span class="logo">Hi, {{ Auth::user()->name }}</span>
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard') }}">
                <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('backend/assets/img/avatar/xyz.png') }}"
                    alt="Profile Image" style="width: 30px; height: 30px; border-radius: 50%;">
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="dropdown {{ Route::is('dashboard') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Route::is('dashboard') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('dashboard') }}">Dashboard</a></li>
                </ul>
            </li>






            @canany(['index-user', 'index-role', 'index-permission'])
                <li class="menu-header">User Management</li>
                <li
                    class="dropdown {{ Route::is('users.*') || Route::is('roles.*') || Route::is('permissions.*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-user"></i>
                        <span>User</span></a>
                    <ul class="dropdown-menu">
                        @can('index-user')
                            <li class="{{ Route::is('users.*') ? 'active' : '' }}"><a class="nav-link"
                                    href="{{ route('users.index') }}">Users List</a></li>
                        @endcan
                        @can('index-role')
                            <li class="{{ Route::is('roles.*') ? 'active' : '' }}"><a class="nav-link"
                                    href="{{ route('roles.index') }}">Roles List</a></li>
                        @endcan
                        @can('index-permission')
                            <li class="{{ Route::is('permissions.*') ? 'active' : '' }}"><a class="nav-link"
                                    href="{{ route('permissions.index') }}">Permissions List</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany

            <li class="menu-header">Book Management</li>
            <li class="dropdown {{ Route::is('book-categories.*') || Route::is('books.*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-book"></i>
                    <span>Books</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Route::is('book-categories.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('book-categories.index') }}">
                            <i class="fas fa-tags"></i> Categories
                        </a>
                    </li>
                    <li class="{{ Route::is('books.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('books.index') }}">
                            <i class="fas fa-book-open"></i> All Books
                        </a>
                    </li>
                </ul>
            </li>
        </ul>

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <div class="text-center small text-muted">
                <div>© 2023 ProfileCrafting.com</div>
            </div>
        </div>
    </aside>
</div>
