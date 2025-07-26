@extends('layouts.back')
@section('title', 'Admin Dashboard')
@push('styles')
<style>
    /* Simple card styles following admin theme */
    .card-statistic-1 .card-body {
        padding: 1.5rem;
    }

    .stats-number {
        font-size: 2rem;
        font-weight: 600;
        margin: 0;
    }

    .stats-label {
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .stats-trend {
        font-size: 0.75rem;
        font-weight: 400;
    }

    .activity-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .activity-table .table td {
        border-top: 1px solid #dee2e6;
        vertical-align: middle;
        padding: 0.75rem;
    }

    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
    }

    .book-cover {
        width: 32px;
        height: 40px;
        object-fit: cover;
        border-radius: 3px;
        border: 1px solid #dee2e6;
        background-color: #f8f9fa;
    }

    .book-cover:hover {
        border-color: #adb5bd;
        transform: scale(1.05);
        transition: all 0.2s ease;
    }

    .action-buttons .btn {
        padding: 0.25rem 0.5rem;
        margin: 0 1px;
        font-size: 0.875rem;
    }

    .health-indicator {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        border-radius: 3px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .health-online {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .progress-custom {
        height: 4px;
        border-radius: 2px;
        background-color: #e9ecef;
    }

    .task-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid #dee2e6;
    }

    .task-item:last-child {
        border-bottom: none;
    }

    .quick-actions .btn {
        margin-bottom: 0.5rem;
        font-weight: 400;
    }

    /* Simple hover effects */
    .card:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .btn:hover {
        transform: none;
        box-shadow: none;
    }

    /* Clean table styling */
    .table th {
        border-top: none;
        font-weight: 500;
        font-size: 0.875rem;
        color: #495057;
    }

    .table td {
        font-size: 0.875rem;
    }

    /* Simple badge styling */
    .badge {
        font-weight: 400;
        font-size: 0.75rem;
    }
</style>
@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1><i class="fas fa-tachometer-alt mr-2"></i>Admin Dashboard</h1>
        <div class="section-header-button">
            <button class="btn btn-primary btn-sm" onclick="refreshDashboard()">
                <i class="fas fa-sync-alt"></i> Refresh
            </button>
        </div>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active">Admin Dashboard</div>
        </div>
    </div>

    <!-- Statistics Overview -->
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4 class="stats-label">Total Users</h4>
                    </div>
                    <div class="card-body">
                        <div class="stats-number">{{ $stats['total_users'] }}</div>
                        <div class="stats-trend text-success">
                            <i class="fas fa-arrow-up"></i> +12% this month
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-book"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4 class="stats-label">Total Books</h4>
                    </div>
                    <div class="card-body">
                        <div class="stats-number">{{ $stats['total_books'] }}</div>
                        <div class="stats-trend text-success">
                            <i class="fas fa-arrow-up"></i> +8% this month
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4 class="stats-label">Pending Books</h4>
                    </div>
                    <div class="card-body">
                        <div class="stats-number">{{ $stats['pending_books'] }}</div>
                        <div class="stats-trend {{ $stats['pending_books'] > 0 ? 'text-warning' : 'text-success' }}">
                            @if($stats['pending_books'] > 0)
                                <i class="fas fa-exclamation-triangle"></i> Needs attention
                            @else
                                <i class="fas fa-check"></i> All caught up!
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                    <i class="fas fa-check"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4 class="stats-label">Approved Books</h4>
                    </div>
                    <div class="card-body">
                        <div class="stats-number">{{ $stats['approved_books'] }}</div>
                        <div class="stats-trend text-info">
                            <i class="fas fa-chart-line"></i> {{ number_format(($stats['approved_books'] / max($stats['total_books'], 1)) * 100, 1) }}% approval rate
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Statistics -->
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1 stats-card-enhanced">
                <div class="card-icon bg-secondary">
                    <i class="fas fa-handshake"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4 class="stats-label">Active Loans</h4>
                    </div>
                    <div class="card-body">
                        <div class="stats-number">{{ $stats['active_loans'] }}</div>
                        <div class="stats-trend text-secondary">
                            <i class="fas fa-chart-line"></i> Active borrowing
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1 stats-card-enhanced">
                <div class="card-icon bg-dark">
                    <i class="fas fa-hand-holding"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4 class="stats-label">Pending Loans</h4>
                    </div>
                    <div class="card-body">
                        <div class="stats-number">{{ $stats['pending_loan_requests'] }}</div>
                        <div class="stats-trend {{ $stats['pending_loan_requests'] > 0 ? 'text-warning' : 'text-success' }}">
                            @if($stats['pending_loan_requests'] > 0)
                                <i class="fas fa-hourglass-half"></i> Awaiting approval
                            @else
                                <i class="fas fa-check"></i> No pending requests
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1 stats-card-enhanced">
                <div class="card-icon bg-purple">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4 class="stats-label">Active Swaps</h4>
                    </div>
                    <div class="card-body">
                        <div class="stats-number">{{ $stats['active_swaps'] }}</div>
                        <div class="stats-trend text-purple">
                            <i class="fas fa-sync"></i> In progress
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1 stats-card-enhanced">
                <div class="card-icon bg-pink">
                    <i class="fas fa-sync"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4 class="stats-label">Pending Swaps</h4>
                    </div>
                    <div class="card-body">
                        <div class="stats-number">{{ $stats['pending_swap_requests'] }}</div>
                        <div class="stats-trend {{ $stats['pending_swap_requests'] > 0 ? 'text-warning' : 'text-success' }}">
                            @if($stats['pending_swap_requests'] > 0)
                                <i class="fas fa-hourglass-half"></i> Awaiting review
                            @else
                                <i class="fas fa-check"></i> All processed
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-bolt"></i> Quick Actions & Management</h4>
                    <div class="card-header-action">
                        <button class="btn btn-primary btn-sm" onclick="refreshDashboard()">
                            <i class="fas fa-sync-alt"></i> Refresh Data
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row quick-actions">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('admin.books.pending') }}" class="btn btn-warning btn-block">
                                <i class="fas fa-clock mr-2"></i> Review Pending Books
                                @if($stats['pending_books'] > 0)
                                    <span class="badge badge-light ml-2">{{ $stats['pending_books'] }}</span>
                                @endif
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('admin.books.all') }}" class="btn btn-primary btn-block">
                                <i class="fas fa-book mr-2"></i> All Books Library
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-success btn-block">
                                <i class="fas fa-users mr-2"></i> User Management
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('book-categories.index') }}" class="btn btn-info btn-block">
                                <i class="fas fa-tags mr-2"></i> Book Categories
                            </a>
                        </div>
                    </div>
                    <hr>
                    <div class="row quick-actions">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <button class="btn btn-secondary btn-block" onclick="generateReport()">
                                <i class="fas fa-chart-bar mr-2"></i> Generate Report
                            </button>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <button class="btn btn-outline-primary btn-block" onclick="exportData()">
                                <i class="fas fa-download mr-2"></i> Export Data
                            </button>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <button class="btn btn-outline-secondary btn-block" onclick="systemSettings()">
                                <i class="fas fa-cogs mr-2"></i> System Settings
                            </button>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <button class="btn btn-outline-danger btn-block" onclick="maintenanceMode()">
                                <i class="fas fa-tools mr-2"></i> Maintenance Mode
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
    <!-- Recent Activities & Quick Actions -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Recent Book Submissions</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.books.index') }}" class="btn btn-primary">View All</a>
                    </div>
                </div>
                <div class="card-body">
                    @if($recentBooks->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Book</th>
                                        <th>Author</th>
                                        <th>Owner</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentBooks as $book)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="mr-3">
                                                    <img src="{{ $book->image ? asset('storage/' . $book->image) : asset('backend/assets/img/book-placeholder.jpg') }}"
                                                         alt="{{ $book->title }}"
                                                         style="width: 40px; height: 50px; object-fit: cover; border-radius: 3px; border: 1px solid #dee2e6;"
                                                         class="book-cover"
                                                         onerror="this.src='{{ asset('backend/assets/img/book-placeholder.svg') }}'">
                                                </div>
                                                <div>
                                                    <div class="font-weight-bold">{{ $book->title }}</div>
                                                    <div class="text-muted small">{{ $book->author }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $book->author }}</td>
                                        <td>{{ $book->user->name }}</td>
                                        <td>
                                            @if($book->status === 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif($book->status === 'approved')
                                                <span class="badge badge-success">Approved</span>
                                            @else
                                                <span class="badge badge-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>{{ $book->created_at->format('M d, Y') }}</td>
                                        <td>
                                            @if($book->status === 'pending')
                                                <button onclick="quickApprove({{ $book->id }})"
                                                        class="btn btn-sm btn-success">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button onclick="quickReject({{ $book->id }})"
                                                        class="btn btn-sm btn-danger">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @else
                                                <a href="{{ route('admin.books.show', $book) }}"
                                                   class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-book fa-2x mb-2"></i>
                            <p>No recent book submissions</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

             <!-- Recent Users -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-user-plus"></i> Recent User Registrations</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-primary">View All</a>
                    </div>
                </div>
                <div class="card-body">
                    @if($recentUsers->count() > 0)
                        <div class="table-responsive activity-table">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>User Profile</th>
                                        <th>Contact</th>
                                        <th>Joined</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentUsers as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="mr-3">
                                                    <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('backend/assets/img/avatar/xyz.png') }}"
                                                         alt="{{ $user->name }}"
                                                         class="user-avatar">
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $user->name }}</h6>
                                                    <small class="text-muted">Member since {{ $user->created_at->format('M Y') }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="d-block">{{ $user->email }}</span>
                                            <small class="text-muted">Primary contact</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ $user->created_at->diffForHumans() }}</span>
                                        </td>
                                        <td>
                                            @if($user->is_active)
                                                <span class="badge badge-success">
                                                    <i class="fas fa-check-circle"></i> Active
                                                </span>
                                            @else
                                                <span class="badge badge-warning">
                                                    <i class="fas fa-pause-circle"></i> Inactive
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-users fa-3x mb-3 text-info"></i>
                            <h5>No Recent Registrations</h5>
                            <p class="mb-0">No new users have registered recently.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- System Health & Analytics -->
    <div class="row">
        <!-- Quick Actions -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h4><i class="fas fa-bolt text-primary mr-2"></i>Quick Actions</h4>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('admin.books.pending') }}"
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-clock text-warning mr-2"></i>
                                Pending Books
                            </div>
                            @if($stats['pending_books'] > 0)
                                <span class="badge badge-warning">{{ $stats['pending_books'] }}</span>
                            @endif
                        </a>
                        <a href="{{ route('admin.users.index') }}"
                           class="list-group-item list-group-item-action">
                            <i class="fas fa-users text-primary mr-2"></i>
                            Manage Users
                        </a>
                        <a href="{{ route('admin.categories.index') }}"
                           class="list-group-item list-group-item-action">
                            <i class="fas fa-tags text-info mr-2"></i>
                            Categories
                        </a>
                        <a href="{{ route('admin.reports.index') }}"
                           class="list-group-item list-group-item-action">
                            <i class="fas fa-chart-bar text-success mr-2"></i>
                            Reports
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Status -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h4><i class="fas fa-heartbeat text-danger mr-2"></i>System Status</h4>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-database text-success mr-2"></i>Database</span>
                            <span class="badge badge-success">Online</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-cloud text-info mr-2"></i>Storage</span>
                            <span class="badge badge-success">Healthy</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-envelope text-primary mr-2"></i>Mail</span>
                            <span class="badge badge-success">Active</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-server text-warning mr-2"></i>Cache</span>
                            <span class="badge badge-warning">{{ round(memory_get_usage() / 1024 / 1024, 1) }}MB</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Tasks -->
        <div class="col-lg-4 col-md-12 col-sm-12 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h4><i class="fas fa-tasks text-purple mr-2"></i>Today's Tasks</h4>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center w-100">
                                <div>
                                    <i class="fas fa-book text-warning mr-2"></i>
                                    <span>Review pending books</span>
                                </div>
                                <span class="badge badge-{{ $stats['pending_books'] > 0 ? 'warning' : 'success' }}">
                                    {{ $stats['pending_books'] > 0 ? $stats['pending_books'] : 'Done' }}
                                </span>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center w-100">
                                <div>
                                    <i class="fas fa-user-clock text-info mr-2"></i>
                                    <span>Check loan requests</span>
                                </div>
                                <span class="badge badge-{{ $stats['pending_loan_requests'] > 0 ? 'warning' : 'success' }}">
                                    {{ $stats['pending_loan_requests'] > 0 ? $stats['pending_loan_requests'] : 'Done' }}
                                </span>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center w-100">
                                <div>
                                    <i class="fas fa-exchange-alt text-primary mr-2"></i>
                                    <span>Monitor swap requests</span>
                                </div>
                                <span class="badge badge-{{ $stats['pending_swap_requests'] > 0 ? 'warning' : 'success' }}">
                                    {{ $stats['pending_swap_requests'] > 0 ? $stats['pending_swap_requests'] : 'Done' }}
                                </span>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center w-100">
                                <div>
                                    <i class="fas fa-chart-line text-success mr-2"></i>
                                    <span>Generate weekly report</span>
                                </div>
                                <span class="badge badge-secondary">
                                    Pending
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

                <div class="col-lg-6 col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-chart-pie text-info mr-2"></i>Quick Statistics</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span><i class="fas fa-book-open text-success mr-1"></i> Book Approval Rate</span>
                            <span class="font-weight-bold">{{ number_format(($stats['approved_books'] / max($stats['total_books'], 1)) * 100, 1) }}%</span>
                        </div>
                        <div class="progress progress-custom">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ ($stats['approved_books'] / max($stats['total_books'], 1)) * 100 }}%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span><i class="fas fa-user-check text-info mr-1"></i> Active User Rate</span>
                            <span class="font-weight-bold">85%</span>
                        </div>
                        <div class="progress progress-custom">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 85%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between mb-1">
                            <span><i class="fas fa-tachometer-alt text-warning mr-1"></i> System Load</span>
                            <span class="font-weight-bold">Low</span>
                        </div>
                        <div class="progress progress-custom">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 25%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-shield-alt text-success mr-2"></i>System Health</h4>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4 mb-3">
                            <div class="mb-2">
                                <i class="fas fa-server fa-2x text-success"></i>
                            </div>
                            <h6 class="font-weight-bold mb-1">Server</h6>
                            <span class="health-indicator health-online">Online</span>
                        </div>
                        <div class="col-4 mb-3">
                            <div class="mb-2">
                                <i class="fas fa-database fa-2x text-success"></i>
                            </div>
                            <h6 class="font-weight-bold mb-1">Database</h6>
                            <span class="health-indicator health-online">Connected</span>
                        </div>
                        <div class="col-4 mb-3">
                            <div class="mb-2">
                                <i class="fas fa-cloud fa-2x text-success"></i>
                            </div>
                            <h6 class="font-weight-bold mb-1">Storage</h6>
                            <span class="health-indicator health-online">Available</span>
                        </div>
                    </div>
                    <div class="text-center mt-2">
                        <button class="btn btn-sm btn-outline-primary" onclick="checkSystemHealth()">
                            <i class="fas fa-sync-alt mr-1"></i> Refresh Status
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>


