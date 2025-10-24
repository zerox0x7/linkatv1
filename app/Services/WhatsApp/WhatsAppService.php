<?php

namespace App\Services\WhatsApp;

use App\Models\Order;
use App\Models\User;
use App\Models\WhatsAppTemplate;
use App\Models\WhatsAppLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $apiKey;
    protected $instanceId;
    protected $baseUrl = 'https://dl1s.co/api/send'; // URL من ملف المطورين API

    /**
     * إنشاء مثيل جديد.
     */
    public function __construct()
    {
        $this->apiKey = config('whatsapp.api_key');
        $this->instanceId = config('whatsapp.instance_id');
    }

    /**
     * إرسال رسالة واتساب
     *
     * @param string $phone رقم الهاتف
     * @param WhatsAppTemplate|string $template قالب الرسالة
     * @param array $params معاملات الرسالة
     * @param mixed|null $related الكائن المرتبط (طلب، مستخدم)
     * @return array استجابة API
     */
    public function sendMessage($phone, $template, array $params = [], $related = null): array
    {
        Log::info('WhatsAppService::sendMessage', [
            'phone' => $phone,
            'template' => $template,
            'params' => $params,
        ]);

        // التحقق من تفعيل الإشعارات
        if (!config('whatsapp.enable_notifications', true)) {
            return ['status' => 'disabled', 'message' => 'WhatsApp notifications are disabled'];
        }

        // تنسيق رقم الهاتف
        $phone = $this->formatPhone($phone);

        // إذا كان القالب نصي عام أو null، أرسل الرسالة مباشرة
        if ($template === 'text' || $template === 'custom_text' || $template === null) {
            $message = is_array($params) ? ($params['message'] ?? '') : (string)$params;
            if (empty($message)) {
                Log::warning('WhatsAppService: رسالة نصية فارغة، لن يتم الإرسال', [
                    'phone' => $phone,
                    'params' => $params,
                ]);
                return ['status' => 'error', 'message' => 'Empty message'];
            }
            try {
                $requestData = [
                    'number' => $phone,
                    'type' => 'text',
                    'message' => $message,
                    'instance_id' => $this->instanceId,
                    'access_token' => $this->apiKey
                ];
                $response = Http::post($this->baseUrl, $requestData);
                $responseData = $response->json();
                if ($response->successful() && isset($responseData['status']) && $responseData['status'] === 'success') {
                    return [
                        'status' => 'success',
                        'id' => $responseData['id'] ?? null,
                    ];
                } else {
                    Log::error('WhatsApp API error (text message): ' . json_encode($responseData));
                    return [
                        'status' => 'error',
                        'message' => $responseData['error'] ?? 'Unknown error',
                    ];
                }
            } catch (\Exception $e) {
                Log::error('WhatsApp error (text message): ' . $e->getMessage());
                return [
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ];
            }
        }

        // الحصول على محتوى الرسالة
        if ($template instanceof WhatsAppTemplate) {
            $message = $template->prepareContent($params);
            $templateId = $template->id;
        } else {
            // البحث عن القالب بالنوع
            $templateObj = WhatsAppTemplate::where('type', $template)
                ->where('is_active', true)
                ->first();

            if (!$templateObj) {
                Log::warning("WhatsApp template not found: {$template}");
                return ['status' => 'error', 'message' => 'Template not found'];
            }

            $message = $templateObj->prepareContent($params);
            $templateId = $templateObj->id;
        }

        // تحديد نوع وهوية الكائن المرتبط
        $relatedType = null;
        $relatedId = null;

        if ($related) {
            $relatedType = get_class($related);
            $relatedId = $related->id;
        }

        // تحديد هوية المستخدم إذا كان متاحًا
        $userId = null;
        if ($related instanceof User) {
            $userId = $related->id;
        } elseif ($related instanceof Order && $related->user) {
            $userId = $related->user->id;
        }

        try {
            // إعداد بيانات الطلب وفقاً لتوثيق API
            $requestData = [
                'number' => $phone,
                'type' => 'text',  // النوع الافتراضي هو نص
                'message' => $message,
                'instance_id' => $this->instanceId,
                'access_token' => $this->apiKey
            ];

            // إرسال طلب API
            $response = Http::post($this->baseUrl, $requestData);
            $responseData = $response->json();

            // التأكد من نجاح الطلب
            if ($response->successful() && isset($responseData['status']) && $responseData['status'] === 'success') {
                // تسجيل الرسالة الناجحة
                $log = WhatsAppLog::create([
                    'user_id' => $userId,
                    'phone' => $phone,
                    'template_id' => $templateId,
                    'message' => $message,
                    'parameters' => $params,
                    'status' => 'success',
                    'external_id' => $responseData['id'] ?? null,
                    'related_type' => $relatedType,
                    'related_id' => $relatedId,
                ]);

                return [
                    'status' => 'success',
                    'id' => $responseData['id'] ?? null,
                    'log_id' => $log->id,
                ];
            } else {
                // تسجيل الرسالة الفاشلة
                $log = WhatsAppLog::create([
                    'user_id' => $userId,
                    'phone' => $phone,
                    'template_id' => $templateId,
                    'message' => $message,
                    'parameters' => $params,
                    'status' => 'failed',
                    'error' => $responseData['error'] ?? $response->body(),
                    'related_type' => $relatedType,
                    'related_id' => $relatedId,
                ]);

                Log::error('WhatsApp API error: ' . json_encode($responseData));
                return [
                    'status' => 'error',
                    'message' => $responseData['error'] ?? 'Unknown error',
                    'log_id' => $log->id,
                ];
            }
        } catch (\Exception $e) {
            // تسجيل خطأ الاتصال
            WhatsAppLog::create([
                'user_id' => $userId,
                'phone' => $phone,
                'template_id' => $templateId,
                'message' => $message,
                'parameters' => $params,
                'status' => 'failed',
                'error' => $e->getMessage(),
                'related_type' => $relatedType,
                'related_id' => $relatedId,
            ]);

            Log::error('WhatsApp error: ' . $e->getMessage());
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * إرسال رمز التحقق (OTP) 
     *
     * @param string $phone رقم الهاتف
     * @param string $otp رمز التحقق
     * @param User|null $user المستخدم (اختياري)
     * @return array
     */
    public function sendOTP($phone, $otp, $user = null): array
    {
        return $this->sendMessage(
            $phone,
            'otp',
            ['otp' => $otp, 'app_name' => config('app.name')],
            $user
        );
    }

    /**
     * إرسال إشعار تغيير حالة الطلب
     *
     * @param Order $order الطلب
     * @param string $status الحالة الجديدة
     * @return array
     */
    public function sendOrderStatusUpdate(Order $order, $status): array
    {
        if (!$order->user || !$order->user->phone) {
            return ['status' => 'error', 'message' => 'User phone not available'];
        }

        $statusName = trans('orders.statuses.' . $status);
        
        return $this->sendMessage(
            $order->user->phone,
            'order_status',
            [
                'customer_name' => $order->user->name,
                'order_id' => $order->id,
                'order_status' => $statusName,
                'order_date' => $order->created_at->format('Y-m-d'),
                'order_amount' => number_format($order->total, 2) . ' ' . config('app.currency'),
            ],
            $order
        );
    }

    /**
     * إرسال إشعار تسليم المنتج الرقمي
     * 
     * @param Order $order الطلب
     * @param string $phone رقم الهاتف
     * @param array $digitalCodes الأكواد الرقمية
     * @return array
     */
    public function sendDigitalProductDelivery(Order $order, $phone, $digitalCodes): array
    {
        // تنسيق الأكواد الرقمية للرسالة
        $codesText = '';
        foreach ($digitalCodes as $index => $item) {
            $codesText .= ($index + 1) . ". {$item['product_name']}: {$item['code']}\n";
        }
        
        return $this->sendMessage(
            $phone,
            'digital_product_delivery',
            [
                'customer_name' => $order->user->name ?? 'العميل',
                'order_id' => $order->id,
                'delivery_date' => now()->format('Y-m-d'),
                'delivery_time' => now()->format('H:i'),
                'digital_codes' => $codesText,
                'order_url' => route('orders.show', $order->id)
            ],
            $order
        );
    }
    
    /**
     * إرسال إشعار تسليم الخدمة
     * 
     * @param Order $order الطلب
     * @param string $phone رقم الهاتف
     * @return array
     */
    public function sendServiceDelivery(Order $order, $phone): array
    {
        return $this->sendMessage(
            $phone,
            'service_activation',
            [
                'customer_name' => $order->user->name ?? 'العميل',
                'order_id' => $order->id,
                'delivery_date' => now()->format('Y-m-d'),
                'delivery_time' => now()->format('H:i'),
                'service_info' => 'تم تنشيط الخدمة وهي الآن متاحة في حسابك',
                'order_url' => route('orders.show', $order->id)
            ],
            $order
        );
    }
    
    /**
     * إرسال إشعار تسليم المنتج المادي
     * 
     * @param Order $order الطلب
     * @param string $phone رقم الهاتف
     * @return array
     */
    public function sendPhysicalProductDelivery(Order $order, $phone): array
    {
        return $this->sendMessage(
            $phone,
            'delivery',
            [
                'customer_name' => $order->user->name ?? 'العميل',
                'order_id' => $order->id,
                'delivery_date' => now()->format('Y-m-d'),
                'delivery_time' => now()->format('H:i'),
                'tracking_info' => $order->tracking_number ? "رقم التتبع: {$order->tracking_number}" : "سيتم إرسال تفاصيل الشحن قريباً",
                'order_url' => route('orders.show', $order->id)
            ],
            $order
        );
    }

    /**
     * إرسال إشعار تسليم عام
     * 
     * @param Order $order الطلب
     * @param string $phone رقم الهاتف
     * @return array
     */
    public function sendGenericDelivery(Order $order, $phone): array
    {
        return $this->sendMessage(
            $phone,
            'delivery',
            [
                'customer_name' => $order->user->name ?? 'العميل',
                'order_id' => $order->id,
                'delivery_date' => now()->format('Y-m-d'),
                'delivery_time' => now()->format('H:i'),
                'order_url' => route('orders.show', $order->id)
            ],
            $order
        );
    }

    /**
     * تحديث طريقة sendDeliveryNotification لتتعامل مع أنواع مختلفة من المنتجات
     * 
     * @param Order $order الطلب
     * @return array
     */
    public function sendDeliveryNotification(Order $order): array
    {
        // الحصول على رقم هاتف العميل
        $phone = $order->customer_phone ?? $order->user->phone ?? null;
        
        if (!$phone) {
            Log::error('واتساب: تعذر إرسال إشعار التسليم، رقم الهاتف غير متوفر', ['order_id' => $order->id]);
            return ['status' => 'error', 'message' => 'رقم الهاتف غير متوفر'];
        }
        
        $orderItems = $order->items;
        $productTypes = [];
        $digitalCodes = [];
        
        // التحقق من أنواع المنتجات في الطلب
        foreach ($orderItems as $item) {
            $product = $item->product;
            $productTypes[$product->type] = true;
            
            // للمنتجات الرقمية، جمع الأكواد
            if ($product->type === 'digital' && isset($item->digital_code)) {
                $digitalCodes[] = [
                    'product_name' => $product->name,
                    'code' => $item->digital_code
                ];
            }
        }
        
        // اختيار القالب بناءً على أنواع المنتجات في الطلب
        if (count($productTypes) === 1) {
            // نوع واحد من المنتجات في الطلب
            if (isset($productTypes['digital'])) {
                return $this->sendDigitalProductDelivery($order, $phone, $digitalCodes);
            } elseif (isset($productTypes['service'])) {
                return $this->sendServiceDelivery($order, $phone);
            } elseif (isset($productTypes['physical'])) {
                return $this->sendPhysicalProductDelivery($order, $phone);
            }
        } else {
            // أنواع مختلطة - استخدام قالب تسليم عام
            return $this->sendGenericDelivery($order, $phone);
        }
        
        return ['status' => 'error', 'message' => 'لم يتم العثور على نوع منتج صالح'];
    }

    /**
     * إرسال رمز تسجيل الدخول
     *
     * @param string $phone رقم الهاتف
     * @param string $code رمز التسجيل
     * @return array
     */
    public function sendLoginCode($phone, $code): array
    {
        return $this->sendMessage(
            $phone,
            'login',
            [
                'code' => $code,
                'app_name' => config('app.name'),
                'valid_time' => '5 دقائق',
            ]
        );
    }

    /**
     * تنسيق رقم الهاتف (إزالة الرمز + وإضافة 966 إذا لزم الأمر)
     */
    protected function formatPhone($phone): string
    {
        // إزالة أي مسافات
        $phone = str_replace(' ', '', $phone);
        
        // إزالة الرمز + إذا وجد
        if (str_starts_with($phone, '+')) {
            $phone = substr($phone, 1);
        }
        
        // التأكد من أن الرقم يبدأ بـ 966 (أو رمز الدولة المناسب)
        if (!str_starts_with($phone, '')) {
            // إذا بدأ بصفر، إزالته وإضافة 966
            if (str_starts_with($phone, '0')) {
                $phone = '' . substr($phone, 1);
            } else {
                // إذا لم يبدأ بصفر، إضافة 966 مباشرة
                $phone = '' . $phone;
            }
        }
        
        return $phone;
    }

    /**
     * اختبار الاتصال بـ API للتحقق من صحة الإعدادات
     *
     * @return array حالة الاختبار
     */
    public function testApiConnection(): array
    {
        try {
            // جمع معلومات الإعدادات
            $configInfo = [
                'api_key' => $this->apiKey ? substr($this->apiKey, 0, 4) . '****' : 'غير محدد',
                'instance_id' => $this->instanceId ? substr($this->instanceId, 0, 4) . '****' : 'غير محدد',
                'base_url' => $this->baseUrl,
                'notifications_enabled' => config('whatsapp.enable_notifications', true) ? 'مفعلة' : 'غير مفعلة',
            ];

            // إذا كانت المعرفات غير محددة
            if (empty($this->apiKey) || empty($this->instanceId)) {
                return [
                    'status' => 'error',
                    'message' => 'معرفات الـ API غير مكتملة، يرجى التحقق من الإعدادات',
                    'config' => $configInfo,
                ];
            }

            // إجراء طلب اختبار بسيط للتحقق من الاتصال
            $testData = [
                'number' => '966500000000', // رقم اختبار
                'type' => 'text',
                'message' => 'اختبار اتصال API - يرجى تجاهل هذه الرسالة',
                'instance_id' => $this->instanceId,
                'access_token' => $this->apiKey
            ];

            // إرسال طلب الاختبار
            $response = Http::timeout(10)->post($this->baseUrl, $testData);
            
            // تحليل الاستجابة
            if ($response->successful()) {
                return [
                    'status' => 'success',
                    'message' => 'تم الاتصال بنجاح بـ API',
                    'response' => $response->json(),
                    'config' => $configInfo,
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'فشل الاتصال بـ API: ' . $response->body(),
                    'config' => $configInfo,
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'خطأ أثناء الاتصال بـ API: ' . $e->getMessage(),
                'config' => $configInfo ?? [],
            ];
        }
    }
} 