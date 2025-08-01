<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Links Of CSS File -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/flaticon.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('frontend/assets/css/remixicon.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/meanmenu.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/magnific-popup.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/custom-styles.css') }}">
    <link  href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"  rel="stylesheet"/>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('frontend/assets/images/favicon.png') }}">

    <!-- Title -->
    <title>@yield('title', 'BookBub - Community Book Lending & Swapping')</title>

    <!-- Custom Availability Styles -->
    <style>
        .availability-badge {
            position: absolute !important;
            top: 15px !important;
            right: 15px !important;
            padding: 5px 12px !important;
            border-radius: 20px !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            z-index: 2 !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15) !important;
        }
        .availability-badge.loan {
            background-color: #28a745 !important;
            color: white !important;
        }
        .availability-badge.swap {
            background-color: #007bff !important;
            color: white !important;
        }
        .availability-badge.both {
            background-color: #6f42c1 !important;
            color: white !important;
        }
        .availability-info {
            color: #2b3b3a !important;
            font-size: 14px !important;
            margin-bottom: 10px !important;
            padding: 8px 12px !important;
            background-color: #f8f9fa !important;
            border-radius: 6px !important;
            border-left: 3px solid #006766 !important;
        }
        .availability-text.loan {
            color: #28a745 !important;
            font-weight: 600 !important;
        }
        .availability-text.swap {
            color: #007bff !important;
            font-weight: 600 !important;
        }
        .availability-text.both {
            color: #6f42c1 !important;
            font-weight: 600 !important;
        }
        .availability-badge-home {
            position: absolute !important;
            top: 10px !important;
            right: 10px !important;
            padding: 4px 10px !important;
            border-radius: 15px !important;
            font-size: 11px !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            z-index: 2 !important;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2) !important;
        }
        .availability-badge-home.loan {
            background-color: #28a745 !important;
            color: white !important;
        }
        .availability-badge-home.swap {
            background-color: #007bff !important;
            color: white !important;
        }
        .availability-badge-home.both {
            background-color: #6f42c1 !important;
            color: white !important;
        }
        .availability-text-home.loan {
            color: #28a745 !important;
            font-weight: 600 !important;
        }
        .availability-text-home.swap {
            color: #007bff !important;
            font-weight: 600 !important;
        }
        .availability-text-home.both {
            color: #6f42c1 !important;
            font-weight: 600 !important;
        }

        /* Book Categories Section - Fixed small size */
        .discover-area .single-discover img {
            width: 100% !important;
            height: 180px !important;
            object-fit: cover !important;
            object-position: center !important;
            border-radius: 8px !important;
        }

        /* Book Lists Section - Fixed size for book images */
        .discover-area .single-discover .book-image-container img {
            width: 100% !important;
            height: 250px !important;
            object-fit: cover !important;
            object-position: center !important;
            border-radius: 8px !important;
        }

        /* Browse Books Page - Fixed size for featured book images */
        .single-featured-item .featured-img img {
            width: 100% !important;
            height: 450px !important;
            object-fit: cover !important;
            object-position: center !important;
            border-radius: 8px !important;
        }

        .single-discover {
            max-width: 200px !important;
            margin: 0 auto !important;
        }

        .single-discover h3 {
            font-size: 16px !important;
            margin-top: 15px !important;
            margin-bottom: 5px !important;
            text-align: center !important;
            line-height: 1.3 !important;
        }

        .single-discover span {
            font-size: 14px !important;
            color: #666 !important;
            text-align: center !important;
            display: block !important;
        }

        /* List wrap span spacing */
        .list-wrap span {
            margin-right: 280px;
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Start Preloader Area -->
    @include('frontend.partials.preloader')
    <!-- End Preloader Area -->

    <!-- Start Navbar Area -->
    @include('frontend.partials.navbar')
    <!-- End Navbar Area -->

    <!-- Main Content -->
    @yield('content')

    <!-- Start Footer Area -->
    @include('frontend.partials.footer')
    <!-- End Footer Area -->

    <!-- Start Go Top Area -->
    @include('frontend.partials.go-top')
    <!-- End Go Top Area -->

    <!-- Links of JS File -->
    <script src="{{ asset('frontend/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/meanmenu.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/wow.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/mixitup.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/magnific-popup.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.sticky-sidebar.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/form-validator.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/contact-form-script.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/custom.js') }}"></script>

    @stack('scripts')
</body>

</html>
