@extends('layouts.back')
@section('title', 'Dashboard')
@section('content')

<section class="section">
    <div class="section-header">
      <h1>Community Book Lending & Swapping Dashboard</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      </div>
    </div>

    <!-- User Information Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="mr-3">
                            <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('backend/assets/img/avatar/xyz.png') }}"
                                 alt="Profile Image"
                                 style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;">
                        </div>
                        <div>
                            <h4 class="mb-1">Welcome back, {{ $user->name }}!</h4>
                            <p class="text-muted mb-2"><strong>Email:</strong> {{ $user->email }}</p>
                            <p class="text-muted mb-0">
                                <strong>Role:</strong>
                                @if($user->roles->isNotEmpty())
                                    @foreach($user->roles as $role)
                                        <span class="badge badge-primary">{{ $role->name }}</span>
                                    @endforeach
                                @else
                                    <span class="badge badge-secondary">No Role Assigned</span>
                                @endif
                            </p>
                        </div>
                        <div class="ml-auto">
                            <a href="{{ route('books.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Upload Book
                            </a>
                            <a href="{{ route('books.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-book"></i> Browse Books
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-primary">
                <i class="fas fa-book"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>My Books</h4>
                </div>
                <div class="card-body">
                  {{ $stats['my_books'] }}
                </div>
              </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-success">
                <i class="fas fa-check"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Approved Books</h4>
                </div>
                <div class="card-body">
                  {{ $stats['my_approved_books'] }}
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
                  <h4>Pending Approval</h4>
                </div>
                <div class="card-body">
                  {{ $stats['my_pending_books'] }}
                </div>
              </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-info">
                <i class="fas fa-search"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Available to Browse</h4>
                </div>
                <div class="card-body">
                  {{ $stats['available_books'] }}
                </div>
              </div>
            </div>
        </div>
    </div>

    <!-- Request Stats -->
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-secondary">
                <i class="fas fa-hand-holding"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>My Loan Requests</h4>
                </div>
                <div class="card-body">
                  {{ $stats['my_loan_requests'] }}
                </div>
              </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-dark">
                <i class="fas fa-inbox"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Loan Requests for My Books</h4>
                </div>
                <div class="card-body">
                  {{ $stats['loan_requests_for_my_books'] }}
                </div>
              </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-purple">
                <i class="fas fa-exchange-alt"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>My Swap Requests</h4>
                </div>
                <div class="card-body">
                  {{ $stats['my_swap_requests'] }}
                </div>
              </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-pink">
                <i class="fas fa-sync"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Swap Requests for My Books</h4>
                </div>
                <div class="card-body">
                  {{ $stats['swap_requests_for_my_books'] }}
                </div>
              </div>
            </div>
        </div>
    </div>

    @if($isAdmin)
    <!-- Admin Statistics -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-primary text-white border-0">
                    <h4 class="mb-0"><i class="fas fa-user-shield mr-2"></i> Admin Overview</h4>
                </div>
                <div class="card-body p-4">
                    <!-- First Row - Primary Stats -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
                            <div class="card card-statistic-2 border-0 shadow-sm h-100">
                                <div class="card-stats">
                                    <div class="card-stats-title text-muted small">Total Users</div>
                                    <div class="card-stats-items">
                                        <div class="card-stats-item">
                                            <div class="card-stats-item-count text-primary font-weight-bold h4">
                                                {{ number_format($stats['total_users']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-icon shadow-primary bg-primary">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
                            <div class="card card-statistic-2 border-0 shadow-sm h-100">
                                <div class="card-stats">
                                    <div class="card-stats-title text-muted small">Total Books</div>
                                    <div class="card-stats-items">
                                        <div class="card-stats-item">
                                            <div class="card-stats-item-count text-primary font-weight-bold h4">
                                                {{ number_format($stats['total_books']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-icon shadow-primary bg-primary">
                                    <i class="fas fa-book"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
                            <div class="card card-statistic-2 border-0 shadow-sm h-100">
                                <div class="card-stats">
                                    <div class="card-stats-title text-muted small">Pending Approvals</div>
                                    <div class="card-stats-items">
                                        <div class="card-stats-item">
                                            <div class="card-stats-item-count text-warning font-weight-bold h4">
                                                {{ number_format($stats['pending_book_approvals']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-icon shadow-warning bg-warning">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
                            <div class="card card-statistic-2 border-0 shadow-sm h-100">
                                <div class="card-stats">
                                    <div class="card-stats-title text-muted small">Categories</div>
                                    <div class="card-stats-items">
                                        <div class="card-stats-item">
                                            <div class="card-stats-item-count text-secondary font-weight-bold h4">
                                                {{ number_format($stats['active_categories']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-icon shadow-secondary bg-secondary">
                                    <i class="fas fa-tags"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Second Row - Request Stats -->
                    <div class="row mb-4">
                        <div class="col-xl-6 col-lg-6 col-md-6 mb-3">
                            <div class="card card-statistic-2 border-0 shadow-sm h-100">
                                <div class="card-stats">
                                    <div class="card-stats-title text-muted small">Total Loan Requests</div>
                                    <div class="card-stats-items">
                                        <div class="card-stats-item">
                                            <div class="card-stats-item-count text-success font-weight-bold h4">
                                                {{ number_format($stats['total_loan_requests']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-icon shadow-success bg-success">
                                    <i class="fas fa-handshake"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 mb-3">
                            <div class="card card-statistic-2 border-0 shadow-sm h-100">
                                <div class="card-stats">
                                    <div class="card-stats-title text-muted small">Total Swap Requests</div>
                                    <div class="card-stats-items">
                                        <div class="card-stats-item">
                                            <div class="card-stats-item-count text-info font-weight-bold h4">
                                                {{ number_format($stats['total_swap_requests']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-icon shadow-info bg-info">
                                    <i class="fas fa-exchange-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Admin Actions -->
                    <div class="text-center pt-3 border-top">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-tachometer-alt mr-2"></i> Go to Admin Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Category Analytics for All Users -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-chart-pie mr-2"></i> Book Categories Overview</h4>
                    <div class="card-header-action">
                        <a href="{{ route('books.index') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-search"></i> Browse Books
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($isAdmin && isset($stats['category_stats']) && $stats['category_stats']->count() > 0)
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    <strong>Top Category:</strong> 
                                    @if($stats['top_category'])
                                        "{{ $stats['top_category']->name }}" has the most books ({{ $stats['top_category']->books_count }} books)
                                    @else
                                        No categories with books yet
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @foreach($stats['category_stats']->take(6) as $category)
                            <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                                <div class="card border-left-primary h-100">
                                    <div class="card-body text-center p-3">
                                        @if($category->image)
                                            <img src="{{ asset('storage/category-images/' . $category->image) }}" 
                                                 alt="{{ $category->name }}" 
                                                 class="rounded-circle mb-2" 
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center"
                                                 style="width: 40px; height: 40px; background-color: {{ $category->color ?? '#6777ef' }};">
                                                <i class="fas fa-tag text-white"></i>
                                            </div>
                                        @endif
                                        <h6 class="font-weight-bold text-truncate">{{ $category->name }}</h6>
                                        <h4 class="text-primary mb-0">{{ $category->books_count }}</h4>
                                        <small class="text-muted">books</small>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="row">
                            @php
                                $allCategories = \App\Models\BookCategory::where('is_active', true)
                                    ->withCount(['books' => function($query) {
                                        $query->where('is_approved', true);
                                    }])
                                    ->orderBy('books_count', 'desc')
                                    ->take(6)
                                    ->get();
                            @endphp
                            @foreach($allCategories as $category)
                            <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                                <div class="card border-left-primary h-100">
                                    <div class="card-body text-center p-3">
                                        @if($category->image)
                                            <img src="{{ asset('storage/category-images/' . $category->image) }}" 
                                                 alt="{{ $category->name }}" 
                                                 class="rounded-circle mb-2" 
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center"
                                                 style="width: 40px; height: 40px; background-color: {{ $category->color ?? '#6777ef' }};">
                                                <i class="fas fa-tag text-white"></i>
                                            </div>
                                        @endif
                                        <h6 class="font-weight-bold text-truncate">{{ $category->name }}</h6>
                                        <h4 class="text-primary mb-0">{{ $category->books_count }}</h4>
                                        <small class="text-muted">books</small>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($isAdmin)
    <!-- Advanced Admin Analytics -->
    <div class="row">
        <!-- User Activity Insights -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-users-cog mr-2"></i> User Activity Insights</h4>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <i class="fas fa-clock text-success mr-2"></i>
                                <span>Active Users (30 days)</span>
                            </div>
                            <span class="badge badge-success badge-pill">{{ $stats['user_activity_stats']['active_users_last_30_days'] ?? 0 }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <i class="fas fa-book text-primary mr-2"></i>
                                <span>Users with Books</span>
                            </div>
                            <span class="badge badge-primary badge-pill">{{ $stats['user_activity_stats']['users_with_books'] ?? 0 }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <i class="fas fa-hand-holding text-info mr-2"></i>
                                <span>Users with Loan Requests</span>
                            </div>
                            <span class="badge badge-info badge-pill">{{ $stats['user_activity_stats']['users_with_loan_requests'] ?? 0 }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 border-bottom-0">
                            <div>
                                <i class="fas fa-exchange-alt text-warning mr-2"></i>
                                <span>Users with Swap Requests</span>
                            </div>
                            <span class="badge badge-warning badge-pill">{{ $stats['user_activity_stats']['users_with_swap_requests'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loan Request Analytics -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-handshake mr-2"></i> Loan Request Analytics</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Pending</span>
                            <span class="font-weight-bold text-warning">{{ $stats['loan_request_stats']['pending_loan_requests'] ?? 0 }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-warning" style="width: {{ ($stats['total_loan_requests'] ?? 0) > 0 ? (($stats['loan_request_stats']['pending_loan_requests'] ?? 0) / $stats['total_loan_requests']) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Approved</span>
                            <span class="font-weight-bold text-success">{{ $stats['loan_request_stats']['approved_loan_requests'] ?? 0 }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: {{ ($stats['total_loan_requests'] ?? 0) > 0 ? (($stats['loan_request_stats']['approved_loan_requests'] ?? 0) / $stats['total_loan_requests']) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Completed</span>
                            <span class="font-weight-bold text-info">{{ $stats['loan_request_stats']['completed_loan_requests'] ?? 0 }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-info" style="width: {{ ($stats['total_loan_requests'] ?? 0) > 0 ? (($stats['loan_request_stats']['completed_loan_requests'] ?? 0) / $stats['total_loan_requests']) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div class="mb-0">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Rejected</span>
                            <span class="font-weight-bold text-danger">{{ $stats['loan_request_stats']['rejected_loan_requests'] ?? 0 }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-danger" style="width: {{ ($stats['total_loan_requests'] ?? 0) > 0 ? (($stats['loan_request_stats']['rejected_loan_requests'] ?? 0) / $stats['total_loan_requests']) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Swap Request Analytics -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-sync-alt mr-2"></i> Swap Request Analytics</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Pending</span>
                            <span class="font-weight-bold text-warning">{{ $stats['swap_request_stats']['pending_swap_requests'] ?? 0 }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-warning" style="width: {{ ($stats['total_swap_requests'] ?? 0) > 0 ? (($stats['swap_request_stats']['pending_swap_requests'] ?? 0) / $stats['total_swap_requests']) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Approved</span>
                            <span class="font-weight-bold text-success">{{ $stats['swap_request_stats']['approved_swap_requests'] ?? 0 }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: {{ ($stats['total_swap_requests'] ?? 0) > 0 ? (($stats['swap_request_stats']['approved_swap_requests'] ?? 0) / $stats['total_swap_requests']) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Completed</span>
                            <span class="font-weight-bold text-info">{{ $stats['swap_request_stats']['completed_swap_requests'] ?? 0 }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-info" style="width: {{ ($stats['total_swap_requests'] ?? 0) > 0 ? (($stats['swap_request_stats']['completed_swap_requests'] ?? 0) / $stats['total_swap_requests']) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div class="mb-0">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Rejected</span>
                            <span class="font-weight-bold text-danger">{{ $stats['swap_request_stats']['rejected_swap_requests'] ?? 0 }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-danger" style="width: {{ ($stats['total_swap_requests'] ?? 0) > 0 ? (($stats['swap_request_stats']['rejected_swap_requests'] ?? 0) / $stats['total_swap_requests']) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- System Performance Metrics -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-chart-line mr-2"></i> System Performance Metrics</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="text-center">
                                <div class="mb-2">
                                    <i class="fas fa-percentage fa-2x text-success"></i>
                                </div>
                                <h3 class="text-success mb-1">{{ $stats['approval_rate'] }}%</h3>
                                <p class="text-muted mb-0">Book Approval Rate</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="text-center">
                                <div class="mb-2">
                                    <i class="fas fa-users fa-2x text-primary"></i>
                                </div>
                                <h3 class="text-primary mb-1">{{ round(($stats['user_activity_stats']['users_with_books'] / max($stats['total_users'], 1)) * 100, 1) }}%</h3>
                                <p class="text-muted mb-0">Users with Books</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="text-center">
                                <div class="mb-2">
                                    <i class="fas fa-handshake fa-2x text-info"></i>
                                </div>
                                <h3 class="text-info mb-1">{{ $stats['total_loan_requests'] > 0 ? round((($stats['loan_request_stats']['approved_loan_requests'] + $stats['loan_request_stats']['completed_loan_requests']) / $stats['total_loan_requests']) * 100, 1) : 0 }}%</h3>
                                <p class="text-muted mb-0">Loan Success Rate</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="text-center">
                                <div class="mb-2">
                                    <i class="fas fa-exchange-alt fa-2x text-warning"></i>
                                </div>
                                <h3 class="text-warning mb-1">{{ $stats['total_swap_requests'] > 0 ? round((($stats['swap_request_stats']['approved_swap_requests'] + $stats['swap_request_stats']['completed_swap_requests']) / $stats['total_swap_requests']) * 100, 1) : 0 }}%</h3>
                                <p class="text-muted mb-0">Swap Success Rate</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Statistics Charts Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-chart-bar mr-2"></i> Statistics Overview</h4>
                    <div class="card-header-action">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-primary active" onclick="showChart('vertical')">
                                <i class="fas fa-chart-bar"></i> Vertical
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="showChart('grouped')">
                                <i class="fas fa-layer-group"></i> Grouped
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="showChart('pie')">
                                <i class="fas fa-chart-pie"></i> Pie
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Chart Container -->
                    <div class="chart-container" style="position: relative; height: 400px;">
                        <canvas id="statisticsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Charts Section -->
    <div class="row">
        <!-- User Books Statistics -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-book mr-2"></i> My Books Analysis</h4>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 300px;">
                        <canvas id="userBooksChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Request Statistics -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-exchange-alt mr-2"></i> Request Statistics</h4>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 300px;">
                        <canvas id="requestChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($isAdmin)
    <!-- Admin Charts Section -->
    <div class="row">
        <!-- Category Distribution Chart -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-chart-pie mr-2"></i> Books by Category</h4>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 350px;">
                        <canvas id="categoryDistributionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Trends Chart -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-chart-line mr-2"></i> Monthly Growth Trends</h4>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 350px;">
                        <canvas id="monthlyTrendsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Request Status Analytics -->
    <div class="row">
        <!-- Loan Request Status Chart -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-handshake mr-2"></i> Loan Request Status Distribution</h4>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 300px;">
                        <canvas id="loanRequestStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Swap Request Status Chart -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-exchange-alt mr-2"></i> Swap Request Status Distribution</h4>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 300px;">
                        <canvas id="swapRequestStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- System Overview Chart -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-tachometer-alt mr-2"></i> System Overview - Comparative Analysis</h4>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 350px;">
                        <canvas id="adminSystemChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Recent Activity & Latest Books -->
    <div class="row">
        <!-- Recent Activity -->
        {{-- <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-history"></i> Recent Activity</h4>
                    <div class="card-header-action">
                        <a href="{{ route('loan-requests.index') }}" class="btn btn-sm btn-primary">View All</a>
                    </div>
                </div>
                <div class="card-body">
                    @if($recentLoanRequests->count() > 0 || $recentSwapRequests->count() > 0)
                        <div class="activities">
                            @foreach($recentLoanRequests->take(3) as $request)
                            <div class="activity">
                                <div class="activity-icon bg-primary text-white shadow-primary">
                                    <i class="fas fa-hand-holding"></i>
                                </div>
                                <div class="activity-detail">
                                    <div class="mb-2">
                                        <span class="text-job">{{ $request->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p>
                                        @if($request->borrower_id === Auth::id())
                                            You requested to borrow "<strong>{{ $request->book->title }}</strong>" from {{ $request->lender->name }}
                                        @else
                                            {{ $request->borrower->name }} requested to borrow your book "<strong>{{ $request->book->title }}</strong>"
                                        @endif
                                    </p>
                                    <span class="badge badge-{{ $request->status === 'pending' ? 'warning' : ($request->status === 'approved' ? 'success' : 'danger') }}">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </div>
                            </div>
                            @endforeach

                            @foreach($recentSwapRequests->take(2) as $request)
                            <div class="activity">
                                <div class="activity-icon bg-info text-white shadow-info">
                                    <i class="fas fa-exchange-alt"></i>
                                </div>
                                <div class="activity-detail">
                                    <div class="mb-2">
                                        <span class="text-job">{{ $request->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p>
                                        @if($request->requester_id === Auth::id())
                                            You proposed a swap: your "<strong>{{ $request->offeredBook->title }}</strong>" for "{{ $request->requestedBook->title }}"
                                        @else
                                            {{ $request->requester->name }} proposed to swap their "{{ $request->offeredBook->title }}" for your "<strong>{{ $request->requestedBook->title }}</strong>"
                                        @endif
                                    </p>
                                    <span class="badge badge-{{ $request->status === 'pending' ? 'warning' : ($request->status === 'approved' ? 'success' : 'danger') }}">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted">
                            <i class="fas fa-info-circle fa-3x mb-3"></i>
                            <p>No recent activity yet. Start by uploading books or browsing available books!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div> --}}

        <!-- Latest Books -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-star"></i> Latest Available Books</h4>
                    <div class="card-header-action">
                        <a href="{{ route('books.index') }}" class="btn btn-sm btn-primary">Browse All</a>
                    </div>
                </div>
                <div class="card-body">
                    @if($latestBooks->count() > 0)
                        <div class="row">
                            @foreach($latestBooks as $book)
                            <div class="col-md-6 mb-3">
                                <div class="card border">
                                    <div class="card-body p-3">
                                        <div class="d-flex">
                                            <div class="mr-3">
                                                <img src="{{ $book->image ? asset('storage/' . $book->image) : asset('backend/assets/img/books/default.png') }}"
                                                     alt="{{ $book->title }}"
                                                     style="width: 50px; height: 60px; object-fit: cover;"
                                                     class="rounded">
                                            </div>
                                            <div class="flex-fill">
                                                <h6 class="mb-1">
                                                    <a href="{{ route('books.show', $book) }}" class="text-dark">
                                                        {{ Str::limit($book->title, 20) }}
                                                    </a>
                                                </h6>
                                                <small class="text-muted">by {{ $book->author }}</small><br>
                                                <small class="text-muted">{{ $book->user->name }}</small><br>
                                                <span class="badge badge-primary badge-sm">{{ $book->formatted_availability_type }}</span>
                                                <span class="badge badge-success badge-sm">{{ $book->formatted_condition }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted">
                            <i class="fas fa-book fa-3x mb-3"></i>
                            <p>No books available yet. Be the first to upload a book!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-bolt"></i> Quick Actions</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('books.create') }}" class="btn btn-primary btn-block">
                                <i class="fas fa-plus"></i> Upload New Book
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('books.my-books') }}" class="btn btn-outline-primary btn-block">
                                <i class="fas fa-book"></i> Manage My Books
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('loan-requests.index') }}" class="btn btn-outline-success btn-block">
                                <i class="fas fa-handshake"></i> Loan Requests
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('swap-requests.index') }}" class="btn btn-outline-info btn-block">
                                <i class="fas fa-exchange-alt"></i> Swap Requests
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



@endsection

@push('scripts')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Global chart variables
let statisticsChart, userBooksChart, requestChart, adminSystemChart, categoryDistributionChart, 
    monthlyTrendsChart, loanRequestStatusChart, swapRequestStatusChart;

// Statistics data from backend
const statsData = @json($stats);

// Color schemes
const colors = {
    primary: '#6777ef',
    success: '#47c363',
    warning: '#ffa426',
    danger: '#fc544b',
    info: '#3abaf4',
    dark: '#2c2c54',
    secondary: '#6c757d',
    purple: '#A855F7',
    pink: '#EC4899'
};

const gradientColors = [
    'rgba(103, 119, 239, 0.8)',
    'rgba(71, 195, 99, 0.8)',
    'rgba(255, 164, 38, 0.8)',
    'rgba(252, 84, 75, 0.8)',
    'rgba(58, 186, 244, 0.8)',
    'rgba(168, 85, 247, 0.8)',
    'rgba(236, 72, 153, 0.8)',
    'rgba(108, 117, 125, 0.8)'
];

// Initialize charts when document is ready
document.addEventListener('DOMContentLoaded', function() {
    initializeMainChart();
    initializeUserBooksChart();
    initializeRequestChart();
    @if($isAdmin)
    initializeAdminCharts();
    @endif
});

// Main Statistics Chart with different types
function initializeMainChart() {
    const ctx = document.getElementById('statisticsChart').getContext('2d');
    
    const chartData = {
        labels: ['My Books', 'Approved Books', 'Pending Books', 'Available Books', 'My Loan Requests', 'Loan Requests for My Books', 'My Swap Requests', 'Swap Requests for My Books'],
        datasets: [{
            label: 'Count',
            data: [
                statsData.my_books || 0,
                statsData.my_approved_books || 0,
                statsData.my_pending_books || 0,
                statsData.available_books || 0,
                statsData.my_loan_requests || 0,
                statsData.loan_requests_for_my_books || 0,
                statsData.my_swap_requests || 0,
                statsData.swap_requests_for_my_books || 0
            ],
            backgroundColor: gradientColors,
            borderColor: gradientColors.map(color => color.replace('0.8', '1')),
            borderWidth: 2,
            borderRadius: 4
        }]
    };

    statisticsChart = new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Your Book & Request Statistics',
                    font: {
                        size: 16,
                        weight: 'bold'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                },
                x: {
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            },
            animation: {
                duration: 1000,
                easing: 'easeOutQuart'
            }
        }
    });
}

// User Books Analysis Chart (Doughnut)
function initializeUserBooksChart() {
    const ctx = document.getElementById('userBooksChart').getContext('2d');
    
    userBooksChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Approved Books', 'Pending Approval', 'Available to Others'],
            datasets: [{
                data: [
                    statsData.my_approved_books || 0,
                    statsData.my_pending_books || 0,
                    statsData.available_books || 0
                ],
                backgroundColor: [colors.success, colors.warning, colors.info],
                borderWidth: 3,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                },
                title: {
                    display: true,
                    text: 'Book Status Distribution',
                    font: {
                        size: 14,
                        weight: 'bold'
                    }
                }
            },
            animation: {
                animateRotate: true,
                duration: 1500
            }
        }
    });
}

// Request Statistics Chart (Horizontal Bar)
function initializeRequestChart() {
    const ctx = document.getElementById('requestChart').getContext('2d');
    
    requestChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: ['My Loan Requests', 'Loan Requests Received', 'My Swap Requests', 'Swap Requests Received'],
            datasets: [{
                label: 'Requests',
                data: [
                    statsData.my_loan_requests || 0,
                    statsData.loan_requests_for_my_books || 0,
                    statsData.my_swap_requests || 0,
                    statsData.swap_requests_for_my_books || 0
                ],
                backgroundColor: [colors.primary, colors.dark, colors.purple, colors.pink],
                borderColor: [colors.primary, colors.dark, colors.purple, colors.pink],
                borderWidth: 2,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Request Activity Overview',
                    font: {
                        size: 14,
                        weight: 'bold'
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            animation: {
                duration: 1200,
                easing: 'easeOutBounce'
            }
        }
    });
}

@if($isAdmin)
// Admin Charts
function initializeAdminCharts() {
    // Category Distribution Chart
    const categoryCtx = document.getElementById('categoryDistributionChart').getContext('2d');
    const categoryData = @json($stats['category_stats'] ?? []);
    
    categoryDistributionChart = new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: categoryData.map(cat => cat.name),
            datasets: [{
                data: categoryData.map(cat => cat.books_count),
                backgroundColor: [
                    colors.primary, colors.success, colors.warning, colors.danger, 
                    colors.info, colors.purple, colors.pink, colors.secondary
                ],
                borderWidth: 3,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        usePointStyle: true,
                        generateLabels: function(chart) {
                            const data = chart.data;
                            return data.labels.map((label, i) => ({
                                text: `${label} (${data.datasets[0].data[i]})`,
                                fillStyle: data.datasets[0].backgroundColor[i],
                                strokeStyle: data.datasets[0].backgroundColor[i],
                                pointStyle: 'circle'
                            }));
                        }
                    }
                },
                title: {
                    display: true,
                    text: 'Book Distribution by Category',
                    font: { size: 16, weight: 'bold' }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label;
                            const value = context.raw;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${label}: ${value} books (${percentage}%)`;
                        }
                    }
                }
            },
            animation: { animateRotate: true, duration: 1500 }
        }
    });

    // Monthly Trends Chart
    const trendsCtx = document.getElementById('monthlyTrendsChart').getContext('2d');
    const monthlyData = @json($stats['monthly_trends'] ?? []);
    const months = Object.keys(monthlyData);
    
    monthlyTrendsChart = new Chart(trendsCtx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [
                {
                    label: 'New Users',
                    data: months.map(month => monthlyData[month].users),
                    borderColor: colors.primary,
                    backgroundColor: colors.primary + '20',
                    borderWidth: 3,
                    fill: false,
                    tension: 0.4,
                    pointBackgroundColor: colors.primary,
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5
                },
                {
                    label: 'New Books',
                    data: months.map(month => monthlyData[month].books),
                    borderColor: colors.success,
                    backgroundColor: colors.success + '20',
                    borderWidth: 3,
                    fill: false,
                    tension: 0.4,
                    pointBackgroundColor: colors.success,
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5
                },
                {
                    label: 'Loan Requests',
                    data: months.map(month => monthlyData[month].loan_requests),
                    borderColor: colors.warning,
                    backgroundColor: colors.warning + '20',
                    borderWidth: 3,
                    fill: false,
                    tension: 0.4,
                    pointBackgroundColor: colors.warning,
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5
                },
                {
                    label: 'Swap Requests',
                    data: months.map(month => monthlyData[month].swap_requests),
                    borderColor: colors.info,
                    backgroundColor: colors.info + '20',
                    borderWidth: 3,
                    fill: false,
                    tension: 0.4,
                    pointBackgroundColor: colors.info,
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: { usePointStyle: true, padding: 20 }
                },
                title: {
                    display: true,
                    text: 'Monthly Growth Trends (Last 12 Months)',
                    font: { size: 16, weight: 'bold' }
                }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } },
                x: { ticks: { maxRotation: 45 } }
            },
            interaction: { intersect: false, mode: 'index' },
            animation: { duration: 1500, easing: 'easeOutQuart' }
        }
    });

    // Loan Request Status Chart
    const loanStatusCtx = document.getElementById('loanRequestStatusChart').getContext('2d');
    const loanStats = @json($stats['loan_request_stats'] ?? []);
    
    loanRequestStatusChart = new Chart(loanStatusCtx, {
        type: 'bar',
        data: {
            labels: ['Pending', 'Approved', 'Completed', 'Rejected'],
            datasets: [{
                label: 'Loan Requests',
                data: [
                    loanStats.pending_loan_requests || 0,
                    loanStats.approved_loan_requests || 0,
                    loanStats.completed_loan_requests || 0,
                    loanStats.rejected_loan_requests || 0
                ],
                backgroundColor: [colors.warning, colors.success, colors.info, colors.danger],
                borderColor: [colors.warning, colors.success, colors.info, colors.danger],
                borderWidth: 2,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Loan Request Status Distribution',
                    font: { size: 14, weight: 'bold' }
                }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            },
            animation: { duration: 1000, easing: 'easeOutBounce' }
        }
    });

    // Swap Request Status Chart
    const swapStatusCtx = document.getElementById('swapRequestStatusChart').getContext('2d');
    const swapStats = @json($stats['swap_request_stats'] ?? []);
    
    swapRequestStatusChart = new Chart(swapStatusCtx, {
        type: 'bar',
        data: {
            labels: ['Pending', 'Approved', 'Completed', 'Rejected'],
            datasets: [{
                label: 'Swap Requests',
                data: [
                    swapStats.pending_swap_requests || 0,
                    swapStats.approved_swap_requests || 0,
                    swapStats.completed_swap_requests || 0,
                    swapStats.rejected_swap_requests || 0
                ],
                backgroundColor: [colors.warning, colors.success, colors.info, colors.danger],
                borderColor: [colors.warning, colors.success, colors.info, colors.danger],
                borderWidth: 2,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Swap Request Status Distribution',
                    font: { size: 14, weight: 'bold' }
                }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            },
            animation: { duration: 1000, easing: 'easeOutBounce' }
        }
    });

    // System Overview Chart (Grouped Bar)
    const systemCtx = document.getElementById('adminSystemChart').getContext('2d');
    
    adminSystemChart = new Chart(systemCtx, {
        type: 'bar',
        data: {
            labels: ['Users', 'Books', 'Categories', 'Loan Requests', 'Swap Requests'],
            datasets: [
                {
                    label: 'Total',
                    data: [
                        statsData.total_users || 0,
                        statsData.total_books || 0,
                        statsData.active_categories || 0,
                        statsData.total_loan_requests || 0,
                        statsData.total_swap_requests || 0
                    ],
                    backgroundColor: colors.primary,
                    borderColor: colors.primary,
                    borderWidth: 2,
                    borderRadius: 4
                },
                {
                    label: 'Active/Pending',
                    data: [
                        statsData.user_activity_stats?.active_users_last_30_days || 0,
                        statsData.pending_book_approvals || 0,
                        0, // No pending categories
                        loanStats.pending_loan_requests || 0,
                        swapStats.pending_swap_requests || 0
                    ],
                    backgroundColor: colors.warning,
                    borderColor: colors.warning,
                    borderWidth: 2,
                    borderRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: { usePointStyle: true, padding: 20 }
                },
                title: {
                    display: true,
                    text: 'System-wide Statistics Overview',
                    font: { size: 16, weight: 'bold' }
                }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } },
                x: { ticks: { maxRotation: 0 } }
            },
            animation: { duration: 1000, easing: 'easeOutQuart' }
        }
    });
}
@endif

// Function to switch between chart types
function showChart(type) {
    // Update button states
    const buttons = document.querySelectorAll('.btn-group .btn');
    buttons.forEach(btn => {
        btn.classList.remove('active');
        btn.classList.add('btn-outline-primary');
        btn.classList.remove('btn-primary');
    });
    event.target.classList.add('active', 'btn-primary');
    event.target.classList.remove('btn-outline-primary');

    // Destroy existing chart
    if (statisticsChart) {
        statisticsChart.destroy();
    }

    const ctx = document.getElementById('statisticsChart').getContext('2d');
    
    const chartData = {
        labels: ['My Books', 'Approved', 'Pending', 'Available', 'My Loans', 'Loans Received', 'My Swaps', 'Swaps Received'],
        datasets: [{
            label: 'Count',
            data: [
                statsData.my_books || 0,
                statsData.my_approved_books || 0,
                statsData.my_pending_books || 0,
                statsData.available_books || 0,
                statsData.my_loan_requests || 0,
                statsData.loan_requests_for_my_books || 0,
                statsData.my_swap_requests || 0,
                statsData.swap_requests_for_my_books || 0
            ],
            backgroundColor: gradientColors,
            borderColor: gradientColors.map(color => color.replace('0.8', '1')),
            borderWidth: 2
        }]
    };

    let chartConfig = {
        data: chartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: type === 'pie'
                },
                title: {
                    display: true,
                    text: `Your Statistics - ${type.charAt(0).toUpperCase() + type.slice(1)} View`,
                    font: {
                        size: 16,
                        weight: 'bold'
                    }
                }
            },
            animation: {
                duration: 1000,
                easing: 'easeOutQuart'
            }
        }
    };

    // Configure based on chart type
    switch(type) {
        case 'vertical':
            chartConfig.type = 'bar';
            chartConfig.options.scales = {
                y: { beginAtZero: true, ticks: { stepSize: 1 } },
                x: { ticks: { maxRotation: 45 } }
            };
            chartConfig.data.datasets[0].borderRadius = 4;
            break;
            
        case 'grouped':
            chartConfig.type = 'bar';
            chartConfig.data.datasets = [
                {
                    label: 'Books',
                    data: [statsData.my_books || 0, statsData.my_approved_books || 0, statsData.my_pending_books || 0, statsData.available_books || 0],
                    backgroundColor: colors.primary,
                    borderColor: colors.primary,
                    borderWidth: 2,
                    borderRadius: 4
                },
                {
                    label: 'Requests',
                    data: [statsData.my_loan_requests || 0, statsData.loan_requests_for_my_books || 0, statsData.my_swap_requests || 0, statsData.swap_requests_for_my_books || 0],
                    backgroundColor: colors.success,
                    borderColor: colors.success,
                    borderWidth: 2,
                    borderRadius: 4
                }
            ];
            chartConfig.data.labels = ['My Books', 'Approved', 'Pending', 'Available'];
            chartConfig.options.scales = {
                y: { beginAtZero: true, ticks: { stepSize: 1 } },
                x: { ticks: { maxRotation: 0 } }
            };
            chartConfig.options.plugins.legend.display = true;
            break;
            
        case 'pie':
            chartConfig.type = 'pie';
            chartConfig.data.datasets[0].borderWidth = 3;
            chartConfig.data.datasets[0].borderColor = '#fff';
            delete chartConfig.options.scales;
            chartConfig.options.plugins.legend = {
                position: 'bottom',
                labels: { padding: 20, usePointStyle: true }
            };
            break;
    }

    statisticsChart = new Chart(ctx, chartConfig);
}

// Utility function for responsive design
function handleResize() {
    if (statisticsChart) statisticsChart.resize();
    if (userBooksChart) userBooksChart.resize();
    if (requestChart) requestChart.resize();
    @if($isAdmin)
    if (adminSystemChart) adminSystemChart.resize();
    if (categoryDistributionChart) categoryDistributionChart.resize();
    if (monthlyTrendsChart) monthlyTrendsChart.resize();
    if (loanRequestStatusChart) loanRequestStatusChart.resize();
    if (swapRequestStatusChart) swapRequestStatusChart.resize();
    @endif
}

// Add resize event listener
window.addEventListener('resize', handleResize);

// Add some animations and interactions
document.addEventListener('DOMContentLoaded', function() {
    // Animate statistics cards on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'fadeInUp 0.6s ease-out forwards';
            }
        });
    }, observerOptions);

    // Observe all chart containers
    document.querySelectorAll('.chart-container').forEach(container => {
        observer.observe(container.parentElement);
    });
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .chart-container {
        opacity: 0;
        animation: fadeInUp 0.6s ease-out 0.2s forwards;
    }
    
    .btn-group .btn {
        transition: all 0.3s ease;
    }
    
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .border-left-primary {
        border-left: 4px solid #6777ef !important;
    }
    
    .progress {
        border-radius: 10px;
        overflow: hidden;
    }
    
    .progress-bar {
        border-radius: 10px;
    }
    
    .list-group-item {
        border: none;
        padding: 0.75rem 0;
    }
    
    .list-group-item:last-child {
        border-bottom: none !important;
    }
    
    .badge-pill {
        border-radius: 50px;
        padding: 0.5em 0.75em;
        font-size: 0.75em;
        font-weight: 600;
    }
    
    .alert {
        border-radius: 10px;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .text-truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
`;
document.head.appendChild(style);
</script>
@endpush
