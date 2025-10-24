@extends('themes.admin.layouts.app')

@section('title', 'إعدادات المتجر')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">إعدادات المتجر</h1>
        <div class="flex items-center space-x-4 space-x-reverse">
            <span class="text-sm text-gray-500 dark:text-gray-300">{{ now()->translatedFormat('l، j F Y') }}</span>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- معلومات المتجر الأساسية -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden md:col-span-2">
                    <div class="bg-gray-50 dark:bg-gray-900 px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100">معلومات المتجر الأساسية</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <!-- اسم المتجر -->
                        <div>
                            <label for="store_name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">اسم المتجر <span class="text-red-600">*</span></label>
                            <input type="text" name="store_name" id="store_name" value="{{ old('store_name', $settings['store_name'] ?? '') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100" required>
                            @error('store_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- الكلمات المفتاحية للمتجر -->
                        <div>
                            <label for="store_keywords" class="block text-sm font-medium text-gray-700 dark:text-gray-200">الكلمات المفتاحية (SEO Keywords)</label>
                            <input type="text" name="store_keywords" id="store_keywords" value="{{ old('store_keywords', $settings['store_keywords'] ?? '') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">افصل بين الكلمات بفاصلة (،) مثال: حسابات ألعاب، حسابات سوشيال ميديا، ببجي، فورتنايت</p>
                            @error('store_keywords')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- شعار المتجر -->
                        <div>
                            <label for="store_logo" class="block text-sm font-medium text-gray-700 dark:text-gray-200">شعار المتجر</label>
                            <div class="mt-1 flex items-center">
                                <span id="logo-preview" class="inline-block h-16 w-16 overflow-hidden bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md">
                                    @if(isset($settings['store_logo']) && $settings['store_logo'])
                                        <img src="{{ asset('storage/logos/' . basename($settings['store_logo'])) }}" alt="شعار المتجر" class="h-16 w-16 object-cover">
                                    @else
                                        <div class="flex items-center justify-center h-full w-full bg-gray-100 dark:bg-gray-800 text-gray-300 dark:text-gray-500">
                                            <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M19 13H5v-2h14v2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </span>
                                <div class="mr-4">
                                    <div class="relative bg-white dark:bg-gray-900 py-2 px-3 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm flex items-center cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <label for="store_logo" class="relative text-sm font-medium text-gray-700 dark:text-gray-200 pointer-events-none">
                                            <span>تغيير الشعار</span>
                                        </label>
                                        <input id="store_logo" name="store_logo" type="file" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer border-gray-300 dark:border-gray-700">
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PNG، JPG حتى 2 ميجا</p>
                                </div>
                            </div>
                            @error('store_logo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- وصف المتجر -->
                        <div>
                            <label for="store_description" class="block text-sm font-medium text-gray-700 dark:text-gray-200">وصف المتجر</label>
                            <textarea name="store_description" id="store_description" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">{{ old('store_description', $settings['store_description'] ?? '') }}</textarea>
                            @error('store_description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- إعدادات الهيدر والتنقل -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden md:col-span-2">
                    <div class="bg-gray-50 dark:bg-gray-900 px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100">الألوان والتنقل</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- الألوان الرئيسية -->
                        <div>
                            <h4 class="font-medium text-gray-700 dark:text-gray-200 mb-4">الألوان</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="primary_color" class="block text-sm font-medium text-gray-700 dark:text-gray-200">اللون الرئيسي</label>
                                    <div class="mt-1 flex items-center space-x-4 space-x-reverse">
                                        <input type="color" name="primary_color_picker" id="primary_color_picker" value="#{{ old('primary_color', $settings['primary_color'] ?? '2196F3') }}" 
                                            class="h-8 w-8 rounded-md border border-gray-300 dark:border-gray-700 shadow-sm color-picker cursor-pointer" data-color-type="primary">
                                        <input type="text" name="primary_color" id="primary_color" value="{{ old('primary_color', $settings['primary_color'] ?? 'primary') }}" 
                                            class="block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                                        <div class="preview-button px-4 py-2 text-white bg-gradient-to-r from-primary to-secondary rounded-md">معاينة</div>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">يمكنك استخدام رمز اللون (مثل 2196F3) بدون علامة #</p>
                                </div>
                                
                                <div>
                                    <label for="secondary_color" class="block text-sm font-medium text-gray-700 dark:text-gray-200">اللون الثانوي</label>
                                    <div class="mt-1 flex items-center space-x-4 space-x-reverse">
                                        <input type="color" name="secondary_color_picker" id="secondary_color_picker" value="#{{ old('secondary_color', $settings['secondary_color'] ?? '9C27B0') }}" 
                                            class="h-8 w-8 rounded-md border border-gray-300 dark:border-gray-700 shadow-sm color-picker cursor-pointer" data-color-type="secondary">
                                        <input type="text" name="secondary_color" id="secondary_color" value="{{ old('secondary_color', $settings['secondary_color'] ?? 'secondary') }}" 
                                            class="block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                                        <div class="preview-button px-4 py-2 text-white bg-gradient-to-r from-secondary to-primary rounded-md">معاينة</div>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">يمكنك استخدام رمز اللون (مثل 9C27B0) بدون علامة #</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- إعدادات البحث -->
                        <div>
                            <h4 class="font-medium text-gray-700 dark:text-gray-200 mb-4">مربع البحث</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="search_placeholder" class="block text-sm font-medium text-gray-700 dark:text-gray-200">نص البحث</label>
                                    <input type="text" name="search_placeholder" id="search_placeholder" value="{{ old('search_placeholder', $settings['search_placeholder'] ?? 'ابحث عن حسابات الألعاب أو السوشيال ميديا...') }}" 
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                                </div>
                                <div class="mt-4 relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="enable_search" name="enable_search" type="checkbox" value="1" {{ old('enable_search', $settings['enable_search'] ?? true) ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-700 rounded">
                                    </div>
                                    <div class="mr-3 text-sm">
                                        <label for="enable_search" class="font-medium text-gray-700 dark:text-gray-200">تفعيل البحث</label>
                                        <p class="text-gray-500 dark:text-gray-400">إظهار/إخفاء مربع البحث في الهيدر</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- إعدادات الهيدر -->
                        <div>
                            <h4 class="font-medium text-gray-700 dark:text-gray-200 mb-4">إعدادات الهيدر</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="mt-4 relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="show_quick_links_header" name="show_quick_links_header" type="checkbox" value="1" {{ old('show_quick_links_header', $settings['show_quick_links_header'] ?? true) ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-700 rounded">
                                    </div>
                                    <div class="mr-3 text-sm">
                                        <label for="show_quick_links_header" class="font-medium text-gray-700 dark:text-gray-200">إظهار الروابط السريعة في الهيدر</label>
                                        <p class="text-gray-500 dark:text-gray-400">يتم استعراض الصفحات المفعلة كروابط سريعة في الهيدر</p>
                                    </div>
                                </div>
                                
                                <div class="mt-4 relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="show_policies_header" name="show_policies_header" type="checkbox" value="1" {{ old('show_policies_header', $settings['show_policies_header'] ?? true) ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-700 rounded">
                                    </div>
                                    <div class="mr-3 text-sm">
                                        <label for="show_policies_header" class="font-medium text-gray-700 dark:text-gray-200">إظهار سياسات المتجر في الهيدر</label>
                                        <p class="text-gray-500 dark:text-gray-400">عرض قائمة منسدلة تحتوي على صفحات سياسات المتجر</p>
                                    </div>
                                </div>

                                <div>
                                    <label for="quick_links_title" class="block text-sm font-medium text-gray-700 dark:text-gray-200">عنوان الروابط السريعة</label>
                                    <input type="text" name="quick_links_title" id="quick_links_title" value="{{ old('quick_links_title', $settings['quick_links_title'] ?? 'روابط سريعة') }}" 
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                                </div>

                                <div>
                                    <label for="policies_title" class="block text-sm font-medium text-gray-700 dark:text-gray-200">عنوان السياسات</label>
                                    <input type="text" name="policies_title" id="policies_title" value="{{ old('policies_title', $settings['policies_title'] ?? 'سياسات المتجر') }}" 
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                                </div>

                                <div class="md:col-span-2">
                                    <div class="bg-blue-50 p-4 rounded-md">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <i class="ri-information-line text-blue-500"></i>
                                            </div>
                                            <div class="mr-3">
                                                <p class="text-sm text-blue-700 dark:text-gray-200">
                                                    يمكنك إدارة الصفحات وتحديد الصفحات التي تظهر في الهيدر من خلال 
                                                    <a href="{{ route('admin.pages.index') }}" class="font-medium underline">إدارة الصفحات</a>.
                                                    حدد خيار "إظهار في القائمة" للصفحات التي تريد عرضها.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- أزرار تسجيل الدخول/الخروج -->
                        <div>
                            <h4 class="font-medium text-gray-700 dark:text-gray-200 mb-4">أزرار الدخول والخروج</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="login_text" class="block text-sm font-medium text-gray-700 dark:text-gray-200">نص تسجيل الدخول</label>
                                    <input type="text" name="login_text" id="login_text" value="{{ old('login_text', $settings['login_text'] ?? 'تسجيل الدخول') }}" 
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                                </div>
                                
                                <div>
                                    <label for="logout_text" class="block text-sm font-medium text-gray-700 dark:text-gray-200">نص تسجيل الخروج</label>
                                    <input type="text" name="logout_text" id="logout_text" value="{{ old('logout_text', $settings['logout_text'] ?? 'تسجيل الخروج') }}" 
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                                </div>
                            </div>
                        </div>
                        
                        <!-- القائمة الرئيسية -->
                        <div>
                            <h4 class="font-medium text-gray-700 dark:text-gray-200 mb-4">أزرار القائمة الرئيسية</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div>
                                    <label for="home_text" class="block text-sm font-medium text-gray-700 dark:text-gray-200">الرئيسية</label>
                                    <div class="flex mt-1">
                                        <input type="text" name="home_text" id="home_text" value="{{ old('home_text', $settings['home_text'] ?? 'الرئيسية') }}" 
                                            class="block w-full border-gray-300 dark:border-gray-700 rounded-r-none rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                                        <div class="flex items-center px-3 py-2 bg-gray-100 dark:bg-gray-800 border border-r-0 border-gray-300 dark:border-gray-700 rounded-l-md">
                                            <input type="checkbox" name="show_home_button" id="show_home_button" value="1" {{ old('show_home_button', $settings['show_home_button'] ?? true) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-700 rounded">
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="games_accounts_text" class="block text-sm font-medium text-gray-700 dark:text-gray-200">حسابات الألعاب</label>
                                    <div class="flex mt-1">
                                        <input type="text" name="games_accounts_text" id="games_accounts_text" value="{{ old('games_accounts_text', $settings['games_accounts_text'] ?? 'حسابات الألعاب') }}" 
                                            class="block w-full border-gray-300 dark:border-gray-700 rounded-r-none rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                                        <div class="flex items-center px-3 py-2 bg-gray-100 dark:bg-gray-800 border border-r-0 border-gray-300 dark:border-gray-700 rounded-l-md">
                                            <input type="checkbox" name="show_games_button" id="show_games_button" value="1" {{ old('show_games_button', $settings['show_games_button'] ?? true) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-700 rounded">
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="social_accounts_text" class="block text-sm font-medium text-gray-700 dark:text-gray-200">حسابات السوشيال</label>
                                    <div class="flex mt-1">
                                        <input type="text" name="social_accounts_text" id="social_accounts_text" value="{{ old('social_accounts_text', $settings['social_accounts_text'] ?? 'حسابات السوشيال') }}" 
                                            class="block w-full border-gray-300 dark:border-gray-700 rounded-r-none rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                                        <div class="flex items-center px-3 py-2 bg-gray-100 dark:bg-gray-800 border border-r-0 border-gray-300 dark:border-gray-700 rounded-l-md">
                                            <input type="checkbox" name="show_social_button" id="show_social_button" value="1" {{ old('show_social_button', $settings['show_social_button'] ?? true) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-700 rounded">
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="featured_text" class="block text-sm font-medium text-gray-700 dark:text-gray-200">العروض المميزة</label>
                                    <div class="flex mt-1">
                                        <input type="text" name="featured_text" id="featured_text" value="{{ old('featured_text', $settings['featured_text'] ?? 'العروض المميزة') }}" 
                                            class="block w-full border-gray-300 dark:border-gray-700 rounded-r-none rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                                        <div class="flex items-center px-3 py-2 bg-gray-100 dark:bg-gray-800 border border-r-0 border-gray-300 dark:border-gray-700 rounded-l-md">
                                            <input type="checkbox" name="show_featured_button" id="show_featured_button" value="1" {{ old('show_featured_button', $settings['show_featured_button'] ?? true) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-700 rounded">
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="best_sellers_text" class="block text-sm font-medium text-gray-700 dark:text-gray-200">الأكثر مبيعاً</label>
                                    <div class="flex mt-1">
                                        <input type="text" name="best_sellers_text" id="best_sellers_text" value="{{ old('best_sellers_text', $settings['best_sellers_text'] ?? 'الأكثر مبيعاً') }}" 
                                            class="block w-full border-gray-300 dark:border-gray-700 rounded-r-none rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                                        <div class="flex items-center px-3 py-2 bg-gray-100 dark:bg-gray-800 border border-r-0 border-gray-300 dark:border-gray-700 rounded-l-md">
                                            <input type="checkbox" name="show_best_sellers_button" id="show_best_sellers_button" value="1" {{ old('show_best_sellers_button', $settings['show_best_sellers_button'] ?? true) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-700 rounded">
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="dark_mode_text" class="block text-sm font-medium text-gray-700 dark:text-gray-200">الوضع الداكن</label>
                                    <div class="flex mt-1">
                                        <input type="text" name="dark_mode_text" id="dark_mode_text" value="{{ old('dark_mode_text', $settings['dark_mode_text'] ?? 'الوضع الداكن') }}" 
                                            class="block w-full border-gray-300 dark:border-gray-700 rounded-r-none rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                                        <div class="flex items-center px-3 py-2 bg-gray-100 dark:bg-gray-800 border border-r-0 border-gray-300 dark:border-gray-700 rounded-l-md">
                                            <input type="checkbox" name="show_dark_mode_button" id="show_dark_mode_button" value="1" {{ old('show_dark_mode_button', $settings['show_dark_mode_button'] ?? true) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-700 rounded">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- إعدادات الفوتر -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden md:col-span-2">
                    <div class="bg-gray-50 dark:bg-gray-900 px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100">إعدادات الفوتر</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- وصف المتجر في الفوتر -->
                        <div>
                            <h4 class="font-medium text-gray-700 dark:text-gray-200 mb-4">وصف المتجر</h4>
                            <div>
                                <label for="footer_description" class="block text-sm font-medium text-gray-700 dark:text-gray-200">الوصف</label>
                                <textarea name="footer_description" id="footer_description" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">{{ old('footer_description', $settings['footer_description'] ?? 'أفضل متجر لشراء حسابات الألعاب والسوشيال ميديا. نقدم خدمات آمنة وموثوقة لجميع عملائنا.') }}</textarea>
                            </div>
                        </div>
                        
                        <!-- وسائل التواصل الاجتماعي -->
                        <div>
                            <h4 class="font-medium text-gray-700 dark:text-gray-200 mb-4">وسائل التواصل الاجتماعي</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <label for="social_facebook_url" class="block text-sm font-medium text-gray-700 dark:text-gray-200">رابط فيسبوك</label>
                                        <div class="flex items-center h-5">
                                            <input id="show_facebook" name="show_facebook" type="checkbox" value="1" {{ old('show_facebook', $settings['show_facebook'] ?? true) ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-700 rounded">
                                            <label for="show_facebook" class="mr-2 text-xs text-gray-600 dark:text-gray-400">إظهار</label>
                                        </div>
                                    </div>
                                    <div class="flex mt-1">
                                        <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 dark:border-gray-700 bg-gray-50 text-gray-500 dark:bg-gray-800">
                                            <i class="ri-facebook-fill"></i>
                                        </span>
                                        <input type="url" name="social_facebook_url" id="social_facebook_url" value="{{ old('social_facebook_url', $settings['social_facebook_url'] ?? '') }}" 
                                            class="block w-full border-gray-300 dark:border-gray-700 rounded-l-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <label for="social_twitter_url" class="block text-sm font-medium text-gray-700 dark:text-gray-200">رابط تويتر</label>
                                        <div class="flex items-center h-5">
                                            <input id="show_twitter" name="show_twitter" type="checkbox" value="1" {{ old('show_twitter', $settings['show_twitter'] ?? true) ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-700 rounded">
                                            <label for="show_twitter" class="mr-2 text-xs text-gray-600 dark:text-gray-400">إظهار</label>
                                        </div>
                                    </div>
                                    <div class="flex mt-1">
                                        <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 dark:border-gray-700 bg-gray-50 text-gray-500 dark:bg-gray-800">
                                            <i class="ri-twitter-x-fill"></i>
                                        </span>
                                        <input type="url" name="social_twitter_url" id="social_twitter_url" value="{{ old('social_twitter_url', $settings['social_twitter_url'] ?? '') }}" 
                                            class="block w-full border-gray-300 dark:border-gray-700 rounded-l-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <label for="social_instagram_url" class="block text-sm font-medium text-gray-700 dark:text-gray-200">رابط انستغرام</label>
                                        <div class="flex items-center h-5">
                                            <input id="show_instagram" name="show_instagram" type="checkbox" value="1" {{ old('show_instagram', $settings['show_instagram'] ?? true) ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-700 rounded">
                                            <label for="show_instagram" class="mr-2 text-xs text-gray-600 dark:text-gray-400">إظهار</label>
                                        </div>
                                    </div>
                                    <div class="flex mt-1">
                                        <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 dark:border-gray-700 bg-gray-50 text-gray-500 dark:bg-gray-800">
                                            <i class="ri-instagram-line"></i>
                                        </span>
                                        <input type="url" name="social_instagram_url" id="social_instagram_url" value="{{ old('social_instagram_url', $settings['social_instagram_url'] ?? '') }}" 
                                            class="block w-full border-gray-300 dark:border-gray-700 rounded-l-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <label for="social_whatsapp_url" class="block text-sm font-medium text-gray-700 dark:text-gray-200">رابط واتساب</label>
                                        <div class="flex items-center h-5">
                                            <input id="show_whatsapp" name="show_whatsapp" type="checkbox" value="1" {{ old('show_whatsapp', $settings['show_whatsapp'] ?? true) ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-700 rounded">
                                            <label for="show_whatsapp" class="mr-2 text-xs text-gray-600 dark:text-gray-400">إظهار</label>
                                        </div>
                                    </div>
                                    <div class="flex mt-1">
                                        <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 dark:border-gray-700 bg-gray-50 text-gray-500 dark:bg-gray-800">
                                            <i class="ri-whatsapp-line"></i>
                                        </span>
                                        <input type="url" name="social_whatsapp_url" id="social_whatsapp_url" value="{{ old('social_whatsapp_url', $settings['social_whatsapp_url'] ?? '') }}" 
                                            class="block w-full border-gray-300 dark:border-gray-700 rounded-l-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- عناوين أقسام الفوتر -->
                        <div>
                            <h4 class="font-medium text-gray-700 dark:text-gray-200 mb-4">عناوين الأقسام</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="footer_links_title" class="block text-sm font-medium text-gray-700 dark:text-gray-200">عنوان الروابط السريعة</label>
                                    <input type="text" name="footer_links_title" id="footer_links_title" value="{{ old('footer_links_title', $settings['footer_links_title'] ?? 'روابط سريعة') }}" 
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                                </div>
                                <div>
                                    <label for="footer_policies_title" class="block text-sm font-medium text-gray-700 dark:text-gray-200">عنوان السياسات</label>
                                    <input type="text" name="footer_policies_title" id="footer_policies_title" value="{{ old('footer_policies_title', $settings['footer_policies_title'] ?? 'السياسات') }}" 
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                                </div>
                                <div>
                                    <label for="footer_payment_title" class="block text-sm font-medium text-gray-700 dark:text-gray-200">عنوان وسائل الدفع</label>
                                    <input type="text" name="footer_payment_title" id="footer_payment_title" value="{{ old('footer_payment_title', $settings['footer_payment_title'] ?? 'وسائل الدفع') }}" 
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                                </div>
                            </div>
                        </div>
                        
                        <!-- إعدادات تذييل الفوتر -->
                        <div>
                            <h4 class="font-medium text-gray-700 dark:text-gray-200 mb-4">تذييل الصفحة</h4>
                            <div>
                                <label for="footer_copyright" class="block text-sm font-medium text-gray-700 dark:text-gray-200">نص حقوق الملكية</label>
                                <input type="text" name="footer_copyright" id="footer_copyright" value="{{ old('footer_copyright', $settings['footer_copyright'] ?? 'جميع الحقوق محفوظة.') }}" 
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">سيتم إضافة اسم المتجر وسنة النشر تلقائيًا</p>
                            </div>
                        </div>
                        
                        <!-- إظهار/إخفاء أقسام الفوتر -->
                        <div>
                            <h4 class="font-medium text-gray-700 dark:text-gray-200 mb-4">إظهار/إخفاء الأقسام</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="show_footer_about" name="show_footer_about" type="checkbox" value="1" {{ old('show_footer_about', $settings['show_footer_about'] ?? true) ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-700 rounded">
                                    </div>
                                    <div class="mr-3 text-sm">
                                        <label for="show_footer_about" class="font-medium text-gray-700 dark:text-gray-200">قسم معلومات المتجر</label>
                                        <p class="text-gray-500 dark:text-gray-400">يشمل اسم المتجر والوصف ووسائل التواصل</p>
                                    </div>
                                </div>
                                
                                <div class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="show_footer_links" name="show_footer_links" type="checkbox" value="1" {{ old('show_footer_links', $settings['show_footer_links'] ?? true) ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-700 rounded">
                                    </div>
                                    <div class="mr-3 text-sm">
                                        <label for="show_footer_links" class="font-medium text-gray-700 dark:text-gray-200">قسم الروابط السريعة</label>
                                    </div>
                                </div>
                                
                                <div class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="show_footer_policies" name="show_footer_policies" type="checkbox" value="1" {{ old('show_footer_policies', $settings['show_footer_policies'] ?? true) ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-700 rounded">
                                    </div>
                                    <div class="mr-3 text-sm">
                                        <label for="show_footer_policies" class="font-medium text-gray-700 dark:text-gray-200">قسم السياسات</label>
                                    </div>
                                </div>
                                
                                <div class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="show_footer_payment" name="show_footer_payment" type="checkbox" value="1" {{ old('show_footer_payment', $settings['show_footer_payment'] ?? true) ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-700 rounded">
                                    </div>
                                    <div class="mr-3 text-sm">
                                        <label for="show_footer_payment" class="font-medium text-gray-700 dark:text-gray-200">قسم وسائل الدفع</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- معلومات التواصل -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                    <div class="bg-gray-50 dark:bg-gray-900 px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100">معلومات التواصل</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <!-- البريد الإلكتروني -->
                        <div>
                            <label for="contact_email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">البريد الإلكتروني <span class="text-red-600">*</span></label>
                            <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100" required>
                            @error('contact_email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- رقم الهاتف -->
                        <div>
                            <label for="contact_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-200">رقم الهاتف</label>
                            <input type="text" name="contact_phone" id="contact_phone" value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                            @error('contact_phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- العنوان -->
                        <div>
                            <label for="contact_address" class="block text-sm font-medium text-gray-700 dark:text-gray-200">العنوان</label>
                            <textarea name="contact_address" id="contact_address" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">{{ old('contact_address', $settings['contact_address'] ?? '') }}</textarea>
                            @error('contact_address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    حفظ الإعدادات وتحديث الكاش
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // تحويل قيم اللون الى الصيغة السداسية عند التحميل
        function updateColorPickerFromText() {
            var primaryColorValue = $('#primary_color').val();
            var secondaryColorValue = $('#secondary_color').val();
            
            // إذا كانت القيمة ليست بصيغة hex (# مثل primary, secondary)
            if (!/^[0-9A-F]{6}$/i.test(primaryColorValue)) {
                // استخدم اللون الافتراضي للمعاينة
                $('#primary_color_picker').val('#2196F3');
            } else {
                $('#primary_color_picker').val('#' + primaryColorValue);
            }
            
            if (!/^[0-9A-F]{6}$/i.test(secondaryColorValue)) {
                // استخدم اللون الافتراضي للمعاينة
                $('#secondary_color_picker').val('#9C27B0');
            } else {
                $('#secondary_color_picker').val('#' + secondaryColorValue);
            }
            
            // تحديث نمط الأزرار المعاينة
            updatePreviewButtons();
        }
        
        // تحديث أزرار المعاينة
        function updatePreviewButtons() {
            var primaryColor = $('#primary_color_picker').val();
            var secondaryColor = $('#secondary_color_picker').val();
            
            $('.preview-button').eq(0).css({
                'background-image': 'linear-gradient(to right, ' + primaryColor + ', ' + secondaryColor + ')'
            });
            
            $('.preview-button').eq(1).css({
                'background-image': 'linear-gradient(to right, ' + secondaryColor + ', ' + primaryColor + ')'
            });
        }
        
        // تشغيل الدالة عند تحميل الصفحة
        updateColorPickerFromText();
        
        // ربط مدخلات اللون بمنتقي اللون
        $('#primary_color_picker').on('input', function() {
            // استخراج قيمة اللون بدون علامة #
            var colorValue = $(this).val().replace('#', '');
            $('#primary_color').val(colorValue);
            updatePreviewButtons();
        });
        
        $('#secondary_color_picker').on('input', function() {
            // استخراج قيمة اللون بدون علامة #
            var colorValue = $(this).val().replace('#', '');
            $('#secondary_color').val(colorValue);
            updatePreviewButtons();
        });
        
        // عند تغيير قيمة حقل النص، قم بتحديث منتقي اللون
        $('#primary_color').on('input', function() {
            updateColorPickerFromText();
        });
        
        $('#secondary_color').on('input', function() {
            updateColorPickerFromText();
        });
        
        // معاينة الصورة عند اختيارها
        $('#store_logo').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#logo-preview').html('<img src="' + e.target.result + '" alt="معاينة الشعار" class="h-16 w-16 object-cover">');
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endpush
@endsection 