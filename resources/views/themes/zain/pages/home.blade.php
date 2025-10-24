<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$storeName}}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com/3.4.16">
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: "#3B82F6", // Blue
                    secondary: "#10B981", // Green
                    accent: "#8B5CF6", // Purple
                    dark: "#111827", // Dark Gray/Black
                    light: "#F3F4F6", // Light Gray
                    success: "#22C55E", // Green (Success)
                    warning: "#F59E0B", // Yellow (Warning)
                    danger: "#EF4444", // Red (Danger)
                    info: "#38BDF8", // Sky Blue (Info)
                    muted: "#6B7280", // Muted Gray
                    white: "#FFFFFF", // White
                    black: "#000000", // Black
                    gray: "#D1D5DB", // Gray
                    pink: "#EC4899", // Pink
                    orange: "#F97316", // Orange
                    teal: "#14B8A6", // Teal
                    indigo: "#6366F1", // Indigo
                    lime: "#84CC16", // Lime Green
                    amber: "#FBBF24", // Amber
                    cyan: "#06B6D4", // Cyan
                    violet: "#A78BFA", // Light Violet
                },
                borderRadius: {
                    none: "0px",
                    sm: "4px",
                    DEFAULT: "8px",
                    md: "12px",
                    lg: "16px",
                    xl: "20px",
                    "2xl": "24px",
                    "3xl": "32px",
                    full: "9999px",
                    button: "8px",
                },
            },
        },
    };
    </script>
    <style>
    :where([class^="ri-"])::before {
        content: "\f3c2";
    }

    body {
        font-family: 'Tajawal', sans-serif;
        background-color: #111827;
        color: #E5E7EB;
    }

    .glass-effect {
        background: rgba(59, 130, 246, 0.1);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .gradient-btn {
        background: linear-gradient(90deg, #3B82F6 0%, #8B5CF6 100%);
    }

    .notification-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background-color: #EF4444;
        color: white;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .search-input:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3);
    }

    .nav-item {
        position: relative;
        transition: all 0.3s ease;
    }

    .nav-item.active::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, #3B82F6 0%, #8B5CF6 100%);
        border-radius: 3px;
    }

    .nav-item:hover {
        color: #3B82F6;
    }
    </style>
</head>

