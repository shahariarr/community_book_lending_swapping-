@php
$user = Auth::user();
@endphp

<style>
    .nav-link-user img.rounded-circle {
        width: 45px;
        height: 37px;
        object-fit: cover;
        object-position: center;
        border: 1px solid rgba(255,255,255,0.2);
    }
</style>

  <nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
      <ul class="navbar-nav mr-3">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
      </ul>
      <div class="search-element">
        <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
        <button class="btn" type="submit"><i class="fas fa-search"></i></button>
        <div class="search-backdrop"></div>
      </div>
    </form>
    <ul class="navbar-nav navbar-right">

    <!-- Frontend Website Link -->
    <li class="dropdown dropdown-list-toggle">
        <a href="{{ route('frontend.home') }}" class="nav-link nav-link-lg" title="Go to Frontend Website" target="_blank">
            <i class="fas fa-external-link-alt"></i>
            <span class="d-none d-md-inline ml-1">Frontend</span>
        </a>
    </li>

    @if($user->hasRole(['admin', 'super admin']))
    <li class="dropdown dropdown-list-toggle"><a href="{{ route('clear') }}" class="nav-link nav-link-lg beep"><i class="fas fa-broom"></i></a>

    </li>


    <li class="dropdown dropdown-list-toggle"><a href="{{ route('route') }}" class="nav-link nav-link-lg beep"><i class="fas fa-route"></i></a>
    </li>
    @endif




    <li class="dropdown">
        <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="{{ $user->image ? asset('storage/' . $user->image) . '?t=' . time() : asset('backend/assets/img/avatar/xyz.png') }}" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hi, {{ $user->name }}</div>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <a href="{{ route('users.profile') }}" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
            </a>
            <div class="dropdown-divider"></div>
            <a href="{{ route('logout') }}"
               class="dropdown-item has-icon text-danger"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </li>
    </ul>
  </nav>
