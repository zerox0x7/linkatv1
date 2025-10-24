<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FixPaymentGateways extends Command
{
    /**
     * اسم وتوصيف الأمر
     *
     * @var string
     */
    protected $signature = 'payment:fix-gateways';

    /**
     * وصف الأمر
     *
     * @var string
     */
    protected $description = 'إصلاح بوابات الدفع في قاعدة البيانات';

    /**
     * تنفيذ الأمر
     */
    public function handle()
    {
        $this->info('بدء عملية إصلاح بوابات الدفع...');
        
        // التحقق من وجود جدول payment_methods
        if (!Schema::hasTable('payment_methods')) {
            $this->error('جدول payment_methods غير موجود!');
            return 1;
        }
        
        // إصلاح كليك باي
        $this->info('إصلاح بوابة كليك باي...');
        $clickpay = DB::table('payment_methods')->where('code', 'clickpay')->first();
        
        if (!$clickpay) {
            $this->warn('بوابة كليك باي غير موجودة في قاعدة البيانات.');
        } else {
            // نسخ البيانات الحالية للتحقق
            $this->info('البيانات الحالية:');
            $this->info('الوصف: ' . ($clickpay->description ?? 'غير موجود'));
            $this->info('الاعتمادات: ' . ($clickpay->credentials ?? 'غير موجودة'));
            $this->info('الحالة: ' . ($clickpay->is_active ? 'مفعلة' : 'غير مفعلة'));
            
            // تعيين بيانات الاعتماد
            $credentials = [];
            
            // محاولة قراءة البيانات الحالية
            try {
                if (!empty($clickpay->credentials)) {
                    $existingCredentials = json_decode($clickpay->credentials, true);
                    if (is_array($existingCredentials)) {
                        $credentials = $existingCredentials;
                    }
                }
            } catch (\Exception $e) {
                $this->warn('خطأ في قراءة البيانات الحالية: ' . $e->getMessage());
            }
            
            // تعيين القيم الافتراضية إذا كانت غير موجودة
            if (empty($credentials['profile_id'])) {
                $credentials['profile_id'] = '43602';
            }
            
            if (empty($credentials['server_key'])) {
                $credentials['server_key'] = 'S9JNLNMJJG-JHBJN9MGZZ-JDN9JKZHDH';
            }
            
            // تحديث بوابة كليك باي
            $updated = DB::table('payment_methods')
                ->where('id', $clickpay->id)
                ->update([
                    'credentials' => json_encode($credentials),
                    'mode' => 'live',
                    'updated_at' => now()
                ]);
            
            if ($updated) {
                $this->info('تم تحديث بوابة كليك باي بنجاح.');
                $this->info('البيانات الجديدة:');
                $this->info('المعرف: ' . $credentials['profile_id']);
                $this->info('المفتاح: ' . $credentials['server_key']);
            } else {
                $this->error('فشل تحديث بوابة كليك باي!');
            }
        }
        
        // إصلاح بوابات الدفع الأخرى
        $this->info('إصلاح باقي بوابات الدفع...');
        $paymentMethods = DB::table('payment_methods')->where('code', '!=', 'clickpay')->get();
        
        foreach ($paymentMethods as $method) {
            $this->info('إصلاح بوابة: ' . $method->name);
            
            // التحقق من بيانات الاعتماد
            try {
                $credentials = json_decode($method->credentials, true);
                
                if (!is_array($credentials)) {
                    $this->warn('بيانات اعتماد غير صالحة، سيتم تعيينها كمصفوفة فارغة.');
                    $credentials = [];
                    
                    // تحديث البوابة
                    DB::table('payment_methods')
                        ->where('id', $method->id)
                        ->update([
                            'credentials' => json_encode($credentials),
                            'updated_at' => now()
                        ]);
                    
                    $this->info('تم إصلاح بيانات الاعتماد.');
                }
            } catch (\Exception $e) {
                $this->error('خطأ في معالجة بوابة ' . $method->name . ': ' . $e->getMessage());
            }
        }
        
        $this->info('اكتملت عملية إصلاح بوابات الدفع بنجاح.');
        
        return 0;
    }
} 