@extends('frontend.layouts.master')

@section('title', 'Categories - BookBub')

@section('content')
    <!-- Start Page Title Area -->
    <div class="page-title-area bg-2" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset('frontend/assets/images/team/library-interior-with-bookshelves-soft-lighting.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
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
                @forelse($categories as $index => $category)
                    <div class="col-lg-3 col-sm-6">
                        <div class="single-discover wow animate__animated animate__fadeInUp delay-0-{{ ($index % 4 + 1) * 2 }}s">
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
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center">
                            <h4>No categories available at the moment.</h4>
                            <p>Please check back later for more book categories.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- End Discover Area -->
@endsection
