@extends('layouts.back')
@section('title', 'Manage Book Categories')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Manage Book Categories</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Book Categories</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Book Categories</h4>
                        <div class="card-header-form">
                            <a href="{{ route('book-categories.create') }}" class="btn btn-success btn-sm my-2">
                                <i class="bi bi-plus-circle"></i> Add New Category
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="categoriesTable">
                                <thead>
                                    <tr>
                                        <th>S#</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Color</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Sort Order</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
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
    $('#categoriesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('book-categories.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'image_preview', name: 'image', orderable: false, searchable: false},
            {data: 'color_preview', name: 'color', orderable: false, searchable: false},
            {data: 'description', name: 'description'},
            {data: 'status', name: 'is_active'},
            {data: 'sort_order', name: 'sort_order'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        responsive: true,
        order: [[6, 'asc']], // Sort by sort_order by default
    });
});
</script>
@endpush
