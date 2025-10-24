<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DigitalCardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomOrderController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PhoneAuthController; // Added for phone auth
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\WhatsAppController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\GameController;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Http\Controllers\Admin\OnlineUsersController;

// require __DIR__.'/dashboard.php';

// تضمين مسارات لوحة التحكم
require __DIR__.'/admin.php';

// dashboard 

// تضمين مسارات التقييمات
require __DIR__.'/reviews.php';

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// الصفحة الرئيسية
Route::get('/', [HomeController::class, 'index'])->name('home');

// مسار التاغات المختصر
Route::get('/tag/{product}/{tag}', [ProductController::class, 'productByTag'])->name('products.tag');

// مسارات المنتجات/الحسابات
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/products/featured', [ProductController::class, 'featured'])->name('products.featured');
Route::get('/products/best-sellers', [ProductController::class, 'bestSellers'])->name('products.best-sellers');
Route::post('/products/filter-popular', [ProductController::class, 'filterPopularProducts'])->name('products.filter-popular');
Route::get('/category/{slug}', [ProductController::class, 'category'])->name('category.show');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// أدوات النظام (مؤقتة)
Route::get('/system/generate-share-slugs', [ProductController::class, 'generateShareSlugs']);

// مسارات البطاقات الرقمية
Route::get('/digital-cards', [DigitalCardController::class, 'index'])->name('digital-cards.index');
Route::get('/digital-cards/featured', [DigitalCardController::class, 'featured'])->name('digital-cards.featured');
Route::get('/digital-cards/{slug}', [DigitalCardController::class, 'show'])->name('digital-cards.show');

// سلة التسوق
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'addItem'])->name('cart.add');
Route::put('/cart/{id}', [CartController::class, 'updateItem'])->name('cart.update');
Route::delete('/cart/{id}', [CartController::class, 'removeItem'])->name('cart.remove');
Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');

// Debug route
Route::get('/debug-session', function() {
    return response()->json([
        'session_id' => session()->getId(),
        'cart_session_id' => session()->get('cart_session_id'),
        'cart_count' => session()->get('cart_count'),
        'all_session' => session()->all(),
        'user_id' => auth()->id(),
    ]);
});
Route::get('/cart/init', [CartController::class, 'initializeCartSession'])->name('cart.init');

// كوبونات الخصم
Route::post('/cart/coupon', [CouponController::class, 'applyCoupon'])->name('cart.apply-coupon');
Route::post('/cart/coupon/remove', [CouponController::class, 'removeCoupon'])->name('cart.remove-coupon');
Route::post('/coupon/check', [CouponController::class, 'checkCoupon'])->name('coupon.check');

// مسارات تتبع الطلبات
Route::get('/track-order', [OrderController::class, 'track'])->name('orders.track');

// مسار تقييم المنتجات الجديد للاختبار (بدون تحقق)
Route::post('/test-product-rate', function (Illuminate\Http\Request $request) {
    try {
        // التحقق من البيانات
        $request->validate([
            'product_id' => 'required|numeric',
            'product_type' => 'required|string',
            'order_item_id' => 'required|numeric',
            'rating' => 'required|numeric|min:1|max:5',
            'review' => 'nullable|string|max:500',
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'تم استلام التقييم بنجاح (وضع الاختبار)',
            'data' => $request->all()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'حدث خطأ: ' . $e->getMessage(),
        ], 422);
    }
})->name('test.product.rate')->middleware(['web']);

// مسار اختبار لحل مشكلة عدم العثور على المسار product/rate
Route::post('/review/rate', [ReviewController::class, 'store'])
    ->name('review.rate')
    ->middleware(['web']);

// إضافة مسار عام للتقييم للاختبار - يستخدم نفس المتحكم
Route::post('/product/rate-public', [ReviewController::class, 'store'])
    ->name('product.rate.public')
    ->middleware('web');

// Añadir ruta directa para el sistema de valoraciones
Route::post('/product/rate', [ReviewController::class, 'store'])->name('product.rate');

// عرض صفحة الاشتراكات - متاح للجميع
Route::get('/subscriptions', [SettingController::class, 'subscriptions'])->name('subscriptions.index');

