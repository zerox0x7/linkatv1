<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>نتائج البحث | {{ $store->store_name ?? 'متجر الألعاب' }}</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <style>
    :where([class^="ri-"])::before {
        content: "\f3c2";
    }

    body {
        background-color: #0a1525;
        color: #fff;
        font-family: 'Inter', sans-serif;
        direction: rtl;
    }

    .product-card {
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(87, 181, 231, 0.3);
        text-decoration: none;
        color: inherit;
    }

    .product-card img {
        transition: transform 0.5s ease;
    }

    .product-card:hover img {
        transform: scale(1.05);
    }

    .badge {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        text-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
    }

    .glow-effect {
        box-shadow: 0 0 15px rgba(87, 181, 231, 0.3);
    }

    .card-gradient {
        background: linear-gradient(180deg, rgba(30, 41, 59, 0.8) 0%, rgba(15, 23, 42, 0.9) 100%);
    }

    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translate(-50%, -20px);
        }
        to {
            opacity: 1;
            transform: translate(-50%, 0);
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: translate(-50%, 0);
        }
        to {
            opacity: 0;
            transform: translate(-50%, -20px);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.3s ease-out forwards;
    }

    .animate-fade-out {
        animation: fadeOut 0.3s ease-out forwards;
    }
    </style>
</head>

