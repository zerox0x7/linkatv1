@extends('themes.admin.layouts.app')

@section('title', 'إدارة أقسام الصفحة الرئيسية')

@section('content')
<div class="px-4 py-5">
    <!-- خط مسار التنقل -->
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    <svg class="w-3 h-3 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                    </svg>
                    الرئيسية
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">أقسام الصفحة الرئيسية</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">إدارة أقسام الصفحة الرئيسية</h1>
        <a href="{{ route('admin.home-sections.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-800 active:bg-blue-900 dark:active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300">
            <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            إضافة قسم جديد
        </a>
    </div>

    @if(session('success'))
    <div class="mb-4 bg-green-100 dark:bg-green-900 border-r-4 border-green-500 dark:border-green-700 text-green-700 dark:text-green-200 px-4 py-3 rounded relative shadow" role="alert">
        <div class="flex">
            <div class="py-1"><svg class="fill-current h-6 w-6 text-green-500 ml-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
            <div>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none'">
                <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
    @endif

    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
            <h2 class="text-lg font-semibold text-primary-600 dark:text-primary-300">أقسام الصفحة الرئيسية</h2>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-24">
                                الترتيب
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                العنوان
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                الوصف
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                النوع
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-24">
                                الحالة
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-36">
                                الإجراءات
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700 sortable">
                        @forelse($sections as $section)
                        <tr data-id="{{ $section->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-gray-400 mr-2 handle cursor-move" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                                    </svg>
                                    <span>{{ $section->order }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $section->title }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-500 dark:text-gray-300">{{ \Illuminate\Support\Str::limit($section->description, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500 dark:text-gray-300">{{ $section->type ?? $section->key }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer toggle-status" 
                                           id="status_{{ $section->id }}" 
                                           data-id="{{ $section->id }}" 
                                           {{ $section->is_active ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:translate-x-[-100%] peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:right-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-left">
                                <div class="flex space-x-2 rtl:space-x-reverse">
                                    <a href="{{ route('admin.home-sections.edit', $section->id) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-blue-600 dark:bg-blue-700 hover:bg-blue-700 dark:hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <a href="{{ route('admin.home-sections.edit', $section->id) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        تعديل
                                    </a>
                                    <button type="button" onclick="deleteSection({{ $section->id }})" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <svg class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        حذف
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="h-12 w-12 text-gray-400 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-lg font-medium">لا توجد أقسام مضافة حاليًا</p>
                                    <a href="{{ route('admin.home-sections.create') }}" class="mt-3 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none">
                                        <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        إضافة قسم جديد
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.sortable-chosen {
    background-color: #f3f4f6;
}
.sortable-ghost {
    opacity: 0.4;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // سكريبت للسحب والإفلات لتغيير الترتيب
        new Sortable(document.querySelector('.sortable'), {
            handle: '.handle',
            animation: 150,
            onEnd: function(evt) {
                // حفظ الترتيب الجديد عبر طلب AJAX
                const items = Array.from(document.querySelectorAll('.sortable tr')).map((el, index) => {
                    return {
                        id: el.dataset.id,
                        order: index + 1
                    };
                });
                
                // إرسال الترتيب الجديد للسيرفر
                fetch('{{ route('admin.home-sections.reorder') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ items: items })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // نجاح العملية
                        showToast('تم حفظ الترتيب الجديد بنجاح', 'success');
                    } else {
                        console.error('Error reordering sections');
                        showToast('حدث خطأ أثناء حفظ الترتيب', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('حدث خطأ أثناء حفظ الترتيب', 'error');
                });
            }
        });
        
        // تفعيل/تعطيل القسم
        document.querySelectorAll('.toggle-status').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const sectionId = this.dataset.id;
                const isActive = this.checked;
                
                fetch(`{{ url('admin/home-sections') }}/${sectionId}/toggle-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ is_active: isActive })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast(isActive ? 'تم تفعيل القسم بنجاح' : 'تم إلغاء تفعيل القسم بنجاح', 'success');
                    } else {
                        console.error('Error toggling status');
                        this.checked = !isActive; // إعادة الحالة السابقة في حالة الخطأ
                        showToast('حدث خطأ أثناء تغيير حالة القسم', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.checked = !isActive; // إعادة الحالة السابقة في حالة الخطأ
                    showToast('حدث خطأ أثناء تغيير حالة القسم', 'error');
                });
            });
        });

        // دالة إظهار رسائل النجاح والخطأ
        function showToast(message, type = 'info') {
            // يمكن استبدال هذا بمكتبة toast notifications مثل toastr أو sweetalert2
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 p-4 rounded shadow-lg z-50 ${
                type === 'success' ? 'bg-green-500' : 
                type === 'error' ? 'bg-red-500' : 
                'bg-blue-500'
            } text-white`;
            toast.innerHTML = message;
            document.body.appendChild(toast);
            
            // إخفاء الرسالة بعد 3 ثوان
            setTimeout(() => {
                toast.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 500);
            }, 3000);
        }
    });
</script>

<script>
function deleteSection(sectionId) {
    if (!confirm('هل أنت متأكد من حذف هذا القسم؟')) return;
    fetch("{{ route('admin.home-sections.destroy', ':id') }}".replace(':id', sectionId), {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content'),
            'Accept': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            var row = document.getElementById('section-row-' + sectionId);
            if (row) row.remove();
            if (typeof toastr !== 'undefined') {
                toastr.success('تم حذف القسم بنجاح');
            } else {
                alert('تم حذف القسم بنجاح');
            }
        } else {
            toastr.error('حدث خطأ أثناء الحذف');
        }
    })
    .catch(() => {
        toastr.error('حدث خطأ أثناء الحذف');
    });
}
</script>
@endpush 