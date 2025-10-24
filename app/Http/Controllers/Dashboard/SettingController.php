<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Controllers\Dashboard\ImageUploadController;

class SettingController extends Controller
{
    protected $imageUploader;

    public function __construct(ImageUploadController $imageUploader)
    {
        $this->imageUploader = $imageUploader;
    }

    /**
     * عرض صفحة الإعدادات
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $settings = Setting::getAllSettings();
        
        // الحصول على قائمة الثيمات المتاحة
        $themeManager = app(ThemeManager::class);
        $themes = $themeManager->getAllThemes();
        $activeTheme = $themeManager->getActiveTheme();
        
        return view('themes.dashboard.settings.index', compact('settings', 'themes', 'activeTheme'));
    }

    /**
     * تحديث الإعدادات
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $inputs = $request->except(['_token', '_method']);
        
        // معالجة رفع الصور
        if ($request->hasFile('store_logo')) {
            // التحقق من صحة الملف
            $request->validate([
                'store_logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            
            $result = $this->imageUploader->uploadSingle(
                $request->file('store_logo'),
                'logos',
                Setting::get('store_logo')
            );
            
            if (!$result['success']) {
                return redirect()->back()
                    ->withErrors(['store_logo' => $result['message']])
                    ->withInput();
            }
            
            // تحديث الإعداد مع مسار الصورة الجديد
            Setting::set('store_logo', $result['path']);
            
            // إزالة من المدخلات لتجنب المعالجة المزدوجة
            unset($inputs['store_logo']);
        }
        
        // معالجة الألوان 
        if (isset($inputs['primary_color_picker']) && !empty($inputs['primary_color_picker'])) {
            // إذا استخدم منتقي اللون، قم بتحديث قيمة اللون
            $primaryColor = str_replace('#', '', $inputs['primary_color_picker']);
            $inputs['primary_color'] = $primaryColor;
        }
        
        if (isset($inputs['secondary_color_picker']) && !empty($inputs['secondary_color_picker'])) {
            // إذا استخدم منتقي اللون، قم بتحديث قيمة اللون
            $secondaryColor = str_replace('#', '', $inputs['secondary_color_picker']);
            $inputs['secondary_color'] = $secondaryColor;
        }

        // معالجة حقول التفعيل/التعطيل للأزرار والأقسام
        $toggleFields = [
            // الهيدر
            'enable_search',
            'show_home_button',
            'show_games_button',
            'show_social_button',
            'show_featured_button',
            'show_best_sellers_button',
            'show_dark_mode_button',
            'show_quick_links_header',
            'show_policies_header',
            
            // الفوتر
            'show_footer_about',
            'show_footer_links',
            'show_footer_policies',
            'show_footer_payment',
            
            // وسائل التواصل الاجتماعي
            'show_facebook',
            'show_twitter',
            'show_instagram',
            'show_whatsapp',
            
            // أخرى
            'maintenance_mode'
        ];
        
        foreach ($toggleFields as $field) {
            // إذا لم يكن الحقل موجودًا في الإرسال (غير محدد)، فهو غير مفعل
            if (!isset($inputs[$field])) {
                Setting::set($field, false);
            } else {
                Setting::set($field, true);
            }
            // إزالة من المدخلات لتجنب المعالجة المزدوجة
            unset($inputs[$field]);
        }

        // معالجة باقي الإعدادات
        foreach ($inputs as $key => $value) {
            // تجاهل حقول منتقي اللون
            if (in_array($key, ['primary_color_picker', 'secondary_color_picker'])) {
                continue;
            }
            
            Setting::set($key, $value);
        }
        
        // إذا تم تغيير الثيم، قم بإعادة تعيين ذاكرة التخزين المؤقت
        if ($request->has('active_theme')) {
            Cache::forget('active_theme');
            
            // إعادة تحميل الثيم
            $themeManager = app(ThemeManager::class);
            $themeManager->setActiveTheme($request->active_theme);
        }

        // مسح جميع الكاشات
        Cache::flush(); // مسح جميع الكاشات
        Cache::forget('settings');
        Cache::forget('app_settings');
        Cache::forget('store_name');
        Cache::forget('store_description');
        Cache::forget('store_logo');
        Cache::forget('setting_store_name');
        
        // مسح كاش التطبيق
        Artisan::call('optimize:clear');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        
        // تحديث اسم التطبيق في التكوين
        if (isset($inputs['store_name'])) {
            config(['app.name' => $inputs['store_name']]);
            // تحديث اسم المتجر في الكاش
            Cache::put('store_name', $inputs['store_name'], now()->addYear());
            Cache::put('setting_store_name', $inputs['store_name'], now()->addYear());
        }
        
        return redirect()->route('dashboard.settings.index')
            ->with('success', 'تم تحديث الإعدادات بنجاح');
    }

    /**
     * تحديث عناوين أقسام الفوتر (الروابط السريعة والسياسات) مباشرة من صفحة إدارة الصفحات
     */
    public function updateFooterTitle(Request $request)
    {
        $request->validate([
            'key' => 'required|in:footer_links_title,footer_policies_title',
            'value' => 'required|string|max:100',
        ]);
        \App\Models\Setting::set($request->key, $request->value);
        return response()->json(['success' => true, 'message' => 'تم تحديث العنوان بنجاح']);
    }

