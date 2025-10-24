<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $homePage->store_name }}</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#57b5e7',
                    secondary: '#8dd3c7'
                },
                borderRadius: {
                    'none': '0px',
                    'sm': '4px',
                    DEFAULT: '8px',
                    'md': '12px',
                    'lg': '16px',
                    'xl': '20px',
                    '2xl': '24px',
                    '3xl': '32px',
                    'full': '9999px',
                    'button': '8px'
                }
            }
        }
    }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @if($headerSettings->header_font == 'Pacifico')
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    @elseif($headerSettings->header_font == 'Tajawal')  
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    @elseif($headerSettings->header_font == 'Inter')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    @elseif($headerSettings->header_font == 'Cairo')
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;700&display=swap" rel="stylesheet">
    @elseif($headerSettings->header_font == 'Amiri')
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;500;700&display=swap" rel="stylesheet">
    @elseif($headerSettings->header_font == 'Noto Kufi Arabic')
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;500;700&display=swap" rel="stylesheet">
    @elseif($headerSettings->header_font == 'Changa')
    <link href="https://fonts.googleapis.com/css2?family=Changa:wght@400;500;700&display=swap" rel="stylesheet">
    @elseif($headerSettings->header_font == 'Almarai')
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@400;500;700&display=swap" rel="stylesheet"> 
    @elseif($headerSettings->header_font == 'IBMPlexArabic')
    <link href="https://fonts.googleapis.com/css2?family=IBMPlexArabic:wght@400;500;700&display=swap" rel="stylesheet"> 
    @elseif($headerSettings->header_font == 'Rubik')
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
    @else
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
    :where([class^="ri-"])::before {
        content: "\f3c2";
    }

    *, *::before, *::after {
        box-sizing: border-box;
    }

    html, body {
        margin: 0;
        padding: 0;
        overflow-x: hidden;
        box-sizing: border-box;
    }

    body {
        background-color: #0a1525;
        color: #fff;
        font-family: '{{$headerSettings->header_font}}', sans-serif;
        direction: rtl;
    }

    .game-card img {
        transform: scaleX(-1);
    }

    [class*="space-x-"]:not(.flex-row-reverse)> :not([hidden])~ :not([hidden]) {
        --tw-space-x-reverse: 1;
    }

    .flex:not(.flex-row-reverse)>.space-x-1> :not([hidden])~ :not([hidden]) {
        --tw-space-x-reverse: 1;
    }

    .flex:not(.flex-row-reverse)>.space-x-2> :not([hidden])~ :not([hidden]) {
        --tw-space-x-reverse: 1;
    }

    .flex:not(.flex-row-reverse)>.space-x-4> :not([hidden])~ :not([hidden]) {
        --tw-space-x-reverse: 1;
    }

    .flex:not(.flex-row-reverse)>.space-x-6> :not([hidden])~ :not([hidden]) {
        --tw-space-x-reverse: 1;
    }

    .flex:not(.flex-row-reverse)>.space-x-8> :not([hidden])~ :not([hidden]) {
        --tw-space-x-reverse: 1;
    }

    .glow-effect {
        box-shadow: 0 0 15px rgba(87, 181, 231, 0.3);
    }

    .card-gradient {
        background: linear-gradient(180deg, rgba(30, 41, 59, 0.8) 0%, rgba(15, 23, 42, 0.9) 100%);
    }

    .category-card {
        transition: all 0.3s ease;
    }

    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(87, 181, 231, 0.2);
    }

    .game-card {
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .game-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(87, 181, 231, 0.3);
    }

    .game-card:hover img {
        transform: scale(1.05);
    }

    .game-card img {
        transition: transform 0.5s ease;
    }

    .badge {
        text-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
    }

    .epic-badge {
        background: linear-gradient(90deg, #9333ea 0%, #c026d3 100%);
    }

    .rare-badge {
        background: linear-gradient(90deg, #2563eb 0%, #38bdf8 100%);
    }

    .legendary-badge {
        background: linear-gradient(90deg, #16a34a 0%, #22c55e 100%);
    }

    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    </style>
</head>

<body class="min-h-screen w-full">
    @include('themes.greenGame.partials.top-header')
    @include('themes.greenGame.partials.header')    

    <!-- Main Content -->
    <main class="container mx-auto  py-6">
        <!-- Hero Banner -->
         @if($homePage->hero_enabled)
        <div class="relative rounded-xl overflow-hidden mb-8 h-64">
            <div class="absolute inset-0 bg-gradient-to-l from-[#0f172a]/90 to-transparent z-10"></div>
            @if($homePage->hero_background_image)
                <img src="{{asset('storage/'. $homePage->hero_background_image)}}"
                    alt="Special Rewards" class="w-full h-full object-cover object-top">
            @elseif(\App\Models\Setting::get('store_logo'))
                <img src="{{ asset('storage/' . \App\Models\Setting::get('store_logo')) }}"
                    alt="{{ \App\Models\Setting::get('store_name', 'Store Logo') }}" class="w-full h-full object-contain p-8">
            @else
                <div class="w-full h-full bg-gradient-to-br from-primary/20 to-secondary/20"></div>
            @endif
            <div class="absolute top-0 left-0 w-full h-full flex flex-col justify-center z-20 px-8">
                <div class="text-sm text-green-400 font-semibold mb-1">{{$homePage->hero_button1_text}}</div>
                <h2 class="text-3xl font-bold text-white mb-2">{{$homePage->hero_title}}</h2>
                <p class="text-gray-300 max-w-md">{{$homePage->hero_subtitle}}</p>
                <a
                href="{{$homePage->hero_button1_link}}"
                    class="mt-4 bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-button flex items-center space-x-2 w-fit whitespace-nowrap">
                    <i class="ri-gift-2-line"></i>
                    <span>{{$homePage->hero_button1_text}}</span>
                 </a>
            </div>
        </div>
        @endif
        <!-- Categories Section -->
         @if($homePage->categories_enabled)
        <div class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-white">{{$homePage->categories_title}}</h3>
                <button class="text-primary hover:text-blue-400 flex items-center space-x-1 text-sm flex-row-reverse">
                    <span>View All</span>
                    <i class="ri-arrow-left-s-line"></i>
                </button>
            </div>
            <div class="grid grid-cols-5 gap-4">
                @foreach($homePage->categories_data as $categoryData)
                    @php
                        $category = $categories->firstWhere('id', $categoryData['id'] ?? $categoryData);
                    @endphp
                    @if($category)
                    <div class="category-card bg-[#1e293b] rounded-xl p-4 flex flex-col items-center cursor-pointer">
                        <div class="w-12 h-12 rounded-full {{$category->bg_color ? 'bg-['.$category->bg_color.']/20' : 'bg-yellow-500/20'}} flex items-center justify-center mb-3">
                            <i class="{{$category->icon}} {{$category->bg_color ? 'text-['.$category->bg_color.']' : 'text-yellow-500'}} text-xl"></i>
                        </div>
                        <span class="text-sm text-center">{{$category->name}}</span>
                    </div>
                    @endif
                @endforeach
                <!-- <div class="category-card bg-[#1e293b] rounded-xl p-4 flex flex-col items-center cursor-pointer">
                    <div class="w-12 h-12 rounded-full bg-pink-500/20 flex items-center justify-center mb-3">
                        <i class="ri-tiktok-fill text-pink-500 text-xl"></i>
                    </div>
                    <span class="text-sm text-center">TikTok Coins</span>
                </div>
                <div class="category-card bg-[#1e293b] rounded-xl p-4 flex flex-col items-center cursor-pointer">
                    <div class="w-12 h-12 rounded-full bg-red-500/20 flex items-center justify-center mb-3">
                        <i class="ri-play-circle-fill text-red-500 text-xl"></i>
                    </div>
                    <span class="text-sm text-center">Google Play</span>
                </div>
                <div class="category-card bg-[#1e293b] rounded-xl p-4 flex flex-col items-center cursor-pointer">
                    <div class="w-12 h-12 rounded-full bg-blue-500/20 flex items-center justify-center mb-3">
                        <i class="ri-facebook-fill text-blue-500 text-xl"></i>
                    </div>
                    <span class="text-sm text-center">Social Accounts</span>
                </div>
                <div class="category-card bg-[#1e293b] rounded-xl p-4 flex flex-col items-center cursor-pointer">
                    <div class="w-12 h-12 rounded-full bg-green-500/20 flex items-center justify-center mb-3">
                        <i class="ri-gamepad-line text-green-500 text-xl"></i>
                    </div>
                    <span class="text-sm text-center">Game Credits</span>
                </div> -->
            </div>
        </div>
        @endif
        <!-- Filter Tabs -->
        <!-- <div class="flex space-x-4 mb-6">
            <button
                class="px-4 py-2 rounded-full bg-[#1e293b] text-gray-400 hover:bg-gray-700 hover:text-white text-sm">Discounted</button>
            <button
                class="px-4 py-2 rounded-full bg-[#1e293b] text-gray-400 hover:bg-gray-700 hover:text-white text-sm">New</button>
            <button class="px-4 py-2 rounded-full bg-primary text-white text-sm">Popular</button>
            <button
                class="px-4 py-2 rounded-full bg-[#1e293b] text-gray-400 hover:bg-gray-700 hover:text-white text-sm">All</button>
        </div> -->
        <!-- Featured Accounts -->
         @if($homePage->featured_enabled)
        <div class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-white">{{$homePage->featured_title}}</h3>
                <button class="text-primary hover:text-blue-400 flex items-center space-x-1 text-sm flex-row-reverse">
                    <span>View All</span>
                    <i class="ri-arrow-left-s-line"></i>
                </button>
            </div>
            <div class="grid grid-cols-3 gap-6">
                @foreach($featuredProducts as $product)
                <!-- Game Card 1 -->
                <a href="{{ route('products.show', $product->share_slug ?: $product->slug) }}" class="game-card bg-[#1e293b] rounded-xl overflow-hidden block">
                    <div class="relative h-48">
                        <img src="{{asset('storage/'.$product->main_image)}}"
                            alt="Dark Warlord" class="w-full h-full object-cover object-top">
                        <div class="absolute top-3 right-3">
                            <span
                                class="epic-badge  px-3 py-1   rounded-full text-xs font-semibold text-white">
                                @if($product->is_featured)
                                            مميز
                                        @elseif($product->created_at > now()->subDays(7))
                                            جديد
                                        @elseif($product->has_discount)
                                            خصم {{ $product->discount_percentage }}%
                                        @endif
                                        
                                        @if($product->status == 'out-of-stock')
                                            نفذت الكمية
                                @endif
                            </span>
                        </div>
                        <div
                            class="absolute bottom-3 right-3 bg-black/60 px-2 py-1 rounded flex items-center space-x-1 flex-row-reverse">
                            <i class="ri-star-line text-xs text-gray-300"></i>
                            <span class="text-xs text-gray-300">{{$product->category->name}}</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                                <h4 class="text-lg font-semibold">{{$product->name}}</h4>
                            <div class="flex items-center space-x-1">
                                <i class="ri-time-line text-gray-400 text-sm"></i>
                                <span class="text-xs text-gray-400">{{$product->created_at->diffForHumans()}}</span>
                            </div>
                        </div>
                        <div class="flex space-x-4 mb-3">
                            <div class="text-xs text-gray-400">{{  Illuminate\Support\Str::limit($product->description, 30) }}</div>
                        </div>
                        <div class="flex justify-between items-center mb-3">
                            <div class="flex space-x-1">
                                <div class="w-6 h-6 rounded-full {{$product->category->bg_color ? 'bg-['.$product->category->bg_color.']/20' : 'bg-yellow-500/20'}} flex items-center justify-center">
                                    <i class="{{$product->category->icon}} {{$product->category->bg_color ? 'text-['.$product->category->bg_color.']' : 'text-yellow-500'}} text-xs"></i>
                                </div>
                                <!-- <div class="w-6 h-6 rounded-full bg-gray-700 flex items-center justify-center">
                                    <i class="{{$product->category->icon}} text-yellow-400 text-xs"></i>
                                </div>
                                <div class="w-6 h-6 rounded-full bg-gray-700 flex items-center justify-center">
                                    <i class="{{$product->category->icon}} text-yellow-400 text-xs"></i>
                                </div> -->
                            </div>
                            <div class="text-sm font-semibold bg-gray-800 px-3 py-1 rounded-full flex items-center">
                                <span class="text-gray-200 ml-1">{{$product->price}}</span>
                                <i class="ri-money-dollar-circle-line  text-green-400 text-sm"></i>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <span class="text-xs text-gray-400">{{$product->badge_text ?? 'No Badge'}}</span>
                            <div class="flex gap-2">
                                <button
                                    class="flex-1 bg-primary hover:bg-blue-600 text-white text-sm px-4 py-1.5 rounded-button flex items-center justify-center space-x-1 whitespace-nowrap"
                                    onclick="event.preventDefault(); event.stopPropagation(); window.location.href='{{ route('products.show', $product->share_slug ?: $product->slug) }}';">
                                    <i class="ri-shopping-bag-line text-xs"></i>
                                    <span>اشتر الآن</span>
                                </button>
                                <button
                                    class="flex-1 bg-green-500 hover:bg-green-600 text-white text-sm px-4 py-1.5 rounded-button flex items-center justify-center space-x-1 whitespace-nowrap"
                                    onclick="event.preventDefault(); event.stopPropagation(); addToCart({{ $product->id }});">
                                    <i class="ri-shopping-cart-2-line text-xs"></i>
                                    <span>أضف للسلة</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
                <!-- Game Card 2 -->
                <!-- <div class="game-card bg-[#1e293b] rounded-xl overflow-hidden">
                    <div class="relative h-48">
                        <img src="https://readdy.ai/api/search-image?query=futuristic%20soldier%20with%20blue%20glowing%20helmet%20and%20high-tech%20armor%2C%20sci-fi%20military%20character%2C%20high%20quality%2C%20detailed%2C%20gaming%20character%20concept%20art&width=400&height=250&seq=3&orientation=landscape"
                            alt="Neo Soldier" class="w-full h-full object-cover object-top">
                        <div class="absolute top-3 right-3">
                            <span
                                class="rare-badge badge px-3 py-1 rounded-full text-xs font-semibold text-white">RARE</span>
                        </div>
                        <div
                            class="absolute bottom-3 right-3 bg-black/60 px-2 py-1 rounded flex items-center space-x-1 flex-row-reverse">
                            <i class="ri-eye-line text-xs text-gray-300"></i>
                            <span class="text-xs text-gray-300">5.3M</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="text-lg font-semibold">Neo Soldier</h4>
                            <div class="flex items-center space-x-1">
                                <i class="ri-time-line text-gray-400 text-sm"></i>
                                <span class="text-xs text-gray-400">3 months ago</span>
                            </div>
                        </div>
                        <div class="flex space-x-4 mb-3">
                            <div class="text-xs text-gray-400">Level 72 • Premium Weapons</div>
                        </div>
                        <div class="flex justify-between items-center mb-3">
                            <div class="flex space-x-1">
                                <div class="w-6 h-6 rounded-full bg-gray-700 flex items-center justify-center">
                                    <i class="ri-sword-line text-blue-400 text-xs"></i>
                                </div>
                                <div class="w-6 h-6 rounded-full bg-gray-700 flex items-center justify-center">
                                    <i class="ri-shield-star-line text-blue-400 text-xs"></i>
                                </div>
                                <div class="w-6 h-6 rounded-full bg-gray-700 flex items-center justify-center">
                                    <i class="ri-rocket-line text-blue-400 text-xs"></i>
                                </div>
                            </div>
                            <div class="text-sm font-semibold bg-gray-800 px-3 py-1 rounded-full flex items-center">
                                <span class="text-yellow-400 mr-1">1,850</span>
                                <i class="ri-coin-line text-yellow-400 text-xs"></i>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-400">Premium Account</span>
                            <button
                                class="bg-green-500 hover:bg-green-600 text-white text-sm px-4 py-1.5 rounded-button flex items-center space-x-1 whitespace-nowrap">
                                <i class="ri-shopping-cart-2-line text-xs"></i>
                                <span>Add to Cart</span>
                            </button>
                        </div>
                    </div>
                </div> -->
                <!-- Game Card 3 -->
                <!-- <div class="game-card bg-[#1e293b] rounded-xl overflow-hidden">
                    <div class="relative h-48">
                        <img src="https://readdy.ai/api/search-image?query=futuristic%20cyber%20warrior%20with%20red%20glowing%20helmet%20visor%2C%20high-tech%20armor%2C%20menacing%20pose%2C%20high%20quality%2C%20detailed%2C%20gaming%20character%20concept%20art&width=400&height=250&seq=4&orientation=landscape"
                            alt="Cyber Warrior" class="w-full h-full object-cover object-top">
                        <div class="absolute top-3 right-3">
                            <span
                                class="legendary-badge badge px-3 py-1 rounded-full text-xs font-semibold text-white">LEGENDARY</span>
                        </div>
                        <div
                            class="absolute bottom-3 right-3 bg-black/60 px-2 py-1 rounded flex items-center space-x-1 flex-row-reverse">
                            <i class="ri-eye-line text-xs text-gray-300"></i>
                            <span class="text-xs text-gray-300">8.1M</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="text-lg font-semibold">Cyber Warrior</h4>
                            <div class="flex items-center space-x-1">
                                <i class="ri-time-line text-gray-400 text-sm"></i>
                                <span class="text-xs text-gray-400">3 months ago</span>
                            </div>
                        </div>
                        <div class="flex space-x-4 mb-3">
                            <div class="text-xs text-gray-400">Level 65 • Full Equipment</div>
                        </div>
                        <div class="flex justify-between items-center mb-3">
                            <div class="flex space-x-1">
                                <div class="w-6 h-6 rounded-full bg-gray-700 flex items-center justify-center">
                                    <i class="ri-sword-line text-green-400 text-xs"></i>
                                </div>
                                <div class="w-6 h-6 rounded-full bg-gray-700 flex items-center justify-center">
                                    <i class="ri-shield-star-line text-green-400 text-xs"></i>
                                </div>
                                <div class="w-6 h-6 rounded-full bg-gray-700 flex items-center justify-center">
                                    <i class="ri-cpu-line text-green-400 text-xs"></i>
                                </div>
                            </div>
                            <div class="text-sm font-semibold bg-gray-800 px-3 py-1 rounded-full flex items-center">
                                <span class="text-yellow-400 mr-1">2,450</span>
                                <i class="ri-coin-line text-yellow-400 text-xs"></i>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-400">Premium Account</span>
                            <button
                                class="bg-green-500 hover:bg-green-600 text-white text-sm px-4 py-1.5 rounded-button flex items-center space-x-1 whitespace-nowrap">
                                <i class="ri-shopping-cart-2-line text-xs"></i>
                                <span>Add to Cart</span>
                            </button>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
        @endif

        @if($homePage->brand_enabled)
        <!-- Trending Games -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-white">{{$homePage->brand_title}}</h3>
                <button class="text-primary hover:text-blue-400 flex items-center space-x-1 text-sm flex-row-reverse">
                    <span>عرض الكل</span>
                    <i class="ri-arrow-left-s-line"></i>
                </button>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($brandProducts as $product)
                <div class="bg-[#1e293b] rounded-xl p-3 flex flex-col items-center cursor-pointer hover:bg-gray-700 transition-all">
                    <a href="{{ route('products.show', $product->share_slug ?: $product->slug) }}" class="w-full">
                        <div class="w-full h-32 rounded-lg overflow-hidden mb-2">
                            <img src="{{asset('storage/'.$product->main_image)}}" alt="{{$product->name}}" class="w-full h-full object-cover">
                        </div>
                        <span class="text-sm text-center block">{{$product->name}}</span>
                        <div class="rating-stars mt-1 flex justify-center">
                            <i class="ri-star-fill filled text-xs text-yellow-400"></i>
                            <i class="ri-star-fill filled text-xs text-yellow-400"></i>
                            <i class="ri-star-fill filled text-xs text-yellow-400"></i>
                            <i class="ri-star-fill filled text-xs text-yellow-400"></i>
                            <i class="ri-star-half-fill filled text-xs text-yellow-400"></i>
                        </div>
                        <div class="text-xs font-semibold bg-gray-800 px-2 py-1 rounded-full flex items-center justify-center mt-2">
                            <span class="text-yellow-400 mr-1">{{$product->price}}</span>
                            <i class="ri-coin-line text-yellow-400 text-xs"></i>
                        </div>
                    </a>
                    <div class="flex gap-2 w-full mt-3">
                        <button
                            class="flex-1 bg-primary hover:bg-blue-600 text-white text-xs px-3 py-1.5 rounded-button flex items-center justify-center space-x-1 whitespace-nowrap"
                            onclick="window.location.href='{{ route('products.show', $product->share_slug ?: $product->slug) }}';">
                            <i class="ri-shopping-bag-line text-xs"></i>
                            <span>اشتر</span>
                        </button>
                        <button
                            class="flex-1 bg-green-500 hover:bg-green-600 text-white text-xs px-3 py-1.5 rounded-button flex items-center justify-center space-x-1 whitespace-nowrap"
                            onclick="event.stopPropagation(); addToCart({{ $product->id }});">
                            <i class="ri-shopping-cart-2-line text-xs"></i>
                            <span>سلة</span>
                        </button>
                    </div>
                </div>
               
                @endforeach
                <!-- <div class="bg-[#1e293b] rounded-xl p-3 flex flex-col items-center cursor-pointer hover:bg-gray-700 transition-all">
                    <div class="w-full h-32 rounded-lg overflow-hidden mb-2">
                        <img src="https://readdy.ai/api/search-image?query=valorant%2520game%2520screenshot%2520with%2520characters%2520in%2520combat%252C%2520high%2520quality%252C%2520detailed&amp;width=200&amp;height=150&amp;seq=21&amp;orientation=landscape" alt="Valorant" class="w-full h-full object-cover">
                    </div>
                    <span class="text-sm text-center">فالورانت</span>
                    <div class="rating-stars mt-1">
                        <i class="ri-star-fill filled text-xs"></i>
                        <i class="ri-star-fill filled text-xs"></i>
                        <i class="ri-star-fill filled text-xs"></i>
                        <i class="ri-star-fill filled text-xs"></i>
                        <i class="ri-star-line text-xs"></i>
                    </div>
                    <div class="text-xs font-semibold bg-gray-800 px-2 py-1 rounded-full flex items-center mt-2">
                        <span class="text-yellow-400 mr-1">420</span>
                        <i class="ri-coin-line text-yellow-400 text-xs"></i>
                    </div>
                </div>
                <div class="bg-[#1e293b] rounded-xl p-3 flex flex-col items-center cursor-pointer hover:bg-gray-700 transition-all">
                    <div class="w-full h-32 rounded-lg overflow-hidden mb-2">
                        <img src="https://readdy.ai/api/search-image?query=league%2520of%2520legends%2520game%2520screenshot%2520with%2520champions%2520in%2520battle%252C%2520high%2520quality%252C%2520detailed&amp;width=200&amp;height=150&amp;seq=22&amp;orientation=landscape" alt="League of Legends" class="w-full h-full object-cover">
                    </div>
                    <span class="text-sm text-center">ليج أوف ليجندز</span>
                    <div class="rating-stars mt-1">
                        <i class="ri-star-fill filled text-xs"></i>
                        <i class="ri-star-fill filled text-xs"></i>
                        <i class="ri-star-fill filled text-xs"></i>
                        <i class="ri-star-fill filled text-xs"></i>
                        <i class="ri-star-fill filled text-xs"></i>
                    </div>
                    <div class="text-xs font-semibold bg-gray-800 px-2 py-1 rounded-full flex items-center mt-2">
                        <span class="text-yellow-400 mr-1">280</span>
                        <i class="ri-coin-line text-yellow-400 text-xs"></i>
                    </div>
                </div>
                <div class="bg-[#1e293b] rounded-xl p-3 flex flex-col items-center cursor-pointer hover:bg-gray-700 transition-all">
                    <div class="w-full h-32 rounded-lg overflow-hidden mb-2">
                        <img src="https://readdy.ai/api/search-image?query=genshin%2520impact%2520game%2520screenshot%2520with%2520beautiful%2520landscape%2520and%2520characters%252C%2520high%2520quality%252C%2520detailed&amp;width=200&amp;height=150&amp;seq=23&amp;orientation=landscape" alt="Genshin Impact" class="w-full h-full object-cover">
                    </div>
                    <span class="text-sm text-center">جينشن إمباكت</span>
                    <div class="rating-stars mt-1">
                        <i class="ri-star-fill filled text-xs"></i>
                        <i class="ri-star-fill filled text-xs"></i>
                        <i class="ri-star-fill filled text-xs"></i>
                        <i class="ri-star-fill filled text-xs"></i>
                        <i class="ri-star-half-fill filled text-xs"></i>
                    </div>
                    <div class="text-xs font-semibold bg-gray-800 px-2 py-1 rounded-full flex items-center mt-2">
                        <span class="text-yellow-400 mr-1">390</span>
                        <i class="ri-coin-line text-yellow-400 text-xs"></i>
                    </div>
                </div>
                <div class="bg-[#1e293b] rounded-xl p-3 flex flex-col items-center cursor-pointer hover:bg-gray-700 transition-all">
                    <div class="w-full h-32 rounded-lg overflow-hidden mb-2">
                        <img src="https://readdy.ai/api/search-image?query=call%2520of%2520duty%2520warzone%2520game%2520screenshot%2520with%2520soldiers%2520in%2520combat%252C%2520high%2520quality%252C%2520detailed&amp;width=200&amp;height=150&amp;seq=24&amp;orientation=landscape" alt="Call of Duty" class="w-full h-full object-cover">
                    </div>
                    <span class="text-sm text-center">كول أوف ديوتي</span>
                    <div class="rating-stars mt-1">
                        <i class="ri-star-fill filled text-xs"></i>
                        <i class="ri-star-fill filled text-xs"></i>
                        <i class="ri-star-fill filled text-xs"></i>
                        <i class="ri-star-fill filled text-xs"></i>
                        <i class="ri-star-line text-xs"></i>
                    </div>
                    <div class="text-xs font-semibold bg-gray-800 px-2 py-1 rounded-full flex items-center mt-2">
                        <span class="text-yellow-400 mr-1">520</span>
                        <i class="ri-coin-line text-yellow-400 text-xs"></i>
                    </div>
                </div>
                <div class="bg-[#1e293b] rounded-xl p-3 flex flex-col items-center cursor-pointer hover:bg-gray-700 transition-all">
                    <div class="w-full h-32 rounded-lg overflow-hidden mb-2">
                        <img src="https://readdy.ai/api/search-image?query=minecraft%2520game%2520screenshot%2520with%2520beautiful%2520landscape%2520and%2520buildings%252C%2520high%2520quality%252C%2520detailed&amp;width=200&amp;height=150&amp;seq=25&amp;orientation=landscape" alt="Minecraft" class="w-full h-full object-cover">
                    </div>
                    <span class="text-sm text-center">ماينكرافت</span>
                    <div class="rating-stars mt-1">
                        <i class="ri-star-fill filled text-xs"></i>
                        <i class="ri-star-fill filled text-xs"></i>
                        <i class="ri-star-fill filled text-xs"></i>
                        <i class="ri-star-fill filled text-xs"></i>
                        <i class="ri-star-fill filled text-xs"></i>
                    </div>
                    <div class="text-xs font-semibold bg-gray-800 px-2 py-1 rounded-full flex items-center mt-2">
                        <span class="text-yellow-400 mr-1">300</span>
                        <i class="ri-coin-line text-yellow-400 text-xs"></i>
                    </div>
                </div> -->
            </div>
        </div>
        @endif

        <!-- Services Section -->
        @if($homePage->services_enabled)
        <div class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-white">{{$homePage->services_title ?? 'خدماتنا'}}</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @if($homePage->services_data && is_array($homePage->services_data))
                    @foreach($homePage->services_data as $service)
                    <div class="bg-[#1e293b] rounded-xl p-6 text-center hover:bg-[#2d3e57] transition-all cursor-pointer">
                        <div class="w-16 h-16 rounded-full bg-primary/20 flex items-center justify-center mx-auto mb-4">
                            <i class="{{ $service['icon'] ?? 'ri-service-line' }} text-primary text-3xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-white mb-2">{{ $service['title'] ?? '' }}</h4>
                        <p class="text-gray-400 text-sm">{{ $service['description'] ?? '' }}</p>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
        @endif

 <!-- Testimonials Section -->
 @if($homePage->reviews_enabled)
 <div class="mt-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold">آراء العملاء</h2>
            <a href="#" class="text-primary text-sm hover:underline">عرض الكل</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Testimonial 1 -->
            @forelse($reviews as $review)
            <div class="bg-[#111827] rounded-xl p-6 border border-gray-800 hover:border-primary transition-colors">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 rounded-full bg-[#1a2234] flex items-center justify-center mr-3">
                        @if($review->avatar)
                            <img src="{{ asset('storage/' . $review->avatar) }}" alt="{{ $review->name }}" class="w-full h-full rounded-full object-cover">
                        @else
                            <i class="ri-user-3-fill text-primary ri-xl"></i>
                        @endif
                    </div>
                    <div>
                        <h3 class="font-bold">{{$review->name}}</h3>
                        <div class="rating-stars flex mt-1">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <i class="ri-star-fill active text-yellow-400"></i>
                                @else
                                    <i class="ri-star-line inactive text-gray-400"></i>
                                @endif
                            @endfor
                        </div>
                    </div>
                </div>
                <p class="text-gray-300 mb-3">{{ $review->comment ?? $review->review ?? 'تجربة رائعة مع هذا المنتج!' }}</p>
                <div class="flex items-center justify-between">
                    <span class="text-gray-400 text-sm">{{ $review->created_at->format('d M Y') }}</span>
                    <div class="flex items-center">
                        <span class="text-gray-400 text-sm ml-1">مفيد؟</span>
                        <button class="w-7 h-7 flex items-center justify-center text-gray-400 hover:text-primary">
                            <i class="ri-thumb-up-line"></i>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center p-8">
                <i class="ri-chat-quote-line text-5xl text-gray-400 mb-4"></i>
                <p class="text-gray-400">لا توجد آراء متاحة حالياً.</p>
            </div>
            @endforelse



              <!-- Testimonial 2 -->
              <!-- <div class="bg-[#111827] rounded-xl p-6 border border-gray-800 hover:border-primary transition-colors">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 rounded-full bg-[#1a2234] flex items-center justify-center mr-3">
                        <i class="ri-user-3-fill text-blue-500 ri-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold">سارة العلي</h3>
                        <div class="rating-stars flex mt-1">
                            <i class="ri-star-fill active"></i>
                            <i class="ri-star-fill active"></i>
                            <i class="ri-star-fill active"></i>
                            <i class="ri-star-fill active"></i>
                            <i class="ri-star-line inactive"></i>
                        </div>
                    </div>
                </div>
                <p class="text-gray-300 mb-3">تجربة رائعة بشكل عام، وضع Ultimate Team أصبح أكثر متعة هذا العام. الوصول
                    المبكر كان ميزة رائعة، لكن لا تزال هناك بعض المشكلات الصغيرة في الخوادم أحيانًا.</p>
                <div class="flex items-center justify-between">
                    <span class="text-gray-400 text-sm">10 يونيو 2025</span>
                    <div class="flex items-center">
                        <span class="text-gray-400 text-sm ml-1">مفيد؟</span>
                        <button class="w-7 h-7 flex items-center justify-center text-gray-400 hover:text-primary">
                            <i class="ri-thumb-up-line"></i>
                        </button>
                    </div>
                </div>
            </div> -->
            <!-- Testimonial 3 -->
            <!-- <div class="bg-[#111827] rounded-xl p-6 border border-gray-800 hover:border-primary transition-colors">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 rounded-full bg-[#1a2234] flex items-center justify-center mr-3">
                        <i class="ri-user-3-fill text-purple-500 ri-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold">محمد الخالدي</h3>
                        <div class="rating-stars flex mt-1">
                            <i class="ri-star-fill active"></i>
                            <i class="ri-star-fill active"></i>
                            <i class="ri-star-fill active"></i>
                            <i class="ri-star-fill active"></i>
                            <i class="ri-star-half-fill active"></i>
                        </div>
                    </div>
                </div>
                <p class="text-gray-300 mb-3">وضع المهنة تحسن كثيرًا هذا العام، والتحكم في اللاعبين أصبح أكثر واقعية.
                    أحب المحتوى الإضافي في النسخة Ultimate، خاصة نقاط FIFA Points التي ساعدتني في بناء فريق قوي من
                    البداية.</p>
                <div class="flex items-center justify-between">
                    <span class="text-gray-400 text-sm">8 يونيو 2025</span>
                    <div class="flex items-center">
                        <span class="text-gray-400 text-sm ml-1">مفيد؟</span>
                        <button class="w-7 h-7 flex items-center justify-center text-gray-400 hover:text-primary">
                            <i class="ri-thumb-up-line"></i>
                        </button>
                    </div>
                </div>
            </div> -->
        </div>
</div>
@endif
     
    </main>

    @if($homePage->footer_enabled)

    @include('themes.greenGame.partials.footer')
    
    @endif

    <script id="categoryInteraction">
    document.addEventListener('DOMContentLoaded', function() {
        const categoryCards = document.querySelectorAll('.category-card');
        categoryCards.forEach(card => {
            card.addEventListener('click', function() {
                // Reset all cards
                categoryCards.forEach(c => {
                    c.classList.remove('bg-gray-700');
                    c.classList.add('bg-[#1e293b]');
                });
                // Highlight selected card
                this.classList.remove('bg-[#1e293b]');
                this.classList.add('bg-gray-700');
            });
        });
    });
    </script>
    <script id="filterTabsInteraction">
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.flex.space-x-4.mb-6 button');
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Reset all buttons
                filterButtons.forEach(btn => {
                    btn.classList.remove('bg-primary', 'text-white');
                    btn.classList.add('bg-[#1e293b]', 'text-gray-400');
                });
                // Highlight selected button
                this.classList.remove('bg-[#1e293b]', 'text-gray-400');
                this.classList.add('bg-primary', 'text-white');
            });
        });
    });
    </script>
    <script id="cartInteraction">
    // Add to cart functionality
    function addToCart(productId) {
        // Add visual feedback immediately
        const button = event.target.closest('button');
        let originalContent = '';
        
        if (button) {
            button.disabled = true;
            originalContent = button.innerHTML;
            button.innerHTML = '<i class="ri-loader-4-line animate-spin"></i>';
        }

        // Function to reset button
        const resetButton = () => {
            if (button) {
                button.disabled = false;
                button.innerHTML = originalContent;
            }
        };

        // Fallback timeout - much shorter now (1 second instead of 3)
        const timeoutId = setTimeout(resetButton, 1000);

        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                product_type: 'product',
                product_id: productId,
                quantity: 1
            })
        })
        .then(response => {
            // Clear the timeout since we got a response
            clearTimeout(timeoutId);
            resetButton();
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Show success message using CartManager
                window.CartManager.showNotification('تم إضافة المنتج إلى السلة بنجاح!', 'success');
                
                // Update cart count using CartManager
                if (data.cart_count !== undefined) {
                    window.CartManager.updateCartCount(data.cart_count);
                } else {
                    // Fallback: sync from server using CartManager
                    window.CartManager.syncCartCount();
                }
            } else {
                window.CartManager.showNotification(data.message || 'حدث خطأ في إضافة المنتج', 'error');
            }
        })
        .catch(error => {
            // Clear timeout and reset button on error too
            clearTimeout(timeoutId);
            resetButton();
            
            console.error('Error:', error);
            window.CartManager.showNotification('حدث خطأ في إضافة المنتج إلى السلة', 'error');
            
            // Try to sync cart count even on error
            setTimeout(() => window.CartManager.syncCartCount(), 1000);
        });
    }
    </script>
</body>

</html>