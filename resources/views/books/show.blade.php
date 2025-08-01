@extends('layouts.back')
@section('title', $book->title)
@section('content')

<section class="section">
    <div class="section-header">
        <h1>{{ $book->title }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('books.index') }}">Browse Books</a></div>
            <div class="breadcrumb-item active">{{ Str::limit($book->title, 30) }}</div>
        </div>
    </div>




    <div class="row">
        <!-- Book Details -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ $book->image ? asset('storage/' . $book->image) : asset('backend/assets/img/books/default.png') }}"
                                 alt="{{ $book->title }}"
                                 class="img-fluid rounded shadow"
                                 style="width: 100%; max-height: 400px; object-fit: cover;">
                        </div>
                        <div class="col-md-8">
                            <h3 class="mb-3">{{ $book->title }}</h3>

                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Author:</strong></div>
                                <div class="col-sm-9">{{ $book->author }}</div>
                            </div>

                            @if($book->isbn)
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>ISBN:</strong></div>
                                <div class="col-sm-9">{{ $book->isbn }}</div>
                            </div>
                            @endif

                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Category:</strong></div>
                                <div class="col-sm-9">
                                    <span class="badge badge-primary">{{ $book->category->name }}</span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Condition:</strong></div>
                                <div class="col-sm-9">
                                    <span class="badge badge-secondary">{{ $book->formatted_condition }}</span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Available for:</strong></div>
                                <div class="col-sm-9">
                                    @if($book->availability_type === 'loan')
                                        <span class="badge badge-success"><i class="fas fa-hand-holding"></i> Loan Only</span>
                                    @elseif($book->availability_type === 'swap')
                                        <span class="badge badge-info"><i class="fas fa-exchange-alt"></i> Swap Only</span>
                                    @else
                                        <span class="badge badge-primary"><i class="fas fa-handshake"></i> Both Loan & Swap</span>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Status:</strong></div>
                                <div class="col-sm-9">
                                    @if($book->status === 'available')
                                        <span class="badge badge-success"><i class="fas fa-check"></i> Available</span>
                                    @elseif($book->status === 'loaned')
                                        <span class="badge badge-warning"><i class="fas fa-hand-holding"></i> Currently Loaned</span>
                                    @elseif($book->status === 'swapped')
                                        <span class="badge badge-info"><i class="fas fa-exchange-alt"></i> Swapped</span>
                                    @else
                                        <span class="badge badge-secondary">{{ ucfirst($book->status) }}</span>
                                    @endif
                                </div>
                            </div>

                            @if($book->language)
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Language:</strong></div>
                                <div class="col-sm-9">{{ $book->language }}</div>
                            </div>
                            @endif

                            @if($book->page_count)
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Pages:</strong></div>
                                <div class="col-sm-9">{{ $book->page_count }}</div>
                            </div>
                            @endif

                            @if($book->published_date)
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Published:</strong></div>
                                <div class="col-sm-9">{{ $book->published_date->format('Y') }}</div>
                            </div>
                            @endif
                        </div>
                    </div>

                    @if($book->description)
                    <div class="mt-4">
                        <h5>Description</h5>
                        <p class="text-justify">{{ $book->description }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Owner Info and Actions -->
        <div class="col-lg-4">
            <!-- Owner Information -->
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-user"></i> Book Owner</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="mr-3">
                            <img src="{{ $book->user->image ? asset('storage/' . $book->user->image) : asset('backend/assets/img/avatar/xyz.png') }}"
                                 alt="{{ $book->user->name }}"
                                 style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                        </div>
                        <div>
                            <h6 class="mb-1">{{ $book->user->name }}</h6>
                            @if($book->user->location)
                                <small class="text-muted"><i class="fas fa-map-marker-alt"></i> {{ $book->user->location }}</small>
                            @endif
                        </div>
                    </div>

                    @if($book->user->bio)
                        <div class="mt-3">
                            <p class="text-muted small">{{ Str::limit($book->user->bio, 100) }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            @if($canRequest)
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-handshake"></i> Request This Book</h4>
                </div>
                <div class="card-body">
                    @if(in_array($book->availability_type, ['loan', 'both']))
                        <button type="button" id="openLoanModal" class="btn btn-success btn-block mb-2">
                            <i class="fas fa-hand-holding"></i> Request to Borrow
                        </button>
                    @endif

                    @if(in_array($book->availability_type, ['swap', 'both']))
                        <a href="{{ route('swap-requests.create', $book) }}" class="btn btn-info btn-block">
                            <i class="fas fa-exchange-alt"></i> Propose a Swap
                        </a>
                    @endif
                </div>
            </div>
            @elseif($book->user_id === Auth::id())
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-cog"></i> Manage Book</h4>
                </div>
                <div class="card-body">
                    <a href="{{ route('books.edit', $book) }}" class="btn btn-primary btn-block mb-2">
                        <i class="fas fa-edit"></i> Edit Book
                    </a>
                    <a href="{{ route('books.my-books') }}" class="btn btn-outline-secondary btn-block">
                        <i class="fas fa-list"></i> Back to My Books
                    </a>
                </div>
            </div>
            @else
            <div class="card">
                <div class="card-body text-center">
                    @if(!$book->is_approved)
                        <div class="alert alert-warning">
                            <i class="fas fa-clock"></i> This book is pending admin approval.
                        </div>
                    @elseif($book->status !== 'available')
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> This book is currently {{ $book->status }}.
                        </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Book Statistics -->
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-chart-bar"></i> Book Stats</h4>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-right">
                                <h5 class="mb-0">{{ $book->loanRequests->count() }}</h5>
                                <small class="text-muted">Loan Requests</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h5 class="mb-0">{{ $book->swapRequestsAsRequested->count() }}</h5>
                            <small class="text-muted">Swap Requests</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Simple Loan Request Modal -->
@if($canRequest && in_array($book->availability_type, ['loan', 'both']))
<div id="loanModal" class="modal fade" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Request to Borrow: {{ $book->title }}</h5>
                <button type="button" id="closeLoanModal" class="close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="loanRequestForm" method="POST" action="{{ route('loan-requests.store') }}">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $book->id }}">

                    <div class="form-group">
                        <label>Loan Duration <span class="text-danger">*</span></label>
                        <select name="duration_days" id="duration_days" class="form-control" required>
                            <option value="">Select Duration</option>
                            <option value="7">1 Week (7 days)</option>
                            <option value="14">2 Weeks (14 days)</option>
                            <option value="21">3 Weeks (21 days)</option>
                            <option value="30">1 Month (30 days)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Message (Optional)</label>
                        <textarea name="message" class="form-control" rows="3" placeholder="Why would you like to borrow this book?"></textarea>
                    </div>

                    <div class="form-group">
                        <button type="button" id="cancelLoanRequest" class="btn btn-secondary">Cancel</button>
                        <button type="submit" id="submitLoanRequest" class="btn btn-success">Send Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Backdrop -->
<div id="modalBackdrop" class="modal-backdrop fade" style="display: none;"></div>
@endif

@endsection

@push('styles')
<style>
/* Modal styles */
#loanModal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1050;
    overflow: auto;
    transition: opacity 0.3s ease;
    opacity: 0;
}

#loanModal.show {
    opacity: 1;
}

