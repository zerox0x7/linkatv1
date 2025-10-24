{{-- Dynamic Header with Torganic Design --}}
@if($headerSettings && $headerSettings->header_enabled)
<header class="header header--style-2 {{ $headerSettings->header_sticky ? 'header--sticky' : '' }}"
        style="font-family: {{ $headerSettings->header_font ?? 'inherit' }}; min-height: {{ $headerSettings->header_height ?? 'auto' }}px;">
    
    {{-- Custom CSS if provided --}}
    @if($headerSettings->header_custom_css)
    <style>
        {!! $headerSettings->header_custom_css !!}
    </style>
    @endif
    
    {{-- Dynamic styles based on settings --}}
    <style>
        /* Cart count badge styling */
        .cart-count {
            min-width: 18px;
            min-height: 18px;
            padding: 2px 5px;
            font-size: 10px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }
        
        /* Dynamic Header Layout Support */
        .header__wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }
        
        /* Logo Positioning */
        .header__brand--center {
            margin: 0 auto;
            text-align: center;
        }
        
        /* Navigation Centering */
        .header__navbar--center {
            flex: 1;
            display: flex;
            justify-content: center;
        }
        
        /* Search Container */
        .header__search {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        /* Logo responsive styles */
        .header__brand img {
            object-fit: contain;
            width: auto;
            height: auto;
        }
        
        @media (max-width: 768px) {
            .header__brand img {
                max-width: min(150px, 80vw) !important;
                max-height: 40px !important;
            }
        }
        
        @media (min-width: 769px) and (max-width: 1024px) {
            .header__brand img {
                max-width: min(180px, 60vw) !important;
                max-height: 45px !important;
            }
        }
    </style>
    
    @if($headerSettings->header_shadow)
    <style>
        .header--style-2 {
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
        }
    </style>
    @endif
    
    @if($headerSettings->header_smooth_transitions)
    <style>
        .header * {
            transition: all 0.3s ease-in-out;
        }
    </style>
    @endif
    
    @if($headerSettings->header_scroll_effects && $headerSettings->header_sticky)
    <style>
        .header--sticky {
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .header--sticky.scrolled {
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.12);
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.querySelector('.header--sticky');
            if (header) {
                window.addEventListener('scroll', function() {
                    if (window.scrollY > 50) {
                        header.classList.add('scrolled');
                    } else {
                        header.classList.remove('scrolled');
                    }
                });
            }
        });
    </script>
    @endif
    
    <div class="container">
        <div class="header__wrapper">
            @php
                $logoPosition = $headerSettings->logo_position ?? 'left';
                $showNavInCenter = !$headerSettings->search_bar_enabled && $headerSettings->navigation_enabled;
            @endphp
            
            {{-- Dynamic Arrangement Based on Logo Position --}}
            @if($logoPosition === 'left')
                {{-- Layout: Logo | Navigation/Search | Actions --}}
                
                <!-- Logo (Left) -->
                @if($headerSettings->logo_enabled)
                <div class="header__brand">
                    <a href="{{ route('home') }}">
                        @if($headerSettings->logo_image)
                            <img src="{{ asset('storage/'.$headerSettings->logo_image) }}" 
                                 alt="{{ config('app.name') }}" 
                                 style="max-width: {{ $headerSettings->logo_width ?? 150 }}px; max-height: {{ $headerSettings->logo_height ?? 50 }}px; object-fit: contain;">
                        @elseif($headerSettings->logo_svg)
                            <div style="max-width: {{ $headerSettings->logo_width ?? 150 }}px; max-height: {{ $headerSettings->logo_height ?? 50 }}px;">
                                {!! $headerSettings->logo_svg !!}
                            </div>
                        @elseif(isset($homePage) && $homePage->store_logo)
                            <img src="{{ asset('storage/'.$homePage->store_logo) }}" 
                                 alt="{{ config('app.name') }}" 
                                 style="max-width: {{ $headerSettings->logo_width ?? 150 }}px; max-height: {{ $headerSettings->logo_height ?? 50 }}px; object-fit: contain;">
                        @else
                            <img src="{{ asset('themes/torganic/assets/images/logo/logo-dark.svg') }}" alt="{{ config('app.name') }}">
                        @endif
                    </a>
                </div>
                @endif

                <!-- Navigation Menu (Center) -->
                @if($headerSettings->navigation_enabled)
                <div class="header__navbar">
                    <div class="header__overlay"></div>
                    <nav class="menu">
                        @if($headerSettings->mobile_menu_enabled)
                        <div class="menu-mobile-header">
                            <button type="button" class="menu-mobile-arrow"><i class="fa-solid fa-arrow-left"></i></button>
                            <div class="menu-mobile-title"></div>
                            <button type="button" class="menu-mobile-close"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                        @endif
                        
                        <ul class="menu-section menu-section--style-2">
                            @if($headerSettings->show_home_link)
                            <li><a href="{{ route('home') }}">الرئيسية</a></li>
                            @endif
                            
                            {{-- Dynamic Menu Items from HeaderSettings --}}
                            @if($headerSettings->main_menus_enabled && $headerSettings->menu_items && is_array($headerSettings->menu_items))
                                @foreach ($headerSettings->menu_items as $menuItem)
                                @if(isset($menuItem['is_active']) && $menuItem['is_active'])
                                <li>
                                    <a href="{{ url($menuItem['url'] ?? '#') }}">
                                        {{ $menuItem['name'] ?? 'Menu Item' }}
                                    </a>
                                </li>
                                @endif
                                @endforeach
                            @elseif($headerSettings->main_menus_enabled && isset($menus) && $menus->isNotEmpty())
                                @foreach ($menus->take($headerSettings->main_menus_number ?? 5) as $menu)
                                <li>
                                    <a href="{{ url($menu->url) }}">{{ $menu->title }}</a>
                                </li>
                                @endforeach
                            @endif
                            
                            {{-- Show Categories if Enabled --}}
                            @if($headerSettings->show_categories_in_menu && isset($categories) && $categories->isNotEmpty())
                            <li class="menu-item-has-children">
                                <a href="{{ route('products.index') }}">الأقسام <i class="fa-solid fa-angle-down"></i></a>
                                <div class="submenu">
                                    <ul>
                                        @foreach($categories->take($headerSettings->categories_count ?? 5) as $category)
                                        <li><a href="{{ route('category.show', $category->slug) }}">{{ $category->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                            @endif
                            
                            {{-- Static Pages if Available --}}
                            @if(isset($pages) && $pages->isNotEmpty())
                            <li class="menu-item-has-children">
                                <a href="#">الصفحات <i class="fa-solid fa-angle-down"></i></a>
                                <div class="submenu">
                                    <ul>
                                        @foreach($pages as $page)
                                        <li><a href="{{ route('page.show', $page->slug) }}">{{ $page->title }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </nav>
                </div>
                @endif

                <!-- Header Actions (Right) -->
                @include('themes.torganic.partials.header-actions')
                
            @elseif($logoPosition === 'center')
                {{-- Layout: Actions | Logo/Navigation | Search --}}
                
                <!-- Header Actions (Left) -->
                @include('themes.torganic.partials.header-actions')

                <!-- Logo or Navigation (Center) -->
                @if($showNavInCenter && $headerSettings->navigation_enabled)
                <div class="header__navbar header__navbar--center">
                    <div class="header__overlay"></div>
                    <nav class="menu">
                        @if($headerSettings->mobile_menu_enabled)
                        <div class="menu-mobile-header">
                            <button type="button" class="menu-mobile-arrow"><i class="fa-solid fa-arrow-left"></i></button>
                            <div class="menu-mobile-title"></div>
                            <button type="button" class="menu-mobile-close"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                        @endif
                        
                        <ul class="menu-section menu-section--style-2">
                            @if($headerSettings->show_home_link)
                            <li><a href="{{ route('home') }}">الرئيسية</a></li>
                            @endif
                            
                            {{-- Dynamic Menu Items from HeaderSettings --}}
                            @if($headerSettings->main_menus_enabled && $headerSettings->menu_items && is_array($headerSettings->menu_items))
                                @foreach ($headerSettings->menu_items as $menuItem)
                                @if(isset($menuItem['is_active']) && $menuItem['is_active'])
                                <li>
                                    <a href="{{ url($menuItem['url'] ?? '#') }}">
                                        {{ $menuItem['name'] ?? 'Menu Item' }}
                                    </a>
                                </li>
                                @endif
                                @endforeach
                            @elseif($headerSettings->main_menus_enabled && isset($menus) && $menus->isNotEmpty())
                                @foreach ($menus->take($headerSettings->main_menus_number ?? 5) as $menu)
                                <li>
                                    <a href="{{ url($menu->url) }}">{{ $menu->title }}</a>
                                </li>
                                @endforeach
                            @endif
                            
                            {{-- Show Categories if Enabled --}}
                            @if($headerSettings->show_categories_in_menu && isset($categories) && $categories->isNotEmpty())
                            <li class="menu-item-has-children">
                                <a href="{{ route('products.index') }}">الأقسام <i class="fa-solid fa-angle-down"></i></a>
                                <div class="submenu">
                                    <ul>
                                        @foreach($categories->take($headerSettings->categories_count ?? 5) as $category)
                                        <li><a href="{{ route('category.show', $category->slug) }}">{{ $category->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                            @endif
                            
                            {{-- Static Pages if Available --}}
                            @if(isset($pages) && $pages->isNotEmpty())
                            <li class="menu-item-has-children">
                                <a href="#">الصفحات <i class="fa-solid fa-angle-down"></i></a>
                                <div class="submenu">
                                    <ul>
                                        @foreach($pages as $page)
                                        <li><a href="{{ route('page.show', $page->slug) }}">{{ $page->title }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </nav>
                </div>
                @elseif($headerSettings->logo_enabled)
                <div class="header__brand header__brand--center">
                    <a href="{{ route('home') }}">
                        @if($headerSettings->logo_image)
                            <img src="{{ asset('storage/'.$headerSettings->logo_image) }}" 
                                 alt="{{ config('app.name') }}" 
                                 style="max-width: {{ $headerSettings->logo_width ?? 150 }}px; max-height: {{ $headerSettings->logo_height ?? 50 }}px; object-fit: contain;">
                        @elseif($headerSettings->logo_svg)
                            <div style="max-width: {{ $headerSettings->logo_width ?? 150 }}px; max-height: {{ $headerSettings->logo_height ?? 50 }}px;">
                                {!! $headerSettings->logo_svg !!}
                            </div>
                        @elseif(isset($homePage) && $homePage->store_logo)
                            <img src="{{ asset('storage/'.$homePage->store_logo) }}" 
                                 alt="{{ config('app.name') }}" 
                                 style="max-width: {{ $headerSettings->logo_width ?? 150 }}px; max-height: {{ $headerSettings->logo_height ?? 50 }}px; object-fit: contain;">
                        @else
                            <img src="{{ asset('themes/torganic/assets/images/logo/logo-dark.svg') }}" alt="{{ config('app.name') }}">
                        @endif
                    </a>
                </div>
                @endif

                <!-- Search or Empty Space (Right) -->
                @if($headerSettings->search_bar_enabled)
                <div class="header__search">
                    <button id="trk-search-icon" class="menu-icon search-icon header__action-btn">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>

                    <div class="trk-search">
                        <div class="trk-search__inner">
                            <form action="{{ route('products.search') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="ابحث عن منتج..." aria-label="البحث">
                                    <button type="submit" class="trk-search__btn" id="trk-search">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="trk-search__overlay"></div>
                </div>
                @endif
                
            @else
                {{-- Layout: Actions | Navigation/Search | Logo (Right Position - Default) --}}
                
                <!-- Header Actions (Left) -->
                @include('themes.torganic.partials.header-actions')

                <!-- Navigation Menu (Center) -->
                @if($headerSettings->navigation_enabled)
                <div class="header__navbar">
                    <div class="header__overlay"></div>
                    <nav class="menu">
                        @if($headerSettings->mobile_menu_enabled)
                        <div class="menu-mobile-header">
                            <button type="button" class="menu-mobile-arrow"><i class="fa-solid fa-arrow-left"></i></button>
                            <div class="menu-mobile-title"></div>
                            <button type="button" class="menu-mobile-close"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                        @endif
                        
                        <ul class="menu-section menu-section--style-2">
                            @if($headerSettings->show_home_link)
                            <li><a href="{{ route('home') }}">الرئيسية</a></li>
                            @endif
                            
                            {{-- Dynamic Menu Items from HeaderSettings --}}
                            @if($headerSettings->main_menus_enabled && $headerSettings->menu_items && is_array($headerSettings->menu_items))
                                @foreach ($headerSettings->menu_items as $menuItem)
                                @if(isset($menuItem['is_active']) && $menuItem['is_active'])
                                <li>
                                    <a href="{{ url($menuItem['url'] ?? '#') }}">
                                        {{ $menuItem['name'] ?? 'Menu Item' }}
                                    </a>
                                </li>
                                @endif
                                @endforeach
                            @elseif($headerSettings->main_menus_enabled && isset($menus) && $menus->isNotEmpty())
                                @foreach ($menus->take($headerSettings->main_menus_number ?? 5) as $menu)
                                <li>
                                    <a href="{{ url($menu->url) }}">{{ $menu->title }}</a>
                                </li>
                                @endforeach
                            @endif
                            
                            {{-- Show Categories if Enabled --}}
                            @if($headerSettings->show_categories_in_menu && isset($categories) && $categories->isNotEmpty())
                            <li class="menu-item-has-children">
                                <a href="{{ route('products.index') }}">الأقسام <i class="fa-solid fa-angle-down"></i></a>
                                <div class="submenu">
                                    <ul>
                                        @foreach($categories->take($headerSettings->categories_count ?? 5) as $category)
                                        <li><a href="{{ route('category.show', $category->slug) }}">{{ $category->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                            @endif
                            
                            {{-- Static Pages if Available --}}
                            @if(isset($pages) && $pages->isNotEmpty())
                            <li class="menu-item-has-children">
                                <a href="#">الصفحات <i class="fa-solid fa-angle-down"></i></a>
                                <div class="submenu">
                                    <ul>
                                        @foreach($pages as $page)
                                        <li><a href="{{ route('page.show', $page->slug) }}">{{ $page->title }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </nav>
                </div>
                @endif

                <!-- Logo (Right) -->
                @if($headerSettings->logo_enabled)
                <div class="header__brand">
                    <a href="{{ route('home') }}">
                        @if($headerSettings->logo_image)
                            <img src="{{ asset('storage/'.$headerSettings->logo_image) }}" 
                                 alt="{{ config('app.name') }}" 
                                 style="max-width: {{ $headerSettings->logo_width ?? 150 }}px; max-height: {{ $headerSettings->logo_height ?? 50 }}px; object-fit: contain;">
                        @elseif($headerSettings->logo_svg)
                            <div style="max-width: {{ $headerSettings->logo_width ?? 150 }}px; max-height: {{ $headerSettings->logo_height ?? 50 }}px;">
                                {!! $headerSettings->logo_svg !!}
                            </div>
                        @elseif(isset($homePage) && $homePage->store_logo)
                            <img src="{{ asset('storage/'.$homePage->store_logo) }}" 
                                 alt="{{ config('app.name') }}" 
                                 style="max-width: {{ $headerSettings->logo_width ?? 150 }}px; max-height: {{ $headerSettings->logo_height ?? 50 }}px; object-fit: contain;">
                        @else
                            <img src="{{ asset('themes/torganic/assets/images/logo/logo-dark.svg') }}" alt="{{ config('app.name') }}">
                        @endif
                    </a>
                </div>
                @endif
            @endif
        </div>
    </div>
</header>

{{-- Contact Information Bar --}}
@if($headerSettings->header_contact_enabled && ($headerSettings->header_phone || $headerSettings->header_email))
<div class="bg-light py-2 border-bottom">
    <div class="container">
        <div class="d-flex justify-content-{{ $headerSettings->contact_position === 'center' ? 'center' : ($headerSettings->contact_position === 'right' ? 'end' : 'start') }} gap-3">
            @if($headerSettings->header_phone)
            <a href="tel:{{ $headerSettings->header_phone }}" class="text-decoration-none text-muted small">
                <i class="fa-solid fa-phone"></i> {{ $headerSettings->header_phone }}
            </a>
            @endif
            
            @if($headerSettings->header_email)
            <a href="mailto:{{ $headerSettings->header_email }}" class="text-decoration-none text-muted small">
                <i class="fa-solid fa-envelope"></i> {{ $headerSettings->header_email }}
            </a>
            @endif
        </div>
    </div>
</div>
@endif

{{-- Cart Synchronization Script --}}
@if($headerSettings->shopping_cart_enabled)
<script>
    // Global cart management
    window.CartManager = window.CartManager || {
        updateCartCount: function(newCount) {
            const cartCountElements = document.querySelectorAll('.cart-count');
            cartCountElements.forEach(element => {
                element.textContent = newCount;
                element.style.animation = 'pulse 0.5s';
                setTimeout(() => element.style.animation = '', 500);
            });
        },

        syncCartCount: function() {
            return fetch('/cart/count', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.cart_count !== undefined) {
                    this.updateCartCount(data.cart_count);
                }
                return data;
            })
            .catch(error => console.error('Error syncing cart:', error));
        }
    };

    // Initialize cart on page load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => window.CartManager.syncCartCount(), 500);
        });
    } else {
        setTimeout(() => window.CartManager.syncCartCount(), 500);
    }

    // Legacy support
    window.updateCartCount = window.CartManager.updateCartCount.bind(window.CartManager);
    window.syncCartCount = window.CartManager.syncCartCount.bind(window.CartManager);
</script>
@endif
@endif

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show m-3" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

