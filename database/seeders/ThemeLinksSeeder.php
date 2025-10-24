<?php

namespace Database\Seeders;

use App\Models\ThemeLink;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ThemeLinksSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Sample theme links data
        ThemeLink::create([
            'name' => 'Modern Dashboard',
            'description' => 'A clean and modern dashboard theme with beautiful UI components',
            'is_active' => true,
            'links' => [
                [
                    'name' => 'Dashboard',
                    'route' => '/dashboard',
                    'icon' => 'fas fa-tachometer-alt',
                    'description' => 'Main dashboard overview'
                ],
                [
                    'name' => 'Products',
                    'route' => '/products',
                    'icon' => 'fas fa-box',
                    'description' => 'Manage your products'
                ],
                [
                    'name' => 'Orders',
                    'route' => '/orders',
                    'icon' => 'fas fa-shopping-cart',
                    'description' => 'View and manage orders'
                ],
                [
                    'name' => 'Customers',
                    'route' => '/customers',
                    'icon' => 'fas fa-users',
                    'description' => 'Customer management'
                ],
                [
                    'name' => 'Analytics',
                    'route' => '/analytics',
                    'icon' => 'fas fa-chart-line',
                    'description' => 'View detailed analytics'
                ],
                [
                    'name' => 'Settings',
                    'route' => '/settings',
                    'icon' => 'fas fa-cog',
                    'description' => 'Application settings'
                ]
            ]
        ]);

        // Inactive theme for testing
        ThemeLink::create([
            'name' => 'Classic Theme',
            'description' => 'A classic theme with traditional layout',
            'is_active' => false,
            'links' => [
                [
                    'name' => 'Home',
                    'route' => '/home',
                    'icon' => 'fas fa-home',
                    'description' => 'Home page'
                ],
                [
                    'name' => 'About',
                    'route' => '/about',
                    'icon' => 'fas fa-info-circle',
                    'description' => 'About us page'
                ]
            ]
        ]);
    }
} 