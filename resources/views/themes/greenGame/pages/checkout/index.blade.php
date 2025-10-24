<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إتمام الطلب - {{ $store->store_name ?? config('app.name') }}</title>
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

    /* Checkout specific styles */
    .glass-effect {
        background: rgba(30, 41, 59, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
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
            <a href="{{ route('cart.index') }}" class="hover:text-primary">سلة التسوق</a>
            <i class="ri-arrow-left-s-line mx-2"></i>
            <span class="text-gray-300">إتمام الطلب</span>
        </div>

        <h1 class="text-3xl font-bold text-white mb-6">إتمام الطلب</h1>
        
        @if(session('error'))
            <div class="bg-red-600 bg-opacity-20 border border-red-600 text-red-100 px-4 py-3 rounded mb-6" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- معلومات الطلب -->
            <div class="lg:col-span-2">
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    
                    <!-- طريقة الدفع -->
                    <div class="glass-effect rounded-lg p-6 mb-6">
                        <h2 class="text-xl font-bold text-white mb-4">اختر طريقة الدفع</h2>
                        
                        <div class="space-y-4">
                            @forelse($paymentMethods as $method)
                                <div class="flex items-center p-4 border rounded-lg @if(old('payment_method') == $method->code) border-primary bg-gray-800 @else border-gray-700 bg-gray-900/50 @endif hover:border-primary transition-all cursor-pointer">
                                    <input type="radio" name="payment_method" id="{{ $method->code }}" value="{{ $method->code }}" class="h-5 w-5 text-primary" @if(old('payment_method') == $method->code || $loop->first) checked @endif required>
                                    <label for="{{ $method->code }}" class="mr-3 flex flex-grow items-center cursor-pointer">
                                        @if($method->logo)
                                            <img src="{{ asset('storage/' . $method->logo) }}" alt="{{ $method->name }}" class="h-8 ml-3">
                                        @else
                                            <div class="text-primary text-2xl ml-2">
                                                @if($method->code == 'credit_card')
                                                    <i class="ri-bank-card-line"></i>
                                                @elseif($method->code == 'clickpay')
                                                    <i class="ri-secure-payment-line"></i>
                                                @elseif($method->code == 'bank_transfer')
                                                    <i class="ri-bank-line"></i>
                                                @elseif($method->code == 'balance')
                                                    <i class="ri-wallet-3-line"></i>
                                                @else
                                                    <i class="ri-money-dollar-circle-line"></i>
                                                @endif
                                            </div>
                                        @endif
                                        <div>
                                            <span class="text-white font-medium">{{ $method->name }}</span>
                                            @if($method->description)
                                                <span class="text-gray-400 text-sm block">{{ $method->description }}</span>
                                            @endif
                                        </div>
                                        @if($method->code == 'balance')
                                            <span class="text-primary text-sm mr-auto font-bold">رصيدك: {{ auth()->user()->balance ?? 0 }} ر.س</span>
                                        @endif
                                    </label>
                                </div>
                            @empty
                                <div class="bg-yellow-900/20 border-r-4 border-yellow-500 p-4 rounded-lg">
                                    <div class="flex">
                                        <div class="flex-shrink-0 text-yellow-500 text-xl ml-3">
                                            <i class="ri-alert-line"></i>
                                        </div>
                                        <div>
                                            <p class="text-yellow-200">
                                                لا توجد طرق دفع متاحة حالياً. يرجى التواصل مع إدارة الموقع.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    
                    <!-- زر إتمام الطلب -->
                    <div class="mt-6">
                        <button type="submit" class="w-full bg-gradient-to-r from-primary to-secondary text-white px-6 py-3 rounded-button font-medium text-center hover:opacity-90 transition-all">
                            <i class="ri-secure-payment-line ml-2"></i> إتمام الطلب
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- ملخص الطلب -->
            <div class="lg:col-span-1">
                <div class="glass-effect rounded-lg p-6">
                    <h2 class="text-xl font-bold text-white mb-4">ملخص الطلب</h2>
                    
                    <div class="space-y-4 divide-y divide-gray-700">
                        @foreach($cart->items as $item)
                            <div class="pt-4 first:pt-0">
                                <div class="flex items-start space-x-4 space-x-reverse">
                                    <div class="w-16 h-16 flex-shrink-0 overflow-hidden rounded-md border border-gray-700 bg-gray-800">
                                        <img src="{{ $item->cartable->image_url ?? asset('images/placeholder.png') }}" 
                                             alt="{{ $item->cartable->name }}" 
                                             class="h-full w-full object-cover object-center">
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-white font-medium">{{ $item->cartable->name }}</h3>
                                        <p class="text-gray-400 text-sm">{{ $item->quantity }} × {{ $item->price }} ر.س</p>
                                        
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
                                        
                                        <!-- عرض الخدمة المطلوبة -->
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
                                    </div>
                                    <div class="text-white font-medium">
                                        {{ $item->price * $item->quantity }} ر.س
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-6 space-y-4">
                        <div class="flex justify-between border-b border-gray-700 pb-4">
                            <span class="text-gray-300">المجموع</span>
                            <span class="text-white font-medium">{{ $cart->getTotal() }} ر.س</span>
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
                            <span class="text-lg text-primary font-bold total-amount">
                                @if(session('coupon'))
                                    {{ $cart->getTotal() - session('coupon')['discount'] }} ر.س
                                @else
                                    {{ $cart->getTotal() }} ر.س
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
        
        // تحديث طريقة الدفع عند الاختيار
        const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
        paymentMethods.forEach(method => {
            method.addEventListener('change', function() {
                paymentMethods.forEach(m => {
                    const container = m.closest('.border');
                    if (m.checked) {
                        container.classList.add('border-primary', 'bg-gray-800');
                        container.classList.remove('border-gray-700', 'bg-gray-900/50');
                    } else {
                        container.classList.remove('border-primary', 'bg-gray-800');
                        container.classList.add('border-gray-700', 'bg-gray-900/50');
                    }
                });
            });
        });
    </script>
</body>

</html> 