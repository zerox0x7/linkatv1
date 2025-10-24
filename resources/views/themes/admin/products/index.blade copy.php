@extends('themes.admin.layouts.app')

@section('title', 'إدارة المنتجات')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">إدارة المنتجات</h1>
        <a href="{{ route('admin.products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded shadow">
            إضافة منتج جديد
        </a>
    </div>
    
    <!-- Filter and search -->
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6">
        <form action="{{ route('admin.products.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">بحث</label>
                    <input type="text" name="search" id="search" placeholder="اسم المنتج أو الوصف..." 
                           value="{{ request('search') }}" 
                           class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                </div>
                
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">الفئة</label>
                    <select name="category" id="category" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                        <option value="">كل الفئات</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">الحالة</label>
                    <select name="status" id="status" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                        <option value="">كل الحالات</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشط</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                        <option value="out-of-stock" {{ request('status') == 'out-of-stock' ? 'selected' : '' }}>نفذ المخزون</option>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded shadow mr-2">
                        تصفية
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded shadow">
                        إعادة تعيين
                    </a>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Products table -->
    <div class="overflow-x-auto">
        <!-- عرض البطاقات في الجوال -->
        <div class="block md:hidden space-y-4">
            @forelse ($products as $product)
                <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-4 border border-gray-100 dark:border-gray-800">
                    <div class="flex items-center mb-3">
                        <div class="h-14 w-14 rounded overflow-hidden bg-gray-100 dark:bg-gray-800 flex-shrink-0">
                            <img src="{{ asset('storage/' . $product->main_image) }}" class="h-14 w-14 object-cover" alt="{{ $product->name }}" onerror="this.src='{{ asset('images/product-placeholder.svg') }}'">
                        </div>
                        <div class="mr-4 flex-1">
                            <div class="text-base font-bold text-gray-900 dark:text-gray-100">{{ $product->name }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">SKU: {{ $product->sku }}</div>
                        </div>
                        <form action="{{ route('admin.products.toggle-featured', $product) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-2xl {{ $product->featured ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}" title="مميز">★</button>
                        </form>
                    </div>
                    <div class="mb-2 flex flex-wrap gap-2">
                        <span class="px-2 py-0.5 rounded text-xs font-medium bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200">{{ $product->category->name ?? 'بدون فئة' }}</span>
                        @if($product->type == 'digital_card')
                            <span class="px-2 py-0.5 rounded text-xs font-medium bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200">بطاقة رقمية</span>
                        @else
                            <span class="px-2 py-0.5 rounded text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">حساب</span>
                        @endif
                        <span class="px-2 py-0.5 rounded text-xs font-medium {{ $product->stock > 0 ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' }}">{{ $product->stock > 0 ? 'متوفر' : 'غير متوفر' }}</span>
                        <span class="px-2 py-0.5 rounded text-xs font-medium
                            {{ $product->status == 'active' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' :
                               ($product->status == 'inactive' ? 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' : 'bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200') }}">
                            {{ $product->status == 'active' ? 'نشط' : ($product->status == 'inactive' ? 'غير نشط' : 'نفذ المخزون') }}
                        </span>
                    </div>
                    <div class="mb-2 flex items-center gap-2">
                        @if($product->old_price)
                            <div class="text-sm font-medium text-red-600 dark:text-red-400">{{ number_format($product->price, 2) }} ر.س</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 line-through">{{ number_format($product->old_price, 2) }} ر.س</div>
                        @else
                            <div class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ number_format($product->price, 2) }} ر.س</div>
                        @endif
                    </div>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @if($product->type == 'digital_card')
                            <a href="{{ route('admin.products.manage-codes', $product) }}" class="text-purple-600 dark:text-purple-300 hover:text-purple-900 dark:hover:text-purple-100" title="إدارة الأكواد الرقمية">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </a>
                        @elseif($product->type == 'account')
                            <a href="{{ route('admin.products.show', $product) }}#accountsModal" 
                               class="text-blue-600 dark:text-blue-300 hover:text-blue-900 dark:hover:text-blue-100" 
                               title="إدارة الحسابات">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </a>
                        @endif
                        <div class="inline-block">
                            <select class="product-status-select block w-32 px-2 py-1 text-sm border border-gray-300 dark:border-gray-700 rounded shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100"
                                    data-product-id="{{ $product->id }}"
                                    data-product-type="{{ $product->type }}">
                                <option value="">-- الحالة --</option>
                                <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>نشط</option>
                                <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                                <option value="out-of-stock" {{ $product->status == 'out-of-stock' ? 'selected' : '' }}>نفذ المخزون</option>
                            </select>
                        </div>
                        <a href="{{ route('admin.products.show', $product) }}" class="text-blue-600 dark:text-blue-300 hover:text-blue-900 dark:hover:text-blue-100" title="عرض">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </a>
                        <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 dark:text-indigo-300 hover:text-indigo-900 dark:hover:text-indigo-100" title="تعديل">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-200" title="حذف">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-400 dark:text-gray-500 py-8">لا توجد منتجات حالياً</div>
            @endforelse
        </div>
        <!-- الجدول في الشاشات المتوسطة والكبيرة -->
        <div class="hidden md:block">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            الصورة
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            المنتج
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            الفئة
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            النوع
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            السعر
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            المخزون
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            الحالة
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            مميز
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            إجراءات
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($products as $product)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="h-10 w-10 rounded overflow-hidden bg-gray-100 dark:bg-gray-800">
                                <img src="{{ asset('storage/' . $product->main_image) }}" 
                                     class="h-10 w-10 object-cover" alt="{{ $product->name }}"
                                     onerror="this.src='{{ asset('images/product-placeholder.svg') }}'">
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $product->name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">SKU: {{ $product->sku }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $product->category->name ?? 'بدون فئة' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            @if($product->type == 'digital_card')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200">
                                    بطاقة رقمية
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                    حساب
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($product->old_price)
                                <div class="text-sm font-medium text-red-600 dark:text-red-400">{{ number_format($product->price, 2) }} ر.س</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400 line-through">{{ number_format($product->old_price, 2) }} ر.س</div>
                            @else
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ number_format($product->price, 2) }} ر.س</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm {{ $product->stock > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                @if($product->type === 'digital_card')
                                    {{ \App\Models\DigitalCardCode::where('product_id', $product->id)->where('status', 'available')->count() }}
                                @else
                                    {{ $product->stock }}
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $product->status == 'active' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 
                               ($product->status == 'inactive' ? 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' : 'bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200') }}">
                                {{ $product->status == 'active' ? 'نشط' : 
                                   ($product->status == 'inactive' ? 'غير نشط' : 'نفذ المخزون') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <form action="{{ route('admin.products.toggle-featured', $product) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-2xl {{ $product->featured ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}">
                                    ★
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex items-center justify-center space-x-3 space-x-reverse">
                                @if($product->type == 'digital_card')
                                    <a href="{{ route('admin.products.manage-codes', $product) }}" 
                                       class="text-purple-600 dark:text-purple-300 hover:text-purple-900 dark:hover:text-purple-100" 
                                       title="إدارة الأكواد الرقمية">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </a>
                                @elseif($product->type == 'account')
                                    <a href="{{ route('admin.products.show', $product) }}#accountsModal" 
                                       class="text-blue-600 dark:text-blue-300 hover:text-blue-900 dark:hover:text-blue-100" 
                                       title="إدارة الحسابات">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </a>
                                @endif
                                
                                <div class="inline-block">
                                    <select class="product-status-select block w-32 px-2 py-1 text-sm border border-gray-300 dark:border-gray-700 rounded shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100"
                                            data-product-id="{{ $product->id }}" 
                                            data-product-type="{{ $product->type }}">
                                        <option value="">-- الحالة --</option>
                                        <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>نشط</option>
                                        <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                                        <option value="out-of-stock" {{ $product->status == 'out-of-stock' ? 'selected' : '' }}>نفذ المخزون</option>
                                    </select>
                                </div>
                                
                                <a href="{{ route('admin.products.show', $product) }}" class="text-blue-600 dark:text-blue-300 hover:text-blue-900 dark:hover:text-blue-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 dark:text-indigo-300 hover:text-indigo-900 dark:hover:text-indigo-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-200">
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
                        <td colspan="10" class="text-center text-gray-400 dark:text-gray-500 py-8">لا توجد منتجات حالياً</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $products->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection 

@push('scripts')
<script>
    // معالجة أخطاء تحميل الصور
    document.addEventListener('DOMContentLoaded', function() {
        // تعيين القيمة الصحيحة للقائمة المنسدلة بناءً على حالة المنتج
        document.querySelectorAll('.product-status-select').forEach(function(select) {
            const productRow = select.closest('tr');
            const statusCell = productRow.querySelector('td:nth-child(7) span'); // عنصر عرض الحالة
            const statusText = statusCell.textContent.trim();
            const productType = select.getAttribute('data-product-type');
            
            if (statusText === 'نشط') {
                select.value = 'active';
            } else if (statusText === 'غير نشط') {
                select.value = 'inactive';
            } else if (statusText === 'نفذ المخزون') {
                select.value = 'out-of-stock';
            }
        });
        
        document.querySelectorAll('img').forEach(function(img) {
            img.onerror = function() {
                // استبدال الصورة بصورة افتراضية عند حدوث خطأ في التحميل
                if (!this.src.includes('default-avatar.png') && !this.src.includes('product-placeholder.svg')) {
                    this.src = "{{ asset('images/product-placeholder.svg') }}";
                    console.log('تعذر تحميل الصورة:', this.src);
                }
            };
        });

        // عرض مسار الصور في وحدة التحكم للتصحيح
        console.log('مسار العرض:', "{{ asset('storage/products/') }}");
        console.log('المسار الكامل:', "E:\\dl1s\\htdocs\\store\\public\\storage\\products");
        
        // معالجة تغييرات القائمة المنسدلة لحالة المنتج
        document.querySelectorAll('.product-status-select').forEach(function(select) {
            // حفظ القيمة الأصلية
            const originalValue = select.value;
            
            select.addEventListener('change', function() {
                const productId = this.getAttribute('data-product-id');
                const productType = this.getAttribute('data-product-type');
                const selectedValue = this.value;
                
                console.log('تم تحديد: ', selectedValue, 'للمنتج:', productId, 'نوع المنتج:', productType);
                
                // إذا لم يتم اختيار قيمة، فلا تفعل شيئًا
                if (!selectedValue) {
                    return;
                }
                
                // إذا تم اختيار نفذ المخزون، تأكد من أن النوع هو بطاقة رقمية وعرض تأكيد
                if (selectedValue === 'out-of-stock') {
                    if (productType !== 'digital_card') {
                        alert('يمكن استخدام هذه الميزة فقط مع البطاقات الرقمية');
                        this.value = originalValue;
                        return;
                    }
                    
                    if (!confirm('هل أنت متأكد من تعيين هذا المنتج كـ نفذ المخزون؟ سيظل المخزون والأكواد المتاحة كما هي، لكن المنتج لن يكون متاحًا للشراء.')) {
                        this.value = originalValue;
                        return;
                    }
                }
                
                // إنشاء نموذج وإرساله مباشرة
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ url('admin/products') }}/" + productId + "/toggle-status";
                
                // إضافة CSRF token
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfInput);
                
                // إضافة حقل الحالة
                const statusInput = document.createElement('input');
                statusInput.type = 'hidden';
                statusInput.name = 'status';
                statusInput.value = selectedValue;
                form.appendChild(statusInput);
                
                // إضافة النموذج للصفحة وإرساله
                document.body.appendChild(form);
                form.submit();
            });
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.product-status-select').forEach(function(select) {
        // حفظ القيمة الأصلية
        const originalValue = select.value;

        select.addEventListener('change', function() {
            const productId = this.getAttribute('data-product-id');
            const productType = this.getAttribute('data-product-type');
            const selectedValue = this.value;

            if (!selectedValue) return;

            if (selectedValue === 'out-of-stock') {
                if (productType !== 'digital_card') {
                    alert('يمكن استخدام هذه الميزة فقط مع البطاقات الرقمية');
                    this.value = originalValue;
                    return;
                }
                if (!confirm('هل أنت متأكد من تعيين هذا المنتج كـ نفذ المخزون؟ سيظل المخزون والأكواد المتاحة كما هي، لكن المنتج لن يكون متاحًا للشراء.')) {
                    this.value = originalValue;
                    return;
                }
            }

            // إنشاء نموذج وإرساله مباشرة
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ url('admin/products') }}/" + productId + "/toggle-status";

            // إضافة CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);

            // إضافة حقل الحالة
            const statusInput = document.createElement('input');
            statusInput.type = 'hidden';
            statusInput.name = 'status';
            statusInput.value = selectedValue;
            form.appendChild(statusInput);

            document.body.appendChild(form);
            form.submit();
        });
    });
});
</script>
@endpush 