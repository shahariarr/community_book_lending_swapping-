<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'borrower_id',
        'lender_id',
        'message',
        'status',
        'requested_start_date',
        'requested_end_date',
        'actual_start_date',
        'actual_end_date',
        'returned_date',
        'lender_response',
        'responded_at',
        'is_overdue',
    ];

    protected $casts = [
        'requested_start_date' => 'datetime',
        'requested_end_date' => 'datetime',
        'actual_start_date' => 'datetime',
        'actual_end_date' => 'datetime',
        'returned_date' => 'datetime',
        'responded_at' => 'datetime',
        'is_overdue' => 'boolean',
    ];

    // Relationships
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function borrower()
    {
        return $this->belongsTo(User::class, 'borrower_id');
    }

    public function lender()
    {
        return $this->belongsTo(User::class, 'lender_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'accepted')
                    ->whereNotNull('actual_start_date')
                    ->whereNull('returned_date');
    }

    public function scopeOverdue($query)
    {
        return $query->where('is_overdue', true);
    }

    // Methods
    public function accept($response = null)
    {
        $this->update([
            'status' => 'accepted',
            'lender_response' => $response,
            'responded_at' => now(),
            'actual_start_date' => $this->requested_start_date,
            'actual_end_date' => $this->requested_end_date,
        ]);

        // Update book status
        $this->book()->update(['status' => 'loaned']);
    }

    public function reject($response)
    {
        $this->update([
            'status' => 'rejected',
            'lender_response' => $response,
            'responded_at' => now(),
        ]);
    }

    public function markAsReturned()
    {
        $this->update([
            'status' => 'completed',
            'returned_date' => now(),
            'is_overdue' => false,
        ]);

        // Update book status back to available
        $this->book()->update(['status' => 'available']);
    }

    public function checkOverdue()
    {
        if ($this->status === 'accepted' && $this->actual_end_date && now()->gt($this->actual_end_date) && !$this->returned_date) {
            $this->update(['is_overdue' => true]);
        }
    }

    // Accessors
    public function getDaysRemainingAttribute()
    {
        if (!$this->actual_end_date || $this->returned_date) {
            return null;
        }

        return now()->diffInDays($this->actual_end_date, false);
    }

    public function getIsActuallyOverdueAttribute()
    {
        if (!$this->actual_end_date || $this->returned_date) {
            return false;
        }

        return now()->gt($this->actual_end_date);
    }
}
