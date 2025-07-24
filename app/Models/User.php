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

    ];





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
