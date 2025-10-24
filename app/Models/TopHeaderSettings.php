<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopHeaderSettings extends Model
{
    use HasFactory;

    protected $table = 'top_header_settings';

    protected $fillable = [
        'store_id',
        'top_header_enabled',
        'top_header_position',
        'top_header_height',
        'top_header_sticky',
        'background_color',
        'text_color',
        'border_color',
        'opacity',
        'contact_enabled',
        'phone',
        'email',
        'address',
        'quick_links_enabled',
        'quick_links',
        'social_media_enabled',
        'social_media',
        'language_switcher_enabled',
        'currency_switcher_enabled',
        'announcement_enabled',
        'announcement_text',
        'announcement_link',
        'announcement_bg_color',
        'announcement_text_color',
        'announcement_scrolling',
        'auth_links_enabled',
        'show_login_link',
        'show_register_link',
        'login_text',
        'register_text',
        'working_hours_enabled',
        'working_hours',
        'movement_type',
        'movement_direction',
        'animation_speed',
        'pause_on_hover',
        'infinite_loop',
        'header_text',
        'header_link',
        'font_size',
        'font_weight',
        'background_gradient',
        'enable_shadow',
        'enable_opacity',
        'show_contact_info',
        'contact_phone',
        'contact_email',
        'show_social_icons',
        'show_close_button',
        'show_countdown',
        'text_only',
        'countdown_date',
    ];

    protected $casts = [
        'top_header_enabled' => 'boolean',
        'top_header_height' => 'integer',
        'top_header_sticky' => 'boolean',
        'opacity' => 'integer',
        'contact_enabled' => 'boolean',
        'quick_links_enabled' => 'boolean',
        'quick_links' => 'array',
        'social_media_enabled' => 'boolean',
        'social_media' => 'array',
        'language_switcher_enabled' => 'boolean',
        'currency_switcher_enabled' => 'boolean',
        'announcement_enabled' => 'boolean',
        'announcement_scrolling' => 'boolean',
        'auth_links_enabled' => 'boolean',
        'show_login_link' => 'boolean',
        'show_register_link' => 'boolean',
        'working_hours_enabled' => 'boolean',
        'animation_speed' => 'integer',
        'pause_on_hover' => 'boolean',
        'infinite_loop' => 'boolean',
        'enable_shadow' => 'boolean',
        'enable_opacity' => 'boolean',
        'show_contact_info' => 'boolean',
        'show_social_icons' => 'boolean',
        'show_close_button' => 'boolean',
        'show_countdown' => 'boolean',
        'text_only' => 'boolean',
        'countdown_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'top_header_enabled' => true,
        'top_header_position' => 'top',
        'top_header_height' => 40,
        'top_header_sticky' => false,
        'background_color' => '#1e293b',
        'text_color' => '#d1d5db',
        'border_color' => '#374151',
        'opacity' => 100,
        'contact_enabled' => true,
        'quick_links_enabled' => true,
        'social_media_enabled' => true,
        'language_switcher_enabled' => false,
        'currency_switcher_enabled' => false,
        'announcement_enabled' => false,
        'announcement_bg_color' => '#6366f1',
        'announcement_text_color' => '#ffffff',
        'announcement_scrolling' => false,
        'auth_links_enabled' => true,
        'show_login_link' => true,
        'show_register_link' => true,
        'login_text' => 'تسجيل الدخول',
        'register_text' => 'إنشاء حساب',
        'working_hours_enabled' => false,
        'movement_type' => 'scroll',
        'movement_direction' => 'rtl',
        'animation_speed' => 20,
        'pause_on_hover' => false,
        'infinite_loop' => true,
        'font_size' => '14px',
        'font_weight' => '400',
        'background_gradient' => 'none',
        'enable_shadow' => false,
        'enable_opacity' => false,
        'show_contact_info' => false,
        'show_social_icons' => false,
        'show_close_button' => false,
        'show_countdown' => false,
        'text_only' => false,
    ];

    /**
     * Get the top header settings instance for a specific store (singleton pattern per store)
     */
    public static function getSettings($storeId = null)
    {
        $query = static::query();
        
        if ($storeId !== null) {
            $query->where('store_id', $storeId);
        } else {
            $query->whereNull('store_id');
        }
        
        return $query->first() ?? static::create(['store_id' => $storeId]);
    }

    /**
     * Update or create top header settings for a specific store
     */
    public static function updateSettings(array $data, $storeId = null)
    {
        $query = static::query();
        
        if ($storeId !== null) {
            $query->where('store_id', $storeId);
        } else {
            $query->whereNull('store_id');
        }
        
        $settings = $query->first();
        
        // Ensure store_id is set in the data
        $data['store_id'] = $storeId;
        
        if ($settings) {
            $settings->update($data);
        } else {
            $settings = static::create($data);
        }
        
        return $settings;
    }

    /**
     * Get the settings for a specific store
     */
    public static function getForStore($storeId = null)
    {
        return static::where('store_id', $storeId)->first() ?? new static(['store_id' => $storeId]);
    }

    /**
     * Scope to filter by store
     */
    public function scopeForStore($query, $storeId)
    {
        return $query->where('store_id', $storeId);
    }

    /**
     * Get settings for current store (helper method)
     */
    public static function getCurrentStoreSettings()
    {
        // You can modify this to get the current store ID from session, auth user, etc.
        $currentStoreId = session('current_store_id') ?? auth()->user()->store_id ?? null;
        return static::getSettings($currentStoreId);
    }
}
