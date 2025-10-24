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
        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'store_id')) {
                $table->unsignedBigInteger('store_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('categories', 'show_in_homepage')) {
                $table->boolean('show_in_homepage')->default(false)->after('type');
            }
            if (!Schema::hasColumn('categories', 'homepage_order')) {
                $table->integer('homepage_order')->default(0)->after('show_in_homepage');
            }
            if (!Schema::hasColumn('categories', 'order')) {
                $table->integer('order')->default(0)->after('homepage_order');
            }
            if (!Schema::hasColumn('categories', 'text_color')) {
                $table->string('text_color')->nullable()->after('order');
            }
            if (!Schema::hasColumn('categories', 'bg_color')) {
                $table->string('bg_color')->nullable()->after('text_color');
            }
            if (!Schema::hasColumn('categories', 'icon')) {
                $table->string('icon')->nullable()->after('bg_color');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $columns = ['store_id', 'show_in_homepage', 'homepage_order', 'order', 'text_color', 'bg_color', 'icon'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('categories', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}; 