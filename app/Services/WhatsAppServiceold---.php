<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\WhatsAppTemplate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class WhatsAppService
{
    protected $apiKey;
    protected $instanceId;
    protected $defaultLang;
    protected $notificationsEnabled;
    protected $defaultPhonePrefix;

    /**
     * Constructor - initialize service with configs
     */
    public function __construct()
    {
        $this->apiKey = config('whatsapp.api_key');
        $this->instanceId = config('whatsapp.instance_id');
        $this->defaultLang = config('whatsapp.default_lang', 'ar');
        $this->notificationsEnabled = (bool) config('whatsapp.enable_notifications', true);
        $this->defaultPhonePrefix = config('whatsapp.default_phone_prefix', '+966');
    }

    /**
     * Format phone number - ensure it has proper country code
     * 
     * @param string $phone
     * @return string
     */
    public function formatPhone($phone)
    {
        // 1. Remove any non-numeric characters.
        //    This will also remove any '+' sign.
        //    So, $phone will be like '9665...' or '05...' or '5...'
        $cleanedPhone = preg_replace('/[^\\d]/', '', $phone);

        // 2. Check if the cleaned phone number starts with the country code (e.g., '966')
        //    The MEMORY[b223ff7a-bc19-4772-94e8-03f3bf7f343a] states numbers are stored as 966...
        //    The defaultPhonePrefix from config is '+966'

        // Remove the '+' from defaultPhonePrefix for comparison and for constructing the number without double '+'
        $prefixWithoutPlus = ltrim($this->defaultPhonePrefix, '+'); // Should be '966'

        if (str_starts_with($cleanedPhone, $prefixWithoutPlus)) {
            // If cleanedPhone is '966...' (it already has the country code)
            // Just add '+' at the beginning.
            return '+' . $cleanedPhone;
        } else {
            // If cleanedPhone is a local number like '05...' or '5...' (after ltrim '0')
            // Remove leading '0' if it exists (for local numbers like 05... -> 5...)
            $localNumber = ltrim($cleanedPhone, '0');
            // Add the full default prefix which includes '+' (e.g., '+966')
            return $this->defaultPhonePrefix . $localNumber;
        }
    }

    /**
     * Send a WhatsApp message using a template
     * 
     * @param string $phone
     * @param string $templateName
     * @param array $params
     * @return array|null
     */
    public function sendTemplateMessage($phone, $templateName, $params = [])
    {
        if (!$this->notificationsEnabled) {
            Log::info('واتساب: الإشعارات معطلة في الإعدادات');
            return null;
        }
        
        try {
            $formattedPhone = $this->formatPhone($phone);
            
            // Get template from database
            $template = WhatsAppTemplate::where('name', $templateName)
                ->where('is_active', true)
                ->first();
                
            if (!$template) {
                Log::error("واتساب: القالب '{$templateName}' غير موجود أو غير مفعل");
                return null;
            }
            
            // Replace parameters in template content
            $content = $template->content;
            foreach ($params as $key => $value) {
                $content = str_replace('{{'.$key.'}}', $value, $content);
            }
            
            // Log for debugging
            Log::info("واتساب: جاري إرسال رسالة بقالب '{$templateName}' إلى {$formattedPhone}", ['params' => $params]);
            
            // Send the message via API
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-API-Key' => $this->apiKey,
            ])->post('https://dl1s.co/api/send', [
                'instance_id' => $this->instanceId,
                'to' => $formattedPhone,
                'type' => 'text',
                'content' => [
                    'text' => $content
                ],
                'language' => $this->defaultLang,
            ]);
            
            $result = $response->json();
            
            if ($response->successful()) {
                Log::info('واتساب: تم إرسال الرسالة بنجاح', ['result' => $result]);
                return $result;
            } else {
                Log::error('واتساب: فشل إرسال الرسالة', ['result' => $result]);
                return null;
            }
            
        } catch (Exception $e) {
            Log::error('واتساب: خطأ أثناء إرسال الرسالة', [
                'error' => $e->getMessage(),
                'phone' => $phone,
                'template' => $templateName
            ]);
            return null;
        }
    }
    
    /**
     * Send delivery notification based on order and product type
     * 
     * @param Order $order
     * @return array|null
     */
    public function sendDeliveryNotification(Order $order)
    {
        // Get customer phone
        $phone = $order->customer_phone ?? $order->user->phone ?? null;
        
        if (!$phone) {
            Log::error('واتساب: تعذر إرسال إشعار التسليم، رقم الهاتف غير متوفر', ['order_id' => $order->id]);
            return null;
        }
        
        $orderItems = $order->items;
        $productTypes = [];
        $digitalCodes = [];
        
        // Check what types of products are in the order
        foreach ($orderItems as $item) {
            $product = $item->product;
            $productTypes[$product->type] = true;
            
            // For digital products, collect codes
            if ($product->type === 'digital' && isset($item->digital_code)) {
                $digitalCodes[] = [
                    'product_name' => $product->name,
                    'code' => $item->digital_code
                ];
            }
        }
        
        // Select template based on product types in order
        if (count($productTypes) === 1) {
            // Single type of product in order
            if (isset($productTypes['digital'])) {
                return $this->sendDigitalProductDelivery($order, $phone, $digitalCodes);
            } elseif (isset($productTypes['service'])) {
                return $this->sendServiceDelivery($order, $phone);
            } elseif (isset($productTypes['physical'])) {
                return $this->sendPhysicalProductDelivery($order, $phone);
            }
        } else {
            // Mixed types - use a generic delivery template
            return $this->sendGenericDelivery($order, $phone);
        }
        
        return null;
    }
    
    /**
     * Send notification for digital product delivery
     * 
     * @param Order $order
     * @param string $phone
     * @param array $digitalCodes
     * @return array|null
     */
    public function sendDigitalProductDelivery(Order $order, $phone, $digitalCodes)
    {
        // Format digital codes for message
        $codesText = '';
        foreach ($digitalCodes as $index => $item) {
            $codesText .= ($index + 1) . ". {$item['product_name']}: {$item['code']}\n";
        }
        
        return $this->sendTemplateMessage($phone, 'delivery', [
            'customer_name' => $order->user->name ?? 'العميل',
            'order_id' => $order->id,
            'delivery_date' => now()->format('Y-m-d'),
            'delivery_time' => now()->format('H:i'),
            'digital_codes' => $codesText,
            'order_url' => route('orders.show', $order->id)
        ]);
    }
    
    /**
     * Send notification for service delivery
     * 
     * @param Order $order
     * @param string $phone
     * @return array|null
     */
    public function sendServiceDelivery(Order $order, $phone)
    {
        return $this->sendTemplateMessage($phone, 'service_delivery', [
            'customer_name' => $order->user->name ?? 'العميل',
            'order_id' => $order->id,
            'delivery_date' => now()->format('Y-m-d'),
            'delivery_time' => now()->format('H:i'),
            'service_info' => 'تم تنشيط الخدمة وهي الآن متاحة في حسابك',
            'order_url' => route('orders.show', $order->id)
        ]);
    }
    
    /**
     * Send notification for physical product delivery/shipping
     * 
     * @param Order $order
     * @param string $phone
     * @return array|null
     */
    public function sendPhysicalProductDelivery(Order $order, $phone)
    {
        return $this->sendTemplateMessage($phone, 'physical_delivery', [
            'customer_name' => $order->user->name ?? 'العميل',
            'order_id' => $order->id,
            'delivery_date' => now()->format('Y-m-d'),
            'delivery_time' => now()->format('H:i'),
            'tracking_info' => $order->tracking_number ? "رقم التتبع: {$order->tracking_number}" : "سيتم إرسال تفاصيل الشحن قريباً",
            'order_url' => route('orders.show', $order->id)
        ]);
    }
    
    /**
     * Send generic delivery notification for mixed product types
     * 
     * @param Order $order
     * @param string $status
     * @return array|null
     */
    /**
     * Send generic delivery notification for mixed product types
     * 
     * @param Order $order
     * @param string $phone
     * @return array|null
     */
    public function sendGenericDelivery(Order $order, $phone)
    {
        return $this->sendTemplateMessage($phone, 'delivery', [
            'customer_name' => $order->user->name ?? 'العميل',
            'order_id' => $order->id,
            'delivery_date' => now()->format('Y-m-d'),
            'delivery_time' => now()->format('H:i'),
            'order_url' => route('orders.show', $order->id)
        ]);
    }
    public function sendOrderStatusUpdate(Order $order, $status)
    {
        // Get customer phone
        $phone = $order->customer_phone ?? $order->user->phone ?? null;
        
        if (!$phone) {
            Log::error('واتساب: تعذر إرسال إشعار تحديث حالة الطلب، رقم الهاتف غير متوفر', ['order_id' => $order->id]);
            return null;
        }
        
        // Check if we should send notification for this status
        $notifyStatuses = config('whatsapp.notify_statuses', []);
        if (!in_array($status, $notifyStatuses)) {
            // Log::info("واتساب: لن يتم إرسال إشعار للحالة {$status} للطلب {$order->id}");
            return null;
        }
        
        // Status names in Arabic
        $statusNames = [
            'pending'    => 'معلق', // Added pending as it might be used
            'new'        => 'جديد',
            'processing' => 'قيد المعالجة',
            'shipped'    => 'تم الشحن',
            'delivered'  => 'تم التسليم',
            'completed'  => 'مكتمل',
            'cancelled'  => 'ملغي',
            'failed'     => 'فشل',
            'refunded'   => 'مسترجع'
        ];
        
        $params = [
            'customer_name' => $order->user->name ?? ($order->billing_name ?? 'العميل'),
            'order_id'      => $order->id,
            'order_status'  => $statusNames[$status] ?? $status,
            'order_date'    => $order->created_at->format('Y-m-d'),
            'order_amount'  => number_format($order->total, 2) . ' ' . ($order->currency ?? config('app.currency', 'ريال')),
            // 'order_url' is intentionally removed
        ];

        return $this->sendTemplateMessage($phone, 'order_status', $params);
    }
}