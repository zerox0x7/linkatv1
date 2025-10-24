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
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'store_id')) {
                $table->unsignedBigInteger('store_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('orders', 'custom_data')) {
                $table->json('custom_data')->nullable()->after('notes');
            }
            if (!Schema::hasColumn('orders', 'has_custom_products')) {
                $table->boolean('has_custom_products')->default(false)->after('custom_data');
            }
            if (!Schema::hasColumn('orders', 'order_token')) {
                $table->string('order_token', 64)->nullable()->unique()->after('has_custom_products');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $columns = ['store_id', 'custom_data', 'has_custom_products', 'order_token'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}; 