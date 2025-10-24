@extends('themes.admin.layouts.app')
@section('title', 'تعديل قسم الصفحة الرئيسية')

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
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('admin.home-sections.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">أقسام الصفحة الرئيسية</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">تعديل قسم</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">تعديل قسم {{ $section->title }}</h1>
        <h1 class="text-2xl font-bold text-gray-800">تعديل قسم {{ $section->title }}</h1>
        <a href="{{ route('admin.home-sections.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 tracking-wide hover:bg-gray-200 dark:hover:bg-gray-700">
            <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            العودة للقائمة
        </a>
    </div>

    @if ($errors->any())
    <div class="bg-red-100 dark:bg-red-900 border-r-4 border-red-500 dark:border-red-700 text-red-700 dark:text-red-200 px-4 py-3 rounded mb-4 shadow">
        <div class="flex">
            <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 ml-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
            <div>
                <p class="font-bold">يرجى تصحيح الأخطاء التالية:</p>
                <ul class="list-disc list-inside mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
            <h2 class="text-lg font-semibold text-primary-600 dark:text-primary-300">معلومات القسم</h2>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.home-sections.update', $section->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">عنوان القسم</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $section->title) }}" 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 @error('title') border-red-500 @enderror" required>
                        @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-1">العنوان الفرعي</label>
                        <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle', $section->subtitle) }}" 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 @error('subtitle') border-red-500 @enderror">
                        @error('subtitle')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-1">نوع القسم</label>
                        <select id="type" name="type" 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 @error('type') border-red-500 @enderror" required>
                            <option value="">-- اختر نوع القسم --</option>
                            <option value="featured" {{ old('type', $section->type) == 'featured' ? 'selected' : '' }}>منتجات مميزة</option>
                            <option value="latest" {{ old('type', $section->type) == 'latest' ? 'selected' : '' }}>أحدث المنتجات</option>
                            <option value="best_sellers" {{ old('type', $section->type) == 'best_sellers' ? 'selected' : '' }}>الأكثر مبيعاً</option>
                            <option value="category" {{ old('type', $section->type) == 'category' ? 'selected' : '' }}>تصنيف محدد</option>
                            <option value="custom" {{ old('type', $section->type) == 'custom' ? 'selected' : '' }}>مخصص</option>
                        </select>
                        @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div id="category-selection" class="{{ old('type', $section->type) != 'category' ? 'hidden' : '' }}">
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">التصنيف</label>
                        <select id="category_id" name="category_id" 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 @error('category_id') border-red-500 @enderror">
                            <option value="">-- اختر التصنيف --</option>
                            @if(isset($categories) && $categories->count() > 0)
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $section->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700 mb-1">ترتيب القسم</label>
                        <input type="number" id="order" name="order" value="{{ old('order', $section->order) }}" min="0" 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 @error('order') border-red-500 @enderror">
                        @error('order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6 p-4 border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 rounded-md">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-200 mb-3 flex items-center">
                        <svg class="w-5 h-5 ml-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        إعدادات العرض
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="products_limit" class="block text-sm font-medium text-gray-700 mb-1">عدد المنتجات المعروضة</label>
                            <input type="number" id="products_limit" name="settings[products_limit]" value="{{ old('settings.products_limit', $section->settings['products_limit'] ?? 8) }}" min="1" max="24" 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100">
                        </div>
                        <div>
                            <label for="display_style" class="block text-sm font-medium text-gray-700 mb-1">طريقة العرض</label>
                            <select id="display_style" name="settings[display_style]" 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100">
                                <option value="grid" {{ old('settings.display_style', $section->settings['display_style'] ?? '') == 'grid' ? 'selected' : '' }}>شبكة</option>
                                <option value="slider" {{ old('settings.display_style', $section->settings['display_style'] ?? '') == 'slider' ? 'selected' : '' }}>سلايدر</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                @if ($section->content && is_array(json_decode($section->content, true)))
                <div class="mb-6 p-4 border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 rounded-md">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-200 mb-3 flex items-center">
                        <svg class="w-5 h-5 ml-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                        إعدادات خاصة بالقسم
                    </h3>
                    
                    @php 
                        $contentData = json_decode($section->content, true) ?? [];
                    @endphp
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($contentData as $key => $value)
                            <div class="mb-4">
                                <label for="content_{{ $key }}" class="block text-sm font-medium text-gray-700 mb-1">{{ ucwords(str_replace('_', ' ', $key)) }}</label>
                                
                                @if(is_bool($value))
                                    <div class="mt-2">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="content[{{ $key }}]" id="content_{{ $key }}" class="sr-only peer" 
                                                {{ old("content.$key", $value) ? 'checked' : '' }} value="1">
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:translate-x-[-100%] peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:right-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                            <span class="mr-3 text-sm font-medium text-gray-700">{{ $value ? 'مفعل' : 'غير مفعل' }}</span>
                                        </label>
                                    </div>
                                @elseif(is_numeric($value))
                                    <input type="number" id="content_{{ $key }}" name="content[{{ $key }}]" value="{{ old("content.$key", $value) }}" 
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100">
                                @elseif(is_string($value) && strlen($value) > 50)
                                    <textarea id="content_{{ $key }}" name="content[{{ $key }}]" rows="3" 
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100">{{ old("content.$key", $value) }}</textarea>
                                @else
                                    <input type="text" id="content_{{ $key }}" name="content[{{ $key }}]" value="{{ old("content.$key", $value) }}" 
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="mb-6 p-4 border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 rounded-md">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-200 mb-3 flex items-center">
                        <svg class="w-5 h-5 ml-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        حالة النشر
                    </h3>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" id="is_active" value="1" class="sr-only peer" {{ old('is_active', $section->is_active) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:translate-x-[-100%] peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:right-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        <span class="mr-3 text-sm font-medium text-gray-700">تفعيل القسم</span>
                    </label>
                </div>

                <div class="flex justify-end space-x-3 rtl:space-x-reverse border-t border-gray-200 pt-5 mt-6">
                    <a href="{{ route('admin.home-sections.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        إلغاء
                    </a>
                    <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="h-4 w-4 inline-block ml-1 -mt-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        حفظ التغييرات
                    </button>
                </div>
            </form>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type');
        const categorySelection = document.getElementById('category-selection');
        
        // عند تغيير نوع القسم
        typeSelect.addEventListener('change', function() {
            if (this.value === 'category') {
                categorySelection.classList.remove('hidden');
                document.getElementById('category_id').setAttribute('required', 'required');
            } else {
                categorySelection.classList.add('hidden');
                document.getElementById('category_id').removeAttribute('required');
            }
        });
        
        // تنفيذ التحقق الأولي عند تحميل الصفحة
        if (typeSelect.value === 'category') {
            categorySelection.classList.remove('hidden');
            document.getElementById('category_id').setAttribute('required', 'required');
        }
        
        // دالة إظهار رسائل النجاح والخطأ
        function showToast(message, type = 'info') {
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
@endpush 