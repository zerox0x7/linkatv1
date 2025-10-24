<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            // حذف الأعمدة التي أضفناها بالخطأ إذا كانت موجودة
            if (Schema::hasColumn('payment_methods', 'credentials')) {
                $table->dropColumn('credentials');
            }
            if (Schema::hasColumn('payment_methods', 'settings')) {
                $table->dropColumn('settings');
            }
            if (Schema::hasColumn('payment_methods', 'mode')) {
                $table->dropColumn('mode');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // هذه الأعمدة ليست جزءًا من الهيكل الأصلي للجدول، لذا لا نعيدها في حالة التراجع
    }
};
