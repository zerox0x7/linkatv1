<?php

namespace App\PaymentGateways\Myfatoorah;

use App\Models\Order;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class SimpleMyFatoorahGateway
{
    protected $apiKey;
    protected $isTest;
    protected $countryCode;
    protected $baseUrl;

    public function __construct()
    {
        $paymentMethod = \App\Models\PaymentMethod::where('code', 'myfatoorah')->where('is_active', 1)->first();
        if (!$paymentMethod) {
            throw new \Exception('بوابة ماي فاتورة غير مفعلة أو غير موجودة');
        }
        
        $config = $paymentMethod->config;
        $this->apiKey = $config['apiKey'] ?? '';
        $this->isTest = $paymentMethod->mode === 'test';
        $this->countryCode = $config['vcCode'] ?? 'SAU';
        $this->baseUrl = 'https://api-sa.myfatoorah.com'; // URL الصحيح للسعودية
    }

    public function createPayment(array $customer, $amount, $successUrl, $errorUrl, $currency = 'SAR')
    {
        // معالجة رقم الجوال
        $mobile = $customer['mobile'] ?? '';
        $mobile = preg_replace('/[^0-9]/', '', $mobile);
        if (preg_match('/^9665[0-9]{8}$/', $mobile)) {
            $mobile = substr($mobile, 3);
        }
        if (preg_match('/^05[0-9]{8}$/', $mobile)) {
            $mobile = substr($mobile, 1);
        }
        if (preg_match('/^5[0-9]{8,}$/', $mobile)) {
            $mobile = substr($mobile, 0, 9);
        }

        $client = new Client();
        
        $payload = [
            'CustomerName' => $customer['name'] ?? '',
            'CustomerEmail' => $customer['email'] ?? '',
            'CustomerMobile' => $mobile,
            'InvoiceValue' => (float)$amount,
            'DisplayCurrencyIso' => $currency,
            'CallBackUrl' => $successUrl,
            'ErrorUrl' => $errorUrl,
            'NotificationOption' => 'LNK', // مطلوب من MyFatoorah
            'CustomerReference' => 'ORDER-' . time(), // مرجع العميل
        ];

        try {
            $response = $client->post($this->baseUrl . '/v2/SendPayment', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => $payload,
            ]);

            $result = json_decode($response->getBody(), true);
            
            Log::info('MyFatoorah API Response', [
                'payload' => $payload,
                'response' => $result,
            ]);

            if (isset($result['IsSuccess']) && $result['IsSuccess'] === true && isset($result['Data']['InvoiceURL'])) {
                return $result['Data']['InvoiceURL'];
            } else {
                $errorMessage = $result['Message'] ?? 'خطأ غير معروف من MyFatoorah';
                Log::error('MyFatoorah Payment Error', [
                    'error' => $errorMessage,
                    'result' => $result,
                ]);
                throw new \Exception('خطأ من MyFatoorah: ' . $errorMessage);
            }
        } catch (\Exception $e) {
            Log::error('MyFatoorah Payment Exception', [
                'error' => $e->getMessage(),
                'payload' => $payload,
            ]);
            throw $e;
        }
    }

    public function processPayment($order)
    {
        $customer = [
            'name' => $order->user->name ?? 'عميل',
            'email' => $order->user->email ?? 'test@test.com',
            'mobile' => $order->user->phone ?? '',
        ];
        
        $amount = $order->total;
        $successUrl = route('payment.myfatoorah.success', ['order_id' => $order->id, 'token' => $order->order_token]);
        $errorUrl = route('payment.myfatoorah.cancel', ['order_id' => $order->id, 'token' => $order->order_token]);

        $paymentUrl = $this->createPayment($customer, $amount, $successUrl, $errorUrl, 'SAR');

        return [
            'success' => true,
            'redirect_url' => $paymentUrl,
            'payment_url' => $paymentUrl,
        ];
    }
}
