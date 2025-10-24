<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug', 
        'description',
        'price',
        'duration_days',
        'duration_type',
        'features',
        'max_products',
        'max_orders',
        'commission_rate',
        'is_active',
        'is_featured',
        'sort_order'
    ];

    protected $casts = [
        'features' => 'array',
        'price' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean'
    ];

    /**
     * علاقة مع الاشتراكات
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * الحصول على الخطط النشطة
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * الحصول على الخطط مرتبة
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('price', 'asc');
    }

    /**
     * تنسيق السعر
     */
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2) . ' ريال';
    }

    /**
     * حساب المدة بالشهور
     */
    public function getDurationInMonthsAttribute()
    {
        return round($this->duration_days / 30);
    }
}