#loanModal .modal-dialog {
    position: relative;
    width: auto;
    margin: 50px auto;
    max-width: 500px;
    pointer-events: none;
}

#loanModal .modal-content {
    position: relative;
    background-color: #fff;
    border: 1px solid rgba(0,0,0,.2);
    border-radius: 0.3rem;
    box-shadow: 0 3px 9px rgba(0,0,0,.5);
    pointer-events: auto;
    background-clip: padding-box;
}

#loanModal .modal-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    padding: 1rem;
    border-bottom: 1px solid #dee2e6;
    border-top-left-radius: 0.3rem;
    border-top-right-radius: 0.3rem;
}

#loanModal .modal-header h5 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 500;
}

#loanModal .modal-header .close {
    padding: 0;
    background: transparent;
    border: 0;
    font-size: 1.5rem;
    cursor: pointer;
}

#loanModal .modal-body {
    position: relative;
    flex: 1 1 auto;
    padding: 1rem;
}

#modalBackdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1040;
    background-color: rgba(0,0,0,0.5);
    transition: opacity 0.3s ease;
    opacity: 0;
}

#modalBackdrop.show {
    opacity: 1;
}

body.modal-open {
    overflow: hidden;
}

.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.form-control {
    display: block;
    width: 100%;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-control:focus {
    color: #495057;
    background-color: #fff;
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

.btn {
    display: inline-block;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    user-select: none;
    border: 1px solid transparent;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: 0.25rem;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    cursor: pointer;
    text-decoration: none;
    margin-right: 0.5rem;
}

.btn-success {
    color: #fff;
    background-color: #28a745;
    border-color: #28a745;
}

.btn-success:hover {
    color: #fff;
    background-color: #218838;
    border-color: #1e7e34;
}

.btn-secondary {
    color: #fff;
    background-color: #6c757d;
    border-color: #6c757d;
}

.btn-secondary:hover {
    color: #fff;
    background-color: #5a6268;
    border-color: #545b62;
}

.text-danger {
    color: #dc3545;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== LOAN REQUEST SYSTEM ===');
    console.log('Page loaded');

    // Get elements
    const openButton = document.getElementById('openLoanModal');
    const modal = document.getElementById('loanModal');
    const backdrop = document.getElementById('modalBackdrop');
    const closeButton = document.getElementById('closeLoanModal');
    const cancelButton = document.getElementById('cancelLoanRequest');
    const form = document.getElementById('loanRequestForm');

    console.log('Elements found:', {
        openButton: !!openButton,
        modal: !!modal,
        backdrop: !!backdrop,
        closeButton: !!closeButton,
        cancelButton: !!cancelButton,
        form: !!form
    });

    // Open modal function
    function openModal() {
        console.log('Opening modal');
        if (modal && backdrop) {
            modal.style.display = 'block';
            backdrop.style.display = 'block';
            setTimeout(function() {
                modal.classList.add('show');
                backdrop.classList.add('show');
                document.body.classList.add('modal-open');
            }, 10);
        }
    }

    // Close modal function
    function closeModal() {
        console.log('Closing modal');
        if (modal && backdrop) {
            modal.classList.remove('show');
            backdrop.classList.remove('show');
            document.body.classList.remove('modal-open');
            setTimeout(function() {
                modal.style.display = 'none';
                backdrop.style.display = 'none';
            }, 300);
        }
    }

    // Event listeners
    if (openButton) {
        openButton.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Open button clicked');
            openModal();
        });
    }

    if (closeButton) {
        closeButton.addEventListener('click', function(e) {
            e.preventDefault();
            closeModal();
        });
    }

    if (cancelButton) {
        cancelButton.addEventListener('click', function(e) {
            e.preventDefault();
            closeModal();
        });
    }

    if (backdrop) {
        backdrop.addEventListener('click', function(e) {
            if (e.target === backdrop) {
                closeModal();
            }
        });
    }

    // Form submission
    if (form) {
        form.addEventListener('submit', function(e) {
            const duration = document.getElementById('duration_days').value;
            console.log('Form submitted with duration:', duration);

            if (!duration) {
                e.preventDefault();
                alert('Please select a loan duration');
                return false;
            }

            // Show loading state
            const submitBtn = document.getElementById('submitLoanRequest');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
            }

            return true;
        });
    }

    // Show modal if there are errors
    @if ($errors->any() || session('error'))
        console.log('Showing modal due to errors');
        setTimeout(openModal, 500);
    @endif
});
</script>
@endpush
