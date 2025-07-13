<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Bike extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'category_id',
        'image',
        'specifications',
        'stock',
        'is_featured',
    ];

    protected $casts = [
        'specifications' => 'array',
        'is_featured' => 'boolean',
    ];
    
    /**
     * Get the full image URL.
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/defaults/default-bike.jpg');
        }
        
        return Storage::disk('public')->url($this->image);
    }

    /**
     * Get the category that owns the bike.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the order items for the bike.
     */
    public function orderItems()
    {
        return $this->morphMany(OrderItem::class, 'product');
    }
}
