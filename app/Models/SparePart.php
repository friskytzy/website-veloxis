<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SparePart extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'category',
        'part_brand',
        'motor_brand',
        'compatible_models',
        'compatible_years',
        'price',
        'stock',
        'rating',
        'review_count',
        'image_url',
        'description',
        'specifications',
        'badge',
        'status',
        'is_featured',
    ];

    protected $casts = [
        'compatible_models' => 'array',
        'specifications' => 'array',
        'is_featured' => 'boolean',
        'price' => 'integer',
        'stock' => 'integer',
        'rating' => 'decimal:1',
        'review_count' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeLowStock($query, int $threshold = 5)
    {
        return $query->where('stock', '<=', $threshold);
    }

    public function toCatalogArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'sku' => $this->sku,
            'category' => $this->category,
            'part_brand' => $this->part_brand,
            'motor_brand' => $this->motor_brand,
            'models' => $this->compatible_models ?? [],
            'years' => $this->compatible_years,
            'price' => $this->price,
            'stock' => $this->stock,
            'rating' => (float) $this->rating,
            'review_count' => $this->review_count,
            'image' => $this->image_url,
            'description' => $this->description,
            'specifications' => $this->specifications ?? [],
            'badge' => $this->badge,
        ];
    }
}
