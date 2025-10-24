<!DOCTYPE html>
<html lang="ar" dir="rtl" style="overflow-y: scroll; -ms-overflow-style: none; scrollbar-width: none;">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>تعديل صفحة: {{ $page->title }}</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" />
    
    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
    
    <style>
        :where([class^="ri-"])::before {
            content: "\f3c2";
        }

        body {
            font-family: 'Cairo', 'Tajawal', sans-serif;
            background-color: #0f172a;
            color: #e2e8f0;
        }

        input:focus,
        textarea:focus,
        select:focus,
        button:focus {
            outline: none;
        }

        .rounded-button {
            border-radius: 8px;
        }

        .ck-editor__editable {
            min-height: 300px;
        }
    </style>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#00e5c9",
                        secondary: "#6b46c1"
                    },
                    borderRadius: {
                        none: "0px",
                        sm: "4px",
                        DEFAULT: "8px",
                        md: "12px",
                        lg: "16px",
                        xl: "20px",
                        "2xl": "24px",
                        "3xl": "32px",
                        full: "9999px",
                        button: "8px",
                    },
                },
            },
        };
    </script>

    <!-- CSS للتحكم في القوائم المنسدلة -->
    <style>
        .s-dropdown-content {
            display: none;
            opacity: 0;
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .s-dropdown-content.show {
            display: block;
            opacity: 1;
            max-height: 500px;
        }

        .s-dropdown-toggle {
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .s-dropdown-toggle:hover {
            color: #10b981;
        }

        .s-transform.rotate-180 {
            transform: rotate(180deg);
        }
    </style>
</head>

<body class="min-h-screen">
    <div class="flex">
        <!-- Sidebar -->
        @include('themes.admin.parts.sidebar')

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Header -->
            @include('themes.admin.parts.header')
            
            <!-- Page Content -->
            <div class="p-6">
                <!-- Header Section -->
                <div class="mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-white mb-2">تعديل صفحة: {{ $page->title }}</h1>
                            <p class="text-gray-400">تعديل معلومات الصفحة</p>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('page.show', $page->slug) }}" target="_blank"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-button flex items-center transition-colors">
                                <i class="ri-eye-line ml-2"></i>
                                <span>عرض الصفحة</span>
                            </a>
                            <a href="{{ route('admin.static-pages.index') }}" 
                                class="bg-gray-700 text-white px-4 py-2 rounded-button flex items-center hover:bg-gray-600 transition-colors">
                                <i class="ri-arrow-right-line ml-2"></i>
                                <span>العودة للقائمة</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('admin.static-pages.update', $page->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <!-- Hidden store_id -->
                    <input type="hidden" name="store_id" value="{{ $page->store_id }}">

                    <!-- Main Info Card -->
                    <div class="bg-gradient-to-br from-[#0f1623] to-[#162033] rounded-lg p-6 border border-gray-700/50">
                        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                            <i class="ri-information-line ml-2 text-primary"></i>
                            المعلومات الأساسية
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-300 mb-2">
                                    عنوان الصفحة <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                    name="title" 
                                    id="title" 
                                    value="{{ old('title', $page->title) }}"
                                    class="w-full bg-[#111827] text-white py-3 px-4 rounded-lg border border-gray-700 focus:border-primary focus:ring-1 focus:ring-primary transition-all @error('title') border-red-500 @enderror"
                                    placeholder="أدخل عنوان الصفحة"
                                    required
                                    onkeyup="generateSlug()">
                                @error('title')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Slug -->
                            <div>
                                <label for="slug" class="block text-sm font-medium text-gray-300 mb-2">
                                    الرابط (Slug) <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                    name="slug" 
                                    id="slug" 
                                    value="{{ old('slug', $page->slug) }}"
                                    class="w-full bg-[#111827] text-white py-3 px-4 rounded-lg border border-gray-700 focus:border-primary focus:ring-1 focus:ring-primary transition-all @error('slug') border-red-500 @enderror"
                                    placeholder="page-slug"
                                    required>
                                <p class="mt-1 text-xs text-gray-400">سيتم إنشاؤه تلقائياً من العنوان</p>
                                @error('slug')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="mt-6">
                            <label for="content" class="block text-sm font-medium text-gray-300 mb-2">
                                محتوى الصفحة
                            </label>
                            <textarea 
                                name="content" 
                                id="content" 
                                class="w-full bg-[#111827] text-white py-3 px-4 rounded-lg border border-gray-700 focus:border-primary focus:ring-1 focus:ring-primary transition-all @error('content') border-red-500 @enderror"
                                rows="10">{{ old('content', $page->content) }}</textarea>
                            @error('content')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- SEO Info Card -->
                    <div class="bg-gradient-to-br from-[#0f1623] to-[#162033] rounded-lg p-6 border border-gray-700/50">
                        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                            <i class="ri-search-eye-line ml-2 text-primary"></i>
                            معلومات SEO
                        </h3>
                        
                        <div class="space-y-6">
                            <!-- Meta Title -->
                            <div>
                                <label for="meta_title" class="block text-sm font-medium text-gray-300 mb-2">
                                    عنوان SEO
                                </label>
                                <input type="text" 
                                    name="meta_title" 
                                    id="meta_title" 
                                    value="{{ old('meta_title', $page->meta_title) }}"
                                    class="w-full bg-[#111827] text-white py-3 px-4 rounded-lg border border-gray-700 focus:border-primary focus:ring-1 focus:ring-primary transition-all @error('meta_title') border-red-500 @enderror"
                                    placeholder="عنوان الصفحة في محركات البحث">
                                @error('meta_title')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Meta Description -->
                            <div>
                                <label for="meta_description" class="block text-sm font-medium text-gray-300 mb-2">
                                    وصف SEO
                                </label>
                                <textarea 
                                    name="meta_description" 
                                    id="meta_description" 
                                    class="w-full bg-[#111827] text-white py-3 px-4 rounded-lg border border-gray-700 focus:border-primary focus:ring-1 focus:ring-primary transition-all @error('meta_description') border-red-500 @enderror"
                                    rows="3"
                                    placeholder="وصف الصفحة في محركات البحث">{{ old('meta_description', $page->meta_description) }}</textarea>
                                @error('meta_description')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Settings Card -->
                    <div class="bg-gradient-to-br from-[#0f1623] to-[#162033] rounded-lg p-6 border border-gray-700/50">
                        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                            <i class="ri-settings-3-line ml-2 text-primary"></i>
                            الإعدادات
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Order -->
                            <div>
                                <label for="order" class="block text-sm font-medium text-gray-300 mb-2">
                                    ترتيب العرض
                                </label>
                                <input type="number" 
                                    name="order" 
                                    id="order" 
                                    value="{{ old('order', $page->order) }}"
                                    min="0"
                                    class="w-full bg-[#111827] text-white py-3 px-4 rounded-lg border border-gray-700 focus:border-primary focus:ring-1 focus:ring-primary transition-all @error('order') border-red-500 @enderror">
                                @error('order')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">
                                    حالة النشر
                                </label>
                                <div class="flex items-center h-[52px]">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $page->is_active) ? 'checked' : '' }} class="sr-only peer">
                                        <div class="w-14 h-7 bg-gray-700 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-primary"></div>
                                        <span class="ms-3 text-sm font-medium text-gray-300">نشط</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Info Card -->
                    <div class="bg-gradient-to-br from-blue-900/20 to-blue-800/20 rounded-lg p-4 border border-blue-700/30">
                        <div class="flex items-start gap-3">
                            <i class="ri-information-line text-blue-400 text-xl mt-0.5"></i>
                            <div class="text-sm text-gray-300">
                                <p class="mb-1"><strong>تاريخ الإنشاء:</strong> {{ $page->created_at->format('Y-m-d H:i') }}</p>
                                <p><strong>آخر تحديث:</strong> {{ $page->updated_at->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between bg-gradient-to-br from-[#0f1623] to-[#162033] rounded-lg p-6 border border-gray-700/50">
                        <div>
                            <a href="{{ route('admin.static-pages.index') }}" 
                                class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white font-medium rounded-button transition-colors inline-block">
                                إلغاء
                            </a>
                        </div>
                        <button type="submit" 
                            class="px-6 py-3 bg-primary hover:bg-primary/90 text-gray-900 font-medium rounded-button transition-colors flex items-center">
                            <i class="ri-save-line ml-2"></i>
                            حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Auto-generate slug from title
        function generateSlug() {
            const title = document.getElementById('title').value;
            const slug = title
                .toLowerCase()
                .trim()
                .replace(/[\s_]+/g, '-')
                .replace(/[^\u0600-\u06FFa-z0-9-]/g, '')
                .replace(/-+/g, '-')
                .replace(/^-+|-+$/g, '');
            
            document.getElementById('slug').value = slug;
        }

        // Initialize CKEditor
        ClassicEditor
            .create(document.querySelector('#content'), {
                language: 'ar',
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'link', '|',
                        'bulletedList', 'numberedList', '|',
                        'blockQuote', 'insertTable', '|',
                        'undo', 'redo'
                    ]
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>
</body>

</html>
