@extends('themes.default.layouts.app')

@section('title', 'تفاصيل الطلب #' . $order->order_number)

@section('head_scripts')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
// تعريف دوال التقييم والنسخ عالمياً لتكون متاحة قبل تحميل عناصر الصفحة
// دوال التقييم
function setRating(itemId, rating) {
    // تعيين قيمة التقييم
    document.getElementById('rating-value-' + itemId).value = rating;
    
    // تحديث مظهر النجوم
    const stars = document.querySelectorAll(`.star-btn[data-item-id="${itemId}"] i`);
    stars.forEach((star, index) => {
        if (index < rating) {
            star.classList.remove('ri-star-line');
            star.classList.add('ri-star-fill');
            star.classList.add('text-yellow-500');
            star.classList.remove('text-gray-400');
        } else {
            star.classList.add('ri-star-line');
            star.classList.remove('ri-star-fill');
            star.classList.remove('text-yellow-500');
            star.classList.add('text-gray-400');
        }
    });
    
    // تحديث نص التقييم
    const ratingTexts = [
        'قم بتقييم هذا المنتج', 
        'سيء', 
        'متوسط',
        'جيد',
        'جيد جداً',
        'ممتاز'
    ];
    document.querySelector(`.rating-text-${itemId}`).textContent = ratingTexts[rating];
    
    // إظهار حقل التعليق
    document.getElementById('review-container-' + itemId).classList.remove('hidden');
    
    // تفعيل زر الإرسال
    const submitButton = document.getElementById('submit-rating-' + itemId);
    submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
    submitButton.disabled = false;
}

function submitRating(itemId) {
    const productId = document.querySelector(`input[name="product_id_${itemId}"]`).value;
    const productType = document.querySelector(`input[name="product_type_${itemId}"]`).value;
    const orderItemId = document.querySelector(`input[name="order_item_id_${itemId}"]`).value;
    const rating = document.getElementById('rating-value-' + itemId).value;
    const review = document.getElementById('review-' + itemId).value;
    
    // تعطيل الزر أثناء الإرسال
    const submitButton = document.getElementById('submit-rating-' + itemId);
    submitButton.disabled = true;
    submitButton.textContent = 'جاري الإرسال...';
    
    // بيانات الطلب
    const requestData = {
        product_id: productId,
        product_type: productType,
        order_item_id: orderItemId,
        rating: rating,
        review: review
    };
    
    // محاولة ارسال التقييم عبر المسار المباشر (دون وسيط)
    sendRatingRequest('/product/rate', requestData, submitButton, itemId)
        .catch(error => {
            console.error('فشلت المحاولة الأولى:', error);
            // محاولة ثانية باستخدام مسار بديل
            return sendRatingRequest('/test-product-rate', requestData, submitButton, itemId);
        })
        .catch(error => {
            console.error('فشلت جميع المحاولات:', error);
            
            // عرض رسالة خطأ مناسبة للمستخدم
            let errorMessage = 'حدث خطأ، تعذر إرسال التقييم. حاول مرة أخرى لاحقاً.';
            
            if (error.message.includes('انتهت جلسة')) {
                errorMessage = 'انتهت جلسة العمل، جاري إعادة التوجيه...';
            } else if (error.message.includes('مسار التقييم غير موجود')) {
                errorMessage = 'مسار التقييم غير موجود. يرجى إبلاغ مسؤول النظام.';
            }
            
            submitButton.textContent = errorMessage;
            submitButton.disabled = false;
        });
}

// دالة مساعدة لإرسال طلب التقييم
function sendRatingRequest(url, data, submitButton, itemId) {
    return new Promise((resolve, reject) => {
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                if (response.status === 404) {
                    throw new Error('مسار التقييم غير موجود، يرجى الاتصال بالدعم الفني');
                } else if (response.status === 401 || response.status === 419) {
                    window.location.href = '/login?redirect=' + window.location.pathname;
                    throw new Error('انتهت جلسة العمل، يرجى تسجيل الدخول مرة أخرى');
                } else {
                    throw new Error('حدث خطأ في الاستجابة: ' + response.status);
                }
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // إخفاء النموذج وإظهار رسالة النجاح
                document.getElementById('rating-success-' + itemId).classList.remove('hidden');
                submitButton.textContent = 'تم التقييم';
                
                // إضافة تأثير بصري للتقييم الناجح
                const card = document.getElementById('product-item-' + itemId);
                card.classList.add('border-green-500');
                
                // بعد فترة، إخفاء البطاقة
                setTimeout(() => {
                    card.style.opacity = '0.5';
                    card.style.pointerEvents = 'none';
                }, 2000);
                
                console.log('تم إرسال التقييم بنجاح:', data);
                resolve(data);
            } else {
                // إظهار رسالة الخطأ
                submitButton.textContent = 'حدث خطأ: ' + (data.message || 'حاول مرة أخرى');
                submitButton.disabled = false;
                console.error('خطأ عند إرسال التقييم:', data);
                reject(new Error(data.message || 'حدث خطأ غير معروف'));
            }
        })
        .catch(error => {
            console.error('خطأ في طلب AJAX:', error);
            reject(error);
        });
    });
}

// دوال النسخ
function copySpecificText(textId) {
    const element = document.getElementById(textId);
    if (element) {
        const text = element.textContent.trim();
        copyToClipboard(text, 'تم نسخ النص بنجاح');
    } else {
        showNotification('خطأ: لم يتم العثور على النص');
    }
}

