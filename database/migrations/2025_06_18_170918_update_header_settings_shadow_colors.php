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
        // Update existing records to use TailwindCSS color format
        $colorMapping = [
            'gray' => 'gray-500',
            'red' => 'red-500',
            'blue' => 'blue-500',
            'green' => 'green-500',
            'yellow' => 'yellow-500',
            'purple' => 'purple-500',
            'pink' => 'pink-500',
            'indigo' => 'indigo-500',
            'orange' => 'orange-500',
            'teal' => 'teal-500',
            'cyan' => 'cyan-500',
            'slate' => 'slate-500',
        ];

        foreach ($colorMapping as $oldColor => $newColor) {
            DB::table('header_settings')
                ->where('logo_shadow_color', $oldColor)
                ->update(['logo_shadow_color' => $newColor]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to old color format
        $colorMapping = [
            'gray-500' => 'gray',
            'red-500' => 'red',
            'blue-500' => 'blue',
            'green-500' => 'green',
            'yellow-500' => 'yellow',
            'purple-500' => 'purple',
            'pink-500' => 'pink',
            'indigo-500' => 'indigo',
            'orange-500' => 'orange',
            'teal-500' => 'teal',
            'cyan-500' => 'cyan',
            'slate-500' => 'slate',
        ];

        foreach ($colorMapping as $newColor => $oldColor) {
            DB::table('header_settings')
                ->where('logo_shadow_color', $newColor)
                ->update(['logo_shadow_color' => $oldColor]);
        }
    }
};
