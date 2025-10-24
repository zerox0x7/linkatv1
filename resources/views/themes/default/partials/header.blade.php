<header class="glass-effect sticky top-0 z-50 py-3">
    <div class="container mx-auto px-4 flex items-center justify-between">
        <div class="flex items-center space-x-4 space-x-reverse">
            <a href="{{ route('home') }}" class="flex items-center">
                @if(\App\Models\Setting::get('store_logo'))
                    <img src="{{ asset('storage/logos/' . basename(\App\Models\Setting::get('store_logo'))) }}" alt="{{ \App\Models\Setting::get('store_name', config('app.name')) }}" class="h-10 w-auto">
                @else
                    <div class="w-10 h-10 flex items-center justify-center bg-gradient-to-r from-primary to-secondary rounded-full">
                        <i class="ri-shopping-cart-2-line text-white ri-lg"></i>
                    </div>
                @endif      
                <span class="text-2xl font-['Pacifico'] text-white mr-2 hidden sm:inline">{{$name}}</span>
            </a>
        </div>
        
        @if(\App\Models\Setting::get('enable_search', true))
        <div class="relative max-w-md w-full mx-4 hidden sm:block">
            <form action="{{ route('products.index') }}" method="GET">
                <input type="text" name="search" placeholder="{{ \App\Models\Setting::get('search_placeholder', 'ابحث عن حسابات الألعاب أو السوشيال ميديا...') }}" 
                    class="w-full bg-[#1e1e1e] border border-[#3a3a3a] rounded-full py-2 px-4 pr-10 text-white placeholder-gray-400 focus:outline-none search-input">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <i class="ri-search-line text-gray-400"></i>
                </div>
            </form>
        </div>
        @endif
        
        <div class="flex items-center space-x-3 md:space-x-5 space-x-reverse">
            <!-- Search icon for mobile -->
            @if(\App\Models\Setting::get('enable_search', true))
            <button type="button" class="w-9 h-9 sm:hidden flex items-center justify-center bg-[#1e1e1e] rounded-full toggle-mobile-search">
                <i class="ri-search-line text-gray-300"></i>
            </button>
            @endif
            
            <a href="{{ route('cart.index') }}" class="w-9 h-9 flex items-center justify-center bg-[#1e1e1e] rounded-full relative">
                <i class="ri-shopping-bag-line text-gray-300"></i>
                <span class="absolute -top-1 -left-1 w-5 h-5 flex items-center justify-center bg-primary text-white text-xs rounded-full cart-count">
                    {{ auth()->check() && auth()->user()->cart ? auth()->user()->cart->getItemsCount() : 0 }}
                </span>
            </a>
            
            @auth
                <a href="{{ route('profile.show') }}" class="w-9 h-9 flex items-center justify-center bg-[#1e1e1e] rounded-full">
                    
                @if(auth()->user()->avatar)
                   <img  class="rounded-full" src="{{ Storage::url( auth()->user()->avatar) }}" alt="User Avatar">

                @else

                <i class="ri-user-line text-gray-300"></i>

                @endif
                </a>
                
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <!-- Desktop logout button -->
                    <button type="submit" class="hidden md:block bg-gradient-to-r from-primary to-secondary text-white px-5 py-2 rounded-button font-medium whitespace-nowrap hover:opacity-90 transition-all neon-glow">
                        {{ \App\Models\Setting::get('logout_text', 'تسجيل الخروج') }}
                    </button>
                    
                    <!-- Mobile logout icon -->
                    <button type="submit" class="md:hidden w-9 h-9 flex items-center justify-center bg-gradient-to-r from-primary to-secondary rounded-full">
                        <i class="ri-logout-box-line text-white"></i>
                    </button>
                </form>
            @else
                <!-- Desktop login button -->
                <a href="{{ route('login') }}" class="hidden md:block bg-gradient-to-r from-primary to-secondary text-white px-5 py-2 rounded-button font-medium whitespace-nowrap hover:opacity-90 transition-all neon-glow">
                    {{ \App\Models\Setting::get('login_text', 'تسجيل الدخول') }}
                </a>
                
                <!-- Mobile login icon -->
                <a href="{{ route('login') }}" class="md:hidden w-9 h-9 flex items-center justify-center bg-gradient-to-r from-primary to-secondary rounded-full">
                    <i class="ri-login-box-line text-white"></i>
                </a>
            @endauth
        </div>
    </div>
    
    <!-- Mobile search box (hidden by default) -->
    @if(\App\Models\Setting::get('enable_search', true))
    <div class="mobile-search-container hidden mt-3 px-4">
        <form action="{{ route('products.index') }}" method="GET" class="w-full">
            <div class="relative">
                <input type="text" name="search" placeholder="{{ \App\Models\Setting::get('search_placeholder', 'ابحث عن حسابات الألعاب أو السوشيال ميديا...') }}" 
                    class="w-full bg-[#1e1e1e] border border-[#3a3a3a] rounded-full py-2 px-4 pr-10 text-white placeholder-gray-400 focus:outline-none search-input">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <i class="ri-search-line text-gray-400"></i>
                </div>
            </div>
        </form>
    </div>
    @endif
</header>

@include('themes.default.partials.marquee')

