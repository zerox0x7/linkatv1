<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateExistingDigitalCodesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:update-existing-codes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'تحديث حالة الأكواد الرقمية الموجودة من "sold" إلى "used" وتحديث المخزون';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('بدء تحديث الأكواد الرقمية للطلبات الموجودة...');
        
        // العثور على جميع الأكواد التي حالتها "sold"
        $soldCodes = DB::table('digital_card_codes')
            ->where('status', 'sold')
            ->whereNotNull('order_id')
            ->get();
            
        $this->info("تم العثور على {$soldCodes->count()} كود بحالة 'sold' للتحديث.");
        
        $updatedCodesCount = 0;
        $updatedProductsCount = 0;
        $productsToUpdate = []; // قائمة بالمنتجات التي تحتاج إلى تحديث المخزون
        
        foreach ($soldCodes as $code) {
            // تحديث حالة الكود إلى "used"
            DB::table('digital_card_codes')
                ->where('id', $code->id)
                ->update([
                    'status' => 'used',
                    'updated_at' => now()
                ]);
                
            $updatedCodesCount++;
            
            // إضافة المنتج/البطاقة الرقمية إلى قائمة المنتجات التي تحتاج إلى تحديث المخزون
            if ($code->product_id) {
                $productsToUpdate[$code->product_id] = 'product';
            } elseif ($code->digital_card_id) {
                $productsToUpdate[$code->digital_card_id] = 'digital_card';
            }
            
            $this->line("تم تحديث حالة الكود #{$code->id} ({$code->code}) من 'sold' إلى 'used'");
        }
        
        // تحديث المخزون للمنتجات والبطاقات الرقمية
        foreach ($productsToUpdate as $id => $type) {
            if ($type === 'product') {
                // حساب المخزون المتبقي للمنتج
                $remainingCodes = DB::table('digital_card_codes')
                    ->where('product_id', $id)
                    ->where('order_id', null)
                    ->where('status', 'available')
                    ->count();
                    
                // تحديث المخزون في جدول المنتجات
                DB::table('products')
                    ->where('id', $id)
                    ->update([
                        'stock' => $remainingCodes,
                        'updated_at' => now()
                    ]);
                    
                $productName = DB::table('products')->where('id', $id)->value('name');
                $this->line("تم تحديث المخزون للمنتج '{$productName}' (ID: {$id}) إلى {$remainingCodes}");
            } elseif ($type === 'digital_card') {
                // حساب المخزون المتبقي للبطاقة الرقمية
                $remainingCodes = DB::table('digital_card_codes')
                    ->where('digital_card_id', $id)
                    ->where('order_id', null)
                    ->where('status', 'available')
                    ->count();
                    
                // تحديث المخزون في جدول البطاقات الرقمية
                DB::table('digital_cards')
                    ->where('id', $id)
                    ->update([
                        'stock_quantity' => $remainingCodes,
                        'updated_at' => now()
                    ]);
                    
                $cardName = DB::table('digital_cards')->where('id', $id)->value('name');
                $this->line("تم تحديث المخزون للبطاقة الرقمية '{$cardName}' (ID: {$id}) إلى {$remainingCodes}");
            }
            
            $updatedProductsCount++;
        }
        
        // إخراج ملخص
        $this->newLine();
        $this->info("تم الانتهاء من تحديث الأكواد الرقمية:");
        $this->info("- عدد الأكواد المحدثة: {$updatedCodesCount}");
        $this->info("- عدد المنتجات التي تم تحديث مخزونها: {$updatedProductsCount}");
        
        return Command::SUCCESS;
    }
} 