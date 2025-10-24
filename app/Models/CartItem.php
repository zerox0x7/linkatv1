<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cart_id',
        'cartable_id',
        'cartable_type',
        'quantity',
        'price',
        'options',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'options' => 'array',
        'price' => 'decimal:2',
    ];

    /**
     * Get the cart that owns the item.
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Get the owning cartable model.
     */
    public function cartable()
    {
        return $this->morphTo();
    }

    /**
     * Get the total price for this item.
     */
    public function getTotalAttribute()
    {
        return $this->price * $this->quantity;
    }
} 