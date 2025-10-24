<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Category;
use App\Observers\OrderObserver;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Registrar el servicio WhatsApp como singleton
        $this->app->singleton(WhatsAppService::class, function ($app) {
            return new WhatsAppService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Order::observe(OrderObserver::class);

        // Share categories with all views (especially for footer)
        View::composer('*', function ($view) {
            try {
                if (Schema::hasTable('categories')) {
                    $store = request()->attributes->get('store');
                    if ($store) {
                        $categories = Category::where('store_id', $store->id)
                            ->where('is_active', 1)
                            ->orderBy('sort_order')
                            ->limit(5)
                            ->get();
                        $view->with('categories', $categories);
                    }
                }
            } catch (\Exception $e) {
                // Handle any database connection errors silently
            }
        });

    //     Paginator::defaultView('pagination.custom');
    // Paginator::defaultSimpleView('pagination.simple-custom');
        
        // تعيين اسم التطبيق من إعدادات قاعدة البيانات
        try {
            if (Schema::hasTable('settings')) {
            $storeName = Setting::get('store_name');
            if ($storeName) {
                config(['app.name' => $storeName]);
            }
            }
        } catch (\Exception $e) {
            // تجاهل الأخطاء في مرحلة التمهيد
            // يمكنك تسجيل الخطأ إذا كنت تريد
            // \Log::error('Database connection error in AppServiceProvider: ' . $e->getMessage());
        }

        // التحقق من وجود الرابط الرمزي للتخزين
        if (!file_exists(public_path('storage'))) {
            \Artisan::call('storage:link');
        }
    }
}
