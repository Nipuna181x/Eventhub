<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'description', 
        'location', 
        'starts_at', 
        'ends_at', 
        'capacity', 
        'user_id'
    ];
    
    // Cast dates to Carbon instances
    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];
    
    /**
     * Get the admin who created the event
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all RSVPs for this event
     */
    public function rsvps()
    {
        return $this->hasMany(Rsvp::class);
    }

    /**
     * Get attending RSVPs only
     */
    public function attendees()
    {
        return $this->hasMany(Rsvp::class)->where('status', 'attending');
    }

    /**
     * Get waitlist RSVPs only
     */
    public function waitlist()
    {
        return $this->hasMany(Rsvp::class)->where('status', 'waitlist');
    }

    /**
     * Check if event is at full capacity
     */
    public function isFull()
    {
        if (!$this->capacity) {
            return false; // No capacity limit
        }
        
        return $this->attendees()->count() >= $this->capacity;
    }

    /**
     * Get available spots
     */
    public function availableSpots()
    {
        if (!$this->capacity) {
            return null; // Unlimited
        }
        
        return $this->capacity - $this->attendees()->count();
    }

    /**
     * Check if a user has RSVPed to this event
     */
    public function hasUserRsvped($userId)
    {
        return $this->rsvps()->where('user_id', $userId)->exists();
    }

    /**
     * Get user's RSVP status for this event
     */
    public function getUserRsvpStatus($userId)
    {
        $rsvp = $this->rsvps()->where('user_id', $userId)->first();
        return $rsvp ? $rsvp->status : null;
    }
}