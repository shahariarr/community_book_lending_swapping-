@extends('frontend.layouts.master')

@section('title', 'Blog - BookBub')

@section('content')
    <!-- Start Page Title Area -->
    <div class="page-title-area bg-6">
        <div class="container">
            <div class="page-title-content">
                <h2>Book Exchange Blog</h2>

                <ul>
                    <li>
                        <a href="{{ route('frontend.home') }}">
                            Home
                        </a>
                    </li>

                    <li class="active">Blog</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- End Page Title Area -->

    <!-- Start Blog Area -->
    <div class="blog-area ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="single-blog wow animate__animated animate__fadeInUp delay-0-2s ">
                                <a href="#">
                                    <img src="{{ asset('frontend/assets/images/blog/blog-1.jpg') }}" alt="Image">
                                </a>
                                <div class="blog-content">
                                    <ul>
                                        <li>
                                            <a href="#">
                                                <img src="{{ asset('frontend/assets/images/blog/user-1.jpg') }}" alt="Image">
                                                By Sarah Johnson
                                            </a>
                                        </li>
                                        <li>
                                            <i class="ri-calendar-line"></i>
                                            8 Dec, 2024
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="ri-chat-2-line"></i>
                                                (12) Comments
                                            </a>
                                        </li>
                                    </ul>
                                    <h3>
                                        <a href="#">
                                            Best Tips for Book Swapping and Community Building
                                        </a>
                                    </h3>
                                    <p>Discover the art of book swapping and how to build meaningful connections with fellow book lovers. Learn about organizing book clubs, hosting reading events, and creating a thriving community of readers who share their passion for literature.</p>

                                    <a href="#" class="default-btn">
                                        Read More
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="single-blog wow animate__animated animate__fadeInUp delay-0-4s ">
                                <a href="#">
                                    <img src="{{ asset('frontend/assets/images/blog/blog-2.jpg') }}" alt="Image">
                                </a>
                                <div class="blog-content">
                                    <ul>
                                        <li>
                                            <a href="#">
                                                <img src="{{ asset('frontend/assets/images/blog/user-2.jpg') }}" alt="Image">
                                                By Michael Chen
                                            </a>
                                        </li>
                                        <li>
                                            <i class="ri-calendar-line"></i>
                                            9 Dec, 2024
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="ri-chat-2-line"></i>
                                                (8) Comments
                                            </a>
                                        </li>
                                    </ul>
                                    <h3>
                                        <a href="#">
                                            Top 5 Ways to Care for Your Books and Keep Them in Perfect Condition
                                        </a>
                                    </h3>
                                    <p>Learn essential book care techniques to maintain your collection in pristine condition. From proper storage methods to cleaning tips, discover how to preserve your books for years to come and ensure they remain valuable for trading and lending.</p>

                                    <a href="#" class="default-btn">
                                        Read More
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="single-blog wow animate__animated animate__fadeInUp delay-0-6s ">
                                <a href="#">
                                    <img src="{{ asset('frontend/assets/images/blog/blog-3.jpg') }}" alt="Image">
                                </a>
                                <div class="blog-content">
                                    <ul>
                                        <li>
                                            <a href="#">
                                                <img src="{{ asset('frontend/assets/images/blog/user-3.jpg') }}" alt="Image">
                                                By Emma Rodriguez
                                            </a>
                                        </li>
                                        <li>
                                            <i class="ri-calendar-line"></i>
                                            10 Dec, 2024
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="ri-chat-2-line"></i>
                                                (15) Comments
                                            </a>
                                        </li>
                                    </ul>
                                    <h3>
                                        <a href="#">
                                            Why Building a Reading Community Matters in the Digital Age
                                        </a>
                                    </h3>
                                    <p>Explore the importance of connecting with fellow readers and book enthusiasts in our increasingly digital world. Discover how book sharing platforms foster meaningful relationships and create lasting bonds through the shared love of literature.</p>

                                    <a href="#" class="default-btn">
                                        Read More
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="pagination-area">
                                <a href="#" class="next page-numbers">
                                    <i class="ri-arrow-left-line"></i>
                                </a>
                                <span class="page-numbers current" aria-current="page">1</span>
                                <a href="#" class="page-numbers">2</a>
                                <a href="#" class="page-numbers">3</a>

                                <a href="#" class="next page-numbers">
                                    <i class="ri-arrow-right-line"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="widget-sidebar ml-15">
                        <div class="sidebar-widget src-forms">
                            <form class="src-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <button class="src-btn">
                                    <i class="ri-search-line"></i>
                                </button>
                            </form>
                        </div>

                        <div class="sidebar-widget categories">
                            <h3>Book Categories</h3>

                            <ul>
                                <li>
                                    <a href="#">
                                        Fiction
                                        <span>(25)</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        Non-Fiction
                                        <span>(18)</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        Mystery & Thriller
                                        <span>(12)</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        Self-Help
                                        <span>(15)</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        Fantasy
                                        <span>(20)</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        Romance
                                        <span>(14)</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="sidebar-widget recent-post">
                            <h3>Featured Books</h3>

                            <article class="item">
                                <a href="#" class="thumb">
                                    <span class="fullimage cover bg-1" role="img"></span>
                                </a>
                                <div class="info">
                                    <h4 class="title usmall">
                                        <a href="#">The Great Gatsby</a>
                                    </h4>
                                    <span class="date">
                                        <i class="ri-user-fill"></i>
                                        By F. Scott Fitzgerald
                                    </span>
                                    <h5>Available for Swap</h5>
                                </div>
                            </article>

                            <article class="item">
                                <a href="#" class="thumb">
                                    <span class="fullimage cover bg-2" role="img"></span>
                                </a>
                                <div class="info">
                                    <h4 class="title usmall">
                                        <a href="#">1984</a>
                                    </h4>
                                    <span class="date">
                                        <i class="ri-user-fill"></i>
                                        By George Orwell
                                    </span>
                                    <h5>Available for Loan</h5>
                                </div>
                            </article>

                            <article class="item">
                                <a href="#" class="thumb">
                                    <span class="fullimage cover bg-3" role="img"></span>
                                </a>
                                <div class="info">
                                    <h4 class="title usmall">
                                        <a href="#">Pride and Prejudice</a>
                                    </h4>
                                    <span class="date">
                                        <i class="ri-user-fill"></i>
                                        By Jane Austen
                                    </span>
                                    <h5>Available for Swap</h5>
                                </div>
                            </article>
                        </div>

                        <div class="sidebar-widget tags">
                            <h3>Popular Tags</h3>

                            <ul>
                                <li>
                                    <a href="#">
                                        Book Exchange
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        Reading
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        Literature
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        Book Swap
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        Fiction
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        Community
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        Book Club
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        Reviews
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        Authors
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Blog Area -->
@endsection
