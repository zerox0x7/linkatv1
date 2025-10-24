<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Category extends Model
{
    use HasFactory;


    protected $fillable = [
        'store_id',
        'name',
        'slug',
        'image',
        'description',
        'is_active',
        'is_featured',
        'show_in_homepage',
        'homepage_order',
        'sort_order',
        'type',
        'parent_id',
        'order',
        'text_color',
        'bg_color',
        'icon',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'show_in_homepage' => 'boolean',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function digitalCards(): HasMany
    {
        return $this->hasMany(DigitalCard::class);
    }
    
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // public function scopeActive($query)
    // {
    //     return $query->where('is_active', true);
    // }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeAccounts($query)
    {
        return $query->where('type', 'account');
    }

    public function scopeDigitalCards($query)
    {
        return $query->where('type', 'digital_card');
    }
    
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * نطاق للتصنيفات التي تظهر في الصفحة الرئيسية
     */
    public function scopeShowInHomepage($query)
    {
        return $query->where('show_in_homepage', true);
    }

    /**
     * الحصول على رابط صورة التصنيف
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('themes/default/images/default-category.png');
    }

    /**
     * علاقة مع الكوبونات
     */
    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_categories');
    }
} 