function copyToClipboard(text, message) {
    // استخدام واجهة برمجة التطبيقات clipboard الحديثة
    navigator.clipboard.writeText(text)
        .then(function() {
            // إظهار إشعار نجاح النسخ
            showNotification(message || 'تم نسخ النص بنجاح');
        })
        .catch(function(err) {
            // استخدام الطريقة البديلة في حالة عدم دعم المتصفح
            fallbackCopyTextToClipboard(text, message);
        });
}

function fallbackCopyTextToClipboard(text, message) {
    // إنشاء عنصر textarea مؤقت
    const textArea = document.createElement("textarea");
    textArea.value = text;
    
    // جعله غير مرئي ولكن جزء من الصفحة
    document.body.appendChild(textArea);
    textArea.style.position = "fixed";
    textArea.style.top = "0";
    textArea.style.left = "0";
    textArea.style.width = "2em";
    textArea.style.height = "2em";
    textArea.style.padding = "0";
    textArea.style.border = "none";
    textArea.style.outline = "none";
    textArea.style.boxShadow = "none";
    textArea.style.background = "transparent";
    
    // تحديد النص ونسخه
    textArea.focus();
    textArea.select();
    
    try {
        const successful = document.execCommand('copy');
        showNotification(successful ? (message || 'تم نسخ النص بنجاح') : 'فشل النسخ، حاول مرة أخرى');
    } catch (err) {
        showNotification('فشل النسخ، حاول مرة أخرى');
        console.error('فشل في نسخ النص: ', err);
    }
    
    // إزالة العنصر المؤقت
    document.body.removeChild(textArea);
}

function showNotification(message) {
    // إزالة أي إشعارات سابقة
    const oldNotifications = document.querySelectorAll('.copy-notification');
    oldNotifications.forEach(n => n.remove());
    
    // إنشاء إشعار جديد
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 left-1/2 -translate-x-1/2 bg-green-600 text-white px-4 py-2 rounded shadow-lg z-50 copy-notification';
    notification.textContent = message;
    document.body.appendChild(notification);
    
    // إزالة الإشعار بعد 2 ثانية
    setTimeout(() => {
        notification.remove();
    }, 2000);
}

// دالة بديلة لتحديد النجوم
function rateProduct(element, rating) {
    // العثور على النموذج الأقرب
    const form = element.closest('form.review-form');
    if (!form) return;
    
    // تعيين قيمة التقييم
    const radioInput = form.querySelector(`input[name="rating"][value="${rating}"]`);
    if (radioInput) {
        radioInput.checked = true;
    }
    
    // تحديث مظهر النجوم
    const stars = form.querySelectorAll('.star-icon');
    stars.forEach((star, index) => {
        if (index < rating) {
            star.classList.remove('ri-star-line');
            star.classList.add('ri-star-fill');
            star.classList.add('text-yellow-500');
            star.classList.remove('text-gray-400');
        } else {
            star.classList.add('ri-star-line');
            star.classList.remove('ri-star-fill');
            star.classList.remove('text-yellow-500');
            star.classList.add('text-gray-400');
        }
    });
    
    // تحديث نص التقييم
    const ratingTexts = [
        'قم بتقييم هذا المنتج', 
        'سيء', 
        'متوسط',
        'جيد',
        'جيد جداً',
        'ممتاز'
    ];
    
    const ratingText = form.querySelector('.rating-text');
    if (ratingText) {
        ratingText.textContent = ratingTexts[rating];
    }
}
</script>
@endsection

