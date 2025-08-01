<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\LoanRequest;
use App\Models\SwapRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Invoice $invoice)
    {
        // Check if user is authorized to view this invoice
        if (!in_array(Auth::id(), [$invoice->borrower_id, $invoice->lender_id])) {
            abort(403, 'Unauthorized to view this invoice.');
        }

        $invoice->load(['borrower', 'lender', 'book', 'loanRequest', 'swapRequest', 'offeredBook']);

        return view('invoices.show', compact('invoice'));
    }

    public function download(Invoice $invoice)
    {
        // Check if user is authorized to download this invoice
        if (!in_array(Auth::id(), [$invoice->borrower_id, $invoice->lender_id])) {
            abort(403, 'Unauthorized to download this invoice.');
        }

        $invoice->load(['borrower', 'lender', 'book', 'loanRequest', 'swapRequest', 'offeredBook']);

        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));

        return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
    }

    public function print(Invoice $invoice)
    {
        // Check if user is authorized to print this invoice
        if (!in_array(Auth::id(), [$invoice->borrower_id, $invoice->lender_id])) {
            abort(403, 'Unauthorized to print this invoice.');
        }

        $invoice->load(['borrower', 'lender', 'book', 'loanRequest', 'swapRequest', 'offeredBook']);

        return view('invoices.print', compact('invoice'));
    }

    public static function generateInvoice(LoanRequest $loanRequest)
    {
        // Check if invoice already exists
        if ($loanRequest->invoice) {
            return $loanRequest->invoice;
        }

        $invoice = Invoice::create([
            'invoice_number' => Invoice::generateInvoiceNumber(),
            'loan_request_id' => $loanRequest->id,
            'borrower_id' => $loanRequest->borrower_id,
            'lender_id' => $loanRequest->lender_id,
            'book_id' => $loanRequest->book_id,
            'loan_start_date' => $loanRequest->actual_start_date,
            'loan_end_date' => $loanRequest->actual_end_date,
            'duration_days' => $loanRequest->duration_days ?? $loanRequest->actual_start_date->diffInDays($loanRequest->actual_end_date),
            'security_deposit' => 0, // Can be configured later
            'late_fee' => 0,
            'terms_conditions' => self::getDefaultTermsAndConditions(),
            'status' => 'active',
            'generated_at' => now()
        ]);

        return $invoice;
    }

    public static function generateSwapInvoice(SwapRequest $swapRequest)
    {
        // Check if invoice already exists
        if ($swapRequest->invoice) {
            return $swapRequest->invoice;
        }

        // Calculate swap dates
        $startDate = $swapRequest->approved_at ? $swapRequest->approved_at : now();
        $endDate = $startDate->copy()->addDays($swapRequest->duration_days ?? 30);

        $invoice = Invoice::create([
            'invoice_number' => Invoice::generateInvoiceNumber(),
            'swap_request_id' => $swapRequest->id,
            'loan_request_id' => null, // Set explicitly to null for swap invoices
            'invoice_type' => 'swap',
            'borrower_id' => $swapRequest->requester_id,
            'lender_id' => $swapRequest->owner_id,
            'book_id' => $swapRequest->requested_book_id,
            'offered_book_id' => $swapRequest->offered_book_id,
            'loan_start_date' => $startDate,
            'loan_end_date' => $endDate,
            'duration_days' => $swapRequest->duration_days ?? 30,
            'security_deposit' => 0,
            'late_fee' => 0,
            'terms_conditions' => self::getDefaultSwapTermsAndConditions(),
            'status' => 'active',
            'generated_at' => now()
        ]);

        return $invoice;
    }

    private static function getDefaultTermsAndConditions()
    {
        return "1. The borrowed book must be returned in the same condition as received.\n" .
               "2. Any damage to the book will result in replacement cost charges.\n" .
               "3. Late return may incur daily late fees.\n" .
               "4. The borrower is responsible for the book until it is returned.\n" .
               "5. This loan agreement is governed by the platform's terms of service.";
    }

    private static function getDefaultSwapTermsAndConditions()
    {
        return "1. Both books must be returned in the same condition as received.\n" .
               "2. Any damage to either book will result in replacement cost charges.\n" .
               "3. Books must be returned by the agreed swap end date.\n" .
               "4. Late return may incur daily late fees for both parties.\n" .
               "5. Both parties are responsible for their respective books during the swap period.\n" .
               "6. This swap agreement is governed by the platform's terms of service.";
    }
}