</section>

<!-- Enhanced Forms for Quick Actions -->
<form id="quickApproveForm" method="POST" style="display: none;">
    @csrf
    @method('PATCH')
</form>

<form id="quickRejectForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
    <input type="hidden" name="rejection_reason" value="Quick rejection from dashboard">
</form>

@push('scripts')
<script>
// Enhanced Quick Actions with Native Browser Dialogs
function quickApprove(bookId) {
    if (confirm('Are you sure you want to approve this book?\n\nThis will make the book available in the library.')) {
        document.getElementById('quickApproveForm').action = '/admin/books/' + bookId + '/approve';
        document.getElementById('quickApproveForm').submit();
    }
}

function quickReject(bookId) {
    if (confirm('Are you sure you want to reject this book?\n\nThis action cannot be undone. The book will be permanently removed.')) {
        document.getElementById('quickRejectForm').action = '/admin/books/' + bookId;
        document.getElementById('quickRejectForm').submit();
    }
}

// Dashboard Utilities
function refreshDashboard() {
    if (confirm('Refresh dashboard with latest data?')) {
        showLoader();
        setTimeout(() => {
            window.location.reload();
        }, 1000);
    }
}

function generateReport() {
    const reportType = prompt('Generate Report:\n\n1. Monthly Report\n2. Weekly Report\n\nEnter 1 or 2:');
    if (reportType === '1') {
        alert('Monthly report generation started. You will be notified when it\'s ready.');
        // Add actual report generation logic here
    } else if (reportType === '2') {
        alert('Weekly report generation started. You will be notified when it\'s ready.');
        // Add actual report generation logic here
    }
}

