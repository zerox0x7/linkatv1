@extends('themes.admin.layouts.app')

@section('title', 'إعدادات واتساب')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex items-center justify-between">
        <h3 class="text-gray-700 dark:text-gray-100 text-3xl font-medium">إعدادات واتساب</h3>
        <a href="{{ route('admin.whatsapp.index') }}" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-100 px-4 py-2 rounded-md">
            العودة إلى لوحة التحكم
        </a>
    </div>

    <div class="mt-4 mb-8 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-md p-6 flex flex-col items-center justify-center shadow-sm text-center">
        <div class="flex items-center justify-center mb-3">
            <svg class="h-10 w-10 text-green-500 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.72 11.06a8.94 8.94 0 01-4.72 4.72l-2.12-.71a1 1 0 00-1.01.24l-1.12 1.12a9.94 9.94 0 01-4.24-4.24l1.12-1.12a1 1 0 00.24-1.01l-.71-2.12A8.94 8.94 0 0112 3c2.21 0 4.26.8 5.86 2.14l-1.12 1.12a1 1 0 00-.24 1.01l.71 2.12z" />
            </svg>
            <span class="text-green-800 dark:text-green-200 font-semibold text-xl">معلومات الربط مع خدمة واتساب</span>
        </div>
        <div class="mb-2 text-green-700 dark:text-green-100 text-base font-medium">
            للاشتراك في خدمة الواتساب يمكنك الاشتراك وربط رقمك من خلال <span class="font-bold">واتسدل</span>.
        </div>
        <a href="https://dl1s.co/payment/index/de39a2bd852/1" target="_blank" class="mt-4 px-7 py-2 bg-green-600 dark:bg-green-800 text-white rounded-md font-semibold shadow hover:bg-green-700 dark:hover:bg-green-900 transition text-lg">الانتقال إلى الاشتراك في واتسدل</a>
    </div>

    <div class="mt-8">
        <form action="{{ route('admin.whatsapp.settings.update') }}" method="POST" class="bg-white dark:bg-gray-800 rounded-md shadow-md p-6">
            @csrf
            
            @if (session('success'))
            <div class="bg-green-100 dark:bg-green-900 border-l-4 border-green-500 text-green-700 dark:text-green-100 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
            @endif
            
            @if ($errors->any())
            <div class="bg-red-100 dark:bg-red-900 border-l-4 border-red-500 text-red-700 dark:text-red-100 p-4 mb-6" role="alert">
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
                    <label class="text-gray-700 dark:text-gray-200 font-medium mb-2 block" for="api_key">مفتاح API</label>
                    <input id="api_key" type="text" name="api_key" value="{{ $settings['api_key'] }}" required
                        class="form-input w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700"
                        placeholder="أدخل مفتاح API">
                </div>
                
                <div>
                    <label class="text-gray-700 dark:text-gray-200 font-medium mb-2 block" for="instance_id">معرّف الحساب (Instance ID)</label>
                    <input id="instance_id" type="text" name="instance_id" value="{{ $settings['instance_id'] }}" required
                        class="form-input w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700"
                        placeholder="أدخل معرّف الحساب">
                </div>
                
                <div>
                    <label class="text-gray-700 dark:text-gray-200 font-medium mb-2 block" for="admin_phones">رقم/أرقام الإدارة لإشعارات الإدارة</label>
                    <textarea id="admin_phones" name="admin_phones" rows="2" required
                        class="form-textarea w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700"
                        placeholder="أدخل رقم أو أكثر، كل رقم في سطر منفصل">{{ is_array($settings['admin_phones'] ?? null) ? implode("\n", $settings['admin_phones']) : str_replace([",", "\r\n", "\r"], "\n", $settings['admin_phones'] ?? '') }}</textarea>
                    <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">ستستقبل هذه الأرقام إشعارات الإدارة عبر واتساب. مثال: 9665xxxxxxxx</p>
                </div>
            </div>
            
            <div class="mt-6">
                <div class="flex items-center mb-4">
                    <input type="checkbox" id="enable_notifications" name="enable_notifications" value="1" {{ $settings['enable_notifications'] ? 'checked' : '' }}
                        class="w-4 h-4 text-blue-600 border-gray-300 dark:border-gray-600 rounded focus:ring-blue-500">
                    <label for="enable_notifications" class="mr-2 text-gray-700 dark:text-gray-200">تفعيل إشعارات واتساب</label>
                </div>
            </div>
            
            <div class="mt-6 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-md p-4">
                <h4 class="text-blue-600 dark:text-blue-200 font-medium mb-2">معلومات حول إعداد واتساب API</h4>
                <ul class="list-disc list-inside text-sm text-blue-800 dark:text-blue-200 space-y-1">
                    <li>يجب الحصول على مفتاح API من مزود خدمة واتساب الخاص بك.</li>
                    <li>معرّف الحساب هو المعرّف الفريد للحساب المستخدم في مزود الخدمة.</li>
                    <li>تأكد من أن الرقم المستخدم في مزود الخدمة مفعل ومسجل في واتساب.</li>
                    <li>يمكنك إيقاف إشعارات واتساب مؤقتًا بإلغاء تحديد مربع "تفعيل إشعارات واتساب".</li>
                    <li>يجب أن تحتوي أرقام العملاء على رمز الدولة (مثل +966) ليتم إرسال الرسائل بشكل صحيح.</li>
                </ul>
            </div>
            
            <div class="mt-8 flex justify-end">
                <button type="submit" 
                    class="px-6 py-2 bg-blue-600 dark:bg-blue-800 text-white rounded-md hover:bg-blue-700 dark:hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-opacity-50">
                    حفظ الإعدادات
                </button>
            </div>
        </form>
    </div>
    
    <div class="mt-8">
        <div class="bg-white dark:bg-gray-800 rounded-md shadow-md p-6">
            <h4 class="text-gray-700 dark:text-gray-100 text-lg font-medium mb-4">اختبار الإرسال</h4>
            
            <p class="text-gray-600 dark:text-gray-300 mb-4">بعد حفظ الإعدادات، يمكنك اختبار إرسال رسالة واتساب للتأكد من صحة الإعدادات.</p>
            
            <div class="mt-4">
                <a href="{{ route('admin.whatsapp.test') }}" class="px-4 py-2 bg-green-600 dark:bg-green-800 text-white rounded-md hover:bg-green-700 dark:hover:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-opacity-50">
                    اختبار إرسال رسالة
                </a>
            </div>
        </div>
    </div>
</div>

@endsection 