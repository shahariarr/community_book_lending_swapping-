@extends('frontend.layouts.master')

@section('title', 'BookBub - Community Book Lending & Swapping')

@section('content')
    <!-- Start Banner Area -->
    <div class="banner-area bg-2">
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
                        <form class="rent-sale-form wow animate__animated animate__fadeInUp delay-0-8s">
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
                                                <input type="text" class="form-control"
                                                    placeholder="Search by title, author, or description...">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <select class="form-select form-control"
                                                    aria-label="Default select example">
                                                    <option selected>All Category</option>
                                                    <option value="1">Non-Fiction</option>
                                                    <option value="2">Fiction</option>
                                                    <option value="3">Science</option>
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
                                                <input type="text" class="form-control"
                                                    placeholder="Search by title, author, or description...">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <select class="form-select form-control"
                                                    aria-label="Default select example">
                                                    <option selected>All Category</option>
                                                    <option value="1">Non-Fiction</option>
                                                    <option value="2">Fiction</option>
                                                    <option value="3">Science</option>
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
                <div class="single-discover wow animate__animated animate__fadeInUp delay-0-4s">
                    <a href="{{ route('frontend.browse-books') }}">
                        <img src="{{ asset('frontend/assets/images/discover/discover-2.jpg') }}" alt="Non-Fiction Books">
                        <h3>Non-Fiction</h3>
                        <span>245 Books</span>
                    </a>
                </div>

                <div class="single-discover wow animate__animated animate__fadeInUp delay-0-6s">
                    <a href="{{ route('frontend.browse-books') }}">
                        <img src="{{ asset('frontend/assets/images/discover/discover-3.jpg') }}" alt="Science Books">
                        <h3>Science</h3>
                        <span>105 Books</span>
                    </a>
                </div>

                <div class="single-discover wow animate__animated animate__fadeInUp delay-0-8s">
                    <a href="{{ route('frontend.browse-books') }}">
                        <img src="{{ asset('frontend/assets/images/discover/discover-4.jpg') }}" alt="Mystery Books">
                        <h3>Mystery</h3>
                        <span>325 Books</span>
                    </a>
                </div>

                <div class="single-discover wow animate__animated animate__fadeInUp delay-0-2s">
                    <a href="{{ route('frontend.browse-books') }}">
                        <img src="{{ asset('frontend/assets/images/discover/discover-5.jpg') }}" alt="Romance Books">
                        <h3>Romance</h3>
                        <span>230 Books</span>
                    </a>
                </div>

                <div class="single-discover wow animate__animated animate__fadeInUp delay-0-4s">
                    <a href="{{ route('frontend.browse-books') }}">
                        <img src="{{ asset('frontend/assets/images/discover/discover-6.jpg') }}" alt="Biography Books">
                        <h3>Biography</h3>
                        <span>145 Books</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- End Discover Area -->

    <!-- Start Properties Area -->
    <div class="properties-area bg-color-f8fafb ptb-100">
        <div class="container">
            <div class="properties-filter">
                <div class="section-title left-title">
                    <h2>Recent Books</h2>
                </div>
                <div class="shorting-menu">
                    <button class="filter border-radius-4" data-filter="all">
                        All Books
                    </button>

                    <button class="filter border-radius-4" data-filter=".for-sale">
                        For Swap
                    </button>

                    <button class="filter border-radius-4" data-filter=".for-rent">
                        For Loan
                    </button>
                </div>
            </div>

            <div class="shorting">
                <div class="row justify-content-center">
                    <div class="col-xl-3 col-md-6 mix for-rent">
                        <div class="single-properties-item style-three wow animate__animated animate__fadeInUp delay-0-2s">
                            <div class="properties-img">
                                <a href="#">
                                    <img src="{{ asset('frontend/assets/images/properties/properties-1.jpg') }}" alt="Atomic Habits Book Cover">
                                </a>
                                <span>Loan</span>
                                <button class="wish">
                                    <i class="ri-heart-3-line"></i>
                                </button>
                            </div>
                            <div class="properties-content">
                                <div class="border-style">
                                    <div class="d-flex justify-content-between">
                                        <a href="#">
                                            <h3>Atomic Habits</h3>
                                        </a>
                                    </div>
                                    <p>
                                        <i class="ri-user-line"></i>
                                        <strong>Author:</strong> James Clear
                                    </p>
                                    <ul class="feature-list">
                                        <li>
                                            <i class="ri-bookmark-line"></i>
                                            Self-Help
                                        </li>
                                        <li>
                                            <i class="ri-medal-line"></i>
                                            Like New
                                        </li>
                                    </ul>
                                </div>

                                <ul class="user d-flex justify-content-between align-items-center">
                                    <li>
                                        <a href="#" class="agent-user">
                                            <img src="{{ asset('frontend/assets/images/agents/agent-1.jpg') }}" alt="Book Owner">
                                            <span>By Sarah Johnson</span>
                                        </a>
                                    </li>
                                    <li>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mix for-sale">
                        <div class="single-properties-item style-three wow animate__animated animate__fadeInUp delay-0-4s">
                            <div class="properties-img">
                                <a href="#">
                                    <img src="{{ asset('frontend/assets/images/properties/properties-2.jpg') }}" alt="The Alchemist Book Cover">
                                </a>
                                <span>Swap</span>
                                <button class="wish">
                                    <i class="ri-heart-3-line"></i>
                                </button>
                            </div>
                            <div class="properties-content">
                                <div class="border-style">
                                    <div class="d-flex justify-content-between">
                                        <a href="#">
                                            <h3>The Alchemist</h3>
                                        </a>
                                    </div>
                                    <p>
                                        <i class="ri-user-line"></i>
                                        <strong>Author:</strong> Paulo Coelho
                                    </p>
                                    <ul class="feature-list">
                                        <li>
                                            <i class="ri-bookmark-line"></i>
                                            Fiction
                                        </li>
                                        <li>
                                            <i class="ri-medal-line"></i>
                                            Good
                                        </li>
                                    </ul>
                                </div>

                                <ul class="user d-flex justify-content-between align-items-center">
                                    <li>
                                        <a href="#" class="agent-user">
                                            <img src="{{ asset('frontend/assets/images/agents/agent-2.jpg') }}" alt="Book Owner">
                                            <span>By Michael Chen</span>
                                        </a>
                                    </li>
                                    <li>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-half-line"></i>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mix for-rent">
                        <div class="single-properties-item style-three wow animate__animated animate__fadeInUp delay-0-6s">
                            <div class="properties-img">
                                <a href="#">
                                    <img src="{{ asset('frontend/assets/images/properties/properties-3.jpg') }}" alt="Sapiens Book Cover">
                                </a>
                                <span>Loan</span>
                                <button class="wish">
                                    <i class="ri-heart-3-line"></i>
                                </button>
                            </div>
                            <div class="properties-content">
                                <div class="border-style">
                                    <div class="d-flex justify-content-between">
                                        <a href="#">
                                            <h3>Sapiens</h3>
                                        </a>
                                    </div>
                                    <p>
                                        <i class="ri-user-line"></i>
                                        <strong>Author:</strong> Yuval Noah Harari
                                    </p>
                                    <ul class="feature-list">
                                        <li>
                                            <i class="ri-bookmark-line"></i>
                                            History
                                        </li>
                                        <li>
                                            <i class="ri-medal-line"></i>
                                            Excellent
                                        </li>
                                    </ul>
                                </div>

                                <ul class="user d-flex justify-content-between align-items-center">
                                    <li>
                                        <a href="#" class="agent-user">
                                            <img src="{{ asset('frontend/assets/images/agents/agent-3.jpg') }}" alt="Book Owner">
                                            <span>By Emma Rodriguez</span>
                                        </a>
                                    </li>
                                    <li>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mix for-sale">
                        <div class="single-properties-item style-three wow animate__animated animate__fadeInUp delay-0-8s">
                            <div class="properties-img">
                                <a href="#">
                                    <img src="{{ asset('frontend/assets/images/properties/properties-4.jpg') }}" alt="1984 Book Cover">
                                </a>
                                <span>Swap</span>
                                <button class="wish">
                                    <i class="ri-heart-3-line"></i>
                                </button>
                            </div>
                            <div class="properties-content">
                                <div class="border-style">
                                    <div class="d-flex justify-content-between">
                                        <a href="#">
                                            <h3>1984</h3>
                                        </a>
                                    </div>
                                    <p>
                                        <i class="ri-user-line"></i>
                                        <strong>Author:</strong> George Orwell
                                    </p>
                                    <ul class="feature-list">
                                        <li>
                                            <i class="ri-bookmark-line"></i>
                                            Dystopian Fiction
                                        </li>
                                        <li>
                                            <i class="ri-medal-line"></i>
                                            Very Good
                                        </li>
                                    </ul>
                                </div>

                                <ul class="user d-flex justify-content-between align-items-center">
                                    <li>
                                        <a href="#" class="agent-user">
                                            <img src="{{ asset('frontend/assets/images/agents/agent-4.jpg') }}" alt="Book Owner">
                                            <span>By David Wilson</span>
                                        </a>
                                    </li>
                                    <li>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-half-line"></i>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 text-center">
                        <a href="{{ route('frontend.browse-books') }}" class="default-btn btn-radius">
                            View All Books
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Properties Area -->

        <!-- Start Meet Our Agents Area -->
    <div class="meet-our-agents-area pt-100 pb-70">
        <div class="container">
            <div class="section-title left-title">
                <h2>Meet Our Team</h2>
            </div>

            <div class="agents-slide-two owl-carousel owl-theme">
                <div class="single-agents wow animate__animated animate__fadeInUp delay-0-2s">
                    <div class="agents-img mb-0">
                        <img src="{{ asset('frontend/assets/images/agents/agent-9.jpg') }}" alt="Image">
                        <span>8 Listing</span>
                        <p>Rello RealEstate Agency</p>
                    </div>

                    <div class="agents-content style-two">
                        <div class="d-flex justify-content-between align-items-center align-items-center">
                            <h3>
                                <a href="#">Edward Mccoy</a>
                            </h3>

                            <div class="team-social">
                                <a href="#" class="control">
                                    <i class="ri-share-fill"></i>
                                </a>

                                <ul>
                                    <li>
                                        <a href="https://www.facebook.com/" target="_blank">
                                            <i class="ri-facebook-fill"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.instagram.com/" target="_blank">
                                            <i class="ri-instagram-line"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.linkedin.com/" target="_blank">
                                            <i class="ri-linkedin-fill"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://twitter.com/" target="_blank">
                                            <i class="ri-twitter-fill"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <ul class="info">
                            <li>
                                <a href="/cdn-cgi/l/email-protection#3f5a5b485e4d5b7f4d5a535350115c5052">
                                    <i class="ri-mail-line"></i>
                                    <span class="__cf_email__"
                                        data-cfemail="315455465043557143545d5d5e1f525e5c">[email&#160;protected]</span>
                                </a>
                            </li>
                        </ul>

                        <div class="view-call d-flex justify-content-between align-items-center">
                            <a href="tel:+1-719-504-1984">
                                <i class="ri-phone-fill"></i>
                                +1 719-504-1984
                            </a>
                            <a href="#" class="read-more">
                                View Profile
                                <i class="ri-arrow-right-line"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="single-agents wow animate__animated animate__fadeInUp delay-0-4s">
                    <div class="agents-img mb-0">
                        <img src="{{ asset('frontend/assets/images/agents/agent-10.jpg') }}" alt="Image">
                        <span>5 Listing</span>
                        <p>Pelody RealEstate Agency</p>
                    </div>

                    <div class="agents-content style-two">
                        <div class="d-flex justify-content-between align-items-center align-items-center">
                            <h3>
                                <a href="single-agents.html">Edward Mccoy</a>
                            </h3>

                            <div class="team-social">
                                <a href="#" class="control">
                                    <i class="ri-share-fill"></i>
                                </a>

                                <ul>
                                    <li>
                                        <a href="https://www.facebook.com/" target="_blank">
                                            <i class="ri-facebook-fill"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.instagram.com/" target="_blank">
                                            <i class="ri-instagram-line"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.linkedin.com/" target="_blank">
                                            <i class="ri-linkedin-fill"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://twitter.com/" target="_blank">
                                            <i class="ri-twitter-fill"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <ul class="info">
                            <li>
                                <a href="/cdn-cgi/l/email-protection#b8dcdddad7cad9d0f8c8ddd4d7dcc196dbd7d5">
                                    <i class="ri-mail-line"></i>
                                    <span class="__cf_email__"
                                        data-cfemail="3a5e5f5855485b527a4a5f56555e4314595557">[email&#160;protected]</span>
                                </a>
                            </li>
                        </ul>

                        <div class="view-call d-flex justify-content-between align-items-center">
                            <a href="tel:+1-719-504-1984">
                                <i class="ri-phone-fill"></i>
                                +1 719-504-1984
                            </a>
                            <a href="single-agents.html" class="read-more">
                                View Profile
                                <i class="ri-arrow-right-line"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="single-agents wow animate__animated animate__fadeInUp delay-0-6s">
                    <div class="agents-img mb-0">
                        <img src="{{ asset('frontend/assets/images/agents/agent-11.jpg') }}" alt="Image">
                        <span>3 Listing</span>
                        <p>Ripeco RealEstate Agency</p>
                    </div>

                    <div class="agents-content style-two">
                        <div class="d-flex justify-content-between align-items-center align-items-center">
                            <h3>
                                <a href="single-agents.html">Edward Mccoy</a>
                            </h3>

                            <div class="team-social">
                                <a href="#" class="control">
                                    <i class="ri-share-fill"></i>
                                </a>

                                <ul>
                                    <li>
                                        <a href="https://www.facebook.com/" target="_blank">
                                            <i class="ri-facebook-fill"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.instagram.com/" target="_blank">
                                            <i class="ri-instagram-line"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.linkedin.com/" target="_blank">
                                            <i class="ri-linkedin-fill"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://twitter.com/" target="_blank">
                                            <i class="ri-twitter-fill"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <ul class="info">
                            <li>
                                <a href="/cdn-cgi/l/email-protection#73191600001a1633011a0316101c5d101c1e">
                                    <i class="ri-mail-line"></i>
                                    <span class="__cf_email__"
                                        data-cfemail="18727d6b6b717d586a71687d7b77367b7775">[email&#160;protected]</span>
                                </a>
                            </li>
                        </ul>

                        <div class="view-call d-flex justify-content-between align-items-center">
                            <a href="tel:+1-719-504-1984">
                                <i class="ri-phone-fill"></i>
                                +1 719-504-1984
                            </a>
                            <a href="single-agents.html" class="read-more">
                                View Profile
                                <i class="ri-arrow-right-line"></i>
                            </a>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <!-- End Meet Our Agents Area -->
@endsection
