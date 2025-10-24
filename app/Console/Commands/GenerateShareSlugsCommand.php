<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Str;

class GenerateShareSlugsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:generate-share-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'إنشاء share_slug لجميع المنتجات التي لا تحتوي عليه';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('بدء إنشاء share_slug للمنتجات...');
        
        // البحث عن المنتجات التي ليس لديها share_slug
        $products = Product::whereNull('share_slug')->get();
        $count = 0;
        
        $bar = $this->output->createProgressBar(count($products));
        $bar->start();
        
        foreach ($products as $product) {
            // إنشاء share_slug من اسم المنتج
            $product->share_slug = Product::generateShareSlug($product->name);
            $product->save();
            
            $count++;
            $bar->advance();
        }
        
        $bar->finish();
        $this->line('');
        
        $this->info("تم إنشاء {$count} share_slug للمنتجات.");
        
        // إجراء فحص إضافي على المنتجات ذات السلاقات العشوائية
        // لا نستخدم REGEXP لضمان التوافق مع مختلف قواعد البيانات
        $this->info('البحث عن منتجات إضافية تحتاج لتحديث...');
        
        // استراتيجية لتحديد السلاقات العشوائية: حروف وأرقام فقط وبطول معين واسم مختلف عن الـ slug
        $productsToCheck = Product::whereRaw('LENGTH(slug) >= 8')
            ->whereRaw('LENGTH(slug) <= 15')
            ->whereNotNull('share_slug')
            ->get();
            
        $mismatchCount = 0;
        
        foreach ($productsToCheck as $product) {
            // نحدد ما إذا كان Slug عشوائي إذا كان لا يشبه اسم المنتج
            $productNameSlug = Str::slug($product->name);
            $currentSlug = $product->slug;
            
            // إذا كان الاختلاف كبيرًا، نفترض أنه slug عشوائي
            $similarity = similar_text($productNameSlug, $currentSlug, $percent);
            
            if ($percent < 30) {
                // تحديث slug في بعض الحالات (مثلا إذا كان share_slug فارغ)
                if (empty($product->share_slug)) {
                    $product->share_slug = Product::generateShareSlug($product->name);
                    $product->save();
                    $mismatchCount++;
                }
            }
        }
        
        if ($mismatchCount > 0) {
            $this->info("تم إنشاء {$mismatchCount} share_slug إضافي للمنتجات ذات السلاقات العشوائية.");
        }
        
        $this->info('تم الانتهاء من العملية بنجاح!');
        
        return Command::SUCCESS;
    }
}
