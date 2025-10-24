<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class TestCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'سناب شات',
                'description' => 'حسابات سناب شات',
                'store_id' => 1,
                'is_active' => true,
                'status' => 'active',
            ],
            [
                'name' => 'حسابات ببجي',
                'description' => 'حسابات لعبة ببجي',
                'store_id' => 1,
                'is_active' => true,
                'status' => 'active',
            ],
            [
                'name' => 'رموز التلفزيون',
                'description' => 'رموز التلفزيون والبث',
                'store_id' => 1,
                'is_active' => true,
                'status' => 'active',
            ],
            [
                'name' => 'ألعاب',
                'description' => 'ألعاب مختلفة',
                'store_id' => 1,
                'is_active' => true,
                'status' => 'active',
            ],
            [
                'name' => 'برمجيات',
                'description' => 'برمجيات وتطبيقات',
                'store_id' => 1,
                'is_active' => true,
                'status' => 'active',
            ],
            [
                'name' => 'اشتراكات',
                'description' => 'اشتراكات مختلفة',
                'store_id' => 1,
                'is_active' => true,
                'status' => 'active',
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::firstOrCreate(
                ['name' => $categoryData['name'], 'store_id' => $categoryData['store_id']],
                $categoryData
            );
        }
    }
}
