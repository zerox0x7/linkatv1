<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Theme\ThemeSettingsController;
use App\Http\Controllers\Theme\ThemeColorController;
use App\Http\Controllers\Theme\ThemeSectionController;
use App\Http\Controllers\Theme\ThemeProductController;
use App\Http\Controllers\Theme\ThemeMediaController;

class GameyThemeController extends Controller
{
    public function index()
    {
        $storeId = 15;
        
        // Get theme configuration
        $themeConfig = $this->getThemeConfiguration($storeId);
        
        // Get sample data
        $products = $this->getSampleProducts();
        $categories = $this->getSampleCategories();
        
        return view('themes.gamey.pages.home', compact('themeConfig', 'products', 'categories'));
    }
    
    private function getThemeConfiguration($storeId)
    {
        // Create a sample theme configuration
        return [
            'settings' => [
                'theme_name' => 'gamey',
                'theme_version' => '1.0',
                'layout_style' => 'gaming',
                'site_width' => 'full',
                'rtl_support' => false,
                'logos' => [
                    'favicon' => null,
                    'logo' => null,
                    'logo_dark' => null,
                    'mobile_logo' => null,
                ],
                'customizations' => [
                    'custom_css' => [],
                    'custom_js' => [],
                ],
                'fonts' => [
                    'google_fonts' => [
                        'Orbitron:wght@400;700;900',
                        'Inter:wght@300;400;500;600;700'
                    ],
                ],
                'features' => [
                    'enable_animations' => true,
                    'enable_dark_mode' => true,
                    'enable_loading_screen' => false,
                    'loading_animation' => 'spinner',
                    'enable_back_to_top' => true,
                ],
                'integrations' => [
                    'social_links' => [
                        'discord' => 'https://discord.gg/gameystore',
                        'telegram' => 'https://t.me/gameystore',
                        'instagram' => 'https://instagram.com/gameystore',
                        'youtube' => 'https://youtube.com/gameystore'
                    ],
                    'analytics_codes' => [],
                ],
                'is_active' => true,
            ],
            'colors' => [
                'scheme_name' => 'gaming_dark',
                'primary_color' => '#00BFFF',
                'secondary_color' => '#39FF14',
                'accent_color' => '#BF00FF',
                'background_color' => '#0a0a0a',
                'surface_color' => '#1a1a1a',
                'text_primary' => '#ffffff',
                'text_secondary' => '#b3b3b3',
                'text_muted' => '#666666',
                'neon_colors' => [
                    'blue' => '#00BFFF',
                    'green' => '#39FF14',
                    'purple' => '#BF00FF',
                    'orange' => '#FF6600'
                ]
            ],
            'sections' => $this->getSampleSections(),
            'products' => [
                'layout' => 'grid',
                'columns_desktop' => 4,
                'columns_tablet' => 2,
                'columns_mobile' => 1,
                'card_style' => 'gaming',
                'hover_effect' => 'lift_glow'
            ]
        ];
    }
    
    private function getSampleSections()
    {
        return [
            [
                'section_key' => 'header',
                'section_name' => 'Header',
                'section_type' => 'header',
                'is_active' => true,
                'sort_order' => 10
            ],
            [
                'section_key' => 'hero',
                'section_name' => 'Hero Section',
                'section_type' => 'hero',
                'is_active' => true,
                'sort_order' => 20
            ],
            [
                'section_key' => 'categories',
                'section_name' => 'Game Categories',
                'section_type' => 'categories',
                'is_active' => true,
                'sort_order' => 30
            ],
            [
                'section_key' => 'featured_products',
                'section_name' => 'Featured Products',
                'section_type' => 'products',
                'is_active' => true,
                'sort_order' => 40
            ],
            [
                'section_key' => 'footer',
                'section_name' => 'Footer',
                'section_type' => 'footer',
                'is_active' => true,
                'sort_order' => 100
            ]
        ];
    }
    
    private function getSampleProducts()
    {
        return [
            (object) [
                'id' => 1,
                'name' => 'PUBG Mobile Premium Account',
                'description' => 'High-level PUBG Mobile account with rare skins and items',
                'price' => 99.99,
                'old_price' => 149.99,
                'image' => '/themes/gamey/images/placeholder-product.jpg',
                'category' => (object) ['name' => 'Gaming Accounts'],
                'platform' => 'PUBG Mobile',
                'level' => 85,
                'region' => 'Global',
                'verified' => true,
                'rating' => 5,
                'reviews_count' => 127,
                'stock' => 3,
                'is_featured' => true,
                'discount_percentage' => 33,
                'is_new' => false
            ],
            (object) [
                'id' => 2,
                'name' => '8100 UC + Bonus',
                'description' => 'PUBG Mobile UC currency with bonus items',
                'price' => 59.99,
                'old_price' => 79.99,
                'image' => '/themes/gamey/images/placeholder-product.jpg',
                'category' => (object) ['name' => 'Game Currency'],
                'platform' => 'PUBG Mobile',
                'rating' => 5,
                'reviews_count' => 89,
                'stock' => 50,
                'is_featured' => true,
                'discount_percentage' => 25,
                'is_new' => false
            ],
            (object) [
                'id' => 3,
                'name' => 'Rank Boost to Conqueror',
                'description' => 'Professional rank boosting service to Conqueror tier',
                'price' => 199.99,
                'old_price' => null,
                'image' => '/themes/gamey/images/placeholder-product.jpg',
                'category' => (object) ['name' => 'Boosting Services'],
                'platform' => 'PUBG Mobile',
                'rating' => 5,
                'reviews_count' => 234,
                'stock' => 10,
                'is_featured' => true,
                'discount_percentage' => 0,
                'is_new' => true
            ],
            (object) [
                'id' => 4,
                'name' => 'Mythic Outfit Set',
                'description' => 'Rare mythic outfit collection for gaming accounts',
                'price' => 299.99,
                'old_price' => null,
                'image' => '/themes/gamey/images/placeholder-product.jpg',
                'category' => (object) ['name' => 'Premium Items'],
                'platform' => 'Multiple',
                'rating' => 4.5,
                'reviews_count' => 56,
                'stock' => 5,
                'is_featured' => true,
                'discount_percentage' => 0,
                'is_new' => false
            ]
        ];
    }
    
    private function getSampleCategories()
    {
        return [
            (object) [
                'id' => 1,
                'name' => 'Gaming Accounts',
                'description' => 'Premium gaming accounts with high levels and rare items',
                'products_count' => 50,
                'image' => '/themes/gamey/images/category-gaming-accounts.jpg'
            ],
            (object) [
                'id' => 2,
                'name' => 'Game Currency',
                'description' => 'In-game currency for various games',
                'products_count' => 100,
                'image' => '/themes/gamey/images/category-currency.jpg'
            ],
            (object) [
                'id' => 3,
                'name' => 'Boosting Services',
                'description' => 'Professional rank boosting and leveling services',
                'products_count' => 25,
                'image' => '/themes/gamey/images/category-boosting.jpg'
            ],
            (object) [
                'id' => 4,
                'name' => 'Premium Items',
                'description' => 'Rare and mythic items for gaming accounts',
                'products_count' => 75,
                'image' => '/themes/gamey/images/category-items.jpg'
            ]
        ];
    }
} 