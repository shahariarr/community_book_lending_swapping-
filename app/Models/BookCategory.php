<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'icon',
        'image',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Boot the model and automatically generate slug from name
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Get all books in this category
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }

    /**
     * Get active books in this category
     */
    public function activeBooks()
    {
        return $this->hasMany(Book::class)->where('is_active', true);
    }

    /**
     * Get available books in this category
     */
    public function availableBooks()
    {
        return $this->hasMany(Book::class)
                    ->where('is_active', true)
                    ->where('availability_status', 'Available');
    }

    /**
     * Scope for active categories
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered categories
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Get books count for this category
     */
    public function getBooksCountAttribute()
    {
        return $this->books()->count();
    }

    /**
     * Get available books count for this category
     */
    public function getAvailableBooksCountAttribute()
    {
        return $this->availableBooks()->count();
    }

    /**
     * Get the full URL for the category image
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/category-images/' . $this->image);
        }
        return asset('backend/assets/img/default-category.png'); // Default image
    }

    /**
     * Get the image path for storage
     */
    public function getImagePathAttribute()
    {
        return $this->image ? 'category-images/' . $this->image : null;
    }
}
