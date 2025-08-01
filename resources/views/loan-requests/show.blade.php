@extends('layouts.back')
@section('title', 'Loan Request Details')
@section('content')

<section class="section">
    <div class="section-header">
        <h1>Loan Request Details</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('loan-requests.index') }}">Loan Requests</a></div>
            <div class="breadcrumb-item active">Request #{{ $loanRequest->id }}</div>
        </div>
    </div>



    <div class="row">
        <!-- Request Details -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-hand-holding"></i> Loan Request Information</h4>
                </div>
                <div class="card-body">
                    <!-- Status Badge -->
                    <div class="mb-4">
                        <h5>Status:
                            @if($loanRequest->status === 'pending')
                                <span class="badge badge-warning"><i class="fas fa-clock"></i> Pending</span>
                            @elseif($loanRequest->status === 'accepted')
                                <span class="badge badge-success"><i class="fas fa-check"></i> Accepted</span>
                            @elseif($loanRequest->status === 'rejected')
                                <span class="badge badge-danger"><i class="fas fa-times"></i> Rejected</span>
                            @elseif($loanRequest->status === 'returned')
                                <span class="badge badge-info"><i class="fas fa-undo"></i> Returned</span>
                            @elseif($loanRequest->status === 'cancelled')
                                <span class="badge badge-secondary"><i class="fas fa-ban"></i> Cancelled</span>
                            @endif
                        </h5>
                    </div>

                    <!-- Book Information -->
                    <div class="card border-primary mb-4">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0"><i class="fas fa-book"></i> Book Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <img src="{{ $loanRequest->book->image ? asset('storage/' . $loanRequest->book->image) : asset('backend/assets/img/books/default.png') }}"
                                         alt="{{ $loanRequest->book->title }}"
                                         class="img-fluid rounded shadow"
                                         style="max-height: 200px;">
                                </div>
                                <div class="col-md-9">
                                    <h5 class="mb-2">{{ $loanRequest->book->title }}</h5>
                                    <p class="text-muted mb-2">by {{ $loanRequest->book->author }}</p>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p><strong>Category:</strong> <span class="badge badge-primary">{{ $loanRequest->book->category->name }}</span></p>
                                            <p><strong>Condition:</strong> <span class="badge badge-secondary">{{ $loanRequest->book->formatted_condition }}</span></p>
                                        </div>
                                        <div class="col-sm-6">
                                            @if($loanRequest->book->isbn)
                                                <p><strong>ISBN:</strong> {{ $loanRequest->book->isbn }}</p>
                                            @endif
                                            @if($loanRequest->book->language)
                                                <p><strong>Language:</strong> {{ $loanRequest->book->language }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <a href="{{ route('books.show', $loanRequest->book) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye"></i> View Book
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Request Details -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6><i class="fas fa-user"></i> Borrower Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="{{ $loanRequest->borrower->image ? asset('storage/' . $loanRequest->borrower->image) : asset('backend/assets/img/avatar/xyz.png') }}"
                                             alt="{{ $loanRequest->borrower->name }}"
                                             style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;"
                                             class="mr-3">
                                        <div>
                                            <h6 class="mb-1">{{ $loanRequest->borrower->name }}</h6>
                                            @if($loanRequest->borrower->location)
                                                <small class="text-muted"><i class="fas fa-map-marker-alt"></i> {{ $loanRequest->borrower->location }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    @if($loanRequest->borrower->bio)
                                        <p class="text-muted small">{{ Str::limit($loanRequest->borrower->bio, 100) }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6><i class="fas fa-calendar-alt"></i> Loan Duration</h6>
                                </div>
                                <div class="card-body">
                                    <p><strong>Requested Start:</strong> {{ $loanRequest->requested_start_date->format('M d, Y') }}</p>
                                    <p><strong>Requested End:</strong> {{ $loanRequest->requested_end_date->format('M d, Y') }}</p>
                                    <p><strong>Duration:</strong> {{ $loanRequest->requested_start_date->diffInDays($loanRequest->requested_end_date) }} days</p>

                                    @if($loanRequest->status === 'accepted' && $loanRequest->actual_start_date)
                                        <hr>
                                        <p><strong>Actual Start:</strong> {{ $loanRequest->actual_start_date->format('M d, Y') }}</p>
                                        <p><strong>Actual End:</strong> {{ $loanRequest->actual_end_date->format('M d, Y') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Message -->
                    @if($loanRequest->message)
                        <div class="card mt-4">
                            <div class="card-header">
                                <h6><i class="fas fa-comment"></i> Borrower's Message</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $loanRequest->message }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Lender Response -->
                    @if($loanRequest->lender_response)
                        <div class="card mt-4">
                            <div class="card-header">
                                <h6><i class="fas fa-reply"></i> Lender's Response</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $loanRequest->lender_response }}</p>
                                @if($loanRequest->responded_at)
                                    <small class="text-muted">Responded on {{ $loanRequest->responded_at->format('M d, Y h:i A') }}</small>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions Sidebar -->
        <div class="col-lg-4">
            <!-- Timeline -->
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-history"></i> Request Timeline</h4>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <!-- Request Created -->
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Request Created</h6>
                                <p class="timeline-text">{{ $loanRequest->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>

                        <!-- Status Updates -->
                        @if($loanRequest->status === 'accepted' && $loanRequest->responded_at)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Request Accepted</h6>
                                    <p class="timeline-text">{{ $loanRequest->responded_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                        @elseif($loanRequest->status === 'rejected' && $loanRequest->responded_at)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-danger"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Request Rejected</h6>
                                    <p class="timeline-text">{{ $loanRequest->responded_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($loanRequest->status === 'returned' && $loanRequest->returned_date)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-info"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Book Returned</h6>
                                    <p class="timeline-text">{{ $loanRequest->returned_date->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actions -->
            @if($loanRequest->lender_id === Auth::id() && $loanRequest->status === 'pending')
                <!-- Lender Actions -->
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-cog"></i> Actions</h4>
                    </div>
                    <div class="card-body">
                        <!-- Approve Form -->
                        <form action="{{ route('loan-requests.approve', $loanRequest) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-success btn-block" onclick="return confirm('Are you sure you want to approve this loan request?')">
                                <i class="fas fa-check"></i> Accept Request
                            </button>
                        </form>

                        <!-- Reject Form -->
                        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#rejectModal">
                            <i class="fas fa-times"></i> Reject Request
                        </button>
                    </div>
                </div>
            @elseif($loanRequest->borrower_id === Auth::id() && $loanRequest->status === 'pending')
                <!-- Borrower Actions -->
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-cog"></i> Actions</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('loan-requests.cancel', $loanRequest) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-secondary btn-block" onclick="return confirm('Are you sure you want to cancel this request?')">
                                <i class="fas fa-ban"></i> Cancel Request
                            </button>
                        </form>
                    </div>
                </div>
            @elseif($loanRequest->lender_id === Auth::id() && $loanRequest->status === 'accepted')
                <!-- Mark as Returned -->
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-undo"></i> Mark as Returned</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('loan-requests.return', $loanRequest) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-info btn-block" onclick="return confirm('Has the book been returned?')">
                                <i class="fas fa-undo"></i> Mark as Returned
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Invoice Section -->
            @if($loanRequest->status === 'accepted' && $loanRequest->invoice)
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-file-invoice"></i> Invoice</h4>
                    </div>
                    <div class="card-body">
                        <p class="mb-3">
                            <strong>Invoice #:</strong> {{ $loanRequest->invoice->invoice_number }}<br>
                            <small class="text-muted">Generated: {{ $loanRequest->invoice->generated_at->format('M d, Y g:i A') }}</small>
                        </p>
                        <div class="btn-group-vertical w-100">
                            <a href="{{ route('invoices.show', $loanRequest->invoice) }}" class="btn btn-primary mb-2">
                                <i class="fas fa-eye"></i> View Invoice
                            </a>
                            <a href="{{ route('invoices.download', $loanRequest->invoice) }}" class="btn btn-success mb-2">
                                <i class="fas fa-download"></i> Download PDF
                            </a>
                            <a href="{{ route('invoices.print', $loanRequest->invoice) }}" class="btn btn-outline-primary" target="_blank">
                                <i class="fas fa-print"></i> Print Invoice
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Navigation -->
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('loan-requests.index') }}" class="btn btn-outline-secondary btn-block">
                        <i class="fas fa-arrow-left"></i> Back to Loan Requests
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Reject Modal -->
@if($loanRequest->lender_id === Auth::id() && $loanRequest->status === 'pending')
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Reject Loan Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('loan-requests.reject', $loanRequest) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="rejection_reason">Reason for Rejection (Optional)</label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3"
                                  placeholder="Let the borrower know why you're rejecting this request..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times"></i> Reject Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 0.5rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 1.5rem;
}

.timeline-marker {
    position: absolute;
    left: -1.25rem;
    width: 0.75rem;
    height: 0.75rem;
    border-radius: 50%;
    border: 2px solid #fff;
}

.timeline-content {
    background: #f8f9fa;
    padding: 0.75rem;
    border-radius: 0.25rem;
    border-left: 3px solid #007bff;
}

.timeline-title {
    margin-bottom: 0.25rem;
    font-size: 0.875rem;
    font-weight: 600;
}

.timeline-text {
    margin-bottom: 0;
    font-size: 0.75rem;
    color: #6c757d;
}
</style>
@endpush
