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
        // إعادة تسمية الجدول ليتوافق مع الطراز
        if (Schema::hasTable('whats_app_templates') && !Schema::hasTable('whatsapp_templates')) {
            Schema::rename('whats_app_templates', 'whatsapp_templates');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('whatsapp_templates') && !Schema::hasTable('whats_app_templates')) {
            Schema::rename('whatsapp_templates', 'whats_app_templates');
        }
    }
}; 