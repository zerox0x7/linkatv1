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
            if (!Schema::hasColumn('payment_methods', 'fee_percentage')) {
                $table->float('fee_percentage', 8, 2)->default(0)->after('mode');
            }
            
            if (!Schema::hasColumn('payment_methods', 'fee_fixed')) {
                $table->float('fee_fixed', 8, 2)->default(0)->after('fee_percentage');
            }
            
            if (!Schema::hasColumn('payment_methods', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('fee_fixed');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            if (Schema::hasColumn('payment_methods', 'fee_percentage')) {
                $table->dropColumn('fee_percentage');
            }
            
            if (Schema::hasColumn('payment_methods', 'fee_fixed')) {
                $table->dropColumn('fee_fixed');
            }
            
            if (Schema::hasColumn('payment_methods', 'sort_order')) {
                $table->dropColumn('sort_order');
            }
        });
    }
};
