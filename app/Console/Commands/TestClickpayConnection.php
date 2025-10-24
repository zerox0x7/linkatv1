<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Log;

class TestClickpayConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:test-clickpay {--debug : Show detailed debug information}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'اختبار الاتصال ببوابة كليك باي وتشخيص المشكلات';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('بدء اختبار الاتصال ببوابة كليك باي...');
        $this->newLine();
        
        // التحقق من وجود بوابة كليك باي
        $paymentMethod = PaymentMethod::where('code', 'clickpay')->first();
        
        if (!$paymentMethod) {
            $this->error('بوابة كليك باي غير موجودة في قاعدة البيانات!');
            return 1;
        }
        
        // عرض معلومات عن بوابة الدفع
        $this->info('معلومات بوابة الدفع:');
        $this->table(
            ['المعرف', 'الاسم', 'الوصف', 'مفعلة', 'وضع التشغيل'],
            [[$paymentMethod->id, $paymentMethod->name, $paymentMethod->description, $paymentMethod->is_active ? 'نعم' : 'لا', $paymentMethod->mode]]
        );
        
        // التحقق من بيانات الاعتماد
        $credentials = $paymentMethod->getActiveCredentials();
        
        if (empty($credentials) || empty($credentials['profile_id']) || empty($credentials['server_key'])) {
            $this->error('بيانات الاعتماد غير مكتملة!');
            
            if ($this->option('debug')) {
                $this->table(
                    ['المفتاح', 'القيمة'],
                    collect($credentials)->map(function ($value, $key) {
                        return [$key, is_array($value) ? json_encode($value) : (is_null($value) ? 'NULL' : $value)];
                    })->toArray()
                );
            }
            
            return 1;
        }
        
        $this->info('بيانات الاعتماد موجودة ✓');
        
        // اختبار الاتصال بالبوابة
        $this->info('جاري اختبار الاتصال بالبوابة...');
        
        $client = new Client();
        $endpoint = 'https://secure.clickpay.com.sa/payment/query';
        
        try {
            // إنشاء طلب وهمي للتحقق فقط
            $payload = [
                'profile_id' => $credentials['profile_id'],
                'tran_ref' => 'TEST-CONNECTION-' . time(),
            ];
            
            if ($this->option('debug')) {
                $this->info('البيانات المرسلة:');
                $this->line(json_encode($payload, JSON_PRETTY_PRINT));
                $this->newLine();
            }
            
            $response = $client->post($endpoint, [
                'headers' => [
                    'Authorization' => $credentials['server_key'],
                    'Content-Type' => 'application/json',
                ],
                'json' => $payload,
                'timeout' => 30,
                'connect_timeout' => 30,
            ]);
            
            $statusCode = $response->getStatusCode();
            $responseBody = (string) $response->getBody();
            $result = json_decode($responseBody, true);
            
            // حتى لو كان هناك خطأ، إذا وصلنا إلى هنا، فهذا يعني أن الاتصال بالخادم تم بنجاح
            $this->info("تم الاتصال بالخادم بنجاح (رمز الاستجابة: $statusCode) ✓");
            
            if ($this->option('debug')) {
                $this->info('استجابة الخادم:');
                $this->line(json_encode($result, JSON_PRETTY_PRINT));
                $this->newLine();
            }
            
            // التحقق من صلاحية بيانات الاعتماد
            if (isset($result['code']) && $result['code'] !== 200) {
                $this->error('بيانات الاعتماد غير صحيحة أو هناك مشكلة في الاستعلام.');
                $this->error('الخطأ: ' . ($result['message'] ?? 'خطأ غير معروف'));
                return 1;
            }
            
            // تشخيص أي مشكلات أخرى
            if (isset($result['tran_ref'])) {
                $this->info('تم التحقق من بيانات الاعتماد بنجاح ✓');
            } else {
                $this->warn('تم الاتصال بالخادم، ولكن الاستجابة غير متوقعة.');
            }
            
            // جمع معلومات عن المسارات
            $this->info('معلومات المسارات:');
            $callbackUrl = route('payment.callback.success', ['order_id' => 123]);
            $returnUrl = route('payment.callback.cancel', ['order_id' => 123]);
            
            $this->table(
                ['المسار', 'العنوان'],
                [
                    ['callback', $callbackUrl],
                    ['return', $returnUrl]
                ]
            );
            
            $this->newLine();
            $this->info('اكتمل اختبار الاتصال ببوابة كليك باي بنجاح.');
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error('فشل الاتصال بالخادم: ' . $e->getMessage());
            
            if ($this->option('debug')) {
                $this->newLine();
                $this->error('تفاصيل الخطأ:');
                $this->line($e->getTraceAsString());
            }
            
            return 1;
        }
    }
}
