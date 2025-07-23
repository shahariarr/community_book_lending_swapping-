@extends('layouts.back')
@section('title', 'View Book')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Book Details</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('books.index') }}">Books</a></div>
            <div class="breadcrumb-item">{{ $book->title }}</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ $book->title }}</h4>
                        <div class="card-header-form">
                            <a href="{{ route('books.index') }}" class="btn btn-primary">
                                <i class="bi bi-arrow-left"></i> Back to Books
                            </a>
                            <a href="{{ route('books.edit', $book) }}" class="btn btn-warning">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($book->cover_image)
                            <div class="row mb-4">
                                <div class="col-12 text-center">
                                    <img src="{{ asset('storage/book-covers/' . $book->cover_image) }}"
                                         alt="{{ $book->title }}"
                                         class="img-fluid rounded shadow"
                                         style="max-height: 300px;"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                    <div style="display: none;" class="alert alert-info">
                                        <i class="bi bi-image"></i> Cover image not found: {{ $book->cover_image }}
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="30%">Title:</th>
                                        <td>{{ $book->title }}</td>
                                    </tr>
                                    <tr>
                                        <th>Author:</th>
                                        <td>{{ $book->author }}</td>
                                    </tr>
                                    <tr>
                                        <th>Category:</th>
                                        <td>
                                            @if($book->category)
                                                <a href="{{ route('book-categories.show', $book->category) }}" class="badge badge-info">
                                                    {{ $book->category->name }}
                                                </a>
                                            @else
                                                <span class="text-muted">No category</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>ISBN:</th>
                                        <td>{{ $book->isbn ?: 'Not specified' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Publisher:</th>
                                        <td>{{ $book->publisher ?: 'Not specified' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Publication Year:</th>
                                        <td>{{ $book->publication_year ?: 'Not specified' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="30%">Owner:</th>
                                        <td>{{ $book->owner ? $book->owner->name : 'Unknown' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td>
                                            <span class="badge {{ $book->status_badge }}">
                                                {{ $book->availability_status }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Condition:</th>
                                        <td>
                                            <span class="badge {{ $book->condition_badge }}">
                                                {{ $book->condition }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Pages:</th>
                                        <td>{{ $book->pages ?: 'Not specified' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Language:</th>
                                        <td>{{ $book->language ?: 'Not specified' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Price:</th>
                                        <td>
                                            @if($book->price)
                                                ${{ number_format($book->price, 2) }}
                                            @else
                                                Not specified
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if($book->description)
                            <hr>
                            <h6>Description:</h6>
                            <p class="text-muted">{{ $book->description }}</p>
                        @endif

                        @if($book->notes)
                            <hr>
                            <h6>Notes:</h6>
                            <p class="text-muted">{{ $book->notes }}</p>
                        @endif

                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <strong>Added:</strong> {{ $book->created_at->format('M d, Y h:i A') }}
                                </small>
                            </div>
                            <div class="col-md-6 text-right">
                                <small class="text-muted">
                                    <strong>Updated:</strong> {{ $book->updated_at->format('M d, Y h:i A') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Quick Actions</h4>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <a href="{{ route('books.edit', $book) }}" class="list-group-item list-group-item-action">
                                <i class="bi bi-pencil-square text-warning"></i> Edit Book Details
                            </a>
                            @if($book->availability_status == 'Available')
                                <a href="#" class="list-group-item list-group-item-action">
                                    <i class="bi bi-hand-thumbs-up text-success"></i> Mark as Borrowed
                                </a>
                            @elseif($book->availability_status == 'Borrowed')
                                <a href="#" class="list-group-item list-group-item-action">
                                    <i class="bi bi-arrow-return-left text-info"></i> Mark as Returned
                                </a>
                            @endif
                            <a href="#" class="list-group-item list-group-item-action">
                                <i class="bi bi-bookmark text-primary"></i> Add to Favorites
                            </a>
                        </div>
                    </div>
                </div>

                @if($book->category)
                    <div class="card">
                        <div class="card-header">
                            <h4>Category Info</h4>
                        </div>
                        <div class="card-body">
                            <div class="media">
                                @if($book->category->icon)
                                    <div class="media-object mr-3">
                                        <i class="{{ $book->category->icon }}" style="font-size: 24px; color: {{ $book->category->color }}"></i>
                                    </div>
                                @endif
                                <div class="media-body">
                                    <h6 class="media-title">{{ $book->category->name }}</h6>
                                    @if($book->category->description)
                                        <small class="text-muted">{{ $book->category->description }}</small>
                                    @endif
                                    <div class="mt-2">
                                        <a href="{{ route('book-categories.show', $book->category) }}" class="btn btn-sm btn-outline-primary">
                                            View Category
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
