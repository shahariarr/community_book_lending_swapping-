@extends('layouts.back')
@section('title', 'Manage Users')
@section('content')

<section class="section">
    <div class="section-header">
        <h1>Manage Users</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></div>
            <div class="breadcrumb-item active">Manage Users</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>All Users</h4>
                <div class="card-header-action">
                    <span class="badge badge-primary">{{ $users->total() }} Total Users</span>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Books</th>
                                <th>Loan Requests</th>
                                <th>Swap Requests</th>
                                <th>Status</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('backend/assets/img/avatar/avatar-1.png') }}"
                                                 alt="Avatar" class="rounded-circle mr-2" style="width: 40px; height: 40px;">
                                            <div>
                                                <strong>{{ $user->name }}</strong>
                                                @if($user->id === auth()->id())
                                                    <span class="badge badge-info ml-1">You</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @foreach($user->roles as $role)
                                            <span class="badge badge-{{ $role->name === 'Super Admin' ? 'danger' : ($role->name === 'Admin' ? 'warning' : 'secondary') }}">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                        @if($user->roles->isEmpty())
                                            <span class="badge badge-light">No Role</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-primary">{{ $user->books_count }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ $user->loan_requests_as_borrower_count }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-success">{{ $user->swap_requests_as_requester_count }}</span>
                                    </td>
                                    <td>
                                        @if($user->is_active ?? true)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $user->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('users.show', $user) }}">
                                                    <i class="fas fa-eye"></i> View Details
                                                </a>
                                                @if($user->id !== auth()->id() && !$user->hasRole('Super Admin'))
                                                    @can('edit-user')
                                                        <a class="dropdown-item" href="{{ route('users.edit', $user) }}">
                                                            <i class="fas fa-edit"></i> Edit User
                                                        </a>
                                                    @endcan
                                                    @if(!$user->hasRole('Admin'))
                                                        <div class="dropdown-divider"></div>
                                                        <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="dropdown-item text-{{ ($user->is_active ?? true) ? 'warning' : 'success' }}"
                                                                    onclick="return confirm('Are you sure you want to {{ ($user->is_active ?? true) ? 'deactivate' : 'activate' }} this user?')">
                                                                <i class="fas fa-{{ ($user->is_active ?? true) ? 'ban' : 'check' }}"></i>
                                                                {{ ($user->is_active ?? true) ? 'Deactivate' : 'Activate' }}
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <div class="empty-state" data-height="400">
                                            <div class="empty-state-icon">
                                                <i class="fas fa-users"></i>
                                            </div>
                                            <h2>No Users Found</h2>
                                            <p class="lead">No users are registered in the system yet.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($users->hasPages())
                    <div class="card-footer">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Users Statistics -->
        <div class="row mt-4">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Users</h4>
                        </div>
                        <div class="card-body">
                            {{ $users->total() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Admin Users</h4>
                        </div>
                        <div class="card-body">
                            {{ $users->filter(function($user) { return $user->hasRole('Admin') || $user->hasRole('Super Admin'); })->count() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Active Book Owners</h4>
                        </div>
                        <div class="card-body">
                            {{ $users->filter(function($user) { return $user->books_count > 0; })->count() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Active Borrowers</h4>
                        </div>
                        <div class="card-body">
                            {{ $users->filter(function($user) { return $user->loan_requests_as_borrower_count > 0; })->count() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
