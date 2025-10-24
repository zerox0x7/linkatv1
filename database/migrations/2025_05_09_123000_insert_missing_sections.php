<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // التحقق من وجود الأقسام وإضافتها إذا كانت غير موجودة
        $sections = [
            [
                'key' => 'category_products',
                'title' => 'المنتجات حسب الفئة',
                'description' => 'عرض المنتجات مقسمة حسب الفئات',
                'sort_order' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'features',
                'title' => 'مميزات الموقع',
                'description' => 'عرض مميزات وخدمات الموقع',
                'sort_order' => 5,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'testimonials',
                'title' => 'آراء العملاء',
                'description' => 'عرض آراء وتقييمات العملاء',
                'sort_order' => 6,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'subscribe',
                'title' => 'اشتراك النشرة البريدية',
                'description' => 'نموذج الاشتراك في النشرة البريدية',
                'sort_order' => 7,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($sections as $section) {
            // التحقق من وجود القسم قبل إضافته
            $exists = DB::table('home_sections')
                ->where('key', $section['key'])
                ->exists();
                
            if (!$exists) {
                DB::table('home_sections')->insert($section);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // حذف الأقسام التي تمت إضافتها
        DB::table('home_sections')
            ->whereIn('key', ['category_products', 'features', 'testimonials', 'subscribe'])
            ->delete();
    }
}; 