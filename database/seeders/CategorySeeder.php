<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'حسابات ببجي',
                'slug' => 'pubg-accounts',
                'description' => 'حسابات لعبة ببجي بمستويات مختلفة',
                'is_active' => true,
                'is_featured' => true,
                'show_in_homepage' => true,
                'homepage_order' => 1,
                'sort_order' => 1,
                'type' => 'account',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'حسابات فورتنايت',
                'slug' => 'fortnite-accounts',
                'description' => 'حسابات لعبة فورتنايت بمستويات مختلفة',
                'is_active' => true,
                'is_featured' => true,
                'show_in_homepage' => true,
                'homepage_order' => 2,
                'sort_order' => 2,
                'type' => 'account',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'حسابات سناب شات',
                'slug' => 'snapchat-accounts',
                'description' => 'حسابات سناب شات مميزة',
                'is_active' => true,
                'is_featured' => true,
                'show_in_homepage' => true,
                'homepage_order' => 3,
                'sort_order' => 3,
                'type' => 'account',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'بطاقات آيتونز',
                'slug' => 'itunes-cards',
                'description' => 'بطاقات آيتونز بفئات مختلفة',
                'is_active' => true,
                'is_featured' => true,
                'show_in_homepage' => false,
                'homepage_order' => 4,
                'sort_order' => 4,
                'type' => 'digital_card',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('categories')->insert($categories);
    }
} 