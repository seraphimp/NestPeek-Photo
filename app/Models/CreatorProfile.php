<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreatorProfile extends Model
{
    use HasFactory, SoftDeletes;

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
            'creator_id', // Foreign key on studio_creators table
            'studio_id', // Local key on studios table
            'user_id', // Local key on creator_profiles table
            'id' // Parent key on studios table
        )->withPivot('role', 'joined_at', 'status', 'permissions')
         ->withTimestamps();
    }

    /**
     * Get the studio where the user is a member.
     * Alternative: Get the studio directly.
     */
    public function studio()
    {
        return $this->hasOneThrough(
            Studio::class,
            StudioCreator::class,
            'creator_id', // Foreign key on studio_creators table
            'id', // Foreign key on studios table
            'user_id', // Local key on creator_profiles table
            'studio_id' // Local key on studio_creators table
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
}
