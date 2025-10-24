@extends('themes.admin.layouts.app')
@section('title', 'إدارة الصفحة الرئيسية')

@section('content')
<div class="container-fluid px-4 py-6">
    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow overflow-hidden flex flex-col h-full">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-primary-600 dark:bg-primary-700 text-white">
                    <h4 class="text-lg font-semibold flex items-center"><i class="fas fa-list mr-2"></i> أقسام الصفحة الرئيسية</h4>
                </div>
                <div class="p-6 flex-1 flex flex-col">
                    <p class="text-gray-700 dark:text-gray-200">التحكم في ظهور وترتيب أقسام الصفحة الرئيسية مثل المنتجات المميزة والتصنيفات وغيرها.</p>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700 mt-4">
                        @foreach($homeSections as $section)
                            <div class="flex items-center justify-between py-2">
                                @php
                                    $keyLabels = [
                                        'featured_products' => 'المنتجات المميزة',
                                        'latest_products' => 'أحدث المنتجات',
                                        'best_sellers' => 'الأكثر مبيعاً',
                                        'categories' => 'تصفح حسب التصنيف',
                                    ];
                                @endphp
                                <span class="flex items-center">
                                    <i class="fas fa-{{ $section->key == 'categories' ? 'tags' : 'cube' }} mr-2"></i>
                                    <span class="text-gray-800 dark:text-gray-100">{{ $keyLabels[$section->key] ?? $section->key }}</span>
                                </span>
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $section->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                    {{ $section->is_active ? 'مفعل' : 'معطل' }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('admin.home-sections.index') }}" class="w-full inline-flex items-center justify-center px-4 py-2 bg-primary-600 hover:bg-primary-700 dark:bg-primary-700 dark:hover:bg-primary-800 text-white rounded shadow text-sm">
                            <i class="fas fa-cog ml-1"></i> إدارة أقسام الصفحة
                        </a>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow overflow-hidden flex flex-col h-full">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-info-600 dark:bg-info-700 text-white">
                    <h4 class="text-lg font-semibold flex items-center"><i class="fas fa-sliders-h mr-2"></i> السلايدر الرئيسي</h4>
                </div>
                <div class="p-6 flex-1 flex flex-col">
                    <p class="text-gray-700 dark:text-gray-200">إدارة الصور والعروض الترويجية في السلايدر الرئيسي. يمكنك إضافة وإزالة وتعديل الشرائح.</p>
                    <div class="text-center mb-3">
                        <img src="{{ asset('images/slider-icon.png') }}" alt="السلايدر الرئيسي" class="mx-auto border rounded dark:border-gray-700" style="max-height: 150px; opacity: 0.7;">
                    </div>
                    <a href="{{ route('admin.home-sliders.index') }}" class="w-full inline-flex items-center justify-center px-4 py-2 bg-info-600 hover:bg-info-700 dark:bg-info-700 dark:hover:bg-info-800 text-white rounded shadow text-sm mb-2">
                        <i class="fas fa-images ml-1"></i> إدارة السلايدر
                    </a>
                    <a href="{{ route('admin.home-sliders.create') }}" class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800 text-white rounded shadow text-sm">
                        <i class="fas fa-plus ml-1"></i> إضافة شريحة جديدة
                    </a>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow overflow-hidden mt-6">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-success-600 dark:bg-success-700 text-white">
                <h4 class="text-lg font-semibold flex items-center"><i class="fas fa-eye mr-2"></i> معاينة التغييرات</h4>
            </div>
            <div class="p-6">
                <p class="text-gray-700 dark:text-gray-200">بعد إجراء التغييرات، يمكنك معاينة الصفحة الرئيسية لرؤية النتيجة النهائية.</p>
                <a href="{{ url('/') }}" target="_blank" class="w-full inline-flex items-center justify-center px-4 py-2 border border-success-600 dark:border-success-700 text-success-700 dark:text-success-200 bg-white dark:bg-gray-900 hover:bg-success-50 dark:hover:bg-success-900 rounded shadow text-lg mt-4">
                    <i class="fas fa-external-link-alt ml-1"></i> فتح الصفحة الرئيسية في نافذة جديدة
                </a>
            </div>
        </div>
        <div class="bg-info-100 border border-info-400 text-info-700 px-4 py-3 rounded relative dark:bg-info-900 dark:border-info-700 dark:text-info-200 mt-6">
            <i class="fas fa-info-circle mr-2"></i>
            <strong>ملاحظة:</strong> يتم تحديث الصفحة الرئيسية آلياً بمجرد حفظ التغييرات في أي قسم.
        </div>
    </div>
</div>
@endsection 