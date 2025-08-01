@extends('layouts.back')
@section('title', 'Invoice #' . $invoice->invoice_number)
@section('content')

<section class="section">
    <div class="section-header">
        <h1>Invoice #{{ $invoice->invoice_number }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('loan-requests.index') }}">Loan Requests</a></div>
            <div class="breadcrumb-item active">Invoice</div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-file-invoice"></i> Loan Invoice</h4>
                    <div class="card-header-action">
                        <a href="{{ route('invoices.download', $invoice) }}" class="btn btn-primary">
                            <i class="fas fa-download"></i> Download PDF
                        </a>
                        <a href="{{ route('invoices.print', $invoice) }}" class="btn btn-outline-primary" target="_blank">
                            <i class="fas fa-print"></i> Print
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Invoice Header -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h3 class="text-primary">Community Book Library</h3>
                            <p class="text-muted mb-0">Book Lending Platform</p>
                            <p class="text-muted">Invoice Date: {{ $invoice->generated_at->format('M d, Y') }}</p>
                        </div>
                        <div class="col-md-6 text-right">
                            <h4>Invoice #{{ $invoice->invoice_number }}</h4>
                            <p class="mb-1">
                                <span class="badge badge-{{ $invoice->status === 'active' ? 'success' : ($invoice->status === 'completed' ? 'info' : 'secondary') }}">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <!-- Parties Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Lender (Book Owner)</h5>
                            <div class="d-flex align-items-center mb-2">
                                <img src="{{ $invoice->lender->image ? asset('storage/' . $invoice->lender->image) : asset('backend/assets/img/avatar/xyz.png') }}"
                                     alt="{{ $invoice->lender->name }}"
                                     style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;" class="mr-3">
                                <div>
                                    <h6 class="mb-0">{{ $invoice->lender->name }}</h6>
                                    <small class="text-muted">{{ $invoice->lender->email }}</small>
                                    @if($invoice->lender->location)
                                        <br><small class="text-muted">{{ $invoice->lender->location }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5>Borrower</h5>
                            <div class="d-flex align-items-center mb-2">
                                <img src="{{ $invoice->borrower->image ? asset('storage/' . $invoice->borrower->image) : asset('backend/assets/img/avatar/xyz.png') }}"
                                     alt="{{ $invoice->borrower->name }}"
                                     style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;" class="mr-3">
                                <div>
                                    <h6 class="mb-0">{{ $invoice->borrower->name }}</h6>
                                    <small class="text-muted">{{ $invoice->borrower->email }}</small>
                                    @if($invoice->borrower->location)
                                        <br><small class="text-muted">{{ $invoice->borrower->location }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Book Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5>Book Details</h5>
                            <div class="card border">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-4">
                                            <img src="{{ $invoice->book->image ? asset('storage/' . $invoice->book->image) : asset('backend/assets/img/books/default.png') }}"
                                                 alt="{{ $invoice->book->title }}"
                                                 style="width: 80px; height: 100px; object-fit: cover;"
                                                 class="rounded">
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6>{{ $invoice->book->title }}</h6>
                                            <p class="mb-1"><strong>Author:</strong> {{ $invoice->book->author }}</p>
                                            <p class="mb-1"><strong>ISBN:</strong> {{ $invoice->book->isbn ?? 'N/A' }}</p>
                                            <p class="mb-1"><strong>Category:</strong> {{ $invoice->book->category->name }}</p>
                                            <p class="mb-0"><strong>Condition:</strong> {{ ucfirst($invoice->book->condition) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Loan Details -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5>Loan Details</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <td><strong>Loan Start Date</strong></td>
                                        <td>{{ $invoice->loan_start_date->format('M d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Loan End Date</strong></td>
                                        <td>
                                            {{ $invoice->loan_end_date->format('M d, Y') }}
                                            @if($invoice->isOverdue())
                                                <span class="badge badge-danger ml-2">{{ $invoice->daysOverdue() }} days overdue</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Duration</strong></td>
                                        <td>{{ $invoice->duration_days }} days</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Security Deposit</strong></td>
                                        <td>${{ number_format($invoice->security_deposit, 2) }}</td>
                                    </tr>
                                    @if($invoice->late_fee > 0)
                                    <tr>
                                        <td><strong>Late Fee</strong></td>
                                        <td class="text-danger">${{ number_format($invoice->late_fee, 2) }}</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Terms and Conditions -->
                    @if($invoice->terms_conditions)
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5>Terms and Conditions</h5>
                            <div class="card border">
                                <div class="card-body">
                                    <pre class="mb-0" style="white-space: pre-wrap; font-family: inherit;">{{ $invoice->terms_conditions }}</pre>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Status and Actions -->
                    <div class="row">
                        <div class="col-12 text-center">
                            <p class="text-muted">
                                This invoice was generated on {{ $invoice->generated_at->format('M d, Y \a\t g:i A') }}
                            </p>
                            @if($invoice->status === 'active')
                                <p class="text-warning">
                                    <i class="fas fa-info-circle"></i> This loan is currently active. Please return the book by the due date.
                                </p>
                            @elseif($invoice->status === 'completed')
                                <p class="text-success">
                                    <i class="fas fa-check-circle"></i> This loan has been completed successfully.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
