<?php

namespace App\PaymentGateways\EdfaPay;

use App\Models\Order;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\PaymentGateways\BaseGateway;

/**
 * بوابة دفع EdfaPay - تكامل مستقل تمامًا عن أي بوابة أخرى
 */
class EdfaPayGateway extends BaseGateway
{
    /**
     * عنوان API الثابت
     * @var string
     */
    protected $paymentUrl = 'https://api.edfapay.com/payment/initiate';

    /**
     * إعدادات البوابة (من قاعدة البيانات)
     * @var array
     */
    protected $settings;

    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * الحقول المطلوبة في لوحة التحكم
     * @return array
     */
    public function getConfigFields(): array
    {
        return [
            'merchant_id' => [
                'name' => 'merchant_id',
                'label' => 'Merchant Key',
                'type' => 'text',
                'required' => true,
            ],
            'password' => [
                'name' => 'password',
                'label' => 'Password',
                'type' => 'password',
                'required' => true,
            ],
            'currency' => [
                'name' => 'currency',
                'label' => 'العملة',
                'type' => 'select',
                'options' => [
                    'SAR' => 'ريال سعودي (SAR)',
                ],
                'default' => 'SAR',
                'required' => true,
            ],
        ];
    }

    protected function getMerchantId(): string
    {
        return $this->settings['merchant_id'] ?? '';
    }

    protected function getPassword(): string
    {
        return $this->settings['password'] ?? '';
    }

    protected function getPaymentUrl(): string
    {
        return $this->paymentUrl;
    }

