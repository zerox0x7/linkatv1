<nav class="sticky top-0 z-50 w-full glass-effect py-3">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center space-x-4 space-x-reverse">
                <a href="{{ route('home') }}" class="flex items-center">
                    <div class="w-10 h-10 flex items-center justify-center bg-gradient-to-r from-primary to-secondary rounded-full">
                        <i class="ri-shopping-cart-2-line text-white ri-lg"></i>
                    </div>
                    <span class="text-2xl font-['Pacifico'] text-white mr-2">{{ config('app.name', 'متجر') }}</span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-4 space-x-reverse">
                <a href="{{ route('home') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('home') ? 'text-white bg-gray-800' : '' }}">
                    الرئيسية
                </a>
                <a href="{{ route('products.index') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('products.index') ? 'text-white bg-gray-800' : '' }}">
                    المنتجات
                </a>
                <a href="{{ route('products.featured') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('products.featured') ? 'text-white bg-gray-800' : '' }}">
                    العروض المميزة
                </a>
                <a href="{{ route('products.best-sellers') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('products.best-sellers') ? 'text-white bg-gray-800' : '' }}">
                    الأكثر مبيعاً
                </a>
                <a href="{{ route('subscriptions.index') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('subscriptions.*') ? 'text-white bg-gray-800' : '' }}">
                    <i class="ri-vip-crown-line ml-1"></i>
                    الاشتراكات
                </a>
                <a href="{{ route('page.show', 'contact') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('page.show') && request('slug') == 'contact' ? 'text-white bg-gray-800' : '' }}">
                    اتصل بنا
                </a>
            </div>

            <!-- Search (Desktop) -->
            <div class="hidden md:block relative max-w-md w-full mx-4">
                <form action="{{ route('products.index') }}" method="GET">
                    <input type="text" name="search" placeholder="ابحث عن حسابات الألعاب أو السوشيال ميديا..." 
                        class="w-full bg-[#1e1e1e] border border-[#3a3a3a] rounded-full py-2 px-4 pr-10 text-white placeholder-gray-400 focus:outline-none search-input"
                        value="{{ request('search') }}">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <button type="submit" class="text-gray-400 hover:text-white focus:outline-none">
                            <i class="ri-search-line"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Right Actions -->
            <div class="flex items-center space-x-5 space-x-reverse">
                <!-- Cart -->
                <a href="{{ route('cart.index') }}" class="relative w-9 h-9 flex items-center justify-center bg-[#1e1e1e] rounded-full">
                    <i class="ri-shopping-bag-line text-gray-300"></i>
                    @if(Cart::count() > 0)
                    <span class="absolute -top-1 -left-1 w-5 h-5 flex items-center justify-center bg-primary text-white text-xs rounded-full">
                        {{ Cart::count() }}
                    </span>
                    @endif
                </a>

                <!-- Theme Toggle -->
                <x-theme-switcher />

                <!-- User Menu (Desktop) -->
                @auth
                <div class="hidden md:block relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-300 hover:text-white focus:outline-none">
                        <span class="sr-only">فتح قائمة المستخدم</span>
                        <div class="w-9 h-9 flex items-center justify-center bg-gradient-to-r from-primary to-secondary rounded-full text-white font-bold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    </button>
                    <div x-show="open" @click.away="open = false" class="origin-top-right absolute left-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-[#1e1e1e] border border-[#3a3a3a] z-50">
                        <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white">
                            الملف الشخصي
                        </a>
                        <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white">
                            طلباتي
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-right px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white">
                                تسجيل الخروج
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="hidden md:block bg-gradient-to-r from-primary to-secondary text-white px-5 py-2 rounded-button font-medium whitespace-nowrap hover:opacity-90 transition-all neon-glow">
                    تسجيل الدخول
                </a>
                @endauth
                
                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" type="button" class="md:hidden text-gray-300 hover:bg-gray-700 hover:text-white rounded-md p-2 focus:outline-none">
                    <span class="sr-only">فتح القائمة</span>
                    <i class="ri-menu-line text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden mt-4">
            <!-- Search (Mobile) -->
            <div class="relative mb-4">
                <form action="{{ route('products.index') }}" method="GET">
                    <input type="text" name="search" placeholder="ابحث عن حسابات الألعاب أو السوشيال ميديا..." 
                        class="w-full bg-[#1e1e1e] border border-[#3a3a3a] rounded-full py-2 px-4 pr-10 text-white placeholder-gray-400 focus:outline-none search-input"
                        value="{{ request('search') }}">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <button type="submit" class="text-gray-400 hover:text-white focus:outline-none">
                            <i class="ri-search-line"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Mobile Navigation Links -->
            <div class="flex flex-col space-y-2">
                <a href="{{ route('home') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'text-white bg-gray-800' : '' }}">
                    الرئيسية
                </a>
                <a href="{{ route('products.index') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('products.index') ? 'text-white bg-gray-800' : '' }}">
                    المنتجات
                </a>
                <a href="{{ route('products.featured') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('products.featured') ? 'text-white bg-gray-800' : '' }}">
                    العروض المميزة
                </a>
                <a href="{{ route('products.best-sellers') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('products.best-sellers') ? 'text-white bg-gray-800' : '' }}">
                    الأكثر مبيعاً
                </a>
                <a href="{{ route('subscriptions.index') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('subscriptions.*') ? 'text-white bg-gray-800' : '' }}">
                    <i class="ri-vip-crown-line ml-1"></i>
                    الاشتراكات
                </a>
                <a href="{{ route('page.show', 'contact') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('page.show') && request('slug') == 'contact' ? 'text-white bg-gray-800' : '' }}">
                    اتصل بنا
                </a>
            </div>

            <!-- Mobile Auth Links -->
            @auth
            <div class="border-t border-gray-700 mt-4 pt-4 flex flex-col space-y-2">
                <div class="flex items-center px-3 py-2">
                    <div class="w-8 h-8 flex items-center justify-center bg-gradient-to-r from-primary to-secondary rounded-full text-white font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <span class="text-white font-medium mr-2">{{ auth()->user()->name }}</span>
                </div>
                <a href="{{ route('profile.show') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-base font-medium">
                    الملف الشخصي
                </a>
                <a href="{{ route('orders.index') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-base font-medium">
                    طلباتي
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-right text-gray-300 hover:text-white px-3 py-2 rounded-md text-base font-medium">
                        تسجيل الخروج
                    </button>
                </form>
            </div>
            @else
            <div class="border-t border-gray-700 mt-4 pt-4">
                <a href="{{ route('login') }}" class="block w-full bg-gradient-to-r from-primary to-secondary text-white px-4 py-2 rounded-button font-medium text-center">
                    تسجيل الدخول
                </a>
                <a href="{{ route('register') }}" class="block w-full bg-[#1e1e1e] border border-[#3a3a3a] text-gray-300 hover:text-white px-4 py-2 rounded-button font-medium text-center mt-2">
                    إنشاء حساب
                </a>
            </div>
            @endauth
        </div>
    </div>
</nav>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    });
</script>
@endpush 