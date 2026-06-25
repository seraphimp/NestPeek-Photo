<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    use HasFactory, SoftDeletes;
    use \Spatie\Sluggable\HasSlug;

    protected $fillable = [
        'owner_id',
        'name',
        'slug',
        'tagline',
        'description',
        'logo',
        'cover_photo',
        'address',
        'city',
        'province',
        'country',
        'postal_code',
        'latitude',
        'longitude',
        'phone',
        'email',
        'website',
        'instagram',
        'facebook',
        'amenities',
        'equipment_available',
        'studio_area_sqm',
        'max_capacity',
        'hourly_rate',
        'half_day_rate',
        'full_day_rate',
        'currency',
        'operating_hours',
        'is_active',
        'is_featured',
        'is_verified',
        'average_rating',
        'total_reviews',
        'specializations',
    ];

    protected $casts = [
        'amenities' => 'array',
        'specializations' => 'array',
        'equipment_available' => 'array',
        'operating_hours' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_verified' => 'boolean',
    ];

    public function getSlugOptions(): \Spatie\Sluggable\SlugOptions
    {
        return \Spatie\Sluggable\SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // ============================================================
    // RELATIONSHIPS
    // ============================================================

    /**
     * The user who owns this studio
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * ALIAS: Get the owner as a creator profile
     * This is the relationship that was missing!
     */
    public function creatorProfile()
    {
        return $this->hasOneThrough(
            CreatorProfile::class,
            User::class,
            'id',        // Foreign key on users table
            'user_id',   // Foreign key on creator_profiles table
            'owner_id',  // Local key on studios table
            'id'         // Local key on users table
        );
    }

    /**
     * Get all creator members of this studio
     */
    public function creators()
    {
        return $this->belongsToMany(CreatorProfile::class, 'studio_creators')
            ->withPivot('role', 'is_featured')
            ->withTimestamps();
    }

    /**
     * Get all users who are members of this studio (through creator profiles)
     */
    public function members()
    {
        return $this->hasManyThrough(
            User::class,
            CreatorProfile::class,
            'id',           // Foreign key on creator_profiles
            'id',           // Foreign key on users
            'id',           // Local key on studios
            'user_id'       // Local key on creator_profiles
        )->whereHas('creatorProfile', function ($query) {
            $query->whereIn('id', $this->creators()->pluck('creator_profiles.id'));
        });
    }

    /**
     * Get all services for this studio
     */
    public function services()
    {
        return $this->morphMany(Service::class, 'serviceable');
    }

    /**
     * Get all reviews for this studio
     */
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    /**
     * Get all bookings for this studio
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get all availabilities for this studio
     */
    public function availabilities()
    {
        return $this->morphMany(Availability::class, 'available');
    }

    /**
     * Get all favorites for this studio
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorable');
    }
}
