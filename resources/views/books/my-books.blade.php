@extends('layouts.back')
@section('title', 'My Books')
@section('content')

<section class="section">
    <div class="section-header">
        <h1>My Books</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active">My Books</div>
        </div>
        <div class="section-header-button">
            <a href="{{ route('books.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Upload New Book
            </a>
        </div>
    </div>



    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Book Collection Overview</h4>
                </div>
                <div class="card-body">
                    @if($books->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Book</th>
                                        <th>Category</th>
                                        <th>Condition</th>
                                        <th>Availability</th>
                                        <th>Status</th>
                                        <th>Requests</th>
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
                                            <span class="badge badge-outline-primary">{{ $book->category->name }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-secondary">{{ $book->formatted_condition }}</span>
                                        </td>
                                        <td>
                                            @if($book->availability_type === 'loan')
                                                <span class="badge badge-success"><i class="fas fa-hand-holding"></i> Loan</span>
                                            @elseif($book->availability_type === 'swap')
                                                <span class="badge badge-info"><i class="fas fa-exchange-alt"></i> Swap</span>
                                            @else
                                                <span class="badge badge-primary"><i class="fas fa-handshake"></i> Both</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($book->is_approved)
                                                @if($book->status === 'available')
                                                    <span class="badge badge-success"><i class="fas fa-check"></i> Available</span>
                                                @elseif($book->status === 'loaned')
                                                    <span class="badge badge-warning"><i class="fas fa-hand-holding"></i> Loaned</span>
                                                @elseif($book->status === 'swapped')
                                                    <span class="badge badge-info"><i class="fas fa-exchange-alt"></i> Swapped</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ ucfirst($book->status) }}</span>
                                                @endif
                                            @else
                                                <span class="badge badge-warning"><i class="fas fa-clock"></i> Pending Approval</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $loanRequests = $book->loanRequests->where('status', 'pending')->count();
                                                $swapRequests = $book->swapRequestsAsRequested->where('status', 'pending')->count();
                                            @endphp
                                            @if($loanRequests > 0 || $swapRequests > 0)
                                                @if($loanRequests > 0)
                                                    <span class="badge badge-warning">{{ $loanRequests }} Loan</span>
                                                @endif
                                                @if($swapRequests > 0)
                                                    <span class="badge badge-info">{{ $swapRequests }} Swap</span>
                                                @endif
                                            @else
                                                <span class="text-muted">None</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('books.show', $book) }}"
                                                   class="btn btn-outline-primary" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if(!$book->is_approved || in_array($book->status, ['available', 'unavailable']))
                                                    <a href="{{ route('books.edit', $book) }}"
                                                       class="btn btn-outline-secondary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif
                                                @if($book->status !== 'loaned' && !$book->loanRequests()->whereIn('status', ['pending', 'accepted'])->exists())
                                                    <button type="button" class="btn btn-outline-danger"
                                                            onclick="confirmDelete({{ $book->id }}, '{{ $book->title }}')"
                                                            title="Delete">
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

                        <!-- Pagination -->
                        @if($books->hasPages())
                            <div class="mt-4">
                                {{ $books->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-book fa-4x text-muted mb-3"></i>
                            <h5>No Books Yet</h5>
                            <p class="text-muted mb-4">You haven't uploaded any books to the platform yet.</p>
                            <a href="{{ route('books.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Upload Your First Book
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete "<span id="bookTitle"></span>"?</p>
                <p class="text-danger"><strong>This action cannot be undone.</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Book</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmDelete(bookId, bookTitle) {
    document.getElementById('bookTitle').textContent = bookTitle;
    document.getElementById('deleteForm').action = '/books/' + bookId;
    $('#deleteModal').modal('show');
}
</script>
@endpush

@endsection
