<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\DigitalCard;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeliverDigitalCardsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:deliver-digital-cards';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'تسليم البطاقات الرقمية للطلبات المدفوعة وتحديث حالتها إلى مكتمل';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('بدء تسليم البطاقات الرقمية للطلبات المدفوعة...');
        
        // البحث عن طلبات مدفوعة ولكن ليست مكتملة بعد
        $orders = Order::where('payment_status', 'paid')
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->with(['items.orderable'])
            ->get();
            
        $this->info("تم العثور على {$orders->count()} طلب للمعالجة.");
        
        $processedOrders = 0;
        
        foreach ($orders as $order) {
            $order->deliverDigitalCodes();
            $processedOrders++;
        }
        
        $this->newLine();
        $this->info("تم الانتهاء من المعالجة:");
        $this->info("- عدد الطلبات المعالجة: {$processedOrders}");
        
        return Command::SUCCESS;
    }
}