<!-- Categories Navigation -->
<div class="container mx-auto px-4 mt-6 z-40 relative">
    <div class="glass-effect rounded-lg p-2 flex items-center justify-between overflow-x-auto custom-scrollbar">
        <div class="flex space-x-2 space-x-reverse">
            @if(\App\Models\Setting::get('show_home_button', true))
            <a href="{{ route('home') }}" class="@if(request()->routeIs('home')) bg-gradient-to-r from-primary to-secondary @else bg-[#1e1e1e] hover:bg-[#2a2a2a] @endif text-white px-5 py-2 rounded-button whitespace-nowrap">
                <i class="ri-home-4-line ml-1"></i>{{ \App\Models\Setting::get('home_text', 'الرئيسية') }}
            </a>
            @endif
            
            @if(\App\Models\Setting::get('show_games_button', true))
            <a href="{{ route('products.index') }}" class="@if(request()->routeIs('products.*') && !request()->routeIs('products.best-sellers')  && !request()->routeIs('products.featured')  && !request()->has('type')) bg-gradient-to-r from-primary to-secondary @else bg-[#1e1e1e] hover:bg-[#2a2a2a] @endif text-white px-5 py-2 rounded-button whitespace-nowrap">
                <i class="ri-gamepad-line ml-1"></i>{{ \App\Models\Setting::get('games_accounts_text', 'حسابات الألعاب') }}
            </a>
            @endif
            
            @if(\App\Models\Setting::get('show_social_button', true))
            <a href="{{ route('products.index', ['type' => 'social']) }}" class="@if(request()->has('type') && request()->type === 'social') bg-gradient-to-r from-primary to-secondary @else bg-[#1e1e1e] hover:bg-[#2a2a2a] @endif text-white px-5 py-2 rounded-button whitespace-nowrap">
                <i class="ri-instagram-line ml-1"></i>{{ \App\Models\Setting::get('social_accounts_text', 'حسابات السوشيال') }}
            </a>
            @endif
            
            @if(\App\Models\Setting::get('show_featured_button', true))
            <a href="{{ route('products.featured') }}" class="@if(request()->routeIs('products.featured')) bg-gradient-to-r from-primary to-secondary @else bg-[#1e1e1e] hover:bg-[#2a2a2a] @endif text-white px-5 py-2 rounded-button whitespace-nowrap">
                <i class="ri-fire-line ml-1"></i>{{ \App\Models\Setting::get('featured_text', 'العروض المميزة') }}
            </a>
            @endif
            
            @if(\App\Models\Setting::get('show_best_sellers_button', true))
            <a href="{{ route('products.best-sellers') }}" class="@if(request()->routeIs('products.best-sellers')) bg-gradient-to-r from-primary to-secondary @else bg-[#1e1e1e] hover:bg-[#2a2a2a] @endif text-white px-5 py-2 rounded-button whitespace-nowrap">
                <i class="ri-award-line ml-1"></i>{{ \App\Models\Setting::get('best_sellers_text', 'الأكثر مبيعاً') }}
            </a>
            @endif
            
            <!-- رابط خطط الاشتراك - متاح للجميع -->
            <a href="{{ route('subscriptions.index') }}" class="@if(request()->routeIs('subscriptions.*')) bg-gradient-to-r from-primary to-secondary @else bg-[#1e1e1e] hover:bg-[#2a2a2a] @endif text-white px-5 py-2 rounded-button whitespace-nowrap">
                <i class="ri-vip-crown-line ml-1"></i>خطط الاشتراك
            </a>
        </div>
        
        @if(\App\Models\Setting::get('show_dark_mode_button', true))
        <div class="flex items-center">
            <span class="text-gray-400 ml-2">{{ \App\Models\Setting::get('dark_mode_text', 'الوضع الداكن') }}</span>
            <label class="custom-switch">
                <input type="checkbox" checked>
                <span class="switch-slider"></span>
            </label>
        </div>
        @endif
    </div>
</div> 

<style>
/* إضافة أنماط CSS للتعامل مع تطبيق الألوان من الإعدادات */
:root {
    --primary-color: #{{ \App\Models\Setting::get('primary_color', '2196F3') }};
    --secondary-color: #{{ \App\Models\Setting::get('secondary_color', '9C27B0') }};
}

.from-primary {
    --tw-gradient-from: var(--primary-color);
    --tw-gradient-to: rgba(33, 150, 243, 0);
    --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
}

.to-secondary {
    --tw-gradient-to: var(--secondary-color);
}

.bg-primary {
    background-color: var(--primary-color);
}

.bg-secondary {
    background-color: var(--secondary-color);
}

/* تصحيح لمشكلة الألوان في أزرار التنقل */
.bg-gradient-to-r.from-primary.to-secondary {
    background-image: linear-gradient(to right, var(--primary-color), var(--secondary-color));
}

/* إضافة أنماط للمساعدة في تصميم الشاشات الصغيرة */
@media (max-width: 640px) {
    .mobile-search-container {
        animation: fadeIn 0.3s ease;
    }
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes marquee {
  0%   { transform: translateX(-100%); }
  100% { transform: translateX(100%); }
}
.animate-marquee {
  animation: marquee 25s linear infinite;
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle mobile search functionality
        const toggleSearchBtn = document.querySelector('.toggle-mobile-search');
        const mobileSearchContainer = document.querySelector('.mobile-search-container');
        
        if (toggleSearchBtn && mobileSearchContainer) {
            toggleSearchBtn.addEventListener('click', function() {
                mobileSearchContainer.classList.toggle('hidden');
                if (!mobileSearchContainer.classList.contains('hidden')) {
                    mobileSearchContainer.querySelector('input').focus();
                }
            });
        }
    });
</script> 