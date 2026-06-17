<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'creator_profile_id',
        'title',
        'slug',
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
        'tags'         => 'array',
        'is_featured'  => 'boolean',
        'is_published' => 'boolean',
        'shoot_date'   => 'date',
    ];

    public function creatorProfile()
    {
        return $this->belongsTo(CreatorProfile::class);
    }

    public function media()
    {
        return $this->hasMany(PortfolioMedia::class)->orderBy('sort_order');
    }

    public function getCoverImageUrlAttribute(): string
    {
        return $this->cover_image
            ? asset('storage/' . $this->cover_image)
            : asset('images/default-portfolio.jpg');
    }
}
