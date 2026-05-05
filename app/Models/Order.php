<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'customer_name',
        'total',
        'status',
        'address',
        'city',
        'postal_code',
        'phone',
        'email',
        'courier',
        'subtotal',
        'shipping_cost',
        'discount',
        'payment_method',
        'payment_provider',
        'payment_status',
        'external_payment_id',
        'tracking_number',
        'notes',
    ];

    protected $casts = [
        'total' => 'integer',
        'subtotal' => 'integer',
        'shipping_cost' => 'integer',
        'discount' => 'integer',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order items for the order.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
