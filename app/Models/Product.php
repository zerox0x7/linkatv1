<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'has_discounts',
        'has_discount',
        'category_id',
        'name',
        'slug',
        'share_slug',
        'sku',
        'description',
        'product_note',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'focus_keyword',
        'tags',
        'seo_score',
        'details',
        'price',
        'old_price',
        'stock',
        'status',
        'is_featured',
        'features',
        'type',
        'warranty_days',
        'main_image',
        'gallery',
        'custom_fields',
        'price_options',
        'rating',
        'sales_count',
        'views_count',
        'coupon_eligible',
        'min_coupon_order_value',
        'max_coupon_discount_amount',
        'max_coupon_discount_percentage',
        'coupon_categories',
        'allow_coupon_stacking',
        'excluded_coupon_types',
        'coupon_start_date',
        'coupon_end_date',
    ];

    protected $casts = [
        'features' => 'array',
        'gallery' => 'array',
        'digital_codes' => 'array',
        'custom_fields' => 'array',
        'price_options' => 'array',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'rating' => 'float',
        'tags' => 'array',
        'coupon_eligible' => 'boolean',
        'min_coupon_order_value' => 'decimal:2',
        'max_coupon_discount_amount' => 'decimal:2',
        'max_coupon_discount_percentage' => 'decimal:2',
        'coupon_categories' => 'array',
        'allow_coupon_stacking' => 'boolean',
        'excluded_coupon_types' => 'array',
        'coupon_start_date' => 'datetime',
        'coupon_end_date' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // قبل حفظ المنتج، تأكد من وجود slug وshare_slug
        static::saving(function ($product) {
            // إنشاء slug عشوائي إذا لم يكن موجوداً
            if (empty($product->slug)) {
                $product->slug = Str::random(10);
            }
            
            // إنشاء share_slug من اسم المنتج إذا لم يكن موجوداً
            if (empty($product->share_slug)) {
                $product->share_slug = self::generateShareSlug($product->name);
            }
        });
    }

    /**
     * توليد share_slug فريد من الاسم
     *
     * @param string $name
     * @return string
     */
    public static function generateShareSlug(string $name): string
    {
        $shareSlug = Str::slug($name);
        
        // التحقق من عدم وجود تكرار
        $count = 0;
        $originalShareSlug = $shareSlug;
        
        while (self::where('share_slug', $shareSlug)->exists()) {
            $count++;
            $shareSlug = $originalShareSlug . '-' . $count;
        }
        
        return $shareSlug;
    }

    /**
     * الحصول على مسار العرض للمنتج (يفضل استخدام share_slug إذا كان موجوداً)
     *
     * @return string
     */
    public function getShareUrlAttribute(): string
    {
        if (!empty($this->share_slug)) {
            return route('products.show', ['slug' => $this->share_slug]);
        }
        
        return route('products.show', ['slug' => $this->slug]);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
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
     * Get all of the product's cart items.
     */
    public function cartItems(): MorphMany
    {
        return $this->morphMany(CartItem::class, 'cartable');
    }

    /**
     * علاقة مع أكواد البطاقات الرقمية
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function digitalCodes(): HasMany
    {
        return $this->hasMany(DigitalCardCode::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'active')->where('stock', '>', 0);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeAccounts($query)
    {
        return $query->where('type', 'account');
    }

    public function getIsOnSaleAttribute(): bool
    {
        return $this->old_price && $this->old_price > $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->has_discount) {
            return round((($this->old_price - $this->price) / $this->old_price) * 100);
        }
        return 0;
    }

    /**
     * الحصول على سعر الخصم إذا كان متوفراً
     * 
     * @return float|null
     */
    public function getDiscountPriceAttribute(): ?float
    {
        if ($this->is_on_sale) {
            return $this->price;
        }
        
        return null;
    }

    /**
     * الحصول على قائمة التاغات كنص مفصول بفواصل
     * 
     * @return string
     */
    public function getTagsListAttribute(): string
    {
        if (empty($this->tags)) {
            return '';
        }
        
        if (is_string($this->tags) && is_array(json_decode($this->tags, true))) {
            return implode(', ', json_decode($this->tags, true));
        }
        
        return is_array($this->tags) ? implode(', ', $this->tags) : (string)$this->tags;
    }
    
    /**
     * تعيين قائمة التاغات من نص مفصول بفواصل
     * 
     * @param string $value
     * @return void
     */
    public function setTagsListAttribute(string $value): void
    {
        if (empty($value)) {
            $this->attributes['tags'] = null;
            return;
        }
        
        $tagsArray = array_map('trim', explode(',', $value));
        $this->attributes['tags'] = json_encode($tagsArray, JSON_UNESCAPED_UNICODE);
    }
    
    /**
     * الحصول على عنوان ميتا إذا كان موجوداً أو توليد واحد تلقائياً
     * 
     * @return string
     */
    public function getSeoTitleAttribute(): string
    {
        if (!empty($this->meta_title)) {
            return $this->meta_title;
        }
        
        // توليد عنوان تلقائي إذا لم يكن موجوداً
        return $this->name . ' - ' . ($this->category ? $this->category->name : 'منتجات');
    }
    
    /**
     * الحصول على وصف ميتا إذا كان موجوداً أو توليد واحد تلقائياً
     * 
     * @return string
     */
    public function getSeoDescriptionAttribute(): string
    {
        if (!empty($this->meta_description)) {
            return $this->meta_description;
        }
        
        // توليد وصف تلقائي إذا لم يكن موجوداً
        $description = strip_tags($this->description);
        return mb_strlen($description) > 160 ? mb_substr($description, 0, 157) . '...' : $description;
    }
    
    /**
     * الحصول على رابط الصورة الرئيسية
     *
     * @return string
     */
    public function getMainImageUrlAttribute()
    {
        if ($this->main_image) {
            return asset('storage/' . $this->main_image);
        }
        return asset('themes/default/images/default-product.png');
    }

    /**
     * الحصول على رابط الصورة (مستخدم في القوالب)
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        return $this->main_image_url;
    }

    /**
     * الحصول على روابط الصور الإضافية
     *
     * @return array
     */
    public function getGalleryUrlsAttribute()
    {
        if (!$this->gallery) {
            return [];
        }

        // Check if gallery is already an array (due to casting) or if it's a JSON string
        if (is_array($this->gallery)) {
            $gallery = $this->gallery;
        } else {
            $gallery = json_decode($this->gallery, true);
        }
        
        // If it's still not an array, return empty array
        if (!is_array($gallery)) {
            return [];
        }

        return array_map(function($image) {
            return asset('storage/' . $image);
        }, $gallery);
    }

    /**
     * تحديث متوسط تقييم المنتج بناءً على المراجعات المعتمدة
     *
     * @return void
     */
    public function updateRating(): void
    {
        $averageRating = $this->reviews()->where('is_approved', true)->avg('rating') ?? 0;
        $this->update(['rating' => $averageRating]);
    }

    /**
     * هل المنتج عليه خصم؟
     */
    public function getHasDiscountAttribute()
    {
        return $this->old_price && $this->old_price > $this->price;
    }

    /**
     * Accessor for 'image' attribute (alias for main_image)
     */
    public function getImageAttribute()
    {
        return $this->main_image;
    }

    /**
     * Accessor for 'original_price' attribute (alias for old_price)
     */
    public function getOriginalPriceAttribute()
    {
        return $this->old_price;
    }

    /**
     * السعر الحالي مع التنسيق
     */
    public function getDisplayPriceAttribute()
    {
        return number_format($this->price, 2);
    }

    /**
     * السعر الأصلي مع التنسيق
     */
    public function getDisplayOldPriceAttribute()
    {
        return number_format($this->old_price, 2);
    }

    public function account_digetals()
    {
        return $this->hasMany(AccountDigetal::class);
    }

    /**
     * علاقة مع الكوبونات
     */
    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_products');
    }
} 