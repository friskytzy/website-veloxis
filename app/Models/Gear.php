<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gear extends Model
{
    use HasFactory;

    protected $table = 'gear';

    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'category_id',
        'image',
        'size',
        'color',
        'stock',
        'is_featured',
    ];

    /**
     * Get the category that owns the gear.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Get the order items for the gear.
     */
    public function orderItems()
    {
        return $this->morphMany(OrderItem::class, 'product');
    }
}
