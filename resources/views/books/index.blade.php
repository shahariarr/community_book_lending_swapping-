@extends('layouts.back')
@section('title', 'Manage Books')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Manage Books</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Books</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>All Books</h4>
                        <div class="card-header-form">
                            <a href="{{ route('books.create') }}" class="btn btn-success btn-sm my-2">
                                <i class="bi bi-plus-circle"></i> Add New Book
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="booksTable">
                                <thead>
                                    <tr>
                                        <th>S#</th>
                                        <th>Cover</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Category</th>
                                        <th>Owner</th>
                                        <th>Status</th>
                                        <th>Condition</th>
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
    $('#booksTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('books.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'cover_preview', name: 'cover_image', orderable: false, searchable: false},
            {data: 'title', name: 'title'},
            {data: 'author', name: 'author'},
            {data: 'category_name', name: 'category.name'},
            {data: 'owner_name', name: 'owner.name'},
            {data: 'status', name: 'availability_status'},
            {data: 'condition_badge', name: 'condition'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        responsive: true,
        order: [[2, 'asc']], // Sort by title by default
    });
});
</script>
@endpush
