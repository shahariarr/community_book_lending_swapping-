@extends('frontend.layouts.master')

@section('title', 'Categories - BookBub')

@section('content')
    <!-- Start Page Title Area -->
    <div class="page-title-area bg-3">
        <div class="container">
            <div class="page-title-content">
                <h2>Book Categories</h2>

                <ul>
                    <li>
                        <a href="{{ route('frontend.home') }}">
                            Home
                        </a>
                    </li>

                    <li class="active">Categories</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- End Page Title Area -->

    <!-- Start Discover Area -->
    <div class="discover-area bg-color-f2f7fd pt-100 pb-70">
        <div class="container">
            <div class="section-title">
                <h2>Explore Book Categories</h2>
                <p>Discover books across various genres and categories. From fiction to non-fiction, find exactly what
                    you're looking for.</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-3 col-sm-6">
                    <div class="single-discover wow animate__animated animate__fadeInUp delay-0-2s">
                        <a href="{{ route('frontend.browse-books') }}">
                            <img src="{{ asset('frontend/assets/images/discover/discover-1.jpg') }}" alt="Fiction Books">
                            <h3>Fiction</h3>
                            <span>458 Books</span>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="single-discover wow animate__animated animate__fadeInUp delay-0-4s">
                        <a href="{{ route('frontend.browse-books') }}">
                            <img src="{{ asset('frontend/assets/images/discover/discover-2.jpg') }}"
                                alt="Non-Fiction Books">
                            <h3>Non-Fiction</h3>
                            <span>245 Books</span>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="single-discover wow animate__animated animate__fadeInUp delay-0-6s">
                        <a href="{{ route('frontend.browse-books') }}">
                            <img src="{{ asset('frontend/assets/images/discover/discover-3.jpg') }}" alt="Science Books">
                            <h3>Science</h3>
                            <span>105 Books</span>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="single-discover wow animate__animated animate__fadeInUp delay-0-8s">
                        <a href="{{ route('frontend.browse-books') }}">
                            <img src="{{ asset('frontend/assets/images/discover/discover-4.jpg') }}" alt="Mystery Books">
                            <h3>Mystery</h3>
                            <span>325 Books</span>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="single-discover wow animate__animated animate__fadeInUp delay-0-2s">
                        <a href="{{ route('frontend.browse-books') }}">
                            <img src="{{ asset('frontend/assets/images/discover/discover-5.jpg') }}" alt="Romance Books">
                            <h3>Romance</h3>
                            <span>230 Books</span>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="single-discover wow animate__animated animate__fadeInUp delay-0-4s">
                        <a href="{{ route('frontend.browse-books') }}">
                            <img src="{{ asset('frontend/assets/images/discover/discover-6.jpg') }}" alt="Biography Books">
                            <h3>Biography</h3>
                            <span>145 Books</span>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="single-discover wow animate__animated animate__fadeInUp delay-0-4s">
                        <a href="{{ route('frontend.browse-books') }}">
                            <img src="{{ asset('frontend/assets/images/discover/discover-6.jpg') }}" alt="Biography Books">
                            <h3>Biography</h3>
                            <span>145 Books</span>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
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
    </div>
    <!-- End Discover Area -->
@endsection
