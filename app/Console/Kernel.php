<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * قائمة أوامر Artisan المخصصة للتطبيق.
     *
     * @var array
     */
    protected $commands = [
        // أوامر مخصصة للتطبيق
        Commands\FixPaymentGateways::class,
        Commands\DeliverDigitalCardsCommand::class,
        Commands\FixDigitalOrdersStatus::class,
        Commands\UpdateDigitalProductOrdersCommand::class,
        Commands\UpdateExistingDigitalCodesCommand::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // تشغيل أمر تسليم البطاقات الرقمية كل 5 دقائق
        $schedule->command('orders:deliver-digital-cards')->everyFiveMinutes();
        
        // تشغيل أمر تصحيح حالة طلبات المنتجات الرقمية كل ساعة
        $schedule->command('orders:fix-digital-status')->hourly();
        
        // تشغيل أمر تحديث طلبات المنتجات الرقمية كل 5 دقائق
        $schedule->command('orders:update-digital-products')->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
