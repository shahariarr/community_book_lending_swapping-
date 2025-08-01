@extends('frontend.layouts.master')

@section('title', 'BookBub - Community Book Lending & Swapping')

@section('content')
    <!-- Start Banner Area -->
    <div class="banner-area bg-2" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset('frontend/assets/images/team/library-interior-with-bookshelves-soft-lighting.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="banner-content style-two">
                        <span class="top-title wow animate__animated animate__fadeInUp delay-0-2s">Start Your Reading Journey</span>
                        <h1 class="wow animate__animated animate__fadeInUp delay-0-4s">Easy Way to Find & Share Books</h1>
                        <p class="wow animate__animated animate__fadeInUp delay-0-6s">We are a great platform for community book lending and swapping. Share your books and discover new reads through our community.</p>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="banner-rent-sale-form style-two wow animate__animated animate__fadeInUp delay-0-6s">
                        <form class="rent-sale-form wow animate__animated animate__fadeInUp delay-0-8s" action="{{ route('frontend.browse-books') }}" method="GET">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item style-two">
                                    <span>Find a book:</span>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="for-rent-tab" data-bs-toggle="pill"
                                        data-bs-target="#for-rent" type="button" role="tab" aria-controls="for-rent"
                                        aria-selected="false">For Swap</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="for-sall-tab" data-bs-toggle="pill"
                                        data-bs-target="#for-sall" type="button" role="tab" aria-controls="for-sall"
                                        aria-selected="false">For Loan</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="for-rent" role="tabpanel"
                                    aria-labelledby="for-rent-tab">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <input type="text" name="search" class="form-control"
                                                    placeholder="Search by title, author, or description...">
                                                <input type="hidden" name="availability_type" value="swap">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <select name="category" class="form-select form-control"
                                                    aria-label="Category select">
                                                    <option value="">All Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->slug }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group mb-0">
                                                <button type="submit" class="default-btn btn-radius">
                                                    <span><i class="ri-search-line"></i> Search</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="for-sall" role="tabpanel" aria-labelledby="for-sall-tab">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <input type="text" name="search" class="form-control"
                                                    placeholder="Search by title, author, or description...">
                                                <input type="hidden" name="availability_type" value="loan">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <select name="category" class="form-select form-control"
                                                    aria-label="Category select">
                                                    <option value="">All Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->slug }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group mb-0">
                                                <button type="submit" class="default-btn btn-radius">
                                                    <span><i class="ri-search-line"></i> Search</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Banner Area -->

    <!-- Start Discover Area -->
    <div class="discover-area bg-color-f2f7fd pt-100 pb-70">
        <div class="container">
            <div class="section-title left-title">
                <h2>Book Categories</h2>
            </div>

            <div class="discover-slide owl-carousel owl-theme">
                @foreach($categories as $index => $category)
                    <div class="single-discover wow animate__animated animate__fadeInUp delay-0-{{ ($index % 3 + 2) * 2 }}s">
                        <a href="{{ route('frontend.browse-books') }}?category={{ $category->slug }}">
                            @if($category->image)
                                <img src="{{ $category->image_url }}" alt="{{ $category->name }} Books">
                            @else
                                <img src="{{ asset('frontend/assets/images/discover/discover-' . (($index % 6) + 1) . '.jpg') }}" alt="{{ $category->name }} Books">
                            @endif
                            <h3>{{ $category->name }}</h3>
                            <span>{{ $category->books_count }} Books</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- End Discover Area -->

    <!-- Start Books for Loan Area -->
    <div class="discover-area bg-color-f8fafb pt-100 pb-70">
        <div class="container">
            <div class="section-title left-title">
                <h2>Books for Loan</h2>
                <p>Discover books available for borrowing from our community</p>
            </div>

            <div class="discover-slide owl-carousel owl-theme">
                @forelse($allBooks->where('availability_type', 'loan') as $index => $book)
                    <div class="single-discover wow animate__animated animate__fadeInUp delay-0-{{ ($index % 3 + 2) * 2 }}s">
                        <a href="#">
                            <div class="book-image-container" style="position: relative;">
                                @if($book->image)
                                    <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }} Book Cover">
                                @else
                                    <img src="{{ asset('frontend/assets/images/discover/discover-' . (($index % 6) + 1) . '.jpg') }}" alt="{{ $book->title }} Book Cover">
                                @endif
                                <span class="availability-badge-home loan">
                                    For Loan
                                </span>
                            </div>
                            <h3>{{ Str::limit($book->title, 25) }}</h3>
                            <span class="book-details">
                                <strong class="availability-text-home loan">
                                    Available for Loan
                                </strong>
                                | {{ $book->category ? $book->category->name : 'Uncategorized' }}
                            </span>
                        </a>
                    </div>
                @empty
                    <div class="single-discover wow animate__animated animate__fadeInUp delay-0-2s">
                        <div class="text-center p-5">
                            <h4>No books available for loan</h4>
                            <p>There are currently no books available for lending.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            @if($allBooks->where('availability_type', 'loan')->count() > 0)
                <div class="text-center mt-5">
                    <a href="{{ route('frontend.browse-books') }}?availability_type=loan" class="default-btn btn-radius">
                        View All Loan Books
                    </a>
                </div>
            @endif
        </div>
    </div>
    <!-- End Books for Loan Area -->

    <!-- Start Books for Swap Area -->
    <div class="discover-area bg-color-f2f7fd pt-100 pb-70">
        <div class="container">
            <div class="section-title left-title">
                <h2>Books for Swap</h2>
                <p>Find books available for exchange with other community members</p>
            </div>

            <div class="discover-slide owl-carousel owl-theme">
                @forelse($allBooks->where('availability_type', 'swap') as $index => $book)
                    <div class="single-discover wow animate__animated animate__fadeInUp delay-0-{{ ($index % 3 + 2) * 2 }}s">
                        <a href="#">
                            <div class="book-image-container" style="position: relative;">
                                @if($book->image)
                                    <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }} Book Cover">
                                @else
                                    <img src="{{ asset('frontend/assets/images/discover/discover-' . (($index % 6) + 1) . '.jpg') }}" alt="{{ $book->title }} Book Cover">
                                @endif
                                <span class="availability-badge-home swap">
                                    For Swap
                                </span>
                            </div>
                            <h3>{{ Str::limit($book->title, 25) }}</h3>
                            <span class="book-details">
                                <strong class="availability-text-home swap">
                                    Available for Swap
                                </strong>
                                | {{ $book->category ? $book->category->name : 'Uncategorized' }}
                            </span>
                        </a>
                    </div>
                @empty
                    <div class="single-discover wow animate__animated animate__fadeInUp delay-0-2s">
                        <div class="text-center p-5">
                            <h4>No books available for swap</h4>
                            <p>There are currently no books available for swapping.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            @if($allBooks->where('availability_type', 'swap')->count() > 0)
                <div class="text-center mt-5">
                    <a href="{{ route('frontend.browse-books') }}?availability_type=swap" class="default-btn btn-radius">
                        View All Swap Books
                    </a>
                </div>
            @endif
        </div>
    </div>
    <!-- End Books for Swap Area -->

    <!-- Start Books for Both Area -->
    <div class="discover-area bg-color-f8fafb pt-100 pb-70">
        <div class="container">
            <div class="section-title left-title">
                <h2>Books for Both</h2>
                <p>Books available for both loan and swap options</p>
            </div>

            <div class="discover-slide owl-carousel owl-theme">
                @forelse($allBooks->where('availability_type', 'both') as $index => $book)
                    <div class="single-discover wow animate__animated animate__fadeInUp delay-0-{{ ($index % 3 + 2) * 2 }}s">
                        <a href="#">
                            <div class="book-image-container" style="position: relative;">
                                @if($book->image)
                                    <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }} Book Cover">
                                @else
                                    <img src="{{ asset('frontend/assets/images/discover/discover-' . (($index % 6) + 1) . '.jpg') }}" alt="{{ $book->title }} Book Cover">
                                @endif
                                <span class="availability-badge-home both" style="background-color: #6f42c1 !important; color: white !important;">
                                    For Both
                                </span>
                            </div>
                            <h3>{{ Str::limit($book->title, 25) }}</h3>
                            <span class="book-details">
                                <strong class="availability-text-home both" style="color: #6f42c1 !important; font-weight: 600 !important;">
                                    Available for Both Loan & Swap
                                </strong>
                                | {{ $book->category ? $book->category->name : 'Uncategorized' }}
                            </span>
                        </a>
                    </div>
                @empty
                    <div class="single-discover wow animate__animated animate__fadeInUp delay-0-2s">
                        <div class="text-center p-5">
                            <h4>No books available for both</h4>
                            <p>There are currently no books available for both loan and swap.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            @if($allBooks->where('availability_type', 'both')->count() > 0)
                <div class="text-center mt-5">
                    <a href="{{ route('frontend.browse-books') }}?availability_type=both" class="default-btn btn-radius">
                        View All Both Books
                    </a>
                </div>
            @endif
        </div>
    </div>
    <!-- End Books for Both Area -->

        <!-- Start Meet Our Team Area -->
    <div class="meet-our-agents-area pt-100 pb-70">
        <div class="container">
            <div class="section-title left-title">
                <h2>Meet Our Team</h2>
            </div>

            <div class="agents-slide-two owl-carousel owl-theme">
                <!-- Team Member 1: Shahariar Rahman -->
                <div class="single-agents wow animate__animated animate__fadeInUp delay-0-2s">
                    <div class="agents-img mb-0">
                        <img src="{{ asset('frontend/assets/images/team/Screenshot 2025-08-01 110838.png') }}" alt="Shahariar Rahman">
                    </div>
                    <div class="agents-content style-two">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3>
                                <a href="#">Shahariar Rahman</a>
                            </h3>
                        </div>
                        <ul class="info">
                            <li>
                                <a href="mailto:sahariarshifat2002@gmail.com">
                                    <i class="ri-mail-line"></i>
                                    <span>sahariarshifat2002@gmail.com</span>
                                </a>
                            </li>
                        </ul>
                        <div class="view-call d-flex justify-content-between align-items-center">
                            <a href="tel:01744717205">
                                <i class="ri-phone-fill"></i>
                                01744717205
                            </a>
                            <span class="read-more">
                                Backend Developer
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Team Member 2: Shantanu Kundu -->
                <div class="single-agents wow animate__animated animate__fadeInUp delay-0-4s">
                    <div class="agents-img mb-0">
                        <img src="{{ asset('frontend/assets/images/team/Screenshot 2025-08-01 023122.png') }}" alt="Shantanu Kundu">
                    </div>
                    <div class="agents-content style-two">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3>
                                <a href="#">Shantanu Kundu</a>
                            </h3>
                        </div>
                        <ul class="info">
                            <li>
                                <a href="mailto:kundu15-5897@diu.edu.bd">
                                    <i class="ri-mail-line"></i>
                                    <span>kundu15-5897@diu.edu.bd</span>
                                </a>
                            </li>
                        </ul>
                        <div class="view-call d-flex justify-content-between align-items-center">
                            <a href="tel:01797477220">
                                <i class="ri-phone-fill"></i>
                                01797477220
                            </a>
                            <span class="read-more">
                                Backend Developer
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Team Member 3: Zinnahtur Rahman -->
                <div class="single-agents wow animate__animated animate__fadeInUp delay-0-6s">
                    <div class="agents-img mb-0">
                        <img src="{{ asset('frontend/assets/images/team/Screenshot 2025-08-01 023348.png') }}" alt="Zinnahtur Rahman">
                    </div>
                    <div class="agents-content style-two">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3>
                                <a href="#">Zinnahtur Rahman</a>
                            </h3>
                        </div>
                        <ul class="info">
                            <li>
                                <a href="mailto:zitu15-6009@diu.edu.bd">
                                    <i class="ri-mail-line"></i>
                                    <span>zitu15-6009@diu.edu.bd</span>
                                </a>
                            </li>
                        </ul>
                        <div class="view-call d-flex justify-content-between align-items-center">
                            <a href="tel:01798436541">
                                <i class="ri-phone-fill"></i>
                                01798436541
                            </a>
                            <span class="read-more">
                                Database Developer
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Team Member 4: Shohanur Rahman -->
                <div class="single-agents wow animate__animated animate__fadeInUp delay-0-8s">
                    <div class="agents-img mb-0">
                        <img src="{{ asset('frontend/assets/images/team/Screenshot 2025-08-01 023512.png') }}" alt="Shohanur Rahman">
                    </div>
                    <div class="agents-content style-two">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3>
                                <a href="#">Shohanur Rahman</a>
                            </h3>
                        </div>
                        <ul class="info">
                            <li>
                                <a href="mailto:rahman15-6021@diu.edu.bd">
                                    <i class="ri-mail-line"></i>
                                    <span>rahman15-6021@diu.edu.bd</span>
                                </a>
                            </li>
                        </ul>
                        <div class="view-call d-flex justify-content-between align-items-center">
                            <a href="tel:01798436541">
                                <i class="ri-phone-fill"></i>
                                01533667510
                            </a>
                            <span class="read-more">
                                Frontend Developer
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Team Member 5: Taposi Rabeya -->
                <div class="single-agents wow animate__animated animate__fadeInUp delay-1-0s">
                    <div class="agents-img mb-0">
                        <img src="{{ asset('frontend/assets/images/team/Screenshot 2025-08-01 023051.png') }}" alt="Taposi Rabeya">
                    </div>
                    <div class="agents-content style-two">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3>
                                <a href="#">Taposi Rabeya</a>
                            </h3>
                        </div>
                        <ul class="info">
                            <li>
                                <a href="mailto:taposi@gmail.com">
                                    <i class="ri-mail-line"></i>
                                    <span>taposi@gmail.com</span>
                                </a>
                            </li>
                        </ul>
                        <div class="view-call d-flex justify-content-between align-items-center">
                            <span>
                                <i class="ri-phone-fill"></i>
                                01714990871
                            </span>
                            <span class="read-more">
                                Frontend Developer
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Meet Our Agents Area -->
@endsection
