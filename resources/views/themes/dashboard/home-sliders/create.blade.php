@extends('themes.admin.layouts.app')
@section('title', 'إضافة سلايدر جديد')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">إضافة سلايدر جديد</h1>
        <a href="{{ route('admin.home-sliders.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded shadow dark:bg-blue-700 dark:hover:bg-blue-800">
            <i class="fas fa-arrow-right ml-1"></i> العودة للقائمة
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
    
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative dark:bg-red-900 dark:border-red-700 dark:text-red-200">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="bg-white rounded-lg shadow overflow-hidden dark:bg-gray-900">
        <div class="p-6">
            <form action="{{ route('admin.home-sliders.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2 space-y-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-200">العنوان <span class="text-red-600">*</span></label>
                            <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100" value="{{ old('title') }}" required>
                        </div>
                        
                        <div>
                            <label for="subtitle" class="block text-sm font-medium text-gray-700 dark:text-gray-200">العنوان الفرعي</label>
                            <textarea name="subtitle" id="subtitle" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100">{{ old('subtitle') }}</textarea>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="button_text" class="block text-sm font-medium text-gray-700 dark:text-gray-200">نص الزر الأساسي</label>
                                <input type="text" name="button_text" id="button_text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100" value="{{ old('button_text') }}">
                            </div>
                            
                            <div>
                                <label for="button_url" class="block text-sm font-medium text-gray-700 dark:text-gray-200">رابط الزر الأساسي</label>
                                <input type="text" name="button_url" id="button_url" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100" value="{{ old('button_url') }}">
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="secondary_button_text" class="block text-sm font-medium text-gray-700 dark:text-gray-200">نص الزر الثانوي</label>
                                <input type="text" name="secondary_button_text" id="secondary_button_text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100" value="{{ old('secondary_button_text') }}">
                            </div>
                            
                            <div>
                                <label for="secondary_button_url" class="block text-sm font-medium text-gray-700 dark:text-gray-200">رابط الزر الثانوي</label>
                                <input type="text" name="secondary_button_url" id="secondary_button_url" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100" value="{{ old('secondary_button_url') }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-6">
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-200">الصورة <span class="text-red-600">*</span></label>
                            <div class="mt-1 flex items-center">
                                <input type="file" name="image" id="image" class="hidden" accept="image/*" required>
                                <label for="image" class="cursor-pointer bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100 dark:hover:bg-gray-800">
                                    اختر صورة...
                                </label>
                                <span id="file-name" class="mr-2 text-gray-500 text-sm dark:text-gray-300"></span>
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">يفضل أن تكون الصورة بأبعاد 1200×400 بكسل</p>
                            <div class="mt-2">
                                <img id="image-preview" src="{{ asset('images/placeholder-image.jpg') }}" alt="معاينة الصورة" class="mt-2 h-40 w-full object-cover rounded border dark:border-gray-700">
                            </div>
                        </div>
                        
                        <div>
                            <label for="sort_order" class="block text-sm font-medium text-gray-700 dark:text-gray-200">الترتيب</label>
                            <input type="number" name="sort_order" id="sort_order" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100" value="{{ old('sort_order', 0) }}" min="0">
                        </div>
                        
                        <div class="relative flex items-start">
                            <div class="flex h-5 items-center">
                                <input type="checkbox" id="is_active" name="is_active" value="1" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700">
                                <input type="hidden" name="is_active_hidden" value="0">
                            </div>
                            <div class="mr-3 text-sm">
                                <label for="is_active" class="font-medium text-gray-700 dark:text-gray-200">تفعيل السلايدر</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 flex justify-start space-x-3 space-x-reverse">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded shadow dark:bg-green-700 dark:hover:bg-green-800">
                        <i class="fas fa-save ml-1"></i> حفظ
                    </button>
                    <a href="{{ route('admin.home-sliders.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded shadow dark:bg-gray-700 dark:hover:bg-gray-800">
                        <i class="fas fa-times ml-1"></i> إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // عرض معاينة للصورة عند اختيارها
    document.addEventListener('DOMContentLoaded', function () {
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('image-preview');
        const fileName = document.getElementById('file-name');
        
        if (imageInput && imagePreview) {
            imageInput.addEventListener('change', function (e) {
                if (e.target.files && e.target.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function (e) {
                        imagePreview.src = e.target.result;
                    }
                    
                    reader.readAsDataURL(e.target.files[0]);
                    
                    // تحديث اسم الملف المختار
                    if (fileName) {
                        fileName.textContent = e.target.files[0].name;
                    }
                }
            });
        }
    });
</script>
@endpush 