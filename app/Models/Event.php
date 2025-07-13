<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'start_date',
        'end_date',
        'location',
        'max_participants',
        'image',
        'is_featured',
        'registration_link',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_featured' => 'boolean',
    ];
    
    /**
     * Scope a query to only include upcoming events.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now())
                     ->orderBy('start_date', 'asc');
    }
    
    /**
     * Scope a query to only include past events.
     */
    public function scopePast($query)
    {
        return $query->where('start_date', '<', now())
                     ->orderBy('start_date', 'desc');
    }
    
    /**
     * Scope a query to only include featured events.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
    
    /**
     * Check if the event is ongoing.
     */
    public function isOngoing()
    {
        $now = now();
        return $this->start_date <= $now && 
              ($this->end_date === null || $this->end_date >= $now);
    }
}
