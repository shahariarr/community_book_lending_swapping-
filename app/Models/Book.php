<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'description',
        'publisher',
        'publication_year',
        'pages',
        'language',
        'condition',
        'availability_status',
        'cover_image',
        'price',
        'notes',
        'is_active',
        'book_category_id',
        'owner_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'publication_year' => 'integer'
    ];

    /**
     * Get the category that owns the book
     */
    public function category()
    {
        return $this->belongsTo(BookCategory::class, 'book_category_id');
    }

    /**
     * Get the owner of the book
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Scope for active books
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for available books
     */
    public function scopeAvailable($query)
    {
        return $query->where('availability_status', 'Available')->where('is_active', true);
    }

    /**
     * Scope for borrowed books
     */
    public function scopeBorrowed($query)
    {
        return $query->where('availability_status', 'Borrowed');
    }

    /**
     * Scope for books by category
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('book_category_id', $categoryId);
    }

    /**
     * Search books by title or author
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('author', 'like', "%{$search}%")
              ->orWhere('isbn', 'like', "%{$search}%");
        });
    }

    /**
     * Get formatted condition with badge class
     */
    public function getConditionBadgeAttribute()
    {
        $badges = [
            'New' => 'badge-success',
            'Good' => 'badge-primary',
            'Fair' => 'badge-warning',
            'Poor' => 'badge-danger'
        ];

        return $badges[$this->attributes['condition']] ?? 'badge-secondary';
    }

    /**
     * Get formatted availability status with badge class
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'Available' => 'badge-success',
            'Borrowed' => 'badge-warning',
            'Reserved' => 'badge-info',
            'Maintenance' => 'badge-danger'
        ];

        return $badges[$this->attributes['availability_status']] ?? 'badge-secondary';
    }

    /**
     * Get the full URL for the book cover image
     */
    public function getCoverImageUrlAttribute()
    {
        if ($this->getAttribute('cover_image')) {
            return asset('storage/book-covers/' . $this->getAttribute('cover_image'));
        }
        return asset('backend/assets/img/default-book.png'); // Default image
    }

    /**
     * Get the cover image path for storage
     */
    public function getCoverImagePathAttribute()
    {
        return $this->getAttribute('cover_image') ? 'book-covers/' . $this->getAttribute('cover_image') : null;
    }
}