@section('content')
<div class="container mx-auto px-3 sm:px-4 py-4 sm:py-8">
    <!-- Breadcrumbs -->
    <div class="flex flex-wrap items-center text-xs sm:text-sm text-gray-400 mb-4 sm:mb-6">
        <a href="{{ route('home') }}" class="hover:text-primary">الرئيسية</a>
        <i class="ri-arrow-left-s-line mx-1 sm:mx-2"></i>
        <a href="{{ route('orders.index') }}" class="hover:text-primary">طلباتي</a>
        <i class="ri-arrow-left-s-line mx-1 sm:mx-2"></i>
        <span class="text-gray-300 truncate">تفاصيل الطلب #{{ $order->order_number }}</span>
    </div>

    <div class="mb-4 sm:mb-6">
        <h1 class="text-xl sm:text-2xl font-bold text-white">تفاصيل الطلب <span class="text-primary">#{{ $order->order_number }}</span></h1>
        <p class="text-xs sm:text-sm text-gray-400">تاريخ الطلب: {{ $order->created_at->format('Y-m-d H:i') }}</p>
    </div>

    <!-- حالة الطلب -->
    <div class="glass-effect rounded-lg p-3 sm:p-5 mb-4 sm:mb-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 space-y-3 sm:space-y-0">
            <div>
                <h3 class="text-lg sm:text-xl font-bold text-white mb-1">حالة الطلب</h3>
                @php
                    $statusClasses = [
                        'pending' => 'bg-yellow-600 bg-opacity-20 border-yellow-600 text-yellow-100',
                        'processing' => 'bg-blue-600 bg-opacity-20 border-blue-600 text-blue-100',
                        'completed' => 'bg-green-600 bg-opacity-20 border-green-600 text-green-100',
                        'cancelled' => 'bg-red-600 bg-opacity-20 border-red-600 text-red-100',
                        'payment_failed' => 'bg-red-600 bg-opacity-20 border-red-600 text-red-100',
                        'pending_confirmation' => 'bg-purple-600 bg-opacity-20 border-purple-600 text-purple-100',
                    ];
                    $statusText = [
                        'pending' => 'قيد الانتظار',
                        'processing' => 'قيد المعالجة',
                        'completed' => 'مكتمل',
                        'cancelled' => 'ملغي',
                        'payment_failed' => 'فشل الدفع',
                        'pending_confirmation' => 'بانتظار تأكيد الدفع',
                    ];
                @endphp
                <span class="inline-block py-1 px-2 sm:px-3 rounded border text-xs sm:text-sm {{ $statusClasses[$order->status] ?? 'bg-gray-600 bg-opacity-20 border-gray-600 text-gray-100' }}">
                    {{ $statusText[$order->status] ?? $order->status }}
                </span>
            </div>
            <div>
                <span class="text-white text-sm mr-1 sm:mr-2">حالة الدفع:</span>
                <span class="inline-block py-1 px-2 sm:px-3 rounded border text-xs sm:text-sm {{ $order->payment_status == 'paid' ? 'bg-green-600 bg-opacity-20 border-green-600 text-green-100' : 'bg-yellow-600 bg-opacity-20 border-yellow-600 text-yellow-100' }}">
                    {{ $order->payment_status == 'paid' ? 'مدفوع' : 'غير مدفوع' }}
                </span>
            </div>
            
            <!-- زر إلغاء الطلب -->
            @if($order->status == 'pending' || $order->status == 'pending_confirmation')
            <div class="mt-2 sm:mt-0">
                <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من رغبتك في إلغاء هذا الطلب؟');">
                    @csrf
                    <button type="submit" class="bg-gradient-to-r from-red-600 to-red-700 text-white text-xs sm:text-sm px-3 sm:px-4 py-1.5 sm:py-2 rounded-button flex items-center hover:opacity-90 transition-all">
                        <i class="ri-close-circle-line ml-1 sm:ml-2"></i>إلغاء الطلب
                    </button>
                </form>
            </div>
            @endif
        </div>

        <!-- خط زمني للطلب -->
        <div class="relative mt-6 sm:mt-8">
            <div class="absolute left-0 right-0 top-1/2 -translate-y-1/2 h-1 bg-gray-700"></div>
            <div class="flex justify-between relative z-10">
                <div class="text-center">
                    <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full {{ $order->created_at ? 'bg-primary' : 'bg-gray-700' }} text-white inline-flex items-center justify-center mb-1 sm:mb-2">
                        <i class="ri-checkbox-circle-fill text-xs sm:text-base"></i>
                    </div>
                    <div class="text-[10px] sm:text-xs text-gray-400">الطلب</div>
                </div>
                <div class="text-center">
                    <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full {{ in_array($order->status, ['processing', 'completed']) ? 'bg-primary' : 'bg-gray-700' }} text-white inline-flex items-center justify-center mb-1 sm:mb-2">
                        <i class="ri-checkbox-circle-fill text-xs sm:text-base"></i>
                    </div>
                    <div class="text-[10px] sm:text-xs text-gray-400">المعالجة</div>
                </div>
                <div class="text-center">
                    <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full {{ $order->status == 'completed' ? 'bg-primary' : 'bg-gray-700' }} text-white inline-flex items-center justify-center mb-1 sm:mb-2">
                        <i class="ri-checkbox-circle-fill text-xs sm:text-base"></i>
                    </div>
                    <div class="text-[10px] sm:text-xs text-gray-400">إتمام</div>
                </div>
            </div>
        </div>
    </div>

    <!-- معلومات الطلب الأساسية -->
    <div class="glass-effect rounded-lg p-3 sm:p-5 mb-4 sm:mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2 sm:gap-4">
            <div class="bg-gray-800 bg-opacity-50 p-2 sm:p-3 rounded-lg">
                <p class="text-gray-400 text-xs sm:text-sm mb-0.5 sm:mb-1">رقم الطلب:</p>
                <p class="text-white text-sm sm:text-base font-bold">#{{ $order->id }}</p>
            </div>
            <div class="bg-gray-800 bg-opacity-50 p-3 rounded-lg">
                <p class="text-gray-400 mb-1">تاريخ الطلب:</p>
                <p class="text-white font-bold">{{ $order->created_at->format('Y-m-d H:i') }}</p>
            </div>
            <div class="bg-gray-800 bg-opacity-50 p-3 rounded-lg">
                <p class="text-gray-400 mb-1">طريقة الدفع:</p>
                <p class="text-white font-bold">
                    @php
                        $paymentMethods = [
                            'credit_card' => 'بطاقة ائتمان',
                            'clickpay' => 'كليك باي',
                            'bank_transfer' => 'تحويل بنكي',
                            'cash_on_delivery' => 'الدفع عند الاستلام',
                        ];
                    @endphp
                    {{ $paymentMethods[$order->payment_method] ?? $order->payment_method }}
                </p>
            </div>
        </div>

        <!-- إذا لم يتم الدفع وحالة الطلب معلقة، اعرض أزرار الدفع -->
        @if($order->payment_status !== 'paid' && !in_array($order->status, ['cancelled', 'completed']))
        <div class="mt-6">
            <h4 class="text-white mb-3">إتمام الدفع:</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <a href="{{ route('payment.clickpay', $order->id) }}" class="bg-gradient-to-r from-green-600 to-green-700 text-white text-center py-2 px-4 rounded-button neon-glow flex items-center justify-center hover:opacity-90 transition-all">
                    <i class="ri-bank-card-line ml-2"></i>الدفع بالبطاقة
                </a>
                <a href="{{ route('payment.bank_transfer', $order->id) }}" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white text-center py-2 px-4 rounded-button neon-glow flex items-center justify-center hover:opacity-90 transition-all">
                    <i class="ri-bank-line ml-2"></i>تحويل بنكي
                </a>
            </div>
        </div>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- بيانات الطلب -->
        <div class="glass-effect rounded-lg p-5 md:col-span-3">
            <h3 class="text-xl font-bold text-white mb-4">منتجات الطلب</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-700">
                            <th class="py-3 text-right text-gray-400">المنتج</th>
                            <th class="py-3 text-center text-gray-400">الكمية</th>
                            <th class="py-3 text-center text-gray-400">السعر</th>
                            <th class="py-3 text-center text-gray-400">المجموع</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr class="border-b border-gray-800">
                            <td class="py-4">
                                <div class="flex items-center">
                                    @if($item->orderable->image)
                                    <img src="{{ asset('storage/' . $item->orderable->image) }}" alt="{{ $item->name }}" class="w-12 h-12 rounded object-cover mr-3">
                                    @else
                                    <div class="w-12 h-12 rounded bg-gray-800 flex items-center justify-center mr-3">
                                        <i class="ri-image-line text-gray-500"></i>
                                    </div>
                                    @endif
                                    <div>
                                        <p class="text-white">{{ $item->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $item->orderable_type }}</p>
                                        
                                        @if(isset($item->options) && !empty($item->options))
                                            @if(isset($item->options['selected_option_name']) || isset($item->options['selected_price']))
                                            <div class="mt-2 bg-blue-900 bg-opacity-20 border border-blue-700 rounded p-2 text-xs">
                                                <span class="text-blue-300 font-bold">الخدمة المطلوبة:</span>
                                                <p class="text-blue-100 mt-1">{{ $item->options['selected_option_name'] ?? 'غير محدد' }}</p>
                                                @if(isset($item->options['selected_price']))
                                                <p class="text-green-300 mt-1">سعر الخدمة: {{ $item->options['selected_price'] }} ر.س</p>
                                                @endif
                                            </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 text-center text-white">{{ $item->quantity }}</td>
                            <td class="py-4 text-center text-white">{{ number_format($item->price, 2) }} ر.س</td>
                            <td class="py-4 text-center text-white">{{ number_format($item->price * $item->quantity, 2) }} ر.س</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-900 bg-opacity-50">
                            <td colspan="3" class="py-3 text-left text-white font-bold">المجموع الإجمالي:</td>
                            <td class="py-3 text-center text-white font-bold">{{ number_format($order->total, 2) }} ر.س</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {{-- قسم الحسابات الرقمية (تم نقله هنا) --}}
            @if(isset($accountDigetals) && count($accountDigetals) > 0)
            <div class="glass-effect rounded-lg p-6 mb-6">
                <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                    <i class="ri-user-line text-primary mr-2"></i>
                    الحسابات الرقمية
                </h3>
                <div class="space-y-4">
                    @foreach($accountDigetals as $itemId => $accounts)
                        @foreach($accounts as $account)
                            @php
                                if (is_string($account->meta)) {
                                    $account->meta = json_decode($account->meta, true);
                                }
                                $accountText = '';
                                if (isset($account->meta['lines'])) {
                                    $lines = is_array($account->meta['lines']) ? $account->meta['lines'] : [ $account->meta['lines'] ];
                                    $accountText = implode("\n", $lines);
                                } elseif (isset($account->meta['text'])) {
                                    $accountText = $account->meta['text'];
                                }
                            @endphp
                            <div class="bg-gray-900 border border-primary/30 shadow-lg rounded-2xl p-6 mb-4">
                                <div class="flex justify-between items-center mb-2">
                                    <h4 class="text-lg font-bold text-primary flex items-center">
                                        <i class="ri-user-3-line ml-2"></i>
                                        {{ $order->items->where('id', $itemId)->first()->orderable->name ?? 'حساب رقمي' }}
                                    </h4>
                                    <button onclick="copySpecificText('account-{{ $itemId }}-{{ $account->id }}')"
                                        class="bg-primary/80 hover:bg-primary text-white px-3 py-1 rounded shadow flex items-center gap-1"
                                        title="نسخ كل بيانات الحساب">
                                        <i class="ri-file-copy-line"></i>
                                        <span class="hidden sm:inline">نسخ</span>
                                    </button>
                                </div>
                                <pre id="account-{{ $itemId }}-{{ $account->id }}"
                                    class="bg-gray-900 rounded-2xl p-4 text-primary font-mono text-base leading-relaxed whitespace-pre-line select-all overflow-x-auto border border-primary/10 text-right"
                                    style="min-height: 120px; font-size: 1.05rem; direction:rtl;">
