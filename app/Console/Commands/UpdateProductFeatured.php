<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;

class UpdateProductFeatured extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-product-featured';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'تحديث المنتجات المميزة وإعدادات عرض التصنيفات في الصفحة الرئيسية';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // تحديث جميع المنتجات لتكون مميزة
        $productsUpdated = Product::where('status', 'active')
            ->update(['is_featured' => true]);
        
        $this->info("تم تحديث {$productsUpdated} منتج ليكون مميز");
        
        // تحديث جميع التصنيفات لتظهر في الصفحة الرئيسية
        $categoriesUpdated = Category::where('is_active', true)
            ->update(['show_in_homepage' => true]);
        
        $this->info("تم تحديث {$categoriesUpdated} تصنيف للظهور في الصفحة الرئيسية");
        
        $this->info('تم الانتهاء من التحديث بنجاح');
    }
}
