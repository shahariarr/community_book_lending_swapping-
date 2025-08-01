@extends('layouts.back')
@section('title', 'Loan Requests')
@section('content')

<section class="section">
    <div class="section-header">
        <h1>Loan Requests</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active">Loan Requests</div>
        </div>
    </div>



    <!-- Requests I Made -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-hand-holding"></i> My Loan Requests</h4>
                    <div class="card-header-action">
                        <span class="badge badge-primary">{{ $myRequests->total() }} Total</span>
                        <button type="button" class="btn btn-outline-danger btn-sm ml-2"
                                onclick="confirmClearHistory()"
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
                                        <th>Book</th>
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
                                                    <img src="{{ $request->book->image ? asset('storage/' . $request->book->image) : asset('backend/assets/img/books/default.png') }}"
                                                         alt="{{ $request->book->title }}"
                                                         style="width: 40px; height: 50px; object-fit: cover;"
                                                         class="rounded">
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">
                                                        <a href="{{ route('books.show', $request->book) }}">
                                                            {{ Str::limit($request->book->title, 30) }}
                                                        </a>
                                                    </h6>
                                                    <small class="text-muted">by {{ $request->book->author }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="mr-2">
                                                    <img src="{{ $request->book->user->image ? asset('storage/' . $request->book->user->image) : asset('backend/assets/img/avatar/xyz.png') }}"
                                                         alt="{{ $request->book->user->name }}"
                                                         style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover;">
                                                </div>
                                                <span>{{ $request->book->user->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $request->duration_days }} days
                                            @if($request->status === 'accepted' && $request->loan_end_date)
                                                <br><small class="text-muted">
                                                    Due: {{ $request->loan_end_date->format('M d, Y') }}
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($request->status === 'pending')
                                                <span class="badge badge-warning"><i class="fas fa-clock"></i> Pending</span>
                                            @elseif($request->status === 'accepted')
                                                <span class="badge badge-success"><i class="fas fa-check"></i> Accepted</span>
                                            @elseif($request->status === 'rejected')
                                                <span class="badge badge-danger"><i class="fas fa-times"></i> Rejected</span>
                                            @elseif($request->status === 'returned')
                                                <span class="badge badge-info"><i class="fas fa-undo"></i> Returned</span>
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
                                                <a href="{{ route('loan-requests.show', $request) }}"
                                                   class="btn btn-outline-primary" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($request->status === 'accepted' && $request->invoice)
                                                    <a href="{{ route('invoices.show', $request->invoice) }}"
                                                       class="btn btn-outline-info" title="View Invoice">
                                                        <i class="fas fa-file-invoice"></i>
                                                    </a>
                                                    <a href="{{ route('invoices.download', $request->invoice) }}"
                                                       class="btn btn-outline-success" title="Download Invoice">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                @endif
                                                @if($request->status === 'pending')
                                                    <button type="button" class="btn btn-outline-danger"
                                                            onclick="confirmCancel('{{ route('loan-requests.cancel', $request->id) }}')"
                                                            title="Cancel Request">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                @endif
                                                @if(in_array($request->status, ['completed', 'cancelled', 'rejected']))
                                                    <button type="button" class="btn btn-outline-secondary"
                                                            onclick="confirmDelete({{ $request->id }})"
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
                            <i class="fas fa-hand-holding fa-3x text-muted mb-3"></i>
                            <h5>No Loan Requests Yet</h5>
                            <p class="text-muted">You haven't made any loan requests yet. Browse books to start borrowing!</p>
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
                    <h4><i class="fas fa-inbox"></i> Requests for My Books</h4>
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
                                        <th>Borrower</th>
                                        <th>Book</th>
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
                                                    <img src="{{ $request->borrower->image ? asset('storage/' . $request->borrower->image) : asset('backend/assets/img/avatar/xyz.png') }}"
                                                         alt="{{ $request->borrower->name }}"
                                                         style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover;">
                                                </div>
                                                <div>
                                                    <span>{{ $request->borrower->name }}</span>
                                                    @if($request->borrower->location)
                                                        <br><small class="text-muted">{{ $request->borrower->location }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="mr-3">
                                                    <img src="{{ $request->book->image ? asset('storage/' . $request->book->image) : asset('backend/assets/img/books/default.png') }}"
                                                         alt="{{ $request->book->title }}"
                                                         style="width: 40px; height: 50px; object-fit: cover;"
                                                         class="rounded">
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">
                                                        <a href="{{ route('books.show', $request->book) }}">
                                                            {{ Str::limit($request->book->title, 30) }}
                                                        </a>
                                                    </h6>
                                                    <small class="text-muted">{{ $request->book->category->name }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $request->duration_days }} days
                                            @if($request->status === 'accepted' && $request->loan_end_date)
                                                <br><small class="text-muted">
                                                    Due: {{ $request->loan_end_date->format('M d, Y') }}
                                                </small>
                                                @if($request->loan_end_date->isPast())
                                                    <br><span class="badge badge-danger badge-sm">Overdue</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if($request->status === 'pending')
                                                <span class="badge badge-warning"><i class="fas fa-clock"></i> Pending</span>
                                            @elseif($request->status === 'accepted')
                                                <span class="badge badge-success"><i class="fas fa-check"></i> Accepted</span>
                                            @elseif($request->status === 'rejected')
                                                <span class="badge badge-danger"><i class="fas fa-times"></i> Rejected</span>
                                            @elseif($request->status === 'returned')
                                                <span class="badge badge-info"><i class="fas fa-undo"></i> Returned</span>
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
                                                <a href="{{ route('loan-requests.show', $request) }}"
                                                   class="btn btn-outline-primary" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($request->status === 'accepted' && $request->invoice)
                                                    <a href="{{ route('invoices.show', $request->invoice) }}"
                                                       class="btn btn-outline-info" title="View Invoice">
                                                        <i class="fas fa-file-invoice"></i>
                                                    </a>
                                                    <a href="{{ route('invoices.download', $request->invoice) }}"
                                                       class="btn btn-outline-success" title="Download Invoice">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                @endif
                                                @if($request->status === 'pending')
                                                    <button type="button" class="btn btn-outline-success"
                                                            onclick="confirmApprove('{{ route('loan-requests.approve', $request->id) }}')"
                                                            title="Approve">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger"
                                                            data-toggle="modal"
                                                            data-target="#rejectModal{{ $request->id }}"
                                                            title="Reject">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                @elseif($request->status === 'accepted')
                                                    <button type="button" class="btn btn-outline-info"
                                                            onclick="confirmReturn('{{ route('loan-requests.return', $request->id) }}')"
                                                            title="Mark as Returned">
                                                        <i class="fas fa-undo"></i>
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
                                                    <h5 class="modal-title">Reject Loan Request</h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('loan-requests.reject', $request) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to reject this loan request from <strong>{{ $request->borrower->name }}</strong>?</p>
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
                            <h5>No Requests Yet</h5>
                            <p class="text-muted">No one has requested to borrow your books yet. Make sure your books are Accepted and visible!</p>
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

<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<form id="clearHistoryForm" method="POST" action="{{ route('loan-requests.clear-history') }}" style="display: none;">
    @csrf
</form>

@push('scripts')
<script>
function confirmApprove(actionUrl) {
    if (confirm('Are you sure you want to approve this loan request? This will generate an invoice.')) {
        document.getElementById('approveForm').action = actionUrl;
        document.getElementById('approveForm').submit();
    }
}

function confirmCancel(actionUrl) {
    if (confirm('Are you sure you want to cancel this loan request?')) {
        document.getElementById('cancelForm').action = actionUrl;
        document.getElementById('cancelForm').submit();
    }
}

function confirmReturn(actionUrl) {
    if (confirm('Are you sure the book has been returned and is in good condition?')) {
        document.getElementById('returnForm').action = actionUrl;
        document.getElementById('returnForm').submit();
    }
}

function confirmDelete(requestId) {
    if (confirm('Are you sure you want to delete this loan request? This action cannot be undone.')) {
        document.getElementById('deleteForm').action = '{{ url("/") }}/loan-requests/' + requestId;
        document.getElementById('deleteForm').submit();
    }
}

function confirmClearHistory() {
    if (confirm('Are you sure you want to clear all completed, cancelled, and rejected loan requests? This action cannot be undone.')) {
        document.getElementById('clearHistoryForm').submit();
    }
}

// Show invoice notification if invoice was generated
@if(session('invoice_generated') && session('invoice_id'))
    $(document).ready(function() {
        setTimeout(function() {
            if (confirm('Invoice has been generated successfully! Would you like to view it now?')) {
                window.open('{{ route("invoices.show", session("invoice_id")) }}', '_blank');
            }
        }, 1000);
    });
@endif
</script>
@endpush

@endsection
