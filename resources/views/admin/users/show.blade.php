@extends('layouts.back')
@section('title', 'User Details')
@section('content')

<section class="section">
    <div class="section-header">
        <h1>User Details</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></div>
            <div class="breadcrumb-item active">{{ $user->name }}</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-4 col-lg-3">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('backend/assets/img/avatar/avatar-1.png') }}"
                             alt="Profile Image" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">

                        <h5>{{ $user->name }}</h5>
                        <p class="text-muted">{{ $user->email }}</p>

                        <div class="mb-3">
                            @foreach($user->roles as $role)
                                <span class="badge badge-{{ $role->name === 'Super Admin' ? 'danger' : ($role->name === 'Admin' ? 'warning' : 'secondary') }} mr-1">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                            @if($user->roles->isEmpty())
                                <span class="badge badge-light">No Role</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            @if($user->is_active ?? true)
                                <span class="badge badge-success">Active User</span>
                            @else
                                <span class="badge badge-danger">Inactive User</span>
                            @endif
                        </div>

                        @if($user->id !== auth()->id() && !$user->hasRole('Super Admin'))
                            @if(!$user->hasRole('Admin'))
                                <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-{{ ($user->is_active ?? true) ? 'warning' : 'success' }} btn-sm"
                                            onclick="return confirm('Are you sure you want to {{ ($user->is_active ?? true) ? 'deactivate' : 'activate' }} this user?')">
                                        <i class="fas fa-{{ ($user->is_active ?? true) ? 'ban' : 'check' }}"></i>
                                        {{ ($user->is_active ?? true) ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                            @endif
                            @can('edit-user')
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-primary btn-sm ml-1">
                                    <i class="fas fa-edit"></i> Edit User
                                </a>
                            @endcan
                        @endif
                    </div>
                </div>

                <!-- User Statistics -->
                <div class="card">
                    <div class="card-header">
                        <h4>Statistics</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="text-center">
                                    <div class="font-weight-bold text-muted">Books</div>
                                    <div class="h4 text-primary">{{ $stats['total_books'] }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center">
                                    <div class="font-weight-bold text-muted">Loans</div>
                                    <div class="h4 text-success">{{ $stats['active_loans'] }}</div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <div class="text-center">
                                    <div class="font-weight-bold text-muted">Swaps</div>
                                    <div class="h4 text-info">{{ $stats['active_swaps'] }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center">
                                    <div class="font-weight-bold text-muted">Pending</div>
                                    <div class="h4 text-warning">{{ $stats['pending_books'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-8 col-lg-9">
                <!-- User Information -->
                <div class="card">
                    <div class="card-header">
                        <h4>User Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="40%">Full Name:</th>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone:</th>
                                        <td>{{ $user->phone ?? 'Not provided' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Address:</th>
                                        <td>{{ $user->address ?? 'Not provided' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="40%">Joined:</th>
                                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Last Updated:</th>
                                        <td>{{ $user->updated_at->format('M d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email Verified:</th>
                                        <td>
                                            @if($user->email_verified_at)
                                                <span class="badge badge-success">Verified</span>
                                            @else
                                                <span class="badge badge-warning">Not Verified</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td>
                                            @if($user->is_active ?? true)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User's Books -->
                @if($user->books->isNotEmpty())
                    <div class="card">
                        <div class="card-header">
                            <h4>User's Books ({{ $user->books->count() }})</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($user->books as $book)
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body p-2">
                                                <div class="d-flex">
                                                    <img src="{{ $book->image ? asset('storage/' . $book->image) : asset('backend/assets/img/book-placeholder.jpg') }}"
                                                         alt="Book Cover" class="rounded mr-2" style="width: 50px; height: 60px; object-fit: cover;">
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">{{ Str::limit($book->title, 20) }}</h6>
                                                        <small class="text-muted">{{ $book->author }}</small><br>
                                                        <div class="mt-1">
                                                            @if($book->is_approved)
                                                                <span class="badge badge-success badge-sm">Approved</span>
                                                            @else
                                                                <span class="badge badge-warning badge-sm">Pending</span>
                                                            @endif
                                                            <span class="badge badge-info badge-sm">{{ $book->category->name }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Recent Loan Requests -->
                @if($user->loanRequestsAsBorrower->isNotEmpty())
                    <div class="card">
                        <div class="card-header">
                            <h4>Recent Loan Requests ({{ $user->loanRequestsAsBorrower->count() }})</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Book</th>
                                            <th>Duration</th>
                                            <th>Status</th>
                                            <th>Requested</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->loanRequestsAsBorrower->take(5) as $loanRequest)
                                            <tr>
                                                <td>
                                                    <strong>{{ $loanRequest->book->title }}</strong><br>
                                                    <small class="text-muted">by {{ $loanRequest->book->author }}</small>
                                                </td>
                                                <td>
                                                    <small>
                                                        {{ $loanRequest->start_date->format('M d') }} - {{ $loanRequest->end_date->format('M d, Y') }}
                                                    </small>
                                                </td>
                                                <td>
                                                    <span class="badge badge-{{ $loanRequest->status === 'approved' ? 'success' : ($loanRequest->status === 'pending' ? 'warning' : 'danger') }}">
                                                        {{ ucfirst($loanRequest->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <small>{{ $loanRequest->created_at->format('M d, Y') }}</small>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Recent Swap Requests -->
                @if($user->swapRequestsAsRequester->isNotEmpty())
                    <div class="card">
                        <div class="card-header">
                            <h4>Recent Swap Requests ({{ $user->swapRequestsAsRequester->count() }})</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Requested Book</th>
                                            <th>Status</th>
                                            <th>Requested</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->swapRequestsAsRequester->take(5) as $swapRequest)
                                            <tr>
                                                <td>
                                                    <strong>{{ $swapRequest->requestedBook->title }}</strong><br>
                                                    <small class="text-muted">by {{ $swapRequest->requestedBook->author }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge badge-{{ $swapRequest->status === 'approved' ? 'success' : ($swapRequest->status === 'pending' ? 'warning' : 'danger') }}">
                                                        {{ ucfirst($swapRequest->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <small>{{ $swapRequest->created_at->format('M d, Y') }}</small>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection
