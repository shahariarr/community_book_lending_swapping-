@extends('layouts.back')
@section('title', 'Edit Book Category')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Edit Book Category</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('book-categories.index') }}">Book Categories</a></div>
            <div class="breadcrumb-item">Edit</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Category: {{ $bookCategory->name }}</h4>
                        <div class="card-header-form">
                            <a href="{{ route('book-categories.index') }}" class="btn btn-primary">
                                <i class="bi bi-arrow-left"></i> Back to Categories
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('book-categories.update', $bookCategory) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Category Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name"
                                               class="form-control @error('name') is-invalid @enderror"
                                               value="{{ old('name', $bookCategory->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="color">Category Color <span class="text-danger">*</span></label>
                                        <input type="color" name="color" id="color"
                                               class="form-control @error('color') is-invalid @enderror"
                                               value="{{ old('color', $bookCategory->color) }}" required>
                                        @error('color')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="icon">Icon Class (FontAwesome)</label>
                                        <input type="text" name="icon" id="icon"
                                               class="form-control @error('icon') is-invalid @enderror"
                                               value="{{ old('icon', $bookCategory->icon) }}"
                                               placeholder="e.g., fas fa-book">
                                        @error('icon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">
                                            Use FontAwesome icon classes. Leave empty for no icon.
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="image">Category Image</label>
                                        <input type="file" name="image" id="image"
                                               class="form-control @error('image') is-invalid @enderror"
                                               accept="image/*">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">
                                            Upload a new image to replace current one. Max size: 2MB.
                                        </small>
                                        @if($bookCategory->image)
                                            <div class="mt-2">
                                                <img src="{{ $bookCategory->image_url }}" alt="Current Image"
                                                     class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                                <p class="small text-muted mt-1">Current image</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sort_order">Sort Order</label>
                                        <input type="number" name="sort_order" id="sort_order"
                                               class="form-control @error('sort_order') is-invalid @enderror"
                                               value="{{ old('sort_order', $bookCategory->sort_order) }}" min="0">
                                        @error('sort_order')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description"
                                          class="form-control summernote @error('description') is-invalid @enderror"
                                          placeholder="Enter category description...">{{ old('description', $bookCategory->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="is_active"
                                           name="is_active" {{ old('is_active', $bookCategory->is_active) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_active">Active</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle"></i> Update Category
                                </button>
                                <a href="{{ route('book-categories.index') }}" class="btn btn-secondary">
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

@push('scripts')
<script>
$(document).ready(function() {
    $('.summernote').summernote({
        height: 150,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });
});
</script>
@endpush
