<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'متجر حسابات الألعاب والسوشيال ميديا')</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>tailwind.config={theme:{extend:{colors:{primary:'#2196F3',secondary:'#9C27B0'},borderRadius:{'none':'0px','sm':'4px',DEFAULT:'8px','md':'12px','lg':'16px','xl':'20px','2xl':'24px','3xl':'32px','full':'9999px','button':'8px'}}}}</script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <style>
    :where([class^="ri-"])::before { content: "\f3c2"; }
    body {
        font-family: 'Cairo', sans-serif;
        background-color: #121212;
        color: #e0e0e0;
    }
    .glass-effect {
        background: rgba(18, 18, 18, 0.7);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .neon-glow {
        box-shadow: 0 0 10px rgba(33, 150, 243, 0.5), 0 0 20px rgba(156, 39, 176, 0.3);
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 0 15px rgba(33, 150, 243, 0.6), 0 0 30px rgba(156, 39, 176, 0.4);
    }
    .gradient-bg {
        background: linear-gradient(135deg, #121212 0%, #1e1e1e 100%);
    }
    .hero-gradient {
        background: linear-gradient(to right, rgba(18, 18, 18, 0.9) 0%, rgba(18, 18, 18, 0.7) 50%, rgba(18, 18, 18, 0.5) 100%);
    }
    .custom-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }
    .custom-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .switch-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        right: 0;
        left: 0;
        bottom: 0;
        background-color: #2a2a2a;
        transition: .4s;
        border-radius: 24px;
    }
    .switch-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        right: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    input:checked + .switch-slider {
        background-color: #2196F3;
    }
    input:checked + .switch-slider:before {
        transform: translateX(-26px);
    }
    .search-input:focus {
        box-shadow: 0 0 0 2px rgba(33, 150, 243, 0.5);
    }
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #1e1e1e;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #3a3a3a;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #2196F3;
    }
    </style>
    @yield('styles')
