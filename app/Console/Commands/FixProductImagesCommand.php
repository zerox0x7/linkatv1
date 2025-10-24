<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FixProductImagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:fix-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'إصلاح مسارات الصور للمنتجات وتوحيدها';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('بدء إصلاح صور المنتجات...');
        
        // تأكد من وجود المجلدات
        if (!Storage::disk('public')->exists('products')) {
            Storage::disk('public')->makeDirectory('products');
            $this->info('تم إنشاء مجلد منتجات جديد.');
        }
        
        $products = Product::all();
        $this->info('وجدنا ' . $products->count() . ' منتج لمعالجته.');
        
        $fixedMain = 0;
        $fixedGallery = 0;
        
        foreach ($products as $product) {
            $this->info("معالجة المنتج: " . $product->name);
            
            // إصلاح الصورة الرئيسية
            if ($product->main_image) {
                $currentPath = $product->main_image;
                
                // التحقق من وجود الصورة
                if (Storage::disk('public')->exists($currentPath)) {
                    $this->info('الصورة الرئيسية موجودة: ' . $currentPath);
                } else {
                    $this->error('الصورة الرئيسية غير موجودة: ' . $currentPath);
                    
                    // إذا كانت الصورة في مسار مختلف، ابحث عنها
                    $filename = basename($currentPath);
                    $this->info("البحث عن الصورة: " . $filename);
                    
                    $files = Storage::disk('public')->allFiles('products');
                    foreach ($files as $file) {
                        if (basename($file) === $filename) {
                            $this->info("تم العثور على الصورة في: " . $file);
                            $product->main_image = $file;
                            $product->save();
                            $fixedMain++;
                            break;
                        }
                    }
                }
            }
            
            // إصلاح معرض الصور
            if ($product->gallery) {
                $gallery = json_decode($product->gallery, true);
                
                if (is_array($gallery)) {
                    $updatedGallery = [];
                    $galleryChanged = false;
                    
                    foreach ($gallery as $index => $imagePath) {
                        if (Storage::disk('public')->exists($imagePath)) {
                            $this->info('صورة المعرض موجودة: ' . $imagePath);
                            $updatedGallery[] = $imagePath;
                        } else {
                            $this->error('صورة المعرض غير موجودة: ' . $imagePath);
                            
                            // إذا كانت الصورة في مسار مختلف، ابحث عنها
                            $filename = basename($imagePath);
                            $this->info("البحث عن الصورة: " . $filename);
                            
                            $found = false;
                            $files = Storage::disk('public')->allFiles('products');
                            foreach ($files as $file) {
                                if (basename($file) === $filename) {
                                    $this->info("تم العثور على الصورة في: " . $file);
                                    $updatedGallery[] = $file;
                                    $galleryChanged = true;
                                    $fixedGallery++;
                                    $found = true;
                                    break;
                                }
                            }
                            
                            if (!$found) {
                                $this->warn("لم يتم العثور على الصورة: " . $filename);
                            }
                        }
                    }
                    
                    if ($galleryChanged) {
                        $product->gallery = json_encode($updatedGallery);
                        $product->save();
                    }
                }
            }
        }
        
        $this->info('تم إصلاح ' . $fixedMain . ' صور رئيسية و ' . $fixedGallery . ' صور معرض.');
        $this->info('تم الانتهاء من تصحيح صور المنتجات.');
        
        return 0;
    }
}