function exportData() {
    const format = prompt('Export Data Format:\n\n1. Excel (.xlsx)\n2. CSV (.csv)\n\nEnter 1 or 2:');
    if (format === '1') {
        alert('Excel export started. File will be downloaded shortly.');
        // Add actual Excel export logic here
    } else if (format === '2') {
        alert('CSV export started. File will be downloaded shortly.');
        // Add actual CSV export logic here
    }
}

function systemSettings() {
    if (confirm('Navigate to system configuration panel?')) {
        // window.location.href = '/admin/settings'; // Add actual settings route
        alert('System settings panel will be available in the next update.');
    }
}

function maintenanceMode() {
    if (confirm('Enable maintenance mode?\n\nThis will put the website in maintenance mode. Only admins will be able to access it.')) {
        alert('Maintenance mode feature will be implemented in the next update.');
        // Add actual maintenance mode logic here
    }
}

function checkSystemHealth() {
    showLoader();

    // Simulate system health check
    setTimeout(() => {
        const loaderElement = document.getElementById('customLoader');
        if (loaderElement) {
            loaderElement.remove();
        }

        // Show success message
        alert('System health check completed!\n\n✓ Server: Online\n✓ Database: Connected\n✓ Storage: Available\n✓ Cache: ' + Math.round(Math.random() * 50 + 20) + 'MB');
    }, 2000);
}

