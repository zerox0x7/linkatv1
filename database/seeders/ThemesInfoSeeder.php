<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ThemesInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $themeData = [
            'name' => 'Torganic',
            'slug' => 'torganic',
            'description' => 'A modern, responsive e-commerce theme designed for organic and natural product stores. Features clean design, mobile-first approach, and optimized for conversions.',
            'price' => 89.99,
            'currency' => 'USD',
            'screenshot_image' => '/themes/torganic/screenshot.jpg',
            'version' => '2.1.0',
            'author' => 'ThemeForest',
            'features' => 'Responsive Design, Mobile-First, SEO Optimized, Fast Loading, WooCommerce Ready, Customizable Colors, Multiple Layouts, Blog Integration, Contact Forms, Social Media Integration',
            'category' => 'E-commerce',
            'tags' => json_encode(['ecommerce', 'responsive', 'organic', 'modern', 'woocommerce', 'mobile-first', 'seo', 'fast']),
            'status' => 'active',
            'is_featured' => true,
            'is_premium' => true,
            'downloads_count' => 15420,
            'views_count' => 89450,
            'rating' => 4.8,
            'reviews_count' => 324,
            'release_date' => '2024-03-15',
            'last_updated' => '2024-12-01',
            'requirements' => 'WordPress 5.0+, PHP 7.4+, WooCommerce 5.0+, MySQL 5.6+',
            'installation_notes' => '1. Upload theme files via WordPress admin. 2. Activate the theme. 3. Install required plugins. 4. Import demo content. 5. Customize settings.',
            'links' => json_encode([
                'demo' => 'https://demo.torganic.com',
                'documentation' => 'https://docs.torganic.com',
                'support' => 'https://support.torganic.com',
                'changelog' => 'https://torganic.com/changelog',
                'download' => 'https://themeforest.net/item/torganic/12345678'
            ]),
            'images' => json_encode([
                [
                    'order' => 1,
                    'path' => '/themes/torganic/images/homepage-desktop.jpg',
                    'size' => '1920x1080',
                    'alt' => 'Torganic Homepage Desktop View',
                    'description' => 'Main homepage layout on desktop',
                    'type' => 'desktop'
                ],
                [
                    'order' => 2,
                    'path' => '/themes/torganic/images/homepage-mobile.jpg',
                    'size' => '375x812',
                    'alt' => 'Torganic Homepage Mobile View',
                    'description' => 'Responsive mobile homepage design',
                    'type' => 'mobile'
                ],
                [
                    'order' => 3,
                    'path' => '/themes/torganic/images/product-page.jpg',
                    'size' => '1440x900',
                    'alt' => 'Product Page Layout',
                    'description' => 'Product detail page with gallery',
                    'type' => 'product'
                ],
                [
                    'order' => 4,
                    'path' => '/themes/torganic/images/shop-grid.jpg',
                    'size' => '1200x800',
                    'alt' => 'Shop Grid Layout',
                    'description' => 'Product grid layout with filters',
                    'type' => 'shop'
                ],
                [
                    'order' => 5,
                    'path' => '/themes/torganic/images/blog-layout.jpg',
                    'size' => '1280x720',
                    'alt' => 'Blog Layout',
                    'description' => 'Blog listing and single post layout',
                    'type' => 'blog'
                ],
                [
                    'order' => 6,
                    'path' => '/themes/torganic/images/cart-checkout.jpg',
                    'size' => '1366x768',
                    'alt' => 'Cart and Checkout',
                    'description' => 'Shopping cart and checkout process',
                    'type' => 'checkout'
                ],
                [
                    'order' => 7,
                    'path' => '/themes/torganic/images/about-page.jpg',
                    'size' => '1600x1000',
                    'alt' => 'About Page',
                    'description' => 'About us page with team section',
                    'type' => 'about'
                ],
                [
                    'order' => 8,
                    'path' => '/themes/torganic/images/contact-page.jpg',
                    'size' => '1200x900',
                    'alt' => 'Contact Page',
                    'description' => 'Contact page with form and map',
                    'type' => 'contact'
                ],
                [
                    'order' => 9,
                    'path' => '/themes/torganic/images/customizer-panel.jpg',
                    'size' => '1920x1200',
                    'alt' => 'Theme Customizer',
                    'description' => 'WordPress customizer panel',
                    'type' => 'customizer'
                ],
                [
                    'order' => 10,
                    'path' => '/themes/torganic/images/admin-dashboard.jpg',
                    'size' => '1440x900',
                    'alt' => 'Admin Dashboard',
                    'description' => 'Theme options and settings panel',
                    'type' => 'admin'
                ]
            ]),
            'custom_data' => json_encode([
                'color_schemes' => ['green', 'blue', 'purple', 'orange'],
                'layout_options' => ['boxed', 'full-width', 'left-sidebar', 'right-sidebar'],
                'header_styles' => ['default', 'centered', 'minimal', 'sticky'],
                'footer_styles' => ['default', 'minimal', 'extended', 'widget-heavy'],
                'supported_plugins' => ['woocommerce', 'elementor', 'contact-form-7', 'yoast-seo']
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('themes_info')->insert($themeData);
    }
}