</head>
<body class="min-h-screen">
    <!-- Header -->
    <header class="glass-effect sticky top-0 z-50 py-3">
        <div class="container mx-auto px-4 flex items-center justify-between">
            <div class="flex items-center space-x-4 space-x-reverse">
                <a href="{{ route('home') }}" class="flex items-center">
                    <div class="w-10 h-10 flex items-center justify-center bg-gradient-to-r from-primary to-secondary rounded-full">
                        <i class="ri-shopping-cart-2-line text-white ri-lg"></i>
                    </div>
                    <span class="text-2xl font-['Pacifico'] text-white mr-2">logo</span>
                </a>
            </div>
            <div class="relative max-w-md w-full mx-4">
                <form action="{{ route('products.index') }}" method="GET">
                    <input type="text" name="search" placeholder="ابحث عن حسابات الألعاب أو السوشيال ميديا..." 
                        class="w-full bg-[#1e1e1e] border border-[#3a3a3a] rounded-full py-2 px-4 pr-10 text-white placeholder-gray-400 focus:outline-none search-input">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="ri-search-line text-gray-400"></i>
                    </div>
                </form>
            </div>
            <div class="flex items-center space-x-5 space-x-reverse">
                <a href="{{ route('cart.index') }}" class="w-9 h-9 flex items-center justify-center bg-[#1e1e1e] rounded-full relative">
                    <i class="ri-shopping-bag-line text-gray-300"></i>
                    <span class="absolute -top-1 -left-1 w-5 h-5 flex items-center justify-center bg-primary text-white text-xs rounded-full cart-count">
                        {{ Auth::check() ? Auth::user()->cart?->getItemsCount() ?? 0 : session()->get('cart_count', 0) }}
                    </span>
                </a>
                
                @auth
                    <a href="{{ route('profile.show') }}" class="w-9 h-9 flex items-center justify-center bg-[#1e1e1e] rounded-full">
                        <i class="ri-user-line text-gray-300"></i>
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-gradient-to-r from-primary to-secondary text-white px-5 py-2 rounded-button font-medium whitespace-nowrap hover:opacity-90 transition-all neon-glow">
                            تسجيل الخروج
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="bg-gradient-to-r from-primary to-secondary text-white px-5 py-2 rounded-button font-medium whitespace-nowrap hover:opacity-90 transition-all neon-glow">
                        تسجيل الدخول
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Categories Navigation -->
    <div class="container mx-auto px-4 mt-6">
        <div class="glass-effect rounded-lg p-2 flex items-center justify-between overflow-x-auto custom-scrollbar">
            <div class="flex space-x-2 space-x-reverse">
                <a href="{{ route('home') }}" class="@if(request()->routeIs('home')) bg-gradient-to-r from-primary to-secondary @else bg-[#1e1e1e] hover:bg-[#2a2a2a] @endif text-white px-5 py-2 rounded-button whitespace-nowrap">
                    <i class="ri-home-4-line ml-1"></i>الرئيسية
                </a>
                <a href="{{ route('products.index') }}" class="@if(request()->routeIs('products.*')) bg-gradient-to-r from-primary to-secondary @else bg-[#1e1e1e] hover:bg-[#2a2a2a] @endif text-white px-5 py-2 rounded-button whitespace-nowrap">
                    <i class="ri-gamepad-line ml-1"></i>حسابات الألعاب
                </a>
                <a href="{{ route('products.index', ['type' => 'social']) }}" class="@if(request()->has('type') && request()->type === 'social') bg-gradient-to-r from-primary to-secondary @else bg-[#1e1e1e] hover:bg-[#2a2a2a] @endif text-white px-5 py-2 rounded-button whitespace-nowrap">
                    <i class="ri-instagram-line ml-1"></i>حسابات السوشيال
                </a>
                <a href="{{ route('products.featured') }}" class="@if(request()->routeIs('products.featured')) bg-gradient-to-r from-primary to-secondary @else bg-[#1e1e1e] hover:bg-[#2a2a2a] @endif text-white px-5 py-2 rounded-button whitespace-nowrap">
                    <i class="ri-fire-line ml-1"></i>العروض المميزة
                </a>
                <a href="{{ route('products.best-sellers') }}" class="@if(request()->routeIs('products.best-sellers')) bg-gradient-to-r from-primary to-secondary @else bg-[#1e1e1e] hover:bg-[#2a2a2a] @endif text-white px-5 py-2 rounded-button whitespace-nowrap">
                    <i class="ri-award-line ml-1"></i>الأكثر مبيعاً
                </a>
            </div>
            <div class="flex items-center">
                <span class="text-gray-400 ml-2">الوضع الداكن</span>
                <label class="custom-switch">
                    <input type="checkbox" checked>
                    <span class="switch-slider"></span>
                </label>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="container mx-auto px-4 mt-4">
            <div class="bg-green-600 bg-opacity-20 border border-green-600 text-green-100 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container mx-auto px-4 mt-4">
            <div class="bg-red-600 bg-opacity-20 border border-red-600 text-red-100 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    @if(session('info'))
        <div class="container mx-auto px-4 mt-4">
            <div class="bg-blue-600 bg-opacity-20 border border-blue-600 text-blue-100 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('info') }}</span>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-16 pt-8 pb-4 border-t border-gray-800">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold text-white mb-4">متجر الحسابات</h3>
                    <p class="text-gray-400 mb-4">متجرك المتخصص في بيع حسابات الألعاب والسوشيال ميديا بأسعار تنافسية وضمان كامل.</p>
                    <div class="flex space-x-4 space-x-reverse">
                        <a href="#" class="w-9 h-9 flex items-center justify-center bg-[#1e1e1e] rounded-full">
                            <i class="ri-facebook-fill text-gray-300"></i>
                        </a>
                        <a href="#" class="w-9 h-9 flex items-center justify-center bg-[#1e1e1e] rounded-full">
                            <i class="ri-twitter-x-fill text-gray-300"></i>
                        </a>
                        <a href="#" class="w-9 h-9 flex items-center justify-center bg-[#1e1e1e] rounded-full">
                            <i class="ri-instagram-fill text-gray-300"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white mb-4">روابط سريعة</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-primary">الرئيسية</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-gray-400 hover:text-primary">حسابات الألعاب</a></li>
                        <li><a href="{{ route('products.index', ['type' => 'social']) }}" class="text-gray-400 hover:text-primary">حسابات السوشيال</a></li>
                        <li><a href="{{ route('products.featured') }}" class="text-gray-400 hover:text-primary">العروض المميزة</a></li>
                        <li><a href="{{ route('products.best-sellers') }}" class="text-gray-400 hover:text-primary">الأكثر مبيعاً</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white mb-4">حسابي</h3>
                    <ul class="space-y-2">
                        @auth
                            <li><a href="{{ route('profile.show') }}" class="text-gray-400 hover:text-primary">الملف الشخصي</a></li>
                            <li><a href="{{ route('orders.index') }}" class="text-gray-400 hover:text-primary">طلباتي</a></li>
                            <li><a href="{{ route('custom-orders.index') }}" class="text-gray-400 hover:text-primary">الطلبات المخصصة</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-primary">تسجيل الدخول</a></li>
                            <li><a href="{{ route('register') }}" class="text-gray-400 hover:text-primary">إنشاء حساب</a></li>
                        @endauth
                        <li><a href="{{ route('cart.index') }}" class="text-gray-400 hover:text-primary">سلة التسوق</a></li>
                        <li><a href="{{ route('orders.track') }}" class="text-gray-400 hover:text-primary">تتبع الطلب</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white mb-4">تواصل معنا</h3>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <i class="ri-mail-line ml-2 text-primary"></i>
                            <span class="text-gray-400">support@example.com</span>
                        </li>
                        <li class="flex items-center">
                            <i class="ri-phone-line ml-2 text-primary"></i>
                            <span class="text-gray-400">+966 555 555 555</span>
                        </li>
                        <li class="flex items-center">
                            <i class="ri-whatsapp-line ml-2 text-primary"></i>
                            <span class="text-gray-400">+966 555 555 555</span>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}" class="text-gray-400 hover:text-primary">صفحة الاتصال</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-4 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-500 text-sm">جميع الحقوق محفوظة &copy; {{ date('Y') }} - متجر حسابات الألعاب والسوشيال ميديا</p>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('privacy-policy') }}" class="text-gray-500 text-sm hover:text-primary ml-4">سياسة الخصوصية</a>
                    <a href="{{ route('terms') }}" class="text-gray-500 text-sm hover:text-primary">الشروط والأحكام</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            // يمكن إضافة المزيد من الجافا سكريبت هنا
        });
    </script>
    @yield('scripts')
</body>
</html> 