@php
    $lines = explode("\n", $accountText);
@endphp
@foreach($lines as $line)
    @if(preg_match('/^[A-Za-z0-9@.\-_]+/', trim($line)))
<span dir="ltr" style="display:block; text-align:left; direction:ltr;">{{ $line }}</span>
    @else
<span dir="rtl" style="display:block; text-align:right; direction:rtl;">{{ $line }}</span>
    @endif
@endforeach
                                </pre>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
            @endif

            <!-- الأكواد الرقمية إذا وجدت -->
            @if(count($digitalCodes) > 0)
            <div class="mt-8">
                <div class="bg-green-600 bg-opacity-20 border border-green-600 text-green-100 px-6 py-4 rounded-lg mb-6">
                    <div class="flex items-start">
                        <i class="ri-checkbox-circle-line text-3xl mr-4"></i>
                        <div>
                            <h4 class="text-lg font-bold mb-2">تم تسليم المنتجات الرقمية بنجاح!</h4>
                            <p>تم تسليم أكواد البطاقات الرقمية التي قمت بشرائها تلقائياً. يمكنك الاطلاع على الأكواد أدناه.</p>
                            @if($order->status == 'completed')
                            <p class="mt-2">تم اكتمال الطلب تلقائياً نظراً لكونه يحتوي على منتجات رقمية فقط.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                    <i class="ri-key-line text-primary mr-2"></i>
                    الأكواد الرقمية المشتراة
                </h3>
                
                @foreach($digitalCodes as $itemId => $codes)
                    @php
                        $item = $order->items->firstWhere('id', $itemId);
                        $allCodes = [];
                        
                        // Collect all codes with labels for better readability
                        foreach ($codes as $index => $code) {
                            $allCodes[] = "كود #" . ($index + 1) . ": " . $code->code;
                            
                            if (isset($code->serial_number) && $code->serial_number) {
                                $allCodes[] = "الرقم التسلسلي: " . $code->serial_number;
                            }
                            
                            if (!$loop->last) {
                                $allCodes[] = "-------------------";
                            }
                        }
                        
                        $allCodesText = implode("\n", $allCodes);
                    @endphp
                    
                    <div class="mb-6 bg-gray-900 bg-opacity-50 rounded-lg p-5 border-r-4 border-primary">
                        <div class="flex items-center mb-4">
                            @if($item->orderable->image)
                            <img src="{{ asset('storage/' . $item->orderable->image) }}" alt="{{ $item->name }}" class="w-16 h-16 rounded object-cover mr-4">
                            @else
                            <div class="w-16 h-16 rounded bg-gray-800 flex items-center justify-center mr-4">
                                <i class="ri-gamepad-line text-2xl text-gray-500"></i>
                            </div>
                            @endif
                            <div>
                                <h4 class="text-lg font-bold text-white">{{ $item->name }}</h4>
                                <p class="text-gray-400">{{ $item->quantity }} × {{ number_format($item->price, 2) }} ر.س</p>
                                
                                @if(isset($item->options) && !empty($item->options))
                                    @if(isset($item->options['selected_option_name']) || isset($item->options['selected_price']))
                                    <div class="mt-2 bg-blue-900 bg-opacity-20 border border-blue-700 rounded-md p-2 text-sm">
                                        <span class="text-blue-300 font-bold">الخدمة المطلوبة:</span>
                                        <p class="text-blue-100 mt-1">{{ $item->options['selected_option_name'] ?? 'غير محدد' }}</p>
                                    </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                        
                        <!-- عرض جميع الأكواد في قائمة بسيطة -->
                        <div class="bg-gray-800 rounded-lg p-4 border border-gray-700 hover:border-primary transition-all">
                            <div class="flex justify-between items-center mb-3">
                                <p class="text-lg text-gray-300 font-bold">جميع الأكواد ({{ count($codes) }})</p>
                                <button type="button" class="bg-primary hover:bg-primary/80 p-2 rounded ml-2 flex items-center" 
                                        onclick="copyAllCodes_{{ $itemId }}()" 
                                        title="نسخ جميع الأكواد">
                                    <i class="ri-file-copy-line text-white ml-1"></i>
                                    <span class="text-white">نسخ الكل</span>
                                </button>
                            </div>
                            
                            <!-- خط فاصل -->
                            <div class="w-full h-px bg-gray-700 my-3"></div>
                            
                            <!-- قائمة الأكواد -->
                            <div class="space-y-2">
                                @foreach($codes as $index => $code)
                                <div class="flex justify-between items-center bg-gray-900 p-3 rounded-md">
                                    <div class="font-mono text-primary font-bold select-all flex-grow" id="code-{{ $itemId }}-{{ $index }}">{{ $code->code }}</div>
                                    <button type="button" class="bg-gray-700 hover:bg-gray-600 p-2 rounded ml-2" 
                                            onclick="copySpecificText('code-{{ $itemId }}-{{ $index }}')" 
                                            title="نسخ الكود">
                                        <i class="ri-file-copy-line text-gray-300"></i>
                                    </button>
                                </div>
                                
                                @if(isset($code->serial_number) && $code->serial_number)
                                <div class="flex justify-between items-center bg-gray-900 p-3 rounded-md">
                                    <div class="font-mono text-primary font-bold select-all flex-grow" id="serial-{{ $itemId }}-{{ $index }}">{{ $code->serial_number }}</div>
                                    <button type="button" class="bg-gray-700 hover:bg-gray-600 p-2 rounded ml-2" 
                                            onclick="copySpecificText('serial-{{ $itemId }}-{{ $index }}')" 
                                            title="نسخ الرقم التسلسلي">
                                        <i class="ri-file-copy-line text-gray-300"></i>
                                    </button>
                                </div>
                                @endif
                                
                                @if(isset($code->expiry_date) && $code->expiry_date)
                                <div class="text-sm text-gray-400 mb-2">
                                    تاريخ الانتهاء: 
                                    <span class="text-white">
                                        @if(is_object($code->expiry_date) && method_exists($code->expiry_date, 'format'))
                                            {{ $code->expiry_date->format('Y-m-d') }}
                                        @else
                                            {{ $code->expiry_date }}
                                        @endif
                                    </span>
                                </div>
                                @endif
                                
                                <!-- خط فاصل بين الأكواد -->
                                @if(!$loop->last)
                                <div class="w-full h-px bg-gray-700 my-2"></div>
                                @endif
                                @endforeach
                            </div>
                            
                            <!-- خط فاصل -->
                            <div class="w-full h-px bg-gray-700 my-3"></div>
                            
                            <script>
                                // تعريف وظيفة نسخ جميع الأكواد لهذا العنصر فقط في النطاق العالمي
                                window.copyAllCodes_{{ $itemId }} = function() {
                                    let allCodesText = "";
                                    @foreach($codes as $index => $code)
                                        allCodesText += "كود #{{ $index + 1 }}: {{ $code->code }}\n";
                                        @if(isset($code->serial_number) && $code->serial_number)
                                            allCodesText += "الرقم التسلسلي: {{ $code->serial_number }}\n";
                                        @endif
                                        @if(!$loop->last)
                                            allCodesText += "-------------------\n";
                                        @endif
                                    @endforeach
                                    
                                    window.copyToClipboard(allCodesText, 'تم نسخ جميع الأكواد بنجاح');
                                }
                            </script>
                        </div>
                        
                        @if($item->orderable->instructions)
                        <div class="mt-4 bg-blue-900 bg-opacity-20 border border-blue-700 rounded-lg p-4">
                            <h5 class="text-blue-300 font-bold mb-2 flex items-center">
                                <i class="ri-information-line mr-2"></i>
                                تعليمات الاستخدام
                            </h5>
                            <div class="text-blue-100">
                                {!! nl2br(e($item->orderable->instructions)) !!}
                            </div>
                        </div>
                        @endif
                    </div>
                @endforeach
            </div>
            @endif
            
            <!-- بيانات المواصفات المخصصة إذا وجدت -->
            @if($order->has_custom_products)
            <div class="mt-6">
                <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                    <i class="ri-file-list-3-line text-primary mr-2"></i>
                    معرفات العميل والمواصفات المخصصة
                </h3>
                
                <div class="bg-gray-900 bg-opacity-50 rounded-lg p-5 border-r-4 border-primary">
                    @foreach($order->getPlayerIdentifiers() as $item)
                    <div class="mb-4 pb-4 {{ !$loop->last ? 'border-b border-gray-700' : '' }}">
                        <div class="flex justify-between items-start mb-3">
                            <h4 class="text-lg font-bold text-primary">{{ $item['product_name'] }}</h4>
                            @if(isset($item['service']))
                            <div class="bg-blue-900 bg-opacity-20 border border-blue-700 rounded px-3 py-1 text-sm">
                                <span class="text-blue-100">{{ $item['service']['name'] }} - {{ $item['service']['price'] }} ر.س</span>
                            </div>
                            @endif
                        </div>
                        
                        @if(!empty($item['identifiers']))
                        <div class="bg-gray-800 rounded-lg p-4">
                            <h5 class="text-white mb-3">بيانات المستخدم:</h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($item['identifiers'] as $key => $value)
                                <div class="flex">
                                    <span class="w-1/3 text-gray-400">
                                        @if(is_array($value) && isset($value['label']))
                                            {{ $value['label'] }}:
                                        @else
                                            {{ $key }}:
                                        @endif
                                    </span>
                                    <div class="w-2/3 font-mono bg-gray-900 text-primary font-bold p-2 rounded select-all">
                                        @if(is_array($value))
                                            @if(isset($value['value']))
                                                {{ $value['value'] }}
                                            @else
                                                {{ is_array($value) ? implode(', ', array_map(function($v) { return is_array($v) ? json_encode($v) : $v; }, $value)) : $value }}
                                            @endif
                                        @else
                                            {{ $value }}
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- قسم تقييم المنتجات غير المقيمة -->
            @if(isset($unratedItems) && $unratedItems->count() > 0 && $order->status === 'completed')
            <div class="mt-4 sm:mt-6">
                <h3 class="text-lg sm:text-xl font-bold text-white mb-2 sm:mb-4 flex items-center">
                    <i class="ri-star-line text-yellow-500 mr-2"></i>
                    تقييم المنتجات
                </h3>
                
                <div class="bg-gray-800 bg-opacity-50 rounded-lg p-3 sm:p-5">
                    <p class="text-xs sm:text-sm text-gray-300 mb-2 sm:mb-4">قم بتقييم المنتجات التي اشتريتها لمساعدة العملاء الآخرين:</p>
                    
                    <div class="grid grid-cols-1 gap-2 sm:gap-4">
                        @foreach($unratedItems as $item)
                        <div class="border border-gray-700 rounded-lg p-2 sm:p-4 bg-gray-800 bg-opacity-50 hover:border-primary transition product-rating-card" id="product-item-{{ $item->id }}">
                            <div class="flex items-start">
                                <div class="shrink-0 w-16 sm:w-20 h-16 sm:h-20 mb-0 mr-3">
                                    <div class="w-full h-full overflow-hidden rounded-md border border-gray-700 bg-gray-900">
                                        @if($item->orderable && $item->orderable->image)
                                            @php
                                                $imagePath = $item->orderable->image;
                                                if (is_string($imagePath) && !filter_var($imagePath, FILTER_VALIDATE_URL)) {
                                                    $imagePath = asset('storage/' . $imagePath);
                                                }
                                            @endphp
                                            <img src="{{ $imagePath }}" alt="{{ $item->name }}" class="h-full w-full object-cover object-center">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-gray-700 text-gray-300">
                                                <i class="ri-image-line text-xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm sm:text-base font-bold text-white mb-1 sm:mb-2 line-clamp-1">{{ $item->name }}</h4>
                                    
                                    <div class="space-y-2">
                                        <!-- استخدام نموذج HTML مباشر بدل AJAX -->
                                        <form action="{{ route('reviews.store') }}" method="POST" class="review-form">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $item->orderable_id }}">
                                            <input type="hidden" name="product_type" value="{{ $item->orderable_type }}">
                                            <input type="hidden" name="order_item_id" value="{{ $item->id }}">
                                            
                                            <div class="mb-3">
                                                <div class="flex items-center flex-wrap mb-2">
                                                    <div class="rating-stars flex mr-2">
                                                        @for($i = 1; $i <= 5; $i++)
                                                        <label class="cursor-pointer p-0.5 sm:p-1 hover:scale-110 transition-transform" title="تقييم {{ $i }} من 5" onclick="rateProduct(this, {{ $i }})">
                                                            <input type="radio" name="rating" value="{{ $i }}" class="sr-only rating-input">
                                                            <i class="ri-star-line text-lg sm:text-xl text-gray-400 hover:text-yellow-500 star-icon"></i>
                                                        </label>
                                                        @endfor
                                                    </div>
                                                    <div class="text-xs sm:text-sm text-gray-400 rating-text mt-1 sm:mt-0">
                                                        قم بتقييم المنتج
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <textarea 
                                                    name="comment" 
                                                    class="w-full bg-gray-900 border border-gray-700 rounded px-2 py-1 sm:px-3 sm:py-2 text-sm text-white focus:outline-none focus:border-primary"
                                                    placeholder="تعليقك (اختياري)" 
                                                    rows="2"></textarea>
                                            </div>
                                            
                                            <button 
                                                type="submit" 
                                                class="bg-primary text-white text-xs sm:text-sm px-3 py-1.5 rounded">
                                                إرسال التقييم
                                            </button>
                                            
                                            @if(session('review_success_' . $item->id))
                                            <span class="mr-2 text-xs sm:text-sm text-green-500">
                                                <i class="ri-check-line"></i> {{ session('review_success_' . $item->id) }}
                                            </span>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            
            <!-- قسم التقييمات الموجودة -->
            @if(isset($ratedItems) && $ratedItems->count() > 0)
            <div class="mt-6">
                <h3 class="text-lg sm:text-xl font-bold text-white mb-4 flex items-center">
                    <i class="ri-star-fill text-yellow-500 mr-2"></i>
                    تقييماتك للمنتجات
                </h3>
                
                <div class="bg-gray-800 bg-opacity-50 rounded-lg p-3 sm:p-5">
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($ratedItems as $item)
                        <div class="border border-gray-700 rounded-lg p-3 sm:p-4 bg-gray-900 bg-opacity-70">
                            <div class="flex items-start">
                                <div class="shrink-0 w-16 sm:w-20 h-16 sm:h-20 mb-0 mr-3">
                                    <div class="w-full h-full overflow-hidden rounded-md border border-gray-700 bg-gray-900">
                                        @if($item->orderable && $item->orderable->image)
                                            @php
                                                $imagePath = $item->orderable->image;
                                                if (is_string($imagePath) && !filter_var($imagePath, FILTER_VALIDATE_URL)) {
                                                    $imagePath = asset('storage/' . $imagePath);
                                                }
                                            @endphp
                                            <img src="{{ $imagePath }}" alt="{{ $item->name }}" class="h-full w-full object-cover object-center">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-gray-700 text-gray-300">
                                                <i class="ri-image-line text-xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm sm:text-base font-bold text-white mb-1 sm:mb-2 line-clamp-1">{{ $item->name }}</h4>
                                    
                                    @if($item->review)
                                    <div class="mb-2">
                                        <div class="flex items-center mb-2">
                                            <div class="flex items-center">
                                                @for($i = 1; $i <= 5; $i++)
                                                <i class="{{ $i <= $item->review->rating ? 'ri-star-fill text-yellow-500' : 'ri-star-line text-gray-400' }} text-lg"></i>
                                                @endfor
                                            </div>
                                            <div class="text-yellow-400 mr-2 text-sm">
                                                {{ $item->review->rating }}/5
                                            </div>
                                            <div class="text-xs text-gray-400">
                                                {{ $item->review->created_at->format('Y-m-d') }}
                                            </div>
                                        </div>
                                        
                                        @if($item->review->comment)
                                        <div class="bg-gray-800 rounded-lg p-3 border border-gray-700">
                                            <p class="text-gray-300 text-sm">{{ $item->review->comment }}</p>
                                        </div>
                                        @endif
                                    </div>
                                    @else
                                    <p class="text-sm text-gray-400">تم تقييم هذا المنتج لكن لم يتم العثور على تفاصيل التقييم.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// تفعيل النجوم في نماذج التقييم المباشرة
