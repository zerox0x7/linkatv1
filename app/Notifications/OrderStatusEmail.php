<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order; // Add this line

class OrderStatusEmail extends Notification
{
    use Queueable;

    public Order $order;
    public string $status;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order, string $status)
    {
        $this->order = $order;
        $this->status = $status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $customerName = $this->order->customer_name ?? $notifiable->name; // Assuming customer_name on order or name on notifiable (User)
        $subject = sprintf("تحديث حالة طلبك رقم #%s", $this->order->id);
        $greeting = sprintf("مرحباً %s,", $customerName);
        $statusMessage = sprintf("تم تحديث حالة طلبك رقم #%s إلى: %s", $this->order->id, __("order_status." . $this->status)); // Using translation for status

        return (new MailMessage)
                    ->subject($subject)
                    ->greeting($greeting)
                    ->line($statusMessage)
                    ->action("عرض الطلب", route('orders.show', $this->order->id)) // Assuming you have a route named 'orders.show'
                    ->line("شكراً لاستخدامك متجرنا!");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