// مسارات تحتاج تسجيل دخول
Route::middleware(['auth'])->group(function () {
    // ملف الحساب الشخصي
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [UserProfileController::class, 'updatePassword'])->name('profile.update-password');
    
    // الطلبات
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    
    // الطلبات المخصصة
    Route::get('/custom-orders', [CustomOrderController::class, 'index'])->name('custom-orders.index');
    Route::get('/custom-orders/create', [CustomOrderController::class, 'create'])->name('custom-orders.create');
    Route::post('/custom-orders', [CustomOrderController::class, 'store'])->name('custom-orders.store');
    Route::get('/custom-orders/{id}', [CustomOrderController::class, 'show'])->name('custom-orders.show');
    Route::post('/custom-orders/{id}/message', [CustomOrderController::class, 'sendMessage'])->name('custom-orders.message');
    
    // إتمام الطلب
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    // صفحات الدفع
    Route::get('/payment/credit-card/{order}', [PaymentController::class, 'creditCard'])->name('payment.creditcard');
    Route::get('/payment/bank-transfer/{order}', [PaymentController::class, 'bankTransfer'])->name('payment.bank_transfer');
    Route::post('/payment/complete/{order}', [PaymentController::class, 'complete'])->name('payment.complete');
    
    // كليك باي وبوابات الدفع
    Route::get('/payment/clickpay/{order}', [PaymentController::class, 'clickpay'])->name('payment.clickpay');
    Route::get('/payment/edfapay/{order}', [PaymentController::class, 'edfapay'])->name('payment.edfapay');

    // الاشتراكات - العمليات التي تحتاج تسجيل دخول
    Route::post('/subscriptions/subscribe/{plan}', [SettingController::class, 'subscribe'])->name('subscriptions.subscribe');
    Route::get('/subscriptions/payment/{subscription}', [SettingController::class, 'subscriptionPayment'])->name('subscriptions.payment');
    Route::post('/subscriptions/payment/complete/{subscription}', [SettingController::class, 'completeSubscriptionPayment'])->name('subscriptions.payment.complete');
    Route::get('/subscriptions/setup', [SettingController::class, 'subscriptionSetup'])->name('subscriptions.setup');
    Route::post('/subscriptions/setup/complete', [SettingController::class, 'completeSetup'])->name('subscriptions.setup.complete');
    Route::get('/subscriptions/setup/success', [SettingController::class, 'setupSuccess'])->name('subscriptions.setup.success');

    // التقييمات - المسار الجديد
    Route::post('/reviews/store', [ReviewController::class, 'store'])->name('reviews.store');
});

// مسارات استجابة بوابات الدفع - بدون تسجيل دخول
Route::prefix('payment/callback')->name('payment.callback.')->group(function () {
    Route::match(['GET', 'POST'], 'success', [PaymentController::class, 'clickpaySuccess'])->name('success');
    Route::match(['GET', 'POST'], 'cancel', [PaymentController::class, 'clickpayCancel'])->name('cancel');
    Route::match(['GET', 'POST'], 'edfapay-success', [PaymentController::class, 'edfapaySuccess'])->name('edfapay.success');
});

// مسارات ويب هوك بوابات الدفع
Route::prefix('payment/webhook')->name('payment.webhook.')->group(function () {
    Route::post('clickpay', [PaymentController::class, 'clickpayWebhook'])
        ->name('clickpay')
        ->withoutMiddleware(['csrf']);
    Route::post('edfapay', [PaymentController::class, 'edfapayWebhook'])
        ->name('edfapay')
        ->withoutMiddleware(['csrf']);
});

// الصفحات العامة
Route::get('/page/{slug}', [PageController::class, 'show'])->name('page.show');

Route::get('/about', function () {
    return redirect()->route('page.show', 'about');
})->name('about');

Route::get('/contact', function () {
    return redirect()->route('page.show', 'contact');
})->name('contact');

Route::get('/privacy-policy', function () {
    return redirect()->route('page.show', 'privacy');
})->name('privacy-policy');

Route::get('/terms', function () {
    return redirect()->route('page.show', 'terms');
})->name('terms');



