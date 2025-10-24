<?php

namespace Database\Seeders;

use App\Models\HomeSectionSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomeSectionSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // حذف الإعدادات الموجودة لتجنب التكرار
        HomeSectionSetting::truncate();
        
        // إضافة إعدادات الأقسام الثابتة
        $sections = [
            // قسم البانر الرئيسي
            [
                'section_key' => 'hero_section',
                'title' => 'البانر الرئيسي',
                'description' => 'البانر الرئيسي للصفحة الرئيسية',
                'order' => 1,
                'is_active' => true,
                'content' => [
                    'heading' => 'أفضل المنتجات الرقمية بأسعار منافسة',
                    'subheading' => 'تسوق بثقة واحصل على أفضل الحسابات الرقمية مع ضمان استرجاع لمدة 30 يوم',
                    'button_text' => 'تسوق الآن',
                    'button_url' => '/products',
                    'background_image' => 'hero-bg.jpg',
                    'show_search' => true,
                ]
            ],
            // قسم المنتجات المميزة
            [
                'section_key' => 'featured_products',
                'title' => 'المنتجات المميزة',
                'description' => 'أفضل المنتجات المميزة في متجرنا',
                'order' => 5,
                'is_active' => true,
                'content' => [
                    'products_count' => 8,
                    'display_type' => 'grid', // grid, carousel
                    'show_price' => true,
                    'show_rating' => true,
                    'auto_select' => true, // اختيار تلقائي للمنتجات المميزة
                ]
            ],
            // قسم التصنيفات
            [
                'section_key' => 'categories_section',
                'title' => 'تصفح حسب التصنيف',
                'description' => 'تصفح المنتجات حسب التصنيف',
                'order' => 10,
                'is_active' => true,
                'content' => [
                    'max_categories' => 6,
                    'display_empty_categories' => false,
                    'layout_type' => 'grid', // grid, carousel
                    'show_image' => true,
                    'show_product_count' => true,
                ]
            ],
            // قسم المميزات
            [
                'section_key' => 'features_section',
                'title' => 'مميزاتنا',
                'description' => 'مميزات متجرنا',
                'order' => 20,
                'is_active' => true,
                'content' => [
                    'features' => [
                        [
                            'title' => 'حسابات موثوقة 100%',
                            'description' => 'نقدم حسابات مضمونة ومفحوصة بعناية مع ضمان استرجاع لمدة 30 يوماً.',
                            'icon' => 'ri-shield-check-line',
                            'color' => 'from-primary to-secondary'
                        ],
                        [
                            'title' => 'دعم فني 24/7',
                            'description' => 'فريق دعم متميز جاهز لمساعدتك في أي وقت ومتابعة طلبك خطوة بخطوة.',
                            'icon' => 'ri-customer-service-2-line',
                            'color' => 'from-primary to-secondary'
                        ],
                        [
                            'title' => 'دفع آمن ومتعدد',
                            'description' => 'طرق دفع متنوعة وآمنة تشمل البطاقات الائتمانية ومدى والمحافظ الإلكترونية.',
                            'icon' => 'ri-secure-payment-line',
                            'color' => 'from-primary to-secondary'
                        ],
                        [
                            'title' => 'استلام فوري',
                            'description' => 'استلام منتجاتك الرقمية بشكل فوري بعد إتمام عملية الدفع بنجاح.',
                            'icon' => 'ri-time-line',
                            'color' => 'from-primary to-secondary'
                        ]
                    ]
                ]
            ],
            // قسم العروض الخاصة
            [
                'section_key' => 'offers_section',
                'title' => 'عروض خاصة',
                'description' => 'أحدث العروض والتخفيضات',
                'order' => 25,
                'is_active' => true,
                'content' => [
                    'background_color' => '#f8f9fa',
                    'offer_image' => 'special-offer.jpg',
                    'offer_title' => 'خصم 20% على جميع الحسابات',
                    'offer_description' => 'عرض لفترة محدودة، استخدم كود الخصم SPECIAL20',
                    'button_text' => 'تسوق الآن',
                    'button_url' => '/offers',
                    'expiry_date' => '2023-12-31',
                ]
            ],
            // قسم التقييمات
            [
                'section_key' => 'testimonials_section',
                'title' => 'آراء العملاء',
                'description' => 'ما يقوله عملاؤنا عنا',
                'order' => 30,
                'is_active' => true,
                'content' => [
                    'display_count' => 5,
                    'display_default_testimonials' => true,
                    'default_testimonials' => [
                        [
                            'name' => 'أحمد محمد',
                            'position' => 'عميل',
                            'rating' => 5,
                            'comment' => 'خدمة ممتازة وسرعة في التوصيل، المنتج كان مطابق للوصف تماماً وسأتعامل معكم مرة أخرى.',
                            'image' => 'testimonials/user1.jpg',
                        ],
                        [
                            'name' => 'سارة علي',
                            'position' => 'عميلة',
                            'rating' => 5,
                            'comment' => 'من أفضل المتاجر التي تعاملت معها، دعم فني ممتاز وحسابات موثوقة 100%.',
                            'image' => 'testimonials/user2.jpg',
                        ],
                        [
                            'name' => 'خالد عبدالله',
                            'position' => 'عميل',
                            'rating' => 4,
                            'comment' => 'سعيد جداً بالتعامل معكم، خدمة عملاء متميزة والرد سريع على كل الاستفسارات.',
                            'image' => 'testimonials/user3.jpg',
                        ]
                    ]
                ]
            ],
            // قسم النشرة البريدية
            [
                'section_key' => 'newsletter_section',
                'title' => 'اشترك في نشرتنا البريدية',
                'description' => 'احصل على آخر العروض والتخفيضات مباشرة إلى بريدك الإلكتروني. كن أول من يعلم بالحسابات الجديدة والعروض الحصرية.',
                'order' => 40,
                'is_active' => true,
                'content' => [
                    'button_text' => 'اشتراك',
                    'placeholder' => 'أدخل بريدك الإلكتروني',
                    'background_color' => '#f8f9fa',
                    'show_privacy_text' => true,
                    'privacy_text' => 'لن نشارك بريدك الإلكتروني مع أي جهة أخرى.',
                ]
            ],
            // قسم الإحصائيات
            [
                'section_key' => 'stats_section',
                'title' => 'إحصائيات المتجر',
                'description' => 'إحصائيات توضح نجاح متجرنا',
                'order' => 35,
                'is_active' => true,
                'content' => [
                    'stats' => [
                        [
                            'label' => 'عملاء سعداء',
                            'value' => '5000+',
                            'icon' => 'ri-user-smile-line'
                        ],
                        [
                            'label' => 'منتجات متنوعة',
                            'value' => '200+',
                            'icon' => 'ri-shopping-basket-line'
                        ],
                        [
                            'label' => 'تقييم إيجابي',
                            'value' => '98%',
                            'icon' => 'ri-star-smile-line'
                        ],
                        [
                            'label' => 'طلبات ناجحة',
                            'value' => '15000+',
                            'icon' => 'ri-shopping-cart-line'
                        ]
                    ]
                ]
            ]
        ];
        
        // إضافة الإعدادات إلى قاعدة البيانات
        foreach ($sections as $section) {
            HomeSectionSetting::create($section);
        }
    }
}
