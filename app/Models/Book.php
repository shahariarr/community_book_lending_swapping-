<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'description',
        'image',
        'category_id',
        'user_id',
        'condition',
        'availability_type',
        'status',
        'rating',
        'review_count',
        'published_date',
        'language',
        'page_count',
        'is_approved',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'published_date' => 'date',
        'approved_at' => 'datetime',
        'is_approved' => 'boolean',
        'rating' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(BookCategory::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function loanRequests()
    {
        return $this->hasMany(LoanRequest::class);
    }

    public function swapRequestsAsRequested()
    {
        return $this->hasMany(SwapRequest::class, 'requested_book_id');
    }

    public function swapRequestsAsOffered()
    {
        return $this->hasMany(SwapRequest::class, 'offered_book_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    // Accessors
    public function getFormattedConditionAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->condition));
    }

    public function getFormattedAvailabilityTypeAttribute()
    {
        return ucfirst($this->availability_type);
    }

    public function getIsAvailableForLoanAttribute()
    {
        return in_array($this->availability_type, ['loan', 'both']) && $this->status === 'available';
    }

    public function getIsAvailableForSwapAttribute()
    {
        return in_array($this->availability_type, ['swap', 'both']) && $this->status === 'available';
    }
}
