@extends('themes.admin.layouts.app')

@section('title', isset($section) ? 'تعديل قسم' : 'إضافة قسم جديد')

@section('content')
<div class="px-4 py-5 bg-white dark:bg-gray-900 min-h-screen">
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
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ isset($section) ? 'تعديل قسم' : 'إضافة قسم جديد' }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ isset($section) ? 'تعديل قسم ' . $section->title : 'إضافة قسم جديد' }}</h1>
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

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
            <h2 class="text-lg font-semibold text-primary-600 dark:text-primary-400">{{ isset($section) ? 'تعديل بيانات القسم' : 'معلومات القسم الجديد' }}</h2>
        </div>
        <div class="p-6">
            <form action="{{ isset($section) ? route('admin.home-sections.update', $section->id) : route('admin.home-sections.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($section))
                    @method('PUT')
                @endif
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">عنوان القسم <span class="text-red-500">*</span></label>
                        <input type="text" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-900 dark:text-gray-100 @error('title') border-red-500 dark:border-red-500 @enderror" id="title" name="title" value="{{ $section->title ?? old('title') }}" required>
                        <small class="block mt-1 text-xs text-gray-500 dark:text-gray-400">العنوان الرئيسي الذي سيظهر في أعلى القسم على الصفحة الرئيسية.</small>
                        @error('title')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                </div>
                
                    <div>
                        <label for="subtitle" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">العنوان الفرعي</label>
                        <input type="text" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-900 dark:text-gray-100 @error('subtitle') border-red-500 dark:border-red-500 @enderror" id="subtitle" name="subtitle" value="{{ $section->subtitle ?? old('subtitle') }}">
                        <small class="block mt-1 text-xs text-gray-500 dark:text-gray-400">العنوان الفرعي الذي سيظهر تحت العنوان الرئيسي (اختياري).</small>
                        @error('subtitle')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">نوع القسم <span class="text-red-500">*</span></label>
                        <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-900 dark:text-gray-100 @error('type') border-red-500 dark:border-red-500 @enderror" id="type" name="type" required>
                        <option value="">-- اختر نوع القسم --</option>
                            <option value="featured" {{ (isset($section) && $section->type === 'featured') || old('type') === 'featured' ? 'selected' : '' }}>منتجات مميزة</option>
                            <option value="latest" {{ (isset($section) && $section->type === 'latest') || old('type') === 'latest' ? 'selected' : '' }}>أحدث المنتجات</option>
                            <option value="best_sellers" {{ (isset($section) && $section->type === 'best_sellers') || old('type') === 'best_sellers' ? 'selected' : '' }}>الأكثر مبيعاً</option>
                            <option value="category" {{ (isset($section) && $section->type === 'category') || old('type') === 'category' ? 'selected' : '' }}>تصنيف محدد</option>
                            <option value="custom" {{ (isset($section) && $section->type === 'custom') || old('type') === 'custom' ? 'selected' : '' }}>مخصص</option>
                            <option value="browse_categories" {{ (isset($section) && $section->type === 'browse_categories') || old('type') === 'browse_categories' ? 'selected' : '' }}>تصفح حسب التصنيف</option>
                            <option value="store_features" {{ (isset($section) && $section->type === 'store_features') || old('type') === 'store_features' ? 'selected' : '' }}>مميزات المتجر</option>
                            <option value="testimonials" {{ (isset($section) && $section->type === 'testimonials') || old('type') === 'testimonials' ? 'selected' : '' }}>آراء العملاء</option>
                            <option value="newsletter" {{ (isset($section) && $section->type === 'newsletter') || old('type') === 'newsletter' ? 'selected' : '' }}>الاشتراك في النشرة البريدية</option>
                            <option value="all" {{ (isset($section) && $section->type === 'all') || old('type') === 'all' ? 'selected' : '' }}>جميع المنتجات</option>
                    </select>
                        <small class="block mt-1 text-xs text-gray-500 dark:text-gray-400">نوع المنتجات التي سيتم عرضها في هذا القسم.</small>
                        @error('type')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                </div>
                
                    <div id="category-selection" class="{{ (!isset($section) || $section->type !== 'category') && old('type') !== 'category' ? 'hidden' : '' }}">
                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">التصنيف <span class="text-red-500">*</span></label>
                        <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-900 dark:text-gray-100 @error('category_id') border-red-500 dark:border-red-500 @enderror" id="category_id" name="category_id">
                        <option value="">-- اختر التصنيف --</option>
                        @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ (isset($section) && $section->category_id == $category->id) || old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                        <small class="block mt-1 text-xs text-gray-500 dark:text-gray-400">اختر التصنيف الذي سيتم عرض منتجاته في هذا القسم.</small>
                        @error('category_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                </div>
                
                    <!-- خيارات القسم المخصص -->
                    <div id="custom-options" class="{{ (!isset($section) || !in_array($section->type, ['custom', 'browse_categories', 'store_features', 'testimonials', 'newsletter'])) && !in_array(old('type'), ['custom', 'browse_categories', 'store_features', 'testimonials', 'newsletter']) ? 'hidden' : '' }} col-span-2 mt-4 border-t pt-4">
                        <h3 class="font-semibold text-gray-700 dark:text-gray-200 mb-3 flex items-center">
                            <svg class="w-5 h-5 ml-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            خيارات القسم المخصص
                        </h3>
                        
                        <div id="section-type-options" class="grid grid-cols-1 gap-4">
                            <!-- هذا القسم سيتم تحديثه ديناميكيًا حسب نوع القسم المختار -->
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">الترتيب</label>
                        <input type="number" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-900 dark:text-gray-100 @error('order') border-red-500 dark:border-red-500 @enderror" id="order" name="order" value="{{ $section->order ?? old('order', 0) }}" min="0">
                        <small class="block mt-1 text-xs text-gray-500 dark:text-gray-400">ترتيب ظهور القسم في الصفحة الرئيسية (الأرقام الأصغر تظهر أولاً).</small>
                        @error('order')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                @php
                    $hideDisplaySettings = in_array(
                        isset($section) ? $section->type : old('type'),
                        ['custom', 'browse_categories', 'store_features', 'testimonials', 'newsletter']
                    );
                @endphp

                <div id="display-settings-section" class="mb-6 p-4 border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 rounded-md {{ $hideDisplaySettings ? 'hidden' : '' }}">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-200 mb-3 flex items-center">
                        <svg class="w-5 h-5 ml-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        إعدادات العرض
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="products_limit" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">عدد المنتجات المعروضة</label>
                            <input type="number" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-900 dark:text-gray-100" id="products_limit" name="settings[products_limit]" 
                        value="{{ isset($section) && isset($section->settings['products_limit']) ? $section->settings['products_limit'] : old('settings.products_limit', 8) }}" min="1" max="24">
                            <small class="block mt-1 text-xs text-gray-500 dark:text-gray-400">عدد المنتجات التي سيتم عرضها في هذا القسم.</small>
                        </div>
                        
                        <div>
                            <label for="display_style" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">نمط العرض</label>
                            <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-900 dark:text-gray-100" id="display_style" name="settings[display_style]">
                                <option value="grid" {{ (isset($section) && isset($section->settings['display_style']) && $section->settings['display_style'] === 'grid') || old('settings.display_style') === 'grid' ? 'selected' : '' }}>شبكة</option>
                                <option value="slider" {{ (isset($section) && isset($section->settings['display_style']) && $section->settings['display_style'] === 'slider') || old('settings.display_style') === 'slider' ? 'selected' : '' }}>سلايدر</option>
                            </select>
                            <small class="block mt-1 text-xs text-gray-500 dark:text-gray-400">طريقة عرض المنتجات في هذا القسم.</small>
                        </div>
                    </div>
                </div>
                
                <div class="mb-6 p-4 border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 rounded-md">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-200 mb-3 flex items-center">
                        <svg class="w-5 h-5 ml-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        حالة النشر
                    </h3>
                    <div class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" id="is_active" name="is_active" value="1"
                            {{ (isset($section) && $section->is_active) || !isset($section) || old('is_active', true) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:translate-x-[-100%] peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:right-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        <span class="mr-3 text-sm font-medium text-gray-700 dark:text-gray-200">تفعيل القسم</span>
                    </div>
                    <small class="block mt-1 text-xs text-gray-500 dark:text-gray-400">إذا كان هذا القسم سيظهر في الصفحة الرئيسية أم لا.</small>
                </div>
                
                <div class="flex justify-end space-x-3 rtl:space-x-reverse border-t border-gray-200 pt-5 mt-6">
                    <a href="{{ route('admin.home-sections.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        إلغاء
                    </a>
                    <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="h-4 w-4 inline-block ml-1 -mt-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        {{ isset($section) ? 'تحديث' : 'إضافة' }}
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
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type');
        const categorySelection = document.getElementById('category-selection');
        const customOptions = document.getElementById('custom-options');
        const sectionTypeOptions = document.getElementById('section-type-options');
        const displaySettingsSection = document.getElementById('display-settings-section');
        
        // عند تغيير نوع القسم
        typeSelect.addEventListener('change', function() {
            // التعامل مع قسم التصنيف
            if (this.value === 'category') {
                categorySelection.classList.remove('hidden');
                document.getElementById('category_id').setAttribute('required', 'required');
            } else {
                categorySelection.classList.add('hidden');
                document.getElementById('category_id').removeAttribute('required');
            }
            
            // التعامل مع القسم المخصص
            if (['custom', 'browse_categories', 'store_features', 'testimonials', 'newsletter'].includes(this.value)) {
                customOptions.classList.remove('hidden');
                loadSectionOptions(this.value);
            } else {
                customOptions.classList.add('hidden');
            }
            
            // إظهار/إخفاء عناصر إعدادات العرض
            if ([
                'custom',
                'browse_categories',
                'store_features',
                'testimonials',
                'newsletter'
            ].includes(this.value)) {
                displaySettingsSection.classList.add('hidden');
            } else {
                displaySettingsSection.classList.remove('hidden');
            }
        });
        
        // تنفيذ التحقق الأولي عند تحميل الصفحة
        if (typeSelect.value === 'category') {
            categorySelection.classList.remove('hidden');
            document.getElementById('category_id').setAttribute('required', 'required');
        }
        
        if (['custom', 'browse_categories', 'store_features', 'testimonials', 'newsletter'].includes(typeSelect.value)) {
            customOptions.classList.remove('hidden');
            loadSectionOptions(typeSelect.value);
        }
        
        // تحميل الخيارات المناسبة لكل نوع قسم
        function loadSectionOptions(sectionType) {
            sectionTypeOptions.innerHTML = '';
            
            switch(sectionType) {
                case 'custom':
                    sectionTypeOptions.innerHTML = `
                        <div class="border border-gray-200 dark:border-gray-700 p-4 rounded-md bg-white dark:bg-gray-900">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                    محتوى مخصص
                                </label>
                                <textarea id="custom_content_editor" name="settings[custom_content]" rows="6" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm dark:bg-gray-900 dark:text-gray-100">{{ isset($section) && isset($section->settings['custom_content']) ? $section->settings['custom_content'] : old('settings.custom_content', '') }}</textarea>
                                <small class="block mt-1 text-xs text-blue-600 dark:text-blue-400">يمكنك إضافة نصوص منسقة وروابط وعناوين وصور. يدعم HTML.</small>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">رفع صورة الخلفية</label>
                                <input type="file" name="settings[background_image_file]" accept="image/*" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-900 dark:text-gray-100" onchange="previewCustomBg(event)">
                                <small class="block mt-1 text-xs text-gray-500 dark:text-gray-400">ارفع صورة خلفية (اختياري).</small>
                                <div id="custom-bg-preview" class="mt-2">
                                    @if(isset($section) && isset($section->settings['background_image']) && $section->settings['background_image'])
                                        <img src="{{ asset('storage/' . $section->settings['background_image']) }}" alt="معاينة الخلفية" class="rounded shadow max-h-32">
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                    شفافية الصورة (%)
                                </label>
                                <input type="range" name="settings[image_opacity]" value="{{ isset($section) && isset($section->settings['image_opacity']) ? $section->settings['image_opacity'] : old('settings.image_opacity', '100') }}" min="0" max="100" step="5" class="w-full h-2 bg-gray-200 dark:bg-gray-800 rounded-lg appearance-none cursor-pointer">
                                <div class="flex justify-between mt-1">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">0% (شفاف)</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">100% (معتم)</span>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                    لون الخلفية
                                </label>
                                <input type="color" name="settings[background_color]" value="{{ isset($section) && isset($section->settings['background_color']) ? $section->settings['background_color'] : old('settings.background_color', '#121212') }}" class="h-10 w-full rounded cursor-pointer border border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                                <small class="block mt-1 text-xs text-gray-500 dark:text-gray-400">لون الخلفية الذي سيظهر خلف/مع الصورة.</small>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                    شفافية لون الخلفية (%)
                                </label>
                                <input type="range" name="settings[bg_opacity]" value="{{ isset($section) && isset($section->settings['bg_opacity']) ? $section->settings['bg_opacity'] : old('settings.bg_opacity', '80') }}" min="0" max="100" step="5" class="w-full h-2 bg-gray-200 dark:bg-gray-800 rounded-lg appearance-none cursor-pointer">
                                <div class="flex justify-between mt-1">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">0% (شفاف)</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">100% (معتم)</span>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                    منتجات مخصصة
                                </label>
                                <input type="text" name="settings[custom_products]" value="{{ isset($section) && isset($section->settings['custom_products']) ? $section->settings['custom_products'] : old('settings.custom_products', '') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-900 dark:text-gray-100">
                                <small class="block mt-1 text-xs text-gray-500 dark:text-gray-400">أرقام معرفات المنتجات مفصولة بفواصل، مثال: 1,5,9,12</small>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                    رابط زر الدعوة للعمل
                                </label>
                                <input type="text" name="settings[cta_link]" value="{{ isset($section) && isset($section->settings['cta_link']) ? $section->settings['cta_link'] : old('settings.cta_link', '') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-900 dark:text-gray-100">
                                <small class="block mt-1 text-xs text-gray-500 dark:text-gray-400">الرابط الذي سيفتح عند النقر على زر الدعوة للعمل.</small>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                    نص زر الدعوة للعمل
                                </label>
                                <input type="text" name="settings[cta_text]" value="{{ isset($section) && isset($section->settings['cta_text']) ? $section->settings['cta_text'] : old('settings.cta_text', 'تسوق الآن') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-900 dark:text-gray-100">
                                <small class="block mt-1 text-xs text-gray-500 dark:text-gray-400">النص الذي سيظهر على زر الدعوة للعمل.</small>
                            </div>
                        </div>
                    `;
                    break;
                    
                case 'browse_categories':
                    sectionTypeOptions.innerHTML = '';
                    break;
                    
                case 'store_features':
                    sectionTypeOptions.innerHTML = `
                        <div class="border border-gray-200 p-4 rounded-md bg-white">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">رفع صورة الخلفية</label>
                                <input type="file" name="settings[background_image_file]" accept="image/*" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" onchange="previewStoreFeaturesBg(event)">
                                <small class="block mt-1 text-xs text-gray-500 dark:text-gray-400">ارفع صورة خلفية (اختياري).</small>
                                <div id="store-features-bg-preview" class="mt-2">
                                    @if(isset($section) && isset($section->settings['background_image']) && $section->settings['background_image'])
                                        <img src="{{ asset('storage/' . $section->settings['background_image']) }}" alt="معاينة الخلفية" class="rounded shadow max-h-32">
                                    @endif
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">شفافية صورة الخلفية (%)</label>
                                <input type="range" name="settings[image_opacity]" value="{{ isset($section) && isset($section->settings['image_opacity']) ? $section->settings['image_opacity'] : old('settings.image_opacity', '70') }}" min="0" max="100" step="5" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                                <div class="flex justify-between mt-1">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">0% (شفاف)</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">100% (معتم)</span>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">لون الخلفية</label>
                                <input type="color" name="settings[background_color]" value="{{ isset($section) && isset($section->settings['background_color']) ? $section->settings['background_color'] : old('settings.background_color', '#121212') }}" class="h-10 w-full rounded cursor-pointer border border-gray-300 dark:border-gray-700">
                                <small class="block mt-1 text-xs text-gray-500 dark:text-gray-400">لون الخلفية الذي سيظهر خلف/مع الصورة.</small>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">شفافية لون الخلفية (%)</label>
                                <input type="range" name="settings[bg_opacity]" value="{{ isset($section) && isset($section->settings['bg_opacity']) ? $section->settings['bg_opacity'] : old('settings.bg_opacity', '80') }}" min="0" max="100" step="5" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                                <div class="flex justify-between mt-1">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">0% (شفاف)</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">100% (معتم)</span>
                                </div>
                            </div>
                            <div class="mb-4">
                                <p class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-3">مميزات المتجر (حتى 4 مميزات)</p>
                                
                                <div id="features-list">
                                    @php
                                        $maxFeatures = 6;
                                        $currentFeatures = 0;
                                        for ($i = 1; $i <= $maxFeatures; $i++) {
                                            if (!empty($section->settings['feature_'.$i.'_title']) || !empty($section->settings['feature_'.$i.'_description']) || !empty($section->settings['feature_'.$i.'_icon'])) {
                                                $currentFeatures = $i;
                                            }
                                        }
                                        $currentFeatures = max($currentFeatures, 4); // ابدأ دائماً بـ 4 على الأقل
                                    @endphp
                                    @for ($i = 1; $i <= $maxFeatures; $i++)
                                        <div class="border border-gray-200 p-3 rounded-md mb-3 feature-item" style="display: {{ $i <= $currentFeatures ? 'block' : 'none' }};" data-feature="{{ $i }}">
                                            <div class="flex items-center justify-between mb-2">
                                                <h4 class="font-medium text-gray-800 dark:text-gray-100">الميزة {{ $i }}</h4>
                                                <button type="button" class="text-red-500 hover:text-red-700 text-xl" title="حذف الميزة" onclick="removeFeature({{ $i }})">
                                                    <i class="ri-delete-bin-6-line"></i>
                                                </button>
                                            </div>
                                            <div class="mb-2">
                                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-200 mb-1">العنوان</label>
                                                <input type="text" name="settings[feature_{{ $i }}_title]" value="{{ isset($section) && isset($section->settings['feature_'.$i.'_title']) ? $section->settings['feature_'.$i.'_title'] : old('settings.feature_'.$i.'_title', '') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            </div>
                                            <div class="mb-2">
                                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-200 mb-1">الوصف</label>
                                                <input type="text" name="settings[feature_{{ $i }}_description]" value="{{ isset($section) && isset($section->settings['feature_'.$i.'_description']) ? $section->settings['feature_'.$i.'_description'] : old('settings.feature_'.$i.'_description', '') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            </div>
                                            <div class="mb-2">
                                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-200 mb-1">الأيقونة</label>
                                                <div class="flex items-center gap-2">
                                                    <input type="text" name="settings[feature_{{ $i }}_icon]" id="feature_{{ $i }}_icon" value="{{ isset($section) && isset($section->settings['feature_'.$i.'_icon']) ? $section->settings['feature_'.$i.'_icon'] : old('settings.feature_'.$i.'_icon', '') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                                    <button type="button" class="px-2 py-1 bg-gray-100 border border-gray-300 rounded text-xs hover:bg-gray-200" onclick="showIconPicker({{ $i }})">اختيار أيقونة</button>
                                                </div>
                                                <small class="block mt-1 text-xs text-gray-500 dark:text-gray-400">اسم الأيقونة من RemixIcon (مثال: ri-customer-service-2-line)</small>
                                                <div id="icon-picker-{{ $i }}" class="hidden fixed inset-0 z-50 bg-black bg-opacity-40 flex items-center justify-center">
                                                    <div class="bg-white rounded-lg shadow-lg p-6 max-w-lg w-full relative">
                                                        <button type="button" class="absolute top-2 left-2 text-gray-500 hover:text-red-500" onclick="closeIconPicker({{ $i }})">&times;</button>
                                                        <h4 class="font-bold mb-4">اختر أيقونة</h4>
                                                        <div class="grid grid-cols-4 gap-4 max-h-64 overflow-y-auto">
                                                            <span class="cursor-pointer flex items-center justify-center" onclick="selectIcon('ri-customer-service-2-line', {{ $i }})"><i class="ri-customer-service-2-line text-3xl"></i></span>
                                                            <span class="cursor-pointer flex items-center justify-center" onclick="selectIcon('ri-shield-check-line', {{ $i }})"><i class="ri-shield-check-line text-3xl"></i></span>
                                                            <span class="cursor-pointer flex items-center justify-center" onclick="selectIcon('ri-secure-payment-line', {{ $i }})"><i class="ri-secure-payment-line text-3xl"></i></span>
                                                            <span class="cursor-pointer flex items-center justify-center" onclick="selectIcon('ri-vip-crown-line', {{ $i }})"><i class="ri-vip-crown-line text-3xl"></i></span>
                                                            <span class="cursor-pointer flex items-center justify-center" onclick="selectIcon('ri-star-smile-line', {{ $i }})"><i class="ri-star-smile-line text-3xl"></i></span>
                                                            <span class="cursor-pointer flex items-center justify-center" onclick="selectIcon('ri-gamepad-line', {{ $i }})"><i class="ri-gamepad-line text-3xl"></i></span>
                                                            <span class="cursor-pointer flex items-center justify-center" onclick="selectIcon('ri-customer-service-fill', {{ $i }})"><i class="ri-customer-service-fill text-3xl"></i></span>
                                                            <span class="cursor-pointer flex items-center justify-center" onclick="selectIcon('ri-gift-line', {{ $i }})"><i class="ri-gift-line text-3xl"></i></span>
                                                        </div>
                                                        <div class="mt-6 flex justify-center">
                                                            <button type="button" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 rounded text-gray-700 font-semibold" onclick="closeIconPicker({{ $i }})">إغلاق</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                    <div class="flex justify-end mb-4">
                                        <button type="button" id="add-feature-btn" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-all" onclick="addFeature()" {{ $currentFeatures >= $maxFeatures ? 'style=display:none;' : '' }}>
                                            + إضافة ميزة جديدة
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    break;
                    
                case 'testimonials':
                    sectionTypeOptions.innerHTML = '';
                    break;
                    
                case 'newsletter':
                    sectionTypeOptions.innerHTML = `
                        <div class="border border-gray-200 p-4 rounded-md bg-white">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                    عنوان النشرة
                                </label>
                                <input type="text" name="settings[newsletter_title]" value="{{ isset($section) && isset($section->settings['newsletter_title']) ? $section->settings['newsletter_title'] : old('settings.newsletter_title', 'اشترك في نشرتنا البريدية') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                    وصف النشرة
                                </label>
                                <textarea name="settings[newsletter_description]" rows="2" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ isset($section) && isset($section->settings['newsletter_description']) ? $section->settings['newsletter_description'] : old('settings.newsletter_description', 'اشترك ليصلك كل جديد عن العروض والمنتجات الجديدة') }}</textarea>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                    نص زر الاشتراك
                                </label>
                                <input type="text" name="settings[newsletter_button_text]" value="{{ isset($section) && isset($section->settings['newsletter_button_text']) ? $section->settings['newsletter_button_text'] : old('settings.newsletter_button_text', 'اشتراك') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                    صورة الخلفية (اختياري)
                                </label>
                                <input type="text" name="settings[newsletter_background]" value="{{ isset($section) && isset($section->settings['newsletter_background']) ? $section->settings['newsletter_background'] : old('settings.newsletter_background', '') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                        </div>
                    `;
                    break;
            }
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

        function previewStoreFeaturesBg(event) {
            const preview = document.getElementById('store-features-bg-preview');
            preview.innerHTML = '';
            if (event.target.files && event.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'rounded shadow max-h-32';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(event.target.files[0]);
            }
        }

        window.previewCustomBg = function(event) {
            const preview = document.getElementById('custom-bg-preview');
            preview.innerHTML = '';
            if (event.target.files && event.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'rounded shadow max-h-32';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(event.target.files[0]);
            }
        }

        window.showIconPicker = function(i) {
            document.getElementById('icon-picker-' + i).classList.remove('hidden');
        }
        window.closeIconPicker = function(i) {
            document.getElementById('icon-picker-' + i).classList.add('hidden');
        }
        window.selectIcon = function(icon, i) {
            document.getElementById('feature_' + i + '_icon').value = icon;
            window.closeIconPicker(i);
        }

        window.addFeature = function() {
            var max = {{ $maxFeatures }};
            var features = document.querySelectorAll('.feature-item');
            for (var i = 0; i < features.length; i++) {
                if (features[i].style.display === 'none') {
                    features[i].style.display = 'block';
                    if (i + 1 >= max) {
                        document.getElementById('add-feature-btn').style.display = 'none';
                    }
                    break;
                }
            }
        }

        window.removeFeature = function(i) {
            var feature = document.querySelector('.feature-item[data-feature="' + i + '"]');
            if (feature) {
                // إخفاء الحقل
                feature.style.display = 'none';
                // مسح القيم حتى لا تحفظ في قاعدة البيانات
                var inputs = feature.querySelectorAll('input');
                inputs.forEach(function(input) { input.value = ''; });
            }
            // إظهار زر إضافة ميزة إذا كان مخفي
            document.getElementById('add-feature-btn').style.display = '';
        }

        if(document.getElementById('custom_content_editor')) {
            ClassicEditor
                .create(document.getElementById('custom_content_editor'), {
                    language: 'ar',
                    toolbar: [
                        'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'undo', 'redo', 'blockQuote', 'code', 'codeBlock'
                    ]
                })
                .catch(error => { console.error(error); });
        }
    });
</script>
@endpush 