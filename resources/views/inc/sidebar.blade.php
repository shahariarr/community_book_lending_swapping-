@php
    $user = Auth::user();
    $isAdmin = $user->hasRole('Admin');

    // Simple notification counts
    $myPendingRequests = \App\Models\LoanRequest::where('lender_id', Auth::id())->where('status', 'pending')->count() +
                        \App\Models\SwapRequest::where('owner_id', Auth::id())->where('status', 'pending')->count();
    $myPendingBooks = \App\Models\Book::where('user_id', Auth::id())->where('is_approved', false)->count();
    $adminPendingTotal = $isAdmin ? \App\Models\Book::where('is_approved', false)->count() : 0;
@endphp
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <!-- Brand -->
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">BookHub</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard') }}">BH</a>
        </div>

        <ul class="sidebar-menu">
            <!-- Dashboard Section -->
            <li class="menu-header">Dashboard</li>
            <li class="dropdown {{ Route::is('dashboard') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Route::is('dashboard') ? 'active' : '' }}"><a class="nav-link" href="{{ route('dashboard') }}">General Dashboard</a></li>
                </ul>
            </li>

            <!-- Books Section -->
            <li class="menu-header">Books Management</li>
            <li class="dropdown {{ Route::is('books.*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-book"></i> <span>Books</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Route::is('books.index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('books.index') }}">Browse Books</a></li>
                    <li class="{{ Route::is('books.my-books') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('books.my-books') }}">
                            My Books
                            @if($myPendingBooks > 0)
                                <span class="float-right badge badge-danger badge-pill" style="border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 10px; line-height: 1; margin-left: auto;">{{ $myPendingBooks }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="{{ Route::is('books.create') ? 'active' : '' }}"><a class="nav-link" href="{{ route('books.create') }}">Add New Book</a></li>
                </ul>
            </li>

            <!-- Categories -->
            @can('index-book-categorie')
                <li class="{{ Route::is('book-categories.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('book-categories.index') }}">
                        <i class="fas fa-tags"></i> <span>Categories</span>
                    </a>
                </li>
            @endcan

            <!-- Requests Section -->
            <li class="menu-header">Activity Management</li>
            <li class="dropdown {{ Route::is('loan-requests.*') || Route::is('swap-requests.*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-handshake"></i> <span>Requests</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Route::is('loan-requests.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('loan-requests.index') }}">
                            Loan Requests
                            @if($myPendingRequests > 0)
                                <span class="float-right badge badge-danger badge-pill" style="border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 10px; line-height: 1; margin-left: auto;">{{ $myPendingRequests }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="{{ Route::is('swap-requests.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('swap-requests.index') }}">Swap Requests</a></li>
                </ul>
            </li>

            <!-- User Profile -->
            <li class="{{ Route::is('users.profile') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('users.profile') }}">
                    <i class="far fa-user"></i> <span>My Profile</span>
                </a>
            </li>

            <!-- Admin Section -->
            @if($isAdmin)
                <li class="menu-header">Admin Panel</li>
                <li class="dropdown {{ Route::is('admin.*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-cog"></i> <span>Administration</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ Route::is('admin.dashboard') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                        <li class="{{ Route::is('admin.books.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.books.pending') }}">
                                Pending Books
                                @if($adminPendingTotal > 0)
                                    <span class="float-right badge badge-danger badge-pill" style="border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 10px; line-height: 1; margin-left: auto;">{{ $adminPendingTotal }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="{{ Route::is('admin.users.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.users.index') }}">Manage Users</a></li>
                    </ul>
                </li>
            @endif

            <!-- User Management -->
            @canany(['index-user', 'index-role', 'index-permission'])
                <li class="menu-header">System Management</li>
                <li class="dropdown {{ Route::is('users.*') || Route::is('roles.*') || Route::is('permissions.*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-users-cog"></i> <span>User Management</span></a>
                    <ul class="dropdown-menu">
                        @can('index-user')
                            <li class="{{ Route::is('users.*') && !Route::is('users.profile') ? 'active' : '' }}"><a class="nav-link" href="{{ route('users.index') }}">Users</a></li>
                        @endcan
                        @can('index-role')
                            <li class="{{ Route::is('roles.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('roles.index') }}">Roles</a></li>
                        @endcan
                        @can('index-permission')
                            <li class="{{ Route::is('permissions.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('permissions.index') }}">Permissions</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany
        </ul>

        <!-- Documentation Button -->
        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="#" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> BookHub Guide
            </a>
        </div>
    </aside>
</div>
