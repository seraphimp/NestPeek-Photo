<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudioCreator extends Model
{
    use HasFactory;

    protected $fillable = [
        'studio_id',
        'creator_id',
        'role',
        'joined_at',
        'status',
        'permissions'
    ];

    protected $casts = [
        'joined_at' => 'datetime',
        'permissions' => 'array'
    ];

    /**
     * Get the studio that the creator belongs to.
     */
    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }

    /**
     * Get the user (creator) that belongs to the studio.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Get the creator profile through the user relationship.
     */
    public function creatorProfile()
    {
        return $this->hasOneThrough(
            CreatorProfile::class,
            User::class,
            'id', // Foreign key on users table
            'user_id', // Foreign key on creator_profiles table
            'creator_id', // Local key on studio_creators table
            'id' // Local key on users table
        );
    }
}
