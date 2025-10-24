<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class DigitalCard extends Model
{
    use HasFactory;

    /**
     * الخصائص القابلة للتعيين الجماعي
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'discount_price',
        'stock_quantity',
        'image',
        'instructions',
        'is_active',
        'is_featured'
    ];

    /**
     * الخصائص التي يجب تحويلها
     *
     * @var array
     */
    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * علاقة مع أكواد البطاقات
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function codes(): HasMany
    {
        return $this->hasMany(DigitalCardCode::class);
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
    
    public function orderItems(): MorphMany
    {
        return $this->morphMany(OrderItem::class, 'orderable');
    }

    /**
     * Get all of the digital card's cart items.
     */
    public function cartItems(): MorphMany
    {
        return $this->morphMany(CartItem::class, 'cartable');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    /**
     * الحصول على عدد الأكواد المتاحة
     *
     * @return int
     */
    public function getAvailableCodesCountAttribute(): int
    {
        return $this->codes()->whereNull('user_id')->count();
    }

    /**
     * تحديد ما إذا كانت البطاقة متوفرة للشراء
     *
     * @return bool
     */
    public function getIsAvailableAttribute(): bool
    {
        return $this->is_active && $this->available_codes_count > 0;
    }

    /**
     * الحصول على سعر الخصم إذا كان متوفراً
     * 
     * @return float|null
     */
    public function getDiscountPriceAttribute(): ?float
    {
        if ($this->discount_price && $this->discount_price < $this->price) {
            return $this->discount_price;
        }
        
        return null;
    }

    /**
     * الحصول على رابط صورة البطاقة الرقمية
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/placeholder-image.jpg');
        }
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($this->image)) {
            return asset('storage/' . $this->image);
        }
        return asset('images/placeholder-image.jpg');
    }
} 