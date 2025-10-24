<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'الخطة الشهرية',
                'slug' => 'monthly-plan',
                'description' => 'خطة مثالية للمتاجر الصغيرة والمتوسطة مع جميع المميزات الأساسية',
                'price' => 99.00,
                'duration_days' => 30,
                'duration_type' => 'monthly',
                'features' => [
                    'لوحة تحكم متكاملة',
                    'دعم فني على مدار الساعة',
                    'إحصائيات مفصلة',
                    'تخصيص الألوان والشعار',
                    'حتى 5 طرق دفع',
                    'نسخ احتياطي يومي'
                ],
                'max_products' => 100,
                'max_orders' => 500,
                'commission_rate' => 2.5,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 1
            ],
            [
                'name' => 'خطة 6 أشهر',
                'slug' => 'semi-annual-plan', 
                'description' => 'خطة اقتصادية للمتاجر الطموحة مع خصم 15% وميزات إضافية',
                'price' => 499.00,
                'duration_days' => 180,
                'duration_type' => 'semi_annual',
                'features' => [
                    'جميع مميزات الخطة الشهرية',
                    'خصم 15% على السعر الإجمالي',
                    'تطبيق جوال مخصص',
                    'تقارير متقدمة',
                    'دعم عبر واتساب',
                    'تدريب مجاني على النظام',
                    'طرق دفع غير محدودة',
                    'دومين فرعي مجاني'
                ],
                'max_products' => 500,
                'max_orders' => 2000,
                'commission_rate' => 2.0,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'الخطة السنوية',
                'slug' => 'annual-plan',
                'description' => 'الخيار الأمثل للمتاجر الكبيرة مع خصم 25% وجميع المميزات المتقدمة',
                'price' => 899.00,
                'duration_days' => 365,
                'duration_type' => 'annual',
                'features' => [
                    'جميع مميزات الخطط السابقة',
                    'خصم 25% على السعر الإجمالي',
                    'دومين مخصص مجاني',
                    'مدير حساب مخصص',
                    'تصميم متجر مخصص',
                    'تكامل مع أنظمة المحاسبة',
                    'API متقدم للتكامل',
                    'أولوية في الدعم الفني',
                    'استشارة تسويقية مجانية'
                ],
                'max_products' => null, // غير محدود
                'max_orders' => null,   // غير محدود
                'commission_rate' => 1.5,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 3
            ],
            [
                'name' => 'الخطة المجانية',
                'slug' => 'free-plan',
                'description' => 'خطة مجانية للبدء مع مميزات أساسية محدودة',
                'price' => 0.00,
                'duration_days' => 30,
                'duration_type' => 'monthly',
                'features' => [
                    'لوحة تحكم أساسية',
                    'دعم فني عبر البريد الإلكتروني',
                    'إحصائيات أساسية',
                    'تخصيص الألوان الأساسية',
                    'طريقة دفع واحدة',
                    'نسخ احتياطي أسبوعي'
                ],
                'max_products' => 10,
                'max_orders' => 50,
                'commission_rate' => 5.0,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 0
            ],
            [
                'name' => 'خطة الشركات',
                'slug' => 'enterprise-plan',
                'description' => 'خطة متقدمة للشركات الكبيرة مع جميع المميزات المتقدمة والدعم المخصص',
                'price' => 1999.00,
                'duration_days' => 365,
                'duration_type' => 'annual',
                'features' => [
                    'جميع مميزات الخطة السنوية',
                    'دعم فني مخصص 24/7',
                    'مدير مشروع مخصص',
                    'تكامل مع أنظمة ERP',
                    'API غير محدود',
                    'تقارير مخصصة',
                    'تدريب فريق كامل',
                    'ضمان SLA 99.9%',
                    'نسخ احتياطي كل ساعة',
                    'أمان متقدم',
                    'دعم متعدد اللغات'
                ],
                'max_products' => null, // غير محدود
                'max_orders' => null,   // غير محدود
                'commission_rate' => 1.0,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 4
            ],
            [
                'name' => 'خطة المطورين',
                'slug' => 'developer-plan',
                'description' => 'خطة مخصصة للمطورين والوكالات مع أدوات التطوير المتقدمة',
                'price' => 299.00,
                'duration_days' => 30,
                'duration_type' => 'monthly',
                'features' => [
                    'جميع مميزات الخطة الشهرية',
                    'API متقدم للتطوير',
                    'أدوات التطوير والتشخيص',
                    'دعم تقني متخصص',
                    'وصول إلى الكود المصدري',
                    'تكامل مع Git',
                    'اختبارات آلية',
                    'توثيق API شامل',
                    'أدوات إدارة المشاريع',
                    'دعم متعدد العملاء'
                ],
                'max_products' => 1000,
                'max_orders' => 5000,
                'commission_rate' => 2.0,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 5
            ],
            [
                'name' => 'خطة التجريبية',
                'slug' => 'trial-plan',
                'description' => 'خطة تجريبية لمدة أسبوعين لاختبار جميع المميزات',
                'price' => 0.00,
                'duration_days' => 14,
                'duration_type' => 'trial',
                'features' => [
                    'جميع مميزات الخطة الشهرية',
                    'دعم فني كامل',
                    'وصول إلى جميع الأدوات',
                    'لا توجد قيود على المنتجات',
                    'لا توجد قيود على الطلبات',
                    'إمكانية الترقية في أي وقت'
                ],
                'max_products' => null, // غير محدود خلال التجربة
                'max_orders' => null,   // غير محدود خلال التجربة
                'commission_rate' => 0.0, // بدون عمولة خلال التجربة
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 6
            ]
        ];

        foreach ($plans as $planData) {
            SubscriptionPlan::updateOrCreate(
                ['slug' => $planData['slug']],
                $planData
            );
        }
    }
}
