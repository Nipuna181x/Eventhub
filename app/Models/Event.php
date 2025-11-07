<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'location', 'starts_at', 'ends_at', 'capacity', 'user_id'
    ];
    
    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];
    
    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id');

    }
    
}
