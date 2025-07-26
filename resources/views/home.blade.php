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
