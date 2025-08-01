@extends('frontend.layouts.master')

@section('title', 'About Us - BookBub')

@section('content')
    <!-- Start Page Title Area -->
    <div class="page-title-area bg-2" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset('frontend/assets/images/team/library-interior-with-bookshelves-soft-lighting.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
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

    <!-- Start How BookBub Can Help Area -->
    <div class="can-help-area pt-100 pb-70">
        <div class="container">
            <div class="section-title text-center">
                <h2>See How BookBub Can Help</h2>
                <p>Discover the amazing features that make book sharing easy and enjoyable</p>
            </div>

            <div class="row justify-content-center g-4">
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                    <div class="single-can-help wow animate__animated animate__fadeInUp delay-0-2s h-100">
                        <div class="help-icon">
                            <img src="{{ asset('frontend/assets/images/team/4758000_39027.jpg') }}" alt="Borrow Books Service" class="img-fluid">
                        </div>
                        <h3>Borrow Books</h3>
                        <p>Discover and borrow books from community members. Find your next great read without spending money on new books.</p>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                    <div class="single-can-help wow animate__animated animate__fadeInUp delay-0-4s h-100">
                        <div class="help-icon">
                            <img src="{{ asset('frontend/assets/images/team/24748756_6966184.jpg') }}" alt="Swap Books Service" class="img-fluid">
                        </div>
                        <h3>Swap Books</h3>
                        <p>Trade books with other community members. Give away books you've finished reading and get new ones in return.</p>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                    <div class="single-can-help wow animate__animated animate__fadeInUp delay-0-6s h-100">
                        <div class="help-icon">
                            <img src="{{ asset('frontend/assets/images/team/5037820_31683-removebg-preview.png') }}" alt="Community Connection Service" class="img-fluid">
                        </div>
                        <h3>Community Connection</h3>
                        <p>Connect with fellow book lovers in your area. Build relationships through shared love of reading and literature.</p>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                    <div class="single-can-help wow animate__animated animate__fadeInUp delay-0-8s h-100">
                        <div class="help-icon">
                            <img src="{{ asset('frontend/assets/images/team/29243248_onlinesupport_3.jpg') }}" alt="Member Support Service" class="img-fluid">
                        </div>
                        <h3>Member Support</h3>
                        <p>Get help when you need it. Our community support team is here to ensure great experiences for all members.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End How BookBub Can Help Area -->
    <!-- End Can Help Area -->

    <!-- Start About BookBub Area -->
    <div class="about-rello-area pb-100">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="rello-about-img">
                        <img src="{{ asset('frontend/assets/images/team/library-interior-with-bookshelves-soft-lighting.jpg') }}" alt="Image">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="rello-about-content">
                        <h2>About BookBub</h2>
                        <p>BookBub is a community-driven platform that connects book lovers for lending and swapping books. We believe that great stories should be shared, and knowledge should be accessible to everyone.</p>
                        <p>Our platform makes it easy to discover new books, connect with fellow readers, and build a sustainable reading community. Whether you're looking to borrow your next favorite novel or share books that have changed your life, BookBub is here to help.</p>

                        <ul>
                            <li>
                                <i class="ri-lightbulb-line"></i>
                                <h3>Our Vision</h3>
                                <p>To create a world where every book lover has access to endless reading opportunities through community sharing, fostering connections and sustainable reading habits.</p>
                            </li>
                            <li>
                                <i class="ri-flag-line"></i>
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
