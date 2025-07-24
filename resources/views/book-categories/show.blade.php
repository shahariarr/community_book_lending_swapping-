@extends('layouts.back')
@section('title', 'View Book Category')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Book Category Details</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('book-categories.index') }}">Book Categories</a></div>
            <div class="breadcrumb-item">{{ $bookCategory->name }}</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            @if($bookCategory->icon)
                                <i class="{{ $bookCategory->icon }}" style="color: {{ $bookCategory->color }}"></i>
                            @endif
                            {{ $bookCategory->name }}
                            @if($bookCategory->is_active)
                                <span class="badge badge-success ml-2">Active</span>
                            @else
                                <span class="badge badge-danger ml-2">Inactive</span>
                            @endif
                        </h4>
                        <div class="card-header-form">
                            <a href="{{ route('book-categories.index') }}" class="btn btn-primary">
                                <i class="bi bi-arrow-left"></i> Back to Categories
                            </a>
                            <a href="{{ route('book-categories.edit', $bookCategory) }}" class="btn btn-warning">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($bookCategory->image)
                            <div class="row mb-4">
                                <div class="col-12 text-center">
                                    <img src="{{ asset('storage/category-images/' . $bookCategory->image) }}"
                                         alt="{{ $bookCategory->name }}"
                                         class="img-fluid rounded shadow"
                                         style="max-height: 200px; border-radius: 10px;"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                    <div style="display: none;" class="alert alert-info">
                                        <i class="bi bi-image"></i> Image not found: {{ $bookCategory->image }}
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="30%">Name:</th>
                                        <td><strong>{{ $bookCategory->name }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Slug:</th>
                                        <td><code class="bg-light px-2 py-1 rounded">{{ $bookCategory->slug }}</code></td>
                                    </tr>
                                    <tr>
                                        <th>Color:</th>
                                        <td>
                                            <div style="display: inline-flex; align-items: center;">
                                                <div style="width: 25px; height: 25px; background-color: {{ $bookCategory->color }}; border-radius: 5px; margin-right: 10px; border: 2px solid #dee2e6;"></div>
                                                <span class="font-weight-bold">{{ $bookCategory->color }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Icon:</th>
                                        <td>
                                            @if($bookCategory->icon)
                                                <i class="{{ $bookCategory->icon }}" style="font-size: 1.2em; color: {{ $bookCategory->color }};"></i>
                                                <code class="ml-2 bg-light px-2 py-1 rounded">{{ $bookCategory->icon }}</code>
                                            @else
                                                <span class="text-muted">No icon assigned</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="30%">Status:</th>
                                        <td>
                                            @if($bookCategory->is_active)
                                                <span class="badge badge-success px-3 py-2">
                                                    <i class="fas fa-check-circle"></i> Active
                                                </span>
                                            @else
                                                <span class="badge badge-danger px-3 py-2">
                                                    <i class="fas fa-times-circle"></i> Inactive
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Sort Order:</th>
                                        <td>
                                            <span class="badge badge-info px-3 py-2">
                                                <i class="fas fa-sort-numeric-down"></i> {{ $bookCategory->sort_order }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Created:</th>
                                        <td>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar"></i> {{ $bookCategory->created_at->format('M d, Y h:i A') }}
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Updated:</th>
                                        <td>
                                            <small class="text-muted">
                                                <i class="fas fa-clock"></i> {{ $bookCategory->updated_at->format('M d, Y h:i A') }}
                                            </small>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if($bookCategory->description)
                            <hr>
                            <div class="mb-3">
                                <h6 class="text-primary">
                                    <i class="fas fa-align-left"></i> Description:
                                </h6>
                                <div class="bg-light p-3 rounded">
                                    <p class="mb-0">{{ $bookCategory->description }}</p>
                                </div>
                            </div>
                        @endif

                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <i class="fas fa-plus-circle text-success"></i>
                                    <strong>Created:</strong> {{ $bookCategory->created_at->format('M d, Y h:i A') }}
                                </small>
                            </div>
                            <div class="col-md-6 text-right">
                                <small class="text-muted">
                                    <i class="fas fa-edit text-warning"></i>
                                    <strong>Last Updated:</strong> {{ $bookCategory->updated_at->format('M d, Y h:i A') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-info-circle text-info"></i> Category Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            @if($bookCategory->icon)
                                <i class="{{ $bookCategory->icon }}" style="font-size: 3em; color: {{ $bookCategory->color }};"></i>
                            @else
                                <i class="fas fa-tag" style="font-size: 3em; color: #6c757d;"></i>
                            @endif
                        </div>

                        <div class="summary">
                            <div class="summary-item text-center mb-3">
                                <h6 class="text-muted">Created Date</h6>
                                <h5 class="text-primary">{{ $bookCategory->created_at->format('M d, Y') }}</h5>
                            </div>
                            <div class="summary-item text-center mb-3">
                                <h6 class="text-muted">Last Updated</h6>
                                <h5 class="text-info">{{ $bookCategory->updated_at->format('M d, Y') }}</h5>
                            </div>
                            <div class="summary-item text-center">
                                <h6 class="text-muted">Status</h6>
                                @if($bookCategory->is_active)
                                    <h5 class="text-success">
                                        <i class="fas fa-check-circle"></i> Active
                                    </h5>
                                @else
                                    <h5 class="text-danger">
                                        <i class="fas fa-times-circle"></i> Inactive
                                    </h5>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-tools text-warning"></i> Quick Actions</h4>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('book-categories.edit', $bookCategory) }}" class="btn btn-warning btn-block mb-2">
                            <i class="bi bi-pencil-square"></i> Edit Category
                        </a>

                        <a href="{{ route('book-categories.index') }}" class="btn btn-primary btn-block mb-2">
                            <i class="fas fa-list"></i> All Categories
                        </a>

                        <a href="{{ route('book-categories.create') }}" class="btn btn-success btn-block mb-3">
                            <i class="fas fa-plus"></i> Add New Category
                        </a>

                        <hr>

                        <form action="{{ route('book-categories.destroy', $bookCategory) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block">
                                <i class="bi bi-trash"></i> Delete Category
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Category Preview Card -->
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-eye text-primary"></i> Category Preview</h4>
                    </div>
                    <div class="card-body text-center">
                        <div class="p-3 rounded" style="background-color: {{ $bookCategory->color }}20; border: 2px solid {{ $bookCategory->color }};">
                            @if($bookCategory->icon)
                                <i class="{{ $bookCategory->icon }}" style="font-size: 2em; color: {{ $bookCategory->color }};"></i>
                            @endif
                            <h5 class="mt-2 mb-0" style="color: {{ $bookCategory->color }};">{{ $bookCategory->name }}</h5>
                            @if($bookCategory->description)
                                <small class="text-muted d-block mt-1">{{ Str::limit($bookCategory->description, 50) }}</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('css')
<style>
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
.summary-item {
    padding: 10px 0;
}
.table th {
    border: none;
    font-weight: 600;
    color: #6c757d;
}
.table td {
    border: none;
    padding: 8px 0;
}
.btn {
    border-radius: 6px;
}
</style>
@endpush

@endsection
