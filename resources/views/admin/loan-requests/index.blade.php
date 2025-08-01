@extends('layouts.back')
@section('title', 'Loan Requests')
@section('content')

<section class="section">
    <div class="section-header">
        <h1>Loan Requests</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></div>
            <div class="breadcrumb-item active">Loan Requests</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>All Loan Requests</h4>
                <div class="card-header-action">
                    <span class="badge badge-primary">{{ $loanRequests->total() }} Total Requests</span>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Book</th>
                                <th>Borrower</th>
                                <th>Lender</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Requested</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($loanRequests as $request)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $request->book->image ? asset('storage/' . $request->book->image) : asset('backend/assets/img/book-placeholder.jpg') }}"
                                                 alt="Book Cover" class="rounded mr-2" style="width: 40px; height: 50px; object-fit: cover;">
                                            <div>
                                                <strong>{{ $request->book->title }}</strong><br>
                                                <small class="text-muted">by {{ $request->book->author }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $request->borrower->profile_image ? asset('storage/' . $request->borrower->profile_image) : asset('backend/assets/img/avatar/avatar-1.png') }}"
                                                 alt="Avatar" class="rounded-circle mr-2" style="width: 30px; height: 30px;">
                                            <div>
                                                <strong>{{ $request->borrower->name }}</strong><br>
                                                <small class="text-muted">{{ $request->borrower->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $request->lender->profile_image ? asset('storage/' . $request->lender->profile_image) : asset('backend/assets/img/avatar/avatar-1.png') }}"
                                                 alt="Avatar" class="rounded-circle mr-2" style="width: 30px; height: 30px;">
                                            <div>
                                                <strong>{{ $request->lender->name }}</strong><br>
                                                <small class="text-muted">{{ $request->lender->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <small>
                                            <strong>From:</strong> {{ $request->start_date->format('M d, Y') }}<br>
                                            <strong>To:</strong> {{ $request->end_date->format('M d, Y') }}<br>
                                            <span class="text-muted">({{ $request->start_date->diffInDays($request->end_date) }} days)</span>
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $request->status === 'approved' ? 'success' : ($request->status === 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                        @if($request->status === 'approved' && $request->start_date <= now() && $request->end_date >= now())
                                            <br><span class="badge badge-info mt-1">Active</span>
                                        @elseif($request->status === 'approved' && $request->end_date < now())
                                            <br><span class="badge badge-secondary mt-1">Completed</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $request->created_at->format('M d, Y g:i A') }}</small>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('loan-requests.show', $request) }}">
                                                    <i class="fas fa-eye"></i> View Details
                                                </a>
                                                @if($request->message)
                                                    <button class="dropdown-item" data-toggle="modal" data-target="#messageModal{{ $request->id }}">
                                                        <i class="fas fa-comment"></i> View Message
                                                    </button>
                                                @endif
                                                @if($request->status === 'pending')
                                                    <div class="dropdown-divider"></div>
                                                    <small class="dropdown-header">Admin Actions</small>
                                                    <button class="dropdown-item text-success" onclick="alert('Feature coming soon: Admin can intervene in loan requests')">
                                                        <i class="fas fa-check"></i> Force Approve
                                                    </button>
                                                    <button class="dropdown-item text-danger" onclick="alert('Feature coming soon: Admin can intervene in loan requests')">
                                                        <i class="fas fa-times"></i> Force Reject
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Message Modal -->
                                @if($request->message)
                                    <div class="modal fade" id="messageModal{{ $request->id }}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Request Message</h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>From:</strong> {{ $request->borrower->name }}</p>
                                                    <p><strong>Message:</strong></p>
                                                    <p>{{ $request->message }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <div class="empty-state" data-height="400">
                                            <div class="empty-state-icon">
                                                <i class="fas fa-hand-holding"></i>
                                            </div>
                                            <h2>No Loan Requests Found</h2>
                                            <p class="lead">No loan requests have been made yet.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($loanRequests->hasPages())
                    <div class="card-footer">
                        {{ $loanRequests->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Loan Requests Statistics -->
        <div class="row mt-4">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-hand-holding"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Requests</h4>
                        </div>
                        <div class="card-body">
                            {{ $loanRequests->total() }}
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
                            <h4>Pending</h4>
                        </div>
                        <div class="card-body">
                            {{ $loanRequests->where('status', 'pending')->count() }}
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
                            <h4>Approved</h4>
                        </div>
                        <div class="card-body">
                            {{ $loanRequests->where('status', 'accepted')->count() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-times"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Rejected</h4>
                        </div>
                        <div class="card-body">
                            {{ $loanRequests->where('status', 'rejected')->count() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
