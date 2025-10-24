@extends('themes.admin.layouts.app')

@section('title', 'تعديل قالب واتساب')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex items-center justify-between">
        <h3 class="text-gray-700 dark:text-gray-100 text-3xl font-medium">تعديل قالب واتساب</h3>
        <a href="{{ route('admin.whatsapp.templates') }}" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-100 px-4 py-2 rounded-md">
            العودة إلى القوالب
        </a>
    </div>

    <div class="mt-8">
        <form action="{{ route('admin.whatsapp.templates.update', $template->id) }}" method="POST" class="bg-white dark:bg-gray-800 rounded-md shadow-md p-6">
            @csrf
            @method('PUT')
            
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
                    <label class="text-gray-700 dark:text-gray-200 font-medium mb-2 block">اسم القالب البرمجي (type)</label>
                    <div class="bg-gray-100 dark:bg-gray-700 px-4 py-2 rounded-md text-gray-700 dark:text-gray-100 font-mono">{{ $template->type }}</div>
                </div>
                <div>
                    <label class="text-gray-700 dark:text-gray-200 font-medium mb-2 block">اسم القالب (name)</label>
                    <div class="bg-gray-100 dark:bg-gray-700 px-4 py-2 rounded-md text-gray-700 dark:text-gray-100">{{ $template->name }}</div>
                </div>
                
                <div class="md:col-span-2">
                    <label class="text-gray-700 dark:text-gray-200 font-medium mb-2 block" for="content">محتوى الرسالة</label>
                    <textarea id="content" name="content" rows="8" required
                        class="form-textarea w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700"
                        placeholder="محتوى الرسالة. استخدم اسم المتغير لإضافة متغيرات، على سبيل المثال: مرحبًا customer_name">{{ old('content', $template->content) }}</textarea>
                </div>
                
                <div class="md:col-span-2">
                    <h4 class="text-gray-700 dark:text-gray-200 font-medium mb-2">المعلمات البرمجية لهذا القالب:</h4>
                    @php
                        $params = \App\Constants\WhatsAppTemplates::TEMPLATE_PARAMS[$template->name] ?? [];
                    @endphp
                    @if(count($params))
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach($params as $param)
                                <div class="flex items-center gap-1 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded px-2 py-1 mb-1">
                                    <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded text-sm text-gray-800 dark:text-gray-100">{{ $param }}</code>
                                    <button type="button" class="insert-param px-2 py-0.5 text-xs bg-blue-100 dark:bg-blue-900 hover:bg-blue-200 dark:hover:bg-blue-800 text-blue-700 dark:text-blue-200 rounded focus:outline-none" data-param="{{ $param }}" title="إدراج في الرسالة">إدراج</button>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mb-2">استخدم هذه المتغيرات داخل نص الرسالة بكتابة اسم المتغير فقط، مثال: customer_name</div>
                    @else
                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-2">لا توجد معلمات محددة لهذا القالب.</div>
                    @endif
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
                                    <strong>معلومة:</strong> يمكنك استخدام المتغيرات في محتوى الرسالة بكتابة اسم المتغير فقط، مثال: customer_name سيتم استبداله بالقيمة المناسبة عند الإرسال.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div>
                    <div class="flex items-center">
                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ $template->is_active ? 'checked' : '' }}
                            class="w-4 h-4 text-blue-600 border-gray-300 dark:border-gray-600 rounded focus:ring-blue-500">
                        <label for="is_active" class="mr-2 text-gray-700 dark:text-gray-200">تفعيل القالب</label>
                    </div>
                </div>
            </div>
            
            <input type="hidden" name="name" value="{{ $template->name }}">
            <input type="hidden" name="type" value="{{ $template->type }}">
            
            <div class="mt-8 flex justify-end">
                <button type="submit" 
                    class="px-6 py-2 bg-blue-600 dark:bg-blue-800 text-white rounded-md hover:bg-blue-700 dark:hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-opacity-50">
                    تحديث القالب
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.insert-param').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var param = btn.getAttribute('data-param');
                var textarea = document.getElementById('content');
                if (textarea) {
                    // إدراج عند مؤشر الكتابة
                    var start = textarea.selectionStart;
                    var end = textarea.selectionEnd;
                    var before = textarea.value.substring(0, start);
                    var after = textarea.value.substring(end);
                    var insertText = '{' + '{' + param + '}' + '}';
                    textarea.value = before + insertText + after;
                    // إعادة وضع المؤشر بعد الإدراج
                    textarea.selectionStart = textarea.selectionEnd = start + insertText.length;
                    textarea.focus();
                }
            });
        });
    });
</script>
@endpush

@endsection 