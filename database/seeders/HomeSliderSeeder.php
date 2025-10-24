<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomeSliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('home_sliders')->insert([
            [
                'title' => 'أفضل حسابات الألعاب والسوشيال ميديا',
                'subtitle' => 'احصل على حسابات متميزة بأسعار تنافسية وضمان الجودة',
                'image' => 'sliders/default-1.jpg',
                'button_text' => 'تصفح الحسابات',
                'button_url' => '/products',
                'secondary_button_text' => 'عروض خاصة',
                'secondary_button_url' => '/products/featured',
                'is_active' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
        
        DB::table('home_sliders')->insert([
            [
                'title' => 'عروض مميزة على حسابات الألعاب',
                'subtitle' => 'تمتع بأفضل العروض الحصرية على حسابات الألعاب لفترة محدودة',
                'image' => 'sliders/default-2.jpg',
                'button_text' => 'تسوق الآن',
                'button_url' => '/products/featured',
                'secondary_button_text' => null,
                'secondary_button_url' => null,
                'is_active' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
} 