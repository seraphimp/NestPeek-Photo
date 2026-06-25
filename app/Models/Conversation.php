<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [
        'booking_id',
        'client_id',
        'creator_id',
        'subject',
        'last_message_at',
        'client_unread',
        'creator_unread',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
    public function messages()
    {
        return $this->hasMany(Message::class)->latest();
    }
    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }
}
