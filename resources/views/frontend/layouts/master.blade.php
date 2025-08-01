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
    <link  href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"  rel="stylesheet"/>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('frontend/assets/images/favicon.png') }}">

    <!-- Title -->
    <title>@yield('title', 'BookBub - Community Book Lending & Swapping')</title>

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
