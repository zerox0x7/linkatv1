<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->seo_title }} | متجر الألعاب والإلكترونيات</title>
    <meta name="description" content="{{ $product->seo_description }}">
    @if($product->meta_keywords)
    <meta name="keywords" content="{{ $product->meta_keywords }}">
    @endif
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
    @include('themes.greenGame.partials.header')
   
    
   
    <section class="px-6 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-2 gap-12">
            <!-- Product Images -->
            <div class="space-y-4">
                <div class="relative h-[500px] rounded-lg overflow-hidden bg-[#1e293b]">
                    <img src="{{ $product->main_image_url }}"
                        alt="{{ $product->name }}" class="w-full h-full object-contain">
                    @if($product->has_discount && $product->discount_percentage > 0)
                    <span
                        class="absolute top-4 right-4 bg-red-500 text-white px-4 py-1 rounded-full text-sm font-bold">خصم
                        {{ $product->discount_percentage }}%</span>
                    @endif
                </div>
                @if($product->gallery_urls && count($product->gallery_urls) > 0)
                <div class="grid grid-cols-4 gap-4">
                    @foreach(array_slice($product->gallery_urls, 0, 4) as $index => $image_url)
                    <div
                        class="h-24 rounded-lg overflow-hidden bg-[#1e293b] cursor-pointer hover:ring-2 hover:ring-primary transition duration-300"
                        onclick="changeMainImage('{{ $image_url }}')">
                        <img src="{{ $image_url }}"
                            alt="{{ $product->name }}" class="w-full h-full object-contain">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            <!-- Product Info -->
            <div class="space-y-6">
                <div class="space-y-2">
                    <h1 class="text-3xl font-bold">{{ $product->name }}</h1>
                    <div class="flex items-center gap-2">
                        <div class="flex items-center gap-1">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($averageRating))
                                <i class="ri-star-fill text-yellow-400"></i>
                                @elseif($i - 0.5 <= $averageRating)
                                <i class="ri-star-half-fill text-yellow-400"></i>
                                @else
                                <i class="ri-star-line text-yellow-400"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="text-gray-400">({{ $reviewsCount }} تقييم)</span>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-4xl font-bold text-primary">{{ number_format($product->price, 0) }} ر.س</span>
                    @if($product->old_price && $product->old_price > $product->price)
                    <span class="text-xl text-gray-400 line-through">{{ number_format($product->old_price, 0) }} ر.س</span>
                    <span class="bg-red-500/10 text-red-500 px-3 py-1 rounded-full text-sm font-bold">خصم {{ $product->discount_percentage }}%</span>
                    @endif
                </div>
                
                @if($product->price_options && count($product->price_options) > 0)
                <div class="space-y-4 border-t border-gray-800 pt-6">
                    <h3 class="font-bold text-lg">اختر الخيار:</h3>
                    <div class="flex gap-3" id="version-options">
                        @foreach($product->price_options as $option)
                        <button
                            class="px-6 py-3 rounded-button bg-[#1e293b] text-white hover:bg-primary transition duration-300"
                            data-version="{{ $option['name'] }}" data-price="{{ $option['price'] }}">{{ $option['name'] }} - {{ number_format($option['price'], 0) }} ر.س</button>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="space-y-4 border-t border-gray-800 pt-6">
                    <div class="flex items-center justify-between">
                        <h3 class="font-bold text-lg">الكمية:</h3>
                        <div class="flex items-center gap-3 bg-[#1e293b] rounded-button">
                            <button
                                class="w-10 h-10 flex items-center justify-center text-gray-400 hover:text-white transition duration-300"
                                id="decrease-quantity">
                                <i class="ri-subtract-line"></i>
                            </button>
                            <span class="w-12 text-center" id="quantity">1</span>
                            <button
                                class="w-10 h-10 flex items-center justify-center text-gray-400 hover:text-white transition duration-300"
                                id="increase-quantity">
                                <i class="ri-add-line"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <button
                            class="flex-1 bg-primary text-white px-6 py-4 rounded-button flex items-center justify-center gap-2 hover:bg-primary/90 transition duration-300"
                            id="buy-now" onclick="buyNow({{ $product->id }})">
                            <i class="ri-shopping-bag-line"></i>
                            <span>اشتر الآن</span>
                        </button>
                        <button
                            class="flex-1 bg-green-500 text-white px-6 py-4 rounded-button flex items-center justify-center gap-2 hover:bg-green-600 transition duration-300"
                            id="add-to-cart" onclick="addToCart({{ $product->id }})">
                            <i class="ri-shopping-cart-line"></i>
                            <span>أضف للسلة</span>
                        </button>
                        <button
                            class="w-14 h-14 bg-[#1e293b] text-primary rounded-button flex items-center justify-center hover:bg-primary/10 transition duration-300">
                            <i class="ri-heart-line"></i>
                        </button>
                    </div>
                </div>
                <div class="space-y-4 border-t border-gray-800 pt-6">
                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full bg-[#1e293b] flex items-center justify-center text-primary">
                                <i class="ri-truck-line"></i>
                            </div>
                            <div>
                                <h4 class="font-bold">شحن سريع</h4>
                                <p class="text-sm text-gray-400">توصيل سريع</p>
                            </div>
                        </div>
                        @if($product->warranty_days)
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full bg-[#1e293b] flex items-center justify-center text-primary">
                                <i class="ri-shield-check-line"></i>
                            </div>
                            <div>
                                <h4 class="font-bold">ضمان {{ $product->warranty_days }} يوم</h4>
                                <p class="text-sm text-gray-400">ضمان رسمي</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- Product Description -->
        <div class="mt-12 grid grid-cols-3 gap-8">
            <div class="col-span-2 space-y-6">
                <div class="bg-[#1e293b] rounded-lg p-6">
                    <h3 class="text-xl font-bold mb-4">وصف المنتج</h3>
                    <div class="space-y-4 text-gray-300">
                        {!! $product->description !!}
                        
                        @if($product->features && count($product->features) > 0)
                        <ul class="list-disc list-inside space-y-2">
                            @foreach($product->features as $feature)
                            <li>{{ $feature }}</li>
                            @endforeach
                        </ul>
                        @endif

                        @if($product->details)
                        <div class="mt-4">
                            {!! $product->details !!}
                        </div>
                        @endif
                    </div>
                </div>
                
                @if($product->reviews && $product->reviews->count() > 0)
                <div class="bg-[#1e293b] rounded-lg p-6">
                    <h3 class="text-xl font-bold mb-4">مراجعات العملاء</h3>
                    <div class="space-y-6">
                        @foreach($product->reviews->take(5) as $review)
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center">
                                <span class="font-bold">{{ substr($review->user->name ?? 'مستخدم', 0, 1) }}</span>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-bold">{{ $review->user->name ?? 'مستخدم' }}</h4>
                                    <span class="text-sm text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="flex items-center gap-1 my-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                        <i class="ri-star-fill text-yellow-400"></i>
                                        @else
                                        <i class="ri-star-line text-yellow-400"></i>
                                        @endif
                                    @endfor
                                </div>
                                <p class="text-gray-300">{{ $review->review ?: $review->comment }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            <!-- Payment Methods -->
            <div class="bg-[#1e293b] rounded-lg p-6 h-fit">
                <h3 class="text-xl font-bold mb-6">طرق الدفع المتاحة</h3>
                <div class="space-y-4">
                    <button
                        class="w-full bg-[#111827] text-white px-4 py-3 rounded-button flex items-center gap-3 hover:bg-[#1e293b] transition duration-300">
                        <i class="ri-bank-card-line text-xl"></i>
                        <span>بطاقة ائتمانية</span>
                    </button>
                    <button
                        class="w-full bg-[#111827] text-white px-4 py-3 rounded-button flex items-center gap-3 hover:bg-[#1e293b] transition duration-300">
                        <i class="ri-apple-fill text-xl"></i>
                        <span>Apple Pay</span>
                    </button>
                    <button
                        class="w-full bg-[#111827] text-white px-4 py-3 rounded-button flex items-center gap-3 hover:bg-[#1e293b] transition duration-300">
                        <i class="ri-paypal-fill text-xl text-blue-500"></i>
                        <span>PayPal</span>
                    </button>
                    <div class="pt-4 border-t border-gray-800">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-gray-400">سعر المنتج</span>
                            <span id="product-price">{{ number_format($product->price, 0) }} ر.س</span>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-gray-400">الضريبة</span>
                            <span id="tax-amount">{{ number_format($product->price * 0.15, 0) }} ر.س</span>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-gray-400">الشحن</span>
                            <span class="text-primary">مجاناً</span>
                        </div>
                        <div class="flex items-center justify-between pt-2 border-t border-gray-800 font-bold">
                            <span>الإجمالي</span>
                            <span id="total-price">{{ number_format($product->price * 1.15, 0) }} ر.س</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

 
    <!-- Footer -->

    @include('themes.greenGame.partials.footer')
    <script id="search-functionality">
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('.search-input');
        if (searchInput) {
            searchInput.addEventListener('focus', function() {
                this.classList.add('ring-2', 'ring-primary', 'ring-opacity-50');
            });
            searchInput.addEventListener('blur', function() {
                this.classList.remove('ring-2', 'ring-primary', 'ring-opacity-50');
            });
        }
    });
    </script>
    <script id="product-interaction">
    document.addEventListener('DOMContentLoaded', function() {
        // Quantity controls
        const decreaseBtn = document.getElementById('decrease-quantity');
        const increaseBtn = document.getElementById('increase-quantity');
        const quantitySpan = document.getElementById('quantity');
        
        if (decreaseBtn && increaseBtn && quantitySpan) {
            decreaseBtn.addEventListener('click', function() {
                let quantity = parseInt(quantitySpan.textContent);
                if (quantity > 1) {
                    quantity--;
                    quantitySpan.textContent = quantity;
                    updateTotalPrice();
                }
            });
            
            increaseBtn.addEventListener('click', function() {
                let quantity = parseInt(quantitySpan.textContent);
                if (quantity < {{ $product->stock }}) {
                    quantity++;
                    quantitySpan.textContent = quantity;
                    updateTotalPrice();
                }
            });
        }

        // Price option selection
        const versionButtons = document.querySelectorAll('#version-options button');
        versionButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                versionButtons.forEach(btn => {
                    btn.classList.remove('bg-primary');
                    btn.classList.add('bg-[#1e293b]');
                });
                
                // Add active class to clicked button
                this.classList.remove('bg-[#1e293b]');
                this.classList.add('bg-primary');
                
                // Update price
                const price = parseFloat(this.dataset.price);
                document.getElementById('product-price').textContent = price.toLocaleString() + ' ر.س';
                updateTotalPrice();
            });
        });

        function updateTotalPrice() {
            const quantity = parseInt(document.getElementById('quantity').textContent);
            const basePrice = parseFloat(document.getElementById('product-price').textContent.replace(/[^\d]/g, ''));
            const subtotal = basePrice * quantity;
            const tax = subtotal * 0.15;
            const total = subtotal + tax;
            
            document.getElementById('tax-amount').textContent = tax.toLocaleString() + ' ر.س';
            document.getElementById('total-price').textContent = total.toLocaleString() + ' ر.س';
        }
    });

    // Change main image function
    function changeMainImage(imageUrl) {
        const mainImage = document.querySelector('.h-\\[500px\\] img');
        if (mainImage) {
            mainImage.src = imageUrl;
        }
    }
    </script>
    
    <script id="add-to-cart">
    // Buy now functionality - Add to cart and redirect to cart page
    function buyNow(productId) {
        const quantity = parseInt(document.getElementById('quantity').textContent);
        const selectedVersion = document.querySelector('#version-options .bg-primary');
        const versionData = selectedVersion ? {
            name: selectedVersion.dataset.version,
            price: selectedVersion.dataset.price
        } : null;

        // Disable button and show loading
        const buyBtn = document.getElementById('buy-now');
        const originalContent = buyBtn.innerHTML;
        buyBtn.disabled = true;
        buyBtn.innerHTML = '<i class="ri-loader-4-line animate-spin"></i><span>جاري المعالجة...</span>';

        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                product_type: 'product',
                product_id: productId,
                quantity: quantity,
                version: versionData
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update cart count immediately before redirect
                if (data.cart_count !== undefined && window.CartManager) {
                    window.CartManager.updateCartCount(data.cart_count);
                }
                
                // Short delay to show the update, then redirect to cart
                setTimeout(() => {
                    window.location.href = '/cart';
                }, 300);
            } else {
                // Reset button and show error
                buyBtn.disabled = false;
                buyBtn.innerHTML = originalContent;
                
                if (window.CartManager) {
                    window.CartManager.showNotification(data.message || 'حدث خطأ في إضافة المنتج', 'error');
                } else {
                    showNotification(data.message || 'حدث خطأ في إضافة المنتج', 'error');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            buyBtn.disabled = false;
            buyBtn.innerHTML = originalContent;
            
            if (window.CartManager) {
                window.CartManager.showNotification('حدث خطأ في إضافة المنتج', 'error');
            } else {
                showNotification('حدث خطأ في إضافة المنتج', 'error');
            }
        });
    }

    // Add to cart functionality
    function addToCart(productId) {
        const quantity = parseInt(document.getElementById('quantity').textContent);
        const selectedVersion = document.querySelector('#version-options .bg-primary');
        const versionData = selectedVersion ? {
            name: selectedVersion.dataset.version,
            price: selectedVersion.dataset.price
        } : null;

        // Disable button and show loading
        const addBtn = document.getElementById('add-to-cart');
        const originalContent = addBtn.innerHTML;
        addBtn.disabled = true;
        addBtn.innerHTML = '<i class="ri-loader-4-line animate-spin"></i>';

        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                product_type: 'product',
                product_id: productId,
                quantity: quantity,
                version: versionData
            })
        })
        .then(response => response.json())
        .then(data => {
            // Reset button
            addBtn.disabled = false;
            addBtn.innerHTML = originalContent;
            
            if (data.success) {
                // Update cart count immediately using CartManager
                if (data.cart_count !== undefined && window.CartManager) {
                    window.CartManager.updateCartCount(data.cart_count);
                    window.CartManager.showNotification('تم إضافة المنتج إلى السلة بنجاح!', 'success');
                } else {
                    // Fallback for older code
                    showNotification('تم إضافة المنتج إلى السلة بنجاح!', 'success');
                    const cartCountElements = document.querySelectorAll('.cart-count');
                    if (cartCountElements.length > 0 && data.cart_count !== undefined) {
                        cartCountElements.forEach(element => {
                            element.textContent = data.cart_count;
                        });
                    }
                }
            } else {
                if (window.CartManager) {
                    window.CartManager.showNotification(data.message || 'حدث خطأ في إضافة المنتج', 'error');
                } else {
                    showNotification(data.message || 'حدث خطأ في إضافة المنتج', 'error');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            addBtn.disabled = false;
            addBtn.innerHTML = originalContent;
            
            if (window.CartManager) {
                window.CartManager.showNotification('حدث خطأ في إضافة المنتج', 'error');
            } else {
                showNotification('حدث خطأ في إضافة المنتج', 'error');
            }
        });
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
    </script>
</body>

</html>