<body>
    <!-- Header -->
    <!-- Header -->
    <header class="w-full py-5 px-6 bg-gray-900/95 backdrop-blur-lg sticky top-0 z-50 border-b border-white/5">
        <div class="container mx-auto flex items-center justify-between">
            <!-- Left Side - Profile & Cart -->
            <div class="flex items-center space-x-6">
                <!-- User Profile -->
                <div class="group relative" id="profileDropdown">
                    @auth
                    <div
                        class="flex items-center space-x-3 cursor-pointer p-2 rounded-lg hover:bg-white/5 transition-all">
                        <!-- User Avatar -->
                        <div
                            class="w-10 h-10 rounded-full bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center relative ring-2 ring-white/10 overflow-hidden">
                            @if (auth()->user()->avatar)
                            <!-- If user has an avatar -->
                            <img src="{{ Storage::url( auth()->user()->avatar) }}" alt="User Avatar"
                                class="w-full h-full object-cover rounded-full">
                            @else
                            <!-- Default avatar -->
                            <i class="ri-user-smile-line text-primary ri-lg"></i>
                            @endif
                        </div>
                        <span class="text-white font-medium pr-2">
                            {{ strlen(auth()->user()->name) > 6 ? substr(auth()->user()->name, 0, 8)  : auth()->user()->name }}
                        </span>
                        <i class="ri-arrow-down-s-line text-gray-400 group-hover:text-white transition-colors"></i>
                    </div>

                    <!-- Dropdown Menu -->
                    <div id="profileMenu"
                        class="absolute left-0 mt-2 w-56 opacity-0 invisible translate-y-2 transition-all duration-300 z-50 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0">
                        <div class="bg-gray-800 rounded-lg shadow-lg border border-gray-700 overflow-hidden">
                            <div class="p-4 border-b border-gray-700">
                                <p class="text-sm text-gray-400">مرحباً بك</p>
                                <p class="text-white font-medium">{{ auth()->user()->name }}</p>
                            </div>
                            <div class="py-2">
                                <a href="{{ route('profile.show') }}"
                                    class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                                    <i class="ri-user-line w-5 h-5 flex items-center justify-center"></i>
                                    <span class="mr-3">الملف الشخصي</span>
                                </a>
                                <a href="#"
                                    class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                                    <i class="ri-shopping-bag-line w-5 h-5 flex items-center justify-center"></i>
                                    <span class="mr-3">طلباتي</span>
                                </a>
                                <a href="#"
                                    class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                                    <i class="ri-heart-line w-5 h-5 flex items-center justify-center"></i>
                                    <span class="mr-3">المفضلة</span>
                                </a>
                                <a href="#"
                                    class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                                    <i class="ri-settings-line w-5 h-5 flex items-center justify-center"></i>
                                    <span class="mr-3">الإعدادات</span>
                                </a>
                                <div class="border-t border-gray-700">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center px-4 py-3 text-red-400 hover:bg-gray-700 hover:text-red-300 transition-colors w-full text-left">
                                            <i class="ri-logout-box-line w-5 h-5 flex items-center justify-center"></i>
                                            <span class="mr-3">تسجيل الخروج</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <!-- Show Login Button if not authenticated -->
                    <button
                        class="relative overflow-hidden px-6 py-3 ml-3  rounded-xl bg-gradient-to-r from-primary to-secondary text-white font-medium hover:shadow-lg hover:shadow-primary/20 transition-all duration-300 whitespace-nowrap group">
                        <a href="{{ route('login') }}" class="relative z-10">تسجيل الدخول</a>
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-secondary to-primary opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </button>
                    @endauth
                </div>

                <!-- Notifications -->
                <!-- <div class="relative">
                <div class="w-10 h-10 rounded-lg bg-white/5 hover:bg-white/10 transition-colors flex items-center justify-center cursor-pointer group">
                    <i class="ri-notification-3-line text-gray-400 group-hover:text-white transition-colors ri-lg"></i>
                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-primary text-white text-xs font-bold rounded-full flex items-center justify-center">6</span>
                </div>
            </div> -->

                <!-- Cart -->
                <div class="relative">
                    <div
                        class="w-10 h-10 mr-2  rounded-lg bg-white/5 hover:bg-white/10 transition-colors flex items-center justify-center cursor-pointer group">
                        <i
                            class="ri-shopping-cart-2-line text-gray-400 group-hover:text-white transition-colors ri-lg"></i>
                        <span
                            class="absolute -top-1 -right-0 w-5 h-5 bg-secondary text-white text-xs font-bold rounded-full flex items-center justify-center">3</span>
                    </div>
                </div>
            </div>

            <!-- Middle - Search Bar -->
            <div class="flex-1 max-w-2xl mx-8">
                <div class="relative group">
                    <input type="text" placeholder="ابحث عن منتج محدد..."
                        class="w-full bg-white/5 text-white py-3 px-5 pr-12 rounded-xl border border-white/10 focus:border-primary/30 focus:bg-white/10 transition-all text-sm">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                        <i class="ri-search-2-line text-gray-400 group-hover:text-primary transition-colors"></i>
                    </div>
                </div>
            </div>

            <!-- Right Side - Logo -->
            <div class="flex items-center space-x-6">
                <!-- <div
                    class="text-2xl font-['Pacifico'] bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">
                    logo
                </div> -->
                @if($homePage->store_logo)
                <img src="{{ asset('storage/' . $homePage->store_logo) }}" alt="Logo" class="w-10 h-10">
                @endif
            </div>
        </div>
    </header>

    <!-- Navigation Menu -->
    <nav class="w-full py-4 bg-gray-900">
        <div class="container mx-auto flex justify-center">
            <div class="flex space-x-8">



                @foreach($menus as $menu)
                <a href="{{ $menu->url }}"
                    class="nav-item  gap-1.5 flex items-center space-x-2 text-gray-300 hover:text-white font-medium px-3 py-2">
                    @if($menu->svg)
                    {!! $menu->svg !!}
                    @else
                    <i class="ri-fire-line ri-lg"></i>
                    @endif
                    <span> {{ $menu->title }}</span>
                </a>
                @endforeach


            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    @if($homePage->hero_enabled)
    <section class="relative w-full h-[500px] overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0 bg-cover bg-center"
            style="background-image: url('{{ asset('storage/' . $homePage->hero_background_image) }}');">
            <!-- Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-r from-dark/80 to-dark/40"></div>
        </div>

        <!-- Content -->
        <div class="container mx-auto h-full flex items-center">
            <div class="glass-effect max-w-2xl p-8 rounded-lg mr-8">
                <h1 class="text-5xl font-bold mb-4 text-white"> {{$homePage->store_name}} </h1>
                <p class="text-2xl text-gray-200 mb-8"> {{$homePage->store_description}} </p>
                <div class="flex space-x-4">

                    <a href="{{$homePage->hero_button1_link}}"
                        class="gradient-btn ml-4  text-white py-3 px-8 rounded-button font-medium text-lg whitespace-nowrap">
                        {{$homePage->hero_button1_text}}
                    </a>
                    <a href="{{$homePage->hero_button2_link}}"
                        class="bg-white/10 text-white py-3 px-8 rounded-button font-medium text-lg border border-white/20 whitespace-nowrap">
                        {{$homePage->hero_button2_text}}
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif
    <!-- main content sections -->
    <div class="container mx-auto px-4 mt-8">
        <!-- عرض الأقسام الديناميكية -->
        @if($homePage)
        {{--  @if($section->type == 'custom_content')
        @continue
        @endif --}}

        @if($homePage->categories_enabled)
        <section class="py-16 bg-gray-900">
            <div class="container mx-auto">
                <h2 class="text-3xl font-bold text-white mb-12 text-center">{{$homePage->categories_title}}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

                    @foreach( $categories as $category)


                    <div
                        class="bg-gray-800 shadow-[5px_4px_6px_-6px_rgba(0,_0,_0,_0.7)] rounded-lg overflow-hidden transition-transform duration-300 hover:transform hover:scale-105">
                        @if($category->image)
                        <img class="h-48 bg-cover bg-center w-full"
                            src="https://readdy.ai/api/search-image?query=video%20game%20controller%20with%20vibrant%20blue%20lighting%20against%20dark%20background%2C%20professional%20gaming%20equipment%2C%20high-quality%20rendering&width=400&height=300&seq=12346&orientation=landscape">

                        @else
                        <img class="h-48 bg-cover bg-center w-full"
                            src="https://readdy.ai/api/search-image?query=video%20game%20controller%20with%20vibrant%20blue%20lighting%20against%20dark%20background%2C%20professional%20gaming%20equipment%2C%20high-quality%20rendering&width=400&height=300&seq=12346&orientation=landscape">
                        @endif
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-white mb-2">{{ $category->name }}</h3>
                            <p class="text-gray-300 mb-4">{{ $category->description ?? 'تصفح منتجات هذا القسم' }}</p>
                            <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                                class="text-primary font-medium flex items-center">
                                <span>تصفح الآن</span>
                                <i class="ri-arrow-left-line mr-2"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        @endif
        
        {{--   @if($section->type == 'newsletter')
        <!-- old one   Newsletter -->
    <section class="py-16 bg-gray-800 relative overflow-hidden">
            <div class="absolute inset-0 opacity-5">
                <div class="absolute top-0 left-0 w-full h-full"
                    style="background-image: url('data:image/svg+xml,%3Csvg width=\" 60\" height=\"60\" viewBox=\"0 0 60
                    60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg
                    fill=\"%239C92AC\" fill-opacity=\"0.4\"%3E%3Cpath d=\"M36
                    34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6
                    34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                </div>
            </div>

            <div class="container mx-auto relative z-10">
                <div class="max-w-3xl mx-auto text-center">
                    <h2 class="text-3xl font-bold text-white mb-4">{{ $section->title }}</h2>
        @if($section->subtitle)
        <p class="text-gray-300 mb-8">{{ $section->subtitle }}</p>
        @endif

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <input type="email" placeholder="أدخل بريدك الإلكتروني"
                class="bg-gray-700 text-white py-3 px-6 rounded-button border-none flex-grow max-w-md">
            <button class="gradient-btn text-white py-3 px-8 rounded-button font-medium whitespace-nowrap">
                اشترك الآن
            </button>
        </div>
         </div>
        </div>
    </section>
    @endif
    --}}






    {{--    @if($section->type == 'featured_categories')


        <!-- Featured Categories -->
        <section class="py-16 bg-gray-900">
                <div class="container mx-auto">
                    <div class="flex justify-between items-center mb-12">
                        <h2 class="text-3xl font-bold text-white">{{ $section->title }}</h2>
    <a href="{{ route('products.index') }}" class="text-primary font-medium flex items-center">
        <span>عرض الكل</span>
        <i class="ri-arrow-left-line mr-2"></i>
    </a>
    </div>
    @if($section->subtitle && $section->subtitle != $section->title)
    <p class="text-gray-400 mb-4 text-center">{{ $section->subtitle }}</p>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">


        @php
        $maxCategories = 3;
        $categoriesToShow = $categories->take($maxCategories);
        @endphp
        @foreach($categoriesToShow as $category)


        <div
            class="bg-gray-800 shadow-[5px_4px_6px_-6px_rgba(0,_0,_0,_0.7)] rounded-lg overflow-hidden transition-transform duration-300 hover:transform hover:scale-105">
            @if($category->image)
            <img class="h-48 bg-cover bg-center w-full" src="{{ $category->image }}">
            @else
            <img class="h-48 bg-cover bg-center w-full"
                src="https://readdy.ai/api/search-image?query=video%20game%20controller%20with%20vibrant%20blue%20lighting%20against%20dark%20background%2C%20professional%20gaming%20equipment%2C%20high-quality%20rendering&width=400&height=300&seq=12346&orientation=landscape">
            @endif
            <div class="p-6">
                <h3 class="text-xl font-bold text-white mb-2">{{ $category->name }}</h3>
                <p class="text-gray-300 mb-4">{{ $category->description ?? 'تصفح منتجات هذا القسم' }}</p>
                <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                    class="text-primary font-medium flex items-center">
                    <span>تصفح الآن</span>
                    <i class="ri-arrow-left-line mr-2"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>
    </div>
    </section>





    @endif
    --}}

    <div class="w-full mb-16">
        @if($homePage->featured_enabled)
        <!-- Featured Products -->

        <section class="py-16 bg-gray-800">
            <div class="container mx-auto">
                <div class="flex justify-between items-center mb-12">
                    <h2 class="text-3xl font-bold text-white">{{ $homePage->featured_title }}</h2>
                    <a href="{{ route('products.featured') }}" class="text-primary font-medium flex items-center">
                        <span>عرض الكل</span>
                        <i class="ri-arrow-left-line mr-2"></i>
                    </a>
                </div>



                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @forelse($featuredProducts as $product)
                    <div class="bg-gray-900 rounded-lg overflow-hidden shadow-lg">
                        <div class="h-40 sm:h-48 bg-gradient-to-b from-[#1e1e1e] to-[#121212]"
                            style="background-image: url('{{ $product->image_url }}'); background-size: cover; background-position: center;">
                        </div>

                        <div class="p-3 gap-1 sm:p-4 flex flex-col flex-grow">
                            <div class="flex justify-between items-center mb-3">
                                <span
                                    class="bg-{{$product->category->text_color ?? 'primary'}}/20 text-{{$product->category->text_color ?? 'primary'}} px-3 py-1 rounded-full text-sm font-medium">
                                    {{ $product->category ? $product->category->name : 'عام' }}
                                </span>
                                <div class="flex items-center">
                                    @if($product->reviews_avg_rating && $product->reviews_avg_rating > 0)
                                    <i class="ri-star-fill text-yellow-400"></i>
                                    <span
                                        class="text-gray-300 mr-1">{{ number_format($product->reviews_avg_rating, 1) }}</span>
                                    @else
                                    <i class="ri-star-line text-yellow-400"></i>
                                    <span class="text-gray-300 mr-1">0</span>
                                    @endif
                                </div>
                            </div>

                            <h3 class="text-xl font-bold text-white mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-400 mb-4">
                                {{ substr($product->meta_description ?? $product->description, 0, 60) }}</p>

                            <div class="flex justify-between items-center">
                                <div class="mt-auto">
                                    <div class="mb-3">
                                        @if($product->has_discount)
                                        <div class="text-primary font-bold text-xl">{{ $product->display_price }} ر.س
                                        </div>
                                        <div class="text-gray-400 text-sm line-through">
                                            {{ $product->display_old_price }} ر.س</div>
                                        @else
                                        <div class="text-primary font-bold text-xl">{{ $product->display_price }} ر.س
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <a href="{{ route('products.show', $product->slug) }}"
                                    class="bg-primary text-white p-2 rounded-full w-10 h-10 flex items-center justify-center whitespace-nowrap !rounded-button">
                                    <i class="ri-shopping-cart-line"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center p-8">
                        <i class="ri-inbox-2-line text-5xl text-gray-400 mb-4"></i>
                        <p class="text-gray-400">لا توجد منتجات متاحة في هذا القسم حالياً.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </section> 

    

        @elseif($section->type == 'testimonials')
        <!-- Testimonials -->
        <section class="py-16 bg-gray-900">
            <div class="container mx-auto">
                <h2 class="text-3xl font-bold text-white mb-12 text-center">{{$reviewsSection->name}} </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($reviews as $review)
                    <div class="glass-effect p-8 rounded-lg">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center mr-4">
                                <i class="ri-user-line text-primary ri-lg"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-white">
                                    {{ $review->name ? mb_substr($review->name, 0, 12) : 'م' }}</h4>
                                <div class="flex text-yellow-400 mb-3">
                                    @for($i = 1; $i <= 5; $i++) @if($i <=$review->rating)
                                        <i class="ri-star-fill"></i>
                                        @elseif($i - 0.5 == $review->rating)
                                        <i class="ri-star-half-fill"></i>
                                        @else
                                        <i class="ri-star-line"></i>
                                        @endif
                                        @endfor
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-300">{{ $review->review }} </p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>



        @elseif($section->type == 'store_features')

        <div class="relative rounded-lg overflow-hidden">
            @if($section->getSetting('background_image'))
            <div class="absolute inset-0 bg-cover bg-center" style="
                            background-image: url('{{ asset('storage/' . $section->getSetting('background_image')) }}');
                            opacity: {{ number_format(($section->getSetting('image_opacity', 70) / 100), 2) }};
                        "></div>
            @endif
            <div class="absolute inset-0" style="
                        background-color: {{ $section->getSetting('background_color', '#121212') }};
                        opacity: {{ number_format(($section->getSetting('bg_opacity', 80) / 100), 2) }};
                    "></div>
            <div class="relative z-10 p-8 md:p-12">
                <div class="container mx-auto px-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @for($i = 1; $i <= 4; $i++) @php $title=$section->settings['feature_'.$i.'_title'] ?? null;
                            $desc = $section->settings['feature_'.$i.'_description'] ?? null;
                            $icon = $section->settings['feature_'.$i.'_icon'] ?? null;
                            @endphp
                            @if($title || $desc || $icon)
                            <div class="glass-effect rounded-lg p-6 text-center">
                                <div
                                    class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-r from-primary to-secondary flex items-center justify-center">
                                    <i class="{{ $icon }} text-white text-2xl"></i>
                                </div>
                                <h3 class="text-xl font-bold text-white mb-2">{{ $title }}</h3>
                                <p class="text-gray-400">{{ $desc }}</p>
                            </div>
                            @endif
                            @endfor
                    </div>
                </div>
            </div>
        </div>
        @else


        <!-- Default section display for other types -->
        @php
        $products = $section->getProducts($section->getSetting('products_limit', 8),$storeId);
        @endphp


        @endif


        @if($homePage->brand_enabled)
        <!-- Brand Products -->
        <section class="py-16 bg-gray-800">
            <div class="container mx-auto">
                <div class="flex justify-between items-center mb-12">
                    <h2 class="text-3xl font-bold text-white">{{ $homePage->brand_title }}</h2>
                    <a href="{{ route('products.featured') }}" class="text-primary font-medium flex items-center">
                        <span>عرض الكل</span>
                        <i class="ri-arrow-left-line mr-2"></i>
                    </a>
                </div>



                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @forelse($brandProducts as $product)
                    <div class="bg-gray-900 rounded-lg overflow-hidden shadow-lg">
                        <div class="h-40 sm:h-48 bg-gradient-to-b from-[#1e1e1e] to-[#121212]"
                            style="background-image: url('{{ $product->image_url }}'); background-size: cover; background-position: center;">
                        </div>

                        <div class="p-3 gap-1 sm:p-4 flex flex-col flex-grow">
                            <div class="flex justify-between items-center mb-3">
                                <span
                                    class="bg-{{$product->category->text_color ?? 'primary'}}/20 text-{{$product->category->text_color ?? 'primary'}} px-3 py-1 rounded-full text-sm font-medium">
                                    {{ $product->category ? $product->category->name : 'عام' }}
                                </span>
                                <div class="flex items-center">
                                    @if($product->reviews_avg_rating && $product->reviews_avg_rating > 0)
                                    <i class="ri-star-fill text-yellow-400"></i>
                                    <span
                                        class="text-gray-300 mr-1">{{ number_format($product->reviews_avg_rating, 1) }}</span>
                                    @else
                                    <i class="ri-star-line text-yellow-400"></i>
                                    <span class="text-gray-300 mr-1">0</span>
                                    @endif
                                </div>
                            </div>

                            <h3 class="text-xl font-bold text-white mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-400 mb-4">
                                {{ substr($product->meta_description ?? $product->description, 0, 60) }}</p>

                            <div class="flex justify-between items-center">
                                <div class="mt-auto">
                                    <div class="mb-3">
                                        @if($product->has_discount)
                                        <div class="text-primary font-bold text-xl">{{ $product->display_price }} ر.س
                                        </div>
                                        <div class="text-gray-400 text-sm line-through">
                                            {{ $product->display_old_price }} ر.س</div>
                                        @else
                                        <div class="text-primary font-bold text-xl">{{ $product->display_price }} ر.س
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <a href="{{ route('products.show', $product->slug) }}"
                                    class="bg-primary text-white p-2 rounded-full w-10 h-10 flex items-center justify-center whitespace-nowrap !rounded-button">
                                    <i class="ri-shopping-cart-line"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center p-8">
                        <i class="ri-inbox-2-line text-5xl text-gray-400 mb-4"></i>
                        <p class="text-gray-400">لا توجد منتجات متاحة في هذا القسم حالياً.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </section> 
        @endif


        @if($homePage->services_enabled)
        <div class="relative rounded-lg overflow-hidden">
            {{-- @if($section->getSetting('background_image'))
            <div class="absolute inset-0 bg-cover bg-center" style="
                            background-image: url('{{ asset('storage/' . $section->getSetting('background_image')) }}');
                            opacity: {{ number_format(($section->getSetting('image_opacity', 70) / 100), 2) }};
                        "></div>
            @endif
            --}}
            <div class="absolute inset-0" style="
                        background-color: #121212;
                        opacity: 1;
                    "></div>
                    
            <div class="relative z-10 p-8 md:p-12">
                <div class="container mx-auto px-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($homePage->services_data as $service)
                            <div class="glass-effect rounded-lg p-6 text-center">
                                <div
                                    class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-r from-primary to-secondary flex items-center justify-center">
                                    <i class="{{$service['icon']}} text-white text-2xl"></i>
                                </div>
                                <h3 class="text-xl font-bold text-white mb-2">{{ $service['title'] }}</h3>
                                <p class="text-gray-400">{{ $service['description'] }}</p>
                            </div>
                            @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif





    </div>
    @endif

 
    </div>



    <!-- Footer -->
    <footer class="bg-gray-900 pt-16 pb-8">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <!-- Company Info -->
                <div>
                    <div class="text-3xl font-['Pacifico'] text-white mb-6">
                        logo
                    </div>
                    <p class="text-gray-400 mb-6">{{$footer->description}}</p>
                    <div class="flex space-x-4">
                        <a href="{{$footer->x}}" target="_blank"
                            class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:text-white hover:bg-primary transition-colors">
                            <i class="ri-twitter-x-line"></i>
                        </a>
                        <a href="{{$footer->instagram }}" target="_blank"
                            class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:text-white hover:bg-primary transition-colors">
                            <i class="ri-instagram-line"></i>
                        </a>
                        <a href="{{$footer->facebook}}" target="_blank"
                            class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:text-white hover:bg-primary transition-colors">
                            <i class="ri-facebook-line"></i>
                        </a>
                        <a href="{{$footer->snapchat}}" target="_blank"
                            class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:text-white hover:bg-primary transition-colors">
                            <i class="ri-snapchat-line"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-xl font-bold text-white mb-6">روابط سريعة</h4>
                    <ul class="space-y-3">
                        @foreach($menus as $menu )
                        <li><a href="#" class="text-gray-400 hover:text-primary"> {{$menu->title}} </a></li>
                        @endforeach
                    </ul>
                </div>

                <!-- Categories -->
                <div>
                    <h4 class="text-xl font-bold text-white mb-6">الفئات</h4>
                    <ul class="space-y-3">
                        @foreach( $cats as $cat )
                        <li><a href="#" class="text-gray-400 hover:text-primary"> {{$cat->name}}</a></li>
                        @endforeach
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-xl font-bold text-white mb-6">تواصل معنا</h4>
                    <ul class="space-y-3">
                        <li class="flex items-center text-gray-400">
                            <i class="ri-map-pin-line mr-3 text-primary"></i>
                            <span>
                                {{$footer->contact_address}}
                            </span>
                        </li>
                        <li class="flex items-center text-gray-400">
                            <i class="ri-mail-line mr-3 text-primary"></i>
                            <span>{{$footer->contact_email}}</span>
                        </li>
                        <li class="flex items-center text-gray-400">
                            <i class="ri-phone-line mr-3 text-primary"></i>
                            <span>{{$footer->contact_phone}}</span>
                        </li>
                        <li class="flex items-center text-gray-400">
                            <i class="ri-time-line mr-3 text-primary"></i>
                            <span> {{$footer->availability}}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="border-t border-gray-800 pt-8">
                <div class="flex flex-wrap justify-between items-center">
                    <div class="text-gray-500 text-sm">
                        {{$footer->copywright}}
                    </div>
                    <div class="flex space-x-4 mt-4 sm:mt-0">
                        <div class="w-10 h-6 bg-gray-800 rounded flex items-center justify-center">
                            <i class="ri-visa-fill text-blue-500 ri-lg"></i>
                        </div>
                        <div class="w-10 h-6 bg-gray-800 rounded flex items-center justify-center">
                            <i class="ri-mastercard-fill text-orange-500 ri-lg"></i>
                        </div>
                        <div class="w-10 h-6 bg-gray-800 rounded flex items-center justify-center">
                            <i class="ri-paypal-fill text-blue-600 ri-lg"></i>
                        </div>
                        <div class="w-10 h-6 bg-gray-800 rounded flex items-center justify-center">
                            <i class="ri-apple-fill text-gray-300 ri-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script id="navInteraction">
    document.addEventListener("DOMContentLoaded", function() {
        const navItems = document.querySelectorAll(".nav-item");
        navItems.forEach((item) => {
            item.addEventListener("click", function() {
                navItems.forEach((navItem) => {
                    navItem.classList.remove("active");
                });
                this.classList.add("active");
            });
        });
        const profileDropdown = document.getElementById("profileDropdown");
        const profileMenu = document.getElementById("profileMenu");
        let isOpen = false;
        profileDropdown.addEventListener("click", function(e) {
            e.stopPropagation();
            isOpen = !isOpen;
            if (isOpen) {
                profileMenu.classList.remove("opacity-0", "invisible", "translate-y-2");
                profileMenu.classList.add("opacity-100", "visible", "translate-y-0");
            } else {
                profileMenu.classList.add("opacity-0", "invisible", "translate-y-2");
                profileMenu.classList.remove("opacity-100", "visible", "translate-y-0");
            }
        });
        document.addEventListener("click", function(e) {
            if (!profileDropdown.contains(e.target) && isOpen) {
                isOpen = false;
                profileMenu.classList.add("opacity-0", "invisible", "translate-y-2");
                profileMenu.classList.remove("opacity-100", "visible", "translate-y-0");
            }
        });
    });
    </script>
    <script id="searchInteraction">
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.querySelector(".search-input");
        searchInput.addEventListener("focus", function() {
            this.classList.add("ring-2", "ring-primary/30");
        });
        searchInput.addEventListener("blur", function() {
            this.classList.remove("ring-2", "ring-primary/30");
        });
    });
    </script>


    {{-- اضافة مارجن الى العنصر الاول من المنيو --}}
    <script>
    const d = document.querySelector('body > nav > div > div > a:nth-child(1)');
    if (d) {
        d.classList.add('ml-10');
    }
    </script>
</body>

</html>