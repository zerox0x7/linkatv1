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
            if (!Schema::hasColumn('payment_methods', 'settings')) {
                $table->json('settings')->nullable();
            }
            
            if (!Schema::hasColumn('payment_methods', 'credentials')) {
                $table->json('credentials')->nullable();
            }
            
            if (!Schema::hasColumn('payment_methods', 'mode')) {
                $table->string('mode')->default('test');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropColumn(['credentials', 'settings', 'mode']);
        });
    }
};
