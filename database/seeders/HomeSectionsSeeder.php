<?php

namespace Database\Seeders;

use App\Models\HomeSection;
use Illuminate\Database\Seeder;

class HomeSectionsSeeder extends Seeder
{
    /**
     * تنفيذ عملية البذر
     */
    public function run(): void
    {
        // حذف البيانات القديمة لتجنب التكرار
        HomeSection::truncate();
        
        // إنشاء أقسام الصفحة الرئيسية الافتراضية
        $sections = [
            [
                'type' => 'featured',
                'title' => 'المنتجات المميزة',
                'subtitle' => 'تصفح أفضل الحسابات المميزة',
                'order' => 1,
                'is_active' => true,
                'settings' => [
                    'products_limit' => 8,
                    'display_style' => 'grid'
                ]
            ],
            [
                'type' => 'latest',
                'title' => 'أحدث المنتجات',
                'subtitle' => 'آخر الإضافات في المتجر',
                'order' => 2,
                'is_active' => true,
                'settings' => [
                    'products_limit' => 8,
                    'display_style' => 'grid'
                ]
            ],
            [
                'type' => 'best_sellers',
                'title' => 'الأكثر مبيعاً',
                'subtitle' => 'الحسابات الأكثر شراءً من قبل العملاء',
                'order' => 3,
                'is_active' => true,
                'settings' => [
                    'products_limit' => 8,
                    'display_style' => 'slider'
                ]
            ]
        ];
        
        // إضافة الأقسام إلى قاعدة البيانات
        foreach ($sections as $section) {
            HomeSection::create([
                'type' => $section['type'],
                'title' => $section['title'],
                'subtitle' => $section['subtitle'],
                'order' => $section['order'],
                'is_active' => $section['is_active'],
                'settings' => $section['settings']
            ]);
        }
    }
} 