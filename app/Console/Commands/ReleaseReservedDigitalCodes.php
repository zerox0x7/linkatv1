<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\DigitalCardCode;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReleaseReservedDigitalCodes extends Command
{
    protected $signature = 'codes:release-reserved';
    protected $description = 'تحرير الأكواد الرقمية المحجوزة سابقاً في الطلبات الملغية والمعلقة';

    public function handle()
    {
        $this->info('جاري تحرير الأكواد المحجوزة...');
        
        // 1. البحث عن الطلبات المعلقة أو الملغية أو التي فشل دفعها
        $orders = Order::whereIn('status', ['pending', 'cancelled', 'payment_failed'])
            ->where('payment_status', '!=', 'paid')
            ->get();
            
        $this->info("تم العثور على {$orders->count()} طلب لتحرير الأكواد...");
        
        $totalReleasedCodes = 0;
        
        foreach ($orders as $order) {
            $this->info("معالجة الطلب #{$order->id}...");
            
            // 2. تحرير الأكواد المرتبطة بالطلب
            foreach ($order->items as $item) {
                if ($item->orderable_type === 'App\\Models\\Product') {
                    // التحقق إذا كان منتج رقمي
                    $product = $item->orderable;
                    if ($product && $product->type === 'digital_card') {
                        // إعادة تعيين حالة أكواد البطاقات الرقمية
                        $releasedCodes = DB::table('digital_card_codes')
                            ->where('product_id', $item->orderable_id)
                            ->where('order_id', $order->id)
                            ->update([
                                'status' => 'available',
                                'sold_at' => null,
                                'order_id' => null,
                                'user_id' => null,
                            ]);
                            
                        $totalReleasedCodes += $releasedCodes;
                        
                        $this->info("  تم تحرير {$releasedCodes} كود للمنتج #{$item->orderable_id}");
                        
                        // تحديث المخزون
                        $availableCount = DB::table('digital_card_codes')
                            ->where('product_id', $item->orderable_id)
                            ->where('status', 'available')
                            ->whereNull('order_id')
                            ->count();
                            
                        DB::table('products')
                            ->where('id', $item->orderable_id)
                            ->update([
                                'stock' => $availableCount,
                                'updated_at' => now()
                            ]);
                            
                        $this->info("  تم تحديث المخزون للمنتج #{$item->orderable_id} إلى {$availableCount}");
                    }
                } elseif ($item->orderable_type === 'App\\Models\\DigitalCard') {
                    $digitalCard = \App\Models\DigitalCard::find($item->orderable_id);
                    if ($digitalCard) {
                        // إعادة تعيين حالة أكواد البطاقات الرقمية
                        $releasedCodes = $digitalCard->codes()
                            ->where('order_id', $order->id)
                            ->update([
                                'status' => 'available',
                                'sold_at' => null,
                                'order_id' => null,
                                'user_id' => null,
                            ]);
                            
                        $totalReleasedCodes += $releasedCodes;
                        
                        $this->info("  تم تحرير {$releasedCodes} كود للبطاقة الرقمية #{$item->orderable_id}");
                        
                        // تحديث المخزون
                        $availableCount = $digitalCard->codes()
                            ->where('status', 'available')
                            ->whereNull('order_id')
                            ->count();
                            
                        $digitalCard->update([
                            'stock_quantity' => $availableCount,
                        ]);
                        
                        $this->info("  تم تحديث المخزون للبطاقة الرقمية #{$item->orderable_id} إلى {$availableCount}");
                    }
                }
            }
            
            // إضافة ملاحظة للطلب
            $order->update([
                'notes' => ($order->notes ? $order->notes . "\n" : '') . 
                           'تم تحرير الأكواد المحجوزة يدوياً في ' . now()->format('Y-m-d H:i:s'),
            ]);
        }
        
        $this->info("تم الانتهاء من العملية! تم تحرير {$totalReleasedCodes} كود رقمي من {$orders->count()} طلب.");
        
        return 0;
    }
}