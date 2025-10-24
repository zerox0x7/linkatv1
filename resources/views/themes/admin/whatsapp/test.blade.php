@extends('themes.admin.layouts.app')

@section('title', 'اختبار إرسال رسائل واتساب')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex items-center justify-between">
        <h3 class="text-gray-700 dark:text-gray-100 text-3xl font-medium">اختبار إرسال رسائل واتساب</h3>
        <a href="{{ route('admin.whatsapp.index') }}" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-100 px-4 py-2 rounded-md">
            العودة إلى لوحة التحكم
        </a>
    </div>

    <div class="mt-8">
        @if (session('success'))
        <div class="bg-green-100 dark:bg-green-900 border-l-4 border-green-500 text-green-700 dark:text-green-100 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
        @endif
        
        @if (session('error'))
        <div class="bg-red-100 dark:bg-red-900 border-l-4 border-red-500 text-red-700 dark:text-red-100 p-4 mb-6" role="alert">
            <p>{{ session('error') }}</p>
        </div>
        @endif

        <div class="bg-red-100 dark:bg-red-900 border-l-4 border-red-500 text-red-700 dark:text-red-100 p-4 mb-6" role="alert">
            <strong>تنبيه!</strong> هذه الرسالة فقط رسالة اختبار، وليس بالضرورة أن تكون مطابقة للرسائل الفعلية المرسلة للعملاء.
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-md shadow-md p-6">
            <h4 class="text-lg font-medium text-gray-700 dark:text-gray-100 mb-4">ارسال رسالة اختبار</h4>
            
            @if(count($templates) === 0)
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
                    <p>لا توجد قوالب رسائل متاحة. <a href="{{ route('admin.whatsapp.templates.create') }}" class="underline">انقر هنا لإنشاء قالب جديد</a>.</p>
                </div>
            @else
                <form action="{{ route('admin.whatsapp.test.send') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-200">رقم الهاتف <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <input type="text" name="phone" id="phone" placeholder="966xxxxxxxx" required 
                                   class="form-input w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-300">أدخل رقم الهاتف بدون الرمز + (مثال: 966501234567)</p>
                        </div>
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="template_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">اختر القالب <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <select name="template_id" id="template_id" required class="template-select form-select w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700">
                                <option value="">-- اختر قالب --</option>
                                @foreach($templates as $template)
                                    @if($template->type === 'otp')
                                        <option value="{{ $template->id }}" data-type="{{ $template->type }}" data-parameters="{{ json_encode($template->parameters) }}">
                                            {{ $template->name }} ({{ config('whatsapp.template_types.' . $template->type) }})
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        @error('template_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div id="preview-container" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">معاينة القالب</label>
                        <div class="mt-1 p-4 bg-gray-50 dark:bg-gray-900 rounded-md border dark:border-gray-700">
                            <div id="template-preview" class="text-gray-800 dark:text-gray-100 whitespace-pre-line"></div>
                        </div>
                    </div>

                    <div id="parameters-container" class="hidden">
                        <h5 class="font-medium text-gray-700 dark:text-gray-100 mb-3">معلمات القالب</h5>
                        <div id="parameters-fields" class="space-y-4">
                            <!-- سيتم إضافة حقول المعلمات ديناميكيًا هنا -->
                        </div>
                    </div>
            
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 dark:bg-blue-800 text-white rounded-md hover:bg-blue-700 dark:hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                            إرسال رسالة اختبار
                        </button>
                    </div>
                </form>
            @endif
        </div>
        
        <div class="mt-8 bg-white dark:bg-gray-800 rounded-md shadow-md p-6">
            <h4 class="text-lg font-medium text-gray-700 dark:text-gray-100 mb-4">تذكير هام</h4>
            
            <ul class="list-disc list-inside space-y-2 text-gray-600 dark:text-gray-300">
                <li>تأكد من تكوين إعدادات API الواتساب بشكل صحيح قبل إجراء الاختبار.</li>
                <li>استخدم رقم هاتف حقيقي مسجل على واتساب لاختبار الإرسال.</li>
                <li>قد تستغرق عملية الإرسال بضع ثوانٍ، يرجى الانتظار.</li>
                <li>يمكنك مراجعة سجلات الإرسال للتحقق من حالة الرسائل المرسلة.</li>
            </ul>
            
            <div class="mt-6 text-center">
                <a href="{{ route('admin.whatsapp.logs') }}" class="inline-block px-4 py-2 bg-gray-600 dark:bg-gray-800 text-white rounded-md hover:bg-gray-700 dark:hover:bg-gray-900">
                    عرض سجلات الإرسال
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
@verbatim
    document.addEventListener('DOMContentLoaded', function() {
        const templateSelect = document.getElementById('template_id');
        const parametersContainer = document.getElementById('parameters-container');
        const parametersFields = document.getElementById('parameters-fields');
        const previewContainer = document.getElementById('preview-container');
        const templatePreview = document.getElementById('template-preview');
        
        // معلمات كل نوع من أنواع القوالب
        const templateTypeParams = {
            'order_status': [
                {name: 'customer_name', label: 'اسم العميل', placeholder: 'أحمد محمد'},
                {name: 'order_id', label: 'رقم الطلب', placeholder: '10001'},
                {name: 'order_status', label: 'حالة الطلب', placeholder: 'تم الشحن'},
                {name: 'order_date', label: 'تاريخ الطلب', placeholder: '2023-06-20'},
                {name: 'order_amount', label: 'إجمالي الطلب', placeholder: '250 ريال'}
            ],
            'otp': [
                {name: 'otp', label: 'رمز التحقق', placeholder: '123456'},
                {name: 'app_name', label: 'اسم التطبيق', placeholder: 'متجرنا'},
                {name: 'valid_time', label: 'مدة الصلاحية', placeholder: '5 دقائق'}
            ],
            'delivery': [
                {name: 'customer_name', label: 'اسم العميل', placeholder: 'أحمد محمد'},
                {name: 'order_id', label: 'رقم الطلب', placeholder: '10001'},
                {name: 'delivery_date', label: 'تاريخ التسليم', placeholder: '2023-06-25'},
                {name: 'delivery_time', label: 'وقت التسليم', placeholder: '14:30'}
            ],
            'login': [
                {name: 'code', label: 'رمز تسجيل الدخول', placeholder: '123456'},
                {name: 'app_name', label: 'اسم التطبيق', placeholder: 'متجرنا'},
                {name: 'valid_time', label: 'مدة الصلاحية', placeholder: '5 دقائق'}
            ]
        };
        
        // عند تغيير اختيار القالب
        templateSelect.addEventListener('change', function() {
            parametersFields.innerHTML = '';
            
            if (this.value) {
                const selectedOption = this.options[this.selectedIndex];
                const templateType = selectedOption.dataset.type;
                const templateParams = JSON.parse(selectedOption.dataset.parameters || '{}');
                
                // جلب معلمات القالب المحدد
                let params = templateTypeParams[templateType] || [];
                
                // إنشاء حقول المعلمات
                if (params.length > 0) {
                    params.forEach(param => {
                        const paramGroup = document.createElement('div');
                        
                        const paramLabel = document.createElement('label');
                        paramLabel.setAttribute('for', `param-${param.name}`);
                        paramLabel.classList.add('block', 'text-sm', 'font-medium', 'text-gray-700');
                        paramLabel.textContent = param.label;
                        
                        const paramInput = document.createElement('input');
                        paramInput.setAttribute('type', 'text');
                        paramInput.setAttribute('id', `param-${param.name}`);
                        paramInput.setAttribute('name', `parameters[${param.name}]`);
                        paramInput.setAttribute('placeholder', param.placeholder);
                        paramInput.classList.add('mt-1', 'form-input', 'w-full', 'px-4', 'py-2', 'border', 'rounded-md', 'focus:outline-none', 'focus:ring-2', 'focus:ring-blue-600');
                        
                        // استمع إلى تغييرات الإدخال لتحديث المعاينة
                        paramInput.addEventListener('input', updatePreview);
                        
                        paramGroup.appendChild(paramLabel);
                        paramGroup.appendChild(paramInput);
                        parametersFields.appendChild(paramGroup);
                    });
                    
                    parametersContainer.classList.remove('hidden');
                    
                    // جلب محتوى القالب للمعاينة
                    fetch(`/admin/api/whatsapp/templates/${this.value}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                templatePreview.textContent = data.content;
                                previewContainer.classList.remove('hidden');
                                updatePreview();
                            }
                        })
                        .catch(error => console.error('خطأ في جلب القالب:', error));
                } else {
                    parametersContainer.classList.add('hidden');
                    previewContainer.classList.add('hidden');
                }
            } else {
                parametersContainer.classList.add('hidden');
                previewContainer.classList.add('hidden');
            }
        });
        
        // تحديث المعاينة مع المعلمات
        function updatePreview() {
            let previewText = templatePreview.textContent;
            
            // الحصول على جميع حقول المعلمات
            const paramInputs = parametersFields.querySelectorAll('input[name^="parameters"]');
            
            paramInputs.forEach(input => {
                const paramName = input.name.match(/\[(.*?)\]/)[1];
                const paramValue = input.value || input.placeholder;
                
                // استبدال المعلمة في نص المعاينة
                const paramRegex = new RegExp(`{{${paramName}}}`, 'g');
                previewText = previewText.replace(paramRegex, paramValue);
            });
            
            templatePreview.textContent = previewText;
        }
    });
@endverbatim
</script>
@endpush

@endsection 