<?php

namespace App\Listeners;

use App\Events\OrderStatusUpdated;
use App\Services\WhatsApp\WhatsAppService;
use App\Notifications\OrderStatusEmail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OrderStatusNotifier implements ShouldQueue
{
    use InteractsWithQueue;
    
    /**
     * The WhatsApp service instance.
     *
     * @var \App\Services\WhatsApp\WhatsAppService
     */
    protected $whatsAppService;

    /**
     * Create the event listener.
     */
    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    /**
     * Handle the event.
     */
    public function handle(OrderStatusUpdated $event): void
    {
        $order = $event->order;
        $status = $event->status;
        
        Log::info('تحديث حالة الطلب', [
            'order_id' => $order->id,
            'status' => $status,
        ]);
        
        // إرسال إشعار حالة الطلب
        $this->sendOrderStatusNotification($order, $status);
        
        // إرسال رسالة واتساب بتعليمات المنتج إذا وجدت
        $this->sendProductNotesWhatsApp($order);
        
        // إرسال إشعار للإدارة
        $this->notifyAdmin($order, $status);
        
        // إرسال إشعار التسليم إذا كان الطلب مكتملاً أو تم توصيله
        if ($status === 'delivered' || $status === 'completed') {
            $this->sendDeliveryNotificationIfApplicable($order);
        }

        // إرسال إشعار البريد الإلكتروني
        if ($order->user) {
            if (method_exists($order->user, 'notify')) {
                try {
                    $order->user->notify(new OrderStatusEmail($order, $status));
                    Log::info('تم إرسال إشعار تحديث حالة الطلب بالبريد الإلكتروني بنجاح.', [
                        'order_id' => $order->id,
                        'user_id' => $order->user->id,
                        'email' => $order->user->email
                    ]);
                } catch (\Exception $e) {
                    Log::error('فشل إرسال إشعار تحديث حالة الطلب بالبريد الإلكتروني.', [
                        'order_id' => $order->id,
                        'user_id' => $order->user->id,
                        'error' => $e->getMessage()
                    ]);
                }
            } else {
                Log::warning('المستخدم المرتبط بالطلب لا يستخدم Notifiable trait.', [
                    'order_id' => $order->id,
                    'user_id' => $order->user->id
                ]);
            }
        } else if ($order->billing_email) {
            Log::info('الطلب يحتوي على بريد إلكتروني للفوترة ولكن لا يوجد مستخدم مرتبط مباشرة.', [
                'order_id' => $order->id,
                'billing_email' => $order->billing_email
            ]);
        }
    }
    
    /**
     * إرسال إشعار حالة الطلب للعميل
     */
    protected function sendOrderStatusNotification($order, $status): void
    {
        try {
            $statusText = [
                'pending' => 'قيد الانتظار',
                'processing' => 'قيد المعالجة',
                'completed' => 'مكتمل',
                'cancelled' => 'ملغي',
                'refunded' => 'مسترجع',
            ];

            $orderDetails = $this->buildOrderDetails($order);
            $digitalCodes = $this->getDigitalCodes($order);

            // جمع بيانات الحسابات الرقمية (AccountDigetal)
            $digitalAccounts = '';
            $accounts = DB::table('account_digetal')
                ->where('order_id', $order->id)
                ->get();
            foreach ($accounts as $account) {
                $meta = is_string($account->meta) ? json_decode($account->meta, true) : $account->meta;
                $details = [];
                if (is_array($meta)) {
                    foreach ($meta as $key => $value) {
                        if ($key === 'lines' && is_array($value)) {
                            // فقط أضف الأسطر مباشرة بدون عنوان
                            $details[] = implode("\n", $value);
                        } elseif (is_array($value)) {
                            $details[] = $key . ":\n" . implode("\n", $value);
                        } else {
                            $details[] = $key . ': ' . $value;
                        }
                    }
                }
                $digitalAccounts .= ($order->items->where('id', $account->product_id)->first()->name ?? 'حساب رقمي') . "\n";
                $digitalAccounts .= implode("\n", $details) . "\n-------------------\n";
            }
            $digitalAccounts = trim($digitalAccounts);

            // اختيار القالب المناسب حسب حالة الطلب
            $template = match ($order->status) {
                'pending'    => 'order_pending',
                'processing' => 'order_processing',
                'completed'  => 'order_completed',
                'cancelled'  => 'order_cancelled',
                'refunded'   => 'order_refunded',
                default      => 'order_status', // fallback
            };

            $this->whatsAppService->sendMessage(
                $order->user->phone,
                $template,
                [
                    'customer_name'        => $order->user->name,
                    'order_number'         => $order->order_number ?? $order->id,
                    'status'               => $statusText[$order->status] ?? $order->status,
                    'order_details'        => $orderDetails,
                    'total_amount'         => number_format($order->total, 2) . ' ' . config('app.currency'),
                    'payment_status'       => $order->payment_status ?? '',
                    'payment_date'         => $order->paid_at ? $order->paid_at->format('Y-m-d') : '',
                    'digital_codes'        => $digitalCodes,
                    'digital_accounts'     => $digitalAccounts,
                    'cancellation_reason'  => $order->cancellation_reason ?? '',
                    'payment_error'        => $order->payment_error ?? '',
                    'payment_method'       => $order->payment_method ?? '',
                    'delivery_date'        => $order->delivered_at ? $order->delivered_at->format('Y-m-d') : '',
                    'tracking_number'      => $order->tracking_number ?? '',
                    'order_url'            => route('orders.show', $order->id),
                ],
                $order
            );

            Log::info('تم إرسال إشعار حالة الطلب بنجاح', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'status' => $status
            ]);

        } catch (\Exception $e) {
            Log::error('فشل إرسال إشعار حالة الطلب', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * إرسال إشعار للإدارة عند تغيير حالة الطلب
     */
    protected function notifyAdmin($order, $status): void
    {
        $adminPhones = config('whatsapp.admin_phones', []);
        if (is_string($adminPhones)) {
            // دعم أكثر من رقم مفصول بفواصل أو أسطر
            $adminPhones = preg_split('/[\n,]+/', $adminPhones, -1, PREG_SPLIT_NO_EMPTY);
        }
        if (empty($adminPhones)) return;
        $statusText = [
            'pending' => 'قيد الانتظار',
            'processing' => 'قيد المعالجة',
            'completed' => 'مكتمل',
            'cancelled' => 'ملغي',
            'refunded' => 'مسترجع',
        ];
        $orderDetails = $this->buildOrderDetails($order);
        $digitalCodes = $this->getDigitalCodes($order);
        // جمع بيانات الحسابات الرقمية (AccountDigetal)
        $digitalAccounts = '';
        $accounts = DB::table('account_digetal')
            ->where('order_id', $order->id)
            ->get();
        foreach ($accounts as $account) {
            $meta = is_string($account->meta) ? json_decode($account->meta, true) : $account->meta;
            $details = [];
            if (is_array($meta)) {
                foreach ($meta as $key => $value) {
                    if ($key === 'lines' && is_array($value)) {
                        // فقط أضف الأسطر مباشرة بدون عنوان
                        $details[] = implode("\n", $value);
                    } elseif (is_array($value)) {
                        $details[] = $key . ":\n" . implode("\n", $value);
                    } else {
                        $details[] = $key . ': ' . $value;
                    }
                }
            }
            $digitalAccounts .= ($order->items->where('id', $account->product_id)->first()->name ?? 'حساب رقمي') . "\n";
            $digitalAccounts .= implode("\n", $details) . "\n-------------------\n";
        }
        $digitalAccounts = trim($digitalAccounts);
        // ضمان وجود جميع المفاتيح المطلوبة لقالب admin_notification
        $adminParams = [
            'order_number'        => $order->order_number ?? $order->id,
            'customer_name'       => $order->user->name ?? '',
            'status'              => $statusText[$order->status] ?? $order->status,
            'order_details'       => $orderDetails,
            'total_amount'        => number_format($order->total, 2) . ' ' . config('app.currency'),
            'payment_status'      => $order->payment_status ?? '',
            'payment_date'        => $order->paid_at ? $order->paid_at->format('Y-m-d') : '',
            'digital_codes'       => $digitalCodes,
            'digital_accounts'    => $digitalAccounts,
            'cancellation_reason' => $order->cancellation_reason ?? '',
            'payment_error'       => $order->payment_error ?? '',
            'payment_method'      => $order->payment_method ?? '',
            'delivery_date'       => $order->delivered_at ? $order->delivered_at->format('Y-m-d') : '',
            'tracking_number'     => $order->tracking_number ?? '',
            'order_url'           => route('admin.orders.show', $order->id),
        ];
        // إضافة أي مفتاح ناقص كقيمة فارغة
        $required = [
            'order_number', 'customer_name', 'status', 'order_details', 'total_amount',
            'payment_status', 'payment_date', 'digital_codes', 'digital_accounts', 'cancellation_reason',
            'payment_error', 'payment_method', 'delivery_date', 'tracking_number', 'order_url'
        ];
        foreach ($required as $key) {
            if (!isset($adminParams[$key])) {
                $adminParams[$key] = '';
            }
        }
        foreach ($adminPhones as $phone) {
            $this->whatsAppService->sendMessage(
                $phone,
                'admin_notification',
                $adminParams,
                $order
            );
        }
    }

    /**
     * تجميع تفاصيل الطلب كنص
     */
    protected function buildOrderDetails($order): string
    {
        $details = [];
        foreach ($order->items as $item) {
            $productName = $item->name ?? 'منتج غير معروف';
            $details[] = $productName . ' × ' . $item->quantity;
        }
        return implode("\n", $details);
    }

    /**
     * جمع الأكواد الرقمية من الطلب
     */
    protected function getDigitalCodes($order): string
    {
        $allCodes = DB::table('digital_card_codes')
            ->where('order_id', $order->id)
            ->pluck('code')
            ->toArray();

        $result = [];
        $codeIndex = 0;

        foreach ($order->items as $item) {
            $productName = $item->name ?? 'منتج غير معروف';
            $qty = $item->quantity;
            $codesForThisItem = array_slice($allCodes, $codeIndex, $qty);
            $codeIndex += $qty;

            if (!empty($codesForThisItem)) {
                $result[] = "{$productName} (عدد {$qty}):\n" . implode("\n", $codesForThisItem);
            }
        }

        return implode("\n\n", $result);
    }

    /**
     * Send delivery notification for digital or service products if needed
     */
    protected function sendDeliveryNotificationIfApplicable($order): void
    {
        $hasDigitalOrService = false;
        
        // Check if order has digital or service products
        foreach ($order->items as $item) {
            $product = $item->product;
            if ($product && ($product->type === 'digital' || $product->type === 'service')) {
                $hasDigitalOrService = true;
                break; 
            }
        }

        if ($hasDigitalOrService) {
            // استخدام الدالة الجديدة sendDeliveryNotification
            $this->whatsAppService->sendDeliveryNotification($order);
        }
    }

    /**
     * إرسال رسالة واتساب بتعليمات المنتج (product_note) إذا وجدت
     */
    protected function sendProductNotesWhatsApp($order): void
    {
        // ترسل التعليمات فقط إذا كان الطلب مكتمل
        if ($order->status !== 'completed') {
            return;
        }
        if (!$order->user || !$order->user->phone) {
            return;
        }
        // تحميل علاقة orderable مع العناصر إذا لم تكن محملة
        $order->loadMissing('items.orderable');
        foreach ($order->items as $item) {
            $product = $item->orderable;
            \Log::info('فحص عنصر الطلب لإرسال تعليمات المنتج', [
                'order_id' => $order->id,
                'item_id' => $item->id,
                'product_exists' => $product ? true : false,
                'product_id' => $product->id ?? null,
                'product_note' => $product->product_note ?? null,
            ]);
            if ($product && !empty($product->product_note)) {
                Log::info('سيتم الآن إرسال رسالة واتساب بتعليمات المنتج', [
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'user_phone' => $order->user->phone,
                    'product_note' => $product->product_note,
                ]);
                try {
                    $this->whatsAppService->sendMessage(
                        $order->user->phone,
                        'text', // قالب نصي عام
                        ['message' => $product->product_note]
                    );
                    Log::info('تم إرسال رسالة واتساب بتعليمات المنتج للعميل', [
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'user_phone' => $order->user->phone
                    ]);
                } catch (\Exception $e) {
                    Log::error('فشل إرسال رسالة واتساب بتعليمات المنتج', [
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }
    }
} 