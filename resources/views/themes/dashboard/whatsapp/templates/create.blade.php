@extends('themes.admin.layouts.app')

@section('title', 'إنشاء قالب واتساب جديد')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex items-center justify-between">
        <h3 class="text-gray-700 text-3xl font-medium">إنشاء قالب واتساب جديد</h3>
        <a href="{{ route('admin.whatsapp.templates') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md">
            العودة إلى القوالب
        </a>
    </div>

    <div class="mt-8">
        <form action="{{ route('admin.whatsapp.templates.store') }}" method="POST" class="bg-white rounded-md shadow-md p-6">
            @csrf
            
            @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p class="font-bold">يرجى تصحيح الأخطاء التالية:</p>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-gray-700 font-medium mb-2 block" for="name">اسم القالب</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required
                        class="form-input w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600"
                        placeholder="اسم وصفي للقالب">
                </div>
                
                <div>
                    <label class="text-gray-700 font-medium mb-2 block" for="type">نوع القالب</label>
                    <select id="type" name="type" required
                        class="form-select w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600">
                        <option value="">-- اختر نوع القالب --</option>
                        <option value="order_pending" {{ old('type') == 'order_pending' ? 'selected' : '' }}>طلب قيد الانتظار</option>
                        <option value="order_processing" {{ old('type') == 'order_processing' ? 'selected' : '' }}>طلب قيد المعالجة</option>
                        <option value="order_completed" {{ old('type') == 'order_completed' ? 'selected' : '' }}>طلب مكتمل</option>
                        <option value="order_cancelled" {{ old('type') == 'order_cancelled' ? 'selected' : '' }}>طلب ملغي</option>
                        <option value="order_refunded" {{ old('type') == 'order_refunded' ? 'selected' : '' }}>طلب مسترجع</option>
                        <option value="otp" {{ old('type') == 'otp' ? 'selected' : '' }}>رمز التحقق (OTP)</option>
                        <option value="admin_notification" {{ old('type') == 'admin_notification' ? 'selected' : '' }}>تنبيهات الإدارة</option>
                    </select>
                </div>
                
                <div class="md:col-span-2">
                    <label class="text-gray-700 font-medium mb-2 block" for="content">محتوى الرسالة</label>
                    <textarea id="content" name="content" rows="8" required
                        class="form-textarea w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600"
                        placeholder="محتوى الرسالة. استخدم @{{parameter}} لإضافة متغيرات، على سبيل المثال: مرحبًا @{{customer_name}}">{{ old('content') }}</textarea>
                </div>
                
                <div class="md:col-span-2">
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    <strong>معلومة:</strong> يمكنك استخدام المتغيرات في محتوى الرسالة باستخدام الصيغة <code>@{{اسم_المتغير}}</code>.
                                    على سبيل المثال، <code>@{{customer_name}}</code> سيتم استبداله باسم العميل عند الإرسال.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="md:col-span-2">
                    <h4 class="text-gray-700 font-medium mb-2">المعلمات المتاحة حسب نوع القالب:</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                        <div class="bg-gray-50 p-3 rounded border template-params" data-type="order_pending">
                            <h5 class="font-semibold mb-2">طلب قيد الانتظار</h5>
                            <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                                <li>customer_name - اسم العميل</li>
                                <li>order_number - رقم الطلب</li>
                                <li>status - حالة الطلب</li>
                                <li>order_details - تفاصيل المنتجات</li>
                                <li>order_url - رابط الطلب</li>
                            </ul>
                        </div>
                        <div class="bg-gray-50 p-3 rounded border template-params" data-type="order_processing">
                            <h5 class="font-semibold mb-2">طلب قيد المعالجة</h5>
                            <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                                <li>customer_name - اسم العميل</li>
                                <li>order_number - رقم الطلب</li>
                                <li>status - حالة الطلب</li>
                                <li>order_details - تفاصيل المنتجات</li>
                                <li>order_url - رابط الطلب</li>
                            </ul>
                        </div>
                        <div class="bg-gray-50 p-3 rounded border template-params" data-type="order_completed">
                            <h5 class="font-semibold mb-2">طلب مكتمل</h5>
                            <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                                <li>customer_name - اسم العميل</li>
                                <li>order_number - رقم الطلب</li>
                                <li>status - حالة الطلب</li>
                                <li>order_details - تفاصيل المنتجات</li>
                                <li>total_amount - المبلغ الإجمالي</li>
                                <li>payment_status - حالة الدفع</li>
                                <li>payment_date - تاريخ الدفع</li>
                                <li>digital_codes - الأكواد الرقمية</li>
                                <li>delivery_date - تاريخ التسليم</li>
                                <li>tracking_number - رقم التتبع</li>
                                <li>order_url - رابط الطلب</li>
                            </ul>
                        </div>
                        <div class="bg-gray-50 p-3 rounded border template-params" data-type="order_cancelled">
                            <h5 class="font-semibold mb-2">طلب ملغي</h5>
                            <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                                <li>customer_name - اسم العميل</li>
                                <li>order_number - رقم الطلب</li>
                                <li>status - حالة الطلب</li>
                                <li>order_details - تفاصيل المنتجات</li>
                                <li>cancellation_reason - سبب الإلغاء</li>
                                <li>order_url - رابط الطلب</li>
                            </ul>
                        </div>
                        <div class="bg-gray-50 p-3 rounded border template-params" data-type="order_refunded">
                            <h5 class="font-semibold mb-2">طلب مسترجع</h5>
                            <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                                <li>customer_name - اسم العميل</li>
                                <li>order_number - رقم الطلب</li>
                                <li>status - حالة الطلب</li>
                                <li>order_details - تفاصيل المنتجات</li>
                                <li>total_amount - المبلغ الإجمالي</li>
                                <li>order_url - رابط الطلب</li>
                            </ul>
                        </div>
                        <div class="bg-gray-50 p-3 rounded border template-params" data-type="otp">
                            <h5 class="font-semibold mb-2">رمز التحقق (OTP)</h5>
                            <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                                <li>otp - رمز التحقق</li>
                                <li>app_name - اسم التطبيق</li>
                                <li>valid_time - مدة صلاحية الرمز</li>
                            </ul>
                        </div>
                        <div class="bg-gray-50 p-3 rounded border template-params" data-type="admin_notification">
                            <h5 class="font-semibold mb-2">تنبيهات الإدارة</h5>
                            <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                                <li>order_number - رقم الطلب</li>
                                <li>customer_name - اسم العميل</li>
                                <li>status - حالة الطلب</li>
                                <li>order_details - تفاصيل المنتجات</li>
                                <li>total_amount - المبلغ الإجمالي</li>
                                <li>payment_status - حالة الدفع</li>
                                <li>payment_date - تاريخ الدفع</li>
                                <li>digital_codes - الأكواد الرقمية</li>
                                <li>delivery_date - تاريخ التسليم</li>
                                <li>tracking_number - رقم التتبع</li>
                                <li>order_url - رابط الطلب</li>
                                <li>cancellation_reason - سبب الإلغاء</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div>
                    <div class="flex items-center">
                        <input type="checkbox" id="is_active" name="is_active" value="1" checked
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="is_active" class="mr-2 text-gray-700">تفعيل القالب</label>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 flex justify-end">
                <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-opacity-50">
                    حفظ القالب
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type');
        const paramSections = document.querySelectorAll('.template-params');
        
        // إخفاء جميع أقسام المعلمات في البداية
        paramSections.forEach(section => {
            section.style.display = 'none';
        });
        
        // عرض القسم المناسب عند اختيار نوع القالب
        function updateParamSection() {
            const selectedType = typeSelect.value;
            
            paramSections.forEach(section => {
                if (selectedType && section.dataset.type === selectedType) {
                    section.style.display = 'block';
                } else {
                    section.style.display = 'none';
                }
            });
        }
        
        // تحديث عند تحميل الصفحة
        updateParamSection();
        
        // تحديث عند تغيير الاختيار
        typeSelect.addEventListener('change', updateParamSection);
    });
</script>
@endpush

@endsection