<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'loan_request_id',
        'swap_request_id',
        'invoice_type',
        'borrower_id',
        'lender_id',
        'book_id',
        'offered_book_id',
        'loan_start_date',
        'loan_end_date',
        'duration_days',
        'security_deposit',
        'late_fee',
        'terms_conditions',
        'status',
        'generated_at'
    ];

    protected $casts = [
        'loan_start_date' => 'datetime',
        'loan_end_date' => 'datetime',
        'generated_at' => 'datetime',
        'security_deposit' => 'decimal:2',
        'late_fee' => 'decimal:2'
    ];

    // Relationships
    public function loanRequest()
    {
        return $this->belongsTo(LoanRequest::class);
    }

    public function swapRequest()
    {
        return $this->belongsTo(SwapRequest::class);
    }

    public function borrower()
    {
        return $this->belongsTo(User::class, 'borrower_id');
    }

    public function lender()
    {
        return $this->belongsTo(User::class, 'lender_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function offeredBook()
    {
        return $this->belongsTo(Book::class, 'offered_book_id');
    }

    // Generate unique invoice number
    public static function generateInvoiceNumber()
    {
        $date = now()->format('Ymd');
        $lastInvoice = self::whereDate('created_at', now())->orderBy('id', 'desc')->first();
        $sequence = $lastInvoice ? (int) substr($lastInvoice->invoice_number, -4) + 1 : 1;

        return 'INV-' . $date . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    // Check if invoice is overdue
    public function isOverdue()
    {
        return $this->status === 'active' && Carbon::now()->isAfter($this->loan_end_date);
    }

    // Calculate days overdue
    public function daysOverdue()
    {
        if (!$this->isOverdue()) {
            return 0;
        }

        return $this->loan_end_date->diffInDays(Carbon::now());
    }
}
