<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    protected $fillable = ['date', 'is_available', 'note'];
    protected $casts = ['date' => 'date', 'is_available' => 'boolean'];
    public function available()
    {
        return $this->morphTo();
    }
}