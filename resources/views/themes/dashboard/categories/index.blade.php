@extends('themes.dashboard.layouts.app')

@section('title', 'إدارة التصنيفات')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2">قائمة التصنيفات</h1>
            <p class="text-gray-600 dark:text-gray-300">عرض وإدارة تصنيفات المنتجات</p>
        </div>
        <a href="{{ route('dashboard.categories.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            إضافة تصنيف
        </a>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-sm overflow-hidden">
        @if($categories->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-right text-gray-500 dark:text-gray-300">
                    <thead class="text-xs text-gray-700 dark:text-gray-200 uppercase bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th scope="col" class="px-6 py-3">#</th>
                            <th scope="col" class="px-6 py-3">الصورة</th>
                            <th scope="col" class="px-6 py-3">الاسم</th>
                            <th scope="col" class="px-6 py-3">التصنيف الأب</th>
                            <th scope="col" class="px-6 py-3">عدد المنتجات</th>
                            <th scope="col" class="px-6 py-3">الحالة</th>
                            <th scope="col" class="px-6 py-3">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr class="border-b dark:border-gray-700">
                                <td class="px-6 py-4">{{ $category->id }}</td>
                                <td class="px-6 py-4">
                                    @if($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-10 h-10 rounded-lg object-cover">
                                    @else
                                        <span class="px-2 py-1 text-xs rounded-full bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-200">لا توجد صورة</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">{{ $category->name }}</td>
                                <td class="px-6 py-4">
                                    @if($category->parent)
                                        {{ $category->parent->name }}
                                    @else
                                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">تصنيف رئيسي</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">{{ $category->products_count }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($category->is_active)
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">نشط</span>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">غير نشط</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2 space-x-reverse">
                                        <a href="{{ route('dashboard.categories.show', $category) }}" class="text-blue-600 hover:text-blue-900" title="عرض">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('dashboard.categories.edit', $category) }}" class="text-yellow-600 hover:text-yellow-900" title="تعديل">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 0L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <button type="button" class="text-red-600 hover:text-red-900" onclick="confirmDelete('{{ $category->id }}', '{{ $category->name }}', {{ $category->products_count }}, {{ $category->children->count() }})" title="حذف">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <!-- قالب نافذة الحذف المنبثقة - سيتم استدعاؤه باستخدام جافاسكريبت -->
                                    <div id="deleteModal{{ $category->id }}" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-80 transition-opacity" aria-hidden="true"></div>
                                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                            <div class="inline-block align-bottom bg-white dark:bg-gray-900 rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                <div class="bg-white dark:bg-gray-900 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                    <div class="sm:flex sm:items-start">
                                                        <div class="mt-3 text-center sm:mt-0 sm:mr-4 sm:text-right">
                                                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">
                                                                تأكيد الحذف
                                                            </h3>
                                                            <div class="mt-2">
                                                                <p class="text-sm text-gray-500 dark:text-gray-300">
                                                                    هل أنت متأكد من حذف تصنيف "<span id="categoryName{{ $category->id }}"></span>"؟
                                                                </p>
                                                                <div id="warningSection{{ $category->id }}" class="mt-2 text-sm text-red-500">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                    <form id="deleteForm{{ $category->id }}" action="{{ route('dashboard.categories.destroy', $category) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                            حذف
                                                        </button>
                                                    </form>
                                                    <button type="button" onclick="closeModal('{{ $category->id }}')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-700 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                        إلغاء
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-6 text-center">
                <p class="text-gray-500 mb-4">لا توجد تصنيفات متاحة حاليًا.</p>
                <a href="{{ route('dashboard.categories.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    إضافة تصنيف جديد
                </a>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    function confirmDelete(id, name, productsCount, childrenCount) {
        document.getElementById('categoryName' + id).textContent = name;
        
        let warningText = '';
        if (productsCount > 0) {
            warningText += '<strong>تحذير:</strong> هذا التصنيف يحتوي على ' + productsCount + ' منتج.<br>';
        }
        
        if (childrenCount > 0) {
            warningText += '<strong>تحذير:</strong> هذا التصنيف يحتوي على ' + childrenCount + ' تصنيف فرعي.';
        }
        
        document.getElementById('warningSection' + id).innerHTML = warningText;
        document.getElementById('deleteModal' + id).style.display = 'block';
    }
    
    function closeModal(id) {
        document.getElementById('deleteModal' + id).style.display = 'none';
    }
</script>
@endpush 