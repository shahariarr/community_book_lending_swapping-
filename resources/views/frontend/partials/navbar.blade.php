<div class="navbar-area">
    <div class="mobile-responsive-nav">
        <div class="container">
            <div class="mobile-responsive-menu">
                <div class="logo">
                    <a href="{{ route('frontend.home') }}">
                        <img src="{{ asset('frontend/assets/images/logo.png') }}" class="main-logo" alt="logo">
                        <img src="{{ asset('frontend/assets/images/white-logo.png') }}" class="white-logo" alt="logo">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="desktop-nav">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-md navbar-light">
                <a class="navbar-brand" href="{{ route('frontend.home') }}">
                    <img src="{{ asset('frontend/assets/images/logo.png') }}" class="main-logo" alt="logo">
                    <img src="{{ asset('frontend/assets/images/white-logo.png') }}" class="white-logo" alt="logo">
                </a>

                <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                    <div class="others-options">
                        <form class="search-form">
                            <input type="text" class="form-control" placeholder="Search...">
                            <button type="submit" class="src-btn">
                                <i class="ri-search-line"></i>
                            </button>
                        </form>
                    </div>

                    <ul class="navbar-nav m-auto">
                        <li class="nav-item">
                            <a href="{{ route('frontend.home') }}" class="nav-link dropdown-toggle {{ Request::routeIs('frontend.home') ? 'active' : '' }}">
                                Home
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('frontend.category') }}" class="nav-link dropdown-toggle {{ Request::routeIs('frontend.category') ? 'active' : '' }}">
                                Category
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('frontend.browse-books') }}" class="nav-link dropdown-toggle {{ Request::routeIs('frontend.browse-books') ? 'active' : '' }}">
                                Listings
                            </a>

                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a href="{{ route('frontend.browse-books') }}" class="nav-link">Swap Books</a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('frontend.browse-books') }}" class="nav-link">Loan Books</a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('frontend.blog') }}" class="nav-link dropdown-toggle {{ Request::routeIs('frontend.blog') ? 'active' : '' }}">
                                Blog
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('frontend.about') }}" class="nav-link {{ Request::routeIs('frontend.about') ? 'active' : '' }}">About Us</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('frontend.contact') }}" class="nav-link {{ Request::routeIs('frontend.contact') ? 'active' : '' }}">Contact</a>
                        </li>
                    </ul>

                    <div class="others-options style">
                        <ul>
                            <li>
                                <a href="{{ route('frontend.browse-books') }}" class="wishlist">
                                    <i class="ri-heart-line"></i>
                                    <span>0</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/login') }}" class="login">
                                    <i class="ri-user-line"></i>
                                    <span>Log In or Sign Up</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
