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
        // تغيير نوع حقل meta_keywords إلى TEXT للسماح بعدد أكبر من الأحرف
        DB::statement('ALTER TABLE products MODIFY meta_keywords TEXT');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // إعادة نوع حقل meta_keywords إلى VARCHAR
        DB::statement('ALTER TABLE products MODIFY meta_keywords VARCHAR(255)');
    }
};
