@extends('themes.admin.layouts.app')
@section('title', 'إضافة رابط جديد')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">إضافة رابط جديد</h1>
        <a href="{{ route('admin.pages.index') }}" class="bg-gray-500 hover:bg-gray-600 dark:bg-gray-700 dark:hover:bg-gray-800 text-white py-2 px-4 rounded shadow">
            <i class="fas fa-arrow-right ml-1"></i> رجوع
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
    
    <!-- Create Form -->
    <div class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-xl shadow-2xl p-8">
        <form action="{{ route('admin.menu-links.store') }}" method="POST">
            @csrf
            
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- القسم -->
                    <div>
                        <label for="section" class="block text-sm font-medium text-gray-700 dark:text-gray-200">القسم <span class="text-red-600">*</span></label>
                        <select name="section" id="section" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-[#111827] dark:text-white rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                            <option value="quick_links" {{ $section == 'quick_links' ? 'selected' : '' }}>روابط سريعة</option>
                            <option value="policies" {{ $section == 'policies' ? 'selected' : '' }}>سياسات المتجر</option>
                        </select>
                        @error('section')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- الترتيب -->
                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700 dark:text-gray-200">الترتيب</label>
                        <input type="number" name="order" id="order" value="{{ old('order') }}" min="0" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-[#111827] dark:text-white rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">اترك فارغًا للإضافة في نهاية القائمة</p>
                        @error('order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- نوع الرابط -->
                <div>
                    <label for="url_type" class="block text-sm font-medium text-gray-700 dark:text-gray-200">نوع الرابط <span class="text-red-600">*</span></label>
                    <select name="url_type" id="url_type" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-[#111827] dark:text-white rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required onchange="toggleUrlInput()">
                        <option value="relative" {{ old('url_type', 'relative') == 'relative' ? 'selected' : '' }}>مسار نسبي (داخلي)</option>
                        <option value="absolute" {{ old('url_type') == 'absolute' ? 'selected' : '' }}>رابط خارجي (http/https)</option>
                    </select>
                </div>
                
                <!-- العنوان -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-200">العنوان <span class="text-red-600">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-[#111827] dark:text-white rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- الرابط -->
                <div id="relative_url_div" style="display: {{ old('url_type', 'relative') == 'relative' ? 'block' : 'none' }};">
                    <label for="url_relative" class="block text-sm font-medium text-gray-700 dark:text-gray-200">المسار النسبي <span class="text-red-600">*</span></label>
                    <input type="text" name="url" id="url_relative" value="{{ old('url') }}" placeholder="مثال: /page/terms" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-[#111827] dark:text-white rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">يجب أن يبدأ بـ / (مسار داخلي للموقع)</p>
                    @error('url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div id="absolute_url_div" style="display: {{ old('url_type') == 'absolute' ? 'block' : 'none' }};">
                    <label for="url_absolute" class="block text-sm font-medium text-gray-700 dark:text-gray-200">الرابط الخارجي <span class="text-red-600">*</span></label>
                    <input type="text" name="url" id="url_absolute" value="{{ old('url') }}" placeholder="مثال: https://example.com" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-[#111827] dark:text-white rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">يجب أن يبدأ بـ http:// أو https:// (رابط خارجي)</p>
                    @error('url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- الحالة -->
                <div class="mt-4 relative flex items-start">
                    <div class="flex items-center h-5">
                        <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-700 dark:bg-[#111827] dark:text-white rounded">
                    </div>
                    <div class="mr-3 text-sm">
                        <label for="is_active" class="font-medium text-gray-700 dark:text-gray-200">تفعيل الرابط</label>
                        <p class="text-gray-500 dark:text-gray-400">الروابط الغير مفعلة لن تظهر في الموقع</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 sm:px-6 flex justify-end border-t border-gray-200 dark:border-gray-700">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-900">
                    <i class="fas fa-save ml-1"></i> حفظ الرابط
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleUrlInput() {
        var type = document.getElementById('url_type').value;
        var rel = document.getElementById('relative_url_div');
        var abs = document.getElementById('absolute_url_div');
        var relInput = document.getElementById('url_relative');
        var absInput = document.getElementById('url_absolute');
        if (type === 'relative') {
            rel.style.display = 'block';
            relInput.disabled = false;
            abs.style.display = 'none';
            absInput.disabled = true;
        } else {
            rel.style.display = 'none';
            relInput.disabled = true;
            abs.style.display = 'block';
            absInput.disabled = false;
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        toggleUrlInput();
    });
</script>
@endsection 