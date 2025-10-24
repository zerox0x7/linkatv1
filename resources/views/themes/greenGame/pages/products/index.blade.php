<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>منتجاتنا | متجر الألعاب والإلكترونيات</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#00c853',
                    secondary: '#2196f3'
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
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
    :where([class^="ri-"])::before {
        content: "\f3c2";
    }

    body {
        font-family: 'Cairo', sans-serif;
        background-color: #0f172a;
        color: #e2e8f0;
    }

    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .product-card {
        animation: fadeInUp 0.6s ease forwards;
        animation-fill-mode: both;
        text-decoration: none;
        color: inherit;
    }

    .product-card:nth-child(1) {
        animation-delay: 0.1s;
    }

    .product-card:nth-child(2) {
        animation-delay: 0.2s;
    }

    .product-card:nth-child(3) {
        animation-delay: 0.3s;
    }

    .search-input:focus {
        outline: none;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 200, 83, 0.1);
        text-decoration: none;
        color: inherit;
    }

    .badge {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
    }

    .product-image {
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
    }

    /* Product link styling */
    .product-card:hover {
        text-decoration: none;
        color: inherit;
    }

    .flash-sale-card {
        text-decoration: none;
        color: inherit;
    }

    .flash-sale-card:hover {
        text-decoration: none;
        color: inherit;
    }
    </style>
</head>

