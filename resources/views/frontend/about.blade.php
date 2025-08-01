@extends('frontend.layouts.master')

@section('title', 'About Us - BookBub')

@section('content')
    <!-- Start Page Title Area -->
    <div class="page-title-area bg-1">
        <div class="container">
            <div class="page-title-content">
                <h2>About Us</h2>

                <ul>
                    <li>
                        <a href="{{ route('frontend.home') }}">
                            Home
                        </a>
                    </li>

                    <li class="active">About Us</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- End Page Title Area -->

    <div class="can-help-area pt-100 pb-70">
        <div class="container">
            <div class="section-title">
                <h2>See How BookBub Can Help</h2>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-3 col-sm-6">
                    <div class="single-can-help wow animate__animated animate__fadeInUp delay-0-2s">
                        <img src="{{ asset('frontend/assets/images/can-help/can-help-1.png') }}" alt="Image">
                        <h3>Borrow Books</h3>
                        <p>Discover and borrow books from community members. Find your next great read without spending money on new books.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="single-can-help wow animate__animated animate__fadeInUp delay-0-4s">
                        <img src="{{ asset('frontend/assets/images/can-help/can-help-2.png') }}" alt="Image">
                        <h3>Swap Books</h3>
                        <p>Trade books with other community members. Give away books you've finished reading and get new ones in return.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="single-can-help wow animate__animated animate__fadeInUp delay-0-6s">
                        <img src="{{ asset('frontend/assets/images/can-help/can-help-3.png') }}" alt="Image">
                        <h3>Community Connection</h3>
                        <p>Connect with fellow book lovers in your area. Build relationships through shared love of reading and literature.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="single-can-help wow animate__animated animate__fadeInUp delay-0-8s">
                        <img src="{{ asset('frontend/assets/images/can-help/can-help-4.png') }}" alt="Image">
                        <h3>Member Support</h3>
                        <p>Get help when you need it. Our community support team is here to ensure great experiences for all members.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Can Help Area -->

    <!-- Start About BookBub Area -->
    <div class="about-rello-area pb-100">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="rello-about-img">
                        <img src="{{ asset('frontend/assets/images/rell-about-img.jpg') }}" alt="Image">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="rello-about-content">
                        <h2>About BookBub</h2>
                        <p>BookBub is a community-driven platform that connects book lovers for lending and swapping books. We believe that great stories should be shared, and knowledge should be accessible to everyone.</p>
                        <p>Our platform makes it easy to discover new books, connect with fellow readers, and build a sustainable reading community. Whether you're looking to borrow your next favorite novel or share books that have changed your life, BookBub is here to help.</p>

                        <ul>
                            <li>
                                <i class="flaticon-terraced-house"></i>
                                <h3>Our Vision</h3>
                                <p>To create a world where every book lover has access to endless reading opportunities through community sharing, fostering connections and sustainable reading habits.</p>
                            </li>
                            <li>
                                <i class="flaticon-interest-rate"></i>
                                <h3>Our Mission</h3>
                                <p>To build the largest community-driven book sharing platform that makes reading affordable, accessible, and socially connected for everyone.</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End About BookBub Area -->
@endsection