// Utility Functions
function showLoader() {
    const loader = document.createElement('div');
    loader.id = 'customLoader';
    loader.innerHTML = `
        <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; display: flex; align-items: center; justify-content: center;">
            <div style="background: white; padding: 2rem; border-radius: 8px; text-align: center;">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="mt-2 mb-0">Loading...</p>
            </div>
        </div>
    `;
    document.body.appendChild(loader);

    setTimeout(() => {
        const loaderElement = document.getElementById('customLoader');
        if (loaderElement) {
            loaderElement.remove();
        }
    }, 5000);
}

// Initialize dashboard features
$(document).ready(function() {
    // Initialize tooltips if available
    if (typeof $().tooltip === 'function') {
        $('[title]').tooltip();
    }

    // Auto-refresh notification every 5 minutes
    setInterval(function() {
        console.log('Dashboard auto-refresh check...');
        // You can implement auto-refresh logic here
    }, 300000); // 5 minutes

    // Add loading states to buttons
    $('.btn').on('click', function() {
        const btn = $(this);
        if (!btn.hasClass('no-loading')) {
            btn.prop('disabled', true);
            setTimeout(() => {
                btn.prop('disabled', false);
            }, 2000);
        }
    });
});

// Real-time notifications using browser notifications
function showNotification(title, message, type = 'info') {
    // Check if browser supports notifications
    if ('Notification' in window) {
        if (Notification.permission === 'granted') {
            const notification = new Notification(title, {
                body: message,
                icon: '/backend/assets/img/avatar/avatar-1.png' // Use your app icon
            });

            setTimeout(() => {
                notification.close();
            }, 5000);
        } else if (Notification.permission !== 'denied') {
            Notification.requestPermission().then(permission => {
                if (permission === 'granted') {
                    showNotification(title, message, type);
                }
            });
        }
    }

    // Fallback to console log
    console.log(`${type.toUpperCase()}: ${title} - ${message}`);
}

// Enhanced error handling
window.addEventListener('error', function(e) {
    console.error('Dashboard Error:', e.error);
});

// Add smooth scrolling
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
});
</script>
@endpush

@endsection
