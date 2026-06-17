<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'avatar',
        'bio',
        'location',
        'website',
        'instagram',
        'facebook',
        'is_verified',
        'is_active',
        'is_featured',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_verified'       => 'boolean',
        'is_active'         => 'boolean',
        'is_featured'       => 'boolean',
    ];

    // -------------------------------------------------------
    // Relationships
    // -------------------------------------------------------

    public function creatorProfile()
    {
        return $this->hasOne(CreatorProfile::class);
    }

    public function ownedStudios()
    {
        return $this->hasMany(Studio::class, 'owner_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'client_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    // CORRECT
    public function conversations()
    {
        return Conversation::where('client_id', $this->id)
            ->orWhere('creator_id', $this->id);
    }

    // -------------------------------------------------------
    // Role helpers
    // -------------------------------------------------------

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isCreator(): bool
    {
        return $this->role === 'creator';
    }

    public function isStudioOwner(): bool
    {
        return $this->role === 'studio_owner';
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    // -------------------------------------------------------
    // Accessors
    // -------------------------------------------------------

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name)
            . '&background=1a1a2e&color=d4af37&size=128';
    }
}