<body class="min-h-screen">
    @include('themes.greenGame.partials.header')    

    <!-- Search Results Section -->
    <section class="px-6 py-12">
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold mb-2">نتائج البحث</h1>
                    @if(!empty($searchTerm))
                        <p class="text-gray-400">نتائج البحث عن: "<span class="text-primary font-medium">{{ $searchTerm }}</span>"</p>
                        <p class="text-sm text-gray-500 mt-1">تم العثور على {{ $products->total() }} منتج</p>
                    @else
                        <p class="text-gray-400">جميع المنتجات المتاحة</p>
                    @endif
                </div>
                
                <!-- Sort Options -->
                <div class="flex gap-2">
                    <form method="GET" action="{{ route('products.search') }}" class="flex gap-2">
                        <input type="hidden" name="q" value="{{ $searchTerm }}">
                        <select name="sort" onchange="this.form.submit()" class="bg-[#1e293b] text-white px-4 py-2 rounded-button border-none focus:outline-none focus:ring-2 focus:ring-primary">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>الأحدث</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>الأكثر مبيعاً</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>الأقل سعراً</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>الأعلى سعراً</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>الأعلى تقييماً</option>
                        </select>
                    </form>
                </div>
            </div>

            {{-- <!-- Search Filters -->
            @if($categories->count() > 0)
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3">تصفية حسب الفئة</h3>
                <div class="flex gap-2 flex-wrap">
                    <a href="{{ route('products.search', ['q' => $searchTerm, 'sort' => request('sort')]) }}" 
                       class="px-4 py-2 rounded-button transition-colors {{ request('category') ? 'bg-[#1e293b] text-gray-400' : 'bg-primary text-white' }}">
                        جميع الفئات
                    </a>
                    @foreach($categories as $category)
                    <a href="{{ route('products.search', ['q' => $searchTerm, 'category' => $category->slug, 'sort' => request('sort')]) }}" 
                       class="px-4 py-2 rounded-button transition-colors {{ request('category') == $category->slug ? 'bg-primary text-white' : 'bg-[#1e293b] text-gray-400 hover:bg-gray-700' }}">
                        {{ $category->name }}
                    </a>
                    @endforeach
                </div>
            </div>
            @endif --}}
        </div>

        <!-- Search Results Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($products as $product)
            <a href="{{ route('products.show', $product->share_slug ?: $product->slug) }}" class="bg-[#1e293b] rounded-lg overflow-hidden product-card block">
                <div class="relative">
                    <img src="{{ $product->main_image_url ?: 'https://readdy.ai/api/search-image?query=gaming%20product%20on%20dark%20background%2C%20high-quality%20product%20photography%2C%20detailed%20texture%2C%20studio%20lighting%2C%20dark%20theme%20with%20blue%20accents&width=300&height=200&seq=' . $loop->iteration . '&orientation=landscape' }}"
                        alt="{{ $product->name }}" class="w-full h-48 object-cover">
                    
                    @if($product->is_featured)
                        <span class="badge bg-blue-500 text-white">الأكثر مبيعاً</span>
                    @elseif($product->discount_percentage > 0)
                        <span class="badge bg-red-500 text-white">خصم {{ $product->discount_percentage }}%</span>
                    @elseif($product->stock > 0)
                        <span class="badge bg-green-500 text-white">متوفر</span>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="font-bold mb-2 text-white">{{ \Illuminate\Support\Str::limit($product->name, 50) }}</h3>
                    
                    @if($product->category)
                    <p class="text-sm text-gray-400 mb-2">{{ $product->category->name }}</p>
                    @endif

                    <div class="flex items-center gap-1 mb-3">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($product->reviews_avg_rating ?? 0))
                                <i class="ri-star-fill text-yellow-400"></i>
                            @elseif($i - 0.5 <= ($product->reviews_avg_rating ?? 0))
                                <i class="ri-star-half-fill text-yellow-400"></i>
                            @else
                                <i class="ri-star-line text-yellow-400"></i>
                            @endif
                        @endfor
                        <span class="text-sm text-gray-400">({{ $product->reviews_count ?? 0 }})</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="font-bold text-primary">{{ number_format($product->price, 0) }} ر.س</span>
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
            <!-- No Results Found -->
            <div class="col-span-full text-center py-16">
                <div class="max-w-md mx-auto">
                    <i class="ri-search-line text-6xl text-gray-500 mb-4"></i>
                    <h3 class="text-2xl font-bold text-gray-400 mb-4">لا توجد نتائج</h3>
                    @if(!empty($searchTerm))
                        <p class="text-gray-500 mb-6">لم نتمكن من العثور على منتجات تطابق بحثك عن "{{ $searchTerm }}"</p>
                        <div class="space-y-2 text-sm text-gray-400">
                            <p>جرب:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>تأكد من صحة الكتابة</li>
                                <li>استخدم كلمات أقل أو أكثر عمومية</li>
                                <li>تصفح الفئات المختلفة</li>
                            </ul>
                        </div>
                    @else
                        <p class="text-gray-500 mb-6">لا توجد منتجات متاحة حالياً</p>
                    @endif
                    <a href="{{ route('products.index') }}" 
                       class="inline-flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-button hover:bg-primary/90 transition-colors">
                        <i class="ri-arrow-right-line"></i>
                        تصفح جميع المنتجات
                    </a>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
        <div class="mt-12 flex justify-center">
            <div class="flex items-center gap-2">
                {{ $products->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        </div>
        @endif
    </section>

    @if(isset($store) && $store->footer_enabled)
        @include('themes.greenGame.partials.footer')
    @endif

    <script>
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

        // Fallback timeout
        const timeoutId = setTimeout(resetButton, 3000);

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
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Show success state
                if (button) {
                    button.innerHTML = '<i class="ri-check-line"></i>';
                    button.classList.remove('text-primary', 'bg-primary/10');
                    button.classList.add('text-white', 'bg-green-500');
                }
                
                // Update cart count in header
                if (window.CartManager) {
                    window.CartManager.syncCartCount();
                } else {
                    updateCartCount();
                }
                
                // Show success message (optional)
                showNotification('تمت إضافة المنتج إلى السلة بنجاح', 'success');
                
                // Reset button after 2 seconds
                setTimeout(() => {
                    if (button) {
                        button.innerHTML = originalContent;
                        button.classList.remove('text-white', 'bg-green-500');
                        button.classList.add('text-primary', 'bg-primary/10');
                        button.disabled = false;
                    }
                }, 2000);
            } else {
                resetButton();
                showNotification(data.message || 'حدث خطأ أثناء إضافة المنتج', 'error');
            }
        })
        .catch(error => {
            console.error('Error adding to cart:', error);
            resetButton();
            showNotification('حدث خطأ أثناء إضافة المنتج للسلة', 'error');
        });
    }

    // Update cart count
    function updateCartCount() {
        fetch('/cart/count', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            const count = data.cart_count || 0;
            
            // Update all cart count elements
            const cartCountElements = document.querySelectorAll('[data-cart-count]');
            cartCountElements.forEach(element => {
                element.textContent = count;
                element.setAttribute('data-cart-count', count);
            });
            
            // Also update any other cart counter elements
            const cartBadges = document.querySelectorAll('.cart-count, #cart-count');
            cartBadges.forEach(badge => {
                badge.textContent = count;
            });

            // Update cart icon badge in header
            const headerCartBadge = document.querySelector('.ri-shopping-cart-2-line')?.parentElement?.querySelector('span');
            if (headerCartBadge) {
                headerCartBadge.textContent = count;
            }
        })
        .catch(error => {
            console.error('Error updating cart count:', error);
        });
    }

    // Show notification
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 left-1/2 transform -translate-x-1/2 px-6 py-3 rounded-lg shadow-lg z-50 ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        } text-white flex items-center gap-2 animate-fade-in`;
        notification.innerHTML = `
            <i class="ri-${type === 'success' ? 'check' : 'error-warning'}-line"></i>
            <span>${message}</span>
        `;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.add('animate-fade-out');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Search functionality enhancements
    document.addEventListener('DOMContentLoaded', function() {
        // Highlight search terms in product names
        const searchTerm = "{{ $searchTerm }}";
        if (searchTerm) {
            const productTitles = document.querySelectorAll('.product-card h3');
            productTitles.forEach(title => {
                const regex = new RegExp(`(${searchTerm})`, 'gi');
                title.innerHTML = title.innerHTML.replace(regex, '<mark class="bg-primary/20 text-primary px-1 rounded">$1</mark>');
            });
        }

        // Product card hover effects
        const productCards = document.querySelectorAll('.product-card');
        productCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.classList.add('shadow-lg', 'shadow-primary/10');
            });
            card.addEventListener('mouseleave', function() {
                this.classList.remove('shadow-lg', 'shadow-primary/10');
            });
        });
    });
    </script>
</body>

</html>