<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'reviewer_id',
        'rating',
        'title',
        'content',
        'communication_rating',
        'quality_rating',
        'value_rating',
        'professionalism_rating',
        'would_recommend',
        'is_verified',
        'is_published',
        'response',
        'responded_at',
    ];

    protected $casts = [
        'would_recommend' => 'boolean',
        'is_verified' => 'boolean',
        'is_published' => 'boolean',
        'responded_at' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
    public function reviewable()
    {
        return $this->morphTo();
    }
}
