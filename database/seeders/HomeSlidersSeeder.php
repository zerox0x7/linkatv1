<?php

namespace Database\Seeders;

use App\Models\HomeSlider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomeSlidersSeeder extends Seeder
{
    /**
     * تنفيذ بذر بيانات السلايدرات الرئيسية.
     */
    public function run(): void
    {
        // حذف البيانات الحالية
        HomeSlider::truncate();
        
        // إضافة السلايدرات الافتراضية
        $sliders = [
            [
                'title' => 'تسوق حسابات الألعاب',
                'subtitle' => 'احصل على حسابات ألعاب وبطاقات رقمية بأفضل الأسعار',
                'image' => 'sliders/slide1.jpg',
                'link' => '/products',
                'button_text' => 'تسوق الآن',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'title' => 'بطاقات رقمية',
                'subtitle' => 'اشتري بطاقات رقمية واستلمها فورًا',
                'image' => 'sliders/slide2.jpg',
                'link' => '/digital-cards',
                'button_text' => 'اشتر الآن',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'title' => 'عروض خاصة',
                'subtitle' => 'خصومات كبيرة على مجموعة مختارة من المنتجات',
                'image' => 'sliders/slide3.jpg',
                'link' => '/offers',
                'button_text' => 'تصفح العروض',
                'is_active' => true,
                'sort_order' => 3
            ],
        ];
        
        foreach ($sliders as $slider) {
            HomeSlider::create($slider);
        }
    }
}