document.addEventListener('DOMContentLoaded', function() {
    // تحديد جميع نماذج التقييم
    const reviewForms = document.querySelectorAll('.review-form');
    
    reviewForms.forEach(form => {
        // العثور على النجوم في هذا النموذج
        const stars = form.querySelectorAll('.rating-input');
        const starLabels = form.querySelectorAll('.cursor-pointer');
        const starIcons = form.querySelectorAll('.star-icon');
        const ratingText = form.querySelector('.rating-text');
        
        // تعريف نصوص التقييم
        const ratingTexts = [
            'قم بتقييم هذا المنتج', 
            'سيء', 
            'متوسط',
            'جيد',
            'جيد جداً',
            'ممتاز'
        ];
        
        // إضافة مستمعي النقر لكل أيقونة نجمة
        starLabels.forEach((label, index) => {
            label.addEventListener('click', function() {
                // تحديد النجمة المقابلة
                const radio = stars[index];
                radio.checked = true;
                
                const rating = radio.value;
                
                // تحديث مظهر النجوم
                starIcons.forEach((icon, i) => {
                    if (i < rating) {
                        icon.classList.remove('ri-star-line');
                        icon.classList.add('ri-star-fill');
                        icon.classList.add('text-yellow-500');
                        icon.classList.remove('text-gray-400');
                    } else {
                        icon.classList.add('ri-star-line');
                        icon.classList.remove('ri-star-fill');
                        icon.classList.remove('text-yellow-500');
                        icon.classList.add('text-gray-400');
                    }
                });
                
                // تحديث نص التقييم
                if (ratingText) {
                    ratingText.textContent = ratingTexts[rating];
                }
            });
        });
        
        // التحقق من اختيار تقييم قبل الإرسال
        form.addEventListener('submit', function(e) {
            const selectedRating = form.querySelector('input[name="rating"]:checked');
            
            if (!selectedRating) {
                e.preventDefault();
                alert('الرجاء اختيار تقييم (عدد النجوم) قبل الإرسال');
            }
        });
    });
});

