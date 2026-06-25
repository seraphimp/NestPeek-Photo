<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CreatorProfile extends Model
{
    use HasFactory;
    use \Spatie\Sluggable\HasSlug;

    protected $fillable = [
        'user_id',
        'slug',
        'brand_name',
        'tagline',
        'cover_photo',
        'specialization',
        'skills',
        'equipment',
        'styles',
        'years_experience',
        'starting_price',
        'currency',
        'is_available',
        'availability_note',
        'service_areas',
        'travels_internationally',
        'average_rating',
        'total_reviews',
        'total_bookings',
        'profile_views',
    ];

    protected $casts = [
        'skills'                  => 'array',
        'equipment'               => 'array',
        'styles'                  => 'array',
        'service_areas'           => 'array',
        'is_available'            => 'boolean',
        'travels_internationally' => 'boolean',
        'average_rating'          => 'decimal:2',
        'starting_price'          => 'decimal:2',
    ];

    // ── Slug ────────────────────────────────────────────────────

    public function getSlugOptions(): \Spatie\Sluggable\SlugOptions
    {
        return \Spatie\Sluggable\SlugOptions::create()
            ->generateSlugsFrom(fn($model) => $model->brand_name ?? $model->user->name)
            ->saveSlugsTo('slug');
    }

    // ── Relationships ────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        return $this->morphMany(Service::class, 'serviceable');
    }

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
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

    public function studios(): BelongsToMany
    {
        return $this->belongsToMany(Studio::class, 'studio_creators')
            ->withPivot('role', 'is_featured')
            ->withTimestamps();
    }

    // Convenience: first studio this creator belongs to (used by topbar)
    public function getStudioAttribute(): ?Studio
    {
        return $this->studios()->first();
    }

    // ── Accessors ────────────────────────────────────────────────

    public function getDisplayNameAttribute(): string
    {
        return $this->brand_name ?? $this->user->name;
    }

    public function getSpecializationLabelAttribute(): string
    {
        return match ($this->specialization) {
            'wedding_photographer'  => 'Wedding Photographer',
            'wedding_videographer'  => 'Wedding Videographer',
            'portrait_photographer' => 'Portrait Photographer',
            'event_photographer'    => 'Event Photographer',
            'event_videographer'    => 'Event Videographer',
            'wedding_coordinator'   => 'Wedding Coordinator',
            'photo_editor'          => 'Photo Editor',
            'video_editor'          => 'Video Editor',
            'drone_operator'        => 'Drone Operator',
            'photo_booth'           => 'Photo Booth',
            default                 => 'Creator',
        };
    }

    public function getCoverPhotoUrlAttribute(): string
    {
        return $this->cover_photo
            ? asset('storage/' . $this->cover_photo)
            : asset('images/default-cover.jpg');
    }

    public function getAvailabilityStatusAttribute(): string
    {
        if (!$this->is_available) {
            return 'unavailable';
        }

        $hasUpcoming = $this->bookings()
            ->whereIn('status', ['confirmed', 'deposit_paid', 'in_progress'])
            ->where('event_date', '>=', now())
            ->where('event_date', '<=', now()->addDays(30))
            ->exists();

        return $hasUpcoming ? 'booked_soon' : 'available';
    }

    // ── Helpers ──────────────────────────────────────────────────

    /**
     * Check if a given user has favorited this profile.
     * Used by the index blade heart button.
     */
    public function isFavoritedBy(User $user): bool
    {
        return $this->favorites()
            ->where('user_id', $user->id)
            ->exists();
    }

    /**
     * Recalculate and save total_bookings from actual bookings table.
     * Call this whenever a booking is created, confirmed, or cancelled.
     */
    public function syncBookingCount(): void
    {
        $this->update([
            'total_bookings' => $this->bookings()
                ->whereNotIn('status', ['cancelled', 'refunded'])
                ->count(),
        ]);
    }

    /**
     * Recalculate and save average_rating + total_reviews from actual reviews table.
     * Call this whenever a review is created or deleted.
     */
    public function syncReviewStats(): void
    {
        $reviews = $this->reviews()->where('is_published', true);

        $this->update([
            'total_reviews'  => $reviews->count(),
            'average_rating' => $reviews->avg('rating') ?? 0,
        ]);
    }
}
