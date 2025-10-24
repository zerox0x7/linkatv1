<?php

namespace App\Observers;

use App\Models\Order;
use App\Events\OrderStatusUpdated;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    /**
     * Handle the Order "updated" event.
     *
     * This method is called when an Order model instance is updated.
     * It checks if the 'status' attribute of the order has changed.
     * If it has, it dispatches the OrderStatusUpdated event.
     *
     * @param  \App\Models\Order  $order The order instance that was updated.
     * @return void
     */
    public function updated(Order $order): void
    {
        Log::critical('IMMEDIATE LOG: OrderObserver@updated has been entered. Order ID: ' . $order->id); // <--- رسالة تسجيل فورية

        // Check if the 'status' attribute was actually changed during this update operation.
        if ($order->isDirty('status')) {
            Log::info('Order status IS DIRTY. Firing OrderStatusUpdated event.', [
                'order_id' => $order->id,
                'new_status' => $order->status,
                'original_status' => $order->getOriginal('status') // لمعرفة الحالة الأصلية
            ]);
            // Dispatch the OrderStatusUpdated event, passing the updated order model
            // and the new status.
            event(new OrderStatusUpdated($order, $order->status));
        } else {
            Log::info('Order status IS NOT DIRTY. Event not fired.', [
                'order_id' => $order->id,
                'current_status' => $order->status,
                'original_status' => $order->getOriginal('status')
            ]);
        }
    }
}
