<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreatorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'slug',
        'bio',
        'location',
        'website',
        'instagram',
        'facebook',
        'twitter',
        'youtube',
        'tiktok',
        'phone',
        'profile_photo',
        'cover_photo',
        'is_verified',
        'is_featured',
        'average_rating',
        'profile_views',
        'hourly_rate',
        'experience_years',
        'specialties',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'is_featured' => 'boolean',
        'average_rating' => 'decimal:2',
        'specialties' => 'array',
    ];

    /**
     * Get the user that owns the creator profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the bookings for the creator.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get the reviews for the creator.
     */
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    /**
     * Get the portfolios for the creator.
     */
    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }

    /**
     * Get the services for the creator.
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Get the studios that the creator belongs to.
     * Uses creator_id (references users table) in the pivot table.
     */
    public function studios()
    {
        return $this->belongsToMany(
            Studio::class,
            'studio_creators',
            'creator_id',
            'studio_id',
            'user_id',
            'id'
        )->withPivot('role', 'joined_at', 'status', 'permissions')
         ->withTimestamps();
    }

    /**
     * Get the studio where the user is a member.
     */
    public function studio()
    {
        return $this->hasOneThrough(
            Studio::class,
            StudioCreator::class,
            'creator_id',
            'id',
            'user_id',
            'studio_id'
        );
    }

    /**
     * Check if the creator is a member of any studio.
     */
    public function isStudioMember()
    {
        return $this->studios()->exists();
    }

    /**
     * Get the current studio membership for the creator.
     */
    public function currentStudioMembership()
    {
        return $this->studios()->first();
    }

    /**
     * Get the favorites for the creator profile.
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    /**
     * Check if the creator profile is favorited by a user.
     */
    public function isFavoritedBy($userId = null)
    {
        if (!$userId) {
            $userId = auth()->id();
        }

        if (!$userId) {
            return false;
        }

        return $this->favorites()->where('user_id', $userId)->exists();
    }

    /**
     * Toggle favorite status for a user.
     */
    public function toggleFavorite($userId = null)
    {
        if (!$userId) {
            $userId = auth()->id();
        }

        if (!$userId) {
            return false;
        }

        $favorite = $this->favorites()->where('user_id', $userId)->first();

        if ($favorite) {
            $favorite->delete();
            return false; // Unfavorited
        } else {
            $this->favorites()->create(['user_id' => $userId]);
            return true; // Favorited
        }
    }

    /**
     * Get the favorite count.
     */
    public function getFavoriteCountAttribute()
    {
        return $this->favorites()->count();
    }
}
