<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\SubscriptionPlan;
use App\Models\Subscription;
use App\Models\User;
use App\Services\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Controllers\Admin\ImageUploadController;
use Carbon\Carbon;

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
        
        return view('themes.admin.settings.index', compact('settings', 'themes', 'activeTheme'));
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
        
        return redirect()->route('admin.settings.index')
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
        return view('themes.admin.settings.custom_code', compact('custom_head_css', 'custom_head_js', 'custom_footer_js'));
    }

    /**
     * حفظ الأكواد المخصصة (CSS/JS)
     */
    public function saveCustomCode(Request $request)
    {
        Setting::set('custom_head_css', $request->input('custom_head_css', ''));
        Setting::set('custom_head_js', $request->input('custom_head_js', ''));
        Setting::set('custom_footer_js', $request->input('custom_footer_js', ''));
        return redirect()->route('admin.settings.custom_code')->with('success', 'تم حفظ الأكواد المخصصة بنجاح');
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
        
        return redirect()->route('admin.settings.index')
            ->with('success', 'تم تحديث الكاش بنجاح');
    }

    /**
     * عرض صفحة خطط الاشتراك
     */
    public function subscriptions()
    {
        $subscriptionPlans = SubscriptionPlan::active()->ordered()->get();
        $userSubscription = auth()->check() ? auth()->user()->activeSubscription : null;
        
        return view('subscriptions.index', compact('subscriptionPlans', 'userSubscription'));
    }

    /**
     * الاشتراك في خطة
     */
    public function subscribe(Request $request, SubscriptionPlan $plan)
    {
        $user = auth()->user();
        
        // التحقق من وجود اشتراك نشط
        if ($user->hasActiveSubscription()) {
            return redirect()->back()
                ->withErrors(['error' => 'لديك اشتراك نشط بالفعل. يرجى انتظار انتهائه قبل الاشتراك في خطة جديدة.']);
        }

        // إنشاء اشتراك جديد
        $subscription = Subscription::create([
            'user_id' => $user->id,
            'subscription_plan_id' => $plan->id,
            'status' => 'pending',
            'amount_paid' => $plan->price,
            'starts_at' => now(),
            'ends_at' => now()->addDays($plan->duration_days),
        ]);

        return redirect()->route('subscriptions.payment', $subscription)
            ->with('success', 'تم إنشاء الاشتراك بنجاح. يرجى إكمال عملية الدفع.');
    }

    /**
     * صفحة دفع الاشتراك
     */
    public function subscriptionPayment(Subscription $subscription)
    {
        // التحقق من أن الاشتراك يخص المستخدم المسجل
        if ($subscription->user_id !== auth()->id()) {
            abort(403, 'غير مسموح لك بالوصول لهذه الصفحة');
        }

        // التحقق من أن الاشتراك لم يتم دفعه بعد
        if ($subscription->status !== 'pending') {
            return redirect()->route('subscriptions.index')
                ->with('info', 'تم دفع هذا الاشتراك مسبقاً');
        }

        $paymentMethods = \App\Models\PaymentMethod::where('is_active', true)->get();
        
        return view('subscriptions.payment', compact('subscription', 'paymentMethods'));
    }

    /**
     * إتمام دفع الاشتراك
     */
    public function completeSubscriptionPayment(Request $request, Subscription $subscription)
    {
        $request->validate([
            'payment_method' => 'required|string'
        ]);

        // التحقق من أن الاشتراك يخص المستخدم المسجل
        if ($subscription->user_id !== auth()->id()) {
            abort(403, 'غير مسموح لك بالوصول لهذه الصفحة');
        }

        // التحقق من أن الاشتراك لم يتم دفعه بعد
        if ($subscription->status !== 'pending') {
            return redirect()->route('subscriptions.index')
                ->with('info', 'تم دفع هذا الاشتراك مسبقاً');
        }

        // في هذا المثال، سنفعل الاشتراك مباشرة
        // في التطبيق الحقيقي، يجب إدماج بوابة دفع حقيقية
        $subscription->update([
            'status' => 'active',
            'payment_method' => $request->payment_method,
            'payment_id' => 'sub_' . time() . '_' . $subscription->id,
            'paid_at' => now()
        ]);

        // التوجيه إلى صفحة إعداد المتجر
        return redirect()->route('subscriptions.setup')
            ->with('success', 'تم تفعيل اشتراكك بنجاح! الآن قم بإعداد متجرك.');
    }

    /**
     * صفحة إعداد المتجر بعد تفعيل الاشتراك
     */
    public function subscriptionSetup()
    {
        $user = auth()->user();

        // التحقق من وجود اشتراك نشط
        if (!$user->hasActiveSubscription()) {
            return redirect()->route('subscriptions.index')
                ->withErrors(['error' => 'يجب أن يكون لديك اشتراك نشط أولاً.']);
        }

        return view('subscriptions.setup');
    }

    /**
     * صفحة نجاح الإعداد مع دومين مخصص
     */
    public function setupSuccess()
    {
        $user = auth()->user();

        // التحقق من وجود custom_domain في session
        if (!session('custom_domain')) {
            return redirect()->route('admin.dashboard');
        }

        return view('subscriptions.setup-success', [
            'custom_domain' => session('custom_domain'),
            'store_url' => session('store_url'),
        ]);
    }

    /**
     * إتمام إعداد المتجر وحفظ البيانات
     */
    public function completeSetup(Request $request)
    {
        $user = auth()->user();

        // التحقق من وجود اشتراك نشط
        if (!$user->hasActiveSubscription()) {
            return redirect()->route('subscriptions.index')
                ->withErrors(['error' => 'يجب أن يكون لديك اشتراك نشط أولاً.']);
        }

        // التحقق من صحة البيانات
        $validated = $request->validate([
            'store_id' => 'required|string|max:255|regex:/^[a-zA-Z0-9-_]+$/',
            'active_theme' => 'required|string|in:default,gamey,greenGame,zain',
            'custom_domain' => 'nullable|string|max:255|regex:/^([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,}$/',
        ], [
            'store_id.required' => 'معرف المتجر مطلوب',
            'store_id.regex' => 'معرف المتجر يجب أن يحتوي على أحرف إنجليزية وأرقام وشرطة فقط',
            'active_theme.required' => 'يجب اختيار ثيم للمتجر',
            'active_theme.in' => 'الثيم المختار غير صالح',
            'custom_domain.regex' => 'صيغة الدومين غير صحيحة',
        ]);

        // التحقق من عدم تكرار store_id
        $existingUser = \App\Models\User::where('store_id', $validated['store_id'])
            ->where('id', '!=', $user->id)
            ->first();

        if ($existingUser) {
            return redirect()->back()
                ->withErrors(['store_id' => 'معرف المتجر مستخدم بالفعل. يرجى اختيار معرف آخر.'])
                ->withInput();
        }

        // التحقق من عدم تكرار custom_domain إذا تم إدخاله
        if (!empty($validated['custom_domain'])) {
            $existingDomain = \App\Models\User::where('custom_domain', $validated['custom_domain'])
                ->where('id', '!=', $user->id)
                ->first();

            if ($existingDomain) {
                return redirect()->back()
                    ->withErrors(['custom_domain' => 'الدومين مستخدم بالفعل. يرجى استخدام دومين آخر.'])
                    ->withInput();
            }
        }

        // حفظ البيانات في جدول users
        $user->update([
            'store_id' => $validated['store_id'],
            'active_theme' => $validated['active_theme'],
            'custom_domain' => $validated['custom_domain'] ?? null,
        ]);

        // إنشاء HomePage للمتجر إذا لم يكن موجوداً
        $homePage = \App\Models\HomePage::firstOrCreate(
            ['store_id' => $user->id],
            [
                'store_name' => $user->name . ' Store',
                'store_description' => 'متجري الإلكتروني',
                'is_active' => true,
            ]
        );

        // توجيه المستخدم بناءً على وجود دومين مخصص
        if (!empty($validated['custom_domain'])) {
            // إذا كان لديه دومين مخصص، نوجهه إلى صفحة نجاح خاصة تخبره بزيارة دومينه
            return redirect()->route('subscriptions.setup.success')
                ->with('custom_domain', $validated['custom_domain'])
                ->with('store_url', 'http://' . $validated['custom_domain']);
        } else {
            // إذا لم يكن لديه دومين، نوجهه إلى لوحة التحكم لإدارة متجره
            return redirect()->route('admin.dashboard')
                ->with('success', 'تم إعداد متجرك بنجاح! ابدأ الآن في إضافة المنتجات وإدارة متجرك.');
        }
    }
} 