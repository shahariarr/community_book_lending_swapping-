@extends('layouts.back')
@section('title', 'Book Details')
@section('content')

<section class="section">
    <div class="section-header">
        <h1>Book Details</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.books.all') }}">All Books</a></div>
            <div class="breadcrumb-item active">{{ $book->title }}</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="{{ $book->image ? asset('storage/' . $book->image) : asset('backend/assets/img/book-placeholder.jpg') }}"
                             alt="Book Cover" class="img-fluid rounded mb-3" style="max-height: 300px;">

                        <h5>{{ $book->title }}</h5>
                        <p class="text-muted">by {{ $book->author }}</p>

                        <div class="mb-3">
                            <span class="badge badge-{{ $book->condition === 'new' ? 'success' : ($book->condition === 'like_new' ? 'primary' : ($book->condition === 'good' ? 'warning' : 'secondary')) }} mr-1">
                                {{ ucfirst(str_replace('_', ' ', $book->condition)) }}
                            </span>
                            <span class="badge badge-info">{{ $book->category->name }}</span>
                        </div>

                        @if(!$book->is_approved)
                            <div class="alert alert-warning">
                                <strong>Pending Approval</strong><br>
                                This book is waiting for admin approval.
                            </div>

            @can('approve-book')
                <form action="{{ route('admin.books.approve', $book) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success mr-2">
                        <i class="fas fa-check"></i> Approve Book
                    </button>
                </form>
            @endcan                            @can('reject-book')
                                <button class="btn btn-danger" data-toggle="modal" data-target="#rejectModal">
                                    <i class="fas fa-times"></i> Reject Book
                                </button>
                            @endcan
                        @else
                            <div class="alert alert-success">
                                <strong>Approved</strong><br>
                                Approved by {{ $book->approvedBy->name }} on {{ $book->approved_at->format('M d, Y') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Book Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="40%">Title:</th>
                                        <td>{{ $book->title }}</td>
                                    </tr>
                                    <tr>
                                        <th>Author:</th>
                                        <td>{{ $book->author }}</td>
                                    </tr>
                                    <tr>
                                        <th>ISBN:</th>
                                        <td>{{ $book->isbn ?? 'Not provided' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Category:</th>
                                        <td>{{ $book->category->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Condition:</th>
                                        <td>{{ ucfirst(str_replace('_', ' ', $book->condition)) }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="40%">Status:</th>
                                        <td>
                                            @if($book->is_approved)
                                                <span class="badge badge-success">Approved</span>
                                                @if($book->status === 'available')
                                                    <span class="badge badge-primary">Available</span>
                                                @elseif($book->status === 'borrowed')
                                                    <span class="badge badge-warning">Borrowed</span>
                                                @elseif($book->status === 'swapped')
                                                    <span class="badge badge-info">Swapped</span>
                                                @endif
                                            @else
                                                <span class="badge badge-warning">Pending Approval</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Uploaded:</th>
                                        <td>{{ $book->created_at->format('M d, Y g:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Owner:</th>
                                        <td>
                                            <a href="{{ route('admin.users.show', $book->user) }}">{{ $book->user->name }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Loan Type:</th>
                                        <td>
                                            @if($book->is_borrowable)
                                                <span class="badge badge-info">Borrowable</span>
                                            @endif
                                            @if($book->is_swappable)
                                                <span class="badge badge-success">Swappable</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if($book->description)
                            <div class="mt-3">
                                <h6>Description:</h6>
                                <p>{{ $book->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Loan Requests for this Book -->
                @if($book->loanRequests->isNotEmpty())
                    <div class="card">
                        <div class="card-header">
                            <h4>Loan Requests</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Borrower</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Status</th>
                                            <th>Requested</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($book->loanRequests as $loanRequest)
                                            <tr>
                                                <td>{{ $loanRequest->borrower->name }}</td>
                                                <td>{{ $loanRequest->start_date->format('M d, Y') }}</td>
                                                <td>{{ $loanRequest->end_date->format('M d, Y') }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $loanRequest->status === 'approved' ? 'success' : ($loanRequest->status === 'pending' ? 'warning' : 'danger') }}">
                                                        {{ ucfirst($loanRequest->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $loanRequest->created_at->format('M d, Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Swap Requests for this Book -->
                @if($book->swapRequestsAsRequested->isNotEmpty())
                    <div class="card">
                        <div class="card-header">
                            <h4>Swap Requests</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Requester</th>
                                            <th>Offered Book</th>
                                            <th>Status</th>
                                            <th>Requested</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($book->swapRequestsAsRequested as $swapRequest)
                                            <tr>
                                                <td>{{ $swapRequest->requester->name }}</td>
                                                <td>{{ $swapRequest->offeredBook->title }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $swapRequest->status === 'approved' ? 'success' : ($swapRequest->status === 'pending' ? 'warning' : 'danger') }}">
                                                        {{ ucfirst($swapRequest->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $swapRequest->created_at->format('M d, Y') }}</td>
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

<!-- Reject Modal -->
@if(!$book->is_approved)
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reject Book</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.books.reject', $book) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>Are you sure you want to reject "<strong>{{ $book->title }}</strong>"?</p>
                        <div class="form-group">
                            <label>Rejection Reason</label>
                            <textarea class="form-control" name="rejection_reason" rows="3" required
                                      placeholder="Please provide a reason for rejection..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Reject Book</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

@endsection
