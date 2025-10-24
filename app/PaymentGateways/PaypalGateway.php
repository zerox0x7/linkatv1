<?php

namespace App\PaymentGateways;

use App\Models\Order;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class PaypalGateway extends BaseGateway
{
    /**
     * عناوين API الثابتة
     * 
     * @var array
     */
    protected $apiEndpoints = [
        'test' => [
            'base' => 'https://api-m.sandbox.paypal.com',
            'oauth' => '/v1/oauth2/token',
            'orders' => '/v2/checkout/orders',
        ],
        'live' => [
            'base' => 'https://api-m.paypal.com',
            'oauth' => '/v1/oauth2/token',
            'orders' => '/v2/checkout/orders',
        ],
    ];
    
    /**
     * الحصول على حقول الإعدادات اللازمة في لوحة التحكم
     * 
     * @return array
     */
    public function getConfigFields(): array
    {
        return [
            'test_client_id' => [
                'name' => 'test_client_id',
                'label' => 'معرف العميل (Client ID) للاختبار',
                'type' => 'text',
                'required' => true,
                'mode' => 'test',
            ],
            'test_client_secret' => [
                'name' => 'test_client_secret',
                'label' => 'كلمة السر (Client Secret) للاختبار',
                'type' => 'password',
                'required' => true,
                'mode' => 'test',
            ],
            'live_client_id' => [
                'name' => 'live_client_id',
                'label' => 'معرف العميل (Client ID) للإنتاج',
                'type' => 'text',
                'required' => true,
                'mode' => 'live',
            ],
            'live_client_secret' => [
                'name' => 'live_client_secret',
                'label' => 'كلمة السر (Client Secret) للإنتاج',
                'type' => 'password',
                'required' => true,
                'mode' => 'live',
            ],
            'currency' => [
                'name' => 'currency',
                'label' => 'العملة الافتراضية',
                'type' => 'select',
                'options' => ['USD', 'EUR', 'GBP', 'SAR'],
                'default' => 'USD',
            ],
            'auto_convert' => [
                'name' => 'auto_convert',
                'label' => 'تحويل العملة تلقائياً',
                'type' => 'checkbox',
                'default' => true,
            ],
            'checkout_style' => [
                'name' => 'checkout_style',
                'label' => 'أسلوب الدفع',
                'type' => 'select',
                'options' => [
                    'redirect' => 'إعادة توجيه للدفع',
                    'inline' => 'دفع مضمن',
                ],
                'default' => 'redirect',
            ],
        ];
    }
    
    /**
     * الحصول على رمز الوصول لـ PayPal
     * 
     * @return string
     * @throws \Exception
     */
    protected function getAccessToken(): string
    {
        $clientId = $this->credentials['client_id'] ?? null;
        $clientSecret = $this->credentials['client_secret'] ?? null;
        
        if (!$clientId || !$clientSecret) {
            throw new \Exception('بيانات الاعتماد غير كاملة لـ PayPal');
        }
        
        $endpoint = $this->apiEndpoints[$this->mode]['base'] . $this->apiEndpoints[$this->mode]['oauth'];
        
        try {
            $client = new Client();
            $response = $client->post($endpoint, [
                'auth' => [$clientId, $clientSecret],
                'form_params' => ['grant_type' => 'client_credentials'],
            ]);
            
            $data = json_decode($response->getBody(), true);
            
            return $data['access_token'] ?? '';
        } catch (GuzzleException $e) {
            throw new \Exception('فشل الاتصال بـ PayPal: ' . $e->getMessage());
        }
    }
    
    /**
     * معالجة عملية الدفع
     * 
     * @param \App\Models\Order $order الطلب
     * @return array استجابة عملية الدفع
     * @throws \Exception
     */
    public function processPayment($order): array
    {
        $accessToken = $this->getAccessToken();
        $endpoint = $this->apiEndpoints[$this->mode]['base'] . $this->apiEndpoints[$this->mode]['orders'];
        
        $orderCurrency = $this->settings['currency'] ?? 'USD';
        $orderAmount = $order->total;
        
        // تحويل العملة إذا كان مطلوباً
        if (($this->settings['auto_convert'] ?? false) && $order->currency != $orderCurrency) {
            $orderAmount = $this->convertCurrency($orderAmount, $order->currency, $orderCurrency);
        }
        
        // إعداد طلب الدفع لـ PayPal
        $payload = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'reference_id' => $order->id,
                    'description' => "Order #{$order->id}",
                    'amount' => [
                        'currency_code' => $orderCurrency,
                        'value' => number_format($orderAmount, 2, '.', ''),
                    ],
                ],
            ],
            'application_context' => [
                'brand_name' => config('app.name'),
                'locale' => app()->getLocale(),
                'landing_page' => 'BILLING',
                'shipping_preference' => 'NO_SHIPPING',
                'user_action' => 'PAY_NOW',
                'return_url' => route('payment.paypal.success', ['order_id' => $order->id]),
                'cancel_url' => route('payment.paypal.cancel', ['order_id' => $order->id]),
            ],
        ];
        
        try {
            $client = new Client();
            $response = $client->post($endpoint, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => "Bearer {$accessToken}",
                ],
                'json' => $payload,
            ]);
            
            $result = json_decode($response->getBody(), true);
            
            // معالجة الاستجابة
            if (isset($result['id'])) {
                $approvalLink = '';
                
                // البحث عن رابط الموافقة
                foreach ($result['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        $approvalLink = $link['href'];
                        break;
                    }
                }
                
                return $this->formatResponse([
                    'success' => true,
                    'reference_id' => $order->id,
                    'transaction_id' => $result['id'],
                    'redirect_url' => $approvalLink,
                    'message' => 'تم إنشاء الطلب بنجاح، يرجى متابعة عملية الدفع',
                    'raw_response' => $result,
                ]);
            }
            
            return $this->formatResponse([
                'success' => false,
                'message' => 'فشل إنشاء الطلب في PayPal',
                'raw_response' => $result,
            ]);
        } catch (GuzzleException $e) {
            return $this->formatResponse([
                'success' => false,
                'message' => 'فشل الاتصال بـ PayPal: ' . $e->getMessage(),
            ]);
        }
    }
    
    /**
     * التحقق من عملية الدفع
     * 
     * @param array $data بيانات استجابة البوابة
     * @return bool
     * @throws \Exception
     */
    public function verifyPayment(array $data): bool
    {
        $accessToken = $this->getAccessToken();
        $paypalOrderId = $data['paypal_order_id'] ?? null;
        
        if (!$paypalOrderId) {
            return false;
        }
        
        $endpoint = $this->apiEndpoints[$this->mode]['base'] . $this->apiEndpoints[$this->mode]['orders'] . '/' . $paypalOrderId;
        
        try {
            $client = new Client();
            $response = $client->get($endpoint, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => "Bearer {$accessToken}",
                ],
            ]);
            
            $result = json_decode($response->getBody(), true);
            
            // التحقق من حالة الطلب
            if (isset($result['status']) && $result['status'] === 'COMPLETED') {
                return true;
            }
            
            // يمكن هنا إضافة منطق للتعامل مع الحالات الأخرى مثل APPROVED
            if (isset($result['status']) && $result['status'] === 'APPROVED') {
                // إتمام المعاملة
                $captureResponse = $this->capturePayment($paypalOrderId, $accessToken);
                return isset($captureResponse['status']) && $captureResponse['status'] === 'COMPLETED';
            }
            
            return false;
        } catch (GuzzleException $e) {
            throw new \Exception('فشل التحقق من الدفع: ' . $e->getMessage());
        }
    }
    
    /**
     * إتمام عملية الدفع (Capture)
     * 
     * @param string $orderId معرف الطلب في PayPal
     * @param string $accessToken رمز الوصول
     * @return array
     * @throws \Exception
     */
    protected function capturePayment(string $orderId, string $accessToken): array
    {
        $endpoint = $this->apiEndpoints[$this->mode]['base'] . $this->apiEndpoints[$this->mode]['orders'] . '/' . $orderId . '/capture';
        
        try {
            $client = new Client();
            $response = $client->post($endpoint, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => "Bearer {$accessToken}",
                ],
            ]);
            
            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            throw new \Exception('فشل إتمام الدفع: ' . $e->getMessage());
        }
    }
    
    /**
     * التعامل مع webhook الخاص بالبوابة
     * 
     * @param array $data البيانات المستلمة
     * @return array
     */
    public function handleWebhook(array $data)
    {
        // التحقق من نوع الحدث
        $eventType = $data['event_type'] ?? '';
        
        switch ($eventType) {
            case 'PAYMENT.CAPTURE.COMPLETED':
                // معالجة اكتمال الدفع
                $orderId = $data['resource']['invoice_id'] ?? null;
                
                if ($orderId) {
                    // تحديث حالة الطلب
                    // Order::find($orderId)->markAsPaid();
                    
                    return [
                        'success' => true,
                        'message' => 'تم تحديث حالة الطلب بنجاح',
                    ];
                }
                break;
                
            case 'PAYMENT.CAPTURE.REFUNDED':
                // معالجة استرداد المبلغ
                break;
                
            default:
                // حدث غير معالج
                break;
        }
        
        return [
            'success' => false,
            'message' => 'نوع الحدث غير مدعوم: ' . $eventType,
        ];
    }
    
    /**
     * إرجاع المبلغ
     * 
     * @param string $transactionId معرف المعاملة
     * @param float $amount المبلغ
     * @return array
     * @throws \Exception
     */
    public function refundPayment(string $transactionId, float $amount): array
    {
        $accessToken = $this->getAccessToken();
        $captureId = $transactionId;
        
        $endpoint = $this->apiEndpoints[$this->mode]['base'] . '/v2/payments/captures/' . $captureId . '/refund';
        
        $payload = [
            'amount' => [
                'currency_code' => $this->settings['currency'] ?? 'USD',
                'value' => number_format($amount, 2, '.', ''),
            ],
        ];
        
        try {
            $client = new Client();
            $response = $client->post($endpoint, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => "Bearer {$accessToken}",
                ],
                'json' => $payload,
            ]);
            
            $result = json_decode($response->getBody(), true);
            
            if (isset($result['id'])) {
                return [
                    'success' => true,
                    'refund_id' => $result['id'],
                    'message' => 'تم استرداد المبلغ بنجاح',
                    'raw_response' => $result,
                ];
            }
            
            return [
                'success' => false,
                'message' => 'فشل استرداد المبلغ',
                'raw_response' => $result,
            ];
        } catch (GuzzleException $e) {
            throw new \Exception('فشل عملية الاسترداد: ' . $e->getMessage());
        }
    }
} 