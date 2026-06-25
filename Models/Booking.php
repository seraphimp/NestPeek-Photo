<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'booking_number',
        'client_id',
        'service_id',
        'creator_profile_id',
        'studio_id',
        'status',
        'event_date',
        'start_time',
        'end_time',
        'event_type',
        'venue',
        'notes',
        'special_requests',
        'subtotal',
        'discount_amount',
        'tax_amount',
        'total_amount',
        'deposit_amount',
        'amount_paid',
        'amount_due',
        'payment_status',
        'stripe_payment_intent',
        'confirmed_at',
        'cancelled_at',
        'cancellation_reason',
    ];

    protected $casts = [
        'event_date' => 'date',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'amount_due' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($booking) {
            $booking->booking_number = 'NP-' . date('Y') . '-' . str_pad(
                Booking::whereYear('created_at', date('Y'))->count() + 1,
                6,
                '0',
                STR_PAD_LEFT
            );
        });
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function creatorProfile()
    {
        return $this->belongsTo(CreatorProfile::class);
    }
    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function review()
    {
        return $this->hasOne(Review::class);
    }
    public function conversation()
    {
        return $this->hasOne(Conversation::class);
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'pending'      => ['label' => 'Pending', 'color' => 'amber'],
            'confirmed'    => ['label' => 'Confirmed', 'color' => 'blue'],
            'deposit_paid' => ['label' => 'Deposit Paid', 'color' => 'teal'],
            'in_progress'  => ['label' => 'In Progress', 'color' => 'purple'],
            'completed'    => ['label' => 'Completed', 'color' => 'green'],
            'cancelled'    => ['label' => 'Cancelled', 'color' => 'red'],
            'refunded'     => ['label' => 'Refunded', 'color' => 'gray'],
            default        => ['label' => 'Unknown', 'color' => 'gray'],
        };
    }
}

// ============================================================
// FILE: app/Models/Portfolio.php
// ============================================================
class Portfolio extends Model
{
    use HasFactory;
    use \Spatie\Sluggable\HasSlug;

    protected $fillable = [
        'creator_profile_id',
        'slug',
        'title',
        'description',
        'category',
        'cover_image',
        'location',
        'shoot_date',
        'tags',
        'is_featured',
        'is_published',
        'view_count',
        'like_count',
        'sort_order',
    ];

    protected $casts = [
        'tags' => 'array',
        'shoot_date' => 'date',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function getSlugOptions(): \Spatie\Sluggable\SlugOptions
    {
        return \Spatie\Sluggable\SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function creatorProfile()
    {
        return $this->belongsTo(CreatorProfile::class);
    }
    public function media()
    {
        return $this->hasMany(PortfolioMedia::class)->orderBy('sort_order');
    }
    public function coverMedia()
    {
        return $this->hasOne(PortfolioMedia::class)->orderBy('sort_order');
    }
}
