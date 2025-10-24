<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePage extends Model
{
    use HasFactory;

    protected $table = 'home_page';

    protected $fillable = [
        'store_id',
        'store_name',
        'store_description',
        'store_logo',
        
        // Hero Section
        'hero_enabled',
        'hero_title',
        'hero_subtitle',
        'hero_button1_text',
        'hero_button1_link',
        'hero_button2_text',
        'hero_button2_link',
        'hero_background_image',
        
        // Categories Section
        'categories_enabled',
        'categories_title',
        'categories_data',
        
        // Featured Products Section
        'featured_enabled',
        'featured_title',
        'featured_count',
        'featured_products',
        
        // Brand Section
        'brand_enabled',
        'brand_title',
        'brand_count',
        'brand_products',
        
        // Services Section
        'services_enabled',
        'services_title',
        'services_data',
        
        // Reviews Section
        'reviews_enabled',
        'reviews_title',
        'reviews_count',
        'reviews_data',
        
        // Location Section
        'location_enabled',
        'location_title',
        'location_address',
        'location_phone',
        'location_email',
        'location_hours',
        'location_map_image',
        
        // Footer Section
        'footer_enabled',
        'footer_description',
        'footer_quick_links',
        'footer_payment_methods',
        'footer_social_media',
        'footer_copyright',
        'footer_background_color',
        'footer_text_color', 
        'footer_phone',
        'footer_email',
        'footer_address',
        'footer_social_media_enabled',
        'footer_payment_methods_enabled',
        'footer_categories_enabled',
        
        // Theme Colors
        'primary_color',
        'background_color',
        'text_color',
        'secondary_text_color',
    ];

    protected $casts = [
        'hero_enabled' => 'boolean',
        'categories_enabled' => 'boolean',
        'categories_data' => 'array',
        'featured_enabled' => 'boolean',
        'featured_count' => 'integer',
        'featured_products' => 'array',
        'brand_enabled' => 'boolean',
        'brand_count' => 'integer',
        'brand_products' => 'array',
        'services_enabled' => 'boolean',
        'services_data' => 'array',
        'reviews_enabled' => 'boolean',
        'reviews_count' => 'integer',
        'reviews_data' => 'array',
        'location_enabled' => 'boolean',
        'footer_enabled' => 'boolean',
        'footer_quick_links' => 'array',
        'footer_payment_methods' => 'array',
        'footer_social_media' => 'array',
        'footer_social_media_enabled' => 'boolean',
        'footer_payment_methods_enabled' => 'boolean',
        'footer_categories_enabled' => 'boolean',
    ];

    /**
     * Get the default home page settings
     */
    public static function getDefault($storeId = null)
    {
        if ($storeId) {
            try {
                $homePage = self::where('store_id', $storeId)->first();
                if ($homePage) {
                    return $homePage;
                }
            } catch (\Exception $e) {
                // store_id column doesn't exist, get first record
                $homePage = self::first();
                if ($homePage) {
                    return $homePage;
                }
            }
        }

        // Create default data if no record exists
        $defaultData = [
            'store_name' => 'متجر إلكتروني',
            'store_description' => 'متجرك الإلكتروني المتخصص في بيع أحدث المنتجات التقنية والإلكترونية',
            'store_logo' => null,
            
            // Hero Section
            'hero_enabled' => true,
            'hero_title' => 'اكتشف أحدث المنتجات التقنية',
            'hero_subtitle' => 'تسوق من مجموعة واسعة من الهواتف الذكية والأجهزة الإلكترونية بأفضل الأسعار',
            'hero_button1_text' => 'تسوق الآن',
            'hero_button1_link' => '/products',
            'hero_button2_text' => 'تصفح الفئات',
            'hero_button2_link' => '/categories',
            'hero_background_image' => null,
            
            // Categories Section
            'categories_enabled' => true,
            'categories_title' => 'تصفح حسب الفئة',
            'categories_data' => [
                [
                    'id' => null,
                    'name' => 'الهواتف الذكية',
                    'icon' => 'ri-smartphone-line',
                    'count' => 0
                ],
                [
                    'id' => null,
                    'name' => 'أجهزة الكمبيوتر',
                    'icon' => 'ri-computer-line',
                    'count' => 0
                ],
                [
                    'id' => null,
                    'name' => 'الساعات الذكية',
                    'icon' => 'ri-watch-line',
                    'count' => 0
                ],
                [
                    'id' => null,
                    'name' => 'السماعات',
                    'icon' => 'ri-headphone-line',
                    'count' => 0
                ]
            ],
            
            // Featured Products Section
            'featured_enabled' => true,
            'featured_title' => 'المنتجات المميزة',
            'featured_count' => 4,
            'featured_products' => [],
            
            // Brand Section
            'brand_enabled' => true,
            'brand_title' => 'المنتجات المميزة',
            'brand_count' => 4,
            'brand_products' => [],
            
            // Services Section
            'services_enabled' => true,
            'services_title' => 'خدماتنا',
            'services_data' => [
                [
                    'title' => 'شحن سريع',
                    'description' => 'توصيل سريع خلال 24 ساعة',
                    'icon' => 'ri-truck-line'
                ],
                [
                    'title' => 'ضمان شامل',
                    'description' => 'ضمان على جميع المنتجات',
                    'icon' => 'ri-shield-check-line'
                ],
                [
                    'title' => 'دعم فني',
                    'description' => 'دعم فني متاح 24/7',
                    'icon' => 'ri-customer-service-line'
                ],
                [
                    'title' => 'دفع آمن',
                    'description' => 'طرق دفع متعددة وآمنة',
                    'icon' => 'ri-money-dollar-circle-line'
                ]
            ],
            
            // Reviews Section
            'reviews_enabled' => true,
            'reviews_title' => 'آراء العملاء',
            'reviews_count' => 3,
            'reviews_data' => [
                [
                    'name' => 'أحمد محمد',
                    'city' => 'الرياض',
                    'text' => 'خدمة ممتازة ومنتجات عالية الجودة. أنصح بالتعامل مع هذا المتجر.',
                    'rating' => 5
                ],
                [
                    'name' => 'فاطمة علي',
                    'city' => 'جدة',
                    'text' => 'تجربة تسوق رائعة وتوصيل سريع. شكراً لكم.',
                    'rating' => 5
                ],
                [
                    'name' => 'محمد السعيد',
                    'city' => 'الدمام',
                    'text' => 'أسعار منافسة وجودة عالية. سأعود للشراء مرة أخرى.',
                    'rating' => 4
                ]
            ],
            
            // Location Section
            'location_enabled' => true,
            'location_title' => 'موقعنا',
            'location_address' => 'الرياض، المملكة العربية السعودية',
            'location_phone' => '+966 50 123 4567',
            'location_email' => 'info@store.com',
            'location_hours' => 'السبت - الخميس: 9:00 ص - 10:00 م',
            'location_map_image' => null,
            
            // Footer Section
            'footer_enabled' => true,
            'footer_description' => 'متجرك الإلكتروني الموثوق للحصول على أحدث المنتجات التقنية بأفضل الأسعار وأعلى جودة.',
            'footer_quick_links' => [
                ['name' => 'من نحن', 'url' => '/about'],
                ['name' => 'اتصل بنا', 'url' => '/contact'],
                ['name' => 'سياسة الخصوصية', 'url' => '/privacy'],
                ['name' => 'شروط الاستخدام', 'url' => '/terms']
            ],
            'footer_payment_methods' => [
                'ri-visa-fill',
                'ri-mastercard-fill',
                'ri-paypal-fill',
                'ri-apple-fill'
            ],
            'footer_social_media' => [
                ['icon' => 'ri-twitter-fill', 'url' => '#'],
                ['icon' => 'ri-facebook-fill', 'url' => '#'],
                ['icon' => 'ri-instagram-fill', 'url' => '#'],
                ['icon' => 'ri-youtube-fill', 'url' => '#']
            ],
            'footer_copyright' => '© 2024 جميع الحقوق محفوظة',
            
            // Theme Colors
            'primary_color' => '#00e5bb',
            'background_color' => '#0f172a',
            'text_color' => '#ffffff',
            'secondary_text_color' => '#94a3b8',
        ];

        // Add store_id if the column exists
        try {
            $defaultData['store_id'] = $storeId;
        } catch (\Exception $e) {
            // Column doesn't exist, skip it
        }

        return self::create($defaultData);
    }
}
