@extends('themes.admin.layouts.app')

@section('title', 'سجلات رسائل واتساب')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex items-center justify-between">
        <h3 class="text-gray-700 dark:text-gray-100 text-3xl font-medium">سجلات رسائل واتساب</h3>
        <a href="{{ route('admin.whatsapp.index') }}" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-100 px-4 py-2 rounded-md">
            العودة إلى لوحة التحكم
        </a>
    </div>

    <div class="mt-8">
        @if(count($logs) > 0)
        <div class="bg-white dark:bg-gray-800 rounded-md shadow-md overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">رقم الهاتف</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">القالب</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الحالة</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">المرسل</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">تاريخ الإرسال</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">التفاصيل</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($logs as $log)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $log->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $log->phone }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                            {{ $log->template_name ?? 'غير محدد' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($log->status == 'success')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                تم الإرسال
                            </span>
                            @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">
                                فشل الإرسال
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                            {{ $log->user ? $log->user->name : 'نظام' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                            {{ $log->created_at->format('Y-m-d H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button type="button" onclick="showLogDetails({{ $log->id }})" class="text-blue-600 dark:text-blue-300 hover:text-blue-900 dark:hover:text-blue-400">
                                <i class="ri-eye-line text-lg"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="px-6 py-4">
                {{ $logs->links() }}
            </div>
        </div>
        @else
        <div class="bg-white dark:bg-gray-800 rounded-md shadow-md p-6 text-center">
            <div class="text-gray-500 dark:text-gray-300 mb-4">
                <i class="ri-history-line text-5xl"></i>
            </div>
            <h4 class="text-lg font-medium text-gray-700 dark:text-gray-100 mb-2">لا توجد سجلات بعد</h4>
            <p class="text-gray-500 dark:text-gray-300 mb-4">سيتم عرض سجلات إرسال رسائل واتساب هنا عند إرسال رسائل</p>
            <a href="{{ route('admin.whatsapp.test') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-800 hover:bg-blue-700 dark:hover:bg-blue-900 text-white rounded-md">
                <i class="ri-send-plane-line ml-1"></i>اختبار إرسال رسالة
            </a>
        </div>
        @endif
    </div>
</div>

<!-- نافذة منبثقة لعرض تفاصيل السجل -->
<div id="logDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg w-full max-w-2xl mx-4">
        <div class="border-b dark:border-gray-700 px-6 py-4 flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">تفاصيل الرسالة</h3>
            <button type="button" onclick="closeLogDetailsModal()" class="text-gray-400 dark:text-gray-300 hover:text-gray-500 dark:hover:text-gray-100">
                <i class="ri-close-line text-xl"></i>
            </button>
        </div>
        <div class="px-6 py-4">
            <div id="logDetailsContent" class="space-y-4">
                <p class="text-center text-gray-500 dark:text-gray-300">جاري تحميل البيانات...</p>
            </div>
        </div>
        <div class="bg-gray-50 dark:bg-gray-900 px-6 py-3 flex justify-end">
            <button type="button" onclick="closeLogDetailsModal()" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600">
                إغلاق
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function showLogDetails(logId) {
        // عرض النافذة المنبثقة
        document.getElementById('logDetailsModal').classList.remove('hidden');
        document.getElementById('logDetailsContent').innerHTML = '<p class="text-center text-gray-500 dark:text-gray-300">جاري تحميل البيانات...</p>';
        
        // جلب بيانات السجل
        fetch(`/admin/api/whatsapp/logs/${logId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let log = data.log;
                    let content = `
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h4 class="font-medium text-gray-700 dark:text-gray-100 mb-2">معلومات الإرسال</h4>
                                <div class="bg-gray-50 dark:bg-gray-900 p-3 rounded border dark:border-gray-700 space-y-2">
                                    <p><span class="font-medium">رقم الهاتف:</span> ${log.phone}</p>
                                    <p><span class="font-medium">القالب:</span> ${log.template_name || 'غير محدد'}</p>
                                    <p><span class="font-medium">الحالة:</span> 
                                        <span class="${log.status === 'success' ? 'text-green-600' : 'text-red-600'}">
                                            ${log.status === 'success' ? 'تم الإرسال' : 'فشل الإرسال'}
                                        </span>
                                    </p>
                                    <p><span class="font-medium">تاريخ الإرسال:</span> ${log.created_at}</p>
                                </div>
                            </div>
                            
                            <div>
                                <h4 class="font-medium text-gray-700 dark:text-gray-100 mb-2">المعلمات المستخدمة</h4>
                                <div class="bg-gray-50 dark:bg-gray-900 p-3 rounded border dark:border-gray-700">
                                    ${log.parameters ? renderParameters(log.parameters) : '<p class="text-gray-500 dark:text-gray-300">لا توجد معلمات</p>'}
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <h4 class="font-medium text-gray-700 dark:text-gray-100 mb-2">محتوى الرسالة</h4>
                            <div class="bg-gray-50 dark:bg-gray-900 p-3 rounded border dark:border-gray-700 whitespace-pre-line">
                                ${log.message || 'لا يوجد محتوى متاح'}
                            </div>
                        </div>
                        
                        ${log.error ? `
                        <div class="mt-4">
                            <h4 class="font-medium text-red-700 dark:text-red-200 mb-2">رسالة الخطأ</h4>
                            <div class="bg-red-50 dark:bg-red-900 p-3 rounded border dark:border-red-700 text-red-700 dark:text-red-200 whitespace-pre-line">
                                ${log.error}
                            </div>
                        </div>
                        ` : ''}
                    `;
                    
                    document.getElementById('logDetailsContent').innerHTML = content;
                } else {
                    document.getElementById('logDetailsContent').innerHTML = '<p class="text-center text-red-500">حدث خطأ أثناء تحميل البيانات</p>';
                }
            })
            .catch(error => {
                document.getElementById('logDetailsContent').innerHTML = '<p class="text-center text-red-500">حدث خطأ أثناء الاتصال بالخادم</p>';
            });
    }
    
    function closeLogDetailsModal() {
        document.getElementById('logDetailsModal').classList.add('hidden');
    }
    
    function renderParameters(parameters) {
        if (!parameters || Object.keys(parameters).length === 0) {
            return '<p class="text-gray-500 dark:text-gray-300">لا توجد معلمات</p>';
        }
        
        let html = '<div class="space-y-1">';
        for (const [key, value] of Object.entries(parameters)) {
            html += `<p><span class="font-medium">${key}:</span> ${value}</p>`;
        }
        html += '</div>';
        
        return html;
    }
    
    // إغلاق النافذة عند النقر خارجها
    document.getElementById('logDetailsModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeLogDetailsModal();
        }
    });
</script>
@endpush

@endsection 