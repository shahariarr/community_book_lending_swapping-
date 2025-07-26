<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookRequest extends Model
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
        'published_date',
        'language',
        'page_count',
        'status',
        'admin_comment',
        'reviewed_at',
        'reviewed_by',
    ];

    protected $casts = [
        'published_date' => 'date',
        'reviewed_at' => 'datetime',
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

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Methods
    public function approve($adminId, $comment = null)
    {
        $this->update([
            'status' => 'approved',
            'admin_comment' => $comment,
            'reviewed_at' => now(),
            'reviewed_by' => $adminId,
        ]);

        // Create the actual book record
        Book::create([
            'title' => $this->title,
            'author' => $this->author,
            'isbn' => $this->isbn,
            'description' => $this->description,
            'image' => $this->image,
            'category_id' => $this->category_id,
            'user_id' => $this->user_id,
            'condition' => $this->condition,
            'availability_type' => $this->availability_type,
            'published_date' => $this->published_date,
            'language' => $this->language,
            'page_count' => $this->page_count,
            'is_approved' => true,
            'approved_at' => now(),
            'approved_by' => $adminId,
        ]);
    }

    public function reject($adminId, $comment)
    {
        $this->update([
            'status' => 'rejected',
            'admin_comment' => $comment,
            'reviewed_at' => now(),
            'reviewed_by' => $adminId,
        ]);
    }
}
