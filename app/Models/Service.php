<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    use \Spatie\Sluggable\HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'category',
        'price',
        'price_type',
        'currency',
        'duration_hours',
        'inclusions',
        'exclusions',
        'max_bookings_per_day',
        'requires_deposit',
        'deposit_amount',
        'deposit_percentage',
        'advance_booking_days',
        'is_active',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'requires_deposit' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function getSlugOptions(): \Spatie\Sluggable\SlugOptions
    {
        return \Spatie\Sluggable\SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function serviceable()
    {
        return $this->morphTo();
    }
    public function creatorProfile()
{
    return $this->belongsTo(CreatorProfile::class, 'creator_id');
}

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getDepositAmountAttribute($value): float
    {
        if ($this->deposit_percentage) {
            return $this->price * ($this->deposit_percentage / 100);
        }
        return $value ?? 0;
    }

    public function getFormattedPriceAttribute(): string
    {
        return $this->currency . ' ' . number_format($this->price, 2);
    }
}
