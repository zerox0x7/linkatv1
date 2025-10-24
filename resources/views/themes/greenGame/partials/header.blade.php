<!-- Header -->
@if($headerSettings && $headerSettings->header_enabled)
<header class="bg-[#0f172a] border-b border-gray-800 {{ $headerSettings->header_sticky ? 'sticky top-0' : '' }} z-50 {{ $headerSettings->header_smooth_transitions ? 'transition-all duration-300 ease-in-out' : '' }} {{ $headerSettings->header_layout === 'centered' ? 'text-center' : ($headerSettings->header_layout === 'full-width' ? 'w-full' : '') }}" 
        style="font-family: {{ $headerSettings->header_font }}; {{ $headerSettings->header_shadow ? 'box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(255, 255, 255, 0.05);' : '' }}"
        @if($headerSettings->header_scroll_effects)
        data-scroll-header="true"
        @endif>
        
        @if($headerSettings->header_custom_css)
        <style>
            {!! $headerSettings->header_custom_css !!}
        </style>
        @endif
        
        @if($headerSettings->header_shadow)
        <style>
            /* Enhanced header shadow effect */
            header {
                position: relative;
            }
            header::after {
                content: '';
                position: absolute;
                bottom: -1px;
                left: 0;
                right: 0;
                height: 1px;
                background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.3) 20%, rgba(59, 130, 246, 0.5) 50%, rgba(59, 130, 246, 0.3) 80%, transparent);
                z-index: -1;
            }
        </style>
        @endif
        
        @if($headerSettings->header_scroll_effects)
        <style>
            [data-scroll-header="true"] {
                transition: all 0.3s ease-in-out;
            }
            [data-scroll-header="true"].scrolled {
                background-color: rgba(15, 23, 42, 0.95);
                backdrop-filter: blur(10px);
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1){{ $headerSettings->header_shadow ? ', 0 10px 25px -5px rgba(0, 0, 0, 0.4), 0 10px 10px -5px rgba(0, 0, 0, 0.2)' : '' }};
            }
        </style>
        @endif
        
        @if($headerSettings->header_smooth_transitions)
        <style>
            /* Modern bubble-like hover animations with triangle connector */
            .header-nav-item {
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
                border: 1px solid transparent;
                overflow: visible;
            }
            .header-nav-item:hover {
                background: linear-gradient(180deg, rgba(59, 130, 246, 0.2), rgba(139, 92, 246, 0.15));
                border: 1px solid rgba(59, 130, 246, 0.4);
                border-bottom: none;
                box-shadow: 0 0 30px rgba(59, 130, 246, 0.5), 
                            0 0 60px rgba(59, 130, 246, 0.2),
                            inset 0 1px 0 rgba(255, 255, 255, 0.1);
                transform: translateY(-3px);
            }
            /* Triangle connector pointing down */
            .header-nav-item:hover::after {
                content: '';
                position: absolute;
                bottom: -10px;
                left: 50%;
                transform: translateX(-50%);
                width: 0;
                height: 0;
                border-left: 12px solid transparent;
                border-right: 12px solid transparent;
                border-top: 10px solid rgba(59, 130, 246, 0.4);
                filter: drop-shadow(0 4px 12px rgba(59, 130, 246, 0.6))
                        drop-shadow(0 8px 24px rgba(59, 130, 246, 0.3));
            }
            /* Glow behind triangle */
            .header-nav-item:hover::before {
                content: '';
                position: absolute;
                bottom: -20px;
                left: 50%;
                transform: translateX(-50%);
                width: 40px;
                height: 15px;
                background: linear-gradient(180deg, rgba(59, 130, 246, 0.4), transparent);
                border-radius: 50%;
                filter: blur(8px);
                opacity: 0.8;
                z-index: -1;
            }
            .header-nav-item:active {
                transform: translateY(-1px) scale(0.98);
            }
            
            .header-icon-btn {
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
                border: 1px solid transparent;
                overflow: visible;
            }
            .header-icon-btn:hover {
                transform: translateY(-3px);
                background: linear-gradient(180deg, rgba(59, 130, 246, 0.2), rgba(139, 92, 246, 0.15)) !important;
                border: 1px solid rgba(59, 130, 246, 0.4);
                border-bottom: none;
                box-shadow: 0 0 30px rgba(59, 130, 246, 0.6), 
                            0 0 60px rgba(59, 130, 246, 0.3),
                            inset 0 1px 0 rgba(255, 255, 255, 0.15);
            }
            /* Triangle connector for icons */
            .header-icon-btn:hover::after {
                content: '';
                position: absolute;
                bottom: -10px;
                left: 50%;
                transform: translateX(-50%);
                width: 0;
                height: 0;
                border-left: 10px solid transparent;
                border-right: 10px solid transparent;
                border-top: 10px solid rgba(59, 130, 246, 0.4);
                filter: drop-shadow(0 4px 12px rgba(59, 130, 246, 0.7))
                        drop-shadow(0 8px 24px rgba(59, 130, 246, 0.4));
            }
            /* Glow behind triangle for icons */
            .header-icon-btn:hover::before {
                content: '';
                position: absolute;
                bottom: -20px;
                left: 50%;
                transform: translateX(-50%);
                width: 35px;
                height: 15px;
                background: linear-gradient(180deg, rgba(59, 130, 246, 0.5), transparent);
                border-radius: 50%;
                filter: blur(8px);
                opacity: 0.9;
                z-index: -1;
            }
            
            .header-search-input {
                transition: all 0.3s ease-in-out;
            }
            .header-search-input:focus {
                transform: scale(1.02);
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2), 0 8px 25px rgba(0, 0, 0, 0.15);
            }
            
            .header-logo {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                object-fit: contain;
            }
            .header-logo:hover {
                transform: scale(1.05) rotate(2deg);
                filter: drop-shadow(0 10px 20px rgba(59, 130, 246, 0.3));
            }
            
            /* Logo responsive styling */
            .logo-container {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }
            
            .logo-container img {
                object-fit: contain;
                width: auto;
                height: auto;
            }
            
            .logo-container svg {
                max-width: 100%;
                max-height: 100%;
                width: auto;
                height: auto;
            }
            
            /* Logo responsive breakpoints for better multi-tenant support */
            @media (max-width: 640px) {
                .logo-container img {
                    max-width: min(150px, 80vw) !important;
                    max-height: 50px !important;
                }
            }
            
            @media (min-width: 641px) and (max-width: 1024px) {
                .logo-container img {
                    max-width: min(200px, 60vw) !important;
                    max-height: 60px !important;
                }
            }
            
            .header-user-menu {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .header-user-menu:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 15px rgba(59, 130, 246, 0.25);
            }
            .header-user-menu:hover .user-avatar {
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.4);
            }
            
            .mobile-menu-btn {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .mobile-menu-btn:hover {
                transform: scale(1.1);
                background: rgba(59, 130, 246, 0.2);
                border-radius: 8px;
            }
            
            @keyframes rotate {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            
            @keyframes pulse-glow {
                0%, 100% { box-shadow: 0 0 5px rgba(59, 130, 246, 0.3); }
                50% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.6); }
            }
        </style>
        @endif
        
        <!-- Header Main Container -->
        <div class="container mx-auto px-4" style="min-height: {{ $headerSettings->header_height }}px;">
            <div class="py-3">
                <!-- Mobile Menu Button -->
                @if($headerSettings->mobile_menu_enabled)
                <div class="lg:hidden flex items-center justify-between mb-3">
                    @php
                        $logoPosition = $headerSettings->logo_position ?? 'right';
                    @endphp
                    
                    @if($logoPosition === 'left')
                        @if($headerSettings->logo_enabled)
                        <div class="flex-1 logo-container">
                            <img src="{{ asset('storage/'.$homePage->store_logo) }}" 
                                 alt="logo" 
                                 class="inline-block {{ $headerSettings->logo_border_radius }}
                                 @if($headerSettings->logo_shadow_enabled)
                                 {{ $headerSettings->logo_shadow_class ?: 'shadow-lg' }} shadow-{{ $headerSettings->logo_shadow_color }}/{{ $headerSettings->logo_shadow_opacity ?? '50' }}
                                 @endif
                                 {{ $headerSettings->header_smooth_transitions ? 'header-logo' : '' }}"
                                 style="max-width: {{ $headerSettings->logo_width }}px; max-height: {{ $headerSettings->logo_height }}px; width: auto; height: auto; object-fit: contain;">
                        </div>
                        @endif
                        
                        <div class="flex items-center space-x-2">
                            <button class="text-white p-2 {{ $headerSettings->header_smooth_transitions ? 'mobile-menu-btn' : '' }}" id="mobile-menu-btn">
                                <i class="ri-menu-line text-xl"></i>
                            </button>
                            
                            @if($headerSettings->mobile_search_enabled)
                            <button class="text-white p-2 {{ $headerSettings->header_smooth_transitions ? 'mobile-menu-btn' : '' }}" id="mobile-search-btn">
                                <i class="ri-search-line text-xl"></i>
                            </button>
                            @endif
                            
                            @if($headerSettings->mobile_cart_enabled && $headerSettings->shopping_cart_enabled)
                            <a href="{{ route('cart.index') }}" class="text-white p-2 relative {{ $headerSettings->header_smooth_transitions ? 'header-icon-btn' : '' }}">
                                <i class="ri-shopping-cart-2-line text-xl"></i>
                                <span class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 rounded-full flex items-center justify-center text-[10px] cart-count">
                                    @php
                                        $cartCount = 0;
                                        
                                        // First, try to get cart count from session (fastest)
                                        $sessionCartCount = session()->get('cart_count');
                                        
                                        if ($sessionCartCount !== null) {
                                            $cartCount = $sessionCartCount;
                                        } else {
                                            // Fallback to database calculation
                                            if (auth()->check()) {
                                                $userCart = \App\Models\Cart::with('items')->where('user_id', auth()->id())->first();
                                                $cartCount = $userCart ? $userCart->getItemsCount() : 0;
                                            } else {
                                                $sessionId = session()->get('cart_session_id');
                                                if ($sessionId) {
                                                    $sessionCart = \App\Models\Cart::with('items')->where('session_id', $sessionId)->first();
                                                    $cartCount = $sessionCart ? $sessionCart->getItemsCount() : 0;
                                                }
                                            }
                                            
                                            // Store in session for next time
                                            session()->put('cart_count', $cartCount);
                                        }
                                    @endphp
                                    {{ $cartCount }}
                                </span>
                            </a>
                            @endif
                        </div>
                        
                    @elseif($logoPosition === 'center')
                        <button class="text-white p-2 {{ $headerSettings->header_smooth_transitions ? 'mobile-menu-btn' : '' }}" id="mobile-menu-btn">
                            <i class="ri-menu-line text-xl"></i>
                        </button>
                        
                        @if($headerSettings->logo_enabled)
                        <div class="flex-1 text-center logo-container justify-center">
                            <img src="{{ asset('storage/'.$homePage->store_logo) }}" 
                                 alt="logo" 
                                 class="inline-block {{ $headerSettings->logo_border_radius }}
                                 @if($headerSettings->logo_shadow_enabled)
                                 {{ $headerSettings->logo_shadow_class ?: 'shadow-lg' }} shadow-{{ $headerSettings->logo_shadow_color }}/{{ $headerSettings->logo_shadow_opacity ?? '50' }}
                                 @endif
                                 {{ $headerSettings->header_smooth_transitions ? 'header-logo' : '' }}"
                                 style="max-width: {{ $headerSettings->logo_width }}px; max-height: {{ $headerSettings->logo_height }}px; width: auto; height: auto; object-fit: contain;">
                        </div>
                        @endif
                        
                        <div class="flex items-center space-x-2">
                            @if($headerSettings->mobile_search_enabled)
                            <button class="text-white p-2 {{ $headerSettings->header_smooth_transitions ? 'mobile-menu-btn' : '' }}" id="mobile-search-btn">
                                <i class="ri-search-line text-xl"></i>
                            </button>
                            @endif
                            
                            @if($headerSettings->mobile_cart_enabled && $headerSettings->shopping_cart_enabled)
                            <a href="{{ route('cart.index') }}" class="text-white p-2 relative {{ $headerSettings->header_smooth_transitions ? 'header-icon-btn' : '' }}">
                                <i class="ri-shopping-cart-2-line text-xl"></i>
                                <span class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 rounded-full flex items-center justify-center text-[10px] cart-count">
                                    @php
                                        $cartCount = 0;
                                        
                                        // First, try to get cart count from session (fastest)
                                        $sessionCartCount = session()->get('cart_count');
                                        
                                        if ($sessionCartCount !== null) {
                                            $cartCount = $sessionCartCount;
                                        } else {
                                            // Fallback to database calculation
                                            if (auth()->check()) {
                                                $userCart = \App\Models\Cart::with('items')->where('user_id', auth()->id())->first();
                                                $cartCount = $userCart ? $userCart->getItemsCount() : 0;
                                            } else {
                                                $sessionId = session()->get('cart_session_id');
                                                if ($sessionId) {
                                                    $sessionCart = \App\Models\Cart::with('items')->where('session_id', $sessionId)->first();
                                                    $cartCount = $sessionCart ? $sessionCart->getItemsCount() : 0;
                                                }
                                            }
                                            
                                            // Store in session for next time
                                            session()->put('cart_count', $cartCount);
                                        }
                                    @endphp
                                    {{ $cartCount }}
                                </span>
                            </a>
                            @endif
                        </div>
                        
                    @else {{-- Default: right position --}}
                        <div class="flex items-center space-x-2">
                            <button class="text-white p-2 {{ $headerSettings->header_smooth_transitions ? 'mobile-menu-btn' : '' }}" id="mobile-menu-btn">
                                <i class="ri-menu-line text-xl"></i>
                            </button>
                            
                            @if($headerSettings->mobile_search_enabled)
                            <button class="text-white p-2 {{ $headerSettings->header_smooth_transitions ? 'mobile-menu-btn' : '' }}" id="mobile-search-btn">
                                <i class="ri-search-line text-xl"></i>
                            </button>
                            @endif
                            
                            @if($headerSettings->mobile_cart_enabled && $headerSettings->shopping_cart_enabled)
                            <a href="{{ route('cart.index') }}" class="text-white p-2 relative {{ $headerSettings->header_smooth_transitions ? 'header-icon-btn' : '' }}">
                                <i class="ri-shopping-cart-2-line text-xl"></i>
                                <span class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 rounded-full flex items-center justify-center text-[10px] cart-count">
                                    @php
                                        $cartCount = 0;
                                        
                                        // First, try to get cart count from session (fastest)
                                        $sessionCartCount = session()->get('cart_count');
                                        
                                        if ($sessionCartCount !== null) {
                                            $cartCount = $sessionCartCount;
                                        } else {
                                            // Fallback to database calculation
                                            if (auth()->check()) {
                                                $userCart = \App\Models\Cart::with('items')->where('user_id', auth()->id())->first();
                                                $cartCount = $userCart ? $userCart->getItemsCount() : 0;
                                            } else {
                                                $sessionId = session()->get('cart_session_id');
                                                if ($sessionId) {
                                                    $sessionCart = \App\Models\Cart::with('items')->where('session_id', $sessionId)->first();
                                                    $cartCount = $sessionCart ? $sessionCart->getItemsCount() : 0;
                                                }
                                            }
                                            
                                            // Store in session for next time
                                            session()->put('cart_count', $cartCount);
                                        }
                                    @endphp
                                    {{ $cartCount }}
                                </span>
                            </a>
                            @endif
                        </div>
                        
                        @if($headerSettings->logo_enabled)
                        <div class="flex-1 text-right logo-container justify-end">
                            <img src="{{ asset('storage/'.$homePage->store_logo) }}" 
                                 alt="logo" 
                                 class="inline-block {{ $headerSettings->logo_border_radius }}
                                 @if($headerSettings->logo_shadow_enabled)
                                 {{ $headerSettings->logo_shadow_class ?: 'shadow-lg' }} shadow-{{ $headerSettings->logo_shadow_color }}/{{ $headerSettings->logo_shadow_opacity ?? '50' }}
                                 @endif
                                 {{ $headerSettings->header_smooth_transitions ? 'header-logo' : '' }}"
                                 style="max-width: {{ $headerSettings->logo_width }}px; max-height: {{ $headerSettings->logo_height }}px; width: auto; height: auto; object-fit: contain;">
                        </div>
                        @endif
                    @endif
                </div>
                @endif
                
                <!-- Desktop Layout -->
                <div class="hidden lg:flex items-center justify-between">
                    @php
                        $logoPosition = $headerSettings->logo_position ?? 'right';
                        $showNavInCenter = !$headerSettings->search_bar_enabled && $headerSettings->navigation_enabled;
                    @endphp
                    
                    @if($logoPosition === 'left')
                        <!-- Left: Logo -->
                        @if($headerSettings->logo_enabled)
                        <div class="flex items-center">
                            <div class="font-['Pacifico'] text-2xl text-white logo-container">
                                @if($headerSettings->logo_image)
                                <img src="{{ asset('storage/'.$headerSettings->logo_image) }}" 
                                     alt="logo" 
                                     class="{{ $headerSettings->logo_border_radius }}
                                     @if($headerSettings->logo_shadow_enabled)
                                     {{ $headerSettings->logo_shadow_class ?: 'shadow-lg' }} shadow-{{ $headerSettings->logo_shadow_color }}/{{ $headerSettings->logo_shadow_opacity ?? '50' }}
                                     @endif
                                     {{ $headerSettings->header_smooth_transitions ? 'header-logo' : '' }}"
                                     style="max-width: {{ $headerSettings->logo_width }}px; max-height: {{ $headerSettings->logo_height }}px; width: auto; height: auto; object-fit: contain;">
                                @elseif($headerSettings->logo_svg)
                                <div class="{{ $headerSettings->header_smooth_transitions ? 'header-logo' : '' }}
                                     @if($headerSettings->logo_shadow_enabled)
                                     {{ $headerSettings->logo_shadow_class ?: 'shadow-lg' }} shadow-{{ $headerSettings->logo_shadow_color }}/{{ $headerSettings->logo_shadow_opacity ?? '50' }}
                                     @endif"
                                     style="max-width: {{ $headerSettings->logo_width }}px; max-height: {{ $headerSettings->logo_height }}px; width: auto; height: auto; display: flex; align-items: center; justify-content: center;">
                                    {!! $headerSettings->logo_svg !!}
                                </div>
                                @elseif($homePage && $homePage->store_logo)
                                <img src="{{ asset('storage/'.$homePage->store_logo) }}" 
                                     alt="logo" 
                                     class="{{ $headerSettings->logo_border_radius }}
                                     @if($headerSettings->logo_shadow_enabled)
                                     {{ $headerSettings->logo_shadow_class ?: 'shadow-lg' }} shadow-{{ $headerSettings->logo_shadow_color }}/{{ $headerSettings->logo_shadow_opacity ?? '50' }}
                                     @endif
                                     {{ $headerSettings->header_smooth_transitions ? 'header-logo' : '' }}"
                                     style="max-width: {{ $headerSettings->logo_width }}px; max-height: {{ $headerSettings->logo_height }}px; width: auto; height: auto; object-fit: contain;">
                                @endif
                            </div>
                        </div>
                        @endif
                        
                        <!-- Center: Navigation Menu or Search -->
                        @if($showNavInCenter)
                        <div class="flex-1 flex justify-center">
                            <nav class="flex items-center space-x-1 bg-gray-800/50 rounded-full px-6 py-2 backdrop-blur-sm border border-gray-700/50">
                                @if($headerSettings->show_home_link)
                                <a href="/" class="{{ request()->is('/') ? 'text-white bg-blue-600 shadow-lg shadow-blue-600/25' : 'text-gray-300 hover:text-white hover:bg-gray-700/50' }} {{ $headerSettings->header_smooth_transitions ? 'header-nav-item' : '' }} flex items-center space-x-2 py-2 px-4 rounded-full font-medium text-sm">
                                    <i class="ri-home-line text-base"></i>
                                    <span>الرئيسية</span>
                                </a>
                                @endif
                                
                                {{-- Use menu_items from header_settings if available, otherwise fallback to $menus --}}
                                @if($headerSettings->main_menus_enabled && $headerSettings->menu_items && is_array(json_decode($headerSettings->menu_items, true)))
                                    @foreach (json_decode($headerSettings->menu_items, true) as $menuItem)
                                    @if(isset($menuItem['is_active']) && $menuItem['is_active'])
                                    <a href="{{ url($menuItem['url'] ?? '#') }}" class="{{ request()->is(ltrim($menuItem['url'] ?? '', '/')) ? 'text-white bg-blue-600 shadow-lg shadow-blue-600/25' : 'text-gray-300 hover:text-white hover:bg-gray-700/50' }} {{ $headerSettings->header_smooth_transitions ? 'header-nav-item' : '' }} flex items-center space-x-2 py-2 px-4 rounded-full font-medium text-sm">
                                        <i class="{{ $menuItem['svg'] ?? 'ri-link' }} text-base"></i>
                                        <span>{{ $menuItem['name'] ?? 'Menu Itm' }}</span>
                                    </a>
                                    @endif
                                    @endforeach
                                @elseif($headerSettings->main_menus_enabled && isset($menus))
                                    @foreach ($menus->take($headerSettings->main_menus_number ?? 5) as $menu)
                                    <a href="{{ url($menu->url) }}" class="{{ request()->is(ltrim($menu->url, '/')) ? 'text-white bg-blue-600 shadow-lg shadow-blue-600/25' : 'text-gray-300 hover:text-white hover:bg-gray-700/50' }} {{ $headerSettings->header_smooth_transitions ? 'header-nav-item' : '' }} flex items-center space-x-2 py-2 px-4 rounded-full font-medium text-sm">
                                        <i class="{{ $menu->svg }} text-base"></i>
                                        <span>{{ $menu->title }}</span>
                                    </a>
                                    @endforeach
                                @endif
                                
                                {{-- Show categories in menu if enabled --}}
                                @if($headerSettings->show_categories_in_menu && isset($categories))
                                    @foreach ($categories->take($headerSettings->categories_count ?? 5) as $category)
                                    <a href="{{ url('categories/'.$category->slug) }}" class="{{ request()->is('categories/'.$category->slug) ? 'text-white bg-blue-600 shadow-lg shadow-blue-600/25' : 'text-gray-300 hover:text-white hover:bg-gray-700/50' }} {{ $headerSettings->header_smooth_transitions ? 'header-nav-item' : '' }} flex items-center space-x-2 py-2 px-4 rounded-full font-medium text-sm">
                                        <i class="{{ $category->icon ?? 'ri-folder-line' }} text-base"></i>
                                        <span>{{ $category->name }}</span>
                                    </a>
                                    @endforeach
                                @endif
                            </nav>
                        </div>
                        @elseif($headerSettings->search_bar_enabled)
                        <div class="flex-1 max-w-xl mx-4">
                            <form action="{{ route('products.search') }}" method="GET" class="relative">
                                <input type="text" name="q" value="{{ request('q') }}" placeholder="ابحث عن الألعاب، الحسابات، العناصر..."
                                    class="w-full bg-gray-800 border-none rounded-full py-2 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary {{ $headerSettings->header_smooth_transitions ? 'header-search-input' : '' }}">
                                <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 w-6 h-6 flex items-center justify-center {{ $headerSettings->header_smooth_transitions ? 'transition-all duration-200 hover:scale-110' : '' }}">
                                    <i class="ri-search-line text-gray-400 hover:text-primary {{ $headerSettings->header_smooth_transitions ? 'transition-colors duration-200' : '' }}"></i>
                                </button>
                            </form>
                        </div>
                        @endif
                        
                        <!-- Right: User info and cart -->
                        <div class="flex items-center space-x-4 flex-row-reverse">
                            @if($headerSettings->user_menu_enabled)
                            <div class="flex mr-4 items-center cursor-pointer {{ $headerSettings->header_smooth_transitions ? 'header-user-menu' : '' }}">
                                <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center user-avatar">
                                    <i class="ri-user-3-line text-white"></i>
                                </div>
                            </div>
                            @endif
                            
                            @if($headerSettings->shopping_cart_enabled)
                            <a href="{{ route('cart.index') }}" class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center relative cursor-pointer {{ $headerSettings->header_smooth_transitions ? 'header-icon-btn' : 'transition-all duration-200 hover:bg-gray-700' }}">
                                <i class="ri-shopping-cart-2-line text-white"></i>
                                <span class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 rounded-full flex items-center justify-center text-[10px] cart-count">
                                    @php
                                        $cartCount = 0;
                                        
                                        // First, try to get cart count from session (fastest)
                                        $sessionCartCount = session()->get('cart_count');
                                        
                                        if ($sessionCartCount !== null) {
                                            $cartCount = $sessionCartCount;
                                        } else {
                                            // Fallback to database calculation
                                            if (auth()->check()) {
                                                $userCart = \App\Models\Cart::with('items')->where('user_id', auth()->id())->first();
                                                $cartCount = $userCart ? $userCart->getItemsCount() : 0;
                                            } else {
                                                $sessionId = session()->get('cart_session_id');
                                                if ($sessionId) {
                                                    $sessionCart = \App\Models\Cart::with('items')->where('session_id', $sessionId)->first();
                                                    $cartCount = $sessionCart ? $sessionCart->getItemsCount() : 0;
                                                }
                                            }
                                            
                                            // Store in session for next time
                                            session()->put('cart_count', $cartCount);
                                        }
                                    @endphp
                                    {{ $cartCount }}
                                </span>
                            </a>
                            @endif
                            
                            {{-- @if($headerSettings->wishlist_enabled)
                            <div class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center relative cursor-pointer {{ $headerSettings->header_smooth_transitions ? 'header-icon-btn' : 'transition-all duration-200 hover:bg-gray-700' }}">
                                <i class="ri-heart-line text-white"></i>
                                <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full flex items-center justify-center text-[10px]">3</span>
                            </div>
                            @endif --}}
                        </div>
                        
                    @elseif($logoPosition === 'center')
                        <!-- Left: User info and cart -->
                        <div class="flex items-center space-x-4 flex-row-reverse">
                            @if($headerSettings->user_menu_enabled)
                            <div class="flex mr-4 items-center cursor-pointer {{ $headerSettings->header_smooth_transitions ? 'header-user-menu' : '' }}">
                                <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center user-avatar">
                                    <i class="ri-user-3-line text-white"></i>
                                </div>
                            </div>
                            @endif
                            
                            @if($headerSettings->shopping_cart_enabled)
                            <a href="{{ route('cart.index') }}" class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center relative cursor-pointer {{ $headerSettings->header_smooth_transitions ? 'header-icon-btn' : 'transition-all duration-200 hover:bg-gray-700' }}">
                                <i class="ri-shopping-cart-2-line text-white"></i>
                                <span class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 rounded-full flex items-center justify-center text-[10px] cart-count">
                                    @php
                                        $cartCount = 0;
                                        
                                        // First, try to get cart count from session (fastest)
                                        $sessionCartCount = session()->get('cart_count');
                                        
                                        if ($sessionCartCount !== null) {
                                            $cartCount = $sessionCartCount;
                                        } else {
                                            // Fallback to database calculation
                                            if (auth()->check()) {
                                                $userCart = \App\Models\Cart::with('items')->where('user_id', auth()->id())->first();
                                                $cartCount = $userCart ? $userCart->getItemsCount() : 0;
                                            } else {
                                                $sessionId = session()->get('cart_session_id');
                                                if ($sessionId) {
                                                    $sessionCart = \App\Models\Cart::with('items')->where('session_id', $sessionId)->first();
                                                    $cartCount = $sessionCart ? $sessionCart->getItemsCount() : 0;
                                                }
                                            }
                                            
                                            // Store in session for next time
                                            session()->put('cart_count', $cartCount);
                                        }
                                    @endphp
                                    {{ $cartCount }}
                                </span>
                            </a>
                            @endif
                            
                            {{-- @if($headerSettings->wishlist_enabled)
                            <div class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center relative cursor-pointer {{ $headerSettings->header_smooth_transitions ? 'header-icon-btn' : 'transition-all duration-200 hover:bg-gray-700' }}">
                                <i class="ri-heart-line text-white"></i>
                                <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full flex items-center justify-center text-[10px]">3</span>
                            </div>
                            @endif --}}
                        </div>
                        
                        <!-- Center: Logo or Navigation Menu -->
                        @if($showNavInCenter)
                        <div class="flex-1 flex justify-center">
                            <nav class="flex items-center space-x-1 bg-gray-800/50 rounded-full px-6 py-2 backdrop-blur-sm border border-gray-700/50">
                                @if($headerSettings->show_home_link)
                                <a href="/" class="{{ request()->is('/') ? 'text-white bg-blue-600 shadow-lg shadow-blue-600/25' : 'text-gray-300 hover:text-white hover:bg-gray-700/50' }} {{ $headerSettings->header_smooth_transitions ? 'header-nav-item' : '' }} flex items-center space-x-2 py-2 px-4 rounded-full font-medium text-sm">
                                    <i class="ri-home-line text-base"></i>
                                    <span>الرئيسية</span>
                                </a>
                                @endif
                                
                                {{-- Use menu_items from header_settings if available, otherwise fallback to $menus --}}
                                @if($headerSettings->main_menus_enabled && $headerSettings->menu_items && is_array(json_decode($headerSettings->menu_items, true)))
                                    @foreach (json_decode($headerSettings->menu_items, true) as $menuItem)
                                    @if(isset($menuItem['is_active']) && $menuItem['is_active'])
                                    <a href="{{ url($menuItem['url'] ?? '#') }}" class="{{ request()->is(ltrim($menuItem['url'] ?? '', '/')) ? 'text-white bg-blue-600 shadow-lg shadow-blue-600/25' : 'text-gray-300 hover:text-white hover:bg-gray-700/50' }} {{ $headerSettings->header_smooth_transitions ? 'header-nav-item' : '' }} flex items-center space-x-2 py-2 px-4 rounded-full font-medium text-sm">
                                        <i class="{{ $menuItem['svg'] ?? 'ri-link' }} text-base"></i>
                                        <span>{{ $menuItem['name'] ?? 'Menu Itm' }}</span>
                                    </a>
                                    @endif
                                    @endforeach
                                @elseif($headerSettings->main_menus_enabled && isset($menus))
                                    @foreach ($menus->take($headerSettings->main_menus_number ?? 5) as $menu)
                                    <a href="{{ url($menu->url) }}" class="{{ request()->is(ltrim($menu->url, '/')) ? 'text-white bg-blue-600 shadow-lg shadow-blue-600/25' : 'text-gray-300 hover:text-white hover:bg-gray-700/50' }} {{ $headerSettings->header_smooth_transitions ? 'header-nav-item' : '' }} flex items-center space-x-2 py-2 px-4 rounded-full font-medium text-sm">
                                        <i class="{{ $menu->svg }} text-base"></i>
                                        <span>{{ $menu->title }}</span>
                                    </a>
                                    @endforeach
                                @endif
                                
                                {{-- Show categories in menu if enabled --}}
                                @if($headerSettings->show_categories_in_menu && isset($categories))
                                    @foreach ($categories->take($headerSettings->categories_count ?? 5) as $category)
                                    <a href="{{ url('categories/'.$category->slug) }}" class="{{ request()->is('categories/'.$category->slug) ? 'text-white bg-blue-600 shadow-lg shadow-blue-600/25' : 'text-gray-300 hover:text-white hover:bg-gray-700/50' }} {{ $headerSettings->header_smooth_transitions ? 'header-nav-item' : '' }} flex items-center space-x-2 py-2 px-4 rounded-full font-medium text-sm">
                                        <i class="{{ $category->icon ?? 'ri-folder-line' }} text-base"></i>
                                        <span>{{ $category->name }}</span>
                                    </a>
                                    @endforeach
                                @endif
                            </nav>
                        </div>
                        @elseif($headerSettings->logo_enabled)
                        <div class="flex items-center justify-center">
                            <div class="font-['Pacifico'] text-2xl text-white logo-container">
                                @if($headerSettings->logo_image)
                                <img src="{{ asset('storage/'.$headerSettings->logo_image) }}" 
                                     alt="logo" 
                                     class="{{ $headerSettings->logo_border_radius }}
                                     @if($headerSettings->logo_shadow_enabled)
                                     {{ $headerSettings->logo_shadow_class ?: 'shadow-lg' }} shadow-{{ $headerSettings->logo_shadow_color }}/{{ $headerSettings->logo_shadow_opacity ?? '50' }}
                                     @endif
                                     {{ $headerSettings->header_smooth_transitions ? 'header-logo' : '' }}"
                                     style="max-width: {{ $headerSettings->logo_width }}px; max-height: {{ $headerSettings->logo_height }}px; width: auto; height: auto; object-fit: contain;">
                                @elseif($headerSettings->logo_svg)
                                <div class="{{ $headerSettings->header_smooth_transitions ? 'header-logo' : '' }}
                                     @if($headerSettings->logo_shadow_enabled)
                                     {{ $headerSettings->logo_shadow_class ?: 'shadow-lg' }} shadow-{{ $headerSettings->logo_shadow_color }}/{{ $headerSettings->logo_shadow_opacity ?? '50' }}
                                     @endif"
                                     style="max-width: {{ $headerSettings->logo_width }}px; max-height: {{ $headerSettings->logo_height }}px; width: auto; height: auto; display: flex; align-items: center; justify-content: center;">
                                    {!! $headerSettings->logo_svg !!}
                                </div>
                                @elseif($homePage && $homePage->store_logo)
                                <img src="{{ asset('storage/'.$homePage->store_logo) }}" 
                                     alt="logo" 
                                     class="{{ $headerSettings->logo_border_radius }}
                                     @if($headerSettings->logo_shadow_enabled)
                                     {{ $headerSettings->logo_shadow_class ?: 'shadow-lg' }} shadow-{{ $headerSettings->logo_shadow_color }}/{{ $headerSettings->logo_shadow_opacity ?? '50' }}
                                     @endif
                                     {{ $headerSettings->header_smooth_transitions ? 'header-logo' : '' }}"
                                     style="max-width: {{ $headerSettings->logo_width }}px; max-height: {{ $headerSettings->logo_height }}px; width: auto; height: auto; object-fit: contain;">
                                @endif
                            </div>
                        </div>
                        @endif
                        
                        <!-- Right: Search -->
                        @if($headerSettings->search_bar_enabled)
                        <div class="flex-1 max-w-xl mx-4">
                            <form action="{{ route('products.search') }}" method="GET" class="relative">
                                <input type="text" name="q" value="{{ request('q') }}" placeholder="ابحث عن الألعاب، الحسابات، العناصر..."
                                    class="w-full bg-gray-800 border-none rounded-full py-2 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary {{ $headerSettings->header_smooth_transitions ? 'header-search-input' : '' }}">
                                <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 w-6 h-6 flex items-center justify-center {{ $headerSettings->header_smooth_transitions ? 'transition-all duration-200 hover:scale-110' : '' }}">
                                    <i class="ri-search-line text-gray-400 hover:text-primary {{ $headerSettings->header_smooth_transitions ? 'transition-colors duration-200' : '' }}"></i>
                                </button>
                            </form>
                        </div>
                        @endif
                        
                    @else {{-- Default: right position --}}
                        <!-- Left: User info and cart -->
                        <div class="flex items-center space-x-4 flex-row-reverse">
                            @if($headerSettings->user_menu_enabled)
                            <div class="flex mr-4 items-center cursor-pointer {{ $headerSettings->header_smooth_transitions ? 'header-user-menu' : '' }}">
                                <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center user-avatar">
                                    <i class="ri-user-3-line text-white"></i>
                                </div>
                            </div>
                            @endif
                            
                            @if($headerSettings->shopping_cart_enabled)
                            <a href="{{ route('cart.index') }}" class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center relative cursor-pointer {{ $headerSettings->header_smooth_transitions ? 'header-icon-btn' : 'transition-all duration-200 hover:bg-gray-700' }}">
                                <i class="ri-shopping-cart-2-line text-white"></i>
                                <span class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 rounded-full flex items-center justify-center text-[10px] cart-count">
                                    @php
                                        $cartCount = 0;
                                        
                                        // First, try to get cart count from session (fastest)
                                        $sessionCartCount = session()->get('cart_count');
                                        
                                        if ($sessionCartCount !== null) {
                                            $cartCount = $sessionCartCount;
                                        } else {
                                            // Fallback to database calculation
                                            if (auth()->check()) {
                                                $userCart = \App\Models\Cart::with('items')->where('user_id', auth()->id())->first();
                                                $cartCount = $userCart ? $userCart->getItemsCount() : 0;
                                            } else {
                                                $sessionId = session()->get('cart_session_id');
                                                if ($sessionId) {
                                                    $sessionCart = \App\Models\Cart::with('items')->where('session_id', $sessionId)->first();
                                                    $cartCount = $sessionCart ? $sessionCart->getItemsCount() : 0;
                                                }
                                            }
                                            
                                            // Store in session for next time
                                            session()->put('cart_count', $cartCount);
                                        }
                                    @endphp
                                    {{ $cartCount }}
                                </span>
                            </a>
                            @endif
                            
                            {{-- @if($headerSettings->wishlist_enabled)
                            <div class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center relative cursor-pointer {{ $headerSettings->header_smooth_transitions ? 'header-icon-btn' : 'transition-all duration-200 hover:bg-gray-700' }}">
                                <i class="ri-heart-line text-white"></i>
                                <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full flex items-center justify-center text-[10px]">3</span>
                            </div>
                            @endif --}}
                        </div>
                        
                        <!-- Center: Navigation Menu or Search -->
                        @if($showNavInCenter)
                        <div class="flex-1 flex justify-center">
                            <nav class="flex items-center space-x-1 bg-gray-800/50 rounded-full px-6 py-2 backdrop-blur-sm border border-gray-700/50">
                                @if($headerSettings->show_home_link)
                                <a href="/" class="{{ request()->is('/') ? 'text-white bg-blue-600 shadow-lg shadow-blue-600/25' : 'text-gray-300 hover:text-white hover:bg-gray-700/50' }} {{ $headerSettings->header_smooth_transitions ? 'header-nav-item' : '' }} flex items-center space-x-2 py-2 px-4 rounded-full font-medium text-sm">
                                    <i class="ri-home-line text-base"></i>
                                    <span class="font-medium">الرئيسية</span>
                                </a>
                                @endif
                                
                                {{-- Use menu_items from header_settings if available, otherwise fallback to $menus --}}
                                @if($headerSettings->main_menus_enabled && $headerSettings->menu_items && is_array(json_decode($headerSettings->menu_items, true)))
                                    @foreach (json_decode($headerSettings->menu_items, true) as $menuItem)
                                    @if(isset($menuItem['is_active']) && $menuItem['is_active'])
                                    <a href="{{ url($menuItem['url'] ?? '#') }}" class="{{ request()->is(ltrim($menuItem['url'] ?? '', '/')) ? 'text-white bg-blue-600 shadow-lg shadow-blue-600/25' : 'text-gray-300 hover:text-white hover:bg-gray-700/50' }} {{ $headerSettings->header_smooth_transitions ? 'header-nav-item' : '' }} flex items-center space-x-2 py-2 px-4 rounded-full font-medium text-sm">
                                        <i class="{{ $menuItem['svg'] ?? 'ri-link' }} text-base"></i>
                                        <span class="font-medium">{{ $menuItem['name'] ?? 'Menu Itm' }}</span>
                                    </a>
                                    @endif
                                    @endforeach
                                @elseif($headerSettings->main_menus_enabled && isset($menus))
                                    @foreach ($menus->take($headerSettings->main_menus_number ?? 5) as $menu)
                                    <a href="{{ url($menu->url) }}" class="{{ request()->is(ltrim($menu->url, '/')) ? 'text-white bg-blue-600 shadow-lg shadow-blue-600/25' : 'text-gray-300 hover:text-white hover:bg-gray-700/50' }} {{ $headerSettings->header_smooth_transitions ? 'header-nav-item' : '' }} flex items-center space-x-2 py-2 px-4 rounded-full font-medium text-sm">
                                        <i class="{{ $menu->svg }} text-base"></i>
                                        <span class="font-medium">{{ $menu->title }}</span>
                                    </a>
                                    @endforeach
                                @endif
                                
                                {{-- Show categories in menu if enabled --}}
                                @if($headerSettings->show_categories_in_menu && isset($categories))
                                    @foreach ($categories->take($headerSettings->categories_count ?? 5) as $category)
                                    <a href="{{ url('categories/'.$category->slug) }}" class="{{ request()->is('categories/'.$category->slug) ? 'text-white bg-blue-600 shadow-lg shadow-blue-600/25' : 'text-gray-300 hover:text-white hover:bg-gray-700/50' }} {{ $headerSettings->header_smooth_transitions ? 'header-nav-item' : '' }} flex items-center space-x-2 py-2 px-4 rounded-full font-medium text-sm">
                                        <i class="{{ $category->icon ?? 'ri-folder-line' }} text-base"></i>
                                        <span class="font-medium">{{ $category->name }}</span>
                                    </a>
                                    @endforeach
                                @endif
                            </nav>
                        </div>
                        @elseif($headerSettings->search_bar_enabled)
                        <div class="flex-1 max-w-xl mx-4">
                            <form action="{{ route('products.search') }}" method="GET" class="relative">
                                <input type="text" name="q" value="{{ request('q') }}" placeholder="ابحث عن الألعاب، الحسابات، العناصر..."
                                    class="w-full bg-gray-800 border-none rounded-full py-2 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary {{ $headerSettings->header_smooth_transitions ? 'header-search-input' : '' }}">
                                <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 w-6 h-6 flex items-center justify-center {{ $headerSettings->header_smooth_transitions ? 'transition-all duration-200 hover:scale-110' : '' }}">
                                    <i class="ri-search-line text-gray-400 hover:text-primary {{ $headerSettings->header_smooth_transitions ? 'transition-colors duration-200' : '' }}"></i>
                                </button>
                            </form>
                        </div>
                        @endif
                        
                        <!-- Right: Logo -->
                        @if($headerSettings->logo_enabled)
                        <div class="flex items-center">
                            <div class="font-['Pacifico'] text-2xl text-white logo-container">
                                @if($headerSettings->logo_image)
                                <img src="{{ asset('storage/'.$headerSettings->logo_image) }}" 
                                     alt="logo" 
                                     class="{{ $headerSettings->logo_border_radius }}
                                     @if($headerSettings->logo_shadow_enabled)
                                     {{ $headerSettings->logo_shadow_class ?: 'shadow-lg' }} shadow-{{ $headerSettings->logo_shadow_color }}/{{ $headerSettings->logo_shadow_opacity ?? '50' }}
                                     @endif
                                     {{ $headerSettings->header_smooth_transitions ? 'header-logo' : '' }}"
                                     style="max-width: {{ $headerSettings->logo_width }}px; max-height: {{ $headerSettings->logo_height }}px; width: auto; height: auto; object-fit: contain;">
                                @elseif($headerSettings->logo_svg)
                                <div class="{{ $headerSettings->header_smooth_transitions ? 'header-logo' : '' }}
                                     @if($headerSettings->logo_shadow_enabled)
                                     {{ $headerSettings->logo_shadow_class ?: 'shadow-lg' }} shadow-{{ $headerSettings->logo_shadow_color }}/{{ $headerSettings->logo_shadow_opacity ?? '50' }}
                                     @endif"
                                     style="max-width: {{ $headerSettings->logo_width }}px; max-height: {{ $headerSettings->logo_height }}px; width: auto; height: auto; display: flex; align-items: center; justify-content: center;">
                                    {!! $headerSettings->logo_svg !!}
                                </div>
                                @elseif($homePage && $homePage->store_logo)
                                <img src="{{ asset('storage/'.$homePage->store_logo) }}" 
                                     alt="logo" 
                                     class="{{ $headerSettings->logo_border_radius }}
                                     @if($headerSettings->logo_shadow_enabled)
                                     {{ $headerSettings->logo_shadow_class ?: 'shadow-lg' }} shadow-{{ $headerSettings->logo_shadow_color }}/{{ $headerSettings->logo_shadow_opacity ?? '50' }}
                                     @endif
                                     {{ $headerSettings->header_smooth_transitions ? 'header-logo' : '' }}"
                                     style="max-width: {{ $headerSettings->logo_width }}px; max-height: {{ $headerSettings->logo_height }}px; width: auto; height: auto; object-fit: contain;">
                                @endif
                            </div>
                        </div>
                        @endif
                    @endif
                </div>
                
                <!-- Navigation Menu (Only show if not shown in center) -->
                @if($headerSettings->navigation_enabled && !$showNavInCenter)
                <nav class="mt-3 flex justify-between items-center">
                    <div class="flex space-x-8">
                        @if($headerSettings->show_home_link)
                        <a href="/" class="{{ request()->is('/') ? 'text-blue-400 border-b-2 border-blue-400 bg-blue-900/20' : 'text-gray-400 hover:text-blue-400' }} {{ $headerSettings->header_smooth_transitions ? 'header-nav-item' : '' }} flex items-center space-x-2 py-2 px-3 rounded-t-lg">
                            <i class="ri-home-line text-xl"></i>
                            <span class="font-medium">الرئيسية</span>
                        </a>
                        @endif
                        
                        {{-- Use menu_items from header_settings if available, otherwise fallback to $menus --}}
                        @if($headerSettings->main_menus_enabled && $headerSettings->menu_items && is_array(json_decode($headerSettings->menu_items, true)))
                            @foreach (json_decode($headerSettings->menu_items, true) as $menuItem)
                            @if(isset($menuItem['is_active']) && $menuItem['is_active'])
                            <a href="{{ url($menuItem['url'] ?? '#') }}" class="{{ request()->is(ltrim($menuItem['url'] ?? '', '/')) ? 'text-blue-400 border-b-2 border-blue-400 bg-blue-900/20' : 'text-gray-400 hover:text-blue-400' }} {{ $headerSettings->header_smooth_transitions ? 'header-nav-item' : '' }} flex items-center space-x-2 py-2 px-3 rounded-t-lg">
                                <i class="{{ $menuItem['svg'] ?? 'ri-link' }} text-xl"></i>
                                <span class="font-medium">{{ $menuItem['name'] ?? 'Menu Item' }}</span>
                            </a>
                            @endif
                            @endforeach
                        @elseif($headerSettings->main_menus_enabled && isset($menus))
                            @foreach ($menus->take($headerSettings->main_menus_number ?? 5) as $menu)
                            <a href="{{ url($menu->url) }}" class="{{ request()->is(ltrim($menu->url, '/')) ? 'text-blue-400 border-b-2 border-blue-400 bg-blue-900/20' : 'text-gray-400 hover:text-blue-400' }} {{ $headerSettings->header_smooth_transitions ? 'header-nav-item' : '' }} flex items-center space-x-2 py-2 px-3 rounded-t-lg">
                                <i class="{{ $menu->svg }} text-xl"></i>
                                <span class="font-medium">{{ $menu->title }}</span>
                            </a>
                            @endforeach
                        @endif
                        
                        {{-- Show categories in menu if enabled --}}
                        @if($headerSettings->show_categories_in_menu && isset($categories))
                            @foreach ($categories->take($headerSettings->categories_count ?? 5) as $category)
                            <a href="{{ url('categories/'.$category->slug) }}" class="{{ request()->is('categories/'.$category->slug) ? 'text-blue-400 border-b-2 border-blue-400 bg-blue-900/20' : 'text-gray-400 hover:text-blue-400' }} {{ $headerSettings->header_smooth_transitions ? 'header-nav-item' : '' }} flex items-center space-x-2 py-2 px-3 rounded-t-lg">
                                <i class="{{ $category->icon ?? 'ri-folder-line' }} text-xl"></i>
                                <span class="font-medium">{{ $category->name }}</span>
                            </a>
                            @endforeach
                        @endif
                    </div>
                    
                    <div class="flex space-x-6">
                        @if($headerSettings->currency_switcher_enabled)
                        <a href="#" class="text-gray-400 hover:text-primary flex items-center space-x-2 py-2 {{ $headerSettings->header_smooth_transitions ? 'header-nav-item' : '' }}">
                            <i class="ri-wallet-3-line"></i>
                            <span>المحفظة</span>
                        </a>
                        @endif
                        
                        @if($headerSettings->language_switcher_enabled)
                        <a href="#" class="text-gray-400 hover:text-primary flex items-center space-x-2 py-2 {{ $headerSettings->header_smooth_transitions ? 'header-nav-item' : '' }}">
                            <i class="ri-global-line"></i>
                            <span>اللغة</span>
                        </a>
                        @endif
                        
                       @if($headerSettings->settings_enabled)
                        <a href="#" class="text-gray-400 hover:text-primary flex items-center space-x-2 py-2 {{ $headerSettings->header_smooth_transitions ? 'header-nav-item' : '' }}">
                            <i class="ri-settings-4-line"></i>
                            <span>الإعدادات</span>
                        </a>
                        @endif
                      
                    </div>
                </nav>
                @endif
                
                <!-- Contact Information -->
                @if($headerSettings->header_contact_enabled && ($headerSettings->header_phone || $headerSettings->header_email))
                <div class="mt-2 flex items-center justify-{{ $headerSettings->contact_position === 'center' ? 'center' : ($headerSettings->contact_position === 'right' ? 'end' : 'start') }} space-x-4">
                    @if($headerSettings->header_phone)
                    <a href="tel:{{ $headerSettings->header_phone }}" class="text-gray-400 hover:text-primary flex items-center space-x-2 {{ $headerSettings->header_smooth_transitions ? 'header-nav-item' : '' }}">
                        <i class="ri-phone-line"></i>
                        <span>{{ $headerSettings->header_phone }}</span>
                    </a>
                    @endif
                    
                    @if($headerSettings->header_email)
                    <a href="mailto:{{ $headerSettings->header_email }}" class="text-gray-400 hover:text-primary flex items-center space-x-2 {{ $headerSettings->header_smooth_transitions ? 'header-nav-item' : '' }}">
                        <i class="ri-mail-line"></i>
                        <span>{{ $headerSettings->header_email }}</span>
                    </a>
                    @endif
                </div>
                @endif
            </div>
        </div>
        
        <!-- Mobile Search (Fixed positioning to not overlap content) -->
        @if($headerSettings->mobile_search_enabled)
        <div class="lg:hidden bg-gray-800 border-t border-gray-700 hidden transition-all duration-300 ease-in-out" id="mobile-search">
            <div class="container mx-auto px-4 py-3">
                <form action="{{ route('products.search') }}" method="GET" class="relative">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="ابحث عن الألعاب، الحسابات، العناصر..."
                        class="w-full bg-gray-900 border border-gray-600 rounded-full py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent {{ $headerSettings->header_smooth_transitions ? 'header-search-input' : '' }}">
                    <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 w-8 h-8 flex items-center justify-center {{ $headerSettings->header_smooth_transitions ? 'transition-all duration-200 hover:scale-110' : '' }}">
                        <i class="ri-search-line text-gray-400 hover:text-primary {{ $headerSettings->header_smooth_transitions ? 'transition-colors duration-200' : 'transition-colors' }}"></i>
                    </button>
                </form>
            </div>
        </div>
        @endif
        
        <!-- Mobile Navigation Menu (Fixed positioning to not overlap content) -->
        @if($headerSettings->mobile_menu_enabled)
        <div class="lg:hidden bg-gray-900 border-t border-gray-800 hidden transition-all duration-300 ease-in-out" id="mobile-menu">
            <div class="container mx-auto px-4 py-4">
                @if($headerSettings->show_home_link)
                <a href="/" class="{{ request()->is('/') ? 'text-blue-400 bg-blue-900/20' : 'text-gray-400' }} {{ $headerSettings->header_smooth_transitions ? 'header-nav-item' : '' }} flex items-center space-x-3 py-3 px-4 rounded-lg mb-2 hover:bg-gray-800 transition-colors duration-200">
                    <i class="ri-home-line text-xl"></i>
                    <span class="font-medium">الرئيسية</span>
                </a>
                @endif
                
                {{-- Mobile menu items --}}
                @if($headerSettings->main_menus_enabled && $headerSettings->menu_items && is_array(json_decode($headerSettings->menu_items, true)))
                    @foreach (json_decode($headerSettings->menu_items, true) as $menuItem)
                    @if(isset($menuItem['is_active']) && $menuItem['is_active'])
                    <a href="{{ url($menuItem['url'] ?? '#') }}" class="{{ request()->is(ltrim($menuItem['url'] ?? '', '/')) ? 'text-blue-400 bg-blue-900/20' : 'text-gray-400' }} {{ $headerSettings->header_smooth_transitions ? 'header-nav-item' : '' }} flex items-center space-x-3 py-3 px-4 rounded-lg mb-2 hover:bg-gray-800 transition-colors duration-200">
                        <i class="{{ $menuItem['svg'] ?? 'ri-link' }} text-xl"></i>
                        <span class="font-medium">{{ $menuItem['name'] ?? 'Menu Itm' }}</span>
                    </a>
                    @endif
                    @endforeach
                @elseif($headerSettings->main_menus_enabled && isset($menus))
                    @foreach ($menus->take($headerSettings->main_menus_number ?? 5) as $menu)
                    <a href="{{ url($menu->url) }}" class="{{ request()->is(ltrim($menu->url, '/')) ? 'text-blue-400 bg-blue-900/20' : 'text-gray-400' }} {{ $headerSettings->header_smooth_transitions ? 'header-nav-item' : '' }} flex items-center space-x-3 py-3 px-4 rounded-lg mb-2 hover:bg-gray-800 transition-colors duration-200">
                        <i class="{{ $menu->svg }} text-xl"></i>
                        <span class="font-medium">{{ $menu->title }}</span>
                    </a>
                    @endforeach
                @endif
            </div>
        </div>
        @endif
        
        @if($headerSettings->header_scroll_effects || $headerSettings->mobile_menu_enabled)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if($headerSettings->header_scroll_effects)
                // Scroll effects
                const header = document.querySelector('[data-scroll-header="true"]');
                if (header) {
                    let lastScrollTop = 0;
                    window.addEventListener('scroll', function() {
                        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                        
                        if (scrollTop > 100) {
                            header.classList.add('scrolled');
                        } else {
                            header.classList.remove('scrolled');
                        }
                        
                        lastScrollTop = scrollTop;
                    });
                }
                @endif
                
                @if($headerSettings->mobile_menu_enabled)
                // Mobile menu toggle
                const mobileMenuBtn = document.getElementById('mobile-menu-btn');
                const mobileMenu = document.getElementById('mobile-menu');
                
                if (mobileMenuBtn && mobileMenu) {
                    mobileMenuBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        mobileMenu.classList.toggle('hidden');
                        
                        // Toggle menu icon
                        const icon = mobileMenuBtn.querySelector('i');
                        if (mobileMenu.classList.contains('hidden')) {
                            icon.className = 'ri-menu-line text-xl';
                        } else {
                            icon.className = 'ri-close-line text-xl';
                        }
                    });
                    
                    // Close menu when clicking outside
                    document.addEventListener('click', function(e) {
                        if (!mobileMenuBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
                            mobileMenu.classList.add('hidden');
                            const icon = mobileMenuBtn.querySelector('i');
                            icon.className = 'ri-menu-line text-xl';
                        }
                    });
                }
                @endif
                
                @if($headerSettings->mobile_search_enabled)
                // Mobile search toggle
                const mobileSearchBtn = document.getElementById('mobile-search-btn');
                const mobileSearch = document.getElementById('mobile-search');
                
                if (mobileSearchBtn && mobileSearch) {
                    mobileSearchBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        mobileSearch.classList.toggle('hidden');
                        
                        // Toggle search icon
                        const icon = mobileSearchBtn.querySelector('i');
                        if (mobileSearch.classList.contains('hidden')) {
                            icon.className = 'ri-search-line text-xl';
                        } else {
                            icon.className = 'ri-close-line text-xl';
                            // Focus on search input when opened
                            setTimeout(() => {
                                const searchInput = mobileSearch.querySelector('input');
                                if (searchInput) searchInput.focus();
                            }, 100);
                        }
                    });
                    
                    // Close search when clicking outside
                    document.addEventListener('click', function(e) {
                        if (!mobileSearchBtn.contains(e.target) && !mobileSearch.contains(e.target)) {
                            mobileSearch.classList.add('hidden');
                            const icon = mobileSearchBtn.querySelector('i');
                            icon.className = 'ri-search-line text-xl';
                        }
                    });
                }
                @endif
            });
        </script>
        @endif
        
        <!-- Cart Synchronization Script -->
        <script>
            // Global cart management functions
            window.CartManager = {
                // Update cart count in header
                updateCartCount: function(newCount) {
                    const cartCountElements = document.querySelectorAll('.cart-count');
                    cartCountElements.forEach(element => {
                        element.textContent = newCount;
                        
                        // Add visual feedback
                        element.classList.add('animate-pulse', 'scale-110');
                        setTimeout(() => {
                            element.classList.remove('animate-pulse', 'scale-110');
                        }, 1000);
                    });
                },

                // Sync cart count from server
                syncCartCount: function() {
                    return fetch('/cart/count', {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.cart_count !== undefined) {
                            this.updateCartCount(data.cart_count);
                        }
                        return data;
                    })
                    .catch(error => {
                        console.error('Error syncing cart count:', error);
                        throw error;
                    });
                },

                // Initialize cart session
                initializeCart: function() {
                    return fetch('/cart/init', {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.cart_count !== undefined) {
                            this.updateCartCount(data.cart_count);
                        }
                        return data;
                    })
                    .catch(error => {
                        console.error('Error initializing cart:', error);
                        // Fallback to sync
                        return this.syncCartCount();
                    });
                },

                // Show notification
                showNotification: function(message, type = 'info') {
                    const notification = document.createElement('div');
                    notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg text-white font-medium transform translate-x-full transition-transform duration-300 ${
                        type === 'success' ? 'bg-green-500' : 
                        type === 'error' ? 'bg-red-500' : 
                        'bg-blue-500'
                    }`;
                    notification.textContent = message;
                    
                    document.body.appendChild(notification);
                    
                    // Show notification
                    setTimeout(() => {
                        notification.classList.remove('translate-x-full');
                    }, 100);
                    
                    // Hide notification after 3 seconds
                    setTimeout(() => {
                        notification.classList.add('translate-x-full');
                        setTimeout(() => {
                            if (notification.parentElement) {
                                notification.parentElement.removeChild(notification);
                            }
                        }, 300);
                    }, 3000);
                }
            };

            // Initialize cart on page load
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(() => {
                    window.CartManager.initializeCart();
                }, 500);
            });

            // Legacy support for existing addToCart functions
            window.updateCartCount = window.CartManager.updateCartCount.bind(window.CartManager);
            window.syncCartCount = window.CartManager.syncCartCount.bind(window.CartManager);
        </script>
    </header>
@endif