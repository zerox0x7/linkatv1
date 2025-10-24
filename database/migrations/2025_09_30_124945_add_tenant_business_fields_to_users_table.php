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
        Schema::table('users', function (Blueprint $table) {
            // Business/Tenant Information Fields
            if (!Schema::hasColumn('users', 'store_name')) {
                $table->string('store_name')->nullable()->after('name');
            }
            if (!Schema::hasColumn('users', 'business_type')) {
                $table->enum('business_type', [
                    'retail', 'wholesale', 'services', 'manufacturing', 
                    'food_beverage', 'fashion', 'electronics', 'health_beauty', 'other'
                ])->nullable()->after('store_name');
            }
            if (!Schema::hasColumn('users', 'expected_monthly_sales')) {
                $table->enum('expected_monthly_sales', [
                    'under_5000', '5000_15000', '15000_50000', 
                    '50000_100000', 'over_100000'
                ])->nullable()->after('business_type');
            }
            if (!Schema::hasColumn('users', 'website_url')) {
                $table->string('website_url')->nullable()->after('expected_monthly_sales');
            }
            if (!Schema::hasColumn('users', 'business_license')) {
                $table->string('business_license', 50)->nullable()->after('website_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'store_name',
                'business_type', 
                'expected_monthly_sales',
                'website_url',
                'business_license'
            ]);
        });
    }
};

