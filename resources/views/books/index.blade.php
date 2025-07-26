@extends('layouts.back')
@section('title', 'Browse Books')
@section('content')

<section class="section">
    <div class="section-header">
        <h1>Browse Books</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active">Browse Books</div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('books.search') }}" method="GET">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Search</label>
                                    <input type="text" name="search" class="form-control"
                                           placeholder="Search by title, author, or description..."
                                           value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Category</label>
                                    <select name="category" class="form-control">
                                        <option value="">All Categories</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Condition</label>
                                    <select name="condition" class="form-control">
                                        <option value="">All Conditions</option>
                                        <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>New</option>
                                        <option value="like_new" {{ request('condition') == 'like_new' ? 'selected' : '' }}>Like New</option>
                                        <option value="good" {{ request('condition') == 'good' ? 'selected' : '' }}>Good</option>
                                        <option value="fair" {{ request('condition') == 'fair' ? 'selected' : '' }}>Fair</option>
                                        <option value="poor" {{ request('condition') == 'poor' ? 'selected' : '' }}>Poor</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Availability</label>
                                    <select name="availability_type" class="form-control">
                                        <option value="">All Types</option>
                                        <option value="loan" {{ request('availability_type') == 'loan' ? 'selected' : '' }}>Loan Only</option>
                                        <option value="swap" {{ request('availability_type') == 'swap' ? 'selected' : '' }}>Swap Only</option>
                                        <option value="both" {{ request('availability_type') == 'both' ? 'selected' : '' }}>Both</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Books Grid -->
    <div class="row">
        @forelse($books as $book)
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card book-card h-100">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <img src="{{ $book->image ? asset('storage/' . $book->image) : asset('backend/assets/img/books/default.png') }}"
                                 alt="{{ $book->title }}"
                                 class="img-fluid rounded book-image"
                                 style="height: 120px; width: 100%; object-fit: cover;">
                        </div>
                        <div class="col-8">
                            <h6 class="card-title mb-2">
                                <a href="{{ route('books.show', $book) }}" class="text-dark font-weight-bold">
                                    {{ Str::limit($book->title, 30) }}
                                </a>
                            </h6>
                            <p class="text-muted mb-1"><small>by {{ $book->author }}</small></p>
                            <p class="text-muted mb-2"><small><i class="fas fa-user"></i> {{ $book->user->name }}</small></p>

                            <div class="mb-2">
                                <span class="badge badge-outline-primary">{{ $book->category->name }}</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    @if($book->availability_type === 'loan')
                                        <span class="badge badge-success"><i class="fas fa-hand-holding"></i> Loan</span>
                                    @elseif($book->availability_type === 'swap')
                                        <span class="badge badge-info"><i class="fas fa-exchange-alt"></i> Swap</span>
                                    @else
                                        <span class="badge badge-primary"><i class="fas fa-handshake"></i> Both</span>
                                    @endif
                                </div>
                                <small class="text-muted">{{ $book->formatted_condition }}</small>
                            </div>
                        </div>
                    </div>

                    @if($book->description)
                    <div class="mt-3">
                        <p class="text-muted small mb-0">{{ Str::limit($book->description, 80) }}</p>
                    </div>
                    @endif

                    <div class="mt-3">
                        <a href="{{ route('books.show', $book) }}" class="btn btn-outline-primary btn-sm btn-block">
                            <i class="fas fa-eye"></i> View Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-search fa-4x text-muted mb-3"></i>
                    <h5>No books found</h5>
                    <p class="text-muted">Try adjusting your search criteria or check back later for new books.</p>
                    <a href="{{ route('books.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Upload First Book
                    </a>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($books->hasPages())
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{ $books->links() }}
                </div>
            </div>
        </div>
    </div>
    @endif
</section>

@push('styles')
<style>
.book-card {
    transition: transform 0.2s;
    border: 1px solid #e9ecef;
}
.book-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.book-image {
    border-radius: 8px;
}
</style>
@endpush

@endsection