    /**
     * رفع أيقونات وسائل الدفع وتخزينها في settings
     */
    public function uploadPaymentIcons(Request $request)
    {
        $request->validate([
            'payment_icons.*' => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:2048'
        ]);

        if ($request->hasFile('payment_icons')) {
            $result = $this->imageUploader->uploadMultiple(
                $request->file('payment_icons'),
                'payment-icons'
            );
            
            if (!$result['success']) {
                return redirect()->back()
                    ->withErrors(['payment_icons' => 'حدث خطأ أثناء رفع الصور'])
                    ->withInput();
            }
            
            // حفظ مسارات الصور في الإعدادات
            $currentIcons = json_decode(Setting::get('footer_payment_icons', '[]'), true);
            $newIcons = array_merge($currentIcons, $result['paths']);
            Setting::set('footer_payment_icons', json_encode($newIcons));
        }

        return redirect()->back()->with('success', 'تم رفع أيقونات الدفع بنجاح');
    }

    /**
     * حذف أيقونة وسيلة دفع من التخزين وتحديث settings
     */
    public function deletePaymentIcon(Request $request)
    {
        $request->validate([
            'icon' => 'required|string'
        ]);

        $icons = json_decode(Setting::get('footer_payment_icons', '[]'), true);
        $iconToDelete = $request->icon;
        
        if (in_array($iconToDelete, $icons)) {
            $this->imageUploader->deleteImage($iconToDelete);
            $icons = array_diff($icons, [$iconToDelete]);
            $icons = array_values($icons); // إعادة ترتيب المصفوفة
            Setting::set('footer_payment_icons', json_encode($icons));
        }

        return redirect()->back()->with('success', 'تم حذف الأيقونة بنجاح');
    }

    /**
     * عرض صفحة الأكواد المخصصة (CSS/JS)
     */
    public function customCode()
    {
        $custom_head_css = Setting::get('custom_head_css', '');
        $custom_head_js = Setting::get('custom_head_js', '');
        $custom_footer_js = Setting::get('custom_footer_js', '');
        return view('themes.dashboard.settings.custom_code', compact('custom_head_css', 'custom_head_js', 'custom_footer_js'));
    }

    /**
     * حفظ الأكواد المخصصة (CSS/JS)
     */
    public function saveCustomCode(Request $request)
    {
        Setting::set('custom_head_css', $request->input('custom_head_css', ''));
        Setting::set('custom_head_js', $request->input('custom_head_js', ''));
        Setting::set('custom_footer_js', $request->input('custom_footer_js', ''));
        return redirect()->route('dashboard.settings.custom_code')->with('success', 'تم حفظ الأكواد المخصصة بنجاح');
    }

    /**
     * تحديث الكاش
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearCache()
    {
        // مسح كاش الإعدادات
        Setting::clearCache();
        
        // مسح كاش التطبيق
        Artisan::call('optimize:clear');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        
        // تحديث اسم التطبيق في التكوين
        $storeName = Setting::get('store_name');
        if ($storeName) {
            config(['app.name' => $storeName]);
        }
        
        return redirect()->route('dashboard.settings.index')
            ->with('success', 'تم تحديث الكاش بنجاح');
    }
} 