<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;

class ThemeManager
{
    /**
     * اسم الثيم الحالي
     *
     * @var string
     */
    protected $currentTheme;

    /**
     * مسار مجلد الثيمات
     *
     * @var string
     */
    protected $themesPath;

    /**
     * إنشاء كائن جديد من مدير الثيمات
     *
     * @return void
     */
    public function __construct()
    {
        $this->themesPath = resource_path('views/themes');
        $this->currentTheme = $this->getActiveTheme();
        
        // تعيين الثيم الحالي كمشاركة عامة في جميع القوالب
        View::share('currentTheme', $this->currentTheme);
        
        // تعيين مسار الثيم في محرك العرض
        View::addNamespace('theme', $this->themesPath . '/' . $this->currentTheme);
    }

    /**
     * الحصول على الثيم النشط من الإعدادات
     *
     * @return string
     */
    public function getActiveTheme()
    {
        // محاولة الحصول على الثيم من الإعدادات
        $theme = Setting::get('active_theme', 'default');
        
        // التحقق من وجود الثيم المطلوب، وإلا العودة إلى الافتراضي
        if (!$this->themeExists($theme)) {
            return 'default';
        }
        
        return $theme;
    }

    /**
     * تعيين الثيم النشط
     *
     * @param string $theme
     * @return bool
     */
    public function setActiveTheme($theme)
    {
        if (!$this->themeExists($theme)) {
            return false;
        }
        
        Setting::set('active_theme', $theme);
        $this->currentTheme = $theme;
        
        return true;
    }

    /**
     * التحقق من وجود الثيم
     *
     * @param string $theme
     * @return bool
     */
    public function themeExists($theme)
    {
        return File::isDirectory($this->themesPath . '/' . $theme);
    }

    /**
     * الحصول على قائمة بجميع الثيمات المتاحة
     *
     * @return array
     */
    public function getAllThemes()
    {
        $themes = [];
        
        if (File::isDirectory($this->themesPath)) {
            $directories = File::directories($this->themesPath);
            
            foreach ($directories as $directory) {
                $name = basename($directory);
                
                // قراءة معلومات الثيم من ملف التكوين إذا كان موجودًا
                $configFile = $directory . '/theme.json';
                $config = File::exists($configFile) ? json_decode(File::get($configFile), true) : [];
                
                $themes[$name] = [
                    'name' => $name,
                    'title' => $config['title'] ?? ucfirst($name) . ' Theme',
                    'description' => $config['description'] ?? '',
                    'version' => $config['version'] ?? '1.0',
                    'author' => $config['author'] ?? '',
                    'screenshot' => $config['screenshot'] ?? null,
                ];
            }
        }
        
        return $themes;
    }

    /**
     * الحصول على مسار القالب ضمن الثيم الحالي
     *
     * @param string $view
     * @return string
     */
    public function getThemeView($view)
    {
        return "theme::{$view}";
    }
} 