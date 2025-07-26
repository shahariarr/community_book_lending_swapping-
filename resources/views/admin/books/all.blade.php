@extends('layouts.back')
@section('title', 'All Books')
@section('content')

<section class="section">
    <div class="section-header">
        <h1>All Books</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></div>
            <div class="breadcrumb-item active">All Books</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>All Books in System</h4>
                <div class="card-header-action">
                    <span class="badge badge-primary">{{ $books->total() }} Total Books</span>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Book</th>
                                <th>Owner</th>
                                <th>Category</th>
                                <th>Condition</th>
                                <th>Status</th>
                                <th>Approved By</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($books as $book)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $book->image ? asset('storage/' . $book->image) : asset('backend/assets/img/book-placeholder.jpg') }}"
                                                 alt="Book Cover" class="rounded mr-2" style="width: 50px; height: 60px; object-fit: cover;">
                                            <div>
                                                <strong>{{ $book->title }}</strong><br>
                                                <small class="text-muted">by {{ $book->author }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $book->user->profile_image ? asset('storage/' . $book->user->profile_image) : asset('backend/assets/img/avatar/avatar-1.png') }}"
                                                 alt="Avatar" class="rounded-circle mr-2" style="width: 30px; height: 30px;">
                                            <div>
                                                <strong>{{ $book->user->name }}</strong><br>
                                                <small class="text-muted">{{ $book->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ $book->category->name }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $book->condition === 'new' ? 'success' : ($book->condition === 'like_new' ? 'primary' : ($book->condition === 'good' ? 'warning' : 'secondary')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $book->condition)) }}
                                        </span>
                                    </td>
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
                                    <td>
                                        @if($book->approvedBy)
                                            <small>{{ $book->approvedBy->name }}</small><br>
                                            <small class="text-muted">{{ $book->approved_at->format('M d, Y') }}</small>
                                        @else
                                            <span class="text-muted">Not approved</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $book->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('admin.books.show', $book) }}">
                                                    <i class="fas fa-eye"></i> View Details
                                                </a>
                                                <a class="dropdown-item" href="{{ route('books.show', $book) }}">
                                                    <i class="fas fa-external-link-alt"></i> View Public
                                                </a>
                                                @if(!$book->is_approved)
                                                    <div class="dropdown-divider"></div>
                                                    @can('approve-book')
                                                        <form action="{{ route('admin.books.approve', $book) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="dropdown-item text-success">
                                                                <i class="fas fa-check"></i> Approve
                                                            </button>
                                                        </form>
                                                    @endcan
                                                    @can('reject-book')
                                                        <button class="dropdown-item text-danger" data-toggle="modal" data-target="#rejectModal{{ $book->id }}">
                                                            <i class="fas fa-times"></i> Reject
                                                        </button>
                                                    @endcan
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Reject Modal -->
                                @if(!$book->is_approved)
                                    <div class="modal fade" id="rejectModal{{ $book->id }}" tabindex="-1" role="dialog">
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
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <div class="empty-state" data-height="400">
                                            <div class="empty-state-icon">
                                                <i class="fas fa-book"></i>
                                            </div>
                                            <h2>No Books Found</h2>
                                            <p class="lead">No books have been uploaded to the system yet.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($books->hasPages())
                    <div class="card-footer">
                        {{ $books->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection
