@extends('layouts.back')
@section('title', 'Dashboard')
@section('content')

<section class="section">
    <div class="section-header">
      <h1>Community Management Dashboard</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      </div>
    </div>

    <!-- User Information Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="mr-3">
                            <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('backend/assets/img/avatar/xyz.png') }}"
                                 alt="Profile Image"
                                 style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;">
                        </div>
                        <div>
                            <h4 class="mb-1">Welcome back, {{ $user->name }}!</h4>
                            <p class="text-muted mb-2"><strong>Email:</strong> {{ $user->email }}</p>
                            <p class="text-muted mb-0">
                                <strong>Role:</strong>
                                @if($user->roles->isNotEmpty())
                                    @foreach($user->roles as $role)
                                        <span class="badge badge-primary">{{ $role->name }}</span>
                                    @endforeach
                                @else
                                    <span class="badge badge-secondary">No Role Assigned</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-primary">
                <i class="fas fa-tags"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Categories</h4>
                </div>
                <div class="card-body">
                  {{ number_format($stats['total_categories']) }}
                </div>
              </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-info">
                <i class="fas fa-users"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Total Users</h4>
                </div>
                <div class="card-body">
                  {{ number_format($stats['total_users']) }}
                </div>
              </div>
            </div>
        </div>

        @if($isAdmin)
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-success">
                <i class="fas fa-check-circle"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Active Categories</h4>
                </div>
                <div class="card-body">
                  {{ number_format($stats['active_categories']) }}
                </div>
              </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-warning">
                <i class="fas fa-user-shield"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Total Members</h4>
                </div>
                <div class="card-body">
                  {{ number_format($stats['total_members']) }}
                </div>
              </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Quick Actions Section -->
    @if($isAdmin)
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-tags text-primary"></i> Category Management</h4>
                </div>
                <div class="card-body">
                    <p class="card-text">Manage and organize system categories efficiently.</p>
                    <div class="d-flex">
                        <a href="{{ route('book-categories.index') }}" class="btn btn-primary btn-sm mr-2">
                            <i class="fas fa-list"></i> View Categories
                        </a>
                        <a href="{{ route('book-categories.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Add Category
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-users text-info"></i> User Management</h4>
                </div>
                <div class="card-body">
                    <p class="card-text">Manage community members and their roles.</p>
                    <div class="d-flex">
                        <a href="{{ route('users.index') }}" class="btn btn-info btn-sm mr-2">
                            <i class="fas fa-users"></i> View Users
                        </a>
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-user-tag"></i> Manage Roles
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-tags text-primary"></i> Browse Categories</h4>
                </div>
                <div class="card-body">
                    <p class="card-text">Explore available categories in the system.</p>
                    <a href="{{ route('book-categories.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-search"></i> Browse Categories
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-user text-success"></i> Profile Management</h4>
                </div>
                <div class="card-body">
                    <p class="card-text">Manage your profile and account settings.</p>
                    <a href="{{ route('users.profile') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-edit"></i> Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- System Information Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-info-circle text-info"></i> Community Management System</h4>
                </div>
                <div class="card-body">
                    @if($isAdmin)
                    <!-- Admin System Information -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center mb-3">
                                <i class="fas fa-tags fa-2x text-primary mb-2"></i>
                                <h5>Category Management</h5>
                                <p class="text-muted small">Organize and manage system categories with colors, icons, and descriptions</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center mb-3">
                                <i class="fas fa-users fa-2x text-info mb-2"></i>
                                <h5>User Management</h5>
                                <p class="text-muted small">Control user access, roles, and permissions across the platform</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center mb-3">
                                <i class="fas fa-cogs fa-2x text-warning mb-2"></i>
                                <h5>System Settings</h5>
                                <p class="text-muted small">Configure and maintain system-wide settings and preferences</p>
                            </div>
                        </div>
                    </div>
                    @else
                    <!-- User System Information -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="text-center mb-3">
                                <i class="fas fa-tags fa-2x text-primary mb-2"></i>
                                <h5>Explore Categories</h5>
                                <p class="text-muted small">Browse through organized categories and discover content</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center mb-3">
                                <i class="fas fa-user-circle fa-2x text-success mb-2"></i>
                                <h5>Personal Dashboard</h5>
                                <p class="text-muted small">Access your personal information and customize your experience</p>
                            </div>
                        </div>
                    </div>
                    @endif
                    <hr>
                    <div class="text-center">
                        <p class="mb-2">
                            <strong>Your Access Level:</strong>
                            <span class="badge badge-{{ $isAdmin ? 'danger' : 'primary' }}">
                                {{ $isAdmin ? 'Administrator' : 'Member' }}
                            </span>
                        </p>
                        <p class="mb-0 text-muted">Last updated: {{ now()->format('M d, Y \a\t h:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('css')
<style>
.card-statistic-1 {
    transition: transform 0.2s;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
.card-statistic-1:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.card {
    border-radius: 10px;
    border: none;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
    border-radius: 10px 10px 0 0 !important;
}
</style>
@endpush

@endsection
