<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ResponsiveImageService;
use Illuminate\Support\Facades\DB;

class TestThemeSizes extends Command
{
    protected $signature = 'test:theme-sizes {position?}';
    protected $description = 'Test theme size retrieval from database';

    public function handle()
    {
        $position = $this->argument('position') ?? 8;
        
        $this->info("Testing theme size retrieval for position {$position}");
        $this->info(str_repeat('=', 60));
        
        // Test direct DB query
        $this->info("\n1. Direct DB Query:");
        $themeData = DB::table('themes_info')->where('name', 'torganic')->first();
        if ($themeData) {
            $images = json_decode($themeData->images, true);
            $order = $position + 1;
            foreach ($images as $img) {
                if ($img['order'] == $order) {
                    $this->info("   Order {$order} size in DB: {$img['size']}");
                }
            }
        }
        
        // Test via service
        $this->info("\n2. Via ResponsiveImageService:");
        $service = new ResponsiveImageService();
        $size = $service->getSizeForPosition($position, 'torganic');
        $this->info("   Returned size: {$size}");
        
        // Test with capital T
        $this->info("\n3. Testing with 'Torganic' (capital T):");
        $size2 = $service->getSizeForPosition($position, 'Torganic');
        $this->info("   Returned size: {$size2}");
        
        $this->info("\n" . str_repeat('=', 60));
        $this->info("Test complete!");
        
        return 0;
    }
}

