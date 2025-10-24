<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProductsPage extends Model
{
    use HasFactory;

    protected $table = 'products_page';

    protected $fillable = [
        // Page Header Settings
        'page_header_enabled',
        'page_title',
        'page_subtitle',
        'header_image',
        'store_id',
        // Discount Timer Settings
        'discount_timer_enabled',
        'discount_text',
        'discount_end_date',
        'timer_style',
        
        // Coupon Banner Settings
        'coupon_banner_enabled',
        'coupon_code',
        'coupon_text',
        'coupon_background_color',
        
        // Layout Settings
        'layout_style',
        'products_per_row',
        'sidebar_enabled',
        'sidebar_position',
        
        // Filter Settings
        'search_enabled',
        'search_placeholder',
        'price_filter_enabled',
        'category_filter_enabled',
        'brand_filter_enabled',
        'rating_filter_enabled',
        'sort_options_enabled',
        'default_sort',
        
        // Product Display Settings
        'product_card_style',
        'product_rating_enabled',
        'product_badges_enabled',
        'quick_view_enabled',
        'wishlist_enabled',
        'products_per_page',
        'pagination_style',
        
        // Color Scheme Settings
        'primary_color',
        'secondary_color',
        'accent_color',
        'background_color',
    ];

    protected $casts = [
        'page_header_enabled' => 'boolean',
        'discount_timer_enabled' => 'boolean',
        'discount_end_date' => 'datetime',
        'coupon_banner_enabled' => 'boolean',
        'sidebar_enabled' => 'boolean',
        'search_enabled' => 'boolean',
        'price_filter_enabled' => 'boolean',
        'category_filter_enabled' => 'boolean',
        'brand_filter_enabled' => 'boolean',
        'rating_filter_enabled' => 'boolean',
        'sort_options_enabled' => 'boolean',
        'product_rating_enabled' => 'boolean',
        'product_badges_enabled' => 'boolean',
        'quick_view_enabled' => 'boolean',
        'wishlist_enabled' => 'boolean',
        'products_per_row' => 'integer',
        'products_per_page' => 'integer',
        'store_id' => 'integer',
    ];

    /**
     * Get the store that owns this products page configuration
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get the default settings for a products page
     */
    public static function getDefaultSettings()
    {
        return [
            'page_header_enabled' => true,
            'page_title' => 'منتجاتنا',
            'page_subtitle' => 'اكتشف منتجات رائعة بأسعار مميزة',
            'header_image' => '',
            
            'discount_timer_enabled' => true,
            'discount_text' => 'عرض خاص - خصم حتى 50%!',
            'discount_end_date' => now()->addDays(7),
            'timer_style' => 'modern',
            
            'coupon_banner_enabled' => true,
            'coupon_code' => 'SAVE25',
            'coupon_text' => 'احصل على خصم 25% على جميع المنتجات',
            'coupon_background_color' => '#6366f1',
            
            'layout_style' => 'grid',
            'products_per_row' => 4,
            'sidebar_enabled' => true,
            'sidebar_position' => 'left',
            
            'search_enabled' => true,
            'search_placeholder' => 'البحث عن المنتجات...',
            'price_filter_enabled' => true,
            'category_filter_enabled' => true,
            'brand_filter_enabled' => true,
            'rating_filter_enabled' => true,
            'sort_options_enabled' => true,
            'default_sort' => 'latest',
            
            'product_card_style' => 'modern',
            'product_rating_enabled' => true,
            'product_badges_enabled' => true,
            'quick_view_enabled' => true,
            'wishlist_enabled' => true,
            'products_per_page' => 12,
            'pagination_style' => 'numbers',
            
            'primary_color' => '#00e5bb',
            'secondary_color' => '#1e293b',
            'accent_color' => '#f59e0b',
            'background_color' => '#0f172a',
        ];
    }

    /**
     * Create or get the settings record for a specific store
     */
    public static function getSettings($storeId = null)
    {
        // If no store ID provided, try to get it from the authenticated user
        if (!$storeId) {
            $user = Auth::user();
            if ($user && $user->store_id) {
                $storeId = $user->store_id;
            } else {
                // If still no store ID available, throw an exception
                throw new \Exception('Store ID is required to get products page settings');
            }
        }

        $settings = static::where('store_id', $storeId)->first();
        
        if (!$settings) {
            $defaultSettings = static::getDefaultSettings();
            $defaultSettings['store_id'] = $storeId;
            $settings = static::create($defaultSettings);
        }
        
        return $settings;
    }

    /**
     * Get a specific setting value for a store
     */
    public static function getSetting($key, $default = null, $storeId = null)
    {
        $settings = static::getSettings($storeId);
        return $settings->$key ?? $default;
    }

    /**
     * Check if a feature is enabled for a store
     */
    public static function isEnabled($feature, $storeId = null)
    {
        $settings = static::getSettings($storeId);
        
        $enabledFields = [
            'page_header' => 'page_header_enabled',
            'discount_timer' => 'discount_timer_enabled',
            'coupon_banner' => 'coupon_banner_enabled',
            'sidebar' => 'sidebar_enabled',
            'search' => 'search_enabled',
            'price_filter' => 'price_filter_enabled',
            'category_filter' => 'category_filter_enabled',
            'brand_filter' => 'brand_filter_enabled',
            'rating_filter' => 'rating_filter_enabled',
            'sort_options' => 'sort_options_enabled',
            'product_rating' => 'product_rating_enabled',
            'product_badges' => 'product_badges_enabled',
            'quick_view' => 'quick_view_enabled',
            'wishlist' => 'wishlist_enabled',
        ];

        $field = $enabledFields[$feature] ?? null;
        return $field ? $settings->$field : false;
    }

    /**
     * Get all colors as an array
     */
    public function getColorsAttribute()
    {
        return [
            'primary' => $this->primary_color,
            'secondary' => $this->secondary_color,
            'accent' => $this->accent_color,
            'background' => $this->background_color,
        ];
    }

    /**
     * Check if discount timer is active
     */
    public function isDiscountActive()
    {
        return $this->discount_timer_enabled && 
               $this->discount_end_date && 
               $this->discount_end_date->isFuture();
    }

    /**
     * Get time remaining for discount
     */
    public function getDiscountTimeRemaining()
    {
        if (!$this->isDiscountActive()) {
            return null;
        }

        return $this->discount_end_date->diff(now());
    }
} 