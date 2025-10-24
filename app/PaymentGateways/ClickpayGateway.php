<?php

namespace App\PaymentGateways;

use App\Models\Order;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ClickpayGateway extends BaseGateway
{
    /**
     * عناوين API الثابتة
     * 
     * @var array
     */
    protected $apiEndpoints = [
        'payment_request' => 'https://secure.clickpay.com.sa/payment/request',
        'payment_query' => 'https://secure.clickpay.com.sa/payment/query',
    ];
    
    /**
     * الحصول على حقول الإعدادات اللازمة في لوحة التحكم
     * 
     * @return array
     */
    public function getConfigFields(): array
    {
        return [
            'profile_id' => [
                'name' => 'profile_id',
                'label' => 'معرف الملف الشخصي',
                'type' => 'text',
                'required' => true,
            ],
            'server_key' => [
                'name' => 'server_key',
                'label' => 'مفتاح الخادم (Server Key)',
                'type' => 'password',
                'required' => true,
            ],
            'currency' => [
                'name' => 'currency',
                'label' => 'العملة الافتراضية',
                'type' => 'select',
                'options' => [
                    'SAR' => 'ريال سعودي (SAR)',
                    'USD' => 'دولار أمريكي (USD)',
                    'AED' => 'درهم إماراتي (AED)',
                    'KWD' => 'دينار كويتي (KWD)',
                    'BHD' => 'دينار بحريني (BHD)',
                ],
                'default' => 'SAR',
                'required' => true,
            ],
            'tran_type' => [
                'name' => 'tran_type',
                'label' => 'نوع المعاملة',
                'type' => 'select',
                'options' => [
                    'sale' => 'بيع (Sale)',
                    'auth' => 'مصادقة (Auth)',
                ],
                'default' => 'sale',
                'required' => true,
            ],
            'tran_class' => [
                'name' => 'tran_class',
                'label' => 'تصنيف المعاملة',
                'type' => 'select',
                'options' => [
                    'ecom' => 'تجارة إلكترونية (ecom)',
                    'moto' => 'طلب عبر الهاتف (moto)',
                    'cont' => 'متكرر (cont)',
                ],
                'default' => 'ecom',
                'required' => true,
            ],
        ];
    }
    
    /**
     * الحصول على مفتاح الخادم
     * 
     * @return string
     */
    protected function getServerKey(): string
    {
        return $this->credentials['server_key'] ?? '';
    }
    
    /**
     * الحصول على معرف الملف الشخصي
     * 
     * @return string
     */
    protected function getProfileId(): string
    {
        return $this->credentials['profile_id'] ?? '';
    }
    
    /**
     * معالجة عملية الدفع
     * 
     * @param Order $order الطلب
     * @return array
     */
    public function processPayment($order): array
    {
        $client = new Client();
        
        // إعداد رابط الاستجابة ورابط العودة
        $callbackUrl = route('payment.callback.success', [
            'order_id' => $order->id,
            'token' => $order->order_token
        ]);
        
        $returnUrl = route('payment.callback.cancel', [
            'order_id' => $order->id,
            'token' => $order->order_token
        ]);
        
        // تسجيل روابط إعادة التوجيه للتشخيص
        Log::info('روابط إعادة التوجيه لبوابة كليك باي', [
            'callback_url' => $callbackUrl,
            'return_url' => $returnUrl,
            'order_id' => $order->id
        ]);
        
        // الحصول على العملة من الإعدادات أو استخدام العملة الافتراضية
        $currency = $this->settings['currency'] ?? 'SAR';
        
        // إعداد بيانات الطلب
        $payload = [
            'profile_id' => $this->getProfileId(),
            'tran_type' => $this->settings['tran_type'] ?? 'sale',
            'tran_class' => $this->settings['tran_class'] ?? 'ecom',
            'cart_id' => (string) $order->id,
            'cart_description' => "طلب #{$order->id} - " . config('app.name'),
            'cart_currency' => $currency,
            'cart_amount' => number_format((float)$order->total, 2, '.', ''),
            'callback' => $callbackUrl,
            'return' => $returnUrl,
            'hide_shipping' => true, // إخفاء معلومات الشحن
        ];
        
        // تسجيل البيانات المرسلة لبوابة الدفع
        Log::info('البيانات المرسلة إلى بوابة كليك باي', [
            'payload' => $payload,
            'credentials' => [
                'profile_id' => $this->getProfileId(),
                'server_key_length' => strlen($this->getServerKey()),
            ],
            'api_endpoint' => $this->apiEndpoints['payment_request']
        ]);
        
        // إضافة بيانات العميل إذا كانت متوفرة
        if ($order->customer_name) {
            $payload['customer_details'] = [
                'name' => $order->customer_name,
                'email' => $order->customer_email ?? '',
                'phone' => $order->customer_phone ?? '',
            ];
        } elseif (auth()->check()) {
            // استخدام بيانات المستخدم المسجل دخول إذا لم تكن بيانات العميل متوفرة
            $user = auth()->user();
            $payload['customer_details'] = [
                'name' => $user->name,
                'email' => $user->email ?? '',
                'phone' => $user->phone ?? '',
            ];
        }
        
        try {
            $response = $client->post($this->apiEndpoints['payment_request'], [
                'headers' => [
                    'Authorization' => $this->getServerKey(),
                    'Content-Type' => 'application/json',
                ],
                'json' => $payload,
                'timeout' => 30,
                'connect_timeout' => 30
            ]);
            
            $result = json_decode($response->getBody(), true);
            
            // تسجيل الاستجابة الكاملة للتشخيص
            Log::info('الاستجابة الكاملة من كليك باي', [
                'order_id' => $order->id,
                'response' => $result,
            ]);
            
            // التحقق من وجود أخطاء في الاستجابة
            if (isset($result['code']) && $result['code'] !== 200) {
                Log::error('خطأ في استجابة كليك باي', [
                    'order_id' => $order->id,
                    'error_code' => $result['code'],
                    'error_message' => $result['message'] ?? 'لا توجد رسالة خطأ',
                ]);
                
                return $this->formatResponse([
                    'success' => false,
                    'message' => 'خطأ من بوابة الدفع: ' . ($result['message'] ?? 'خطأ غير معروف'),
                    'raw_response' => $result,
                ]);
            }
            
            // التعامل مع استجابة إعادة التوجيه
            if (isset($result['redirect_url']) && !empty($result['redirect_url'])) {
                Log::info('تم استلام رابط إعادة التوجيه من كليك باي', [
                    'order_id' => $order->id,
                    'redirect_url' => $result['redirect_url'],
                ]);
                
                // التحقق من صحة الرابط قبل إرساله
                if (filter_var($result['redirect_url'], FILTER_VALIDATE_URL) === false) {
                    Log::error('رابط إعادة التوجيه من كليك باي غير صالح', [
                        'redirect_url' => $result['redirect_url']
                    ]);
                    
                    return $this->formatResponse([
                        'success' => false,
                        'message' => 'تم استلام رابط توجيه غير صالح من بوابة الدفع',
                        'raw_response' => $result,
                    ]);
                }
                
                // استخدام دالة formatResponse مع تضمين رابط إعادة التوجيه بشكل صريح
                return $this->formatResponse([
                    'success' => true,
                    'transaction_id' => $result['tran_ref'] ?? null,
                    'redirect_url' => $result['redirect_url'],
                    'message' => 'تم إنشاء طلب الدفع بنجاح، سيتم تحويلك لصفحة الدفع',
                    'raw_response' => $result,
                ]);
            }
            
            // التعامل مع استجابة النتيجة المباشرة
            if (isset($result['payment_result']) && $result['payment_result']['response_status'] === 'A') {
                return $this->formatResponse([
                    'success' => true,
                    'transaction_id' => $result['tran_ref'] ?? null,
                    'message' => $result['payment_result']['response_message'] ?? 'تمت العملية بنجاح',
                    'raw_response' => $result,
                ]);
            }
            
            // في حالة عدم وجود بيانات نجاح واضحة، نعتبرها فاشلة
            Log::warning('لم يتم العثور على رابط إعادة التوجيه في استجابة كليك باي', [
                'order_id' => $order->id,
                'response' => $result,
            ]);
            
            return $this->formatResponse([
                'success' => false,
                'message' => $result['message'] ?? 'فشل إنشاء طلب الدفع: لم يتم استلام رابط إعادة التوجيه',
                'raw_response' => $result,
            ]);
            
        } catch (\Exception $e) {
            Log::error('Clickpay payment processing error', [
                'error' => $e->getMessage(),
                'order_id' => $order->id,
                'trace' => $e->getTraceAsString(),
            ]);
            
            return $this->formatResponse([
                'success' => false,
                'message' => 'حدث خطأ أثناء معالجة الدفع: ' . $e->getMessage(),
            ]);
        }
    }
    
    /**
     * التحقق من عملية الدفع
     * 
     * @param array $data بيانات الاستجابة
     * @return bool
     */
    public function verifyPayment(array $data): bool
    {
        // تسجيل كامل البيانات الواردة من بوابة الدفع
        Log::info('بيانات التحقق من الدفع ClickPay', [
            'callback_data' => $data,
            'server_key' => substr($this->getServerKey(), 0, 5) . '...' . substr($this->getServerKey(), -5),
            'profile_id' => $this->getProfileId()
        ]);
        
        // التحقق من وجود طلب استعلام مباشر
        $isDirectQuery = isset($data['direct_query']) && $data['direct_query'] === true;
        $orderId = $data['order_id'] ?? $data['cartId'] ?? null;
        
        // استخدام tranRef (المعامل الصحيح من API) أو tran_ref (الاسم المستخدم داخلياً)
        $transactionRef = $data['tranRef'] ?? $data['tran_ref'] ?? null;
        
        if ($isDirectQuery) {
            Log::info('تم استلام طلب استعلام مباشر عن حالة الطلب', [
                'order_id' => $orderId,
            ]);
            
            // البحث عن معرف المعاملة في جدول المدفوعات
            $payment = \App\Models\Payment::where('order_id', $orderId)
                ->orderBy('created_at', 'desc')
                ->first();
            
            if ($payment && $payment->payment_id) {
                $transactionRef = $payment->payment_id;
                Log::info('تم العثور على معرف المعاملة من المدفوعات السابقة', [
                    'transaction_id' => $transactionRef,
                    'order_id' => $orderId
                ]);
            } else {
                Log::warning('لم يتم العثور على معرف معاملة للطلب', [
                    'order_id' => $orderId
                ]);
                return false;
            }
        }
        
        // فحص وجود معرف المعاملة
        if (!$transactionRef) {
            Log::warning('معرف المعاملة غير موجود في بيانات الاستجابة', $data);
            return false;
        }
        
        // التحقق من respStatus أولاً (مباشرة من البيانات المستلمة) إذا كان متاحاً
        if (!$isDirectQuery) {
            $respStatus = $data['respStatus'] ?? $data['response_status'] ?? null;
            
            if ($respStatus) {
                Log::info('وجدت respStatus في بيانات الاستجابة', [
                    'respStatus' => $respStatus,
                    'tran_ref' => $transactionRef
                ]);
                
                // فقط الحالة 'A' تعني نجاح الدفع
                if ($respStatus === 'A') {
                    Log::info('عملية دفع ناجحة وفقًا لـ respStatus', [
                        'tran_ref' => $transactionRef,
                        'respStatus' => $respStatus
                    ]);
                    return true;
                } 
                // لأي حالة أخرى ('C', 'D', 'E' إلخ)
                else {
                    Log::warning('حالة الدفع غير ناجحة وفقًا لـ respStatus', [
                        'tran_ref' => $transactionRef,
                        'respStatus' => $respStatus,
                        'description' => $this->getStatusDescription($respStatus)
                    ]);
                    return false;
                }
            }
        }
        
        // محاولة طلب أكثر من مرة إلى بوابة الدفع في حالة حدوث خطأ
        $maxAttempts = 2;
        $attempt = 0;
        $lastError = null;
        
        while ($attempt < $maxAttempts) {
            try {
                $attempt++;
                // الاستعلام عن حالة المعاملة من بوابة الدفع
                $client = new Client([
                    'verify' => false // لأغراض التطوير فقط
                ]);
                
                $requestData = [
                    'profile_id' => $this->getProfileId(),
                    'tran_ref' => $transactionRef,
                ];
                
                // تسجيل بيانات الاستعلام
                Log::info('إرسال استعلام عن حالة الدفع لكليك باي', [
                    'attempt' => $attempt,
                    'request_data' => $requestData,
                    'tran_ref' => $transactionRef
                ]);
                
                $response = $client->post($this->apiEndpoints['payment_query'], [
                    'headers' => [
                        'Authorization' => $this->getServerKey(),
                        'Content-Type' => 'application/json',
                    ],
                    'json' => $requestData,
                    'timeout' => 30,
                    'connect_timeout' => 30
                ]);
                
                $result = json_decode($response->getBody(), true);
                
                // تسجيل استجابة الاستعلام
                Log::info('استجابة استعلام كليك باي الكاملة', [
                    'tran_ref' => $transactionRef,
                    'response' => $result,
                ]);
                
                // التحقق من استجابة الاستعلام
                if (isset($result['payment_result']) && isset($result['payment_result']['response_status'])) {
                    $status = $result['payment_result']['response_status'];
                    
                    Log::info('حالة الدفع المستلمة من الاستعلام', [
                        'tran_ref' => $transactionRef,
                        'status' => $status,
                        'description' => $this->getStatusDescription($status)
                    ]);
                    
                    // فقط A تعني نجاح العملية
                    if ($status === 'A') {
                        return true;
                    } 
                    // لأي حالة أخرى ('C', 'D', 'E' إلخ)
                    else {
                        Log::warning('عملية الدفع فاشلة بناءً على الاستعلام', [
                            'tran_ref' => $transactionRef,
                            'status' => $status,
                            'description' => $this->getStatusDescription($status)
                        ]);
                        return false;
                    }
                }
                
                // إذا لم نجد حالة محددة في الاستجابة، نحاول التحقق من كود الاستجابة
                if (isset($result['code']) && $result['code'] == 200) {
                    // عدم وجود حالة واضحة مع كود 200 يعتبر نجاح
                    Log::info('تم اعتبار العملية ناجحة بناءً على كود الاستجابة 200', [
                        'tran_ref' => $transactionRef,
                        'result' => $result
                    ]);
                    return true;
                }
                
                // إذا لم نستطع العثور على حالة واضحة، نعتبر العملية فاشلة
                Log::warning('لم يتم العثور على حالة واضحة في استجابة الاستعلام', [
                    'tran_ref' => $transactionRef,
                    'result' => $result
                ]);
                
                return false;
                
            } catch (\Exception $e) {
                $lastError = $e;
                Log::error('خطأ في استعلام حالة الدفع من كليك باي - محاولة ' . $attempt, [
                    'error' => $e->getMessage(),
                    'tran_ref' => $transactionRef,
                ]);
                
                if ($attempt < $maxAttempts) {
                    // انتظار قليلاً قبل المحاولة مرة أخرى
                    sleep(2);
                }
            }
        }
        
        // في حالة فشل جميع المحاولات
        Log::error('فشلت جميع محاولات الاستعلام عن حالة الدفع', [
            'tran_ref' => $transactionRef,
            'order_id' => $orderId,
            'last_error' => $lastError ? $lastError->getMessage() : null
        ]);
        
        return false;
    }
    
    /**
     * الحصول على وصف الحالة من رمزها
     * 
     * @param string $status رمز الحالة
     * @return string
     */
    protected function getStatusDescription(string $status): string
    {
        $statuses = [
            'A' => 'عملية دفع ناجحة (Authorized)',
            'D' => 'تم الرفض (Declined)',
            'E' => 'خطأ (Error)',
            'C' => 'ملغية (Cancelled)',
        ];
        
        return $statuses[$status] ?? "حالة غير معروفة: $status";
    }
    
    /**
     * التحقق من صحة توقيع الاستجابة
     * 
     * @param array $data بيانات الاستجابة
     * @return bool
     */
    protected function verifySignature(array $data): bool
    {
        // إذا لم يكن هناك توقيع، نفترض أن التحقق مطلوب فقط للمعاملة
        if (!isset($data['signature'])) {
            return true;
        }
        
        $receivedSignature = $data['signature'];
        
        // نسخة من البيانات بدون التوقيع
        $dataWithoutSignature = $data;
        unset($dataWithoutSignature['signature']);
        
        // ترتيب المفاتيح أبجدياً
        ksort($dataWithoutSignature);
        
        // إنشاء سلسلة استعلام URL مشفرة
        $queryString = http_build_query($dataWithoutSignature);
        
        // إنشاء التوقيع باستخدام HMAC-SHA256
        $calculatedSignature = hash_hmac('sha256', $queryString, $this->getServerKey());
        
        // مقارنة التوقيع المحسوب مع التوقيع المستلم
        return hash_equals($calculatedSignature, $receivedSignature);
    }
    
    /**
     * معالجة webhook من البوابة
     * 
     * @param array $data بيانات الإشعار
     * @return array
     */
    public function handleWebhook(array $data): array
    {
        // تسجيل كامل البيانات الواردة لتشخيص المشاكل
        Log::info('بيانات webhook من بوابة كليك باي', [
            'data' => $data
        ]);
        
        // التحقق من التوقيع أولاً
        if (!$this->verifySignature($data)) {
            return [
                'success' => false,
                'message' => 'فشل التحقق من التوقيع',
            ];
        }
        
        // استخدام tranRef (المعامل الصحيح من API) أو tran_ref (الاسم المستخدم داخلياً)
        $transactionRef = $data['tranRef'] ?? $data['tran_ref'] ?? null;
        $paymentResult = $data['payment_result'] ?? null;
        $cartId = $data['cartId'] ?? $data['cart_id'] ?? null;
        
        if (!$transactionRef && !$cartId) {
            return [
                'success' => false,
                'message' => 'بيانات غير كاملة - معرف المعاملة أو معرف السلة مفقود',
            ];
        }
        
        // البحث عن محاولة الدفع المرتبطة بهذه المعاملة
        $paymentQuery = \App\Models\Payment::query();
        
        if ($transactionRef) {
            $paymentQuery->where('payment_id', $transactionRef);
        } elseif ($cartId) {
            // استخدام معرف السلة (وهو معرف الطلب) إذا كان معرف المعاملة غير متوفر
            $paymentQuery->where('order_id', $cartId);
        }
        
        $payment = $paymentQuery->latest()->first();
        
        if (!$payment) {
            return [
                'success' => false,
                'message' => 'عملية دفع غير موجودة',
            ];
        }
        
        $order = \App\Models\Order::find($payment->order_id);
        
        if (!$order) {
            return [
                'success' => false,
                'message' => 'الطلب غير موجود',
            ];
        }
        
        // التحقق من حالة الدفع - يمكن أن تكون في respStatus أو في payment_result
        $status = $data['respStatus'] ?? ($paymentResult['response_status'] ?? '');
        
        Log::info('حالة الدفع الواردة من webhook', [
            'tran_ref' => $transactionRef,
            'status' => $status,
            'status_description' => $this->getStatusDescription($status),
            'payment_result' => $paymentResult
        ]);
        
        if ($status === 'A') { // فقط A تعني نجاح العملية
            // تحديث حالة الطلب
            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing',
                'paid_at' => now(),
            ]);
            
            // تحديث حالة عملية الدفع
            $payment->update([
                'payment_status' => 'completed',
                'payment_data' => array_merge($payment->payment_data ?? [], ['webhook_data' => $data]),
            ]);
            
            return [
                'success' => true,
                'message' => 'تم تحديث حالة الطلب بنجاح',
            ];
        }
        
        return [
            'success' => false,
            'message' => 'حالة الدفع غير مكتملة: ' . ($paymentResult['response_message'] ?? 'غير معروف'),
        ];
    }
}
