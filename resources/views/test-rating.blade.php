@extends('themes.default.layouts.app')

@section('title', 'اختبار نظام التقييم')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="glass-effect rounded-lg p-5 mb-6">
        <h2 class="text-2xl font-bold text-white mb-4">اختبار نظام التقييم</h2>
        <!-- إضافة توضيح للمستخدم -->
        <div class="bg-blue-900 bg-opacity-20 border border-blue-700 rounded-lg p-3 mb-4">
            <p class="text-blue-100">
                <i class="ri-information-line ml-2"></i>
                انقر على النجوم لتحديد تقييمك من 1 إلى 5 نجوم، ثم اكتب تعليقًا اختياريًا وانقر على زر "إرسال التقييم".
            </p>
        </div>
        
        <div class="bg-gray-800 bg-opacity-50 rounded-lg p-5">
            <!-- اختيار المنتج للتقييم -->
            <div class="w-full mb-5">
                <label class="block text-gray-300 mb-2">اختر المنتج للتقييم</label>
                <div class="flex flex-wrap gap-4">
                    <div class="w-full md:w-1/2">
                        <select id="product-select" class="w-full bg-gray-900 border border-gray-700 rounded px-3 py-2 text-white focus:outline-none focus:border-primary">
                            <option value="">-- اختر منتج --</option>
                            @if(isset($products) && count($products) > 0)
                                <optgroup label="المنتجات">
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-type="App\Models\Product">{{ $product->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endif
                            @if(isset($digitalCards) && count($digitalCards) > 0)
                                <optgroup label="البطاقات الرقمية">
                                    @foreach($digitalCards as $card)
                                    <option value="{{ $card->id }}" data-type="App\Models\DigitalCard">{{ $card->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endif
                        </select>
                    </div>
                    <input type="hidden" name="product_id" id="product_id" value="">
                    <input type="hidden" name="product_type" id="product_type" value="">
                    <input type="hidden" name="order_item_id" id="order_item_id" value="{{ $orderItemId ?? 1 }}">
                    <input type="hidden" name="rating" id="rating-value" value="0">
                    <!-- إضافة قيمة CSRF مخفية -->
                    <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}">
                </div>
            </div>
            
            <div class="w-full mb-3" id="rating-container">
                <label class="block text-gray-300 mb-2">قيمنا هذا المنتج</label>
                <div class="rating-stars-container flex items-center">                    
                    <div class="rating-stars flex">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button" class="star-btn p-1" 
                                data-rating="{{ $i }}" 
                                id="star-btn-{{ $i }}">
                            <i class="ri-star-line text-2xl text-gray-400 hover:text-yellow-500"></i>
                        </button>
                        @endfor
                    </div>
                    
                    <div class="ml-2 text-sm text-gray-400 rating-text">
                        قم بتقييم هذا المنتج
                    </div>
                </div>
            </div>
            
            <div class="w-full mb-3 hidden" id="review-container">
                <label class="block text-gray-300 mb-2">أضف تعليقك (اختياري)</label>
                <textarea 
                    id="review" 
                    class="w-full bg-gray-900 border border-gray-700 rounded px-3 py-2 text-white focus:outline-none focus:border-primary"
                    placeholder="اكتب تعليقك حول المنتج (اختياري)" 
                    rows="3"></textarea>
            </div>
            
            <div class="w-full mt-4">
                <button 
                    type="button" 
                    id="submit-rating" 
                    class="bg-primary text-white px-6 py-2 rounded disabled:opacity-50 disabled:cursor-not-allowed" 
                    disabled>
                    إرسال التقييم
                </button>
                
                <span id="rating-success" class="hidden ml-2 text-green-500">
                    <i class="ri-check-line"></i> تم إرسال تقييمك بنجاح
                </span>
            </div>

            <div class="mt-6">
                <div id="debug-info" class="bg-gray-900 p-4 rounded text-white font-mono text-xs hidden"></div>
                <button
                    type="button" 
                    id="toggle-debug-btn"
                    class="mt-2 bg-gray-700 hover:bg-gray-600 text-white px-3 py-1 rounded text-sm">
                    عرض معلومات التصحيح
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // تحديد العناصر
    const productSelect = document.getElementById('product-select');
    const productIdInput = document.getElementById('product_id');
    const productTypeInput = document.getElementById('product_type');
    const ratingValue = document.getElementById('rating-value');
    const starButtons = document.querySelectorAll('.star-btn');
    const submitButton = document.getElementById('submit-rating');
    const debugInfo = document.getElementById('debug-info');
    const toggleDebugBtn = document.getElementById('toggle-debug-btn');
    
    // إضافة مستمع الحدث للقائمة المنسدلة
    productSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (selectedOption.value) {
            const productId = selectedOption.value;
            const productType = selectedOption.getAttribute('data-type');
            
            productIdInput.value = productId;
            productTypeInput.value = productType;
            
            // إعادة تعيين النجوم
            resetStars();
            
            console.log('تم اختيار المنتج:', { id: productId, type: productType });
        } else {
            productIdInput.value = '';
            productTypeInput.value = '';
        }
    });
    
    // إضافة مستمعي الأحداث للنجوم
    starButtons.forEach(button => {
        button.addEventListener('click', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            setRating(rating);
        });
    });
    
    // إضافة مستمع الحدث لزر الإرسال
    submitButton.addEventListener('click', function() {
        submitRating();
    });
    
    // إضافة مستمع الحدث لزر عرض معلومات التصحيح
    toggleDebugBtn.addEventListener('click', function() {
        toggleDebug();
    });
    
    // إعادة تعيين النجوم
    function resetStars() {
        ratingValue.value = 0;
        
        // إعادة تعيين مظهر النجوم
        const stars = document.querySelectorAll('.star-btn i');
        stars.forEach((star) => {
            star.classList.add('ri-star-line');
            star.classList.remove('ri-star-fill');
            star.classList.remove('text-yellow-500');
            star.classList.add('text-gray-400');
        });
        
        // إعادة تعيين نص التقييم
        document.querySelector('.rating-text').textContent = 'قم بتقييم هذا المنتج';
        
        // إخفاء حقل التعليق
        document.getElementById('review-container').classList.add('hidden');
        document.getElementById('review').value = '';
        
        // تعطيل زر الإرسال
        submitButton.disabled = true;
        
        // إخفاء رسالة النجاح
        document.getElementById('rating-success').classList.add('hidden');
    }
    
    // وظيفة تحديد التقييم
    function setRating(rating) {
        // التحقق من وجود منتج مختار
        if (!productIdInput.value) {
            alert('يرجى اختيار منتج أولاً');
            return;
        }
        
        console.log('تم اختيار تقييم: ' + rating);
        // تعيين قيمة التقييم
        ratingValue.value = rating;
        
        // تحديث مظهر النجوم
        const stars = document.querySelectorAll('.star-btn i');
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
        document.querySelector('.rating-text').textContent = ratingTexts[rating];
        
        // إظهار حقل التعليق
        document.getElementById('review-container').classList.remove('hidden');
        
        // تفعيل زر الإرسال
        submitButton.disabled = false;
    }
    
    // وظيفة إرسال التقييم
    function submitRating() {
        console.log('بدء إرسال التقييم...');
        const productId = productIdInput.value;
        const productType = productTypeInput.value;
        const orderItemId = document.getElementById('order_item_id').value;
        const rating = ratingValue.value;
        const review = document.getElementById('review').value;
        const csrfToken = document.getElementById('csrf-token').value;
        
        // التحقق من وجود منتج مختار
        if (!productId || !productType) {
            alert('يرجى اختيار منتج أولاً');
            return;
        }
        
        // التحقق من قيمة التقييم
        if (rating < 1) {
            alert('يرجى تحديد تقييم من 1 إلى 5 نجوم');
            return;
        }
        
        // بيانات الطلب
        const requestData = {
            product_id: productId,
            product_type: productType,
            order_item_id: orderItemId,
            rating: rating,
            review: review
        };
        
        // إظهار بيانات الطلب في قسم التصحيح
        debugInfo.innerHTML = 'بيانات الطلب: ' + JSON.stringify(requestData, null, 2);
        debugInfo.classList.remove('hidden');
        console.log('بيانات الطلب:', requestData);
        
        // تعطيل الزر أثناء الإرسال
        submitButton.disabled = true;
        submitButton.textContent = 'جاري الإرسال...';
        
        // إرسال البيانات عبر طلب AJAX
        fetch('/debug/test-rating', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(requestData)
        })
        .then(response => {
            // تحديث بيانات التصحيح مع استجابة الخادم
            debugInfo.innerHTML += '<hr>استجابة الخادم (status): ' + response.status;
            console.log('استجابة الخادم:', response.status);
            
            return response.json().then(data => {
                // إضافة بيانات الاستجابة إلى معلومات التصحيح
                debugInfo.innerHTML += '<br>بيانات الاستجابة: ' + JSON.stringify(data, null, 2);
                console.log('بيانات الاستجابة:', data);
                return { status: response.status, data };
            }).catch(err => {
                // إذا لم يكن الرد JSON صالحًا
                debugInfo.innerHTML += '<br>خطأ في تفسير رد الخادم: ' + err.message;
                console.error('خطأ في تفسير رد الخادم:', err);
                return { status: response.status, data: { success: false, message: 'خطأ في بيانات الاستجابة' } };
            });
        })
        .then(({status, data}) => {
            if (status === 200 && data.success) {
                // إخفاء النموذج وإظهار رسالة النجاح
                document.getElementById('rating-success').classList.remove('hidden');
                submitButton.textContent = 'تم التقييم';
                console.log('تم إرسال التقييم بنجاح!');
            } else {
                // إظهار رسالة الخطأ
                submitButton.textContent = 'حدث خطأ: ' + (data.message || 'خطأ غير معروف');
                submitButton.disabled = false;
                console.error('خطأ في إرسال التقييم:', data.message || 'خطأ غير معروف');
            }
        })
        .catch(error => {
            console.error('خطأ عام:', error);
            debugInfo.innerHTML += '<br>خطأ: ' + error.message;
            submitButton.textContent = 'حدث خطأ، حاول مرة أخرى';
            submitButton.disabled = false;
        });
    }
    
    // وظيفة عرض/إخفاء معلومات التصحيح
    function toggleDebug() {
        if (debugInfo.classList.contains('hidden')) {
            debugInfo.classList.remove('hidden');
        } else {
            debugInfo.classList.add('hidden');
        }
    }
});
</script>
@endsection 