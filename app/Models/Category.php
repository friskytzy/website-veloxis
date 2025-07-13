<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'description',
        'parent_id',
    ];

    /**
     * Get the parent category.
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the subcategories.
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Get all products in this category.
     */
    public function products()
    {
        if ($this->type === 'bikes') {
            return $this->bikes();
        } elseif ($this->type === 'gear') {
            return $this->gear();
        }
        
        // Return an empty relation instead of null to prevent errors
        return $this->bikes()->where('id', 0); // This will always return an empty collection, not null
    }

    /**
     * Get the bikes for the category.
     */
    public function bikes()
    {
        return $this->hasMany(Bike::class);
    }

    /**
     * Get the gear for the category.
     */
    public function gear()
    {
        return $this->hasMany(Gear::class);
    }
}
