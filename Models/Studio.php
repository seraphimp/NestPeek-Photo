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
    ];

    protected $casts = [
        'amenities' => 'array',
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

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function services()
    {
        return $this->morphMany(Service::class, 'serviceable');
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function creators()
    {
        return $this->belongsToMany(CreatorProfile::class, 'studio_creators')
            ->withPivot('role', 'is_featured')
            ->withTimestamps();
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function availabilities()
    {
        return $this->morphMany(Availability::class, 'available');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorable');
    }
}