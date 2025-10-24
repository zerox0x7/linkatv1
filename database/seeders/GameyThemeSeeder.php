<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GameyThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $storeId = 15;
        $now = Carbon::now();

        // Insert theme settings for gamey theme
        DB::table('zain_theme_settings')->insert([
            'store_id' => $storeId,
            'theme_name' => 'gamey',
            'theme_version' => '1.0',
            'layout_style' => 'gaming',
            'site_width' => 'full',
            'rtl_support' => true,
            'favicon' => null,
            'logo' => null,
            'logo_dark' => null,
            'mobile_logo' => null,
            'custom_css' => json_encode([]),
            'custom_js' => json_encode([]),
            'google_fonts' => json_encode([
                'Orbitron:wght@400;700;900',
                'Inter:wght@300;400;500;600;700'
            ]),
            'enable_animations' => true,
            'enable_dark_mode' => true,
            'enable_loading_screen' => true,
            'loading_animation' => 'spinner',
            'enable_back_to_top' => true,
            'social_links' => json_encode([
                'discord' => 'https://discord.gg/gameystore',
                'telegram' => 'https://t.me/gameystore',
                'instagram' => 'https://instagram.com/gameystore',
                'youtube' => 'https://youtube.com/gameystore'
            ]),
            'analytics_codes' => json_encode([]),
            'is_active' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Insert color scheme for gamey theme
        DB::table('zain_theme_colors')->insert([
            'store_id' => $storeId,
            'scheme_name' => 'gaming_dark',
            'primary_color' => '#00BFFF',
            'secondary_color' => '#39FF14',
            'accent_color' => '#BF00FF',
            'background_color' => '#0a0a0a',
            'surface_color' => '#1a1a1a',
            'text_primary' => '#ffffff',
            'text_secondary' => '#b3b3b3',
            'text_muted' => '#666666',
            'border_color' => '#333333',
            'hover_color' => '#2c2c2c',
            'success_color' => '#39FF14',
            'warning_color' => '#FF6600',
            'error_color' => '#FF0000',
            'info_color' => '#00BFFF',
            'button_primary' => '#00BFFF',
            'button_secondary' => '#6c757d',
            'button_text' => '#ffffff',
            'link_color' => '#00BFFF',
            'link_hover' => '#0099CC',
            'header_bg' => '#1a1a1a',
            'header_text' => '#ffffff',
            'footer_bg' => '#0a0a0a',
            'footer_text' => '#b3b3b3',
            'sidebar_bg' => '#1a1a1a',
            'sidebar_text' => '#ffffff',
            'gradient_colors' => json_encode([
                'primary_gradient' => ['#00BFFF', '#BF00FF'],
                'secondary_gradient' => ['#39FF14', '#00BFFF'],
                'accent_gradient' => ['#BF00FF', '#FF6600']
            ]),
            'custom_properties' => json_encode([
                'neon_blue' => '#00BFFF',
                'neon_green' => '#39FF14',
                'neon_purple' => '#BF00FF',
                'neon_orange' => '#FF6600',
                'dark_bg' => '#0a0a0a',
                'dark_surface' => '#1a1a1a',
                'dark_card' => '#242424'
            ]),
            'is_default' => true,
            'is_active' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Insert theme sections for gamey theme
        $sections = [
            [
                'store_id' => $storeId,
                'section_key' => 'header',
                'section_name' => 'Header',
                'section_type' => 'header',
                'description' => 'Main navigation and branding',
                'sort_order' => 10,
                'is_active' => true,
                'is_required' => true,
                'template_file' => 'themes.gamey.partials.header',
                'container_type' => 'full-width',
                'settings' => json_encode([
                    'sticky' => true,
                    'transparent' => false,
                    'search_enabled' => true
                ]),
                'style_settings' => json_encode([
                    'background' => '#1a1a1a',
                    'text_color' => '#ffffff',
                    'height' => 'auto'
                ]),
                'content_settings' => json_encode([
                    'logo_position' => 'left',
                    'menu_position' => 'center',
                    'actions_position' => 'right'
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'store_id' => $storeId,
                'section_key' => 'hero',
                'section_name' => 'Hero Section',
                'section_type' => 'hero',
                'description' => 'Main hero banner with call-to-action',
                'sort_order' => 20,
                'is_active' => true,
                'is_required' => false,
                'template_file' => 'themes.gamey.sections.hero',
                'container_type' => 'full-width',
                'settings' => json_encode([
                    'full_height' => false,
                    'parallax' => true,
                    'video_background' => false
                ]),
                'style_settings' => json_encode([
                    'background_type' => 'gradient',
                    'background_gradient' => ['#0a0a0a', '#1a1a1a'],
                    'text_alignment' => 'center',
                    'padding' => '5rem 0'
                ]),
                'content_settings' => json_encode([
                    'title' => 'GAME ON!',
                    'subtitle' => 'Level up your gaming experience with premium accounts, rare items, and instant currency',
                    'primary_button_text' => 'Shop Now',
                    'secondary_button_text' => 'Featured Items'
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'store_id' => $storeId,
                'section_key' => 'categories',
                'section_name' => 'Game Categories',
                'section_type' => 'categories',
                'description' => 'Product categories showcase',
                'sort_order' => 30,
                'is_active' => true,
                'is_required' => false,
                'template_file' => 'themes.gamey.sections.categories',
                'container_type' => 'container',
                'settings' => json_encode([
                    'columns_desktop' => 4,
                    'columns_tablet' => 2,
                    'columns_mobile' => 1,
                    'show_count' => true
                ]),
                'style_settings' => json_encode([
                    'card_style' => 'gaming',
                    'hover_effect' => 'glow',
                    'border_radius' => '12px'
                ]),
                'content_settings' => json_encode([
                    'title' => 'Game Categories',
                    'subtitle' => 'Choose your battleground'
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'store_id' => $storeId,
                'section_key' => 'featured_products',
                'section_name' => 'Featured Products',
                'section_type' => 'products',
                'description' => 'Featured gaming products',
                'sort_order' => 40,
                'is_active' => true,
                'is_required' => false,
                'template_file' => 'themes.gamey.sections.featured-products',
                'container_type' => 'container',
                'settings' => json_encode([
                    'products_count' => 8,
                    'columns_desktop' => 4,
                    'columns_tablet' => 2,
                    'columns_mobile' => 1,
                    'show_badges' => true
                ]),
                'style_settings' => json_encode([
                    'card_style' => 'gaming',
                    'hover_effect' => 'lift_glow',
                    'spacing' => 'normal'
                ]),
                'content_settings' => json_encode([
                    'title' => 'Featured Products',
                    'subtitle' => 'Top picks for serious gamers',
                    'show_view_all' => true
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'store_id' => $storeId,
                'section_key' => 'footer',
                'section_name' => 'Footer',
                'section_type' => 'footer',
                'description' => 'Site footer with links and information',
                'sort_order' => 100,
                'is_active' => true,
                'is_required' => true,
                'template_file' => 'themes.gamey.partials.footer',
                'container_type' => 'full-width',
                'settings' => json_encode([
                    'columns' => 4,
                    'newsletter' => true,
                    'social_links' => true
                ]),
                'style_settings' => json_encode([
                    'background' => '#1a1a1a',
                    'text_color' => '#b3b3b3',
                    'border_top' => true
                ]),
                'content_settings' => json_encode([
                    'copyright' => 'Gamey Store. All rights reserved.',
                    'description' => 'Your ultimate destination for premium gaming accounts, in-game currency, and digital goods.'
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('zain_theme_sections')->insert($sections);

        // Insert product display settings for gamey theme
        DB::table('zain_theme_products')->insert([
            'store_id' => $storeId,
            'products_layout' => 'grid',
            'products_per_row_desktop' => 4,
            'products_per_row_tablet' => 2,
            'products_per_row_mobile' => 1,
            'products_per_page' => 16,
            'products_spacing' => 'normal',
            'card_style' => 'gaming',
            'card_hover_effect' => 'lift',
            'show_product_badges' => true,
            'show_wishlist_button' => true,
            'show_quick_view' => true,
            'show_compare_button' => false,
            'show_product_title' => true,
            'show_product_price' => true,
            'show_old_price' => true,
            'show_product_rating' => true,
            'show_product_reviews_count' => true,
            'show_product_category' => true,
            'show_product_description' => false,
            'show_product_attributes' => true,
            'show_game_platform' => true,
            'show_game_genre' => true,
            'show_account_level' => true,
            'show_account_region' => true,
            'show_follower_count' => true,
            'show_verification_badge' => true,
            'show_account_age' => true,
            'show_engagement_rate' => false,
            'pagination_style' => 'numbers',
            'show_page_info' => true,
            'enable_mobile_filters' => true,
            'mobile_filter_style' => 'bottom_sheet',
            'mobile_sticky_cart' => false,
            'enable_caching' => true,
            'cache_duration' => 3600,
            'enable_infinite_scroll' => false,
            'custom_settings' => json_encode([
                'gaming_features' => [
                    'platform_icons' => true,
                    'rank_badges' => true,
                    'rarity_colors' => true
                ],
                'animations' => [
                    'hover_glow' => true,
                    'loading_shimmer' => true,
                    'add_to_cart_feedback' => true
                ]
            ]),
            'is_active' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Insert theme media assets
        $mediaAssets = [
            [
                'store_id' => $storeId,
                'media_key' => 'hero_bg',
                'media_type' => 'image',
                'media_category' => 'background',
                'file_name' => 'gaming_hero_bg.jpg',
                'file_path' => '/themes/gamey/images/gaming_hero_bg.jpg',
                'file_url' => '/themes/gamey/images/gaming_hero_bg.jpg',
                'mime_type' => 'image/jpeg',
                'file_size' => 245760,
                'width' => 1920,
                'height' => 1080,
                'alt_text' => 'Gaming Hero Background',
                'description' => 'Dark gaming themed hero background',
                'responsive_urls' => json_encode([
                    'sm' => '/themes/gamey/images/gaming_hero_bg_sm.jpg',
                    'md' => '/themes/gamey/images/gaming_hero_bg_md.jpg',
                    'lg' => '/themes/gamey/images/gaming_hero_bg_lg.jpg'
                ]),
                'metadata' => json_encode([
                    'color_palette' => ['#0a0a0a', '#1a1a1a', '#00BFFF', '#BF00FF'],
                    'theme' => 'dark',
                    'style' => 'gaming'
                ]),
                'is_optimized' => true,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'store_id' => $storeId,
                'media_key' => 'logo_main',
                'media_type' => 'image',
                'media_category' => 'logo',
                'file_name' => 'gamey_logo.png',
                'file_path' => '/themes/gamey/images/gamey_logo.png',
                'file_url' => '/themes/gamey/images/gamey_logo.png',
                'mime_type' => 'image/png',
                'file_size' => 15360,
                'width' => 200,
                'height' => 60,
                'alt_text' => 'Gamey Store Logo',
                'description' => 'Main Gamey store logo with gaming aesthetic',
                'responsive_urls' => json_encode([
                    'sm' => '/themes/gamey/images/gamey_logo_sm.png',
                    'md' => '/themes/gamey/images/gamey_logo_md.png'
                ]),
                'metadata' => json_encode([
                    'has_text' => true,
                    'transparent_bg' => true,
                    'color_scheme' => 'neon'
                ]),
                'is_optimized' => true,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('zain_theme_media')->insert($mediaAssets);

        // Insert some sample products for store_id 15
        $this->insertSampleProducts($storeId, $now);

        // Insert sample categories for store_id 15
        $this->insertSampleCategories($storeId, $now);
    }

    private function insertSampleProducts($storeId, $now)
    {
        $products = [
            [
                'name' => 'PUBG Mobile Premium Account',
                'description' => 'High-level PUBG Mobile account with rare skins and items',
                'price' => 99.99,
                'old_price' => 149.99,
                'category_id' => 1,
                'user_id' => $storeId,
                'store_id' => $storeId,
                'stock' => 3,
                'is_featured' => true,
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => '8100 UC + Bonus',
                'description' => 'PUBG Mobile UC currency with bonus items',
                'price' => 59.99,
                'old_price' => 79.99,
                'category_id' => 2,
                'user_id' => $storeId,
                'store_id' => $storeId,
                'stock' => 50,
                'is_featured' => true,
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Rank Boost to Conqueror',
                'description' => 'Professional rank boosting service to Conqueror tier',
                'price' => 199.99,
                'category_id' => 3,
                'user_id' => $storeId,
                'store_id' => $storeId,
                'stock' => 10,
                'is_featured' => true,
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Mythic Outfit Set',
                'description' => 'Rare mythic outfit collection for gaming accounts',
                'price' => 299.99,
                'category_id' => 4,
                'user_id' => $storeId,
                'store_id' => $storeId,
                'stock' => 5,
                'is_featured' => true,
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($products as $product) {
            if (DB::table('products')->where('name', $product['name'])->where('store_id', $storeId)->doesntExist()) {
                DB::table('products')->insert($product);
            }
        }
    }

    private function insertSampleCategories($storeId, $now)
    {
        $categories = [
            [
                'name' => 'Gaming Accounts',
                'description' => 'Premium gaming accounts with high levels and rare items',
                'user_id' => $storeId,
                'store_id' => $storeId,
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Game Currency',
                'description' => 'In-game currency for various games',
                'user_id' => $storeId,
                'store_id' => $storeId,
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Boosting Services',
                'description' => 'Professional rank boosting and leveling services',
                'user_id' => $storeId,
                'store_id' => $storeId,
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Premium Items',
                'description' => 'Rare and mythic items for gaming accounts',
                'user_id' => $storeId,
                'store_id' => $storeId,
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($categories as $category) {
            if (DB::table('categories')->where('name', $category['name'])->where('store_id', $storeId)->doesntExist()) {
                DB::table('categories')->insert($category);
            }
        }
    }
} 