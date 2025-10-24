@extends('themes.admin.layouts.app')

@section('title', 'إضافة منتج جديد')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">إضافة منتج جديد</h1>
        <a href="{{ route('admin.products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded shadow">العودة للمنتجات</a>
    </div>
    
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6">
        <form id="product-form" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            @if ($errors->any())
                <div class="bg-red-100 dark:bg-red-900 border-r-4 border-red-500 text-red-700 dark:text-red-200 p-4 mb-6 rounded">
                    <p class="font-bold">يرجى تصحيح الأخطاء التالية:</p>
                    <ul class="list-disc mr-8 mt-2 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <!-- المعلومات الأساسية -->
            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">المعلومات الأساسية</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">اسم المنتج <span class="text-red-600">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                   class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                        </div>
                        
                        <!-- سويتش تفعيل الرابط المخصص -->
                        <div class="flex items-center mt-2 mb-2">
                            <input type="checkbox" id="custom-slug-switch" name="custom_slug_switch" value="1" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="custom-slug-switch" class="mr-2 block text-sm text-gray-700 dark:text-gray-200">تفعيل رابط مخصص للمنتج</label>
                        </div>
                        
                        <!-- حقل الرابط المخصص (slug) -->
                        <div class="form-group mb-3" id="custom-slug-group" style="display: none;">
                            <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">الرابط المخصص (slug)</label>
                            <input type="text" name="slug" id="slug" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100" placeholder="مثال: snapchat">
                            <small class="form-text text-gray-500 dark:text-gray-400">يمكنك كتابة كلمة واحدة فقط (بدون مسافات أو رموز)، وستظهر في رابط المنتج.</small>
                        </div>
                        
                        <div>
                            <label for="sku" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">رمز المنتج (SKU)</label>
                            <input type="text" name="sku" id="sku" value="{{ old('sku') }}"
                                   class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                        </div>
                        
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">نوع المنتج <span class="text-red-600">*</span></label>
                            <select name="type" id="type" required
                                    class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                                <option value="account" {{ old('type') == 'account' ? 'selected' : '' }}>حساب</option>
                                <option value="digital_card" {{ old('type') == 'digital_card' ? 'selected' : '' }}>بطاقة رقمية</option>
                                <option value="custom" {{ old('type') == 'custom' ? 'selected' : '' }}>منتج مخصص</option>
                            </select>
                        </div>
                        
                        <!-- قسم الحسابات المتاحة (يظهر فقط إذا كان نوع المنتج حساب) -->
                        <div id="accounts_section" class="bg-gray-50 dark:bg-gray-800 rounded-lg shadow p-6 mt-6" style="display: none;">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">الحسابات المتاحة</h3>
                            <div id="accounts_container" class="space-y-4">
                                <!-- سيتم إضافة textareas ديناميكيًا هنا -->
                            </div>
                            <button type="button" id="add_account_btn" class="mt-4 py-2 px-4 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                + إضافة حساب جديد
                            </button>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">كل حساب في textarea منفصل. يمكنك كتابة أي تفاصيل (اسم مستخدم، كلمة مرور، بريد، ...). كل سطر يمثل معلومة.</p>
                            <input type="hidden" name="accounts_json" id="accounts_json">
                        </div>
                        
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">الفئة <span class="text-red-600">*</span></label>
                            <select name="category_id" id="category_id" required
                                    class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                                <option value="">اختر الفئة</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="description">وصف المنتج</label>
                            <div id="quill-editor">{!! old('description') !!}</div>
                            <input type="hidden" name="description" id="description-input">
                        </div>
                        
                        <div>
                            <label for="product_note" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">تعليمات أو شرح خاص لهذا المنتج (اختياري)</label>
                            <textarea name="product_note" id="product_note" rows="3"
                                      class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">{{ old('product_note') }}</textarea>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">يمكنك كتابة تعليمات أو شرح خاص يظهر للعميل عند شراء المنتج (مثلاً: طريقة التفعيل أو ملاحظات هامة).</p>
                        </div>
                    </div>
                    
                    <div class="space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">السعر <span class="text-red-600">*</span></label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0" required
                                           class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 dark:text-gray-400 sm:text-sm">ر.س</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <label for="sale_price" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">السعر الأصلي</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="number" name="sale_price" id="sale_price" value="{{ old('sale_price') }}" step="0.01" min="0"
                                           class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 dark:text-gray-400 sm:text-sm">ر.س</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">المخزون</label>
                            <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" min="0"
                                   class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                        </div>
                        
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">الحالة <span class="text-red-600">*</span></label>
                            <select name="status" id="status" required
                                    class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>نشط</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                            </select>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" name="featured" id="featured" value="1" {{ old('featured') ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="featured" class="mr-2 block text-sm text-gray-700 dark:text-gray-200">عرض في المنتجات المميزة</label>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- الأكواد الرقمية (للبطاقات الرقمية فقط) -->
            <div id="digital_codes_section" class="bg-gray-50 dark:bg-gray-800 rounded-lg shadow p-6" style="display: none;">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">الأكواد الرقمية</h3>
                <div class="space-y-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">أضف الأكواد الرقمية هنا. كل سطر يمثل كود واحد.</p>
                    <textarea name="digital_codes" id="digital_codes" rows="5"
                            class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">{{ old('digital_codes') }}</textarea>
                    <p class="text-xs text-gray-500 dark:text-gray-400">تنسيق الأكواد: كود واحد في كل سطر. مثال: ABC-123-XYZ</p>
                    <div>
                        <button type="button" id="add_code_btn" class="py-2 px-4 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            إضافة كود جديد
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- المنتج المخصص -->
            <div id="custom_fields_section" class="bg-gray-50 dark:bg-gray-800 rounded-lg shadow p-6" style="display: none;">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">الحقول المخصصة</h3>
                <div class="space-y-4">
                    <p class="text-sm text-gray-500">أضف الحقول المخصصة التي تريد جمعها من العميل عند الطلب.</p>
                    
                    <div id="custom_fields_container" class="space-y-3">
                        <!-- هنا سيتم إضافة الحقول المخصصة ديناميكيًا -->
                    </div>
                    
                    <div class="flex space-x-2 space-x-reverse">
                        <button type="button" id="add_custom_field_btn" class="py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            إضافة حقل جديد
                        </button>
                    </div>
                    
                    <input type="hidden" name="custom_fields" id="custom_fields_json" value="{{ old('custom_fields') }}">
                </div>
            </div>
            
            <!-- خيارات السعر المتعددة -->
            <div id="price_options_section" class="bg-gray-50 dark:bg-gray-800 rounded-lg shadow p-6" style="display: none;">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">خيارات السعر المتعددة</h3>
                <div class="space-y-4">
                    <p class="text-sm text-gray-500">أضف خيارات السعر المختلفة حسب الكمية (عدد المتابعين، النقاط، إلخ).</p>
                    
                    <div id="price_options_container" class="space-y-3">
                        <!-- هنا سيتم إضافة خيارات السعر ديناميكيًا -->
                    </div>
                    
                    <div class="flex space-x-2 space-x-reverse">
                        <button type="button" id="add_price_option_btn" class="py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            إضافة خيار سعر
                        </button>
                    </div>
                    
                    <input type="hidden" name="price_options" id="price_options_json" value="{{ old('price_options') }}">
                </div>
            </div>
            
            <!-- صور المنتج -->
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">صور المنتج</h3>
                <div class="flex flex-col md:flex-row md:items-start gap-8">
                    <!-- معاينة الصورة الرئيسية -->
                    <div class="flex flex-col items-center w-full md:w-56">
                        <div class="relative group bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden w-40 h-40 flex items-center justify-center">
                            <img id="mainImagePreviewImg" src="{{ asset('assets/admin/images/no-image.png') }}" alt="معاينة الصورة الرئيسية" class="object-contain w-full h-full">
                            <button type="button" id="removeMainImageBtn" onclick="removeMainImage()" class="absolute top-2 left-2 bg-red-500 hover:bg-red-600 text-white p-2 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity" style="display:none;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <span class="block text-xs text-gray-500 dark:text-gray-400 mt-2">الصورة الرئيسية للمنتج</span>
                        <span class="block text-xs text-gray-400">يفضل مقاس 800×800 بكسل</span>
                    </div>
                    <!-- منطقة السحب والإفلات للصورة الرئيسية -->
                    <div class="flex-1">
                        <div class="drop-zone relative flex items-center justify-center h-48 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition cursor-pointer" id="mainImageDropZone">
                            <input type="file" name="image" id="mainImageInput" class="drop-zone__input absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/jpeg,image/png,image/webp">
                            <div class="flex flex-col items-center justify-center w-full pointer-events-none">
                                <svg class="w-10 h-10 text-gray-400 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                <span class="text-sm text-gray-500 dark:text-gray-400">اختر صورة أو اسحب وأفلت الصورة هنا</span>
                                <span class="text-xs text-gray-400 mt-1">2MB كحد أقصى JPG, PNG, WebP</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- الصور الإضافية -->
                <div class="mt-8">
                    <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-2">صور إضافية للمنتج</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">يمكنك إضافة حتى 10 صور إضافية</p>
                    <div class="drop-zone relative flex items-center justify-center h-40 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition cursor-pointer" id="additionalImagesDropZone">
                        <input type="file" name="gallery[]" id="additionalImagesInput" class="drop-zone__input absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" multiple accept="image/jpeg,image/png,image/webp">
                        <div class="flex flex-col items-center justify-center w-full pointer-events-none">
                            <svg class="w-10 h-10 text-gray-400 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                            <span class="text-sm text-gray-500 dark:text-gray-400">اختر الصور أو اسحب وأفلت الصور هنا</span>
                            <span class="text-xs text-gray-400 mt-1">2MB كحد أقصى JPG, PNG, WebP</span>
                        </div>
                    </div>
                    <div id="additionalImagesPreview" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mt-6"></div>
                    <div id="uploadStatus" class="mt-2 text-xs text-gray-400"></div>
                </div>
            </div>
            
            <!-- SEO والتاغات -->
            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">SEO والتاغات</h3>
                <p class="text-sm text-gray-500 mb-4">المعلومات أدناه تساعد في تحسين ظهور المنتج في محركات البحث مثل Google.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">عنوان صفحة المنتج (Title)</label>
                            <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                   placeholder="عنوان المنتج المُحسّن لمحركات البحث">
                            <p class="mt-1 text-xs text-gray-500">
                                يفضل أن يكون بين 50-60 حرف. إذا تُرك فارغاً، سيتم استخدام اسم المنتج تلقائياً.
                                <span class="text-xs text-blue-500 character-count" data-for="meta_title">0 / 60</span>
                            </p>
                        </div>
                        
                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">وصف الصفحة (Meta Description)</label>
                            <textarea name="meta_description" id="meta_description" rows="3"
                                      class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                      placeholder="اكتب وصفاً موجزاً للمنتج. هذا الوصف يظهر في نتائج البحث.">{{ old('meta_description') }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">
                                يفضل أن يكون بين 150-160 حرف. إذا تُرك فارغاً، سيتم اقتطاع جزء من وصف المنتج تلقائياً.
                                <span class="text-xs text-blue-500 character-count" data-for="meta_description">0 / 160</span>
                            </p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-1">الكلمات المفتاحية (Meta Keywords)</label>
                            <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords') }}"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                   placeholder="كلمات مفتاحية مفصولة بفواصل: كلمة1, كلمة2, كلمة3">
                            <p class="mt-1 text-xs text-gray-500">أدخل الكلمات المفتاحية مفصولة بفواصل. مثال: بطاقة ستور, العاب, هدايا</p>
                        </div>
                        
                        <div>
                            <label for="focus_keyword" class="block text-sm font-medium text-gray-700 mb-1">الكلمة المفتاحية الرئيسية</label>
                            <input type="text" name="focus_keyword" id="focus_keyword" value="{{ old('focus_keyword') }}"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                   placeholder="كلمة أو عبارة رئيسية للمنتج">
                            <p class="mt-1 text-xs text-gray-500">أهم كلمة مفتاحية تريد أن يظهر المنتج عند البحث عنها</p>
                        </div>
                        
                        <div>
                            <label for="tags_list" class="block text-sm font-medium text-gray-700 mb-1">التاغات (وسوم المنتج)</label>
                            <input type="text" name="tags_list" id="tags_list" value="{{ old('tags_list') }}"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                   placeholder="أدخل وسوم المنتج مفصولة بفواصل">
                            <p class="mt-1 text-xs text-gray-500">التاغات تساعد العملاء في العثور على المنتج. مثال: سناب, حساب, مميز</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- أزرار -->
            <div class="pt-5 border-t border-gray-200 dark:border-gray-700">
                <div class="flex justify-start">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded shadow ml-3">
                        حفظ المنتج
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white py-2 px-4 rounded shadow">
                        إلغاء
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
    // إظهار/إخفاء قسم الأكواد الرقمية حسب نوع المنتج
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type');
        const digitalCodesSection = document.getElementById('digital_codes_section');
        const customFieldsSection = document.getElementById('custom_fields_section');
        const priceOptionsSection = document.getElementById('price_options_section');
        
        // تهيئة تاغات المنتج
        initProductTags();
        
        // تحقق من نوع المنتج عند التحميل
        updateSections(typeSelect.value);
        
        // تحديث الأقسام عند تغيير نوع المنتج
        typeSelect.addEventListener('change', function() {
            updateSections(this.value);
        });
        
        function updateSections(type) {
            // إخفاء كل الأقسام أولاً
            digitalCodesSection.style.display = 'none';
            customFieldsSection.style.display = 'none';
            priceOptionsSection.style.display = 'none';
            
            // إظهار الأقسام حسب نوع المنتج
            if (type === 'digital_card') {
                digitalCodesSection.style.display = 'block';
            } else if (type === 'custom') {
                customFieldsSection.style.display = 'block';
                priceOptionsSection.style.display = 'block';
            }
        }
        
        // تهيئة وإدارة تاغات المنتج
        function initProductTags() {
            const tagsInput = document.getElementById('tags_list');
            const tagsContainer = document.createElement('div');
            tagsContainer.className = 'flex flex-wrap gap-2 mt-2';
            tagsContainer.id = 'tags_container';
            
            // إضافة حاوية التاغات بعد حقل الإدخال
            tagsInput.parentNode.insertBefore(tagsContainer, tagsInput.nextSibling);
            
            // إضافة زر لإضافة تاغ جديد
            const addTagButton = document.createElement('button');
            addTagButton.type = 'button';
            addTagButton.className = 'text-xs bg-blue-50 text-blue-700 px-2 py-1 rounded hover:bg-blue-100 mt-2';
            addTagButton.textContent = 'أضف تاغ';
            tagsInput.parentNode.insertBefore(addTagButton, tagsContainer.nextSibling);
            
            // معالجة إضافة تاغ جديد عند النقر على الزر
            addTagButton.addEventListener('click', function() {
                addNewTag();
            });
            
            // معالجة إضافة تاغ جديد عند الضغط على Enter
            tagsInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ',') {
                    e.preventDefault();
                    addNewTag();
                }
            });
            
            // تحميل التاغات الحالية إذا وجدت
            if (tagsInput.value) {
                const tags = tagsInput.value.split(',').map(tag => tag.trim()).filter(tag => tag);
                tags.forEach(tag => {
                    createTagElement(tag);
                });
            }
            
            // إضافة تاغ جديد
            function addNewTag() {
                const tagText = tagsInput.value.trim();
                if (tagText) {
                    // إذا كان النص يحتوي على فواصل، نقسمه إلى عدة تاغات
                    const tags = tagText.split(',').map(tag => tag.trim()).filter(tag => tag);
                    
                    tags.forEach(tag => {
                        createTagElement(tag);
                    });
                    
                    // تفريغ حقل الإدخال
                    tagsInput.value = '';
                    // تحديث قيمة الحقل المخفي
                    updateTagsInputValue();
                }
            }
            
            // إنشاء عنصر تاغ مرئي
            function createTagElement(tagText) {
                // التحقق من عدم وجود تاغ بنفس الاسم
                const existingTags = Array.from(tagsContainer.querySelectorAll('.tag-text')).map(tag => tag.textContent);
                if (existingTags.includes(tagText)) {
                    return;
                }
                
                const tagElement = document.createElement('div');
                tagElement.className = 'inline-flex items-center bg-gray-100 text-gray-800 rounded px-2 py-1 text-sm';
                
                const tagContent = document.createElement('span');
                tagContent.className = 'tag-text';
                tagContent.textContent = tagText;
                
                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'ml-1 text-gray-500 hover:text-gray-700';
                removeButton.innerHTML = '&times;';
                removeButton.addEventListener('click', function() {
                    tagsContainer.removeChild(tagElement);
                    updateTagsInputValue();
                });
                
                tagElement.appendChild(tagContent);
                tagElement.appendChild(removeButton);
                tagsContainer.appendChild(tagElement);
            }
            
            // تحديث قيمة حقل التاغات المخفي
            function updateTagsInputValue() {
                const tags = Array.from(tagsContainer.querySelectorAll('.tag-text')).map(tag => tag.textContent);
                tagsInput.value = tags.join(', ');
            }
        }
        
        // إضافة كود جديد
        document.getElementById('add_code_btn').addEventListener('click', function() {
            const codesTextarea = document.getElementById('digital_codes');
            codesTextarea.value += (codesTextarea.value ? '\n' : '') + '';
            codesTextarea.focus();
            codesTextarea.setSelectionRange(codesTextarea.value.length, codesTextarea.value.length);
        });
        
        // إدارة الحقول المخصصة
        const customFieldsContainer = document.getElementById('custom_fields_container');
        const customFieldsInput = document.getElementById('custom_fields_json');
        let customFields = [];
        
        // تحميل الحقول المخصصة الموجودة (إن وجدت)
        try {
            if (customFieldsInput.value) {
                customFields = JSON.parse(customFieldsInput.value);
                renderCustomFields();
            }
        } catch (e) {
            console.error('خطأ في تحميل الحقول المخصصة:', e);
        }
        
        // إضافة حقل مخصص جديد
        document.getElementById('add_custom_field_btn').addEventListener('click', function() {
            customFields.push({
                label: 'حقل جديد',
                type: 'text',
                required: true
            });
            renderCustomFields();
            updateCustomFieldsJson();
        });
        
        // عرض الحقول المخصصة في واجهة المستخدم
        function renderCustomFields() {
            customFieldsContainer.innerHTML = '';
            
            customFields.forEach((field, index) => {
                const fieldDiv = document.createElement('div');
                fieldDiv.className = 'bg-gray-50 dark:bg-gray-800 p-3 rounded-md';
                fieldDiv.innerHTML = `
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="text-sm font-medium">حقل مخصص #${index + 1}</h4>
                        <button type="button" data-index="${index}" class="remove-custom-field text-red-600 hover:text-red-800 text-sm">
                            حذف
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">عنوان الحقل</label>
                            <input type="text" data-index="${index}" data-property="label" value="${field.label}" 
                                   class="custom-field-input block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">نوع الحقل</label>
                            <select data-index="${index}" data-property="type" 
                                    class="custom-field-input block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                                <option value="text" ${field.type === 'text' ? 'selected' : ''}>نص</option>
                                <option value="email" ${field.type === 'email' ? 'selected' : ''}>بريد إلكتروني</option>
                                <option value="number" ${field.type === 'number' ? 'selected' : ''}>رقم</option>
                                <option value="url" ${field.type === 'url' ? 'selected' : ''}>رابط</option>
                            </select>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="required_${index}" data-index="${index}" data-property="required" 
                                   class="custom-field-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-700 rounded"
                                   ${field.required ? 'checked' : ''}>
                            <label for="required_${index}" class="mr-2 block text-sm text-gray-700 dark:text-gray-200">
                                حقل مطلوب
                            </label>
                        </div>
                    </div>
                `;
                customFieldsContainer.appendChild(fieldDiv);
            });
            
            // إضافة مستمعي الأحداث للحقول الجديدة
            document.querySelectorAll('.remove-custom-field').forEach(btn => {
                btn.addEventListener('click', function() {
                    const index = parseInt(this.dataset.index);
                    customFields.splice(index, 1);
                    renderCustomFields();
                    updateCustomFieldsJson();
                });
            });
            
            document.querySelectorAll('.custom-field-input').forEach(input => {
                input.addEventListener('change', function() {
                    const index = parseInt(this.dataset.index);
                    const property = this.dataset.property;
                    customFields[index][property] = this.value;
                    updateCustomFieldsJson();
                });
            });
            
            document.querySelectorAll('.custom-field-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const index = parseInt(this.dataset.index);
                    const property = this.dataset.property;
                    customFields[index][property] = this.checked;
                    updateCustomFieldsJson();
                });
            });
        }
        
        // تحديث قيمة الحقول المخصصة في الحقل المخفي
        function updateCustomFieldsJson() {
            customFieldsInput.value = JSON.stringify(customFields);
        }
        
        // إدارة خيارات السعر
        const priceOptionsContainer = document.getElementById('price_options_container');
        const priceOptionsInput = document.getElementById('price_options_json');
        let priceOptions = [];
        
        // تحميل خيارات السعر الموجودة (إن وجدت)
        try {
            if (priceOptionsInput.value) {
                priceOptions = JSON.parse(priceOptionsInput.value);
                renderPriceOptions();
            }
        } catch (e) {
            console.error('خطأ في تحميل خيارات السعر:', e);
        }
        
        // إضافة خيار سعر جديد
        document.getElementById('add_price_option_btn').addEventListener('click', function() {
            priceOptions.push({
                quantity: 100,
                price: 10
            });
            renderPriceOptions();
            updatePriceOptionsJson();
        });
        
        // عرض خيارات السعر في واجهة المستخدم
        function renderPriceOptions() {
            priceOptionsContainer.innerHTML = '';
            
            priceOptions.forEach((option, index) => {
                const optionDiv = document.createElement('div');
                optionDiv.className = 'bg-gray-50 dark:bg-gray-800 p-3 rounded-md';
                optionDiv.innerHTML = `
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="text-sm font-medium">خيار السعر #${index + 1}</h4>
                        <button type="button" data-index="${index}" class="remove-price-option text-red-600 hover:text-red-800 text-sm">
                            حذف
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">الكمية أو اسم الباقة</label>
                            <input type="text" data-index="${index}" data-property="quantity" value="${option.quantity || ''}" 
                                   class="price-option-input block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100"
                                   placeholder="مثال: 1000 متابع أو باقة ذهبية">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">السعر (ر.س)</label>
                            <input type="number" data-index="${index}" data-property="price" value="${option.price}" step="0.01"
                                   class="price-option-input block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                        </div>
                    </div>
                `;
                priceOptionsContainer.appendChild(optionDiv);
            });
            
            // إضافة مستمعي الأحداث للحقول الجديدة
            document.querySelectorAll('.remove-price-option').forEach(btn => {
                btn.addEventListener('click', function() {
                    const index = parseInt(this.dataset.index);
                    priceOptions.splice(index, 1);
                    renderPriceOptions();
                    updatePriceOptionsJson();
                });
            });
            
            document.querySelectorAll('.price-option-input').forEach(input => {
                input.addEventListener('change', function() {
                    const index = parseInt(this.dataset.index);
                    const property = this.dataset.property;
                    if (property === 'price') {
                        priceOptions[index][property] = parseFloat(this.value) || 0;
                    } else {
                        priceOptions[index][property] = this.value;
                    }
                    updatePriceOptionsJson();
                });
            });
        }
        
        // تحديث قيمة خيارات السعر في الحقل المخفي
        function updatePriceOptionsJson() {
            priceOptionsInput.value = JSON.stringify(priceOptions);
        }
        
        // حساب عدد الأحرف في حقول SEO
        function updateCharCount(input, maxLength) {
            const target = document.querySelector(`.character-count[data-for="${input.id}"]`);
            if (target) {
                const count = input.value.length;
                target.textContent = `${count} / ${maxLength}`;
                
                // تغيير لون العداد حسب عدد الأحرف
                if (count > maxLength) {
                    target.classList.remove('text-blue-500', 'text-yellow-500');
                    target.classList.add('text-red-500');
                } else if (count > maxLength * 0.8) {
                    target.classList.remove('text-blue-500', 'text-red-500');
                    target.classList.add('text-yellow-500');
                } else {
                    target.classList.remove('text-yellow-500', 'text-red-500');
                    target.classList.add('text-blue-500');
                }
            }
        }
        
        // إضافة مستمعي الأحداث لعدادات الأحرف
        const metaTitle = document.getElementById('meta_title');
        const metaDescription = document.getElementById('meta_description');
        
        if (metaTitle) {
            metaTitle.addEventListener('input', function() {
                updateCharCount(this, 60);
            });
            // تحديث العداد عند التحميل
            updateCharCount(metaTitle, 60);
        }
        
        if (metaDescription) {
            metaDescription.addEventListener('input', function() {
                updateCharCount(this, 160);
            });
            // تحديث العداد عند التحميل
            updateCharCount(metaDescription, 160);
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        var quill = new Quill('#quill-editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, false] }],
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link']
                ]
            },
            placeholder: 'اكتب وصف المنتج هنا...'
        });
        quill.format('direction', 'rtl');
        quill.format('align', 'right');
        document.getElementById('product-form').onsubmit = function() {
            document.getElementById('description-input').value = quill.root.innerHTML;
        };
    });

    document.addEventListener('DOMContentLoaded', function() {
        const switchEl = document.getElementById('custom-slug-switch');
        const slugGroup = document.getElementById('custom-slug-group');
        switchEl.addEventListener('change', function() {
            if (this.checked) {
                slugGroup.style.display = 'block';
            } else {
                slugGroup.style.display = 'none';
                document.getElementById('slug').value = '';
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        // معالجة الصورة الرئيسية
        const mainImageInput = document.getElementById('mainImageInput');
        const mainImagePreviewImg = document.getElementById('mainImagePreviewImg');
        const removeMainImageBtn = document.getElementById('removeMainImageBtn');
        mainImageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type) || file.size > 2 * 1024 * 1024) {
                    alert('الرجاء اختيار صورة بصيغة JPG أو PNG أو WebP ولا تتجاوز 2MB');
                    this.value = '';
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) {
                    mainImagePreviewImg.src = e.target.result;
                    removeMainImageBtn.style.display = '';
                };
                reader.readAsDataURL(file);
            }
        });
        window.removeMainImage = function() {
            mainImageInput.value = '';
            mainImagePreviewImg.src = "{{ asset('assets/admin/images/no-image.png') }}";
            removeMainImageBtn.style.display = 'none';
        };
    });

    document.addEventListener('DOMContentLoaded', function() {
        // معالجة الصور الإضافية
        const additionalImagesInput = document.getElementById('additionalImagesInput');
        const additionalImagesPreview = document.getElementById('additionalImagesPreview');
        const additionalImagesDropZone = document.getElementById('additionalImagesDropZone');
        const uploadStatus = document.getElementById('uploadStatus');
        let selectedFiles = [];

        function handleAdditionalImages(input) {
            const files = Array.from(input.files);
            if (files.length === 0) return;

            // التحقق من عدد الصور
            if (selectedFiles.length + files.length > 10) {
                alert('يمكنك إضافة 10 صور كحد أقصى');
                input.value = '';
                return;
            }

            let validFiles = 0;
            let invalidFiles = 0;

            files.forEach(file => {
                // التحقق من نوع الملف
                if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
                    invalidFiles++;
                    return;
                }

                // التحقق من حجم الملف
                if (file.size > 2 * 1024 * 1024) {
                    invalidFiles++;
                    return;
                }

                validFiles++;
                selectedFiles.push(file);

                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'image-preview-item';
                    div.innerHTML = `
                        <img src="${e.target.result}" alt="صورة إضافية">
                        <button type="button" class="delete-image-btn" onclick="removeImagePreview(this)">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    `;
                    additionalImagesPreview.appendChild(div);
                };
                reader.readAsDataURL(file);
            });

            // تحديث حالة الرفع
            if (validFiles > 0 || invalidFiles > 0) {
                let statusMessage = '';
                if (validFiles > 0) {
                    statusMessage += `تم اختيار ${validFiles} صور صالحة. `;
                }
                if (invalidFiles > 0) {
                    statusMessage += `تم تجاهل ${invalidFiles} صور غير صالحة.`;
                }
                uploadStatus.textContent = statusMessage;
            }

            input.value = '';
        }

        window.removeImagePreview = function(button) {
            const previewDiv = button.closest('.image-preview-item');
            const index = Array.from(additionalImagesPreview.children).indexOf(previewDiv);
            selectedFiles.splice(index, 1);
            previewDiv.remove();
            uploadStatus.textContent = `تم اختيار ${selectedFiles.length} صور.`;
        };

        additionalImagesInput.addEventListener('change', function() {
            handleAdditionalImages(this);
        });

        // تحسينات السحب والإفلات
        [mainImageDropZone, additionalImagesDropZone].forEach(dropZone => {
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                dropZone.classList.add('drop-zone--over');
            }

            function unhighlight(e) {
                dropZone.classList.remove('drop-zone--over');
            }

            dropZone.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;

                if (dropZone === mainImageDropZone) {
                    mainImageInput.files = files;
                    handleMainImage(mainImageInput);
                } else {
                    additionalImagesInput.files = files;
                    handleAdditionalImages(additionalImagesInput);
                }
            }
        });

        // عند الضغط على منطقة drop-zone للصورة الرئيسية، افتح input
        document.getElementById('mainImageDropZone').addEventListener('click', function(e) {
            if (e.target.tagName !== 'INPUT') {
                document.getElementById('mainImageInput').click();
            }
        });
        // عند الضغط على منطقة drop-zone للصور الإضافية، افتح input
        document.getElementById('additionalImagesDropZone').addEventListener('click', function(e) {
            if (e.target.tagName !== 'INPUT') {
                document.getElementById('additionalImagesInput').click();
            }
        });
    });

    // إظهار/إخفاء قسم الحسابات حسب نوع المنتج
    function toggleAccountsSection() {
        var type = document.getElementById('type').value;
        document.getElementById('accounts_section').style.display = (type === 'account') ? 'block' : 'none';
    }
    document.getElementById('type').addEventListener('change', toggleAccountsSection);
    window.addEventListener('DOMContentLoaded', toggleAccountsSection);

    // منطق إضافة/حذف textareas للحسابات
    let accountsContainer = document.getElementById('accounts_container');
    let addAccountBtn = document.getElementById('add_account_btn');
    function addAccountTextarea(value = '') {
        let wrapper = document.createElement('div');
        wrapper.className = 'relative';
        let textarea = document.createElement('textarea');
        textarea.className = 'block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100';
        textarea.rows = 3;
        textarea.value = value;
        let removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'absolute left-0 top-0 mt-2 ml-2 bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded';
        removeBtn.textContent = 'حذف';
        removeBtn.onclick = function() {
            accountsContainer.removeChild(wrapper);
            updateAccountsJson();
        };
        wrapper.appendChild(textarea);
        wrapper.appendChild(removeBtn);
        accountsContainer.appendChild(wrapper);
        textarea.addEventListener('input', updateAccountsJson);
        updateAccountsJson();
    }
    addAccountBtn.addEventListener('click', function() {
        addAccountTextarea();
    });
    function updateAccountsJson() {
        let accounts = [];
        accountsContainer.querySelectorAll('textarea').forEach(function(textarea) {
            if (textarea.value.trim() !== '') {
                accounts.push(textarea.value.trim());
            }
        });
        document.getElementById('accounts_json').value = JSON.stringify(accounts);
    }
