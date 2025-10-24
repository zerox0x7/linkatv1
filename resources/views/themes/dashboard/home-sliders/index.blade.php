@extends('themes.admin.layouts.app')
@section('title', 'إدارة سلايدر الصفحة الرئيسية')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">إدارة سلايدر الصفحة الرئيسية</h1>
        <a href="{{ route('admin.home-sliders.create') }}" class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded shadow dark:bg-green-700 dark:hover:bg-green-800">
            <i class="fas fa-plus ml-1"></i> إضافة سلايدر جديد
        </a>
    </div>
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative dark:bg-green-900 dark:border-green-700 dark:text-green-200">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative dark:bg-red-900 dark:border-red-700 dark:text-red-200">
            {{ session('error') }}
        </div>
    @endif
    
    <!-- Sliders Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden dark:bg-gray-900">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                            #
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                            الصورة
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                            العنوان
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                            الحالة
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                            الترتيب
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                            الإجراءات
                        </th>
                    </tr>
                </thead>
                <tbody id="sliders-list" class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-800">
                    @forelse($sliders as $slider)
                        <tr data-id="{{ $slider->id }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="{{ $slider->image_url ?? asset('images/placeholder-image.jpg') }}" alt="{{ $slider->title }}" class="h-16 w-auto object-cover rounded">
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $slider->title }}</div>
                                @if($slider->subtitle)
                                    <div class="text-sm text-gray-500 dark:text-gray-300">{{ Str::limit($slider->subtitle, 100) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $slider->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                    {{ $slider->is_active ? 'مفعل' : 'معطل' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ $slider->sort_order }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex items-center justify-center space-x-3 space-x-reverse">
                                    <a href="{{ route('admin.home-sliders.edit', $slider) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    
                                    <form action="{{ route('admin.home-sliders.toggle-status', $slider) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="{{ $slider->is_active ? 'text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-200' : 'text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-200' }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $slider->is_active ? 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636' : 'M5 13l4 4L19 7' }}" />
                                            </svg>
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('admin.home-sliders.destroy', $slider) }}" method="POST" class="inline-block delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-300">
                                لا يوجد سلايدرات مضافة حتى الآن. <a href="{{ route('admin.home-sliders.create') }}" class="text-blue-600 hover:underline dark:text-blue-400">إضافة سلايدر جديد</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow overflow-hidden dark:bg-gray-900">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <h2 class="text-lg font-medium text-gray-800 dark:text-gray-100">ترتيب السلايدرات</h2>
        </div>
        <div class="p-6">
            <p class="text-gray-600 mb-4 dark:text-gray-300">يمكنك ترتيب السلايدرات عن طريق سحب وإفلات الصفوف في الجدول أعلاه.</p>
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative dark:bg-yellow-900 dark:border-yellow-700 dark:text-yellow-200">
                <strong class="font-bold ml-1">ملاحظة:</strong>
                <span class="block sm:inline">يتم حفظ الترتيب تلقائياً بعد السحب والإفلات.</span>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // تهيئة خاصية السحب والإفلات لترتيب السلايدرات
        const slidersList = document.getElementById('sliders-list');
        
        if (slidersList) {
            new Sortable(slidersList, {
                animation: 150,
                ghostClass: 'bg-gray-100',
                onEnd: function () {
                    saveOrder();
                }
            });
        }
        
        // حفظ الترتيب الجديد
        function saveOrder() {
            const rows = document.querySelectorAll('#sliders-list tr');
            const sliders = [];
            
            rows.forEach((row, index) => {
                sliders.push({
                    id: row.dataset.id,
                    order: index
                });
            });
            
            // إرسال البيانات للخادم
            fetch('{{ route("admin.home-sliders.update-order") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ sliders })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('تم تحديث الترتيب بنجاح');
                }
            })
            .catch(error => {
                console.error('خطأ في تحديث الترتيب:', error);
            });
        }
        
        // تأكيد الحذف
        const deleteForms = document.querySelectorAll('.delete-form');
        
        deleteForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                
                if (confirm('هل أنت متأكد من رغبتك في حذف هذا السلايدر؟')) {
                    this.submit();
                }
            });
        });
    });
</script>
@endpush 