// تعريف وظائف النسخ في نطاق عالمي
window.copyToClipboard = function(text, message) {
    // استخدام واجهة برمجة التطبيقات clipboard الحديثة
    navigator.clipboard.writeText(text)
        .then(function() {
            // إظهار إشعار نجاح النسخ
            window.showNotification(message || 'تم نسخ النص بنجاح');
        })
        .catch(function(err) {
            // استخدام الطريقة البديلة في حالة عدم دعم المتصفح
            window.fallbackCopyTextToClipboard(text, message);
        });
}

// وظيفة نسخ نص من عنصر محدد بالصفحة
window.copySpecificText = function(textId) {
    const element = document.getElementById(textId);
    if (element) {
        const text = element.textContent.trim();
        window.copyToClipboard(text, 'تم نسخ النص بنجاح');
    } else {
        window.showNotification('خطأ: لم يتم العثور على النص');
    }
}

// طريقة بديلة للنسخ تعمل في المتصفحات القديمة
window.fallbackCopyTextToClipboard = function(text, message) {
    // إنشاء عنصر textarea مؤقت
    const textArea = document.createElement("textarea");
    textArea.value = text;
    
    // جعله غير مرئي ولكن جزء من الصفحة
    document.body.appendChild(textArea);
    textArea.style.position = "fixed";
    textArea.style.top = "0";
    textArea.style.left = "0";
    textArea.style.width = "2em";
    textArea.style.height = "2em";
    textArea.style.padding = "0";
    textArea.style.border = "none";
    textArea.style.outline = "none";
    textArea.style.boxShadow = "none";
    textArea.style.background = "transparent";
    
    // تحديد النص ونسخه
    textArea.focus();
    textArea.select();
    
    try {
        const successful = document.execCommand('copy');
        window.showNotification(successful ? (message || 'تم نسخ النص بنجاح') : 'فشل النسخ، حاول مرة أخرى');
    } catch (err) {
        window.showNotification('فشل النسخ، حاول مرة أخرى');
        console.error('فشل في نسخ النص: ', err);
    }
    
    // إزالة العنصر المؤقت
    document.body.removeChild(textArea);
}

// وظيفة عرض الإشعارات
window.showNotification = function(message) {
    // إزالة أي إشعارات سابقة
    const oldNotifications = document.querySelectorAll('.copy-notification');
    oldNotifications.forEach(n => n.remove());
    
    // إنشاء إشعار جديد
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 left-1/2 -translate-x-1/2 bg-green-600 text-white px-4 py-2 rounded shadow-lg z-50 copy-notification';
    notification.textContent = message;
    document.body.appendChild(notification);
    
    // إزالة الإشعار بعد 2 ثانية
    setTimeout(() => {
        notification.remove();
    }, 2000);
}

// الدوال تم نقلها إلى النطاق العالمي في بداية الملف
// وظيفة نسخ النصوص تم الاحتفاظ بها
</script>
@endsection 