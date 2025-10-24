









<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'لوحة المسؤول') - {{ config('app.name') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
        }
        
        [x-cloak] {
            display: none !important;
        }
    </style>

    @stack('styles')
    <script>
        // عند تحميل الصفحة، اضبط كلاس dark حسب LocalStorage
        (function() {
            if (localStorage.getItem('theme') === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();

        // زر التبديل
        document.addEventListener('DOMContentLoaded', function() {
            var btn = document.getElementById('theme-toggle-btn');
            var moon = document.getElementById('moon-icon');
            var sun = document.getElementById('sun-icon');
            function updateThemeIcon() {
                var isDark = document.documentElement.classList.contains('dark');
                if (moon && sun) {
                    moon.style.display = isDark ? 'none' : 'inline';
                    sun.style.display = isDark ? 'inline' : 'none';
                }
            }
            if (btn) {
                btn.addEventListener('click', function() {
                    if(document.documentElement.classList.contains('dark')) {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('theme', 'light');
                    } else {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('theme', 'dark');
                    }
                    updateThemeIcon();
                });
                updateThemeIcon();
            }
        });
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen text-gray-900 dark:text-gray-100">
    <div x-data="{ sidebarOpen: false  }">
        <!-- Sidebar for desktop -->
        <div class="fixed inset-y-0 right-0 z-50 w-64 bg-white dark:bg-gray-800 shadow-lg transform transition-transform duration-300 lg:translate-x-0" 
             :class="{'translate-x-0': sidebarOpen, 'translate-x-full': !sidebarOpen}">
            
            <div class="flex items-center justify-between h-16 px-4 bg-white dark:bg-gray-800 border-b dark:border-gray-700">
                <div class="flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
                        @if(\App\Models\Setting::get('store_logo'))
                            <img src="{{ asset('storage/logos/' . basename(\App\Models\Setting::get('store_logo'))) }}" alt="{{ \App\Models\Setting::get('store_name', config('app.name')) }}" class="h-8 w-auto">
                        @else
                            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto">
                        @endif
                        <span class="text-xl font-bold text-gray-800 dark:text-gray-100 ml-2">{{ \App\Models\Setting::get('store_name', config('app.name')) }}</span>
                    </a>
                </div>
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 dark:text-gray-300 lg:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="py-4">
                <nav>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center px-4 py-3 hover:bg-blue-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-500 text-white dark:bg-blue-600 dark:text-white' : '' }}">
                        <svg class="w-5 h-5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span>لوحة التحكم</span>
                    </a>
                    
                    <!-- قائمة المنتجات والتصنيفات -->
                    <div x-data="{ open: {{ request()->routeIs('admin.products.*') || request()->routeIs('admin.categories.*') ? 'true' : 'false' }} }" class="">
                        <button @click="open = !open" type="button" class="flex items-center w-full px-4 py-3 hover:bg-blue-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 focus:outline-none" :class="{ 'bg-blue-500 text-white dark:bg-blue-600 dark:text-white': open }">
                            <svg class="w-5 h-5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <span>المنتجات والتصنيفات</span>
                            <svg class="w-4 h-4 mr-auto transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" class="pl-8" x-transition>
                            <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-2 hover:bg-blue-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 {{ request()->routeIs('admin.products.*') ? 'bg-blue-500 text-white dark:bg-blue-600 dark:text-white' : '' }}">
                                <i class="ri-shopping-bag-3-line ml-2"></i>
                                <span class="ml-2">المنتجات</span>
                            </a>
                            <a href="{{ route('admin.categories.index') }}" class="flex items-center px-4 py-2 hover:bg-blue-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 {{ request()->routeIs('admin.categories.*') ? 'bg-blue-500 text-white dark:bg-blue-600 dark:text-white' : '' }}">
                                <i class="ri-price-tag-3-line ml-2"></i>
                                <span class="ml-2">التصنيفات</span>
                            </a>
                            <a href="{{ route('admin.coupons.index') }}" class="flex items-center px-4 py-2 hover:bg-blue-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 {{ request()->routeIs('admin.coupons.*') ? 'bg-blue-500 text-white dark:bg-blue-600 dark:text-white' : '' }}">
                                <i class="ri-ticket-2-line ml-2"></i>
                                <span class="ml-2">أكواد الخصم</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- قائمة الطلبات والتقارير -->
                    <div x-data="{ open: {{ request()->routeIs('admin.orders.*') || request()->routeIs('admin.reports.*') ? 'true' : 'false' }} }" class="">
                        <button @click="open = !open" type="button" class="flex items-center w-full px-4 py-3 hover:bg-blue-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 focus:outline-none" :class="{ 'bg-blue-500 text-white dark:bg-blue-600 dark:text-white': open }">
                            <svg class="w-5 h-5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <span>الطلبات والتقارير</span>
                            <svg class="w-4 h-4 mr-auto transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" class="pl-8" x-transition>
                            <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-2 hover:bg-blue-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 {{ request()->routeIs('admin.orders.*') ? 'bg-blue-500 text-white dark:bg-blue-600 dark:text-white' : '' }}">
                                <i class="ri-file-list-3-line ml-2"></i>
                                <span class="ml-2">الطلبات</span>
                            </a>
                            <a href="{{ route('admin.reports.sales') }}" class="flex items-center px-4 py-2 hover:bg-blue-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 {{ request()->routeIs('admin.reports.*') ? 'bg-blue-500 text-white dark:bg-blue-600 dark:text-white' : '' }}">
                                <i class="ri-bar-chart-2-line ml-2"></i>
                                <span class="ml-2">التقارير</span>
                            </a>
                        </div>
                    </div>
                    
                    <a href="{{ route('admin.users.index') }}" 
                       class="flex items-center px-4 py-3 hover:bg-blue-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 {{ request()->routeIs('admin.users.*') ? 'bg-blue-500 text-white dark:bg-blue-600 dark:text-white' : '' }}">
                        <svg class="w-5 h-5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span>المستخدمين</span>
                    </a>

                    <!-- بوابات الدفع -->
                    <a href="{{ route('admin.payment-methods.index') }}"
                       class="flex items-center px-4 py-3 hover:bg-blue-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 {{ request()->routeIs('admin.payment-methods.*') ? 'bg-blue-500 text-white dark:bg-blue-600 dark:text-white' : '' }}">
                        <i class="ri-bank-card-line ml-3"></i>
                        <span>بوابات الدفع</span>
                    </a>

                    <!-- تقييمات المنتجات -->
                    <a href="{{ route('admin.reviews.index') }}"
                       class="flex items-center px-4 py-3 hover:bg-blue-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 {{ request()->routeIs('admin.reviews.*') ? 'bg-blue-500 text-white dark:bg-blue-600 dark:text-white' : '' }}">
                        <i class="ri-star-line ml-3"></i>
                        <span>تقييمات المنتجات</span>
                    </a>

                    <!-- آراء العملاء -->
                    <a href="{{ route('admin.site-reviews.index') }}"
                       class="flex items-center px-4 py-3 hover:bg-blue-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 {{ request()->routeIs('admin.site-reviews.*') ? 'bg-blue-500 text-white dark:bg-blue-600 dark:text-white' : '' }}">
                        <i class="ri-chat-3-line ml-3"></i>
                        <span>آراء العملاء</span>
                    </a>
                    
                    <!-- قائمة الإعدادات -->
                    <div x-data="{ open: {{ request()->routeIs('admin.home-sections.*') ? 'true' : 'false' }} }" class="">
                        <button @click="open = !open" type="button" class="flex items-center w-full px-4 py-3 hover:bg-blue-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 focus:outline-none" :class="{ 'bg-blue-500 text-white dark:bg-blue-600 dark:text-white': open }">
                            <i class="ri-layout-3-line w-5 h-5 ml-3"></i>
                            <span>إدارة واجهة الموقع</span>
                            <svg class="w-4 h-4 mr-auto transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" class="pl-8" x-transition>
                            <a href="{{ route('admin.home-sections.index') }}" class="flex items-center px-4 py-2 hover:bg-blue-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 {{ request()->routeIs('admin.home-sections.*') ? 'bg-blue-500 text-white dark:bg-blue-600 dark:text-white' : '' }}">
                                <i class="ri-settings-5-line ml-2"></i>
                                <span class="ml-2">إعدادات الواجهة</span>
                            </a>
                        </div>
                    </div>
                    
                    <div x-data="{ open: {{ request()->routeIs('admin.settings.*') || request()->routeIs('admin.pages.*') || request()->routeIs('admin.whatsapp.*') ? 'true' : 'false' }} }" class="">
                        <button @click="open = !open" type="button" class="flex items-center w-full px-4 py-3 hover:bg-blue-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 focus:outline-none" :class="{ 'bg-blue-500 text-white dark:bg-blue-600 dark:text-white': open }">
                            <svg class="w-5 h-5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>الإعدادات</span>
                            <svg class="w-4 h-4 mr-auto transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" class="pl-8" x-transition>
                            <a href="{{ route('admin.settings.index') }}" class="flex items-center px-4 py-2 hover:bg-blue-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 {{ request()->routeIs('admin.settings.*') ? 'bg-blue-500 text-white dark:bg-blue-600 dark:text-white' : '' }}">
                                <i class="ri-settings-3-line ml-2"></i>
                                <span class="ml-2">الإعدادات العامة</span>
                            </a>
                            <a href="{{ route('admin.settings.custom_code') }}" class="flex items-center px-4 py-2 hover:bg-blue-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 {{ request()->routeIs('admin.settings.custom_code') ? 'bg-blue-500 text-white dark:bg-blue-600 dark:text-white' : '' }}">
                                <i class="ri-code-s-slash-line ml-2"></i>
                                <span class="ml-2">الأكواد المخصصة (CSS/JS)</span>
                            </a>
                            <a href="{{ route('admin.pages.index') }}" class="flex items-center px-4 py-2 hover:bg-blue-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 {{ request()->routeIs('admin.pages.*') ? 'bg-blue-500 text-white dark:bg-blue-600 dark:text-white' : '' }}">
                                <i class="ri-pages-line ml-2"></i>
                                <span class="ml-2">الصفحات</span>
                            </a>
                            <a href="{{ route('admin.whatsapp.index') }}" class="flex items-center px-4 py-2 hover:bg-blue-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 {{ request()->routeIs('admin.whatsapp.*') ? 'bg-blue-500 text-white dark:bg-blue-600 dark:text-white' : '' }}">
                                <i class="ri-whatsapp-line ml-2"></i>
                                <span class="ml-2">إدارة إشعارات واتساب</span>
                            </a>
                            <a href="{{ route('admin.online-users.index') }}" class="flex items-center px-4 py-2 hover:bg-blue-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 {{ request()->routeIs('admin.online-users.*') ? 'bg-blue-500 text-white dark:bg-blue-600 dark:text-white' : '' }}">
                                <i class="ri-user-line ml-2"></i>
                                <span class="ml-2">المتواجدون الآن</span>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            
            <div class="absolute bottom-0 w-full border-t border-gray-200 dark:border-gray-700">
                <div class="px-4 py-4">
                    <div class="flex items-center justify-between">
                        @if(auth()->check() && auth()->user()->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="User avatar" class="h-8 w-8 rounded-full object-cover">
                        @else
                            <img src="{{ asset('images/default-avatar.png') }}" alt="User avatar" class="h-8 w-8 rounded-full object-cover">
                        @endif
                        <div class="mr-3">
                            <p class="text-sm font-medium text-gray-800 dark:text-gray-100">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="p-1 rounded-full text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="lg:mr-64 min-h-screen">
            <!-- Top navigation -->
            <div class="bg-white dark:bg-gray-800 shadow-md py-2 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 dark:text-gray-300 lg:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                
                <div class="flex items-center">
                    <a href="{{ route('home') }}" target="_blank" class="mr-4 p-1 rounded-full text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </a>
                    
                    <!-- زر تبديل الدارك مود مع أيقونتين -->
                    <button 
                        id="theme-toggle-btn"
                        class="ml-2 p-2 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200"
                        title="تبديل الوضع الليلي/النهاري">
                        <i id="moon-icon" class="ri-moon-line" style="display: none;"></i>
                        <i id="sun-icon" class="ri-sun-line" style="display: none;"></i>
                    </button>
                    
                    <div x-data="{ notificationsOpen: false }" class="relative">
                        <button @click="notificationsOpen = !notificationsOpen" class="p-1 rounded-full text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 relative">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                        </button>
                        
                        <div x-show="notificationsOpen" 
                             @click.away="notificationsOpen = false" 
                             x-cloak
                             class="absolute left-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-md shadow-lg overflow-hidden z-50">
                            <div class="p-3 border-b">
                                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200">الإشعارات</h3>
                            </div>
                            <div class="max-h-64 overflow-y-auto">
                                <div class="p-3 border-b hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <p class="text-sm text-gray-700 dark:text-gray-200">طلب جديد تم إنشاؤه</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">منذ 5 دقائق</p>
                                </div>
                                <div class="p-3 border-b hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <p class="text-sm text-gray-700 dark:text-gray-200">مستخدم جديد مسجل</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">منذ 30 دقيقة</p>
                                </div>
                            </div>
                            <div class="p-2 text-center border-t">
                                <a href="#" class="text-sm text-blue-500 dark:text-blue-300 hover:underline">عرض كل الإشعارات</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Page content -->
            <main class="py-6 px-4 sm:px-6 lg:px-8">
                @if (session('success'))
                    <div class="bg-green-100 dark:bg-green-900 border-r-4 border-green-500 text-green-700 dark:text-green-200 p-4 mb-6 rounded shadow" role="alert">
                        <p class="font-bold">نجاح!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="bg-red-100 dark:bg-red-900 border-r-4 border-red-500 text-red-700 dark:text-red-200 p-4 mb-6 rounded shadow" role="alert">
                        <p class="font-bold">خطأ!</p>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        // إعدادات Toastr
        if (typeof toastr !== 'undefined') {
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-left",
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut",
                "rtl": true
            };
            
            // عرض رسائل النجاح من الجلسة
            @if(session('success'))
                toastr.success('{{ session('success') }}');
            @endif
            
            // عرض رسائل الخطأ من الجلسة
            @if(session('error'))
                toastr.error('{{ session('error') }}');
            @endif
        }
    </script>
    
    @stack('scripts')
</body>
</html>   