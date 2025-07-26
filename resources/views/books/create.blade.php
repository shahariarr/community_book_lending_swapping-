@extends('layouts.back')
@section('title', 'Upload Book')
@section('content')

<section class="section">
    <div class="section-header">
        <h1>Upload New Book</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('books.my-books') }}">My Books</a></div>
            <div class="breadcrumb-item active">Upload Book</div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-upload"></i> Book Information</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Book Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                           id="title" name="title" value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="author">Author <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('author') is-invalid @enderror"
                                           id="author" name="author" value="{{ old('author') }}" required>
                                    @error('author')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="isbn">ISBN (Optional)</label>
                                    <input type="text" class="form-control @error('isbn') is-invalid @enderror"
                                           id="isbn" name="isbn" value="{{ old('isbn') }}">
                                    @error('isbn')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category_id">Category <span class="text-danger">*</span></label>
                                    <select class="form-control @error('category_id') is-invalid @enderror"
                                            id="category_id" name="category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                            <small class="form-text text-muted">Describe the book's content, condition, or any special notes.</small>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="condition">Book Condition <span class="text-danger">*</span></label>
                                    <select class="form-control @error('condition') is-invalid @enderror"
                                            id="condition" name="condition" required>
                                        <option value="">Select Condition</option>
                                        <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>New</option>
                                        <option value="like_new" {{ old('condition') == 'like_new' ? 'selected' : '' }}>Like New</option>
                                        <option value="good" {{ old('condition') == 'good' ? 'selected' : '' }}>Good</option>
                                        <option value="fair" {{ old('condition') == 'fair' ? 'selected' : '' }}>Fair</option>
                                        <option value="poor" {{ old('condition') == 'poor' ? 'selected' : '' }}>Poor</option>
                                    </select>
                                    @error('condition')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="availability_type">Availability Type <span class="text-danger">*</span></label>
                                    <select class="form-control @error('availability_type') is-invalid @enderror"
                                            id="availability_type" name="availability_type" required>
                                        <option value="">Select Type</option>
                                        <option value="loan" {{ old('availability_type') == 'loan' ? 'selected' : '' }}>Loan Only</option>
                                        <option value="swap" {{ old('availability_type') == 'swap' ? 'selected' : '' }}>Swap Only</option>
                                        <option value="both" {{ old('availability_type') == 'both' ? 'selected' : '' }}>Both Loan & Swap</option>
                                    </select>
                                    @error('availability_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="language">Language</label>
                                    <input type="text" class="form-control @error('language') is-invalid @enderror"
                                           id="language" name="language" value="{{ old('language', 'English') }}">
                                    @error('language')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="published_date">Published Date</label>
                                    <input type="date" class="form-control @error('published_date') is-invalid @enderror"
                                           id="published_date" name="published_date" value="{{ old('published_date') }}">
                                    @error('published_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="page_count">Number of Pages</label>
                                    <input type="number" class="form-control @error('page_count') is-invalid @enderror"
                                           id="page_count" name="page_count" value="{{ old('page_count') }}" min="1">
                                    @error('page_count')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="image">Book Cover Image</label>
                            <input type="file" class="form-control-file @error('image') is-invalid @enderror"
                                   id="image" name="image" accept="image/*">
                            <small class="form-text text-muted">Upload a cover image (JPEG, PNG, JPG, GIF - Max: 2MB)</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload"></i> Submit Book for Approval
                            </button>
                            <a href="{{ route('books.my-books') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-info-circle"></i> Important Information</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6><i class="fas fa-clock"></i> Approval Process</h6>
                        <p class="mb-0">Your book will be reviewed by an administrator before becoming visible to other users. This usually takes 1-2 business days.</p>
                    </div>

                    <div class="alert alert-warning">
                        <h6><i class="fas fa-exclamation-triangle"></i> Guidelines</h6>
                        <ul class="mb-0">
                            <li>Ensure book information is accurate</li>
                            <li>Upload a clear cover image</li>
                            <li>Be honest about book condition</li>
                            <li>Provide complete description</li>
                        </ul>
                    </div>

                    <div class="alert alert-success">
                        <h6><i class="fas fa-handshake"></i> Community Rules</h6>
                        <ul class="mb-0">
                            <li>Treat books with care</li>
                            <li>Respond to requests promptly</li>
                            <li>Return books on time</li>
                            <li>Communicate clearly</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
