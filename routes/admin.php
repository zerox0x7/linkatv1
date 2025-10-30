<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\HomeSectionController;
use App\Http\Controllers\Admin\HomeSectionSettingController;
use App\Http\Controllers\Admin\HomeSliderController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\WhatsAppController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\OnlineUsersController;
use App\Http\Controllers\CustomizerController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| U+U+O USOU. OO1OUSU? OU.USO1 U.O3OOOO U,U^O-Oc OU,U.O3OU^U,OO U^OUU^U+ OO-O OU,U.OU.U^O1Oc /admin
|
*/

Route::prefix('admin')->name('admin.')->middleware(['auth','customer'])->group(function () {
    // OU,OU?O-Oc OU,OOUSO3USOc U,U,U^O-Oc OU,OO-UU.
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('products/advanced-coupon', [ProductController::class, 'advancedCoupon'])->name('products.advanced-coupon');
    
    // OO_OOOc OU,U.U+OOOO U^OU,O-O3OO"OO
    Route::resource('products', ProductController::class);

    Route::post('products/{product}/toggle-featured', [ProductController::class, 'toggleFeatured'])->name('products.toggle-featured');
    Route::post('products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::post('products/{product}/mark-out-of-stock', [ProductController::class, 'markAsOutOfStock'])->name('products.mark-out-of-stock');
    Route::get('products/{product}/digital-codes', [ProductController::class, 'getDigitalCodes'])->name('products.get-digital-codes');
    Route::put('products/{product}/digital-codes', [ProductController::class, 'updateDigitalCodes'])->name('products.update-digital-codes');
    // OU?O-Oc OO_OOOc OU,OUU^OO_ OU,OU,U.USOc
    Route::get('products/{product}/manage-codes', [ProductController::class, 'manageCodes'])->name('products.manage-codes');
    Route::post('products/{product}/add-code', [ProductController::class, 'addCode'])->name('products.add-code');
    Route::post('products/{product}/add-multiple-codes', [ProductController::class, 'addMultipleCodes'])->name('products.add-multiple-codes');
    Route::delete('products/{product}/delete-code/{code}', [ProductController::class, 'deleteCode'])->name('products.delete-code');
    
    // إدارة التصنيفات
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    
    // مسارات إدارة التقييمات
    Route::resource('reviews', \App\Http\Controllers\Admin\ReviewController::class);
    Route::patch('reviews/{review}/toggle-approval', [\App\Http\Controllers\Admin\ReviewController::class, 'toggleApproval'])->name('reviews.toggle-approval');
    
    // إدارة البطاقات الرقمية
    Route::resource('digital-cards', \App\Http\Controllers\Admin\DigitalCardController::class);
    
    // OO_OOOc OU,OU,O"OO
    Route::resource('orders', OrderController::class)->except(['create', 'store']);
    Route::put('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
    Route::post('orders/{order}/whatsapp-alert', [App\Http\Controllers\Admin\WhatsAppController::class, 'sendOrderAlert'])->name('orders.whatsapp_alert');
    
    // OO_OOOc OU,U.O3OOrO_U.USU+
    Route::resource('users', UserController::class);
    
    // OU,OU,O"OO OU,U.OrOOOc
    Route::redirect('custom-orders', '/admin/custom_orders')->name('custom-orders.redirect');
    Route::resource('custom_orders', \App\Http\Controllers\Admin\CustomOrderController::class);
    Route::post('custom_orders/{custom_order}/reply', [\App\Http\Controllers\Admin\CustomOrderController::class, 'reply'])->name('custom_orders.reply');
    Route::put('custom_orders/{custom_order}/status', [\App\Http\Controllers\Admin\CustomOrderController::class, 'updateStatus'])->name('custom_orders.update_status');
    
    // 
    Route::get('marquee', [\App\Http\Controllers\Admin\MarqueeController::class, 'index'])->name('marquee');
    Route::post('marquee/save', [\App\Http\Controllers\Admin\MarqueeController::class, 'save'])->name('marquee.save');
    Route::post('marquee/update-item', [\App\Http\Controllers\Admin\MarqueeController::class, 'updateItem'])->name('marquee.update-item');
    Route::post('marquee/toggle-item', [\App\Http\Controllers\Admin\MarqueeController::class, 'toggleItem'])->name('marquee.toggle-item');
    Route::post('marquee/delete-item', [\App\Http\Controllers\Admin\MarqueeController::class, 'deleteItem'])->name('marquee.delete-item');
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::post('settings/clear-cache', [SettingController::class, 'clearCache'])->name('settings.clear-cache');
    Route::post('settings/payment-icons/upload', [SettingController::class, 'uploadPaymentIcons'])->name('admin.settings.payment-icons.upload');
    Route::post('settings/payment-icons/delete', [SettingController::class, 'deletePaymentIcon'])->name('admin.settings.payment-icons.delete');
    
    // إعدادات الأكواد المخصصة (CSS/JS)
    Route::get('settings/custom-code', [\App\Http\Controllers\Admin\SettingController::class, 'customCode'])->name('admin.settings.custom_code');
    Route::post('settings/custom-code', [\App\Http\Controllers\Admin\SettingController::class, 'saveCustomCode'])->name('admin.settings.save_custom_code');
    
    // OO_OOOc OOU, OU,O_U?O1
    Route::resource('payment-methods', PaymentMethodController::class);
    Route::post('payment-methods/{paymentMethod}/toggle-status', [PaymentMethodController::class, 'toggleStatus'])->name('payment-methods.toggle-status');
    
    // OU,OU,OOUSO U^OU,OO-OOOUSOO
    Route::get('reports/sales', [\App\Http\Controllers\Admin\ReportController::class, 'sales'])->name('reports.sales');
    Route::get('reports/users', [\App\Http\Controllers\Admin\ReportController::class, 'users'])->name('reports.users');
    
    // OO_OOOc OU,OU?O-OO OU,OOO"OOc
    Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);
    Route::get('home-manager', [\App\Http\Controllers\Admin\PageController::class, 'homeManager'])->name('pages.home-manager');
    
    // إدارة الصفحات الثابتة
    Route::resource('static-pages', \App\Http\Controllers\Admin\StaticPagesController::class);
    
    // OO_OOOc OU^OO"O OU,U?U^OO
    Route::resource('menu-links', \App\Http\Controllers\Admin\MenuLinkController::class);
    
    // U.O3OOOO OO_OOOc OU,O3U,OUSO_O
    Route::prefix('home-sliders')->name('home-sliders.')->group(function () {
        Route::get('/', [HomeSliderController::class, 'index'])->name('index');
        Route::get('/create', [HomeSliderController::class, 'create'])->name('create');
        Route::post('/', [HomeSliderController::class, 'store'])->name('store');
        Route::get('/{homeSlider}/edit', [HomeSliderController::class, 'edit'])->name('edit');
        Route::put('/{homeSlider}', [HomeSliderController::class, 'update'])->name('update');
        Route::delete('/{homeSlider}', [HomeSliderController::class, 'destroy'])->name('destroy');
        Route::patch('/{homeSlider}/toggle-status', [HomeSliderController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/update-order', [HomeSliderController::class, 'updateOrder'])->name('update-order');
    });
    
    // OO_OOOc UU^O"U^U+OO OU,OrOU.
    Route::get('coupons/generate-code', [CouponController::class, 'generateCode'])->name('coupons.generate-code');
    Route::resource('coupons', CouponController::class);
    Route::post('coupons/{coupon}/toggle-status', [CouponController::class, 'toggleStatus'])->name('coupons.toggle-status');

    // U.O3OOOO OO_OOOc OU,U^OOO3OO"
    Route::prefix('whatsapp')->name('whatsapp.')->group(function () {
        Route::get('/', [WhatsAppController::class, 'index'])->name('index');
        Route::get('/settings', [WhatsAppController::class, 'settings'])->name('settings');
        Route::post('/settings', [WhatsAppController::class, 'updateSettings'])->name('settings.update');
        Route::get('/templates', [WhatsAppController::class, 'templates'])->name('templates');
        Route::get('/templates/create', [WhatsAppController::class, 'createTemplate'])->name('templates.create');
        Route::post('/templates', [WhatsAppController::class, 'storeTemplate'])->name('templates.store');
        Route::get('/templates/{template}/edit', [WhatsAppController::class, 'editTemplate'])->name('templates.edit');
        Route::put('/templates/{template}', [WhatsAppController::class, 'updateTemplate'])->name('templates.update');
        Route::delete('/templates/{template}', [WhatsAppController::class, 'destroyTemplate'])->name('templates.destroy');
        Route::get('/test', [WhatsAppController::class, 'testPage'])->name('test');
        Route::post('/test/send', [WhatsAppController::class, 'sendTest'])->name('test.send');
        Route::get('/logs', [WhatsAppController::class, 'logs'])->name('logs');
        Route::patch('/templates/{template}/toggle', [WhatsAppController::class, 'toggleTemplateStatus'])->name('templates.toggle');
    });
    
    // U.O3OOOO API U.U+U?OU,Oc U,U,U^OOO3OO"
    Route::get('api/whatsapp/test-connection', [WhatsAppController::class, 'testApiConnection']);
    Route::get('api/whatsapp/templates/{template}', [WhatsAppController::class, 'getTemplate']);

    // Home Sections Management
    Route::resource('home-sections', HomeSectionController::class);
    Route::post('home-sections/reorder', [HomeSectionController::class, 'reorder'])->name('home-sections.reorder');
    Route::post('home-sections/{homeSection}/toggle-status', [HomeSectionController::class, 'toggleStatus'])->name('home-sections.toggle-status');
    

    Route::get('customizer/', [CustomizerController::class, 'index'])->name('customizer.index');
    Route::get('customizer/menu', [CustomizerController::class, 'menu'])->name('customizer.menu');
    Route::get('customizer/footer', [CustomizerController::class, 'footer'])->name('customizer.footer');
    Route::get('customizer/products-page', [CustomizerController::class, 'productsPage'])->name('customizer.products-page');
    Route::get('customizer/coupons-offers', [CustomizerController::class, 'couponsOffers'])->name('customizer.coupons-offers');
    Route::get('customizer/top-header', [CustomizerController::class, 'topHeader'])->name('customizer.top-header');
    // Home Section Settings Management (commented out the specialized routes)
    Route::prefix('home-section-settings')->name('home-section-settings.')->group(function () {
        Route::get('/', [HomeSectionSettingController::class, 'index'])->name('index');
        
        // Create and Store routes
        Route::get('/create', [HomeSectionSettingController::class, 'create'])->name('create');
        Route::post('/', [HomeSectionSettingController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [HomeSectionSettingController::class, 'edit'])->name('edit');
        Route::put('/{id}', [HomeSectionSettingController::class, 'update'])->name('update');
        Route::delete('/{id}', [HomeSectionSettingController::class, 'delete'])->name('delete');
        
        
        /* 
        // Products Section
        Route::get('/products', [HomeSectionSettingController::class, 'editProducts'])->name('edit-products');
        Route::post('/products', [HomeSectionSettingController::class, 'updateProducts'])->name('update-products');
        
        // Banner Section
        Route::get('/banner', [HomeSectionSettingController::class, 'editBanner'])->name('edit-banner');
        Route::post('/banner', [HomeSectionSettingController::class, 'updateBanner'])->name('update-banner');
        
        // Hero Section
        Route::get('/hero', [HomeSectionSettingController::class, 'editHero'])->name('edit-hero');
        Route::post('/hero', [HomeSectionSettingController::class, 'updateHero'])->name('update-hero');
        
        // Categories Section
        Route::get('/categories', [HomeSectionSettingController::class, 'editCategories'])->name('edit-categories');
        Route::post('/categories', [HomeSectionSettingController::class, 'updateCategories'])->name('update-categories');
        
        // Features Section
        Route::get('/features', [HomeSectionSettingController::class, 'editFeatures'])->name('edit-features');
        Route::post('/features', [HomeSectionSettingController::class, 'updateFeatures'])->name('update-features');
        
        // Testimonials Section
        Route::get('/testimonials', [HomeSectionSettingController::class, 'editTestimonials'])->name('edit-testimonials');
        Route::post('/testimonials', [HomeSectionSettingController::class, 'updateTestimonials'])->name('update-testimonials');
        
        // Newsletter Section
        Route::get('/newsletter', [HomeSectionSettingController::class, 'editNewsletter'])->name('edit-newsletter');
        Route::post('/newsletter', [HomeSectionSettingController::class, 'updateNewsletter'])->name('update-newsletter');
        */
        
        // Common Actions
        Route::post('/{id}/toggle-status', [HomeSectionSettingController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/reorder', [HomeSectionSettingController::class, 'reorder'])->name('reorder');
    });

    // إدارة المستخدمين المتواجدين
    Route::get('online-users', [\App\Http\Controllers\Admin\OnlineUsersController::class, 'index'])->name('online-users.index');
    Route::post('online-users/update-activity', [\App\Http\Controllers\Admin\OnlineUsersController::class, 'updateActivity'])->name('online-users.update-activity');
    Route::post('online-users/clear-inactive', [\App\Http\Controllers\Admin\OnlineUsersController::class, 'clearInactive'])->name('online-users.clear-inactive');

    // إدارة الثيمات وتخصيصها
    Route::prefix('themes')->name('themes.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ThemeController::class, 'index'])->name('index');
        Route::get('/customize', [\App\Http\Controllers\Admin\ThemeController::class, 'customize'])->name('customize');
        Route::get('/home-customize', [\App\Http\Controllers\Admin\ThemeController::class, 'customizeHome'])->name('home-customize');
        Route::get('/layout-builder', [\App\Http\Controllers\Admin\ThemeController::class, 'layoutBuilder'])->name('layout-builder');
        Route::get('/sections-control', [\App\Http\Controllers\Admin\ThemeController::class, 'sectionsControl'])->name('sections-control');
        Route::get('/custom-code', [\App\Http\Controllers\Admin\ThemeController::class, 'customCodePage'])->name('custom-code');
        Route::get('/custom-data', [\App\Http\Controllers\Admin\ThemeController::class, 'customDataPage'])->name('custom-data');
        Route::get('/media', [\App\Http\Controllers\Admin\ThemeController::class, 'mediaPage'])->name('media');
        Route::post('/update', [\App\Http\Controllers\Admin\ThemeController::class, 'update'])->name('update');
        Route::post('/switch', [\App\Http\Controllers\Admin\ThemeController::class, 'switchTheme'])->name('switch');
        Route::delete('/delete-image', [\App\Http\Controllers\Admin\ThemeController::class, 'deleteImage'])->name('delete-image');
    });
}); 
