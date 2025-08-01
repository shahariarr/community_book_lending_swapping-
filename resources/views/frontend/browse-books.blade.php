@extends('frontend.layouts.master')

@section('title', 'Browse Books - BookBub')

@section('content')
    <!-- Start Page Title Area -->
 <div class="page-title-area bg-2" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset('frontend/assets/images/team/library-interior-with-bookshelves-soft-lighting.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">        <div class="container">
            <div class="page-title-content">
                <h2>Browse Books</h2>

                <ul>
                    <li>
                        <a href="{{ route('frontend.home') }}">
                            Home
                        </a>
                    </li>

                    <li class="active">Browse Books</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- End Page Title Area -->

    <!-- Start Listing Area -->
    <div class="listing-area ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="widget-sidebar">
                        <div class="sidebar-widget filter-form">
                            <h3>Filter search</h3>
                            <form method="GET" action="{{ route('frontend.browse-books') }}">
                                <div class="form-group">
                                    <input type="text" name="search" class="form-control style"
                                        placeholder="Search by title, author, or description..."
                                        value="{{ request('search') }}">
                                    <i class="ri-search-line"></i>
                                </div>
                                <div class="form-group">
                                    <select name="category" class="form-select form-control" aria-label="Category filter">
                                        <option value="">All Categories</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->slug }}"
                                                {{ request('category') == $category->slug ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="condition" class="form-select form-control" aria-label="Condition filter">
                                        <option value="">All Conditions</option>
                                        <option value="like_new" {{ request('condition') == 'like_new' ? 'selected' : '' }}>Like New</option>
                                        <option value="very_good" {{ request('condition') == 'very_good' ? 'selected' : '' }}>Very Good</option>
                                        <option value="good" {{ request('condition') == 'good' ? 'selected' : '' }}>Good</option>
                                        <option value="fair" {{ request('condition') == 'fair' ? 'selected' : '' }}>Fair</option>
                                        <option value="poor" {{ request('condition') == 'poor' ? 'selected' : '' }}>Poor</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="availability_type" class="form-select form-control" aria-label="Availability filter">
                                        <option value="">All Availability</option>
                                        <option value="loan" {{ request('availability_type') == 'loan' ? 'selected' : '' }}>For Loan</option>
                                        <option value="swap" {{ request('availability_type') == 'swap' ? 'selected' : '' }}>For Swap</option>
                                        <option value="both" {{ request('availability_type') == 'both' ? 'selected' : '' }}>For Both</option>
                                    </select>
                                </div>

                                <div class="amenities-wrap">
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6">
                                            <button type="submit" class="default-btn">
                                                Apply Filters
                                            </button>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <a href="{{ route('frontend.browse-books') }}" class="default-btn mt-20">
                                                Reset All Filters
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="list-wrap">
                        <div class="mb-30">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <p>{{ $books->total() }} Books Found</p>
                                </div>
                                <div class="col-lg-6">
                                    <form method="GET" action="{{ route('frontend.browse-books') }}" id="sortForm">
                                        @foreach(request()->except(['sort_by', 'page']) as $key => $value)
                                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                        @endforeach
                                        <select name="sort_by" class="form-select form-control" aria-label="Sort options" onchange="document.getElementById('sortForm').submit();">
                                            <option value="">Sort by</option>
                                            <option value="title_asc" {{ request('sort_by') == 'title_asc' ? 'selected' : '' }}>Title A-Z</option>
                                            <option value="title_desc" {{ request('sort_by') == 'title_desc' ? 'selected' : '' }}>Title Z-A</option>
                                            <option value="author_asc" {{ request('sort_by') == 'author_asc' ? 'selected' : '' }}>Author A-Z</option>
                                            <option value="rating" {{ request('sort_by') == 'rating' ? 'selected' : '' }}>Rating High to Low</option>
                                            <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>Newest First</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            @forelse($books as $book)
                                <div class="col-lg-6 col-md-6">
                                    <div class="single-featured-item">
                                        <div class="featured-img mb-0">
                                            @if($book->image)
                                                <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }} Book Cover">
                                            @else
                                                <img src="{{ asset('frontend/assets/images/featured/featured-' . (($loop->index % 3) + 1) . '.jpg') }}" alt="{{ $book->title }} Book Cover">
                                            @endif
                                            <span class="availability-badge {{ strtolower($book->availability_type) }}">
                                                @if($book->availability_type == 'loan')
                                                    For Loan
                                                @elseif($book->availability_type == 'swap')
                                                    For Swap
                                                @elseif($book->availability_type == 'both')
                                                    For Both
                                                @else
                                                    {{ ucfirst($book->availability_type) }}
                                                @endif
                                            </span>
                                            <ul class="d-flex justify-content-between">
                                                <li>
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= floor($book->rating))
                                                            <i class="ri-star-fill"></i>
                                                        @elseif($i - 0.5 <= $book->rating)
                                                            <i class="ri-star-half-line"></i>
                                                        @else
                                                            <i class="ri-star-line"></i>
                                                        @endif
                                                    @endfor
                                                </li>
                                                <li>
                                                    <button type="submit">
                                                        <i class="ri-heart-line"></i>
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="featured-content style-three">
                                            <div class="d-flex justify-content-between">
                                                <h3>
                                                    <a href="#">{{ $book->title }}</a>
                                                </h3>
                                            </div>
                                            <p>
                                                <i class="ri-user-line"></i>
                                                <strong>Author:</strong> {{ $book->author }}
                                            </p>

                                            <!-- Enhanced availability display -->
                                            <div class="availability-info mb-2">
                                                <i class="ri-price-tag-3-line"></i>
                                                <strong>Availability:</strong>
                                                <span class="availability-text {{ strtolower($book->availability_type) }}">
                                                    @if($book->availability_type == 'loan')
                                                        Available for Loan
                                                    @elseif($book->availability_type == 'swap')
                                                        Available for Swap
                                                    @elseif($book->availability_type == 'both')
                                                        Available for Both Loan & Swap
                                                    @else
                                                        {{ ucfirst($book->availability_type) }}
                                                    @endif
                                                </span>
                                            </div>

                                            <ul>
                                                <li>
                                                    <i class="ri-bookmark-line"></i>
                                                    {{ $book->category ? $book->category->name : 'Uncategorized' }}
                                                </li>
                                                <li>
                                                    <i class="ri-medal-line"></i>
                                                    {{ ucwords(str_replace('_', ' ', $book->condition)) }}
                                                </li>
                                            </ul>

                                            <a href="#" class="agent-user">
                                                @if($book->user && $book->user->image)
                                                    <img src="{{ asset('storage/' . $book->user->image) }}" alt="Book Owner">
                                                @else
                                                    <img src="{{ asset('backend/assets/img/avatar/xyz.png') }}" alt="Book Owner">
                                                @endif
                                                By {{ $book->user ? $book->user->name : 'Unknown' }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="text-center">
                                        <h4>No books found</h4>
                                        <p>Try adjusting your search criteria or browse all categories.</p>
                                        <a href="{{ route('frontend.browse-books') }}" class="default-btn">View All Books</a>
                                    </div>
                                </div>
                            @endforelse

                            <!-- Pagination -->
                            @if($books->hasPages())
                                <div class="col-lg-12">
                                    <div class="pagination-area">
                                        {{-- Previous Page Link --}}
                                        @if ($books->onFirstPage())
                                            <span class="prev page-numbers disabled">
                                                <i class="ri-arrow-left-s-line"></i>
                                            </span>
                                        @else
                                            <a href="{{ $books->previousPageUrl() }}" class="prev page-numbers">
                                                <i class="ri-arrow-left-s-line"></i>
                                            </a>
                                        @endif

                                        {{-- Pagination Elements --}}
                                        @foreach ($books->getUrlRange(1, $books->lastPage()) as $page => $url)
                                            @if ($page == $books->currentPage())
                                                <span class="page-numbers current" aria-current="page">{{ $page }}</span>
                                            @else
                                                <a href="{{ $url }}" class="page-numbers">{{ $page }}</a>
                                            @endif
                                        @endforeach

                                        {{-- Next Page Link --}}
                                        @if ($books->hasMorePages())
                                            <a href="{{ $books->nextPageUrl() }}" class="next page-numbers">
                                                <i class="ri-arrow-right-s-line"></i>
                                            </a>
                                        @else
                                            <span class="next page-numbers disabled">
                                                <i class="ri-arrow-right-s-line"></i>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Listing Area -->
@endsection
