<!DOCTYPE html>
<html lang="ar" dir="rtl" style="overflow-y: scroll; -ms-overflow-style: none; scrollbar-width: none;">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>تعديل فئة</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" />
    <style>
        :where([class^="ri-"])::before {
            content: "\f3c2";
        }

        body {
            font-family: 'Cairo', 'Tajawal', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #e2e8f0;
            min-height: 100vh;
        }

        .form-card {
            background: linear-gradient(135deg, #0f1623 0%, #162033 100%);
            border: 1px solid #2a3548;
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .form-section {
            background: linear-gradient(135deg, #121827 0%, #1a2234 100%);
            border: 1px solid #2a3548;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .form-section:hover {
            border-color: rgba(0, 200, 179, 0.3);
            box-shadow: 0 4px 12px rgba(0, 200, 179, 0.1);
        }

        .form-input {
            background: linear-gradient(135deg, #0f1623 0%, #162033 100%);
            border: 1px solid #374151;
            color: #f9fafb;
            padding: 0.875rem 1rem;
            border-radius: 10px;
            width: 100%;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .form-input:focus {
            border-color: #00C8B3;
            box-shadow: 0 0 0 3px rgba(0, 200, 179, 0.1);
            outline: none;
        }

        .form-input:hover {
            border-color: rgba(0, 200, 179, 0.4);
        }

        .form-label {
            color: #d1d5db;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            display: block;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-label i {
            color: #00C8B3;
            font-size: 1rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #00C8B3 0%, #00B5A3 100%);
            color: #0f172a;
            padding: 0.875rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 200, 179, 0.3);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #00B5A3 0%, #009688 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 200, 179, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #374151 0%, #4B5563 100%);
            color: #f9fafb;
            padding: 0.875rem 2rem;
            border-radius: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #4B5563 0%, #6B7280 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 56px;
            height: 28px;
        }

        .toggle-input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #374151 0%, #4B5563 100%);
            transition: all 0.4s ease;
            border-radius: 28px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 4px;
            bottom: 4px;
            background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
            transition: all 0.4s ease;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .toggle-input:checked + .toggle-slider {
            background: linear-gradient(135deg, #00C8B3 0%, #00B5A3 100%);
            box-shadow: 0 0 12px rgba(0, 200, 179, 0.3);
        }

        .toggle-input:checked + .toggle-slider:before {
            transform: translateX(28px);
        }

        .icon-container {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(0, 200, 179, 0.1) 0%, rgba(0, 181, 163, 0.1) 100%);
            border: 1px solid rgba(0, 200, 179, 0.2);
        }

        .section-divider {
            border-top: 1px solid #2a3548;
            background: linear-gradient(90deg, transparent 0%, rgba(0, 200, 179, 0.2) 50%, transparent 100%);
            height: 1px;
        }

        .image-preview {
            border-radius: 12px;
            border: 2px solid #2a3548;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .image-preview:hover {
            border-color: rgba(0, 200, 179, 0.4);
            transform: scale(1.05);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .status-active {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(34, 197, 94, 0.2) 100%);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .status-inactive {
            background: linear-gradient(135deg, rgba(107, 114, 128, 0.2) 0%, rgba(156, 163, 175, 0.2) 100%);
            color: #9CA3AF;
            border: 1px solid rgba(107, 114, 128, 0.3);
        }

        .page-header {
            background: linear-gradient(135deg, #0f1623 0%, #162033 100%);
            border: 1px solid #2a3548;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            font-size: 0.875rem;
            color: #9CA3AF;
        }

        .breadcrumb a {
            color: #00C8B3;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb a:hover {
            color: #00B5A3;
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#00C8B3",
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
                        button: "12px",
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
            <div class="p-8">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="breadcrumb">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="ri-dashboard-line"></i>
                            لوحة التحكم
                        </a>
                        <i class="ri-arrow-left-s-line"></i>
                        <a href="{{ route('admin.categories.index') }}">
                            <i class="ri-price-tag-3-line"></i>
                            التصنيفات
                        </a>
                        <i class="ri-arrow-left-s-line"></i>
                        <span>تعديل فئة</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-100 mb-2 flex items-center gap-3">
                                <div class="icon-container">
                                    <i class="ri-edit-2-line text-primary text-xl"></i>
                                </div>
                                تعديل فئة: {{ $category->name }}
                            </h1>
                            <p class="text-gray-400 text-lg">قم بتعديل معلومات الفئة وخصائصها</p>
                        </div>
                        <div class="status-badge {{ $category->is_active ? 'status-active' : 'status-inactive' }}">
                            <i class="ri-{{ $category->is_active ? 'checkbox-circle' : 'close-circle' }}-line"></i>
                            {{ $category->is_active ? 'نشط' : 'غير نشط' }}
                        </div>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="form-card p-8">
                    <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        @method('PUT')
                        
                        <!-- Basic Information Section -->
                        <div class="form-section p-6">
                            <h3 class="text-xl font-semibold text-gray-200 mb-6 flex items-center gap-3">
                                <div class="icon-container">
                                    <i class="ri-information-line text-primary"></i>
                                </div>
                                المعلومات الأساسية
                            </h3>
                            
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="form-label">
                                        <i class="ri-price-tag-3-line"></i>
                                        اسم الفئة <span class="text-red-400">*</span>
                                    </label>
                                    <input type="text" class="form-input @error('name') border-red-500 @enderror" 
                                           id="name" name="name" value="{{ old('name', $category->name) }}" required
                                           placeholder="أدخل اسم الفئة">
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                                            <i class="ri-error-warning-line"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="parent_id" class="form-label">
                                        <i class="ri-node-tree"></i>
                                        الفئة الأب
                                    </label>
                                    <select class="form-input @error('parent_id') border-red-500 @enderror" 
                                            id="parent_id" name="parent_id">
                                        <option value="">فئة رئيسية</option>
                                        @foreach($parentCategories as $parentCategory)
                                            <option value="{{ $parentCategory->id }}" {{ old('parent_id', $category->parent_id) == $parentCategory->id ? 'selected' : '' }}>
                                                {{ $parentCategory->name }}
                                            </option>
                                            @foreach($parentCategory->children as $childCategory)
                                                @if($childCategory->id != $category->id)
                                                    <option value="{{ $childCategory->id }}" {{ old('parent_id', $category->parent_id) == $childCategory->id ? 'selected' : '' }}>
                                                        &nbsp;&nbsp;&nbsp;-- {{ $childCategory->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                        <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                                            <i class="ri-error-warning-line"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                    <p class="mt-2 text-xs text-amber-400 flex items-center gap-1">
                                        <i class="ri-information-line"></i>
                                        ملاحظة: لا يمكن جعل الفئة تابعة لنفسها أو لأحد فروعها
                                    </p>
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <label for="description" class="form-label">
                                    <i class="ri-file-text-line"></i>
                                    وصف الفئة
                                </label>
                                <textarea class="form-input @error('description') border-red-500 @enderror" 
                                          id="description" name="description" rows="4"
                                          placeholder="أدخل وصف مفصل للفئة">{{ old('description', $category->description) }}</textarea>
                                @error('description')
                                    <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                                        <i class="ri-error-warning-line"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Media & Display Section -->
                        <div class="form-section p-6">
                            <h3 class="text-xl font-semibold text-gray-200 mb-6 flex items-center gap-3">
                                <div class="icon-container">
                                    <i class="ri-image-line text-primary"></i>
                                </div>
                                الصورة والعرض
                            </h3>
                            
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <div>
                                    <label for="image" class="form-label">
                                        <i class="ri-image-add-line"></i>
                                        صورة الفئة
                                    </label>
                                    @if($category->image)
                                        <div class="mb-4">
                                            <div class="image-preview w-24 h-24 mb-2">
                                                <img src="{{ asset('storage/' . $category->image) }}" 
                                                     alt="{{ $category->name }}" 
                                                     class="w-full h-full object-cover">
                                            </div>
                                            <p class="text-xs text-gray-400 flex items-center gap-1">
                                                <i class="ri-image-line"></i>
                                                الصورة الحالية
                                            </p>
                                        </div>
                                    @endif
                                    <input type="file" class="form-input @error('image') border-red-500 @enderror" 
                                           id="image" name="image" accept="image/*">
                                    <p class="mt-2 text-xs text-gray-400 flex items-center gap-1">
                                        <i class="ri-information-line"></i>
                                        اترك الحقل فارغًا للاحتفاظ بالصورة الحالية
                                    </p>
                                    @error('image')
                                        <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                                            <i class="ri-error-warning-line"></i>  
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="sort_order" class="form-label">
                                        <i class="ri-sort-asc"></i>
                                        ترتيب العرض
                                    </label>
                                    <input type="number" class="form-input @error('sort_order') border-red-500 @enderror" 
                                           id="sort_order" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" 
                                           min="0" placeholder="0">
                                    <p class="mt-2 text-xs text-gray-400 flex items-center gap-1">
                                        <i class="ri-information-line"></i>
                                        الأرقام الأصغر تظهر أولاً
                                    </p>
                                    @error('sort_order')
                                        <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                                            <i class="ri-error-warning-line"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Status Section -->
                        <div class="form-section p-6">
                            <h3 class="text-xl font-semibold text-gray-200 mb-6 flex items-center gap-3">
                                <div class="icon-container">
                                    <i class="ri-settings-3-line text-primary"></i>
                                </div>
                                إعدادات الحالة
                            </h3>
                            
                            <div class="space-y-6">
                                <div class="flex items-center justify-between p-4 rounded-lg border border-gray-600">
                                    <div class="flex items-center gap-4">
                                        <div class="toggle-switch">
                                            <input type="checkbox" id="is_active" name="is_active" value="1" 
                                                   class="toggle-input" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                            <label for="is_active" class="toggle-slider"></label>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <i class="ri-checkbox-circle-line text-primary" id="status-icon"></i>
                                                <span class="text-lg font-medium text-white" id="statusText">
                                                    {{ old('is_active', $category->is_active) ? 'نشط' : 'غير نشط' }}
                                                </span>
                                            </div>
                                            <span class="text-sm text-gray-400" id="statusDescription">
                                                {{ old('is_active', $category->is_active) ? 'الفئة متاحة للعرض' : 'الفئة مخفية عن العرض' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @error('is_active')
                                    <p class="text-sm text-red-400 flex items-center gap-1">
                                        <i class="ri-error-warning-line"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Form Actions -->
                        <div class="flex justify-between items-center pt-6">
                            <a href="{{ route('admin.categories.index') }}" class="btn-secondary">
                                <i class="ri-arrow-left-line"></i>
                                إلغاء والعودة
                            </a>
                            <button type="submit" class="btn-primary">
                                <i class="ri-save-line"></i>
                                حفظ التغييرات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // JavaScript لتحديث نص الحالة للـ is_active
        document.getElementById('is_active').addEventListener('change', function() {
            const statusText = document.getElementById('statusText');
            const statusDescription = document.getElementById('statusDescription');
            const statusIcon = document.getElementById('status-icon');

            if (this.checked) {
                statusText.textContent = 'نشط';
                statusDescription.textContent = 'الفئة متاحة للعرض';
                statusIcon.className = 'ri-checkbox-circle-line text-green-400';
            } else {
                statusText.textContent = 'غير نشط';
                statusDescription.textContent = 'الفئة مخفية عن العرض';
                statusIcon.className = 'ri-close-circle-line text-red-400';
            }
        });

        // تحديث الأيقونة عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', function() {
            const isActive = document.getElementById('is_active').checked;
            const statusIcon = document.getElementById('status-icon');
            
            if (isActive) {
                statusIcon.className = 'ri-checkbox-circle-line text-green-400';
            } else {
                statusIcon.className = 'ri-close-circle-line text-red-400';
            }
        });
    </script>
</body>
</html> 