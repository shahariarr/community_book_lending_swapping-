<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'google_id',
        'phone',
        'location',
        'bio',
        'reading_interests',
        'is_active',
        'last_active_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'reading_interests' => 'array',
        'last_active_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function bookRequests()
    {
        return $this->hasMany(BookRequest::class);
    }

    public function loanRequestsAsBorrower()
    {
        return $this->hasMany(LoanRequest::class, 'borrower_id');
    }

    public function loanRequestsAsLender()
    {
        return $this->hasMany(LoanRequest::class, 'lender_id');
    }

    public function swapRequestsAsRequester()
    {
        return $this->hasMany(SwapRequest::class, 'requester_id');
    }

    public function swapRequestsAsOwner()
    {
        return $this->hasMany(SwapRequest::class, 'owner_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getInitialsAttribute()
    {
        $names = explode(' ', $this->name);
        $initials = '';
        foreach ($names as $name) {
            $initials .= strtoupper(substr($name, 0, 1));
        }
        return $initials;
    }





    /**
     * Generate a unique 10-character identifier
     *
     * @return string
     */
    protected function generateUniqueId()
    {
        // Mix of uppercase letters and numbers (avoiding similar looking characters)
        $characters = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        $idLength = 10;
        $uniqueId = '';

        for ($i = 0; $i < $idLength; $i++) {
            $uniqueId .= $characters[rand(0, strlen($characters) - 1)];
        }

        // Check if this ID already exists to prevent duplicates
        if (self::where('unique_id', $uniqueId)->exists()) {
            return $this->generateUniqueId(); // Recursively try again
        }

        return $uniqueId;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->unique_id = $user->generateUniqueId();
        });
    }
}
