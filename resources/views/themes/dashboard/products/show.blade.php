@extends('themes.admin.layouts.app')

@section('title', 'تفاصيل المنتج: ' . $product->name)

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">تفاصيل المنتج</h1>
        <div class="flex space-x-2 space-x-reverse">
            <a href="{{ route('admin.products.edit', $product) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded shadow ml-3">
                تعديل المنتج
            </a>
            <a href="{{ route('admin.products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded shadow">
                العودة للمنتجات
            </a>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="md:flex">
            <!-- صور المنتج -->
            <div class="md:w-1/3 bg-gray-50 p-6">
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $product->main_image) }}" 
                         alt="{{ $product->name }}"
                         class="w-full h-auto rounded-lg shadow"
                         onerror="this.src='{{ asset('images/product-placeholder.svg') }}'">
                </div>
                
                @if($product->gallery)
                    <div class="grid grid-cols-3 gap-2 mt-4">
                        @foreach(json_decode($product->gallery, true) as $image)
                            <div class="rounded-lg overflow-hidden shadow">
                                <img src="{{ asset('storage/' . $image) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-auto"
                                     onerror="this.src='{{ asset('images/product-placeholder.svg') }}'">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            
            <!-- تفاصيل المنتج -->
            <div class="md:w-2/3 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $product->name }}</h2>
                        <p class="text-sm text-gray-500">SKU: {{ $product->sku }}</p>
                    </div>
                    
                    <div>
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                            {{ $product->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->status == 'active' ? 'نشط' : 'غير نشط' }}
                        </span>
                        
                        @if($product->featured)
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 mr-2">
                                منتج مميز
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="border-t border-gray-200 pt-4">
                    <dl class="divide-y divide-gray-200">
                        <div class="py-3 grid grid-cols-3">
                            <dt class="text-sm font-medium text-gray-500">الفئة</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ $product->category->name ?? 'بدون فئة' }}</dd>
                        </div>
                        
                        <div class="py-3 grid grid-cols-3">
                            <dt class="text-sm font-medium text-gray-500">السعر الأساسي</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ number_format($product->price, 2) }} ر.س</dd>
                        </div>
                        
                        @if($product->old_price)
                        <div class="py-3 grid grid-cols-3">
                            <dt class="text-sm font-medium text-gray-500">سعر العرض</dt>
                            <dd class="text-sm text-red-600 font-semibold col-span-2">{{ number_format($product->price, 2) }} ر.س</dd>
                        </div>
                        
                        <div class="py-3 grid grid-cols-3">
                            <dt class="text-sm font-medium text-gray-500">السعر الأصلي</dt>
                            <dd class="text-sm text-gray-500 line-through col-span-2">{{ number_format($product->old_price, 2) }} ر.س</dd>
                        </div>
                        
                        <div class="py-3 grid grid-cols-3">
                            <dt class="text-sm font-medium text-gray-500">نسبة الخصم</dt>
                            <dd class="text-sm text-red-600 font-semibold col-span-2">
                                {{ number_format((($product->old_price - $product->price) / $product->old_price) * 100, 0) }}%
                            </dd>
                        </div>
                        @endif
                        
                        <div class="py-3 grid grid-cols-3">
                            <dt class="text-sm font-medium text-gray-500">المخزون</dt>
                            <dd class="text-sm {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }} col-span-2">
                                {{ $product->stock }}
                            </dd>
                        </div>
                        
                        <div class="py-3 grid grid-cols-3">
                            <dt class="text-sm font-medium text-gray-500">تاريخ الإنشاء</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ $product->created_at->format('Y-m-d') }}</dd>
                        </div>
                        
                        <div class="py-3 grid grid-cols-3">
                            <dt class="text-sm font-medium text-gray-500">آخر تحديث</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ $product->updated_at->format('Y-m-d') }}</dd>
                        </div>
                    </dl>
                </div>
                
                <div class="border-t border-gray-200 pt-4 mt-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">وصف المنتج</h3>
                    <div class="prose text-gray-700 max-w-none">
                        {{ $product->description }}
                    </div>
                </div>
                @if($product->type === 'account')
                <div class="mt-8">
                    <button type="button" onclick="openAccountsModal()" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded shadow">
                        إدارة الحسابات
                    </button>
                </div>
                <!-- مودال إدارة الحسابات -->
                <div id="accountsModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
                    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 relative">
                        <h2 class="text-xl font-bold mb-4">إدارة الحسابات المرتبطة بالمنتج</h2>
                        <div id="accountsList" class="space-y-4 max-h-96 overflow-y-auto">
                            @foreach($product->account_digetals as $account)
                                <div class="relative border rounded p-3 mb-2">
                                    <form method="POST" action="{{ route('admin.products.accounts.update', ['product' => $product->id, 'account' => $account->id]) }}" class="mb-2">
                                        @csrf
                                        @method('PUT')
                                        <textarea name="text" rows="3" class="block w-full border-gray-300 rounded-md">{{ $account->meta['text'] ?? '' }}</textarea>
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded mt-2">تحديث</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.products.accounts.destroy', ['product' => $product->id, 'account' => $account->id]) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">حذف</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                        <form method="POST" action="{{ route('admin.products.accounts.store', $product) }}" class="mt-4">
                            @csrf
                            <textarea name="text" rows="3" class="block w-full border-gray-300 rounded-md" placeholder="أدخل بيانات الحساب الجديد"></textarea>
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded mt-2">إضافة حساب جديد</button>
                        </form>
                        <div class="flex justify-end mt-6 gap-2">
                            <button type="button" onclick="closeAccountsModal()" class="bg-gray-400 hover:bg-gray-500 text-white py-2 px-4 rounded">إلغاء</button>
                        </div>
                        <button type="button" onclick="closeAccountsModal()" class="absolute top-2 left-2 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    @if($product->custom_fields || $product->price_options)
    <div class="mt-8 bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-yellow-200 dark:border-yellow-700 overflow-hidden">
        <div class="bg-yellow-50 dark:bg-yellow-900 px-4 py-3 border-b dark:border-yellow-800 flex items-center">
            <h3 class="text-lg font-bold text-yellow-800 dark:text-yellow-200">تفاصيل التخصيص للمنتج</h3>
            <span class="mr-2 px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">مخصص</span>
        </div>
        <div class="p-4 space-y-6">
            @if($product->custom_fields)
                @php
                    $customFields = is_string($product->custom_fields) ? json_decode($product->custom_fields, true) : $product->custom_fields;
                @endphp
                <div class="bg-white dark:bg-gray-900 rounded-md border border-gray-200 dark:border-gray-700 p-3">
                    <h5 class="font-medium text-gray-700 dark:text-gray-200 mb-2">الحقول المخصصة:</h5>
                    <div class="space-y-2">
                        @foreach($customFields as $field)
                            <div class="flex items-center gap-2 border border-gray-100 dark:border-gray-700 rounded bg-gray-50 dark:bg-gray-800 p-3">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ $field['label'] ?? $field['name'] ?? '-' }}:</span>
                                <span class="text-sm text-gray-600 dark:text-gray-300">{{ $field['type'] ?? '-' }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            @if($product->price_options)
                @php
                    $priceOptions = is_string($product->price_options) ? json_decode($product->price_options, true) : $product->price_options;
                @endphp
                <div class="bg-white dark:bg-gray-900 rounded-md border border-gray-200 dark:border-gray-700 p-3">
                    <h5 class="font-medium text-gray-700 dark:text-gray-200 mb-2">خيارات السعر:</h5>
                    <div class="space-y-2">
                        @foreach($priceOptions as $option)
                            <div class="flex items-center gap-2 border border-gray-100 dark:border-gray-700 rounded bg-gray-50 dark:bg-gray-800 p-3">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ $option['quantity'] ?? $option['name'] ?? '-' }}</span>
                                <span class="text-sm text-gray-600 dark:text-gray-300">:
                                    {{ isset($option['price']) ? number_format($option['price'], 2) . ' ر.س' : '-' }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
    @endif
    
    <div class="flex justify-between items-center">
        <div>
            <a href="{{ route('admin.products.edit', $product) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded shadow">
                تعديل المنتج
            </a>
        </div>
        
        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟');">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded shadow">
                حذف المنتج
            </button>
        </form>
    </div>
</div>
@endsection 

@push('scripts')
<script>
    // معالجة أخطاء تحميل الصور
    document.addEventListener('DOMContentLoaded', function() {
        // صورة افتراضية للصور التي لا يمكن تحميلها
        const placeholderImage = "{{ asset('images/product-placeholder.svg') }}";
        
        // معالجة أخطاء تحميل جميع الصور
        document.querySelectorAll('img').forEach(function(img) {
            if (!img.hasAttribute('onerror')) {
                img.onerror = function() {
                    if (!this.src.includes('product-placeholder.svg')) {
                        console.log('تعذر تحميل الصورة:', this.src);
                        this.src = placeholderImage;
                    }
                };
            }
        });
        
        // عرض مسار الصور في وحدة التحكم للتصحيح
        console.log('مسار الصور:', "{{ asset('storage/products/') }}");
    });

    function openAccountsModal() {
        document.getElementById('accountsModal').classList.remove('hidden');
    }
    function closeAccountsModal() {
        document.getElementById('accountsModal').classList.add('hidden');
    }
</script>
@endpush 