// greenGame theme routes
Route::get('/games', [GameController::class, 'index'])->name('games.index');

// مسارات المصادقة (تحل محل Auth::routes())

// Phone Login Routes
Route::get('/login/phone', [PhoneAuthController::class, 'showPhoneEntryForm'])->name('login.phone.form');
Route::post('/login/phone', [PhoneAuthController::class, 'sendOtp'])->name('login.phone.send');
Route::get('/login/otp', [PhoneAuthController::class, 'showOtpEntryForm'])->name('login.otp.form');
// Route::post('/login/otp', [PhoneAuthController::class, 'verifyOtpAndProcess'])->name('login.otp.verify'); // AJAX flow uses login.phone.verify

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// في routes/web.php أو routes/auth.php
Route::post('/login/phone/verify', [App\Http\Controllers\Auth\PhoneAuthController::class, 'verifyOtp'])->name('login.phone.verify');

// مسارات استعادة كلمة المرور
Route::get('/password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Subscription Authentication Routes - Global pages not related to themes
Route::get('/subscription/login', [LoginController::class, 'showSubscriptionLoginForm'])->name('subscription.login');
Route::post('/subscription/login', [LoginController::class, 'subscriptionLogin'])->name('subscription.login.post');
Route::get('/subscription/register', [RegisterController::class, 'showSubscriptionRegistrationForm'])->name('subscription.register');
Route::post('/subscription/register', [RegisterController::class, 'subscriptionRegister'])->name('subscription.register.post');
Route::get('/password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

// مسار اختبار لتحديث كليك باي
Route::get('/test-clickpay-update', function () {
    return view('test-clickpay');
})->name('test.clickpay');

Route::post('/test-clickpay-update', function (Illuminate\Http\Request $request) {
    try {
        $paymentMethod = DB::table('payment_methods')->where('code', 'clickpay')->first();
        
        if (!$paymentMethod) {
            return "بوابة كليك باي غير موجودة";
        }
        
        $description = $request->input('description');
        $profile_id = $request->input('profile_id');
        $server_key = $request->input('server_key');
        $is_active = $request->has('is_active') ? 1 : 0;
        
        // تحضير بيانات الاعتماد
        $credentials = [
            'profile_id' => $profile_id,
            'server_key' => $server_key
        ];
        
        // تحديث البيانات بشكل مباشر
        $updated = DB::table('payment_methods')
            ->where('id', $paymentMethod->id)
            ->update([
                'description' => $description,
                'is_active' => $is_active,
                'credentials' => json_encode($credentials),
                'updated_at' => now()
            ]);
        
        return "تم التحديث بنجاح: " . ($updated ? 'نعم' : 'لا') . "<br>البيانات المُحدثة:<br>الوصف: $description<br>المعرف: $profile_id<br>المفتاح: $server_key<br>مفعل: " . ($is_active ? 'نعم' : 'لا');
        
    } catch (\Exception $e) {
        return "حدث خطأ: " . $e->getMessage();
    }
})->name('test.clickpay.update');

// مسار لعرض آخر سجلات بوابة الدفع
Route::get('/view-payment-logs', function () {
    try {
        $logFile = storage_path('logs/laravel.log');
        $logs = file_exists($logFile) ? file_get_contents($logFile) : '';
        
        // البحث عن سجلات بوابة الدفع
        $paymentLogs = [];
        $pattern = '/\[.*?\] local\.INFO: .*?(كليك باي|clickpay|payment|respStatus|tran_ref).*?(\{.*\})/i';
        
        if (preg_match_all($pattern, $logs, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $paymentLogs[] = [
                    'log' => $match[0],
                    'data' => $match[2] ?? '{}'
                ];
            }
        }
        
        // اخذ آخر 20 سجل فقط
        $paymentLogs = array_slice(array_reverse($paymentLogs), 0, 20);
        
        return view('payment-logs', [
            'logs' => $paymentLogs
        ]);
    } catch (\Exception $e) {
        return "حدث خطأ في قراءة السجلات: " . $e->getMessage();
    }
})->name('view.payment.logs');

// مسار لعرض سجلات الدفع بتنسيق JSON
Route::get('/api/payment-logs', function () {
    try {
        $logFile = storage_path('logs/laravel.log');
        $logs = file_exists($logFile) ? file_get_contents($logFile) : '';
        
        // البحث عن سجلات بوابة الدفع
        $paymentLogs = [];
        
        // البحث عن سجلات معينة مرتبطة ببوابة الدفع
        $patterns = [
            'respStatus' => '/\[.*?\] local\.INFO: .*?(respStatus).*?(\{.*\})/i',
            'tran_ref' => '/\[.*?\] local\.INFO: .*?(tran_ref).*?(\{.*\})/i',
            'بيانات الاستجابة' => '/\[.*?\] local\.INFO: بيانات الاستجابة الكاملة من كليك باي.*?(\{.*\})/i',
            'استجابة استعلام' => '/\[.*?\] local\.INFO: استجابة استعلام كليك باي.*?(\{.*\})/i',
            'نتيجة التحقق' => '/\[.*?\] local\.INFO: نتيجة التحقق من الدفع.*?(\{.*\})/i',
        ];
        
        foreach ($patterns as $type => $pattern) {
            if (preg_match_all($pattern, $logs, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $match) {
                    $jsonStr = $match[1] ?? $match[2] ?? '{}';
                    $paymentLogs[] = [
                        'type' => $type,
                        'timestamp' => substr($match[0], 1, 19),
                        'data' => json_decode($jsonStr, true)
                    ];
                }
            }
        }
        
        // ترتيب السجلات حسب التاريخ (من الأحدث إلى الأقدم)
        usort($paymentLogs, function($a, $b) {
            return strtotime($b['timestamp']) - strtotime($a['timestamp']);
        });
        
        // اخذ آخر 30 سجل فقط
        $paymentLogs = array_slice($paymentLogs, 0, 30);
        
        return response()->json($paymentLogs);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
})->name('api.payment.logs');

// مسار اختبار مباشر للتقييم (للتحقق من المشكلة)
Route::post('/test-rating-direct', [App\Http\Controllers\DebugController::class, 'testAddRating'])->name('debug.add-rating-direct');

// مسار تقييم المنتج للزوار (بدون مصادقة للاختبار)
Route::post('/guest-product-rate', [App\Http\Controllers\GuestRatingController::class, 'store'])->name('guest.product.rate');

// مسار اختبار واجهة API واتساب
Route::get('/test-whatsapp-api', function () {
    $service = app(App\Services\WhatsApp\WhatsAppService::class);
    return response()->json($service->testApiConnection());
});

// مسار اختبار وظيفة التقييم
Route::get('/test-rating', function () {
    return view('test-rating');
})->middleware(['auth'])->name('test.rating');

// مسارات تصحيح نظام التقييم
Route::prefix('debug')->middleware(['web'])->group(function () {
    Route::get('/test-rating', [App\Http\Controllers\DebugController::class, 'testRating'])->name('debug.test-rating');
    Route::post('/test-rating', [App\Http\Controllers\DebugController::class, 'testAddRating'])->name('debug.add-rating');
    Route::get('/reviews', [App\Http\Controllers\DebugController::class, 'viewReviews'])->name('debug.reviews');
});

// جلب قالب واتساب عبر AJAX
Route::get('admin/api/whatsapp/templates/{template}', [WhatsAppController::class, 'getTemplate'])->name('admin.api.whatsapp.template');

Route::post('admin/settings/update-footer-title', [SettingController::class, 'updateFooterTitle'])->name('admin.settings.updateFooterTitle');

Route::post('admin/settings/payment-icons/upload', [SettingController::class, 'uploadPaymentIcons'])->name('admin.settings.payment-icons.upload');
Route::post('admin/settings/payment-icons/delete', [SettingController::class, 'deletePaymentIcon'])->name('admin.settings.payment-icons.delete');
Route::get('settings/custom-code', [\App\Http\Controllers\Admin\SettingController::class, 'customCode'])->name('admin.settings.custom_code');
Route::post('settings/custom-code', [\App\Http\Controllers\Admin\SettingController::class, 'saveCustomCode'])->name('admin.settings.save_custom_code');

Route::get('/buy-now', [App\Http\Controllers\CartController::class, 'buyNow'])->name('cart.buyNow');

// MyFatoorah Payment Routes
Route::match(['GET', 'POST'], '/payment/myfatoorah/success', [\App\Http\Controllers\PaymentController::class, 'myfatoorahSuccess'])->name('payment.myfatoorah.success');
Route::match(['GET', 'POST'], '/payment/myfatoorah/cancel', [\App\Http\Controllers\PaymentController::class, 'myfatoorahCancel'])->name('payment.myfatoorah.cancel');
Route::post('/payment/myfatoorah/webhook', [\App\Http\Controllers\PaymentController::class, 'myfatoorahWebhook'])->name('payment.myfatoorah.webhook');
Route::get('/payment/myfatoorah/{order}', [\App\Http\Controllers\PaymentController::class, 'myfatoorah'])->name('payment.myfatoorah');

// Route لاختبار الكتابة في مجلد public
Route::get('/test-write', function () {
    file_put_contents(public_path('test.txt'), 'hello world');
    return 'تمت الكتابة!';
});

Route::get('/generate-sitemap', function () {
    $sitemap = Sitemap::create();

    // الصفحة الرئيسية
    $sitemap->add(Url::create('/'));

    // صفحة المنتجات الرئيسية
    $sitemap->add(Url::create('/products'));

    // روابط التصنيفات
    foreach (Category::all() as $category) {
        $sitemap->add(Url::create('/category/' . $category->slug));
    }

    // روابط المنتجات والتاقات
    foreach (Product::all() as $product) {
        $sitemap->add(Url::create('/products/' . $product->slug));

        // تحويل التاقات إلى مصفوفة بشكل صريح
        $tags = $product->tags;
        if (is_string($tags)) {
            $tags = json_decode($tags, true);
        }

        if (is_array($tags) && !empty($tags)) {
            foreach ($tags as $tag) {
                if (!empty($tag)) {
                    $sitemap->add(Url::create('/tag/' . $product->id . '/' . str_replace(' ', '-', $tag)));
                }
            }
        }
    }

    $sitemap->writeToFile(public_path('sitemap.xml'));

    return 'تم توليد خريطة الموقع بنجاح!';
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Online Users Routes
    Route::get('/online-users', [OnlineUsersController::class, 'index'])->name('online-users.index');
    Route::post('/online-users/update-activity', [OnlineUsersController::class, 'updateActivity'])->name('online-users.update-activity');
    Route::post('/online-users/clear-inactive', [OnlineUsersController::class, 'clearInactive'])->name('online-users.clear-inactive');
});

// ثابت لمدة الاتصال
Route::post('admin/online-users/update-activity', [\App\Http\Controllers\Admin\OnlineUsersController::class, 'updateActivity'])
    ->name('admin.online-users.update-activity');
    
// ثابت عام للمتابعة
Route::post('/online-users/update-activity-general', [\App\Http\Controllers\Admin\OnlineUsersController::class, 'updateActivity'])->name('online-users.update-activity-general');

Route::prefix('admin/products/{product}/accounts')->name('admin.products.accounts.')->group(function () {
    Route::post('/', [\App\Http\Controllers\Admin\AccountDigetalController::class, 'store'])->name('store');
    Route::put('/{account}', [\App\Http\Controllers\Admin\AccountDigetalController::class, 'update'])->name('update');
    Route::delete('/{account}', [\App\Http\Controllers\Admin\AccountDigetalController::class, 'destroy'])->name('destroy');
});

Route::get('admin/products/{product}/manage-accounts', [\App\Http\Controllers\Admin\ProductController::class, 'manageAccounts'])->name('admin.products.manage-accounts');

// Add this route for testing the Gamey theme
Route::get('/gamey-demo', [App\Http\Controllers\GameyThemeController::class, 'index'])->name('gamey.demo');

// ative theme handler route  
use App\Http\Controllers\ThemeController;

Route::post('/update-theme', [ThemeController::class, 'updateTheme'])->name('updateTheme');






















