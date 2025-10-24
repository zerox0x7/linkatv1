<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->string('mode')->default('live')->after('is_active');
        });

        // تحديث قيمة وضع التشغيل لبوابة كليك باي
        DB::table('payment_methods')
            ->where('code', 'clickpay')
            ->update(['mode' => 'live']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropColumn('mode');
        });
    }
}; 