<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Print Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { margin: 0; }
        }
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 5px;
        }
        .subtitle {
            color: #666;
            margin-bottom: 15px;
        }
        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .invoice-number {
            font-size: 20px;
            font-weight: bold;
        }
        .parties {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .party {
            width: 45%;
        }
        .party h3 {
            margin-bottom: 10px;
            color: #007bff;
        }
        .book-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        .book-details h3 {
            margin-top: 0;
            color: #007bff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .terms {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        .terms h3 {
            margin-top: 0;
            color: #007bff;
        }
        .footer {
            text-align: center;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 3px;
            color: white;
            font-size: 12px;
        }
        .status-active { background-color: #28a745; }
        .status-completed { background-color: #17a2b8; }
        .status-cancelled { background-color: #6c757d; }
        .text-danger { color: #dc3545; }
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <!-- Print Button -->
    <button onclick="window.print()" class="print-btn no-print" style="
        background: #007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
    ">
        <i class="fas fa-print"></i> Print Invoice
    </button>

    <!-- Header -->
    <div class="header">
        <div class="company-name">Community Book Library</div>
        <div class="subtitle">Book Lending Platform Invoice</div>
    </div>

    <!-- Invoice Info -->
    <div class="invoice-info">
        <div>
            <strong>Invoice Date:</strong> {{ $invoice->generated_at->format('M d, Y') }}
        </div>
        <div>
            <div class="invoice-number">Invoice #{{ $invoice->invoice_number }}</div>
            <span class="status-badge status-{{ $invoice->status }}">{{ ucfirst($invoice->status) }}</span>
        </div>
    </div>

    <!-- Parties -->
    <div class="parties">
        <div class="party">
            <h3>Lender (Book Owner)</h3>
            <div><strong>{{ $invoice->lender->name }}</strong></div>
            <div>{{ $invoice->lender->email }}</div>
            @if($invoice->lender->location)
                <div>{{ $invoice->lender->location }}</div>
            @endif
        </div>
        <div class="party">
            <h3>Borrower</h3>
            <div><strong>{{ $invoice->borrower->name }}</strong></div>
            <div>{{ $invoice->borrower->email }}</div>
            @if($invoice->borrower->location)
                <div>{{ $invoice->borrower->location }}</div>
            @endif
        </div>
    </div>

    <!-- Book Details -->
    <div class="book-details">
        <h3>Book Details</h3>
        <table>
            <tr>
                <td><strong>Title:</strong></td>
                <td>{{ $invoice->book->title }}</td>
            </tr>
            <tr>
                <td><strong>Author:</strong></td>
                <td>{{ $invoice->book->author }}</td>
            </tr>
            <tr>
                <td><strong>ISBN:</strong></td>
                <td>{{ $invoice->book->isbn ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Category:</strong></td>
                <td>{{ $invoice->book->category->name }}</td>
            </tr>
            <tr>
                <td><strong>Condition:</strong></td>
                <td>{{ ucfirst($invoice->book->condition) }}</td>
            </tr>
        </table>
    </div>

    <!-- Loan Details -->
    <h3>Loan Details</h3>
    <table>
        <tr>
            <td><strong>Loan Start Date</strong></td>
            <td>{{ $invoice->loan_start_date->format('M d, Y') }}</td>
        </tr>
        <tr>
            <td><strong>Loan End Date</strong></td>
            <td>
                {{ $invoice->loan_end_date->format('M d, Y') }}
                @if($invoice->isOverdue())
                    <span class="text-danger">({{ $invoice->daysOverdue() }} days overdue)</span>
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

    <!-- Terms and Conditions -->
    @if($invoice->terms_conditions)
    <div class="terms">
        <h3>Terms and Conditions</h3>
        <div style="white-space: pre-wrap;">{{ $invoice->terms_conditions }}</div>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>This invoice was generated on {{ $invoice->generated_at->format('M d, Y \a\t g:i A') }}</p>
        <p>Community Book Library - Connecting book lovers through sharing</p>
    </div>

    <script>
        // Auto-print when page loads (optional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
