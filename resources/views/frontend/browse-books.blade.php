@extends('frontend.layouts.master')

@section('title', 'Browse Books - BookBub')

@section('content')
    <!-- Start Page Title Area -->
    <div class="page-title-area bg-9">
        <div class="container">
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
                            <form>
                                <div class="form-group">
                                    <input type="text" class="form-control style"
                                        placeholder="Search by title, author, or description...">
                                    <i class="ri-search-line"></i>
                                </div>
                                <div class="form-group">
                                    <select class="form-select form-control" aria-label="Default select example">
                                        <option selected>All Categories</option>
                                        <option value="1">Fiction</option>
                                        <option value="2">Non-Fiction</option>
                                        <option value="3">Science</option>
                                        <option value="4">Mystery</option>
                                        <option value="5">Romance</option>
                                        <option value="6">Biography</option>
                                        <option value="7">Fantasy</option>
                                        <option value="8">Thriller</option>
                                        <option value="9">History</option>
                                        <option value="10">Self-Help</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="form-select form-control" aria-label="Default select example">
                                        <option selected>All Conditions</option>
                                        <option value="1">Like New</option>
                                        <option value="2">Very Good</option>
                                        <option value="3">Good</option>
                                        <option value="4">Fair</option>
                                        <option value="5">Poor</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="form-select form-control" aria-label="Default select example">
                                        <option selected>All Availability</option>
                                        <option value="1">For Loan</option>
                                        <option value="2">For Swap</option>
                                        <option value="3">Available Now</option>
                                        <option value="4">Coming Soon</option>
                                    </select>
                                </div>

                                <div class="amenities-wrap">
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6">
                                            <button class="default-btn">
                                                Save Search
                                            </button>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <button class="default-btn mt-20">
                                                Reset All Filters
                                            </button>
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
                                    <p>248 Books Found</p>
                                </div>
                                <div class="col-lg-6">
                                    <select class="form-select form-control" aria-label="Default select example">
                                        <option selected>Sort by</option>
                                        <option value="1">Title A-Z</option>
                                        <option value="2">Title Z-A</option>
                                        <option value="3">Author A-Z</option>
                                        <option value="4">Most Popular</option>
                                        <option value="5">Newest First</option>
                                        <option value="6">Rating High to Low</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="single-featured-item">
                                    <div class="featured-img mb-0">
                                        <img src="{{ asset('frontend/assets/images/featured/featured-1.jpg') }}"
                                            alt="Atomic Habits Book Cover">
                                        <span>Loan</span>
                                        <ul class="d-flex justify-content-between">
                                            <li>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
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
                                                <a href="#">Atomic Habits</a>
                                            </h3>
                                        </div>
                                        <p>
                                            <i class="ri-user-line"></i>
                                            <strong>Author:</strong> James Clear
                                        </p>
                                        <ul>
                                            <li>
                                                <i class="ri-bookmark-line"></i>
                                                Self-Help
                                            </li>
                                            <li>
                                                <i class="ri-medal-line"></i>
                                                Like New
                                            </li>
                                        </ul>

                                        <a href="#" class="agent-user">
                                            <img src="{{ asset('frontend/assets/images/agents/agent-5.jpg') }}"
                                                alt="Book Owner">
                                            <span>By Sarah Johnson</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="single-featured-item">
                                    <div class="featured-img mb-0">
                                        <img src="{{ asset('frontend/assets/images/featured/featured-2.jpg') }}"
                                            alt="The Alchemist Book Cover">
                                        <span>Swap</span>
                                        <ul class="d-flex justify-content-between">
                                            <li>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-half-line"></i>
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
                                                <a href="#">The Alchemist</a>
                                            </h3>
                                        </div>
                                        <p>
                                            <i class="ri-user-line"></i>
                                            <strong>Author:</strong> Paulo Coelho
                                        </p>
                                        <ul>
                                            <li>
                                                <i class="ri-bookmark-line"></i>
                                                Fiction
                                            </li>
                                            <li>
                                                <i class="ri-medal-line"></i>
                                                Good
                                            </li>
                                        </ul>

                                        <a href="#" class="agent-user">
                                            <img src="{{ asset('frontend/assets/images/agents/agent-6.jpg') }}"
                                                alt="Book Owner">
                                            <span>By Michael Chen</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="single-featured-item">
                                    <div class="featured-img mb-0">
                                        <img src="{{ asset('frontend/assets/images/featured/featured-3.jpg') }}"
                                            alt="Sapiens Book Cover">
                                        <span>Loan</span>
                                        <ul class="d-flex justify-content-between">
                                            <li>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
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
                                                <a href="#">Sapiens</a>
                                            </h3>
                                        </div>
                                        <p>
                                            <i class="ri-user-line"></i>
                                            <strong>Author:</strong> Yuval Noah Harari
                                        </p>
                                        <ul>
                                            <li>
                                                <i class="ri-bookmark-line"></i>
                                                History
                                            </li>
                                            <li>
                                                <i class="ri-medal-line"></i>
                                                Excellent
                                            </li>
                                        </ul>

                                        <a href="#" class="agent-user">
                                            <img src="{{ asset('frontend/assets/images/agents/agent-7.jpg') }}"
                                                alt="Book Owner">
                                            <span>By Emma Rodriguez</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                                                        <div class="col-lg-6 col-md-6">
                                <div class="single-featured-item">
                                    <div class="featured-img mb-0">
                                        <img src="{{ asset('frontend/assets/images/featured/featured-3.jpg') }}" alt="Sapiens Book Cover">
                                        <span>Loan</span>
                                        <ul class="d-flex justify-content-between">
                                            <li>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
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
                                                <a href="#">Sapiens</a>
                                            </h3>
                                        </div>
                                        <p>
                                            <i class="ri-user-line"></i>
                                            <strong>Author:</strong> Yuval Noah Harari
                                        </p>
                                        <ul>
                                            <li>
                                                <i class="ri-bookmark-line"></i>
                                                History
                                            </li>
                                            <li>
                                                <i class="ri-medal-line"></i>
                                                Excellent
                                            </li>
                                        </ul>

                                        <a href="#" class="agent-user">
                                            <img src="{{ asset('frontend/assets/images/agents/agent-7.jpg') }}" alt="Book Owner">
                                            <span>By Emma Rodriguez</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                                                        <div class="col-lg-6 col-md-6">
                                <div class="single-featured-item">
                                    <div class="featured-img mb-0">
                                        <img src="{{ asset('frontend/assets/images/featured/featured-3.jpg') }}" alt="Sapiens Book Cover">
                                        <span>Loan</span>
                                        <ul class="d-flex justify-content-between">
                                            <li>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
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
                                                <a href="#">Sapiens</a>
                                            </h3>
                                        </div>
                                        <p>
                                            <i class="ri-user-line"></i>
                                            <strong>Author:</strong> Yuval Noah Harari
                                        </p>
                                        <ul>
                                            <li>
                                                <i class="ri-bookmark-line"></i>
                                                History
                                            </li>
                                            <li>
                                                <i class="ri-medal-line"></i>
                                                Excellent
                                            </li>
                                        </ul>

                                        <a href="#" class="agent-user">
                                            <img src="{{ asset('frontend/assets/images/agents/agent-7.jpg') }}" alt="Book Owner">
                                            <span>By Emma Rodriguez</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="single-featured-item">
                                    <div class="featured-img mb-0">
                                        <img src="{{ asset('frontend/assets/images/featured/featured-3.jpg') }}"
                                            alt="Sapiens Book Cover">
                                        <span>Loan</span>
                                        <ul class="d-flex justify-content-between">
                                            <li>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
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
                                                <a href="#">Sapiens</a>
                                            </h3>
                                        </div>
                                        <p>
                                            <i class="ri-user-line"></i>
                                            <strong>Author:</strong> Yuval Noah Harari
                                        </p>
                                        <ul>
                                            <li>
                                                <i class="ri-bookmark-line"></i>
                                                History
                                            </li>
                                            <li>
                                                <i class="ri-medal-line"></i>
                                                Excellent
                                            </li>
                                        </ul>

                                        <a href="#" class="agent-user">
                                            <img src="{{ asset('frontend/assets/images/agents/agent-7.jpg') }}"
                                                alt="Book Owner">
                                            <span>By Emma Rodriguez</span>
                                        </a>
                                    </div>
                                </div>
                            </div>


                            <!-- Pagination -->
                            <div class="col-lg-12">
                                <div class="pagination-area">
                                    <a href="#" class="prev page-numbers">
                                        <i class="ri-arrow-left-s-line"></i>
                                    </a>
                                    <span class="page-numbers current" aria-current="page">1</span>
                                    <a href="#" class="page-numbers">2</a>
                                    <a href="#" class="page-numbers">3</a>
                                    <a href="#" class="next page-numbers">
                                        <i class="ri-arrow-right-s-line"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Listing Area -->
@endsection
