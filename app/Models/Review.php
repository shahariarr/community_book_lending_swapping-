<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'user_id',
        'rating',
        'comment',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    // Relationships
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    // Boot method to update book rating when review is created/updated
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($review) {
            $review->updateBookRating();
        });

        static::deleted(function ($review) {
            $review->updateBookRating();
        });
    }

    private function updateBookRating()
    {
        $book = $this->book;
        $reviews = $book->reviews()->approved();

        $avgRating = $reviews->avg('rating');
        $reviewCount = $reviews->count();

        $book->update([
            'rating' => $avgRating ? round($avgRating, 2) : null,
            'review_count' => $reviewCount,
        ]);
    }
}
