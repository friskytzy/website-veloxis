<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'author',
        'published_at',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];
    
    /**
     * Scope a query to only include published news.
     */
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }
    
    /**
     * Scope a query to only include featured news.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
