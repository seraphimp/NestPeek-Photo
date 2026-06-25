<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'portfolio_id',
        'file_path',
        'thumbnail_path',
        'type',
        'caption',
        'sort_order',
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }

    public function getFileUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }

    public function getThumbnailUrlAttribute(): string
    {
        return $this->thumbnail_path
            ? asset('storage/' . $this->thumbnail_path)
            : $this->file_url;
    }

    public function getIsVideoAttribute(): bool
    {
        return $this->type === 'video';
    }
}
