<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomeSectionSetting;

class HomeSectionSeeder extends Seeder
{
    /**
     * تشغيل عملية البذر.
     */
    public function run(): void
    {
        // تسجيل أسماء الأعمدة للتأكد من صحتها
        $columns = \Schema::getColumnListing('home_section_settings');
        $this->command->info("أسماء الأعمدة: " . implode(', ', $columns));
        
        $sections = [
            [
                'key' => 'hero_section',
                'title' => 'قسم العرض الرئيسي',
                'description' => 'القسم الرئيسي في أعلى الصفحة الرئيسية',
                'order' => 1,
                'is_active' => true,
                'content' => json_encode([
                    'hero_title' => 'أفضل حسابات الألعاب والسوشيال ميديا',
                    'hero_subtitle' => 'احصل على حسابات متميزة بأسعار تنافسية وضمان الجودة',
                    'primary_button_text' => 'تصفح الحسابات',
                    'primary_button_url' => '/products',
                    'secondary_button_text' => 'عروض خاصة',
                    'secondary_button_url' => '/products/featured',
                    'show_secondary_button' => true
                ])
            ],
            [
                'key' => 'features_section',
                'title' => 'مميزات المتجر',
                'description' => 'عرض مميزات وفوائد المتجر',
                'order' => 2,
                'is_active' => true,
                'content' => json_encode([
                    'features' => [
                        [
                            'title' => 'حسابات موثوقة 100%',
                            'icon' => 'ri-shield-check-line',
                            'description' => 'نقدم حسابات مضمونة ومفحوصة بعناية مع ضمان استرجاع لمدة 30 يوماً.'
                        ],
                        [
                            'title' => 'دعم فني 24/7',
                            'icon' => 'ri-customer-service-2-line',
                            'description' => 'فريق دعم متميز جاهز لمساعدتك في أي وقت ومتابعة طلبك خطوة بخطوة.'
                        ],
                        [
                            'title' => 'دفع آمن ومتعدد',
                            'icon' => 'ri-secure-payment-line',
                            'description' => 'طرق دفع متنوعة وآمنة تشمل البطاقات الائتمانية ومدى والمحافظ الإلكترونية.'
                        ]
                    ]
                ])
            ],
            [
                'key' => 'categories_section',
                'title' => 'تصفح حسب التصنيف',
                'description' => 'عرض أقسام وتصنيفات المتجر',
                'order' => 3,
                'is_active' => true,
                'content' => json_encode([
                    'display_count' => 6,
                    'show_product_count' => true,
                    'show_more_button' => true
                ])
            ],
            [
                'key' => 'products_section',
                'title' => 'منتجات مميزة',
                'description' => 'عرض منتجات مختارة في الصفحة الرئيسية',
                'order' => 4,
                'is_active' => true,
                'content' => json_encode([
                    'type' => 'featured',
                    'display_style' => 'grid',
                    'products_limit' => 8
                ])
            ],
            [
                'key' => 'banner_section',
                'title' => 'بانر إعلاني',
                'description' => 'بانر ترويجي في الصفحة الرئيسية',
                'order' => 5,
                'is_active' => true,
                'content' => json_encode([
                    'banner_title' => 'عروض حصرية',
                    'banner_subtitle' => 'خصومات تصل إلى 50% على الحسابات المميزة',
                    'button_text' => 'تسوق الآن',
                    'button_url' => '/products/offers',
                    'background_color' => '#121212',
                    'text_color' => '#ffffff'
                ])
            ],
            [
                'key' => 'testimonials_section',
                'title' => 'آراء العملاء',
                'description' => 'تقييمات ومراجعات من عملائنا',
                'order' => 6,
                'is_active' => true,
                'content' => json_encode([
                    'display_count' => 6,
                    'auto_play' => true,
                    'show_rating' => true
                ])
            ],
            [
                'key' => 'newsletter_section',
                'title' => 'النشرة البريدية',
                'description' => 'الاشتراك في النشرة البريدية للحصول على آخر العروض',
                'order' => 7,
                'is_active' => true,
                'content' => json_encode([
                    'title' => 'اشترك في نشرتنا البريدية',
                    'description' => 'احصل على آخر العروض والتخفيضات مباشرة إلى بريدك الإلكتروني',
                    'button_text' => 'اشتراك',
                    'placeholder' => 'أدخل بريدك الإلكتروني'
                ])
            ]
        ];

        foreach ($sections as $sectionData) {
            // التحقق مما إذا كان القسم موجودًا بالفعل
            $existingSection = \DB::table('home_section_settings')->where('key', $sectionData['key'])->first();
            
            if (!$existingSection) {
                // إنشاء قسم جديد إذا لم يكن موجودًا
                \DB::table('home_section_settings')->insert($sectionData);
                $this->command->info("تم إنشاء قسم: " . $sectionData['title'] . " بنجاح");
            } else {
                $this->command->line("القسم " . $sectionData['title'] . " موجود بالفعل");
            }
        }
    }
} 