<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FixDigitalOrdersStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:fix-digital-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'تصحيح حالة طلبات المنتجات الرقمية المدفوعة لتكون مكتملة';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('بدء فحص وإصلاح حالة طلبات المنتجات الرقمية...');
        
        // البحث عن طلبات مدفوعة ولكن ليست مكتملة
        $orders = Order::where('payment_status', 'paid')
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->with(['items.orderable'])
            ->get();
            
        $this->info("تم العثور على {$orders->count()} طلب للمعالجة.");
        
        $updatedOrders = 0;
        
        foreach ($orders as $order) {
            // تحديد ما إذا كان الطلب يحتوي على منتجات رقمية فقط
            $totalItems = $order->items->count();
            $digitalItems = $order->items->where('orderable_type', 'App\\Models\\DigitalCard')->count();
            
            // إذا كان الطلب يحتوي فقط على منتجات رقمية
            if ($digitalItems > 0 && $digitalItems === $totalItems) {
                $this->line("الطلب #{$order->id} يحتوي على منتجات رقمية فقط - تحديث الحالة إلى مكتمل");
                
                // تحديث حالة الطلب إلى مكتمل
                $order->update([
                    'status' => 'completed',
                    'fulfilled_at' => now(),
                ]);
                
                // تسليم البطاقات الرقمية
                foreach ($order->items as $item) {
                    if ($item->orderable_type === 'App\\Models\\DigitalCard') {
                        $digitalCard = $item->orderable;
                        
                        // البحث عن أكواد متاحة
                        $availableCodes = $digitalCard->codes()
                            ->where(function($query) use ($order) {
                                $query->where('order_id', $order->id)
                                      ->orWhere(function($q) {
                                          $q->where('order_id', null)
                                            ->where('status', 'available');
                                      });
                            })
                            ->limit($item->quantity)
                            ->get();
                        
                        // إذا لم تتوفر أكواد كافية، تسجيل تحذير
                        if ($availableCodes->count() < $item->quantity) {
                            $this->warn("تحذير: لا تتوفر أكواد كافية للبطاقة \"{$digitalCard->name}\" - الطلب #{$order->id}");
                            Log::warning("عدد غير كافٍ من أكواد البطاقات الرقمية", [
                                'order_id' => $order->id,
                                'digital_card_id' => $digitalCard->id,
                                'required' => $item->quantity,
                                'available' => $availableCodes->count()
                            ]);
                            continue;
                        }
                        
                        // تعيين الأكواد للطلب
                        foreach ($availableCodes as $code) {
                            // إذا لم يتم تعيين الكود للطلب من قبل، قم بتحديثه
                            if ($code->order_id === null || $code->status !== 'sold') {
                                $code->update([
                                    'status' => 'sold',
                                    'sold_at' => now(),
                                    'order_id' => $order->id,
                                    'user_id' => $order->user_id,
                                ]);
                                
                                $this->line("  - تم تسليم كود: {$code->code}");
                            }
                        }
                    }
                }
                
                $updatedOrders++;
            }
        }
        
        // إخراج ملخص
        $this->newLine();
        $this->info("تم الانتهاء من المعالجة:");
        $this->info("- عدد الطلبات التي تم تحديثها: {$updatedOrders}");
        
        return Command::SUCCESS;
    }
} 