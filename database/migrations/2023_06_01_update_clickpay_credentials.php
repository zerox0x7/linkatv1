<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // تحقق من وجود الجدول قبل التحديث
        if (Schema::hasTable('payment_methods')) {
            // تحديث بيانات اعتماد كليك باي
            DB::table('payment_methods')
                ->where('code', 'clickpay')
                ->update([
                    'credentials' => json_encode([
                        'profile_id' => '43602',
                        'server_key' => 'S9JNLNMJJG-JHBJN9MGZZ-JDN9JKZHDH'
                    ]),
                    'settings' => null // إزالة الإعدادات غير المطلوبة
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // تحقق من وجود الجدول قبل التحديث
        if (Schema::hasTable('payment_methods')) {
            // استعادة البيانات السابقة إذا لزم الأمر
            DB::table('payment_methods')
                ->where('code', 'clickpay')
                ->update([
                    'credentials' => null,
                    'settings' => null
                ]);
        }
    }
}; 