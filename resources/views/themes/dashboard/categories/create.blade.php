@extends('themes.dashboard.layouts.app')

@section('title', 'إضافة تصنيف جديد')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2">إضافة تصنيف جديد</h1>
        <p class="text-gray-600 dark:text-gray-300">أدخل معلومات التصنيف الجديد</p>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-sm p-6">
        <form action="{{ route('dashboard.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">اسم التصنيف <span class="text-red-500">*</span></label>
                    <input type="text" class="bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('name') border-red-500 @enderror" 
                           id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="parent_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">التصنيف الأب</label>
                    <select class="bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('parent_id') border-red-500 @enderror" 
                            id="parent_id" name="parent_id">
                        <option value="">تصنيف رئيسي</option>
                        @foreach($parentCategories as $parentCategory)
                            <option value="{{ $parentCategory->id }}" {{ old('parent_id') == $parentCategory->id ? 'selected' : '' }}>
                                {{ $parentCategory->name }}
                            </option>
                            @foreach($parentCategory->children as $childCategory)
                                <option value="{{ $childCategory->id }}" {{ old('parent_id') == $childCategory->id ? 'selected' : '' }}>
                                    &nbsp;&nbsp;&nbsp;-- {{ $childCategory->name }}
                                </option>
                            @endforeach
                        @endforeach
                    </select>
                    @error('parent_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">وصف التصنيف</label>
                <textarea class="bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('description') border-red-500 @enderror" 
                          id="description" name="description" rows="3">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">صورة التصنيف</label>
                    <input type="file" class="bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('image') border-red-500 @enderror" 
                           id="image" name="image" accept="image/*">
                    <p class="mt-1 text-xs text-gray-500">يُفضل أن تكون الصورة بأبعاد 200×200 بكسل</p>
                    @error('image')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">ترتيب العرض</label>
                    <input type="number" class="bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('sort_order') border-red-500 @enderror" 
                           id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                    @error('sort_order')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="mb-6">
                <div class="flex items-center">
                    <input class="w-4 h-4 text-blue-600 bg-gray-100 dark:bg-gray-800 border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 focus:ring-2 @error('is_active') border-red-500 @enderror" 
                           type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                    <label class="mr-2 text-sm font-medium text-gray-700 dark:text-gray-200" for="is_active">تفعيل التصنيف</label>
                </div>
                @error('is_active')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6 border-t pt-4">
                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-200 mb-3">خيارات العرض في الصفحة الرئيسية</h3>
                
                <div class="flex items-center mb-3">
                    <input class="w-4 h-4 text-blue-600 bg-gray-100 dark:bg-gray-800 border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 focus:ring-2" 
                           type="checkbox" id="show_in_homepage" name="show_in_homepage" value="1" {{ old('show_in_homepage') ? 'checked' : '' }}>
                    <label class="mr-2 text-sm font-medium text-gray-700 dark:text-gray-200" for="show_in_homepage">عرض في الصفحة الرئيسية</label>
                </div>
                
                <div class="mt-3">
                    <label for="homepage_order" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">ترتيب العرض في الصفحة الرئيسية</label>
                    <input type="number" class="bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                           id="homepage_order" name="homepage_order" value="{{ old('homepage_order', 0) }}" min="0">
                    <p class="mt-1 text-xs text-gray-500">الأرقام الأصغر تظهر أولاً</p>
                </div>
            </div>
            
            <div class="flex justify-between">
                <a href="{{ route('dashboard.categories.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-800">إلغاء</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">حفظ</button>
            </div>
        </form>
    </div>
@endsection 