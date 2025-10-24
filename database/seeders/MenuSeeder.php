<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing menu items
        DB::table('menus')->truncate();

        // Sample menu items
        $menuItems = [
            [
                'title' => 'الرئيسية',
                'url' => '/',
                'svg' => 'ri-home-line',
                'owner_id' => 1,
                'order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'المنتجات',
                'url' => '/products',
                'svg' => 'ri-store-line',
                'owner_id' => 1,
                'order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'من نحن',
                'url' => '/about',
                'svg' => 'ri-information-line',
                'owner_id' => 1,
                'order' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'اتصل بنا',
                'url' => '/contact',
                'svg' => 'ri-phone-line',
                'owner_id' => 1,
                'order' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($menuItems as $item) {
            Menu::create($item);
        }
    }
}
