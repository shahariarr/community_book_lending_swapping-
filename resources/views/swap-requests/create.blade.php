@extends('layouts.back')
@section('title', 'Propose Book Swap')
@section('content')

<section class="section">
    <div class="section-header">
        <h1>Propose Book Swap</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('books.show', $book) }}">{{ Str::limit($book->title, 30) }}</a></div>
            <div class="breadcrumb-item active">Propose Swap</div>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-exchange-alt"></i> Book Swap Details</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('swap-requests.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="requested_book_id" value="{{ $book->id }}">

                        <!-- Book I Want -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary"><i class="fas fa-star"></i> Book I Want</h5>
                                <div class="card border-primary">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <img src="{{ $book->image ? asset('storage/' . $book->image) : asset('backend/assets/img/books/default.png') }}"
                                                     alt="{{ $book->title }}"
                                                     class="img-fluid rounded shadow">
                                            </div>
                                            <div class="col-md-9">
                                                <h5>{{ $book->title }}</h5>
                                                <p class="text-muted mb-2">by {{ $book->author }}</p>
                                                <div class="mb-2">
                                                    <span class="badge badge-primary">{{ $book->category->name }}</span>
                                                    <span class="badge badge-secondary">{{ $book->formatted_condition }}</span>
                                                </div>
                                                <p class="mb-2"><strong>Owner:</strong> {{ $book->user->name }}</p>
                                                @if($book->description)
                                                    <p class="text-muted">{{ Str::limit($book->description, 150) }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Book I Offer -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-success"><i class="fas fa-gift"></i> Book I Offer in Exchange</h5>
                                <div class="form-group">
                                    <label for="offered_book_id">Select one of your books <span class="text-danger">*</span></label>
                                    <select class="form-control @error('offered_book_id') is-invalid @enderror"
                                            id="offered_book_id" name="offered_book_id" required onchange="showBookDetails(this.value)">
                                        <option value="">Select a book to offer</option>
                                        @foreach($myBooks as $myBook)
                                            <option value="{{ $myBook->id }}" {{ old('offered_book_id') == $myBook->id ? 'selected' : '' }}>
                                                {{ $myBook->title }} by {{ $myBook->author }} ({{ $myBook->formatted_condition }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('offered_book_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Book Details Preview -->
                                <div id="bookPreview" class="card border-success" style="display: none;">
                                    <div class="card-body" id="bookPreviewContent">
                                        <!-- Book details will be loaded here -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Swap Duration -->
                        <div class="form-group">
                            <label for="swap_duration_days">Swap Duration <span class="text-danger">*</span></label>
                            <select class="form-control @error('swap_duration_days') is-invalid @enderror"
                                    id="swap_duration_days" name="swap_duration_days" required>
                                <option value="">How long would you like to swap?</option>
                                <option value="7" {{ old('swap_duration_days') == '7' ? 'selected' : '' }}>1 Week</option>
                                <option value="14" {{ old('swap_duration_days') == '14' ? 'selected' : '' }}>2 Weeks</option>
                                <option value="30" {{ old('swap_duration_days') == '30' ? 'selected' : '' }}>1 Month</option>
                                <option value="60" {{ old('swap_duration_days') == '60' ? 'selected' : '' }}>2 Months</option>
                                <option value="90" {{ old('swap_duration_days') == '90' ? 'selected' : '' }}>3 Months</option>
                            </select>
                            <small class="form-text text-muted">Both parties will exchange books for this duration, then return them.</small>
                            @error('swap_duration_days')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Message -->
                        <div class="form-group">
                            <label for="message">Message to Owner (Optional)</label>
                            <textarea class="form-control @error('message') is-invalid @enderror"
                                      id="message" name="message" rows="4"
                                      placeholder="Introduce yourself, explain why you'd like this swap, or provide any additional information...">{{ old('message') }}</textarea>
                            <small class="form-text text-muted">A friendly message can increase your chances of a successful swap!</small>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-paper-plane"></i> Send Swap Request
                            </button>
                            <a href="{{ route('books.show', $book) }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Swap Guidelines -->
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-info-circle"></i> Swap Guidelines</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6><i class="fas fa-handshake"></i> How Swaps Work</h6>
                        <ol class="mb-0">
                            <li>You propose a swap with one of your books</li>
                            <li>The book owner reviews your request</li>
                            <li>If approved, books are permanently exchanged</li>
                            <li>Both books become yours and theirs respectively</li>
                        </ol>
                    </div>

                    <div class="alert alert-warning">
                        <h6><i class="fas fa-exclamation-triangle"></i> Important Notes</h6>
                        <ul class="mb-0">
                            <li>Swaps are permanent exchanges</li>
                            <li>Both books must be available</li>
                            <li>Be honest about book conditions</li>
                            <li>Coordinate the physical exchange</li>
                        </ul>
                    </div>

                    <div class="alert alert-success">
                        <h6><i class="fas fa-tips"></i> Tips for Success</h6>
                        <ul class="mb-0">
                            <li>Offer books of similar value/condition</li>
                            <li>Write a thoughtful message</li>
                            <li>Check the owner's location</li>
                            <li>Be respectful if rejected</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- My Available Books Stats -->
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-book"></i> My Available Books</h4>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <h3 class="text-primary">{{ $myBooks->count() }}</h3>
                        <p class="text-muted">Books available for swap</p>
                        @if($myBooks->count() === 0)
                            <div class="alert alert-warning">
                                You need approved books to make swap requests.
                                <br><br>
                                <a href="{{ route('books.create') }}" class="btn btn-sm btn-primary">
                                    Upload Books
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
// Book preview data
const books = {!! $myBooks->toJson() !!};

function showBookDetails(bookId) {
    const preview = document.getElementById('bookPreview');
    const content = document.getElementById('bookPreviewContent');

    if (!bookId) {
        preview.style.display = 'none';
        return;
    }

    const book = books.find(b => b.id == bookId);
    if (!book) {
        preview.style.display = 'none';
        return;
    }

    const imageUrl = book.image ?
        `/storage/${book.image}` :
        '/backend/assets/img/books/default.png';

    content.innerHTML = `
        <div class="row">
            <div class="col-md-3">
                <img src="${imageUrl}" alt="${book.title}" class="img-fluid rounded">
            </div>
            <div class="col-md-9">
                <h6>${book.title}</h6>
                <p class="text-muted mb-1">by ${book.author}</p>
                <div class="mb-2">
                    <span class="badge badge-outline-primary">${book.category.name}</span>
                    <span class="badge badge-secondary">${book.condition.replace('_', ' ')}</span>
                </div>
                ${book.description ? `<p class="text-muted small">${book.description.substring(0, 100)}${book.description.length > 100 ? '...' : ''}</p>` : ''}
            </div>
        </div>
    `;

    preview.style.display = 'block';
}

// Show selected book on page load if there's an old value
document.addEventListener('DOMContentLoaded', function() {
    const selectedBookId = document.getElementById('offered_book_id').value;
    if (selectedBookId) {
        showBookDetails(selectedBookId);
    }
});
</script>
@endpush

@endsection
