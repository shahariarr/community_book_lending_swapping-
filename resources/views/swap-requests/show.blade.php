@extends('layouts.back')
@section('title', 'Swap Request Details')
@section('content')

<section class="section">
    <div class="section-header">
        <h1>Swap Request Details</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('swap-requests.index') }}">Swap Requests</a></div>
            <div class="breadcrumb-item active">Request #{{ $swapRequest->id }}</div>
        </div>
    </div>

    <div class="row">
        <!-- Request Details -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-exchange-alt"></i> Swap Request Information</h4>
                </div>
                <div class="card-body">
                    <!-- Status Badge -->
                    <div class="mb-4">
                        <h5>Status:
                            @if($swapRequest->status === 'pending')
                                <span class="badge badge-warning"><i class="fas fa-clock"></i> Pending</span>
                            @elseif($swapRequest->status === 'accepted')
                                <span class="badge badge-success"><i class="fas fa-check"></i> Accepted</span>
                            @elseif($swapRequest->status === 'rejected')
                                <span class="badge badge-danger"><i class="fas fa-times"></i> Rejected</span>
                            @elseif($swapRequest->status === 'completed')
                                <span class="badge badge-info"><i class="fas fa-handshake"></i> Completed</span>
                            @elseif($swapRequest->status === 'cancelled')
                                <span class="badge badge-secondary"><i class="fas fa-ban"></i> Cancelled</span>
                            @endif
                        </h5>
                    </div>

                    <!-- Duration Information -->
                    @if($swapRequest->duration_days && $swapRequest->duration_type)
                    <div class="mb-4">
                        <div class="card border-info">
                            <div class="card-body">
                                <h6><i class="fas fa-calendar-alt"></i> Swap Duration</h6>
                                <p class="mb-0">
                                    <span class="badge badge-info">
                                        {{ $swapRequest->duration_days }} {{ ucfirst($swapRequest->duration_type) }}{{ $swapRequest->duration_days > 1 ? 's' : '' }}
                                    </span>
                                    @if($swapRequest->status === 'accepted')
                                        <br><small class="text-muted">Books should be returned by:
                                            {{ \Carbon\Carbon::parse($swapRequest->approved_at)->add($swapRequest->duration_type, $swapRequest->duration_days)->format('M d, Y') }}
                                        </small>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Books Information -->
                    <div class="row">
                        <!-- Requested Book -->
                        <div class="col-md-6">
                            <div class="card border-primary mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0"><i class="fas fa-book"></i> Requested Book</h6>
                                </div>
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <img src="{{ $swapRequest->requestedBook->image ? asset('storage/' . $swapRequest->requestedBook->image) : asset('backend/assets/img/books/default.png') }}"
                                             alt="{{ $swapRequest->requestedBook->title }}"
                                             class="img-fluid rounded shadow"
                                             style="max-height: 200px;">
                                    </div>
                                    <h5 class="mb-2">{{ $swapRequest->requestedBook->title }}</h5>
                                    <p class="text-muted mb-2">by {{ $swapRequest->requestedBook->author }}</p>

                                    <div class="mb-3">
                                        <p><strong>Category:</strong> <span class="badge badge-primary">{{ $swapRequest->requestedBook->category->name }}</span></p>
                                        <p><strong>Condition:</strong> <span class="badge badge-secondary">{{ ucfirst($swapRequest->requestedBook->condition) }}</span></p>
                                        @if($swapRequest->requestedBook->isbn)
                                            <p><strong>ISBN:</strong> {{ $swapRequest->requestedBook->isbn }}</p>
                                        @endif
                                    </div>

                                    <a href="{{ route('books.show', $swapRequest->requestedBook) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye"></i> View Book
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Offered Book -->
                        <div class="col-md-6">
                            <div class="card border-success mb-4">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0"><i class="fas fa-book"></i> Offered Book</h6>
                                </div>
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <img src="{{ $swapRequest->offeredBook->image ? asset('storage/' . $swapRequest->offeredBook->image) : asset('backend/assets/img/books/default.png') }}"
                                             alt="{{ $swapRequest->offeredBook->title }}"
                                             class="img-fluid rounded shadow"
                                             style="max-height: 200px;">
                                    </div>
                                    <h5 class="mb-2">{{ $swapRequest->offeredBook->title }}</h5>
                                    <p class="text-muted mb-2">by {{ $swapRequest->offeredBook->author }}</p>

                                    <div class="mb-3">
                                        <p><strong>Category:</strong> <span class="badge badge-success">{{ $swapRequest->offeredBook->category->name }}</span></p>
                                        <p><strong>Condition:</strong> <span class="badge badge-secondary">{{ ucfirst($swapRequest->offeredBook->condition) }}</span></p>
                                        @if($swapRequest->offeredBook->isbn)
                                            <p><strong>ISBN:</strong> {{ $swapRequest->offeredBook->isbn }}</p>
                                        @endif
                                    </div>

                                    <a href="{{ route('books.show', $swapRequest->offeredBook) }}" class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-eye"></i> View Book
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Participants Information -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6><i class="fas fa-user"></i> Requester Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="{{ $swapRequest->requester->image ? asset('storage/' . $swapRequest->requester->image) : asset('backend/assets/img/avatar/xyz.png') }}"
                                             alt="{{ $swapRequest->requester->name }}"
                                             style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;"
                                             class="mr-3">
                                        <div>
                                            <h6 class="mb-1">{{ $swapRequest->requester->name }}</h6>
                                            @if($swapRequest->requester->location)
                                                <small class="text-muted"><i class="fas fa-map-marker-alt"></i> {{ $swapRequest->requester->location }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    @if($swapRequest->requester->bio)
                                        <p class="text-muted small">{{ Str::limit($swapRequest->requester->bio, 100) }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6><i class="fas fa-user-tie"></i> Book Owner Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="{{ $swapRequest->owner->image ? asset('storage/' . $swapRequest->owner->image) : asset('backend/assets/img/avatar/xyz.png') }}"
                                             alt="{{ $swapRequest->owner->name }}"
                                             style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;"
                                             class="mr-3">
                                        <div>
                                            <h6 class="mb-1">{{ $swapRequest->owner->name }}</h6>
                                            @if($swapRequest->owner->location)
                                                <small class="text-muted"><i class="fas fa-map-marker-alt"></i> {{ $swapRequest->owner->location }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    @if($swapRequest->owner->bio)
                                        <p class="text-muted small">{{ Str::limit($swapRequest->owner->bio, 100) }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Message -->
                    @if($swapRequest->message)
                        <div class="card mt-4">
                            <div class="card-header">
                                <h6><i class="fas fa-comment"></i> Requester's Message</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $swapRequest->message }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Owner Response -->
                    @if($swapRequest->rejection_reason)
                        <div class="card mt-4">
                            <div class="card-header">
                                <h6><i class="fas fa-reply"></i> Owner's Response</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $swapRequest->rejection_reason }}</p>
                                @if($swapRequest->responded_at)
                                    <small class="text-muted">Responded on {{ $swapRequest->responded_at->format('M d, Y h:i A') }}</small>
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
                                <p class="timeline-text">{{ $swapRequest->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>

                        <!-- Status Updates -->
                        @if($swapRequest->status === 'accepted' && $swapRequest->responded_at)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Request Accepted</h6>
                                    <p class="timeline-text">{{ $swapRequest->responded_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                        @elseif($swapRequest->status === 'rejected' && $swapRequest->responded_at)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-danger"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Request Rejected</h6>
                                    <p class="timeline-text">{{ $swapRequest->responded_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($swapRequest->status === 'completed' && $swapRequest->completed_at)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-info"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Swap Completed</h6>
                                    <p class="timeline-text">{{ $swapRequest->completed_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($swapRequest->status === 'cancelled' && $swapRequest->cancelled_at)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-secondary"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Request Cancelled</h6>
                                    <p class="timeline-text">{{ $swapRequest->cancelled_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Invoice Section for Accepted Swaps -->
            @if($swapRequest->status === 'accepted' && $swapRequest->invoice)
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-file-invoice"></i> Invoice</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <h6>Invoice #{{ $swapRequest->invoice->invoice_number }}</h6>
                            <p class="text-muted">Generated on {{ $swapRequest->invoice->created_at->format('M d, Y') }}</p>
                        </div>

                        <div class="btn-group btn-block" role="group">
                            <a href="{{ route('invoices.show', $swapRequest->invoice) }}"
                               class="btn btn-primary">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <a href="{{ route('invoices.download', $swapRequest->invoice) }}"
                               class="btn btn-info">
                                <i class="fas fa-download"></i> Download
                            </a>
                            <a href="{{ route('invoices.print', $swapRequest->invoice) }}"
                               class="btn btn-success" target="_blank">
                                <i class="fas fa-print"></i> Print
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Return Section for Active Swaps -->
            @if($swapRequest->status === 'accepted' && ($swapRequest->owner_id === Auth::id() || $swapRequest->requester_id === Auth::id()))
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-undo"></i> Return Books</h4>
                    </div>
                    <div class="card-body">
                        @if($swapRequest->duration_days && $swapRequest->duration_type)
                            @php
                                $returnDate = \Carbon\Carbon::parse($swapRequest->approved_at)->add($swapRequest->duration_type, $swapRequest->duration_days);
                                $isOverdue = $returnDate->isPast();
                                $daysLeft = $returnDate->diffInDays(now(), false);
                            @endphp

                            <div class="text-center mb-3">
                                @if($isOverdue)
                                    <div class="alert alert-danger">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Overdue by {{ abs($daysLeft) }} day{{ abs($daysLeft) > 1 ? 's' : '' }}
                                    </div>
                                @else
                                    <div class="alert alert-info">
                                        <i class="fas fa-clock"></i>
                                        {{ $daysLeft }} day{{ $daysLeft > 1 ? 's' : '' }} remaining
                                    </div>
                                @endif
                            </div>
                        @endif

                        <form action="{{ route('swap-requests.return', $swapRequest) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-block"
                                    onclick="return confirm('Are you sure you want to return the books? This will complete the swap.')">
                                <i class="fas fa-undo"></i> Return Books
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Actions -->
            @if($swapRequest->owner_id === Auth::id() && $swapRequest->status === 'pending')
                <!-- Owner Actions -->
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-cog"></i> Actions</h4>
                    </div>
                    <div class="card-body">
                        <!-- Approve Form -->
                        <form action="{{ route('swap-requests.approve', $swapRequest) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-success btn-block" onclick="return confirm('Are you sure you want to approve this swap request? Books will be exchanged immediately.')">
                                <i class="fas fa-handshake"></i> Accept Swap
                            </button>
                        </form>

                        <!-- Reject Form -->
                        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#rejectModal">
                            <i class="fas fa-times"></i> Reject Request
                        </button>
                    </div>
                </div>
            @elseif($swapRequest->requester_id === Auth::id() && $swapRequest->status === 'pending')
                <!-- Requester Actions -->
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-cog"></i> Actions</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('swap-requests.cancel', $swapRequest) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-secondary btn-block" onclick="return confirm('Are you sure you want to cancel this request?')">
                                <i class="fas fa-ban"></i> Cancel Request
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Navigation -->
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('swap-requests.index') }}" class="btn btn-outline-secondary btn-block">
                        <i class="fas fa-arrow-left"></i> Back to Swap Requests
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Reject Modal -->
@if($swapRequest->owner_id === Auth::id() && $swapRequest->status === 'pending')
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Reject Swap Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('swap-requests.reject', $swapRequest) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="rejection_reason">Reason for Rejection (Optional)</label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3"
                                  placeholder="Let the requester know why you're rejecting this swap..."></textarea>
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