<body class="min-h-screen">
    <!-- Header -->
    @include('themes.greenGame.partials.top-header')

    @include('themes.greenGame.partials.header')
    @if($productsPage->page_header_enabled)
        <div class="relative  overflow-hidden mb-0 h-72">
            <div class="absolute inset-0 bg-gradient-to-l from-[#0f172a]/90 to-transparent z-10"></div>
            <img src="{{asset('storage/'. $productsPage->header_image )}}"
                alt="Special Rewards" class="w-full h-full object-cover object-top">
            <div class="absolute top-0 left-0 w-full h-full flex flex-col justify-center z-20 px-8">
                <!-- <div class="text-sm text-green-400 font-semibold mb-1">{{$homePage->hero_button1_text}}</div> -->
                <h2 class="text-3xl font-bold text-white mb-2">{{$productsPage->page_title}}</h2>
                <p class="text-gray-300 max-w-md">{{$productsPage->page_subtitle}}</p>
                <!-- <a
                href="{{$homePage->hero_button1_link}}"
                    class="mt-4 bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-button flex items-center space-x-2 w-fit whitespace-nowrap">
                    <i class="ri-gift-2-line"></i>
                    <span>{{$homePage->hero_button1_text}}</span>
                 </a> -->
            </div>
        </div>
        @endif
    
    <!-- Flash Sale Timer Section -->
     @if($productsPage->discount_timer_enabled)
    <section class="px-6 py-12 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-primary/5 to-secondary/5 backdrop-blur-3xl"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center animate-pulse">
                        <i class="ri-flashlight-line text-primary ri-2x"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold mb-1">عروض فلاش</h2>
                        <p class="text-gray-400">احصل على خصم يصل إلى 50٪ على المنتجات المختارة</p>
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    <div class="timer-box">
                        <div class="text-4xl font-bold" id="days">02</div>
                        <div class="text-sm text-gray-400">يوم</div>
                    </div>
                    <div class="text-2xl text-gray-600">:</div>
                    <div class="timer-box">
                        <div class="text-4xl font-bold" id="hours">18</div>
                        <div class="text-sm text-gray-400">ساعة</div>
                    </div>
                    <div class="text-2xl text-gray-600">:</div>
                    <div class="timer-box">
                        <div class="text-4xl font-bold" id="minutes">45</div>
                        <div class="text-sm text-gray-400">دقيقة</div>
                    </div>
                    <div class="text-2xl text-gray-600">:</div>
                    <div class="timer-box">
                        <div class="text-4xl font-bold" id="seconds">30</div>
                        <div class="text-sm text-gray-400">ثانية</div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-4 gap-6">
                @forelse($flashSaleProducts as $product)
                <a href="{{ route('products.show', $product->share_slug ?: $product->slug) }}" class="flash-sale-card block">
                    <div class="relative h-48 overflow-hidden rounded-lg">
                        <img src="{{ $product->main_image_url ?: 'https://readdy.ai/api/search-image?query=gaming%20product%20with%20RGB%20lighting%20on%20dark%20background%20with%20neon%20glow%20effects%2C%20professional%20studio%20photography&width=400&height=300&seq=' . $loop->iteration . '&orientation=landscape' }}"
                            alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @if($product->discount_percentage > 0)
                        <div class="absolute top-3 right-3 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                            -{{ $product->discount_percentage }}%</div>
                        @endif
                    </div>
                    <div class="mt-4">
                        <h3 class="font-bold text-lg mb-2">{{ \Illuminate\Support\Str::limit($product->name, 30) }}</h3>
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-xl font-bold text-primary">{{ number_format($product->price, 0) }} ر.س</span>
                            @if($product->old_price)
                            <span class="text-gray-400 line-through">{{ number_format($product->old_price, 0) }} ر.س</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="h-2 bg-[#2d3748] rounded-full flex-1">
                                @php
                                    $stockPercentage = $product->stock > 0 ? min(($product->stock / 10) * 100, 100) : 0;
                                @endphp
                                <div class="h-full bg-primary rounded-full" style="width: {{ $stockPercentage }}%"></div>
                            </div>
                            <span class="text-sm text-gray-400">باقي {{ $product->stock }} قطع</span>
                        </div>
                    </div>
                </a>
                @empty
                <!-- Fallback to static content if no flash sale products -->
                <div class="flash-sale-card">
                    <div class="relative h-48 overflow-hidden rounded-lg">
                        <img src="https://readdy.ai/api/search-image?query=gaming%20headset%20with%20RGB%20lighting%20on%20dark%20background%20with%20neon%20glow%20effects%2C%20professional%20studio%20photography&width=400&height=300&seq=14&orientation=landscape"
                            alt="سماعة ألعاب" class="w-full h-full object-cover">
                        <div
                            class="absolute top-3 right-3 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                            -50%</div>
                    </div>
                    <div class="mt-4">
                        <h3 class="font-bold text-lg mb-2">سماعة ألعاب احترافية</h3>
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-xl font-bold text-primary">450 ر.س</span>
                            <span class="text-gray-400 line-through">900 ر.س</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="h-2 bg-[#2d3748] rounded-full flex-1">
                                <div class="h-full w-[70%] bg-primary rounded-full"></div>
                            </div>
                            <span class="text-sm text-gray-400">باقي 7 قطع</span>
                        </div>
                    </div>
                </div>
                @endforelse
                
                @if($flashSaleProducts->count() < 4)
                    @for($i = $flashSaleProducts->count(); $i < 4; $i++)
                    <div class="flash-sale-card opacity-50">
                        <div class="relative h-48 overflow-hidden rounded-lg bg-gray-700">
                            <div class="w-full h-full flex items-center justify-center text-gray-500">
                                <i class="ri-image-line text-4xl"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h3 class="font-bold text-lg mb-2 text-gray-500">منتج قريباً</h3>
                            <div class="flex items-center gap-2 mb-3">
                                <span class="text-xl font-bold text-gray-500">--- ر.س</span>
                            </div>
                        </div>
                    </div>
                    @endfor
                @endif
            </div>
        </div>
        <style>
        .timer-box {
            background: linear-gradient(145deg, #1e293b, #111827);
            padding: 1rem;
            border-radius: 12px;
            text-align: center;
            min-width: 80px;
            position: relative;
            overflow: hidden;
        }

        .timer-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        }

        .flash-sale-card {
            background: linear-gradient(145deg, #1e293b, #111827);
            border-radius: 16px;
            padding: 1rem;
            transition: all 0.3s ease;
        }

        .flash-sale-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 200, 83, 0.1);
        }
        </style>
        <script id="countdown-timer">
        document.addEventListener('DOMContentLoaded', function() {
            function updateTimer() {
                const now = new Date();
                const endDate = new Date('2025-06-17T23:59:59');
                const diff = endDate - now;
                if (diff <= 0) {
                    document.getElementById('days').textContent = '00';
                    document.getElementById('hours').textContent = '00';
                    document.getElementById('minutes').textContent = '00';
                    document.getElementById('seconds').textContent = '00';
                    return;
                }
                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);
                document.getElementById('days').textContent = days.toString().padStart(2, '0');
                document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
                document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
                document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
            }
            updateTimer();
            setInterval(updateTimer, 1000);
            const flashSaleCards = document.querySelectorAll('.flash-sale-card');
            flashSaleCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
        </script>
    </section>
    @endif
    <!-- Featured Products Section -->
    
    <!-- Popular Products Grid -->
    <section class="px-6 py-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold">المنتجات الشائعة</h2>
            <div class="flex gap-2">
                <button
                    data-filter="newest"
                    class="filter-btn {{ $popularFilter == 'newest' ? 'bg-primary' : 'bg-[#1e293b]' }} text-white px-4 py-2 rounded-button flex items-center gap-2 hover:bg-[#2d3748] transition duration-300 !rounded-button whitespace-nowrap">
                    <span>الأحدث</span>
                </button>
                <button
                    data-filter="best_selling"
                    class="filter-btn {{ $popularFilter == 'best_selling' ? 'bg-primary' : 'bg-[#1e293b]' }} text-white px-4 py-2 rounded-button flex items-center gap-2 hover:bg-primary/90 transition duration-300 !rounded-button whitespace-nowrap">
                    <span>الأكثر مبيعاً</span>
                </button>
                <button
                    data-filter="price_asc"
                    class="filter-btn {{ $popularFilter == 'price_asc' ? 'bg-primary' : 'bg-[#1e293b]' }} text-white px-4 py-2 rounded-button flex items-center gap-2 hover:bg-[#2d3748] transition duration-300 !rounded-button whitespace-nowrap">
                    <span>الأقل سعراً</span>
                </button>
            </div>
        </div>
        <div id="popular-products-grid" class="grid grid-cols-4 gap-6">
            @forelse($popularProducts as $product)
            <!-- Product {{ $loop->iteration }} -->
            <a href="{{ route('products.show', $product->share_slug ?: $product->slug) }}" class="bg-[#1e293b] rounded-lg overflow-hidden product-card transition duration-300 block">
                <div class="relative">
                    <img src="{{ $product->main_image_url ?: 'https://readdy.ai/api/search-image?query=gaming%20product%20on%20dark%20background%2C%20high-quality%20product%20photography%2C%20detailed%20texture%2C%20studio%20lighting%2C%20dark%20theme%20with%20blue%20accents&width=300&height=200&seq=' . $loop->iteration . '&orientation=landscape' }}"
                        alt="{{ $product->name }}" class="w-full h-40 object-cover product-image">
                    @if($product->is_featured)
                        <span class="badge bg-blue-500 text-white">الأكثر مبيعاً</span>
                    @elseif($product->discount_percentage > 0)
                        <span class="badge bg-red-500 text-white">خصم {{ $product->discount_percentage }}%</span>
                    @elseif($product->stock > 0)
                        <span class="badge bg-green-500 text-white">متوفر</span>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="font-bold mb-2">{{ \Illuminate\Support\Str::limit($product->name, 40) }}</h3>
                    <div class="flex items-center gap-1 mb-3">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($product->rating ?? 0))
                                <i class="ri-star-fill text-yellow-400"></i>
                            @elseif($i - 0.5 <= ($product->rating ?? 0))
                                <i class="ri-star-half-fill text-yellow-400"></i>
                            @else
                                <i class="ri-star-line text-yellow-400"></i>
                            @endif
                        @endfor
                        <span class="text-sm text-gray-400">({{ $product->reviews_count ?? 0 }})</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="font-bold">{{ number_format($product->price, 0) }} ر.س</span>
                            @if($product->old_price)
                                <span class="text-gray-400 line-through text-sm mr-2">{{ number_format($product->old_price, 0) }} ر.س</span>
                            @endif
                        </div>
                        <button
                            class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center text-primary hover:bg-primary/20 transition duration-300"
                            onclick="event.preventDefault(); event.stopPropagation(); addToCart({{ $product->id }})">
                            <i class="ri-shopping-cart-line"></i>
                        </button>
                    </div>
                </div>
            </a>
            @empty
            <!-- Fallback message if no products -->
            <div class="col-span-4 text-center py-12">
                <i class="ri-shopping-bag-line text-6xl text-gray-500 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-400 mb-2">لا توجد منتجات متاحة حالياً</h3>
                <p class="text-gray-500">سيتم إضافة منتجات جديدة قريباً</p>
            </div>
            @endforelse
        </div>
    </section>
    <!-- Newsletter Section -->
    <!-- <section class="px-6 py-10 my-6">
        <div class="bg-gradient-to-r from-[#1e293b] to-[#0f172a] rounded-lg p-10 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-1/3 h-full opacity-10">
                <div class="w-full h-full"
                    style="background-image: url('https://readdy.ai/api/search-image?query=abstract%20gaming%20pattern%20with%20controllers%2C%20headsets%20and%20gaming%20symbols%2C%20blue%20neon%20glow%2C%20digital%20art%20style&width=500&height=500&seq=13&orientation=squarish'); background-size: cover; background-position: center;">
                </div>
            </div>
            <div class="relative z-10 flex flex-col items-center text-center max-w-2xl mx-auto">
                <h2 class="text-3xl font-bold mb-4">اشترك في نشرتنا الإخبارية</h2>
                <p class="text-gray-300 mb-6">احصل على آخر العروض والتحديثات حول أحدث المنتجات والألعاب مباشرة إلى بريدك
                    الإلكتروني</p>
                <div class="flex w-full max-w-md">
                    <input type="email" placeholder="أدخل بريدك الإلكتروني"
                        class="flex-1 bg-[#2d3748] text-white border-none rounded-r-button py-3 px-4">
                    <button
                        class="bg-primary text-white px-6 py-3 rounded-l-button hover:bg-primary/90 transition duration-300 !rounded-button whitespace-nowrap">
                        اشترك الآن
                    </button>
                </div>
            </div>
        </div>
    </section> -->
    <!-- Footer -->

    @include('themes.greenGame.partials.footer')
    <script id="search-functionality">
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('.search-input');
        searchInput.addEventListener('focus', function() {
            this.classList.add('ring-2', 'ring-primary', 'ring-opacity-50');
        });
        searchInput.addEventListener('blur', function() {
            this.classList.remove('ring-2', 'ring-primary', 'ring-opacity-50');
        });
    });
    </script>
 
    <script id="filter-functionality">
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const productsGrid = document.getElementById('popular-products-grid');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter');
                
                // Update active button
                filterButtons.forEach(btn => {
                    btn.classList.remove('bg-primary');
                    btn.classList.add('bg-[#1e293b]');
                });
                this.classList.remove('bg-[#1e293b]');
                this.classList.add('bg-primary');
                
                // Show loading state
                productsGrid.innerHTML = `
                    <div class="col-span-4 text-center py-12">
                        <i class="ri-loader-4-line text-6xl text-primary animate-spin mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-400">جاري تحميل المنتجات...</h3>
                    </div>
                `;
                
                // Make AJAX request
                fetch('/products/filter-popular', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        filter: filter
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        renderProducts(data.products);
                    } else {
                        showError('حدث خطأ في تحميل المنتجات');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('حدث خطأ في الاتصال بالخادم');
                });
            });
        });
        
        function renderProducts(products) {
            if (products.length === 0) {
                productsGrid.innerHTML = `
                    <div class="col-span-4 text-center py-12">
                        <i class="ri-shopping-bag-line text-6xl text-gray-500 mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-400 mb-2">لا توجد منتجات متاحة</h3>
                        <p class="text-gray-500">لا توجد منتجات تطابق الفلتر المحدد</p>
                    </div>
                `;
                return;
            }
            
            let productsHTML = '';
            products.forEach((product, index) => {
                const imageUrl = product.main_image_url || `https://readdy.ai/api/search-image?query=gaming%20product%20on%20dark%20background%2C%20high-quality%20product%20photography%2C%20detailed%20texture%2C%20studio%20lighting%2C%20dark%20theme%20with%20blue%20accents&width=300&height=200&seq=${index + 1}&orientation=landscape`;
                
                // Generate stars
                let starsHTML = '';
                for (let i = 1; i <= 5; i++) {
                    if (i <= Math.floor(product.rating)) {
                        starsHTML += '<i class="ri-star-fill text-yellow-400"></i>';
                    } else if (i - 0.5 <= product.rating) {
                        starsHTML += '<i class="ri-star-half-fill text-yellow-400"></i>';
                    } else {
                        starsHTML += '<i class="ri-star-line text-yellow-400"></i>';
                    }
                }
                
                // Generate badge
                let badgeHTML = '';
                if (product.is_featured) {
                    badgeHTML = '<span class="badge bg-blue-500 text-white">الأكثر مبيعاً</span>';
                } else if (product.discount_percentage > 0) {
                    badgeHTML = `<span class="badge bg-red-500 text-white">خصم ${product.discount_percentage}%</span>`;
                } else if (product.stock > 0) {
                    badgeHTML = '<span class="badge bg-green-500 text-white">متوفر</span>';
                }
                
                // Generate old price
                let oldPriceHTML = '';
                if (product.old_price) {
                    oldPriceHTML = `<span class="text-gray-400 line-through text-sm mr-2">${product.old_price.toLocaleString()} ر.س</span>`;
                }
                
                productsHTML += `
                    <a href="/products/${product.share_slug || product.slug}" class="bg-[#1e293b] rounded-lg overflow-hidden product-card transition duration-300 block">
                        <div class="relative">
                            <img src="${imageUrl}" alt="${product.name}" class="w-full h-40 object-cover product-image">
                            ${badgeHTML}
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold mb-2">${product.name.length > 40 ? product.name.substring(0, 40) + '...' : product.name}</h3>
                            <div class="flex items-center gap-1 mb-3">
                                ${starsHTML}
                                <span class="text-sm text-gray-400">(${product.reviews_count})</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="font-bold">${product.price.toLocaleString()} ر.س</span>
                                    ${oldPriceHTML}
                                </div>
                                <button
                                    class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center text-primary hover:bg-primary/20 transition duration-300"
                                    onclick="event.preventDefault(); event.stopPropagation(); addToCart(${product.id})">
                                    <i class="ri-shopping-cart-line"></i>
                                </button>
                            </div>
                        </div>
                    </a>
                `;
            });
            
            productsGrid.innerHTML = productsHTML;
        }
        
        function showError(message) {
            productsGrid.innerHTML = `
                <div class="col-span-4 text-center py-12">
                    <i class="ri-error-warning-line text-6xl text-red-500 mb-4"></i>
                    <h3 class="text-xl font-bold text-gray-400 mb-2">خطأ</h3>
                    <p class="text-gray-500">${message}</p>
                </div>
            `;
        }
    });
    </script>
    <script id="add-to-cart">
    // Global function to update cart count in header
    function updateCartCount(newCount) {
        console.log('=== updateCartCount DEBUG START ===');
        console.log('New count:', newCount);
        
        // Check if the elements exist
        const cartCountElements = document.querySelectorAll('.cart-count');
        console.log('Elements with .cart-count class:', cartCountElements.length);
        
        if (cartCountElements.length > 0) {
            cartCountElements.forEach((element, index) => {
                console.log(`Element ${index}:`, element);
                console.log(`Current text: "${element.textContent}"`);
                console.log(`Classes: ${element.className}`);
                
                element.textContent = newCount;
                console.log(`Updated to: "${element.textContent}"`);
                
                // Add a subtle animation to indicate the update
                element.classList.add('animate-pulse', 'scale-110');
                setTimeout(() => {
                    element.classList.remove('animate-pulse', 'scale-110');
                }, 1000);
            });
        } else {
            console.log('No .cart-count elements found, searching for alternatives...');
            
            // Search for all spans that might be cart counters
            const allSpans = document.querySelectorAll('span');
            console.log('Total spans on page:', allSpans.length);
            
            // Look for spans that contain numbers and are near cart icons
            const cartIcons = document.querySelectorAll('.ri-shopping-cart-2-line, .ri-shopping-cart-line');
            console.log('Cart icons found:', cartIcons.length);
            
            cartIcons.forEach((icon, index) => {
                console.log(`Cart icon ${index}:`, icon);
                const parent = icon.parentElement;
                if (parent) {
                    const spans = parent.querySelectorAll('span');
                    console.log(`Spans in cart icon ${index} parent:`, spans.length);
                    
                    spans.forEach((span, spanIndex) => {
                        const text = span.textContent.trim();
                        console.log(`  Span ${spanIndex}: "${text}", classes: ${span.className}`);
                        
                        if (/^\d+$/.test(text)) {
                            console.log(`  -> Updating span ${spanIndex} from "${text}" to "${newCount}"`);
                            span.textContent = newCount;
                        }
                    });
                }
            });
        }
        
        console.log('=== updateCartCount DEBUG END ===');
    }

    // Function to sync cart count from server
    function syncCartCount() {
        console.log('=== syncCartCount START ===');
        fetch('/cart/count', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            console.log('Sync response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Sync response data:', data);
            if (data.cart_count !== undefined) {
                updateCartCount(data.cart_count);
            }
        })
        .catch(error => {
            console.error('Error syncing cart count:', error);
        });
        console.log('=== syncCartCount END ===');
    }

    // Add to cart functionality
    function addToCart(productId) {
        console.log('=== addToCart DEBUG START ===');
        console.log('Product ID:', productId);
        
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
                product_type: 'product',  // Added required field
                product_id: productId,
                quantity: 1
            })
        })
        .then(response => {
            console.log('Response status:', response.status);
            
            // Clear the timeout since we got a response
            clearTimeout(timeoutId);
            resetButton();
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            
            if (data.success) {
                // Show success message using CartManager
                window.CartManager.showNotification('تم إضافة المنتج إلى السلة بنجاح!', 'success');
                
                // Update cart count using CartManager
                if (data.cart_count !== undefined) {
                    window.CartManager.updateCartCount(data.cart_count);
                } else {
                    // Fallback: sync from server using CartManager
                    console.log('No cart_count in response, syncing from server...');
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
            
            console.error('Fetch error:', error);
            window.CartManager.showNotification('حدث خطأ في إضافة المنتج إلى السلة', 'error');
            
            // Try to sync cart count even on error
            setTimeout(() => window.CartManager.syncCartCount(), 1000);
        });
        
        console.log('=== addToCart DEBUG END ===');
    }

    // Show notification function
    function showNotification(message, type = 'info') {
        // Create notification element
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

    // Make functions globally available
    window.updateCartCount = updateCartCount;
    window.syncCartCount = syncCartCount;
    
    // Add a test function to manually check cart count elements
    window.testCartCount = function() {
        console.log('=== MANUAL CART COUNT TEST ===');
        updateCartCount(99);
    };

    // Sync cart count on page load to ensure accuracy
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Page loaded, syncing cart count...');
        // Small delay to ensure page is fully loaded
        setTimeout(syncCartCount, 500);
    });
    
    console.log('Cart functions loaded. You can test with: testCartCount()');
    </script>
</body>

</html>