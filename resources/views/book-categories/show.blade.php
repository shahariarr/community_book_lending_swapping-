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
                                         style="max-height: 200px;"
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
                                        <td>{{ $bookCategory->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Slug:</th>
                                        <td><code>{{ $bookCategory->slug }}</code></td>
                                    </tr>
                                    <tr>
                                        <th>Color:</th>
                                        <td>
                                            <div style="display: inline-flex; align-items: center;">
                                                <div style="width: 20px; height: 20px; background-color: {{ $bookCategory->color }}; border-radius: 3px; margin-right: 8px;"></div>
                                                {{ $bookCategory->color }}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Icon:</th>
                                        <td>
                                            @if($bookCategory->icon)
                                                <i class="{{ $bookCategory->icon }}"></i> {{ $bookCategory->icon }}
                                            @else
                                                <span class="text-muted">No icon</span>
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
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Sort Order:</th>
                                        <td>{{ $bookCategory->sort_order }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Books:</th>
                                        <td><span class="badge badge-info">{{ $bookCategory->books_count }}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Available Books:</th>
                                        <td><span class="badge badge-success">{{ $bookCategory->available_books_count }}</span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if($bookCategory->description)
                            <hr>
                            <h6>Description:</h6>
                            <p class="text-muted">{{ $bookCategory->description }}</p>
                        @endif

                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <strong>Created:</strong> {{ $bookCategory->created_at->format('M d, Y h:i A') }}
                                </small>
                            </div>
                            <div class="col-md-6 text-right">
                                <small class="text-muted">
                                    <strong>Updated:</strong> {{ $bookCategory->updated_at->format('M d, Y h:i A') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                @if($bookCategory->books->count() > 0)
                    <div class="card">
                        <div class="card-header">
                            <h4>Books in this Category ({{ $bookCategory->books->count() }})</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>Owner</th>
                                            <th>Status</th>
                                            <th>Condition</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bookCategory->books as $book)
                                            <tr>
                                                <td>{{ $book->title }}</td>
                                                <td>{{ $book->author }}</td>
                                                <td>{{ $book->owner->name }}</td>
                                                <td>
                                                    <span class="badge {{ $book->status_badge }}">
                                                        {{ $book->availability_status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge {{ $book->condition_badge }}">
                                                        {{ $book->condition }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Quick Stats</h4>
                    </div>
                    <div class="card-body">
                        <div class="summary">
                            <div class="summary-item">
                                <h6>Total Books</h6>
                                <h3 class="text-primary">{{ $bookCategory->books_count }}</h3>
                            </div>
                            <div class="summary-item">
                                <h6>Available Books</h6>
                                <h3 class="text-success">{{ $bookCategory->available_books_count }}</h3>
                            </div>
                            <div class="summary-item">
                                <h6>Borrowed Books</h6>
                                <h3 class="text-warning">{{ $bookCategory->books->where('availability_status', 'Borrowed')->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                    <div class="card">
                        <div class="card-header">
                            <h4>Actions</h4>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('books.create', ['category' => $bookCategory->id]) }}" class="btn btn-success btn-block">
                                <i class="bi bi-plus-circle"></i> Add Book to this Category
                            </a>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</section>
@endsection
