<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        
        // General Header Settings
        'header_enabled',
        'header_font',
        'header_sticky',
        'header_shadow',
        'header_scroll_effects',
        'header_smooth_transitions',
        'header_custom_css',
        'header_layout',
        'header_height',
        
        // Logo Settings
        'logo_enabled',
        'logo_image',
        'logo_svg',
        'logo_width',
        'logo_height',
        'logo_position',
        'logo_border_radius',
        'logo_shadow_enabled',
        'logo_shadow_class',
        'logo_shadow_color',
        'logo_shadow_opacity',
        
        // Navigation Settings
        'navigation_enabled',
        'main_menus_enabled',
        'main_menus_number',
        'show_home_link',
        'show_categories_in_menu',
        'categories_count',
        'menu_items',
        
        // Header Features
        'search_bar_enabled',
        'user_menu_enabled',
        'shopping_cart_enabled',
        'wishlist_enabled',
        'language_switcher_enabled',
        'currency_switcher_enabled',
        
        // Contact Information
        'header_contact_enabled',
        'header_phone',
        'header_email',
        'contact_position',
        
        // Mobile Settings
        'mobile_menu_enabled',
        'mobile_search_enabled',
        'mobile_cart_enabled',
        
        // Settings
        'settings_enabled',
    ];

    protected $casts = [
        'store_id' => 'integer',
        
        // General Header Settings
        'header_enabled' => 'boolean',
        'header_sticky' => 'boolean',
        'header_shadow' => 'boolean',
        'header_scroll_effects' => 'boolean',
        'header_smooth_transitions' => 'boolean',
        'header_height' => 'integer',
        
        // Logo Settings
        'logo_enabled' => 'boolean',
        'logo_width' => 'integer',
        'logo_height' => 'integer',
        'logo_shadow_enabled' => 'boolean',
        
        // Navigation Settings
        'navigation_enabled' => 'boolean',
        'main_menus_enabled' => 'boolean',
        'main_menus_number' => 'integer',
        'show_home_link' => 'boolean',
        'show_categories_in_menu' => 'boolean',
        'categories_count' => 'integer',
        'menu_items' => 'array',
        
        // Header Features
        'search_bar_enabled' => 'boolean',
        'user_menu_enabled' => 'boolean',
        'shopping_cart_enabled' => 'boolean',
        'wishlist_enabled' => 'boolean',
        'language_switcher_enabled' => 'boolean',
        'currency_switcher_enabled' => 'boolean',
        
        // Contact Information
        'header_contact_enabled' => 'boolean',
        
        // Mobile Settings
        'mobile_menu_enabled' => 'boolean',
        'mobile_search_enabled' => 'boolean',
        'mobile_cart_enabled' => 'boolean',
        
        // Settings
        'settings_enabled' => 'boolean',
    ];

    /**
     * Get the header settings instance for a specific store (singleton pattern per store)
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
     * Update or create header settings for a specific store
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
     * Get settings for current store (helper method)
     */
    public static function getCurrentStoreSettings()
    {
        // You can modify this to get the current store ID from session, auth user, etc.
        $currentStoreId = session('current_store_id') ?? auth()->user()->store_id ?? null;
        return static::getSettings($currentStoreId);
    }
}
