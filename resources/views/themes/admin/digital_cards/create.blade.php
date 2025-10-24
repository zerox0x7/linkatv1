@extends('themes.admin.layouts.app')

@section('title', 'إضافة بطاقة رقمية جديدة')

@section('content')
<div class="card bg-white dark:bg-gray-900 rounded-lg shadow">
    <div class="card-header bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <h5 class="mb-0 text-gray-800 dark:text-gray-100">إدخال معلومات البطاقة الرقمية</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.digital-cards.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">اسم البطاقة <span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 border-gray-300 dark:border-gray-700 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="price" class="form-label">السعر <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" class="form-control bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 border-gray-300 dark:border-gray-700 @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" min="0" step="0.01" required>
                            <span class="input-group-text bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-200">ريال</span>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">وصف البطاقة <span class="text-danger">*</span></label>
                <textarea class="form-control bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 border-gray-300 dark:border-gray-700 @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="instructions" class="form-label">تعليمات الاستخدام <span class="text-danger">*</span></label>
                <textarea class="form-control bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 border-gray-300 dark:border-gray-700 @error('instructions') is-invalid @enderror" id="instructions" name="instructions" rows="3" required>{{ old('instructions') }}</textarea>
                @error('instructions')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">أدخل تعليمات استخدام البطاقة التي ستظهر للمستخدم بعد الشراء</small>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">صورة البطاقة <span class="text-danger">*</span></label>
                <input class="form-control bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 border-gray-300 dark:border-gray-700 @error('image') is-invalid @enderror" type="file" id="image" name="image" accept="image/*" required>
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">يفضل أن تكون الصورة بأبعاد 300×200 بكسل</small>
            </div>

            <div class="mb-3">
                <label for="codes" class="form-label">أكواد البطاقات <span class="text-danger">*</span></label>
                <textarea class="form-control bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 border-gray-300 dark:border-gray-700 @error('codes') is-invalid @enderror" id="codes" name="codes" rows="6" required>{{ old('codes') }}</textarea>
                @error('codes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">أدخل أكواد البطاقات، كل كود في سطر منفصل</small>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input dark:bg-gray-700 dark:border-gray-600" id="is_active" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">تفعيل البطاقة</label>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.digital-cards.index') }}" class="btn btn-secondary dark:bg-gray-700 dark:text-gray-200">إلغاء</a>
                <button type="submit" class="btn btn-primary dark:bg-blue-700 dark:text-white">حفظ البطاقة</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // يمكن إضافة أي سكربت خاص بالصفحة هنا
    document.addEventListener('DOMContentLoaded', function() {
        // مثال: معاينة الصورة قبل الرفع
        const imageInput = document.getElementById('image');
        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // يمكن إضافة كود لعرض معاينة الصورة هنا
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
@endpush 