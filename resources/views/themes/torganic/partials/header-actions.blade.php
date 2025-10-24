<div class="header__action">
    <!-- User Account -->
    @if($headerSettings->user_menu_enabled)
        @auth
        <a class="header__action-btn d-none d-xl-grid" href="{{ route('profile.show') }}" title="حسابي">
            <i class="fa-regular fa-user"></i>
        </a>
        @else
        <a class="header__action-btn d-none d-xl-grid" href="{{ route('login') }}" title="تسجيل الدخول">
            <i class="fa-regular fa-user"></i>
        </a>
        @endauth
    @endif

    <!-- Wishlist -->
    @if($headerSettings->wishlist_enabled)
    <a class="header__action-btn d-none d-xl-grid" href="#" title="المفضلة">
        <i class="fa-regular fa-heart"></i>
    </a>
    @endif

    <!-- Cart -->
    @if($headerSettings->shopping_cart_enabled)
    <a class="header__action-btn d-none d-xl-grid position-relative" href="{{ route('cart.index') }}" title="سلة التسوق">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="cart-icon">
            <path d="M4.92383 18.2228C4.92383 18.6943 5.11832 19.1464 5.46451 19.4798C5.81071 19.8132 6.28025 20.0005 6.76985 20.0005C7.25944 20.0005 7.72899 19.8132 8.07518 19.4798C8.42138 19.1464 8.61587 18.6943 8.61587 18.2228C8.61587 17.7513 8.42138 17.2991 8.07518 16.9658C7.72899 16.6324 7.25944 16.4451 6.76985 16.4451C6.28025 16.4451 5.81071 16.6324 5.46451 16.9658C5.11832 17.2991 4.92383 17.7513 4.92383 18.2228Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M15.0762 18.2228C15.0762 18.6943 15.2707 19.1464 15.6169 19.4798C15.9631 19.8132 16.4326 20.0005 16.9222 20.0005C17.4118 20.0005 17.8813 19.8132 18.2275 19.4798C18.5737 19.1464 18.7682 18.6943 18.7682 18.2228C18.7682 17.7513 18.5737 17.2991 18.2275 16.9658C17.8813 16.6324 17.4118 16.4451 16.9222 16.4451C16.4326 16.4451 15.9631 16.6324 15.6169 16.9658C15.2707 17.2991 15.0762 17.7513 15.0762 18.2228Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M16.923 16.4446H6.76985V4.00049H4.92383" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M6.76953 5.77881L19.6917 6.66767L18.7687 12.8897H6.76953" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        @php
            $cartCount = 0;
            $sessionCartCount = session()->get('cart_count');
            
            if ($sessionCartCount !== null) {
                $cartCount = $sessionCartCount;
            } else {
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
                session()->put('cart_count', $cartCount);
            }
        @endphp
        @if($cartCount > 0)
        <span class="badge bg-primary cart-count position-absolute top-0 start-100 translate-middle rounded-circle">{{ $cartCount }}</span>
        @endif
    </a>

    <!-- Mobile Cart -->
    @if($headerSettings->mobile_cart_enabled)
    <a href="{{ route('cart.index') }}" class="header__action-btn menu-icon d-xl-none position-relative">
        <i class="fa-solid fa-cart-shopping"></i>
        @if($cartCount > 0)
        <span class="badge bg-primary cart-count position-absolute top-0 start-100 translate-middle rounded-circle">{{ $cartCount }}</span>
        @endif
    </a>
    @endif
    @endif

    <!-- Search -->
    @if($headerSettings->search_bar_enabled)
    <button id="trk-search-icon" class="menu-icon search-icon header__action-btn">
        <i class="fa-solid fa-magnifying-glass"></i>
    </button>

    <!-- Search Box -->
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
    @endif

    <!-- Mobile Menu Toggle -->
    @if($headerSettings->mobile_menu_enabled)
    <button type="button" class="menu-mobile-trigger menu-mobile-trigger--style-2">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </button>
    @endif
</div>

