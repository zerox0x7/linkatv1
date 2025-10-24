<?php

namespace App\PaymentGateways;

use App\Models\Order;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class PaylinkGateway extends BaseGateway
{
    /**
     * عناوين API الثابتة
     * 
     * @var array
     */
    protected $apiEndpoints = [
        'live' => 'https://restpilot.paylink.sa',
        'test' => 'https://restpilot.paylink.sa', // Paylink تستخدم نفس الرابط للتجريبي والحي
    ];
    
    /**
     * الحصول على حقول الإعدادات اللازمة في لوحة التحكم
     * 
     * @return array
     */
    public function getConfigFields(): array
    {
        return [
            'api_id' => [
                'name' => 'api_id',
                'label' => 'معرف API (API ID)',
                'type' => 'text',
                'required' => true,
            ],
            'secret_key' => [
                'name' => 'secret_key',
                'label' => 'المفتاح السري (Secret Key)',
                'type' => 'password',
                'required' => true,
            ],
            'mode' => [
                'name' => 'mode',
                'label' => 'وضع التشغيل',
                'type' => 'select',
                'options' => [
                    'test' => 'تجريبي (Test)',
                    'live' => 'حي (Live)',
                ],
                'default' => 'test',
                'required' => true,
            ],
        ];
    }
    
    /**
     * الحصول على معرف API
     * 
     * @return string
     */
    protected function getApiId(): string
    {
        return $this->credentials['api_id'] ?? '';
    }
    
    /**
     * الحصول على المفتاح السري
     * 
     * @return string
     */
    protected function getSecretKey(): string
    {
        return $this->credentials['secret_key'] ?? '';
    }
    
    /**
     * الحصول على رابط API الأساسي
     * 
     * @return string
     */
    protected function getBaseUrl(): string
    {
        return $this->apiEndpoints[$this->mode] ?? $this->apiEndpoints['test'];
    }
    
    /**
     * الحصول على id_token من Paylink
     * 
     * @return string|null
     * @throws \Exception
     */
    protected function getAuthToken(): ?string
    {
        try {
            $client = new Client([
                'verify' => true,
                'timeout' => 30,
            ]);
            
            $response = $client->post($this->getBaseUrl() . '/api/auth', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'apiId' => $this->getApiId(),
                    'secretKey' => $this->getSecretKey(),
                    'persistToken' => false, // Token صالح لمدة 30 دقيقة
                ],
            ]);
            
            $result = json_decode($response->getBody(), true);
            
            Log::info('نجح الحصول على token من Paylink', [
                'has_token' => isset($result['id_token']),
                'api_id' => $this->getApiId(),
            ]);
            
            return $result['id_token'] ?? null;
            
        } catch (\Exception $e) {
            Log::error('فشل الحصول على token من Paylink', [
                'error' => $e->getMessage(),
                'api_id' => $this->getApiId(),
            ]);
            
            throw new \Exception('فشل المصادقة مع Paylink: ' . $e->getMessage());
        }
    }
    
    /**
     * معالجة عملية الدفع
     * 
     * @param Order $order الطلب
     * @return array
     */
    public function processPayment($order): array
    {
        $client = new Client([
            'verify' => true,
            'timeout' => 30,
        ]);
        
        // إعداد رابط الاستجابة ورابط العودة
        $callbackUrl = route('payment.callback.success', [
            'order_id' => $order->id,
            'token' => $order->order_token ?? $order->order_number
        ]);
        
        $cancelUrl = route('payment.callback.cancel', [
            'order_id' => $order->id,
            'token' => $order->order_token ?? $order->order_number
        ]);
        
        // تسجيل روابط إعادة التوجيه للتشخيص
        Log::info('روابط إعادة التوجيه لبوابة Paylink', [
            'callback_url' => $callbackUrl,
            'cancel_url' => $cancelUrl,
            'order_id' => $order->id
        ]);
        
        // الحصول على بيانات العميل
        $user = auth()->user();
        $customerName = $order->customer_name ?? $user->name ?? 'عميل';
        $customerEmail = $order->customer_email ?? $user->email ?? '';
        $customerMobile = $order->customer_phone ?? $user->phone ?? '';
        
        // إعداد بيانات الفاتورة
        $payload = [
            'amount' => (float) $order->total,
            'callBackUrl' => $callbackUrl,
            'cancelUrl' => $cancelUrl,
            'clientEmail' => $customerEmail,
            'clientMobile' => $customerMobile,
            'clientName' => $customerName,
            'note' => "طلب رقم: {$order->order_number}",
            'orderNumber' => $order->order_number,
            'products' => $this->prepareProducts($order),
            'supportedCardBrands' => ['mada', 'visaMastercard', 'amex'],
            'displayPending' => true,
        ];
        
        // تسجيل البيانات المرسلة لبوابة الدفع
        Log::info('البيانات المرسلة إلى بوابة Paylink', [
            'payload' => $payload,
            'api_id' => $this->getApiId(),
            'secret_key_length' => strlen($this->getSecretKey()),
            'base_url' => $this->getBaseUrl()
        ]);
        
        try {
            // الحصول على id_token أولاً
            $authToken = $this->getAuthToken();
            
            if (!$authToken) {
                return $this->formatResponse([
                    'success' => false,
                    'message' => 'فشل الحصول على توكن المصادقة من Paylink',
                ]);
            }
            
            $response = $client->post($this->getBaseUrl() . '/api/addInvoice', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authToken,
                ],
                'json' => $payload,
            ]);
            
            $result = json_decode($response->getBody(), true);
            
            // تسجيل الاستجابة الكاملة للتشخيص
            Log::info('الاستجابة الكاملة من Paylink', [
                'order_id' => $order->id,
                'response' => $result,
            ]);
            
            // التحقق من نجاح الطلب
            if (isset($result['success']) && $result['success'] === false) {
                Log::error('خطأ في استجابة Paylink', [
                    'order_id' => $order->id,
                    'error' => $result['error'] ?? 'خطأ غير معروف',
                    'message' => $result['message'] ?? 'لا توجد رسالة خطأ',
                ]);
                
                return $this->formatResponse([
                    'success' => false,
                    'message' => 'خطأ من بوابة الدفع: ' . ($result['message'] ?? $result['error'] ?? 'خطأ غير معروف'),
                    'raw_response' => $result,
                ]);
            }
            
            // التحقق من وجود رابط الدفع
            if (isset($result['url']) && !empty($result['url'])) {
                Log::info('تم استلام رابط الدفع من Paylink', [
                    'order_id' => $order->id,
                    'payment_url' => $result['url'],
                    'transaction_no' => $result['transactionNo'] ?? null,
                ]);
                
                // التحقق من صحة الرابط
                if (filter_var($result['url'], FILTER_VALIDATE_URL) === false) {
                    Log::error('رابط الدفع من Paylink غير صالح', [
                        'url' => $result['url']
                    ]);
                    
                    return $this->formatResponse([
                        'success' => false,
                        'message' => 'تم استلام رابط دفع غير صالح من بوابة الدفع',
                        'raw_response' => $result,
                    ]);
                }
                
                // حفظ معلومات المعاملة
                if (isset($result['transactionNo'])) {
                    // تحديث سجل الدفع إذا كان موجوداً
                    $payment = \App\Models\Payment::where('order_id', $order->id)
                        ->latest()
                        ->first();
                    
                    if ($payment) {
                        $payment->update([
                            'payment_id' => $result['transactionNo'],
                        ]);
                    }
                }
                
                return $this->formatResponse([
                    'success' => true,
                    'transaction_id' => $result['transactionNo'] ?? null,
                    'redirect_url' => $result['url'],
                    'message' => 'تم إنشاء رابط الدفع بنجاح، سيتم تحويلك لصفحة الدفع',
                    'raw_response' => $result,
                ]);
            }
            
            // في حالة عدم وجود رابط دفع
            Log::warning('لم يتم العثور على رابط الدفع في استجابة Paylink', [
                'order_id' => $order->id,
                'response' => $result,
            ]);
            
            return $this->formatResponse([
                'success' => false,
                'message' => 'فشل إنشاء رابط الدفع: لم يتم استلام رابط الدفع من بوابة الدفع',
                'raw_response' => $result,
            ]);
            
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // خطأ 4xx من API
            $response = $e->getResponse();
            $body = json_decode($response->getBody(), true);
            
            Log::error('خطأ من Paylink API (4xx)', [
                'error' => $e->getMessage(),
                'order_id' => $order->id,
                'response_body' => $body,
                'status_code' => $response->getStatusCode(),
            ]);
            
            return $this->formatResponse([
                'success' => false,
                'message' => 'خطأ في بيانات الطلب: ' . ($body['message'] ?? $e->getMessage()),
                'raw_response' => $body,
            ]);
        } catch (\Exception $e) {
            Log::error('Paylink payment processing error', [
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
     * تحضير قائمة المنتجات للفاتورة
     * 
     * @param Order $order
     * @return array
     */
    protected function prepareProducts(Order $order): array
    {
        $products = [];
        
        foreach ($order->items as $item) {
            $products[] = [
                'title' => $item->name,
                'price' => (float) $item->price,
                'qty' => (int) $item->quantity,
                'description' => $item->name,
                'isDigital' => true, // معظم المنتجات رقمية
            ];
        }
        
        return $products;
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
        Log::info('بيانات التحقق من الدفع Paylink', [
            'callback_data' => $data,
        ]);
        
        // Paylink ترسل transactionNo في callback
        $transactionNo = $data['transactionNo'] ?? $data['transaction_no'] ?? null;
        $orderNumber = $data['orderNumber'] ?? $data['order_number'] ?? null;
        
        if (!$transactionNo) {
            Log::warning('معرف المعاملة غير موجود في بيانات الاستجابة', $data);
            return false;
        }
        
        try {
            // الحصول على id_token أولاً
            $authToken = $this->getAuthToken();
            
            if (!$authToken) {
                Log::error('فشل الحصول على token للتحقق من الدفع', [
                    'transaction_no' => $transactionNo,
                ]);
                return false;
            }
            
            // الاستعلام عن حالة الفاتورة من Paylink
            $client = new Client([
                'verify' => true,
                'timeout' => 30,
            ]);
            
            $response = $client->get($this->getBaseUrl() . '/api/getInvoice/' . $transactionNo, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $authToken,
                ],
            ]);
            
            $result = json_decode($response->getBody(), true);
            
            // تسجيل استجابة الاستعلام
            Log::info('استجابة استعلام Paylink الكاملة', [
                'transaction_no' => $transactionNo,
                'response' => $result,
            ]);
            
            // التحقق من حالة الدفع
            // orderStatus: Paid = تم الدفع, Pending = معلق, Canceled = ملغى
            if (isset($result['orderStatus']) && $result['orderStatus'] === 'Paid') {
                Log::info('عملية دفع ناجحة من Paylink', [
                    'transaction_no' => $transactionNo,
                    'order_status' => $result['orderStatus'],
                    'amount' => $result['amount'] ?? null,
                ]);
                return true;
            } else {
                Log::warning('حالة الدفع غير مكتملة من Paylink', [
                    'transaction_no' => $transactionNo,
                    'order_status' => $result['orderStatus'] ?? 'غير معروف',
                ]);
                return false;
            }
            
        } catch (\Exception $e) {
            Log::error('خطأ في التحقق من الدفع من Paylink', [
                'error' => $e->getMessage(),
                'transaction_no' => $transactionNo,
            ]);
            
            return false;
        }
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
        Log::info('بيانات webhook من بوابة Paylink', [
            'data' => $data
        ]);
        
        $transactionNo = $data['transactionNo'] ?? $data['transaction_no'] ?? null;
        $orderNumber = $data['orderNumber'] ?? $data['order_number'] ?? null;
        $orderStatus = $data['orderStatus'] ?? $data['order_status'] ?? null;
        
        if (!$transactionNo || !$orderNumber) {
            return [
                'success' => false,
                'message' => 'بيانات غير كاملة',
            ];
        }
        
        // البحث عن الطلب
        $order = \App\Models\Order::where('order_number', $orderNumber)->first();
        
        if (!$order) {
            return [
                'success' => false,
                'message' => 'الطلب غير موجود',
            ];
        }
        
        // التحقق من حالة الدفع
        if ($orderStatus === 'Paid') {
            // تحديث حالة الطلب
            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing',
                'paid_at' => now(),
            ]);
            
            // تحديث سجل الدفع
            $payment = \App\Models\Payment::where('order_id', $order->id)
                ->latest()
                ->first();
            
            if ($payment) {
                $payment->update([
                    'payment_status' => 'completed',
                    'payment_id' => $transactionNo,
                    'payment_data' => array_merge($payment->payment_data ?? [], ['webhook_data' => $data]),
                ]);
            }
            
            return [
                'success' => true,
                'message' => 'تم تحديث حالة الطلب بنجاح',
            ];
        }
        
        return [
            'success' => false,
            'message' => 'حالة الدفع غير مكتملة',
        ];
    }
}

