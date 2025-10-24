<?php

namespace App\Providers;

use App\Services\ThemeManager;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ThemeManager::class, function ($app) {
            return new ThemeManager();
        });

        // تسجيل اختصار للوصول إلى خدمة إدارة الثيمات
        $this->app->alias(ThemeManager::class, 'theme');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // إنشاء المجلدات الضرورية إذا لم تكن موجودة
        $themesPath = resource_path('views/themes');
        
        if (!file_exists($themesPath)) {
            mkdir($themesPath, 0755, true);
        }
        
        if (!file_exists($themesPath . '/default')) {
            mkdir($themesPath . '/default', 0755, true);
            mkdir($themesPath . '/default/layouts', 0755, true);
            mkdir($themesPath . '/default/components', 0755, true);
            mkdir($themesPath . '/default/pages', 0755, true);
            mkdir($themesPath . '/default/partials', 0755, true);
        }
        
        // تسجيل مسار الثيم الحالي
        $themeManager = $this->app->make(ThemeManager::class);
        
        // استخدام الثيم الافتراضي بدلاً من محاولة قراءته من قاعدة البيانات
        $currentTheme = 'default';
        
        // تسجيل مسار العرض للثيم
        View::addNamespace('theme', resource_path("views/themes/{$currentTheme}"));
    }
} 