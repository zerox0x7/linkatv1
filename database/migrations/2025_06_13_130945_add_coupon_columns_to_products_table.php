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
        Schema::table('products', function (Blueprint $table) {
            // Coupon eligibility - determines if the product can have coupons applied
            if (!Schema::hasColumn('products', 'coupon_eligible')) {
                $table->boolean('coupon_eligible')->default(true)->after('views_count')
                    ->comment('يحدد ما إذا كان المنتج مؤهل لتطبيق الكوبونات عليه أم لا');
            }
            
            // Minimum order value required to apply coupon on this product
            if (!Schema::hasColumn('products', 'min_coupon_order_value')) {
                $table->decimal('min_coupon_order_value', 10, 2)->nullable()->after('coupon_eligible')
                    ->comment('الحد الأدنى لقيمة الطلب المطلوبة لتطبيق الكوبون على هذا المنتج');
            }
            
            // Maximum discount amount that can be applied to the product
            if (!Schema::hasColumn('products', 'max_coupon_discount_amount')) {
                $table->decimal('max_coupon_discount_amount', 10, 2)->nullable()->after('min_coupon_order_value')
                    ->comment('الحد الأقصى لمبلغ الخصم الذي يمكن تطبيقه على المنتج');
            }
            
            // Maximum discount percentage allowed on the product
            if (!Schema::hasColumn('products', 'max_coupon_discount_percentage')) {
                $table->decimal('max_coupon_discount_percentage', 5, 2)->nullable()->after('max_coupon_discount_amount')
                    ->comment('أقصى نسبة خصم مسموحة على المنتج');
            }
            
            // Coupon categories allowed to be applied on this product
            if (!Schema::hasColumn('products', 'coupon_categories')) {
                $table->json('coupon_categories')->nullable()->after('max_coupon_discount_percentage')
                    ->comment('فئات الكوبونات المسموح تطبيقها على هذا المنتج');
            }
            
            // Allow using more than one coupon on the same product
            if (!Schema::hasColumn('products', 'allow_coupon_stacking')) {
                $table->boolean('allow_coupon_stacking')->default(false)->after('coupon_categories')
                    ->comment('يسمح باستخدام أكثر من كوبون واحد على نفس المنتج');
            }
            
            // Types of coupons excluded from applying on this product
            if (!Schema::hasColumn('products', 'excluded_coupon_types')) {
                $table->json('excluded_coupon_types')->nullable()->after('allow_coupon_stacking')
                    ->comment('أنواع الكوبونات المستثناة من التطبيق على هذا المنتج');
            }
            
            // Time period when the product is eligible for coupons
            if (!Schema::hasColumn('products', 'coupon_start_date')) {
                $table->datetime('coupon_start_date')->nullable()->after('excluded_coupon_types')
                    ->comment('تاريخ بداية فترة استحقاق المنتج للكوبونات');
            }
            
            if (!Schema::hasColumn('products', 'coupon_end_date')) {
                $table->datetime('coupon_end_date')->nullable()->after('coupon_start_date')
                    ->comment('تاريخ نهاية فترة استحقاق المنتج للكوبونات');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $columns = [
                'coupon_eligible',
                'min_coupon_order_value',
                'max_coupon_discount_amount',
                'max_coupon_discount_percentage',
                'coupon_categories',
                'allow_coupon_stacking',
                'excluded_coupon_types',
                'coupon_start_date',
                'coupon_end_date'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('products', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