    /**
     * بدء عملية الدفع مع EdfaPay
     * @param Order $order
     * @return array
     */
    public function processPayment($order): array
    {
        $client = new Client();

        // تجهيز بيانات العميل
        $user = auth()->user();
        $payload = [
            'action' => 'SALE',
            'edfa_merchant_id' => $this->getMerchantId(),
            'order_id' => (string) $order->id,
            'order_amount' => number_format((float)$order->total, 2, '.', ''),
            'order_currency' => 'SAR',
            'order_description' => "طلب #{$order->id} - " . config('app.name'),
            'payer_first_name' => $order->customer_first_name ?? ($user->name ?? 'عميل'),
            'payer_last_name' => $order->customer_last_name ?? ($user->last_name ?? 'متجر'),
            'payer_address' => $order->customer_address ?? 'العنوان',
            'payer_country' => $order->customer_country ?? 'SA',
            'payer_city' => $order->customer_city ?? 'الرياض',
            'payer_zip' => $order->customer_zip ?? '00000',
            'payer_email' => $order->customer_email ?? ($user->email ?? ''),
            'payer_phone' => $order->customer_phone ?? ($user->phone ?? ''),
            'payer_ip' => request()->ip(),
            // فقط term_url_3ds حسب وثائق EdfaPay
            'term_url_3ds' => route('payment.callback.edfapay.success', [
                'order_id' => $order->id,
                'token' => $order->order_token
            ]),
        ];

        // توليد التوقيع (hash) حسب وثيقة EdfaPay
        $to_md5 = strtoupper($payload['order_id'] . $payload['order_amount'] . $payload['order_currency'] . $payload['order_description'] . $this->getPassword());
        $md5 = md5($to_md5);
        $hash = sha1($md5);
        $payload['hash'] = $hash;

        Log::info('البيانات المرسلة إلى EdfaPay', [
            'payload' => $payload,
            'api_endpoint' => $this->getPaymentUrl()
        ]);

        try {
            $response = $client->post($this->getPaymentUrl(), [
                'form_params' => $payload,
                'timeout' => 30,
                'connect_timeout' => 30
            ]);

            $result = json_decode($response->getBody(), true);

            Log::info('استجابة EdfaPay', [
                'order_id' => $order->id,
                'response' => $result,
            ]);

            // إذا كان هناك رابط إعادة توجيه
            if (isset($result['redirect_url']) && !empty($result['redirect_url'])) {
                return [
                    'success' => true,
                    'redirect_url' => $result['redirect_url'],
                    'transaction_id' => $result['trans_id'] ?? null,
                    'message' => 'تم إنشاء طلب الدفع بنجاح، سيتم تحويلك لصفحة الدفع',
                    'raw_response' => $result,
                ];
            }

            // إذا كان هناك خطأ
            if (isset($result['result']) && $result['result'] === 'ERROR') {
                return [
                    'success' => false,
                    'message' => $result['error_message'] ?? 'خطأ غير معروف من بوابة الدفع',
                    'raw_response' => $result,
                ];
            }

            // أي استجابة أخرى
            return [
                'success' => false,
                'message' => $result['message'] ?? 'فشل إنشاء طلب الدفع: لم يتم استلام رابط إعادة التوجيه',
                'raw_response' => $result,
            ];
        } catch (\Exception $e) {
            Log::error('EdfaPay payment processing error', [
                'error' => $e->getMessage(),
                'order_id' => $order->id,
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'حدث خطأ أثناء معالجة الدفع: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * التحقق من الدفع عبر استعلام حالة الطلب من EdfaPay
     *
     * @param array $data
     * @return bool
     */
    public function verifyPayment(array $data): bool
    {
        $client = new Client();
        $orderId = $data['order_id'] ?? null;
        $gwayPaymentId = $data['gway_Payment_Id'] ?? $data['gwayId'] ?? null;

        if (!$orderId || !$gwayPaymentId) {
            Log::warning('بيانات التحقق من الدفع غير مكتملة', $data);
            return false;
        }

        // توليد التوقيع (hash) حسب وثيقة EdfaPay
        $to_md5 = strtoupper($this->getMerchantId() . $gwayPaymentId . $orderId . $this->getPassword());
        $md5 = md5($to_md5);
        $hash = sha1($md5);

        $payload = [
            'merchant_id' => $this->getMerchantId(),
            'gway_Payment_Id' => $gwayPaymentId,
            'order_id' => $orderId,
            'hash' => $hash,
        ];

        try {
            $response = $client->post('https://api.edfapay.com/payment/status', [
                'json' => $payload,
                'timeout' => 30,
                'connect_timeout' => 30
            ]);
            $result = json_decode($response->getBody(), true);
            Log::info('استجابة تحقق حالة الدفع من EdfaPay', [
                'payload' => $payload,
                'response' => $result,
            ]);
            if (isset($result['result']) && $result['result'] === 'SUCCESS') {
                return true;
            }
        } catch (\Exception $e) {
            Log::error('خطأ في استعلام حالة الدفع من EdfaPay', [
                'error' => $e->getMessage(),
                'payload' => $payload,
            ]);
        }
        return false;
    }

    /**
     * التحقق من صحة التوقيع (hash) في الردود
     *
     * @param array $data
     * @return bool
     */
    public function verifySignature(array $data): bool
    {
        if (!isset($data['hash'])) {
            return false;
        }
        // توليد نفس صيغة التوقيع المستخدمة في الطلب
        $to_md5 = strtoupper(
            ($data['order_id'] ?? '') .
            ($data['order_amount'] ?? '') .
            ($data['order_currency'] ?? '') .
            ($data['order_description'] ?? '') .
            $this->getPassword()
        );
        $md5 = md5($to_md5);
        $expectedHash = sha1($md5);
        return hash_equals($expectedHash, $data['hash']);
    }

    /**
     * استقبال إشعارات الدفع (Webhook) من EdfaPay
     *
     * @param array $data
     * @return array
     */
    public function handleWebhook(array $data): array
    {
        Log::info('بيانات Webhook من EdfaPay', [ 'data' => $data ]);
        if (!$this->verifySignature($data)) {
            return [
                'success' => false,
                'message' => 'فشل التحقق من التوقيع',
            ];
        }
        $orderId = $data['order_id'] ?? null;
        $paymentResult = $data['result'] ?? null;
        if (!$orderId) {
            return [
                'success' => false,
                'message' => 'معرف الطلب غير موجود في بيانات الإشعار',
            ];
        }
        $order = \App\Models\Order::find($orderId);
        if (!$order) {
            return [
                'success' => false,
                'message' => 'الطلب غير موجود',
            ];
        }
        if ($paymentResult === 'SUCCESS') {
            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing',
                'paid_at' => now(),
            ]);
            // تحديث سجل الدفع إذا كان موجودًا
            $payment = $order->payment;
            if ($payment) {
                $payment->update([
                    'payment_status' => 'completed',
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
            'message' => 'حالة الدفع غير مكتملة: ' . ($data['error_message'] ?? 'غير معروف'),
        ];
    }
} 