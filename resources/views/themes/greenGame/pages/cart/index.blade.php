<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سلة التسوق - {{ config('app.name') }}</title>
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
    
    <!-- CSRF Token for AJAX Requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
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

    /* Cart specific styles */
    .glass-effect {
        background: rgba(30, 41, 59, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* إخفاء أسهم الزيادة والنقصان في حقول الإدخال الرقمية */
    .no-spinners::-webkit-outer-spin-button,
    .no-spinners::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .no-spinners {
        -moz-appearance: textfield;
    }

    .rounded-r-lg {
        border-top-right-radius: 0px;
        border-bottom-right-radius: 0px;
    }

    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    </style>
</head>

<body class="min-h-screen">
    @include('themes.greenGame.partials.header')    

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Breadcrumbs -->
        <div class="flex items-center text-sm text-gray-400 mb-6">
            <a href="{{ route('home') }}" class="hover:text-primary">الرئيسية</a>
            <i class="ri-arrow-left-s-line mx-2"></i>
            <span class="text-gray-300">سلة التسوق</span>
        </div>

        <h1 class="text-3xl font-bold text-white mb-6">سلة التسوق</h1>
        
        <!-- Flash Message -->
        @if(session('success'))
        <div class="bg-green-600 bg-opacity-20 border border-green-600 text-green-100 px-4 py-3 rounded mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        <!-- Cart items -->
        @if($cart->items->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="glass-effect rounded-lg p-6">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead>
                            <tr>
                                <th class="text-right text-sm font-medium text-gray-300 py-3">المنتج</th>
                                <th class="text-center text-sm font-medium text-gray-300 py-3">السعر</th>
                                <th class="text-center text-sm font-medium text-gray-300 py-3">الكمية</th>
                                <th class="text-center text-sm font-medium text-gray-300 py-3">المجموع</th>
                                <th class="text-center text-sm font-medium text-gray-300 py-3">حذف</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            @foreach($cart->items as $item)
                            <tr class="hover:bg-gray-800/30 transition-colors" data-id="{{ $item->id }}">
                                <td class="py-4">
                                    <div class="flex items-center">
                                        <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-md border border-gray-700 bg-gray-800">
                                            <img src="{{ $item->cartable->image_url ?? asset('images/placeholder.png') }}" 
                                                 alt="{{ $item->cartable->name ?? 'منتج غير موجود' }}" 
                                                 class="h-full w-full object-cover object-center">
                                        </div>
                                        <div class="mr-4">
                                            <h3 class="text-base font-medium text-white">
                                                {{ $item->cartable->name ?? 'منتج غير موجود أو تم حذفه' }}
                                            </h3>
                                            
                                            <!-- عرض بيانات المنتج المخصص -->
                                            @if(isset($item->options['player_data']) && is_array($item->options['player_data']))
                                            <div class="mt-1 text-xs text-gray-400">
                                                <div class="bg-purple-900/30 p-2 rounded-md border border-purple-700/50 mt-2">
                                                    <span class="block font-medium mb-1 text-purple-300">بيانات المستخدم:</span>
                                                    <ul class="space-y-1">
                                                        @foreach($item->options['player_data'] as $fieldName => $fieldData)
                                                            @if($fieldName != 'price_option')
                                                            <li>
                                                                @if(is_array($fieldData) && isset($fieldData['label']))
                                                                    <span class="font-medium text-purple-300">{{ $fieldData['label'] }}:</span>
                                                                    @if(isset($fieldData['value']))
                                                                        @if(is_array($fieldData['value']))
                                                                            @if(isset($fieldData['value']['name']) && isset($fieldData['value']['price']))
                                                                                {{ $fieldData['value']['name'] }} - {{ $fieldData['value']['price'] }} ر.س
                                                                            @else
                                                                                {{ implode(', ', array_map(function($v) { return is_array($v) ? '' : $v; }, $fieldData['value'])) }}
                                                                            @endif
                                                                        @else
                                                                            {{ $fieldData['value'] }}
                                                                        @endif
                                                                    @endif
                                                                @else
                                                                    <span class="font-medium text-purple-300">{{ $fieldName }}:</span>
                                                                    @if(is_array($fieldData))
                                                                        {{ implode(', ', array_map(function($v) { return is_array($v) ? '' : $v; }, $fieldData)) }}
                                                                    @else
                                                                        {{ $fieldData }}
                                                                    @endif
                                                                @endif
                                                            </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                            @endif
                                            
                                            <!-- عرض الخدمة المطلوبة (التنسيق المحسن) -->
                                            @if(isset($item->options['service_option']) && is_array($item->options['service_option']))
                                            <div class="mt-1 text-xs text-gray-400">
                                                <div class="bg-blue-900/30 p-2 rounded-md border border-blue-800/50 mt-2">
                                                    <span class="block font-medium mb-1 text-blue-400">الخدمة المطلوبة:</span>
                                                    <div class="flex items-center">
                                                        <span class="ml-2 text-blue-300">{{ $item->options['service_option']['name'] ?? 'خدمة مخصصة' }}</span>
                                                        @if(isset($item->options['service_option']['price']))
                                                        <span class="text-green-400">({{ $item->options['service_option']['price'] }} ر.س)</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            
                                            @if($item->cartable_type == 'App\\Models\\Product')
                                            <p class="mt-1 text-sm text-gray-400">{{ $item->cartable->category->name ?? 'عام' }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center py-4">
                                    <span class="text-primary font-medium">{{ $item->price }} ر.س</span>
                                </td>
                                <td class="text-center py-4">
                                    <div class="flex items-center justify-center">
                                        <div class="relative border border-primary/30 bg-gray-900/50 rounded-full flex items-center w-32 h-10 px-1">
                                            <button type="button" class="quantity-decrease w-8 h-8 flex items-center justify-center bg-[#15141f] text-white rounded-full focus:outline-none hover:bg-primary transition-colors"
                                                    onclick="decreaseQuantity({{ $item->id }})"
                                                    title="إنقاص الكمية">
                                                <i class="ri-subtract-line"></i>
                                            </button>
                                            <input type="number" min="1" value="{{ $item->quantity }}" 
                                                   class="no-spinners w-full h-8 text-center bg-transparent border-0 text-white focus:ring-0 px-0" 
                                                   oninput="updateQuantityFromInput(this, {{ $item->id }})"
                                                   data-original-value="{{ $item->quantity }}"
                                                   id="qty-input-{{ $item->id }}"
                                                   data-max-stock="{{ $item->cartable ? ($item->cartable_type == 'App\\Models\\Product' ? $item->cartable->stock : $item->cartable->stock_quantity) : 0 }}">
                                            <button type="button" class="quantity-increase w-8 h-8 flex items-center justify-center bg-[#15141f] text-white rounded-full focus:outline-none hover:bg-primary transition-colors"
                                                    onclick="increaseQuantity({{ $item->id }})"
                                                    title="زيادة الكمية">
                                                <i class="ri-add-line"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center py-4">
                                    <span class="text-primary font-medium item-total">{{ $item->quantity * $item->price }} ر.س</span>
                                </td>
                                <td class="text-center py-4">
                                    <button type="button" class="text-red-400 hover:text-white hover:bg-red-500 p-2 rounded-full transition-all focus:outline-none"
                                            onclick="removeItem({{ $item->id }})">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-6 flex justify-between">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center bg-gradient-to-r from-gray-700 to-gray-800 hover:from-gray-600 hover:to-gray-700 px-4 py-2 rounded-lg text-white transition-colors">
                            <i class="ri-arrow-left-line ml-1"></i>
                            مواصلة التسوق
                        </a>
                        <button type="button" class="inline-flex items-center bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 px-4 py-2 rounded-lg text-white transition-colors"
                                onclick="clearCart()">
                            <i class="ri-delete-bin-line ml-1"></i>
                            تفريغ السلة
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Cart summary -->
            <div class="lg:col-span-1">
                <div class="glass-effect rounded-lg p-6">
                    <h2 class="text-xl font-bold text-white mb-4">ملخص الطلب</h2>
                    <div class="space-y-4">
                        <div class="flex justify-between border-b border-gray-700 pb-4">
                            <span class="text-gray-300">المجموع</span>
                            <span class="text-white font-medium cart-total">{{ $cart->getTotal() }} ر.س</span>
                        </div>
                        
                        <!-- كود الخصم -->
                        <div class="border-b border-gray-700 pb-6">
                            <div class="flex items-center mb-4">
                                <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full mr-3">
                                    <i class="ri-coupon-3-line text-white text-lg"></i>
                                </div>
                                <h3 class="text-white font-semibold text-lg">
                                    كود الخصم
                                </h3>
                            </div>
                            
                            @if(session('coupon'))
                                <div class="bg-gradient-to-r from-green-500/10 to-emerald-500/10 p-4 rounded-xl border border-green-500/30 backdrop-blur-sm relative overflow-hidden">
                                    <!-- Background decoration -->
                                    <div class="absolute top-0 right-0 w-20 h-20 bg-green-400/10 rounded-full -translate-y-10 translate-x-10"></div>
                                    <div class="absolute bottom-0 left-0 w-16 h-16 bg-emerald-400/10 rounded-full translate-y-8 -translate-x-8"></div>
                                    
                                    <div class="flex items-center justify-between relative z-10">
                                        <div class="flex items-center">
                                            <div class="flex items-center justify-center w-8 h-8 bg-green-500 rounded-full mr-3">
                                                <i class="ri-check-line text-white text-sm"></i>
                                            </div>
                                            <div>
                                                <div class="flex items-center">
                                                    <span class="text-white font-medium text-lg">{{ session('coupon')['code'] }}</span>
                                                    <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full mr-2">مُطبق</span>
                                                </div>
                                                <span class="text-green-300 text-sm flex items-center mt-1">
                                                    <i class="ri-arrow-down-line text-green-400 mr-1"></i>
                                                    خصم: {{ session('coupon')['discount'] }} ر.س
                                                </span>
                                            </div>
                                        </div>
                                        <button type="button" 
                                                onclick="removeCoupon()" 
                                                class="remove-coupon-btn group flex items-center justify-center w-10 h-10 bg-red-500/20 hover:bg-red-500 text-red-400 hover:text-white rounded-full transition-all duration-300 hover:scale-110">
                                            <i class="ri-close-line text-lg group-hover:rotate-90 transition-transform duration-300"></i>
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="space-y-4">
                                    <div class="relative">
                                        <div class="flex rounded-xl overflow-hidden shadow-lg bg-gradient-to-r from-gray-800/50 to-gray-900/50 backdrop-blur-sm border border-gray-600/30">
                                            <div class="flex items-center justify-center px-4 bg-gradient-to-r from-blue-600/20 to-purple-600/20 border-r border-gray-600/30">
                                                <i class="ri-coupon-line text-blue-400 text-xl"></i>
                                            </div>
                                            <input type="text" 
                                                   id="coupon_code" 
                                                   class="flex-1 bg-transparent border-0 px-4 py-4 text-white placeholder-gray-400 focus:ring-0 focus:outline-none text-lg" 
                                                   placeholder="أدخل كود الخصم هنا..."
                                                   autocomplete="off">
                                            <button type="button" 
                                                    onclick="applyCoupon()" 
                                                    class="apply-coupon-btn px-6 py-4 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-medium transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/25 relative overflow-hidden group">
                                                <span class="relative z-10 flex items-center">
                                                    <i class="ri-check-line mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                                                    تطبيق
                                                </span>
                                                <!-- Hover effect -->
                                                <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-purple-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Message area with better styling -->
                                    <div id="coupon-message" class="hidden">
                                        <div class="flex items-center p-3 rounded-lg transition-all duration-300">
                                            <i class="message-icon mr-2 text-lg"></i>
                                            <span class="message-text text-sm font-medium"></span>
                                        </div>
                                    </div>
                                    
                                    <!-- Help text -->
                                    <div class="flex items-center text-xs text-gray-400 bg-gray-800/30 px-3 py-2 rounded-lg">
                                        <i class="ri-information-line mr-2 text-blue-400"></i>
                                        <span>أدخل كود الخصم الخاص بك للحصول على تخفيض على طلبك</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        @if(session('coupon'))
                        <div class="flex justify-between border-b border-gray-700 pb-4" id="discount-section">
                            <span class="text-gray-300">الخصم ({{ session('coupon')['code'] }})</span>
                            <span class="text-red-400 font-medium">- {{ session('coupon')['discount'] }} ر.س</span>
                        </div>
                        @endif
                        
                        <div class="flex justify-between border-b border-gray-700 pb-4">
                            <span class="text-gray-300">الشحن</span>
                            <span class="text-white font-medium">مجاني</span>
                        </div>
                        <div class="flex justify-between pb-4">
                            <span class="text-lg text-white font-medium">الإجمالي</span>
                            <span class="text-lg text-primary font-bold cart-total">
                                @if(session('coupon'))
                                    {{ $cart->getTotal() - session('coupon')['discount'] }} ر.س
                                @else
                                    {{ $cart->getTotal() }} ر.س
                                @endif
                            </span>
                        </div>
                        @auth
                            <a href="{{ route('checkout.index') }}" class="block w-full bg-gradient-to-r from-primary to-secondary text-white px-6 py-3 rounded-button font-medium text-center hover:opacity-90 transition-all">
                                <i class="ri-secure-payment-line ml-2"></i> متابعة الشراء
                            </a>
                        @else
                            <a href="{{ route('login', ['redirect' => route('checkout.index')]) }}" class="block w-full bg-gradient-to-r from-primary to-secondary text-white px-6 py-3 rounded-button font-medium text-center hover:opacity-90 transition-all">
                                <i class="ri-login-circle-line ml-2"></i> تسجيل الدخول للمتابعة
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- Empty cart -->
        <div class="glass-effect rounded-lg p-8 text-center">
            <div class="text-gray-400 text-6xl mb-4">
                <i class="ri-shopping-cart-line"></i>
            </div>
            <h2 class="text-xl font-bold text-white mb-2">سلة التسوق فارغة</h2>
            <p class="text-gray-400 mb-6">لم تقم بإضافة أي منتجات بعد.</p>
            <a href="{{ route('products.index') }}" class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-3 rounded-button font-medium inline-block hover:opacity-90 transition-all">
                تصفح المنتجات
            </a>
        </div>
        @endif
    </main>

    @include('themes.greenGame.partials.footer')
    
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // إعداد ال csrf token مع كل طلبات ajax
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // عرض رسالة متعلقة بكود الخصم
        function showCouponMessage(type, message) {
            const messageDiv = $('#coupon-message');
            const messageContainer = messageDiv.find('div');
            const messageIcon = messageDiv.find('.message-icon');
            const messageText = messageDiv.find('.message-text');
            
            messageDiv.removeClass('hidden');
            
            // إزالة الكلاسات السابقة
            messageContainer.removeClass('bg-red-500/10 bg-green-500/10 bg-blue-500/10 border-red-500/30 border-green-500/30 border-blue-500/30');
            messageText.removeClass('text-red-400 text-green-400 text-blue-400');
            messageIcon.removeClass('ri-error-warning-line ri-check-circle-line ri-loader-4-line animate-spin');
            
            if (type === 'success') {
                messageContainer.addClass('bg-green-500/10 border border-green-500/30');
                messageText.addClass('text-green-400');
                messageIcon.addClass('ri-check-circle-line text-green-400');
                messageText.text(message);
            } else if (type === 'error') {
                messageContainer.addClass('bg-red-500/10 border border-red-500/30');
                messageText.addClass('text-red-400');
                messageIcon.addClass('ri-error-warning-line text-red-400');
                messageText.text(message);
            } else if (type === 'loading') {
                messageContainer.addClass('bg-blue-500/10 border border-blue-500/30');
                messageText.addClass('text-blue-400');
                messageIcon.addClass('ri-loader-4-line animate-spin text-blue-400');
                messageText.text(message);
            }
            
            // إضافة تأثير انزلاق للظهور
            messageDiv.css({
                'opacity': '0',
                'transform': 'translateY(-10px)'
            }).animate({
                'opacity': '1',
                'transform': 'translateY(0)'
            }, 300);
        }
        
        // تطبيق كود الخصم
        function applyCoupon() {
            const couponCode = $('#coupon_code').val().trim();
            if (!couponCode) {
                showCouponMessage('error', 'يرجى إدخال كود الخصم');
                return;
            }
            
            // تعطيل الزر وإظهار حالة التحميل
            const applyButton = $('.apply-coupon-btn');
            const buttonSpan = applyButton.find('span');
            const originalHtml = buttonSpan.html();
            
            applyButton.prop('disabled', true).addClass('opacity-70 cursor-not-allowed');
            buttonSpan.html(`
                <i class="ri-loader-4-line animate-spin mr-2"></i>
                جارٍ التطبيق...
            `);
            
            // عرض رسالة تحميل
            showCouponMessage('loading', 'جارِ التحقق من الكود...');
            
            $.ajax({
                url: '{{ route("cart.apply-coupon") }}',
                type: 'POST',
                data: {
                    code: couponCode
                },
                success: function(response) {
                    applyButton.prop('disabled', false).removeClass('opacity-70 cursor-not-allowed');
                    buttonSpan.html(originalHtml);
                    if (response.success) {
                        showCouponMessage('success', 'تم تطبيق كود الخصم بنجاح!');
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        showCouponMessage('error', response.message || 'حدث خطأ أثناء تطبيق الكود');
                    }
                },
                error: function(xhr) {
                    applyButton.prop('disabled', false).removeClass('opacity-70 cursor-not-allowed');
                    buttonSpan.html(originalHtml);
                    let errorMessage = 'حدث خطأ أثناء تطبيق الكود';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    showCouponMessage('error', errorMessage);
                }
            });
        }
        
        // إزالة كود الخصم
        function removeCoupon() {
            // عرض حالة التحميل
            const removeButton = $('.remove-coupon-btn');
            const originalHtml = removeButton.html();
            removeButton.prop('disabled', true).addClass('opacity-70');
            removeButton.html(`<i class="ri-loader-4-line animate-spin"></i>`);
            
            $.ajax({
                url: '{{ route("cart.remove-coupon") }}',
                type: 'POST',
                success: function(response) {
                    if (response.success) {
                        // تحديث الصفحة بعد إزالة الكود بنجاح
                        location.reload();
                    } else {
                        // إعادة الزر إلى حالته الأصلية
                        removeButton.prop('disabled', false).removeClass('opacity-70');
                        removeButton.html(originalHtml);
                        showAlert('error', response.message || 'حدث خطأ أثناء إزالة الكود');
                    }
                },
                error: function(xhr) {
                    // إعادة الزر إلى حالته الأصلية
                    removeButton.prop('disabled', false).removeClass('opacity-70');
                    removeButton.html(originalHtml);
                    
                    let errorMessage = 'حدث خطأ أثناء إزالة الكود';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    showAlert('error', errorMessage);
                }
            });
        }
        
        // زيادة الكمية
        function increaseQuantity(itemId) {
            const input = document.getElementById(`qty-input-${itemId}`);
            const currentValue = parseInt(input.value);
            const maxStock = parseInt(input.dataset.maxStock);
            const button = $(input).next('button');
            
            // إضافة تأثير نقر على الزر
            button.addClass('bg-primary');
            setTimeout(() => button.removeClass('bg-primary'), 200);
            
            if (isNaN(currentValue)) return;
            
            const newValue = currentValue + 1;
            
            if (newValue <= maxStock) {
                updateQuantity(itemId, newValue);
            } else {
                showAlert('error', `الكمية المطلوبة (${newValue}) غير متوفرة في المخزون. المتوفر حالياً: ${maxStock}`);
            }
        }
        
        // إنقاص الكمية
        function decreaseQuantity(itemId) {
            const input = document.getElementById(`qty-input-${itemId}`);
            const currentValue = parseInt(input.value);
            const button = $(input).prev('button');
            
            // إضافة تأثير نقر على الزر
            button.addClass('bg-primary');
            setTimeout(() => button.removeClass('bg-primary'), 200);
            
            if (isNaN(currentValue) || currentValue <= 1) return;
            
            updateQuantity(itemId, currentValue - 1);
        }
        
        // تحديث الكمية
        function updateQuantity(itemId, quantity) {
            if (quantity < 1) return;
            
            // تحديث الواجهة مباشرة للاستجابة الفورية
            const qtyInput = $(`tr[data-id="${itemId}"] input[type="number"]`);
            const maxStock = parseInt(qtyInput.data('max-stock'));
            
            // التحقق من توفر المخزون
            if (quantity > maxStock) {
                showAlert('error', `الكمية المطلوبة (${quantity}) غير متوفرة في المخزون. المتوفر حالياً: ${maxStock}`);
                return;
            }
            
            qtyInput.val(quantity);
            
            // تغيير شكل الحقل ليظهر أنه قيد التحديث
            qtyInput.addClass('text-primary');
            
            $.ajax({
                url: '{{ url("/cart") }}/' + itemId,
                type: 'PUT',
                data: {
                    quantity: quantity
                },
                success: function(response) {
                    // تحديث المعلومات في الواجهة
                    $('.cart-count').text(response.cart_count);
                    $('.cart-total').text(response.cart_total + ' ر.س');
                    $(`tr[data-id="${itemId}"] .item-total`).text(response.item_total + ' ر.س');
                    
                    // إزالة تأثير التحديث
                    qtyInput.removeClass('text-primary');
                    
                    // عرض رسالة نجاح
                    showAlert('success', 'تم تحديث سلة التسوق');
                    
                    console.log('تم تحديث الكمية بنجاح', response);
                },
                error: function(xhr) {
                    // إعادة القيمة القديمة في حالة الخطأ
                    qtyInput.val(qtyInput.data('original-value'));
                    qtyInput.removeClass('text-primary');
                    
                    let errorMessage = 'حدث خطأ أثناء تحديث الكمية';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    showAlert('error', errorMessage);
                    console.error('خطأ في تحديث الكمية', xhr);
                }
            });
        }
        
        // تحديث الكمية من حقل الإدخال
        function updateQuantityFromInput(input, itemId) {
            // تحديث الكمية فقط عندما يكون الإدخال صالحاً
            const quantity = parseInt(input.value);
            const maxStock = parseInt($(input).data('max-stock'));
            const container = $(input).closest('.relative');
            
            // التأكد من أن القيمة صالحة وليست أقل من 1
            if (isNaN(quantity) || quantity < 1) {
                return;
            }
            
            // التحقق من توفر المخزون عند كتابة الكمية
            if (quantity > maxStock) {
                showAlert('error', `الكمية المطلوبة (${quantity}) غير متوفرة في المخزون. المتوفر حالياً: ${maxStock}`);
                
                // إعادة تعيين القيمة إلى الحد الأقصى المتاح أو القيمة السابقة
                setTimeout(() => {
                    input.value = Math.min(maxStock, $(input).data('original-value'));
                }, 100);
                return;
            }
            
            // إضافة مؤشر الانتظار عند التعديل
            $(input).addClass('text-primary');
            
            // إزالة مؤشر انتظار قديم إن وجد
            $('.waiting-update-indicator').remove();
            
            // إضافة مؤشر انتظار جديد في مكان مناسب (خارج سياق حقل الإدخال)
            const waitingMessage = `<div class="waiting-update-indicator fixed bottom-4 left-4 bg-gray-800 text-blue-400 py-2 px-4 rounded-lg shadow-lg z-50">
                <i class="ri-time-line ml-1"></i>
                <span>جارٍ تحديث الكمية... (${quantity})</span>
            </div>`;
            $('body').append(waitingMessage);
            
            // إضافة تأخير 3 ثواني للتحديث عند الكتابة
            clearTimeout(input.timer);
            input.timer = setTimeout(() => {
                // إزالة مؤشر الانتظار
                $('.waiting-update-indicator').remove();
                updateQuantity(itemId, quantity);
            }, 3000); // تم تعديل التأخير إلى 3000 مللي ثانية (3 ثواني)
        }
        
        // إزالة منتج من السلة
        function removeItem(itemId) {
            if (!confirm('هل أنت متأكد من رغبتك في حذف هذا المنتج من السلة؟')) return;
            
            // إضافة تأثير بصري فوري
            $(`tr[data-id="${itemId}"]`).css('opacity', '0.5');
            
            $.ajax({
                url: '{{ url("/cart") }}/' + itemId,
                type: 'DELETE',
                success: function(response) {
                    // إزالة الصف من الجدول
                    $(`tr[data-id="${itemId}"]`).fadeOut(300, function() {
                        $(this).remove();
                        
                        // إذا كانت السلة فارغة الآن، أعد تحميل الصفحة
                        if (response.cart_count === 0) {
                            location.reload();
                        }
                    });
                    
                    // تحديث المجاميع
                    $('.cart-count').text(response.cart_count);
                    $('.cart-total').text(response.cart_total + ' ر.س');
                    
                    // عرض رسالة نجاح
                    showAlert('success', 'تم حذف المنتج من السلة');
                    console.log('تم حذف المنتج بنجاح', response);
                },
                error: function(xhr) {
                    // إعادة العنصر إلى حالته الطبيعية في حال الخطأ
                    $(`tr[data-id="${itemId}"]`).css('opacity', '1');
                    
                    let errorMessage = 'حدث خطأ أثناء حذف المنتج';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    showAlert('error', errorMessage);
                    console.error('خطأ في حذف المنتج', xhr);
                }
            });
        }
        
        // تفريغ السلة
        function clearCart() {
            if (!confirm('هل أنت متأكد من رغبتك في تفريغ سلة التسوق بالكامل؟')) return;
            
            $.ajax({
                url: '{{ url("/cart") }}',
                type: 'DELETE',
                success: function(response) {
                    // إعادة تحميل الصفحة
                    location.reload();
                    console.log('تم تفريغ السلة بنجاح', response);
                },
                error: function(xhr) {
                    let errorMessage = 'حدث خطأ أثناء تفريغ السلة';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    showAlert('error', errorMessage);
                    console.error('خطأ في تفريغ السلة', xhr);
                }
            });
        }
        
        // عرض تنبيه
        function showAlert(type, message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'fixed top-5 right-5 z-50 p-4 rounded-lg shadow-lg flex items-center glass-effect max-w-md transform transition-transform duration-300 translate-x-full';
            alertDiv.role = 'alert';
            
            if (type === 'success') {
                alertDiv.classList.add('bg-gradient-to-r', 'from-green-500', 'to-green-600', 'text-white');
                alertDiv.innerHTML = `
                    <i class="ri-check-line text-xl ml-3"></i>
                    <div>${message}</div>
                    <button type="button" class="text-white hover:text-gray-200 mr-auto" onclick="this.parentElement.remove()">
                        <i class="ri-close-line"></i>
                    </button>
                `;
            } else if (type === 'error') {
                alertDiv.classList.add('bg-gradient-to-r', 'from-red-500', 'to-red-600', 'text-white');
                alertDiv.innerHTML = `
                    <i class="ri-error-warning-line text-xl ml-3"></i>
                    <div>${message}</div>
                    <button type="button" class="text-white hover:text-gray-200 mr-auto" onclick="this.parentElement.remove()">
                        <i class="ri-close-line"></i>
                    </button>
                `;
            }
            
            document.body.appendChild(alertDiv);
            
            // تأخير صغير ثم إظهار الإشعار بتأثير انزلاق
            setTimeout(() => {
                alertDiv.classList.remove('translate-x-full');
            }, 10);
            
            // إزالة التنبيه بعد 3 ثوانِ
            setTimeout(() => {
                alertDiv.classList.add('translate-x-full');
                setTimeout(() => {
                    alertDiv.remove();
                }, 300);
            }, 3000);
        }

        // إعدادات إضافية عند تحميل الصفحة
        $(document).ready(function() {
            // حفظ القيم الأصلية
            $('input[type="number"]').each(function() {
                $(this).data('original-value', $(this).val());
                
                // إضافة تأثير عند التركيز على حقل الكمية
                $(this).focus(function() {
                    $(this).closest('.relative').addClass('border-primary');
                    $(this).addClass('bg-[#15141f]/50'); // إضافة خلفية عند التركيز
                }).blur(function() {
                    $(this).closest('.relative').removeClass('border-primary');
                    $(this).removeClass('bg-[#15141f]/50'); // إزالة الخلفية عند فقد التركيز
                });
                
                // إضافة تأثير على حقل الإدخال عند التحويم
                $(this).hover(
                    function() {
                        // عند تحويم المؤشر
                        $(this).addClass('bg-[#15141f]/30');
                        $(this).css('cursor', 'text'); // تغيير شكل المؤشر
                    },
                    function() {
                        // عند مغادرة المؤشر
                        if (!$(this).is(':focus')) {
                            $(this).removeClass('bg-[#15141f]/30');
                        }
                    }
                );
            });
            
            // تمكين إرسال كود الخصم بالضغط على Enter
            $('#coupon_code').on('keypress', function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    applyCoupon();
                }
            });
        });
    </script>
</body>

</html> 