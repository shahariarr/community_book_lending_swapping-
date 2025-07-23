@extends('layouts.back')
@section('title', 'Edit Book')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Edit Book</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('books.index') }}">Books</a></div>
            <div class="breadcrumb-item">Edit</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Book: {{ $book->title }}</h4>
                        <div class="card-header-form">
                            <a href="{{ route('books.index') }}" class="btn btn-primary">
                                <i class="bi bi-arrow-left"></i> Back to Books
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">Book Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" id="title"
                                               class="form-control @error('title') is-invalid @enderror"
                                               value="{{ old('title', $book->title) }}" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="author">Author <span class="text-danger">*</span></label>
                                        <input type="text" name="author" id="author"
                                               class="form-control @error('author') is-invalid @enderror"
                                               value="{{ old('author', $book->author) }}" required>
                                        @error('author')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="book_category_id">Category <span class="text-danger">*</span></label>
                                        <select name="book_category_id" id="book_category_id"
                                                class="form-control @error('book_category_id') is-invalid @enderror" required>
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('book_category_id', $book->book_category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('book_category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="isbn">ISBN</label>
                                        <input type="text" name="isbn" id="isbn"
                                               class="form-control @error('isbn') is-invalid @enderror"
                                               value="{{ old('isbn', $book->isbn) }}">
                                        @error('isbn')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" rows="3"
                                          class="form-control @error('description') is-invalid @enderror">{{ old('description', $book->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="publisher">Publisher</label>
                                        <input type="text" name="publisher" id="publisher"
                                               class="form-control @error('publisher') is-invalid @enderror"
                                               value="{{ old('publisher', $book->publisher) }}">
                                        @error('publisher')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="publication_year">Publication Year</label>
                                        <input type="number" name="publication_year" id="publication_year"
                                               class="form-control @error('publication_year') is-invalid @enderror"
                                               value="{{ old('publication_year', $book->publication_year) }}" min="1000" max="{{ date('Y') }}">
                                        @error('publication_year')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="pages">Pages</label>
                                        <input type="number" name="pages" id="pages"
                                               class="form-control @error('pages') is-invalid @enderror"
                                               value="{{ old('pages', $book->pages) }}" min="1">
                                        @error('pages')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="language">Language</label>
                                        <input type="text" name="language" id="language"
                                               class="form-control @error('language') is-invalid @enderror"
                                               value="{{ old('language', $book->language) }}">
                                        @error('language')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input type="number" name="price" id="price" step="0.01"
                                               class="form-control @error('price') is-invalid @enderror"
                                               value="{{ old('price', $book->price) }}" min="0">
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="condition">Condition <span class="text-danger">*</span></label>
                                        <select name="condition" id="condition"
                                                class="form-control @error('condition') is-invalid @enderror" required>
                                            <option value="">Select Condition</option>
                                            <option value="New" {{ old('condition', $book->condition) == 'New' ? 'selected' : '' }}>New</option>
                                            <option value="Good" {{ old('condition', $book->condition) == 'Good' ? 'selected' : '' }}>Good</option>
                                            <option value="Fair" {{ old('condition', $book->condition) == 'Fair' ? 'selected' : '' }}>Fair</option>
                                            <option value="Poor" {{ old('condition', $book->condition) == 'Poor' ? 'selected' : '' }}>Poor</option>
                                        </select>
                                        @error('condition')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="availability_status">Availability Status <span class="text-danger">*</span></label>
                                        <select name="availability_status" id="availability_status"
                                                class="form-control @error('availability_status') is-invalid @enderror" required>
                                            <option value="">Select Status</option>
                                            <option value="Available" {{ old('availability_status', $book->availability_status) == 'Available' ? 'selected' : '' }}>Available</option>
                                            <option value="Borrowed" {{ old('availability_status', $book->availability_status) == 'Borrowed' ? 'selected' : '' }}>Borrowed</option>
                                            <option value="Reserved" {{ old('availability_status', $book->availability_status) == 'Reserved' ? 'selected' : '' }}>Reserved</option>
                                            <option value="Maintenance" {{ old('availability_status', $book->availability_status) == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                                        </select>
                                        @error('availability_status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="cover_image">Book Cover Image</label>
                                @if($book->cover_image)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/book-covers/' . $book->cover_image) }}"
                                             alt="{{ $book->title }}"
                                             style="max-height: 100px;"
                                             class="img-thumbnail">
                                        <small class="text-muted d-block">Current cover image</small>
                                    </div>
                                @endif
                                <input type="file" name="cover_image" id="cover_image"
                                       class="form-control @error('cover_image') is-invalid @enderror"
                                       accept="image/*">
                                @error('cover_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Upload new cover image to replace existing (max 2MB, jpg/png/gif)</small>
                            </div>

                            <div class="form-group">
                                <label for="notes">Notes</label>
                                <textarea name="notes" id="notes" rows="2"
                                          class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $book->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="is_active"
                                           name="is_active" {{ old('is_active', $book->is_active) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_active">Active</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle"></i> Update Book
                                </button>
                                <a href="{{ route('books.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
