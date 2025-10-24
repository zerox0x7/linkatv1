<?php

namespace App\PaymentGateways;

abstract class BaseGateway
{
    /**
     * إعدادات البوابة
     * 
     * @var array
     */
    protected $settings;
    
    /**
     * بيانات الاعتماد للبوابة
     * 
     * @var array
     */
    protected $credentials;
    
    /**
     * حالة البوابة (حية أو تجريبية)
     * 
     * @var string
     */
    protected $mode;
    
    /**
     * إنشاء مثيل جديد للبوابة
     * 
     * @param array $settings إعدادات البوابة
     * @param array $credentials بيانات الاعتماد
     * @param string $mode وضع التشغيل (live/test)
     * @return void
     */
    public function __construct(array $settings = [], array $credentials = [], string $mode = 'test')
    {
        $this->settings = $settings;
        $this->credentials = $credentials;
        $this->mode = $mode;
    }
    
    /**
     * الحصول على حقول الإعدادات اللازمة في لوحة التحكم
     * 
     * @return array
     */
    abstract public function getConfigFields(): array;
    
    /**
     * معالجة عملية الدفع
     * 
     * @param \App\Models\Order $order الطلب
     * @return array استجابة عملية الدفع
     */
    abstract public function processPayment($order): array;
    
    /**
     * التحقق من عملية الدفع
     * 
     * @param array $data بيانات استجابة البوابة
     * @return bool
     */
    abstract public function verifyPayment(array $data): bool;
    
    /**
     * التعامل مع webhook الخاص بالبوابة
     * 
     * @param array $data البيانات المستلمة
     * @return mixed
     */
    abstract public function handleWebhook(array $data);
    
    /**
     * إرجاع المبلغ (إذا كانت البوابة تدعم ذلك)
     * 
     * @param string $transactionId معرف المعاملة
     * @param float $amount المبلغ
     * @return array
     */
    public function refundPayment(string $transactionId, float $amount): array
    {
        throw new \Exception('هذه البوابة لا تدعم إرجاع المبالغ');
    }
    
    /**
     * حساب الرسوم على المبلغ
     * 
     * @param float $amount المبلغ
     * @return float
     */
    public function calculateFee(float $amount): float
    {
        $percentage = $this->settings['fee_percentage'] ?? 0;
        $fixed = $this->settings['fee_fixed'] ?? 0;
        
        return ($amount * $percentage / 100) + $fixed;
    }
    
    /**
     * تحويل المبلغ من عملة إلى أخرى
     * 
     * @param float $amount المبلغ
     * @param string $fromCurrency العملة المصدر
     * @param string $toCurrency العملة الهدف
     * @return float
     */
    protected function convertCurrency(float $amount, string $fromCurrency, string $toCurrency): float
    {
        if ($fromCurrency === $toCurrency) {
            return $amount;
        }
        
        // التحقق من وجود أسعار الصرف في الإعدادات
        if (isset($this->settings['currency_handling']['exchange_rates'][$fromCurrency][$toCurrency])) {
            $rate = $this->settings['currency_handling']['exchange_rates'][$fromCurrency][$toCurrency];
            return $amount * $rate;
        }
        
        // يمكن هنا إضافة منطق للحصول على سعر الصرف من API خارجي
        // في حالة عدم توفر الأسعار محلياً
        
        throw new \Exception("سعر الصرف غير متوفر: {$fromCurrency} إلى {$toCurrency}");
    }
    
    /**
     * إنشاء رقم مرجعي للمعاملة
     * 
     * @param int $orderId رقم الطلب
     * @return string
     */
    protected function generateReferenceNumber(int $orderId): string
    {
        return strtoupper(uniqid() . '-' . $orderId);
    }
    
    /**
     * تحويل الاستجابة من البوابة إلى تنسيق موحد
     * 
     * @param array $response استجابة البوابة
     * @return array
     */
    protected function formatResponse(array $response): array
    {
        // هذه الدالة يمكن التعديل عليها في الفئات المشتقة للتعامل مع استجابات البوابات المختلفة
        return [
            'success' => $response['success'] ?? false,
            'reference_id' => $response['reference_id'] ?? null,
            'transaction_id' => $response['transaction_id'] ?? null,
            'redirect_url' => $response['redirect_url'] ?? null,
            'message' => $response['message'] ?? '',
            'data' => $response,
            'raw_response' => $response['raw_response'] ?? null,
        ];
    }
} 