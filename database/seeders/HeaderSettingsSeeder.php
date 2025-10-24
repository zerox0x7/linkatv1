<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HeaderSettings;

class HeaderSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HeaderSettings::create([
            // Store settings (null = global/default store)
            'store_id' => null,
            
            // General Header Settings
            'header_enabled' => true,
            'header_font' => 'Tajawal',
            'header_sticky' => true,
            'header_shadow' => true,
            'header_scroll_effects' => true,
            'header_smooth_transitions' => true,
            'header_custom_css' => null,
            'header_layout' => 'default',
            'header_height' => 80,
            
            // Logo Settings
            'logo_enabled' => true,
            'logo_image' => null,
            'logo_svg' => null,
            'logo_width' => 150,
            'logo_height' => 50,
            'logo_position' => 'left',
            'logo_border_radius' => 'rounded-lg',
            'logo_shadow_enabled' => false,
            'logo_shadow_class' => null,
            'logo_shadow_color' => 'gray-500',
            'logo_shadow_opacity' => '50',
            
            // Navigation Settings
            'navigation_enabled' => true,
            'main_menus_enabled' => true,
            'main_menus_number' => 5,
            'show_home_link' => true,
            'show_categories_in_menu' => true,
            'menu_items' => null,
            
            // Header Features
            'search_bar_enabled' => true,
            'user_menu_enabled' => true,
            'shopping_cart_enabled' => false,
            'wishlist_enabled' => false,
            'language_switcher_enabled' => false,
            'currency_switcher_enabled' => false,
            
            // Contact Information
            'header_contact_enabled' => false,
            'header_phone' => null,
            'header_email' => null,
            'contact_position' => 'top',
            
            // Mobile Settings
            'mobile_menu_enabled' => true,
            'mobile_search_enabled' => true,
            'mobile_cart_enabled' => true,
        ]);
    }
} 