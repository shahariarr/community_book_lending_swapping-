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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    @if($isAdmin)
    <!-- Admin View - Full Statistics -->
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-primary">
                <i class="fas fa-book"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Total Books</h4>
                </div>
                <div class="card-body">
                  {{ number_format($stats['total_books']) }}
                </div>
              </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-success">
                <i class="fas fa-book-open"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Available Books</h4>
                </div>
                <div class="card-body">
                  {{ number_format($stats['available_books']) }}
                </div>
              </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-warning">
                <i class="fas fa-exchange-alt"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Books on Loan</h4>
                </div>
                <div class="card-body">
                  {{ number_format($stats['books_on_loan']) }}
                </div>
              </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-info">
                <i class="fas fa-users"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Total Members</h4>
                </div>
                <div class="card-body">
                  {{ number_format($stats['total_members']) }}
                </div>
              </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-secondary">
                <i class="fas fa-handshake"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Active Loans</h4>
                </div>
                <div class="card-body">
                  {{ number_format($stats['active_loans']) }}
                </div>
              </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-purple">
                <i class="fas fa-sync-alt"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Book Swaps</h4>
                </div>
                <div class="card-body">
                  {{ number_format($stats['book_swaps']) }}
                </div>
              </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-cyan">
                <i class="fas fa-bell"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>New Requests</h4>
                </div>
                <div class="card-body">
                  {{ number_format($stats['new_requests']) }}
                </div>
              </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-danger">
                <i class="fas fa-clock"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Overdue Books</h4>
                </div>
                <div class="card-body">
                  {{ number_format($stats['overdue_books']) }}
                </div>
              </div>
            </div>
        </div>
    </div>

    <!-- Additional Admin Information Section -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-tags text-primary"></i> Book Categories</h4>
                </div>
                <div class="card-body">
                    <p class="card-text">Total book categories available in the system.</p>
                    <h3 class="text-primary">{{ number_format($stats['total_categories']) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-star text-warning"></i> Popular Books</h4>
                </div>
                <div class="card-body">
                    <p class="card-text">Books with highest lending activity.</p>
                    <h3 class="text-warning">{{ number_format($stats['popular_books']) }}</h3>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- User View - Limited Statistics -->
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-success">
                <i class="fas fa-book-open"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Available Books</h4>
                </div>
                <div class="card-body">
                  {{ number_format($stats['available_books']) }}
                </div>
              </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-info">
                <i class="fas fa-book-reader"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>My Borrowed Books</h4>
                </div>
                <div class="card-body">
                  {{ number_format($stats['my_borrowed_books']) }}
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
                  <h4>My Requests</h4>
                </div>
                <div class="card-body">
                  {{ number_format($stats['my_requests']) }}
                </div>
              </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-primary">
                <i class="fas fa-tags"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Book Categories</h4>
                </div>
                <div class="card-body">
                  {{ number_format($stats['total_categories']) }}
                </div>
              </div>
            </div>
        </div>
    </div>

    <!-- User Quick Access Section -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-search text-primary"></i> Browse Books</h4>
                </div>
                <div class="card-body">
                    <p class="card-text">Search and explore available books in our collection.</p>
                    <a href="#" class="btn btn-primary btn-sm">Browse Now</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-exchange-alt text-success"></i> Request Book</h4>
                </div>
                <div class="card-body">
                    <p class="card-text">Submit a request to borrow a book from the library.</p>
                    <a href="#" class="btn btn-success btn-sm">Request Book</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-history text-info"></i> My History</h4>
                </div>
                <div class="card-body">
                    <p class="card-text">View your borrowing history and current loans.</p>
                    <a href="#" class="btn btn-info btn-sm">View History</a>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- System Information Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-info-circle text-info"></i> Community Book Lending & Swapping System</h4>
                </div>
                <div class="card-body">
                    @if($isAdmin)
                    <!-- Admin System Information -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center mb-3">
                                <i class="fas fa-book fa-2x text-primary mb-2"></i>
                                <h5>Book Management</h5>
                                <p class="text-muted small">Track and manage entire book inventory</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center mb-3">
                                <i class="fas fa-users fa-2x text-info mb-2"></i>
                                <h5>Member Management</h5>
                                <p class="text-muted small">Manage all community members and activities</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center mb-3">
                                <i class="fas fa-chart-bar fa-2x text-success mb-2"></i>
                                <h5>Analytics</h5>
                                <p class="text-muted small">View detailed system statistics and reports</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center mb-3">
                                <i class="fas fa-cogs fa-2x text-warning mb-2"></i>
                                <h5>System Settings</h5>
                                <p class="text-muted small">Configure and maintain the system</p>
                            </div>
                        </div>
                    </div>
                    @else
                    <!-- User System Information -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center mb-3">
                                <i class="fas fa-book fa-2x text-primary mb-2"></i>
                                <h5>Browse Books</h5>
                                <p class="text-muted small">Explore our collection of available books</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center mb-3">
                                <i class="fas fa-exchange-alt fa-2x text-success mb-2"></i>
                                <h5>Borrow & Return</h5>
                                <p class="text-muted small">Easy book borrowing and return process</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center mb-3">
                                <i class="fas fa-sync-alt fa-2x text-warning mb-2"></i>
                                <h5>Book Swapping</h5>
                                <p class="text-muted small">Swap books with other community members</p>
                            </div>
                        </div>
                    </div>
                    @endif
                    <hr>
                    <div class="text-center">
                        <p class="mb-2">
                            <strong>Your Access Level:</strong>
                            <span class="badge badge-{{ $isAdmin ? 'danger' : 'primary' }}">
                                {{ $isAdmin ? 'Administrator' : 'Member' }}
                            </span>
                        </p>
                        <p class="mb-0 text-muted">Last updated: {{ now()->format('M d, Y \a\t h:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('css')
<style>
.bg-purple {
    background: linear-gradient(45deg, #667eea 0%, #764ba2 100%) !important;
}
.bg-cyan {
    background: linear-gradient(45deg, #4facfe 0%, #00f2fe 100%) !important;
}
.card-statistic-1 {
    transition: transform 0.2s;
}
.card-statistic-1:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
</style>
@endpush

@endsection