</script>
@endpush

@push('styles')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<style>
    /* CSS الخاص بوصف المنتج */
    .ql-editor {
        direction: rtl;
        text-align: right;
        min-height: 200px;
    }

    /* CSS الخاص بقسم الصور */
    .drop-zone {
        border: 2px dashed #e5e7eb;
        border-radius: 0.5rem;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #ffffff;
    }

    .dark .drop-zone {
        border-color: #374151;
        background: #1f2937;
    }

    .drop-zone--over {
        border-color: #3b82f6;
        background: #eff6ff;
    }

    .dark .drop-zone--over {
        border-color: #3b82f6;
        background: #1e3a8a;
    }

    .drop-zone__input {
        display: none;
    }

    .drop-zone__prompt {
        color: #6b7280;
    }

    .dark .drop-zone__prompt {
        color: #9ca3af;
    }

    .image-preview-container {
        position: relative;
        width: 100%;
        max-width: 300px;
        margin: 0 auto;
    }

    .image-preview {
        position: relative;
        width: 100%;
        height: 300px;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        overflow: hidden;
        background: #ffffff;
    }

    .dark .image-preview {
        border-color: #374151;
        background: #1f2937;
    }

    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    #additionalImagesPreview .position-relative {
        aspect-ratio: 1;
        border-radius: 0.5rem;
        overflow: hidden;
        border: 1px solid #e5e7eb;
    }

    .dark #additionalImagesPreview .position-relative {
        border-color: #374151;
    }

    #additionalImagesPreview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .btn-danger {
        background-color: #ef4444;
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        line-height: 1.25rem;
        transition: all 0.2s;
    }

    .btn-danger:hover {
        background-color: #dc2626;
    }

    .dark .btn-danger {
        background-color: #dc2626;
    }

    .dark .btn-danger:hover {
        background-color: #b91c1c;
    }

    .drop-zone {
        transition: background 0.2s, border-color 0.2s;
    }
    .drop-zone--over {
        border-color: #3b82f6 !important;
        background: #232a3b !important;
    }
    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    .image-preview {
        min-width: 160px;
        min-height: 160px;
        max-width: 180px;
        max-height: 180px;
        background: #232a3b;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    /* شبكة الصور الإضافية */
    #additionalImagesPreview .image-preview-item {
        position: relative;
        background: #fff;
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 1px 4px 0 rgba(0,0,0,0.04);
        border: 1px solid #e5e7eb;
        transition: box-shadow 0.2s;
    }
    .dark #additionalImagesPreview .image-preview-item {
        background: #232a3b;
        border-color: #374151;
    }
    #additionalImagesPreview img {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 0.75rem 0.75rem 0 0;
    }
    /* زر الحذف الدائري */
    .delete-image-btn {
        position: absolute;
        top: 8px;
        left: 8px;
        background: #ef4444;
        color: #fff;
        border-radius: 9999px;
        padding: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.2s;
        z-index: 10;
        box-shadow: 0 2px 8px 0 rgba(0,0,0,0.10);
    }
    #additionalImagesPreview .image-preview-item:hover .delete-image-btn {
        opacity: 1;
    }
</style>
@endpush 