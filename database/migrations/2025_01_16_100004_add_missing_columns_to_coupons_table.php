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
        Schema::table('coupons', function (Blueprint $table) {
            if (!Schema::hasColumn('coupons', 'store_id')) {
                $table->unsignedBigInteger('store_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('coupons', 'style_id')) {
                $table->unsignedBigInteger('style_id')->nullable()->after('code');
            }
            if (!Schema::hasColumn('coupons', 'max_discount_amount')) {
                $table->decimal('max_discount_amount', 10, 2)->nullable()->after('min_order_amount');
            }
            if (!Schema::hasColumn('coupons', 'user_limit')) {
                $table->integer('user_limit')->nullable()->after('max_discount_amount');
            }
            if (!Schema::hasColumn('coupons', 'priority')) {
                $table->integer('priority')->default(0)->after('user_limit');
            }
            if (!Schema::hasColumn('coupons', 'auto_apply')) {
                $table->boolean('auto_apply')->default(false)->after('priority');
            }
            if (!Schema::hasColumn('coupons', 'stackable')) {
                $table->boolean('stackable')->default(false)->after('auto_apply');
            }
            if (!Schema::hasColumn('coupons', 'email_notifications')) {
                $table->boolean('email_notifications')->default(false)->after('stackable');
            }
            if (!Schema::hasColumn('coupons', 'show_on_homepage')) {
                $table->boolean('show_on_homepage')->default(false)->after('email_notifications');
            }
            if (!Schema::hasColumn('coupons', 'product_ids')) {
                $table->json('product_ids')->nullable()->after('is_active');
            }
            if (!Schema::hasColumn('coupons', 'category_ids')) {
                $table->json('category_ids')->nullable()->after('product_ids');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $columns = [
                'store_id', 'style_id', 'max_discount_amount', 'user_limit', 'priority',
                'auto_apply', 'stackable', 'email_notifications', 'show_on_homepage',
                'product_ids', 'category_ids'
            ];
            foreach ($columns as $column) {
                if (Schema::hasColumn('coupons', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}; 