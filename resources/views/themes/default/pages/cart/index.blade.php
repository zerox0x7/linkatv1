@extends('theme::layouts.app')

@section('title', 'سلة التسوق - ' . config('app.name'))

@push('styles')
<style>
    /* إخفاء أسهم الزيادة والنقصان في حقول الإدخال الرقمية */
    .no-spinners::-webkit-outer-spin-button,
    .no-spinners::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .no-spinners {
        -moz-appearance: textfield;
    }
</style>
@endpush

@section('content')
<style>
.rounded-r-lg {
    border-top-right-radius: 0px;
    border-bottom-right-radius: 0px;
}

</style>
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumbs -->
    <div class="flex items-center text-sm text-gray-400 mb-6">
        <a href="{{ route('home') }}" class="hover:text-primary">الرئيسية</a>
        <i class="ri-arrow-left-s-line mx-2"></i>
        <span class="text-gray-300">سلة التسوق</span>
    </div>

    <h1 class="text-3xl font-bold text-white mb-6">سلة التسوق</h1>
    
    <!-- Flash Message para mostrar cuando se agrega un producto exitosamente -->
    @if(session('success'))
    <div class="bg-green-600 bg-opacity-20 border border-green-600 text-green-100 px-4 py-3 rounded mb-6" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <!-- CSRF Token for AJAX Requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
                                        
                                        <!-- عرض الخدمة المطلوبة (التنسيق القديم) -->
                                        @if(isset($item->options['selected_option_name']) || isset($item->options['selected_price_option']))
                                        <div class="mt-1 text-xs text-gray-400">
                                            <div class="bg-blue-900/30 p-2 rounded-md border border-blue-800/50 mt-2">
                                                <span class="block font-medium mb-1 text-blue-400">الخدمة المطلوبة:</span>
                                                <div class="flex items-center">
                                                    <span class="ml-2 text-blue-300">{{ $item->options['selected_option_name'] ?? 'خدمة مخصصة' }}</span>
                                                    @if(isset($item->options['selected_price']))
                                                    <span class="text-green-400">({{ $item->options['selected_price'] }} ر.س)</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <!-- عرض البيانات المخصصة الأخرى -->
                                        @php
                                            $fieldsToIgnore = ['selected_price_option', 'selected_option_name', 'selected_price', 
                                                            'other_options', 'custom_fields_data', 'custom_data', 'quantity', 
                                                            'id', 'product_id', 'player_data', 'service_option'];
                                            $customDataFound = false;
                                        @endphp
                                        
                                        @if(isset($item->options) && is_array($item->options))
                                            @foreach($item->options as $key => $value)
                                                @if(!in_array($key, $fieldsToIgnore) && !empty($value))
                                                    @php $customDataFound = true; @endphp
                                                @endif
                                            @endforeach
                                        @endif
                                        
                                        @if($customDataFound)
                                        <div class="mt-1 text-xs text-gray-400">
                                            <div class="bg-yellow-900/30 p-2 rounded-md border border-yellow-800/50 mt-2">
                                                <span class="block font-medium mb-1 text-yellow-400">بيانات إضافية:</span>
                                                <ul class="space-y-1">
                                                    @if(isset($item->options) && is_array($item->options))
                                                        @foreach($item->options as $key => $value)
                                                            @if(!in_array($key, $fieldsToIgnore) && !empty($value))
                                                                <li>
                                                                    <span class="font-medium text-yellow-300">{{ $key }}:</span>
                                                                    @if(is_array($value))
                                                                        @if(isset($value['name']) && isset($value['price']))
                                                                            {{ $value['name'] }} - {{ $value['price'] }} ر.س
                                                                        @elseif(isset($value['label']) && isset($value['value']))
                                                                            {{ $value['label'] }}: {{ $value['value'] }}
                                                                        @else
                                                                            {{ implode(', ', array_map(function($v) { return is_array($v) ? '' : $v; }, $value)) }}
                                                                        @endif
                                                                    @else
                                                                        {{ $value }}
                                                                    @endif
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </ul>
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
                    <div class="border-b border-gray-700 pb-4">
                        <div class="flex items-center mb-3">
                            <h3 class="text-white font-medium flex items-center">
                                <i class="ri-coupon-3-line ml-2 text-lg"></i>
                                هل لديك كود خصم؟
                            </h3>
                        </div>
                        @if(session('coupon'))
                            <div class="bg-primary/10 p-3 rounded-lg border border-primary/30">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-white">{{ session('coupon')['code'] }}</span>
                                        <span class="text-primary block text-sm">خصم: {{ session('coupon')['discount'] }} ر.س</span>
                                    </div>
                                    <button type="button" onclick="removeCoupon()" class="text-red-400 hover:text-red-300 remove-coupon-btn">
                                        <i class="ri-close-line text-xl"></i>
                                    </button>
                                </div>
                            </div>
                        @else
                            <div>
                                <div class="flex">
                                    <input type="text" id="coupon_code" class="flex-1 bg-[#1a1a1a] border border-gray-700 rounded-r-none p-2 text-white focus:ring-primary focus:border-primary" placeholder="أدخل كود الخصم">
                                    <button type="button" onclick="applyCoupon()" class="bg-gradient-to-r from-blue-500 to-purple-600 hover:opacity-90 text-white px-4 py-2 rounded-l-none rounded-r-lg transition-colors">
                                        تطبيق الخصم
                                    </button>
                                </div>
                                <div id="coupon-message" class="mt-2 text-xs text-red-400 hidden"></div>
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
                    <a href="{{ route('checkout.index') }}" class="block w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-3 rounded-button font-medium text-center hover:opacity-90 transition-all">
                        <i class="ri-secure-payment-line ml-2"></i> متابعة الشراء
                    </a>
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
</div>
@endsection

