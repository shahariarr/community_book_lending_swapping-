@extends('layouts.back')
@section('title', 'Swap Requests')
@section('content')

<section class="section">
    <div class="section-header">
        <h1>Swap Requests</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></div>
            <div class="breadcrumb-item active">Swap Requests</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>All Swap Requests</h4>
                <div class="card-header-action">
                    <span class="badge badge-primary">{{ $swapRequests->total() }} Total Requests</span>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Requester</th>
                                <th>Offered Book</th>
                                <th>Requested Book</th>
                                <th>Owner</th>
                                <th>Status</th>
                                <th>Requested</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($swapRequests as $request)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $request->requester->profile_image ? asset('storage/' . $request->requester->profile_image) : asset('backend/assets/img/avatar/avatar-1.png') }}"
                                                 alt="Avatar" class="rounded-circle mr-2" style="width: 30px; height: 30px;">
                                            <div>
                                                <strong>{{ $request->requester->name }}</strong><br>
                                                <small class="text-muted">{{ $request->requester->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $request->offeredBook->image ? asset('storage/' . $request->offeredBook->image) : asset('backend/assets/img/book-placeholder.jpg') }}"
                                                 alt="Book Cover" class="rounded mr-2" style="width: 40px; height: 50px; object-fit: cover;">
                                            <div>
                                                <strong>{{ $request->offeredBook->title }}</strong><br>
                                                <small class="text-muted">by {{ $request->offeredBook->author }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $request->requestedBook->image ? asset('storage/' . $request->requestedBook->image) : asset('backend/assets/img/book-placeholder.jpg') }}"
                                                 alt="Book Cover" class="rounded mr-2" style="width: 40px; height: 50px; object-fit: cover;">
                                            <div>
                                                <strong>{{ $request->requestedBook->title }}</strong><br>
                                                <small class="text-muted">by {{ $request->requestedBook->author }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $request->owner->profile_image ? asset('storage/' . $request->owner->profile_image) : asset('backend/assets/img/avatar/avatar-1.png') }}"
                                                 alt="Avatar" class="rounded-circle mr-2" style="width: 30px; height: 30px;">
                                            <div>
                                                <strong>{{ $request->owner->name }}</strong><br>
                                                <small class="text-muted">{{ $request->owner->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $request->status === 'approved' ? 'success' : ($request->status === 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                        @if($request->status === 'approved')
                                            <br><span class="badge badge-info mt-1">Completed</span>
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
                                                <a class="dropdown-item" href="{{ route('swap-requests.show', $request) }}">
                                                    <i class="fas fa-eye"></i> View Details
                                                </a>
                                                @if($request->message)
                                                    <button class="dropdown-item" data-toggle="modal" data-target="#messageModal{{ $request->id }}">
                                                        <i class="fas fa-comment"></i> View Message
                                                    </button>
                                                @endif
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="{{ route('books.show', $request->offeredBook) }}">
                                                    <i class="fas fa-book"></i> View Offered Book
                                                </a>
                                                <a class="dropdown-item" href="{{ route('books.show', $request->requestedBook) }}">
                                                    <i class="fas fa-book-open"></i> View Requested Book
                                                </a>
                                                @if($request->status === 'pending')
                                                    <div class="dropdown-divider"></div>
                                                    <small class="dropdown-header">Admin Actions</small>
                                                    <button class="dropdown-item text-success" onclick="alert('Feature coming soon: Admin can intervene in swap requests')">
                                                        <i class="fas fa-check"></i> Force Approve
                                                    </button>
                                                    <button class="dropdown-item text-danger" onclick="alert('Feature coming soon: Admin can intervene in swap requests')">
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
                                                    <h5 class="modal-title">Swap Request Message</h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>From:</strong> {{ $request->requester->name }}</p>
                                                    <p><strong>Swap Proposal:</strong></p>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6>Offering:</h6>
                                                            <p>"{{ $request->offeredBook->title }}" by {{ $request->offeredBook->author }}</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6>Requesting:</h6>
                                                            <p>"{{ $request->requestedBook->title }}" by {{ $request->requestedBook->author }}</p>
                                                        </div>
                                                    </div>
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
                                                <i class="fas fa-exchange-alt"></i>
                                            </div>
                                            <h2>No Swap Requests Found</h2>
                                            <p class="lead">No swap requests have been made yet.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($swapRequests->hasPages())
                    <div class="card-footer">
                        {{ $swapRequests->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Swap Requests Statistics -->
        <div class="row mt-4">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Requests</h4>
                        </div>
                        <div class="card-body">
                            {{ $swapRequests->total() }}
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
                            {{ $swapRequests->where('status', 'pending')->count() }}
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
                            {{ $swapRequests->where('status', 'approved')->count() }}
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
                            {{ $swapRequests->where('status', 'rejected')->count() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
