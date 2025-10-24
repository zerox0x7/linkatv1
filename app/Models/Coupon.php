<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'code',
        'category',
        'style_id',
        'type',
        'value',
        'starts_at',
        'expires_at',
        'max_uses',
        'used_times',
        'min_order_amount',
        'max_discount_amount',
        'user_limit',
        'priority',
        'auto_apply',
        'stackable',
        'email_notifications',
        'show_on_homepage',
        'is_active',
        'product_ids',
        'category_ids',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'auto_apply' => 'boolean',
        'stackable' => 'boolean',
        'show_on_homepage' => 'boolean',
        'email_notifications' => 'boolean',
        'value' => 'decimal:2',
        'max_discount_amount' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'product_ids' => 'array',
        'category_ids' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCurrent($query)
    {
        return $query
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('starts_at')
                      ->orWhere('starts_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>=', now());
            })
            ->where(function ($query) {
                $query->whereNull('max_uses')
                      ->orWhereRaw('used_times < max_uses');
            });
    }

    public function isValid()
    {
        // Check if coupon is active
        if (!$this->is_active) {
            return false;
        }

        // Check if coupon has started
        if ($this->starts_at && $this->starts_at > now()) {
            return false;
        }

        // Check if coupon has expired
        if ($this->expires_at && $this->expires_at < now()) {
            return false;
        }

        // Check if coupon has reached max uses
        if ($this->max_uses && $this->used_times >= $this->max_uses) {
            return false;
        }

        return true;
    }

    public function calculateDiscount($amount)
    {
        if (!$this->isValid()) {
            return 0;
        }

        // Check minimum order amount
        if ($this->min_order_amount && $amount < $this->min_order_amount) {
            return 0;
        }

        if ($this->type === 'percentage') {
            $discount = ($amount * $this->value) / 100;
            
            // Apply maximum discount cap if set
            if ($this->max_discount_amount && $discount > $this->max_discount_amount) {
                $discount = $this->max_discount_amount;
            }
            
            return $discount;
        }

        if ($this->type === 'fixed') {
            return min($this->value, $amount);
        }

        return 0;
    }

    public function incrementUsage()
    {
        $this->increment('used_times');
        $this->touch(); // Update updated_at timestamp
    }

    public function orders()
    {
        // If you have an orders table with coupon_code or coupon_id
        return $this->hasMany(\App\Models\Order::class, 'coupon_code', 'code');
    }

    public function categories()
    {
        if (empty($this->category_ids)) {
            return collect([]);
        }
        return Category::whereIn('id', $this->category_ids)->get();
    }

    public function products()
    {
        if (empty($this->product_ids)) {
            return collect([]);
        }
        return Product::whereIn('id', $this->product_ids)->get();
    }

    // Helper method to check if coupon applies to a specific category
    public function appliesToCategory($categoryId)
    {
        return empty($this->category_ids) || in_array($categoryId, $this->category_ids);
    }

    // Helper method to check if coupon applies to a specific product
    public function appliesToProduct($productId)
    {
        return empty($this->product_ids) || in_array($productId, $this->product_ids);
    }

    // Helper methods for display
    public function getDisplayNameAttribute()
    {
        return $this->code . ($this->category ? ' (' . $this->category . ')' : '');
    }

    public function getFormattedDiscountAttribute()
    {
        if ($this->type === 'percentage') {
            return $this->value . '%';
        }
        return $this->value . ' ر.س';
    }

    public function getStatusAttribute()
    {
        if (!$this->is_active) {
            return 'غير مفعل';
        }

        if ($this->starts_at && $this->starts_at > now()) {
            return 'لم يبدأ بعد';
        }

        if ($this->expires_at && $this->expires_at < now()) {
            return 'منتهي الصلاحية';
        }

        if ($this->max_uses && $this->used_times >= $this->max_uses) {
            return 'مستنفد';
        }

        return 'نشط';
    }
} 