@extends('layouts.back')
@section('title', 'Swap Requests')
@section('content')

<section class="section">
    <div class="section-header">
        <h1>Swap Requests</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active">Swap Requests</div>
        </div>
    </div>



    <!-- My Swap Requests -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-exchange-alt"></i> My Swap Requests</h4>
                    <div class="card-header-action">
                        <span class="badge badge-primary">{{ $myRequests->total() }} Total</span>
                        <button type="button" class="btn btn-outline-danger btn-sm ml-2"
                                onclick="confirmClearSwapHistory()"
                                title="Clear completed/cancelled/rejected requests">
                            <i class="fas fa-broom"></i> Clear History
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if($myRequests->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>I Want</th>
                                        <th>I Offer</th>
                                        <th>Owner</th>
                                        <th>Duration</th>
                                        <th>Status</th>
                                        <th>Requested</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($myRequests as $request)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="mr-3">
                                                    <img src="{{ $request->requestedBook->image ? asset('storage/' . $request->requestedBook->image) : asset('backend/assets/img/books/default.png') }}"
                                                         alt="{{ $request->requestedBook->title }}"
                                                         style="width: 40px; height: 50px; object-fit: cover;"
                                                         class="rounded">
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">
                                                        <a href="{{ route('books.show', $request->requestedBook) }}">
                                                            {{ Str::limit($request->requestedBook->title, 25) }}
                                                        </a>
                                                    </h6>
                                                    <small class="text-muted">by {{ $request->requestedBook->author }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="mr-3">
                                                    <img src="{{ $request->offeredBook->image ? asset('storage/' . $request->offeredBook->image) : asset('backend/assets/img/books/default.png') }}"
                                                         alt="{{ $request->offeredBook->title }}"
                                                         style="width: 40px; height: 50px; object-fit: cover;"
                                                         class="rounded">
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">
                                                        <a href="{{ route('books.show', $request->offeredBook) }}">
                                                            {{ Str::limit($request->offeredBook->title, 25) }}
                                                        </a>
                                                    </h6>
                                                    <small class="text-muted">by {{ $request->offeredBook->author }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="mr-2">
                                                    <img src="{{ $request->requestedBook->user->image ? asset('storage/' . $request->requestedBook->user->image) : asset('backend/assets/img/avatar/xyz.png') }}"
                                                         alt="{{ $request->requestedBook->user->name }}"
                                                         style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover;">
                                                </div>
                                                <span>{{ $request->requestedBook->user->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($request->duration_days && $request->duration_type)
                                                <span class="badge badge-info">
                                                    {{ $request->duration_days }} {{ ucfirst($request->duration_type) }}{{ $request->duration_days > 1 ? 's' : '' }}
                                                </span>
                                            @else
                                                <span class="text-muted">Not set</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($request->status === 'pending')
                                                <span class="badge badge-warning"><i class="fas fa-clock"></i> Pending</span>
                                            @elseif($request->status === 'accepted')
                                                <span class="badge badge-success"><i class="fas fa-check"></i> Completed</span>
                                            @elseif($request->status === 'rejected')
                                                <span class="badge badge-danger"><i class="fas fa-times"></i> Rejected</span>
                                            @elseif($request->status === 'cancelled')
                                                <span class="badge badge-secondary"><i class="fas fa-ban"></i> Cancelled</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $request->created_at->format('M d, Y') }}
                                            <br><small class="text-muted">{{ $request->created_at->diffForHumans() }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('swap-requests.show', $request) }}"
                                                   class="btn btn-outline-primary" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                @if($request->status === 'accepted')
                                                    @if($request->invoice)
                                                        <a href="{{ route('invoices.show', $request->invoice) }}"
                                                           class="btn btn-outline-info" title="View Invoice">
                                                            <i class="fas fa-file-invoice"></i>
                                                        </a>
                                                    @endif

                                                    <button type="button" class="btn btn-outline-success"
                                                            onclick="confirmReturn({{ $request->id }})"
                                                            title="Return Books">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                @endif

                                                @if($request->status === 'pending')
                                                    <button type="button" class="btn btn-outline-danger"
                                                            onclick="confirmCancel({{ $request->id }})"
                                                            title="Cancel Request">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                @endif

                                                @if(in_array($request->status, ['completed', 'cancelled', 'rejected']))
                                                    <button type="button" class="btn btn-outline-secondary"
                                                            onclick="confirmDeleteSwap({{ $request->id }})"
                                                            title="Delete Request">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($myRequests->hasPages())
                            <div class="mt-4">
                                {{ $myRequests->appends(request()->query())->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-exchange-alt fa-3x text-muted mb-3"></i>
                            <h5>No Swap Requests Yet</h5>
                            <p class="text-muted">You haven't made any swap requests yet. Browse books to start swapping!</p>
                            <a href="{{ route('books.index') }}" class="btn btn-primary">
                                <i class="fas fa-search"></i> Browse Books
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Requests for My Books -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-inbox"></i> Swap Requests for My Books</h4>
                    <div class="card-header-action">
                        <span class="badge badge-info">{{ $requestsForMyBooks->total() }} Total</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($requestsForMyBooks->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Requester</th>
                                        <th>My Book</th>
                                        <th>Offered Book</th>
                                        <th>Duration</th>
                                        <th>Status</th>
                                        <th>Requested</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($requestsForMyBooks as $request)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="mr-2">
                                                    <img src="{{ $request->requester->image ? asset('storage/' . $request->requester->image) : asset('backend/assets/img/avatar/xyz.png') }}"
                                                         alt="{{ $request->requester->name }}"
                                                         style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover;">
                                                </div>
                                                <div>
                                                    <span>{{ $request->requester->name }}</span>
                                                    @if($request->requester->location)
                                                        <br><small class="text-muted">{{ $request->requester->location }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="mr-3">
                                                    <img src="{{ $request->requestedBook->image ? asset('storage/' . $request->requestedBook->image) : asset('backend/assets/img/books/default.png') }}"
                                                         alt="{{ $request->requestedBook->title }}"
                                                         style="width: 40px; height: 50px; object-fit: cover;"
                                                         class="rounded">
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">
                                                        <a href="{{ route('books.show', $request->requestedBook) }}">
                                                            {{ Str::limit($request->requestedBook->title, 25) }}
                                                        </a>
                                                    </h6>
                                                    <small class="text-muted">{{ $request->requestedBook->category->name }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="mr-3">
                                                    <img src="{{ $request->offeredBook->image ? asset('storage/' . $request->offeredBook->image) : asset('backend/assets/img/books/default.png') }}"
                                                         alt="{{ $request->offeredBook->title }}"
                                                         style="width: 40px; height: 50px; object-fit: cover;"
                                                         class="rounded">
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">
                                                        <a href="{{ route('books.show', $request->offeredBook) }}">
                                                            {{ Str::limit($request->offeredBook->title, 25) }}
                                                        </a>
                                                    </h6>
                                                    <small class="text-muted">{{ $request->offeredBook->category->name }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($request->duration_days && $request->duration_type)
                                                <span class="badge badge-info">
                                                    {{ $request->duration_days }} {{ ucfirst($request->duration_type) }}{{ $request->duration_days > 1 ? 's' : '' }}
                                                </span>
                                            @else
                                                <span class="text-muted">Not set</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($request->status === 'pending')
                                                <span class="badge badge-warning"><i class="fas fa-clock"></i> Pending</span>
                                            @elseif($request->status === 'accepted')
                                                <span class="badge badge-success"><i class="fas fa-check"></i> Completed</span>
                                            @elseif($request->status === 'rejected')
                                                <span class="badge badge-danger"><i class="fas fa-times"></i> Rejected</span>
                                            @elseif($request->status === 'cancelled')
                                                <span class="badge badge-secondary"><i class="fas fa-ban"></i> Cancelled</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $request->created_at->format('M d, Y') }}
                                            <br><small class="text-muted">{{ $request->created_at->diffForHumans() }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('swap-requests.show', $request) }}"
                                                   class="btn btn-outline-primary" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                @if($request->status === 'accepted')
                                                    @if($request->invoice)
                                                        <a href="{{ route('invoices.show', $request->invoice) }}"
                                                           class="btn btn-outline-info" title="View Invoice">
                                                            <i class="fas fa-file-invoice"></i>
                                                        </a>
                                                    @endif

                                                    <button type="button" class="btn btn-outline-success"
                                                            onclick="confirmReturn({{ $request->id }})"
                                                            title="Return Books">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                @endif

                                                @if($request->status === 'pending')
                                                    <button type="button" class="btn btn-outline-success"
                                                            onclick="confirmApprove({{ $request->id }})"
                                                            title="Approve Swap">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger"
                                                            data-toggle="modal"
                                                            data-target="#rejectModal{{ $request->id }}"
                                                            title="Reject">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Reject Modal for each request -->
                                    @if($request->status === 'pending')
                                    <div class="modal fade" id="rejectModal{{ $request->id }}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Reject Swap Request</h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('swap-requests.reject', $request) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to reject this swap request from <strong>{{ $request->requester->name }}</strong>?</p>
                                                        <div class="form-group">
                                                            <label for="rejection_reason{{ $request->id }}">Reason (Optional)</label>
                                                            <textarea class="form-control" id="rejection_reason{{ $request->id }}"
                                                                      name="rejection_reason" rows="3"
                                                                      placeholder="Provide a reason for rejection..."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger">Reject Request</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($requestsForMyBooks->hasPages())
                            <div class="mt-4">
                                {{ $requestsForMyBooks->appends(request()->query())->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5>No Swap Requests Yet</h5>
                            <p class="text-muted">No one has requested to swap with your books yet. Make sure your books are approved and available for swap!</p>
                            <a href="{{ route('books.my-books') }}" class="btn btn-primary">
                                <i class="fas fa-book"></i> View My Books
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Hidden forms for actions -->
<form id="approveForm" method="POST" style="display: none;">
    @csrf
</form>

<form id="cancelForm" method="POST" style="display: none;">
    @csrf
</form>

<form id="returnForm" method="POST" style="display: none;">
    @csrf
</form>

<form id="deleteSwapForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<form id="clearSwapHistoryForm" method="POST" action="{{ route('swap-requests.clear-history') }}" style="display: none;">
    @csrf
</form>

@push('scripts')
<script>
function confirmApprove(requestId) {
    if (confirm('Are you sure you want to approve this swap? This will exchange ownership of both books permanently.')) {
        document.getElementById('approveForm').action = '{{ url("/") }}/swap-requests/' + requestId + '/approve';
        document.getElementById('approveForm').submit();
    }
}

function confirmCancel(requestId) {
    if (confirm('Are you sure you want to cancel this swap request?')) {
        document.getElementById('cancelForm').action = '{{ url("/") }}/swap-requests/' + requestId + '/cancel';
        document.getElementById('cancelForm').submit();
    }
}

function confirmReturn(requestId) {
    if (confirm('Are you sure you want to return the books? This will mark the swap as completed.')) {
        document.getElementById('returnForm').action = '{{ url("/") }}/swap-requests/' + requestId + '/return';
        document.getElementById('returnForm').submit();
    }
}

function confirmDeleteSwap(requestId) {
    if (confirm('Are you sure you want to delete this swap request? This action cannot be undone.')) {
        document.getElementById('deleteSwapForm').action = '{{ url("/") }}/swap-requests/' + requestId;
        document.getElementById('deleteSwapForm').submit();
    }
}

function confirmClearSwapHistory() {
    if (confirm('Are you sure you want to clear all completed, cancelled, and rejected swap requests? This action cannot be undone.')) {
        document.getElementById('clearSwapHistoryForm').submit();
    }
}
</script>
@endpush

@endsection
