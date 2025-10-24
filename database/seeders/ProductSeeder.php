<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // الحصول على معرفات التصنيفات
        $pubgCategory = DB::table('categories')->where('slug', 'pubg-accounts')->first();
        $fortniteCategory = DB::table('categories')->where('slug', 'fortnite-accounts')->first();
        $snapchatCategory = DB::table('categories')->where('slug', 'snapchat-accounts')->first();

        if (!$pubgCategory || !$fortniteCategory || !$snapchatCategory) {
            echo "يجب تشغيل CategorySeeder أولاً لإنشاء التصنيفات.\n";
            return;
        }

        $products = [
            // منتجات ببجي
            [
                'category_id' => $pubgCategory->id,
                'name' => 'حساب ببجي رويال مستوى 100',
                'slug' => 'pubg-royal-level-100',
                'description' => 'حساب ببجي رويال بمستوى 100 مع العديد من الأسلحة النادرة والأزياء المميزة.',
                'price' => 199.99,
                'old_price' => 249.99,
                'stock' => 1,
                'status' => 'active',
                'is_featured' => true,
                'features' => json_encode(['مستوى 100', 'رويال باس', 'أسلحة نادرة'], JSON_UNESCAPED_UNICODE),
                'type' => 'account',
                'warranty_days' => '30',
                'main_image' => 'products/pubg1.jpg',
                'rating' => 4.8,
                'sales_count' => 15,
                'views_count' => 1200,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $pubgCategory->id,
                'name' => 'حساب ببجي مستوى 75 مع أسلحة مميزة',
                'slug' => 'pubg-level-75-special-weapons',
                'description' => 'حساب ببجي بمستوى 75 يحتوي على مجموعة من الأسلحة المميزة والأزياء النادرة.',
                'price' => 149.99,
                'old_price' => 199.99,
                'stock' => 1,
                'status' => 'active',
                'is_featured' => true,
                'features' => json_encode(['مستوى 75', 'أسلحة مميزة', 'أزياء نادرة'], JSON_UNESCAPED_UNICODE),
                'type' => 'account',
                'warranty_days' => '30',
                'main_image' => 'products/pubg2.jpg',
                'rating' => 4.5,
                'sales_count' => 8,
                'views_count' => 850,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            
            // منتجات فورتنايت
            [
                'category_id' => $fortniteCategory->id,
                'name' => 'حساب فورتنايت محترف مع سكنات نادرة',
                'slug' => 'fortnite-pro-account-rare-skins',
                'description' => 'حساب فورتنايت محترف يحتوي على سكنات نادرة وأسلحة مميزة.',
                'price' => 299.99,
                'old_price' => 349.99,
                'stock' => 1,
                'status' => 'active',
                'is_featured' => true,
                'features' => json_encode(['سكنات نادرة', 'باتل باس', 'أسلحة مميزة'], JSON_UNESCAPED_UNICODE),
                'type' => 'account',
                'warranty_days' => '30',
                'main_image' => 'products/fortnite1.jpg',
                'rating' => 4.9,
                'sales_count' => 25,
                'views_count' => 1800,
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'category_id' => $fortniteCategory->id,
                'name' => 'حساب فورتنايت مبتدئ مع باتل باس',
                'slug' => 'fortnite-starter-account-battle-pass',
                'description' => 'حساب فورتنايت للمبتدئين مع باتل باس وبعض السكنات الأساسية.',
                'price' => 99.99,
                'old_price' => 129.99,
                'stock' => 0,
                'status' => 'out-of-stock',
                'is_featured' => false,
                'features' => json_encode(['باتل باس', 'سكنات أساسية'], JSON_UNESCAPED_UNICODE),
                'type' => 'account',
                'warranty_days' => '30',
                'main_image' => 'products/fortnite2.jpg',
                'rating' => 4.2,
                'sales_count' => 42,
                'views_count' => 2500,
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(15),
            ],
            
            // منتجات سناب شات
            [
                'category_id' => $snapchatCategory->id,
                'name' => 'حساب سناب شات مميز',
                'slug' => 'special-snapchat-account',
                'description' => 'حساب سناب شات مميز مع اسم مستخدم قصير وأصدقاء كثيرون.',
                'price' => 399.99,
                'old_price' => 499.99,
                'stock' => 1,
                'status' => 'active',
                'is_featured' => true,
                'features' => json_encode(['اسم مستخدم قصير', '+5000 متابع', 'سناب سكور عالي'], JSON_UNESCAPED_UNICODE),
                'type' => 'account',
                'warranty_days' => '30',
                'main_image' => 'products/snapchat1.jpg',
                'rating' => 4.7,
                'sales_count' => 5,
                'views_count' => 900,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $snapchatCategory->id,
                'name' => 'حساب سناب شات عادي',
                'slug' => 'regular-snapchat-account',
                'description' => 'حساب سناب شات عادي مع اسم مستخدم مميز.',
                'price' => 149.99,
                'old_price' => null,
                'stock' => 1,
                'status' => 'active',
                'is_featured' => false,
                'features' => json_encode(['اسم مستخدم مميز', '+1000 متابع'], JSON_UNESCAPED_UNICODE),
                'type' => 'account',
                'warranty_days' => '30',
                'main_image' => 'products/snapchat2.jpg',
                'rating' => 4.3,
                'sales_count' => 12,
                'views_count' => 1100,
                'created_at' => now()->subDays(8),
                'updated_at' => now()->subDays(8),
            ],
        ];

        DB::table('products')->insert($products);
    }
} 