<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ClearAppCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all application caches including settings';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Clearing application cache...');
        Artisan::call('cache:clear');
        $this->info('Application cache cleared!');

        $this->info('Clearing configuration cache...');
        Artisan::call('config:clear');
        $this->info('Configuration cache cleared!');

        $this->info('Clearing view cache...');
        Artisan::call('view:clear');
        $this->info('View cache cleared!');

        $this->info('Clearing route cache...');
        Artisan::call('route:clear');
        $this->info('Route cache cleared!');

        $this->info('Clearing settings cache...');
        Setting::clearCache();
        $this->info('Settings cache cleared!');

        $this->info('All caches cleared successfully!');
        return Command::SUCCESS;
    }
} 