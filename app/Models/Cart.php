<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'session_id',
    ];

    /**
     * Get the user that owns the cart.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the cart items for the cart.
     */
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get cart subtotal (before shipping, tax, etc.)
     * 
     * @return float
     */
    public function getSubtotal()
    {
        return $this->items->sum(function($item) {
            return $item->price * $item->quantity;
        });
    }

    /**
     * Get cart total
     * 
     * @return float
     */
    public function getTotal()
    {
        return $this->getSubtotal();
    }

    /**
     * Get cart items count
     * 
     * @return int
     */
    public function getItemsCount()
    {
        return $this->items->sum('quantity');
    }
} 