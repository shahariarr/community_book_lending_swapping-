<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SwapRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'requested_book_id',
        'offered_book_id',
        'requester_id',
        'owner_id',
        'message',
        'swap_duration_days',
        'status',
        'owner_response',
        'responded_at',
        'completed_at',
        'swap_start_date',
        'swap_end_date',
        'actual_return_date',
        'swap_status',
        'rejection_reason',
        'cancelled_at',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
        'completed_at' => 'datetime',
        'swap_start_date' => 'date',
        'swap_end_date' => 'date',
        'actual_return_date' => 'date',
        'cancelled_at' => 'datetime',
    ];

    // Relationships
    public function requestedBook()
    {
        return $this->belongsTo(Book::class, 'requested_book_id');
    }

    public function offeredBook()
    {
        return $this->belongsTo(Book::class, 'offered_book_id');
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'swap_request_id');
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

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Methods
    public function accept($response = null)
    {
        $this->update([
            'status' => 'accepted',
            'owner_response' => $response,
            'responded_at' => now(),
        ]);
    }

    public function reject($response)
    {
        $this->update([
            'status' => 'rejected',
            'owner_response' => $response,
            'responded_at' => now(),
        ]);
    }

    public function complete()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        // Update both books to be swapped - change their owners
        $requestedBook = $this->requestedBook;
        $offeredBook = $this->offeredBook;

        $requestedBook->update([
            'user_id' => $this->requester_id,
            'status' => 'available'
        ]);

        $offeredBook->update([
            'user_id' => $this->owner_id,
            'status' => 'available'
        ]);
    }
}