@push('scripts')
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
        messageDiv.removeClass('hidden');
        
        if (type === 'success') {
            messageDiv.removeClass('text-red-400').addClass('text-green-400');
        } else if (type === 'error') {
            messageDiv.removeClass('text-green-400').addClass('text-red-400');
        } else if (type === 'loading') {
            messageDiv.removeClass('text-green-400 text-red-400').addClass('text-blue-400');
        }
        
        if (type === 'loading') {
            messageDiv.html(`<i class="ri-loader-4-line animate-spin ml-1"></i> ${message}`);
        } else {
            messageDiv.text(message);
        }
    }
    
    // تطبيق كود الخصم
    function applyCoupon() {
        const couponCode = $('#coupon_code').val().trim();
        if (!couponCode) {
            showCouponMessage('error', 'يرجى إدخال كود الخصم');
            return;
        }
        
        // تعطيل الزر وإظهار حالة التحميل
        const applyButton = $('#coupon_code').next('button');
        applyButton.prop('disabled', true).addClass('opacity-70');
        applyButton.html(`<i class="ri-loader-4-line animate-spin ml-1"></i> جارٍ التطبيق`);
        
        // عرض رسالة تحميل
        showCouponMessage('loading', 'جارِ التحقق من الكود...');
        
        $.ajax({
            url: '{{ route("cart.apply-coupon") }}',
            type: 'POST',
            data: {
                code: couponCode
            },
            success: function(response) {
                applyButton.prop('disabled', false).removeClass('opacity-70');
                applyButton.text('تطبيق الخصم');
                if (response.success) {
                    location.reload();
                } else {
                    showCouponMessage('error', response.message || 'حدث خطأ أثناء تطبيق الكود');
                }
            },
            error: function(xhr) {
                applyButton.prop('disabled', false).removeClass('opacity-70');
                applyButton.text('تطبيق الخصم');
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
    
    // عرض رسالة متعلقة بكود الخصم
    function showCouponMessage(type, message) {
        const messageDiv = $('#coupon-message');
        messageDiv.removeClass('hidden text-green-400 text-red-400 text-blue-400');
        
        if (type === 'success') {
            messageDiv.addClass('text-green-400');
            messageDiv.html(`<i class="ri-check-line ml-1"></i> ${message}`);
        } else if (type === 'error') {
            messageDiv.addClass('text-red-400');
            messageDiv.html(`<i class="ri-error-warning-line ml-1"></i> ${message}`);
        } else if (type === 'loading') {
            messageDiv.addClass('text-blue-400');
            messageDiv.html(`<i class="ri-loader-4-line animate-spin ml-1"></i> ${message}`);
        }
        
        messageDiv.removeClass('hidden');
    }
    
    // حفظ القيم الأصلية للكميات وإضافة معالجة الأحداث 
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
        
        // تركيز تلقائي في حقل كود الخصم عند النقر على القسم
        $('.border-b.border-gray-700.pb-4').eq(1).on('click', function(e) {
            if (!$(e.target).is('button, input')) {
                $('#coupon_code').focus();
            }
        });
        
        // إزالة تلميح الكمية المتوفرة للسماح بالكتابة بشكل أفضل
        // بدلاً من ذلك، سيظهر فقط عند النقر على الأزرار
        
        // عرض رسالة توضيحية في حالة وجود خطأ في أي من وظائف السلة
        console.log('صفحة السلة جاهزة - تأكد من تحميل jQuery وعمل CSRF token');
    });
    
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
</script>
@endpush 