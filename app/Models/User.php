<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    /**
     * STUDIO MEMBERSHIP - Many-to-Many through studio_creators table
     * The pivot table connects creator_profiles to studios
     */
    public function studios(): BelongsToMany
    {
        // If user has a creator profile, get studios through it
        if ($this->creatorProfile) {
            return $this->creatorProfile->studios();
        }

        // Fallback: return empty relationship with correct pivot table
        return $this->belongsToMany(
            Studio::class,
            'studio_creators',
            'creator_profile_id',
            'Creator_id,
            'studio_id'
        )->whereRaw('1 = 0');
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

    public function conversations()
    {
        return Conversation::where('client_id', $this->id)
            ->orWhere('creator_id', $this->id);
    }

    // -------------------------------------------------------
    // Studio Helper Methods
    // -------------------------------------------------------

    /**
     * Check if user is a member of any studio
     */
    public function isStudioMember(): bool
    {
        return $this->creatorProfile && $this->creatorProfile->studios()->exists();
    }

    /**
     * Get the user's current studio (if they're a member)
     */
    public function currentStudio()
    {
        return $this->creatorProfile?->studios()->first();
    }

    /**
     * Check if user is a member of a specific studio
     */
    public function isMemberOfStudio($studioId): bool
    {
        return $this->creatorProfile &&
            $this->creatorProfile->studios()->where('studio_id', $studioId)->exists();
    }

    /**
     * Get user's role in a studio
     */
    public function getStudioRole($studioId): ?string
    {
        $studio = $this->creatorProfile?->studios()
            ->where('studio_id', $studioId)
            ->first();

        return $studio ? $studio->pivot->role : null;
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
