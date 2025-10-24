@extends('themes.admin.layouts.app')
@section('title', 'تعديل صفحة')

@section('content')
<div class="container-fluid px-4 py-6">
    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">تعديل صفحة</h3>
                <a href="{{ route('admin.pages.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white rounded shadow text-sm">
                    <i class="fas fa-arrow-right ml-1"></i> العودة للقائمة
                </a>
            </div>
            <div class="p-6">
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
                <form action="{{ route('admin.pages.update', $page->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2 space-y-6">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-200">عنوان الصفحة <span class="text-red-600">*</span></label>
                                <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100" value="{{ old('title', $page->title) }}" required>
                            </div>
                            <div>
                                <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-200">الرابط المختصر</label>
                                <input type="text" name="slug" id="slug" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100" value="{{ old('slug', $page->slug) }}">
                                <small class="text-gray-500 dark:text-gray-400">سيتم إنشاؤه تلقائياً إذا تركته فارغاً.</small>
                            </div>
                            <div>
                                <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-200">محتوى الصفحة <span class="text-red-600">*</span></label>
                                <textarea name="content" id="content" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100" rows="15">{{ old('content', $page->content) }}</textarea>
                            </div>
                        </div>
                        <div class="space-y-6">
                            <div class="bg-gray-50 dark:bg-gray-800 rounded-md p-4 border border-gray-200 dark:border-gray-700">
                                <h5 class="font-semibold text-gray-700 dark:text-gray-200 mb-3">النشر</h5>
                                <div class="flex items-center mb-3">
                                    <input type="checkbox" id="is_active" name="is_active" value="1" class="h-4 w-4 rounded border-gray-300 dark:border-gray-700 text-blue-600 focus:ring-blue-500 dark:bg-gray-900" {{ old('is_active', $page->is_active) ? 'checked' : '' }}>
                                    <label for="is_active" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-200">نشر الصفحة</label>
                                </div>
                                <div class="flex items-center mb-3">
                                    <input type="checkbox" id="show_in_menu" name="show_in_menu" value="1" class="h-4 w-4 rounded border-gray-300 dark:border-gray-700 text-blue-600 focus:ring-blue-500 dark:bg-gray-900" {{ old('show_in_menu', $page->show_in_menu) ? 'checked' : '' }}>
                                    <label for="show_in_menu" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-200">إظهار في القائمة</label>
                                </div>
                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800 text-white py-2 px-4 rounded shadow">
                                    <i class="fas fa-save ml-1"></i> حفظ الصفحة
                                </button>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-800 rounded-md p-4 border border-gray-200 dark:border-gray-700">
                                <h5 class="font-semibold text-gray-700 dark:text-gray-200 mb-3">بيانات SEO</h5>
                                <div class="mb-3">
                                    <label for="meta_title" class="block text-sm font-medium text-gray-700 dark:text-gray-200">عنوان SEO</label>
                                    <input type="text" name="meta_title" id="meta_title" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100" value="{{ old('meta_title', $page->meta_title) }}">
                                    <small class="text-gray-500 dark:text-gray-400">إذا تركته فارغاً، سيتم استخدام عنوان الصفحة.</small>
                                </div>
                                <div>
                                    <label for="meta_description" class="block text-sm font-medium text-gray-700 dark:text-gray-200">وصف SEO</label>
                                    <textarea name="meta_description" id="meta_description" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100" rows="3">{{ old('meta_description', $page->meta_description) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.tiny.cloud/1/00n4nzlqgkmwaidq0vo9ii6q8m6sg3orti9rwou0q1zvtsjf/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/langs/ar.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        tinymce.init({
            selector: '#content',
            directionality: 'rtl',
            language: 'ar',
            height: 500,
            plugins: 'preview paste searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
            menubar: 'file edit view insert format tools table help',
            toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen preview save print | insertfile image media template link anchor codesample | ltr rtl',
        });
        // توليد الرابط المختصر تلقائياً
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');
        if (titleInput && slugInput) {
            titleInput.addEventListener('blur', function () {
                if (!slugInput.value.trim()) {
                    const slug = titleInput.value
                        .trim()
                        .toLowerCase()
                        .replace(/[\s_]+/g, '-')
                        .replace(/[^\w\u0621-\u064A\u0660-\u0669-]+/g, '')
                        .replace(/^-+|-+$/g, '');
                    slugInput.value = slug;
                }
            });
        }
    });
</script>
@endpush
