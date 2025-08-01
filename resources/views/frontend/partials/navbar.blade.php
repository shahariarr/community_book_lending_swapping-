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
                            <a href="{{ route('frontend.home') }}" class=" {{ Request::routeIs('frontend.home') ? 'active' : '' }}">
                                Home
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('frontend.category') }}" class=" {{ Request::routeIs('frontend.category') ? 'active' : '' }}">
                                Category
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('frontend.browse-books') }}" class=" {{ Request::routeIs('frontend.browse-books') ? 'active' : '' }}">
                                Listings
                            </a>

                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a href="{{ route('frontend.browse-books') }}?availability_type=swap" class="nav-link">Swap Books</a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('frontend.browse-books') }}?availability_type=loan" class="nav-link">Loan Books</a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('frontend.browse-books') }}?availability_type=both" class="nav-link">Both Books</a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('frontend.browse-books') }}" class="nav-link">All Books</a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('frontend.blog') }}" class=" {{ Request::routeIs('frontend.blog') ? 'active' : '' }}">
                                Blog
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('frontend.about') }}" class=" {{ Request::routeIs('frontend.about') ? 'active' : '' }}">About Us</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('frontend.contact') }}" class="{{ Request::routeIs('frontend.contact') ? 'active' : '' }}">Contact</a>
                        </li>
                    </ul>

                    <div class="others-options style">
                        <ul>
                            @auth
                                <!-- Quick Dashboard Access Button -->
                                <li class="me-3">
                                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-primary d-none d-lg-inline-block" title="Go to Dashboard">
                                        <i class="ri-dashboard-line"></i>
                                        <span class="ms-1">Dashboard</span>
                                    </a>
                                </li>

                                <li class="dropdown">
                                    <a href="#" class="login dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        @if(auth()->user()->profile_image)
                                            <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Profile" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 8px;">
                                        @else
                                            <i class="ri-user-fill"></i>
                                        @endif
                                        <span>{{ auth()->user()->name }}</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('dashboard') }}" class="dropdown-item"><i class="ri-dashboard-line me-2"></i>Dashboard</a></li>
                                        <li><a href="{{ route('books.my-books') }}" class="dropdown-item"><i class="ri-book-line me-2"></i>My Books</a></li>
                                        <li><a href="{{ route('users.profile') }}" class="dropdown-item"><i class="ri-user-settings-line me-2"></i>Profile</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a href="{{ route('logout') }}" class="dropdown-item"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="ri-logout-circle-line me-2"></i> Logout
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @else
                                <li>
                                    <a href="{{ url('/login') }}" class="login">
                                        <i class="ri-login-circle-fill"></i>
                                        <span>Log In or Sign Up</span>
                                    </a>
                                </li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
