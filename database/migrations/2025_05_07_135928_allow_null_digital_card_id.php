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
        // تعديل حقل digital_card_id ليقبل قيمة NULL
        DB::statement('ALTER TABLE digital_card_codes MODIFY digital_card_id BIGINT UNSIGNED NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // إعادة حقل digital_card_id لعدم قبول NULL
        DB::statement('ALTER TABLE digital_card_codes MODIFY digital_card_id BIGINT UNSIGNED NOT NULL');
    }
};
