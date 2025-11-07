<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rsvp extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'status',
    ];

    /**
     * Get the user who made the RSVP
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the event for this RSVP
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}