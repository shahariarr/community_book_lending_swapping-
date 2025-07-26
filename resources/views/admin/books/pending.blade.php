@extends('layouts.back')
@section('title', 'Pending Book Approvals')
@section('content')

<section class="section">
    <div class="section-header">
        <h1>Pending Book Approvals</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></div>
            <div class="breadcrumb-item active">Pending Books</div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Books Awaiting Approval</h4>
                    <div class="card-header-action">
                        <span class="badge badge-warning">{{ $books->total() }} Pending</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($books->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Book Details</th>
                                        <th>Category</th>
                                        <th>Condition</th>
                                        <th>User</th>
                                        <th>Submitted</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($books as $book)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="mr-3">
                                                    <img src="{{ $book->image ? asset('storage/' . $book->image) : asset('backend/assets/img/books/default.png') }}"
                                                         alt="{{ $book->title }}"
                                                         style="width: 50px; height: 60px; object-fit: cover;"
                                                         class="rounded">
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $book->title }}</h6>
                                                    <small class="text-muted">by {{ $book->author }}</small>
                                                    @if($book->isbn)
                                                        <br><small class="text-muted">ISBN: {{ $book->isbn }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">{{ $book->category->name }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-secondary">{{ $book->formatted_condition }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="mr-2">
                                                    <img src="{{ $book->user->image ? asset('storage/' . $book->user->image) : asset('backend/assets/img/avatar/xyz.png') }}"
                                                         alt="{{ $book->user->name }}"
                                                         style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover;">
                                                </div>
                                                <div>
                                                    <span>{{ $book->user->name }}</span>
                                                    <br><small class="text-muted">{{ $book->user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $book->created_at->format('M d, Y') }}
                                            <br><small class="text-muted">{{ $book->created_at->diffForHumans() }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('admin.books.show', $book) }}"
                                                   class="btn btn-outline-primary" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-success"
                                                        onclick="confirmApprove({{ $book->id }}, '{{ $book->title }}')"
                                                        title="Approve">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-danger"
                                                        data-toggle="modal"
                                                        data-target="#rejectModal{{ $book->id }}"
                                                        title="Reject">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Reject Modal for each book -->
                                    <div class="modal fade" id="rejectModal{{ $book->id }}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Reject Book Submission</h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('admin.books.reject', $book) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to reject "<strong>{{ $book->title }}</strong>" by {{ $book->user->name }}?</p>
                                                        <div class="alert alert-warning">
                                                            <strong>Warning:</strong> This will permanently delete the book submission.
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="rejection_reason{{ $book->id }}">Reason for Rejection <span class="text-danger">*</span></label>
                                                            <textarea class="form-control" id="rejection_reason{{ $book->id }}"
                                                                      name="rejection_reason" rows="3" required
                                                                      placeholder="Please provide a detailed reason for rejection..."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger">Reject & Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($books->hasPages())
                            <div class="mt-4">
                                {{ $books->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                            <h5>All Caught Up!</h5>
                            <p class="text-muted">There are no books pending approval at the moment.</p>
                            <a href="{{ route('admin.books.all') }}" class="btn btn-primary">
                                <i class="fas fa-book"></i> View All Books
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Hidden form for approvals -->
<form id="approveForm" method="POST" style="display: none;">
    @csrf
    @method('PATCH')
</form>

@push('scripts')
<script>
function confirmApprove(bookId, bookTitle) {
    if (confirm(`Are you sure you want to approve "${bookTitle}"? This will make it visible to all users.`)) {
        const baseUrl = '{{ route("admin.books.approve", ":id") }}';
        document.getElementById('approveForm').action = baseUrl.replace(':id', bookId);
        document.getElementById('approveForm').submit();
    }
}
</script>
@endpush

@endsection
