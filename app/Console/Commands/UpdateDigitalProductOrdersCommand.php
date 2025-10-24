<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateDigitalProductOrdersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:update-digital-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'تحديث حالة الطلبات التي تحتوي على منتجات رقمية وتسليم الأكواد';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('بدء معالجة طلبات المنتجات الرقمية...');
        
        // البحث عن طلبات مدفوعة ولكن ليست مكتملة
        $orders = Order::where('payment_status', 'paid')
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->with(['items'])
            ->get();
            
        $this->info("تم العثور على {$orders->count()} طلب للمعالجة.");
        
        $processedOrders = 0;
        $deliveredCodes = 0;
        
        foreach ($orders as $order) {
            $this->line("معالجة الطلب #{$order->id}...");
            
            $hasDigitalProducts = false;
            $hasPhysicalProducts = false;
            $allDigitalItemsHaveCodes = true; // للتحقق من أن جميع المنتجات الرقمية لديها أكواد متاحة
            
            foreach ($order->items as $item) {
                // التحقق من نوع المنتج (إذا كان من نوع Product)
                if ($item->orderable_type === 'App\\Models\\Product') {
                    $product = DB::table('products')->where('id', $item->orderable_id)->first();
                    
                    if ($product && $product->type === 'digital_card') {
                        $hasDigitalProducts = true;
                        $this->line("  - منتج رقمي: {$item->name}");
                        
                        // تسليم الأكواد الرقمية
                        $codes = DB::table('digital_card_codes')
                            ->where('product_id', $product->id)
                            ->where(function($query) use ($order) {
                                $query->where('order_id', $order->id)
                                      ->orWhere(function($q) {
                                          $q->where('order_id', null)
                                            ->where('status', 'available');
                                      });
                            })
                            ->limit($item->quantity)
                            ->get();
                            
                        $this->line("  - وجدنا {$codes->count()} كود متاح للتسليم");
                        
                        if ($codes->count() < $item->quantity) {
                            $this->warn("  ⚠️ تحذير: لا تتوفر أكواد كافية للمنتج \"{$item->name}\" - الطلب #{$order->id}");
                            $allDigitalItemsHaveCodes = false;
                            continue;
                        }
                        
                        $deliveredCodesCount = 0;
                        foreach ($codes as $code) {
                            if ($code->order_id === null || $code->status !== 'used') {
                                DB::table('digital_card_codes')
                                    ->where('id', $code->id)
                                    ->update([
                                        'status' => 'used', // تغيير الحالة إلى "used" بدلاً من "sold"
                                        'sold_at' => now(),
                                        'order_id' => $order->id,
                                        'user_id' => $order->user_id,
                                    ]);
                                
                                $deliveredCodes++;
                                $deliveredCodesCount++;
                                $this->line("  - تم تسليم كود: {$code->code}");
                            }
                        }
                        
                        // تحديث المخزون للمنتج إذا لم يكن محدثًا بالفعل
                        if ($deliveredCodesCount > 0) {
                            // حساب المخزون المتبقي (عدد الأكواد المتبقية)
                            $remainingCodes = DB::table('digital_card_codes')
                                ->where('product_id', $product->id)
                                ->where('order_id', null)
                                ->where('status', 'available')
                                ->count();
                                
                            // تحديث المخزون في جدول المنتجات
                            DB::table('products')
                                ->where('id', $product->id)
                                ->update([
                                    'stock' => $remainingCodes,
                                    'updated_at' => now()
                                ]);
                                
                            $this->line("  - تم تحديث المخزون للمنتج \"{$item->name}\" إلى {$remainingCodes}");
                        }
                    } else {
                        $hasPhysicalProducts = true;
                        $this->line("  - منتج فعلي: {$item->name}");
                    }
                } elseif ($item->orderable_type === 'App\\Models\\DigitalCard') {
                    $hasDigitalProducts = true;
                    $this->line("  - بطاقة رقمية: {$item->name}");
                    
                    // تسليم الأكواد من البطاقات الرقمية
                    $digitalCard = DB::table('digital_cards')->where('id', $item->orderable_id)->first();
                    if ($digitalCard) {
                        $codes = DB::table('digital_card_codes')
                            ->where('digital_card_id', $digitalCard->id)
                            ->where(function($query) use ($order) {
                                $query->where('order_id', $order->id)
                                      ->orWhere(function($q) {
                                          $q->where('order_id', null)
                                            ->where('status', 'available');
                                      });
                            })
                            ->limit($item->quantity)
                            ->get();
                            
                        $this->line("  - وجدنا {$codes->count()} كود متاح للتسليم من البطاقة الرقمية");
                        
                        if ($codes->count() < $item->quantity) {
                            $this->warn("  ⚠️ تحذير: لا تتوفر أكواد كافية للبطاقة الرقمية \"{$item->name}\" - الطلب #{$order->id}");
                            $allDigitalItemsHaveCodes = false;
                            continue;
                        }
                        
                        $deliveredCodesCount = 0;
                        foreach ($codes as $code) {
                            if ($code->order_id === null || $code->status !== 'used') {
                                DB::table('digital_card_codes')
                                    ->where('id', $code->id)
                                    ->update([
                                        'status' => 'used',
                                        'sold_at' => now(),
                                        'order_id' => $order->id,
                                        'user_id' => $order->user_id,
                                    ]);
                                
                                $deliveredCodes++;
                                $deliveredCodesCount++;
                                $this->line("  - تم تسليم كود: {$code->code}");
                            }
                        }
                        
                        // تحديث المخزون للبطاقة الرقمية
                        if ($deliveredCodesCount > 0) {
                            // حساب المخزون المتبقي
                            $remainingCodes = DB::table('digital_card_codes')
                                ->where('digital_card_id', $digitalCard->id)
                                ->where('order_id', null)
                                ->where('status', 'available')
                                ->count();
                                
                            // تحديث المخزون في جدول البطاقات الرقمية
                            DB::table('digital_cards')
                                ->where('id', $digitalCard->id)
                                ->update([
                                    'stock_quantity' => $remainingCodes,
                                    'updated_at' => now()
                                ]);
                                
                            $this->line("  - تم تحديث المخزون للبطاقة الرقمية \"{$item->name}\" إلى {$remainingCodes}");
                        }
                    }
                }
            }
            
            // تحديث حالة الطلب
            if ($hasDigitalProducts && !$hasPhysicalProducts && $allDigitalItemsHaveCodes) {
                // إذا كان الطلب يحتوي فقط على منتجات رقمية وجميع المنتجات لديها أكواد متاحة، تحديث الحالة إلى مكتمل
                $order->update([
                    'status' => 'completed',
                    'fulfilled_at' => now(),
                ]);
                
                $this->info("  ✅ تم تحديث حالة الطلب #{$order->id} إلى مكتمل لأنه يحتوي فقط على منتجات رقمية");
                
                // إرسال إشعار للمستخدم (يمكن تنفيذه هنا إذا كان هناك نظام إشعارات)
                // يمكن إضافة كود لإرسال بريد إلكتروني أو إشعار للمستخدم بأن طلبه قد اكتمل
            } elseif ($hasDigitalProducts && $hasPhysicalProducts) {
                // إذا كان الطلب مختلط (منتجات رقمية وفعلية)، تحديث الحالة إلى معالجة
                if ($order->status === 'pending') {
                    $order->update([
                        'status' => 'processing',
                    ]);
                    
                    $this->info("  ✅ تم تحديث حالة الطلب #{$order->id} إلى معالجة لأنه يحتوي على منتجات مختلطة");
                }
            }
            
            $processedOrders++;
        }
        
        // إخراج ملخص
        $this->newLine();
        $this->info("تم الانتهاء من المعالجة:");
        $this->info("- عدد الطلبات المعالجة: {$processedOrders}");
        $this->info("- عدد الأكواد المسلمة: {$deliveredCodes}");
        
        return Command::SUCCESS;
    }
} 