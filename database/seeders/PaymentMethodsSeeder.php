<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // تبسيط عملية إضافة/تحديث كليك باي
        try {
            // إنشاء أو تحديث سجل كليك باي
            $existingMethod = DB::table('payment_methods')->where('code', 'clickpay')->first();
            
            if ($existingMethod) {
                // تحديث السجل الموجود
                DB::table('payment_methods')
                    ->where('code', 'clickpay')
                    ->update([
                        'name' => 'كليك باي',
                        'description' => 'بوابة كليك باي للدفع الإلكتروني',
                        'is_active' => true,
                        'updated_at' => now(),
                    ]);
            } else {
                // إنشاء سجل جديد
                DB::table('payment_methods')->insert([
                    'name' => 'كليك باي',
                    'code' => 'clickpay',
                    'description' => 'بوابة كليك باي للدفع الإلكتروني',
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            
            // إضافة معلومات إضافية في لوحة التحكم
            echo "تم إضافة/تحديث بوابة كليك باي بنجاح!";
            echo "\n\nملاحظة: يجب إضافة المعلومات التالية من لوحة التحكم:";
            echo "\n- معرف الملف الشخصي: Profile ID";
            echo "\n- مفتاح الخادم: Server Key";
            echo "\n\nإذا كنت بحاجة لإضافة هذه المعلومات برمجياً، يرجى استخدام PaymentMethod::updateOrCreate()";
            
        } catch (\Exception $e) {
            dump('Error: ' . $e->getMessage());
        }
    }
}
