@extends('themes.admin.layouts.app')

@section('title', 'تعديل بطاقة رقمية')

@section('content')
<div class="card bg-white dark:bg-gray-900 rounded-lg shadow">
    <div class="card-header bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <h5 class="mb-0 text-gray-800 dark:text-gray-100">تعديل معلومات البطاقة الرقمية</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.digital-cards.update', $digitalCard) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">اسم البطاقة <span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 border-gray-300 dark:border-gray-700 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $digitalCard->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="price" class="form-label">السعر <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" class="form-control bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 border-gray-300 dark:border-gray-700 @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $digitalCard->price) }}" min="0" step="0.01" required>
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
                <textarea class="form-control bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 border-gray-300 dark:border-gray-700 @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description', $digitalCard->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="instructions" class="form-label">تعليمات الاستخدام <span class="text-danger">*</span></label>
                <textarea class="form-control bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 border-gray-300 dark:border-gray-700 @error('instructions') is-invalid @enderror" id="instructions" name="instructions" rows="3" required>{{ old('instructions', $digitalCard->instructions) }}</textarea>
                @error('instructions')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">أدخل تعليمات استخدام البطاقة التي ستظهر للمستخدم بعد الشراء</small>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">صورة البطاقة</label>
                @if($digitalCard->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $digitalCard->image) }}" alt="{{ $digitalCard->name }}" class="img-thumbnail" style="max-height: 150px;">
                    </div>
                @endif
                <input class="form-control bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 border-gray-300 dark:border-gray-700 @error('image') is-invalid @enderror" type="file" id="image" name="image" accept="image/*">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">اترك هذا الحقل فارغًا للاحتفاظ بالصورة الحالية. يفضل أن تكون الصورة بأبعاد 300×200 بكسل</small>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input dark:bg-gray-700 dark:border-gray-600" id="is_active" name="is_active" value="1" {{ old('is_active', $digitalCard->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">تفعيل البطاقة</label>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.digital-cards.index') }}" class="btn btn-secondary dark:bg-gray-700 dark:text-gray-200">إلغاء</a>
                <button type="submit" class="btn btn-primary dark:bg-blue-700 dark:text-white">حفظ التغييرات</button>
            </div>
        </form>
    </div>
</div>

<div class="card mt-4 bg-white dark:bg-gray-900 rounded-lg shadow">
    <div class="card-header d-flex justify-content-between align-items-center bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <h5 class="mb-0 text-gray-800 dark:text-gray-100">أكواد البطاقة</h5>
        <span class="badge bg-{{ $digitalCard->codes->whereNull('user_id')->count() > 0 ? 'success dark:bg-green-800 dark:text-white' : 'danger dark:bg-red-800 dark:text-white' }}">
            {{ $digitalCard->codes->whereNull('user_id')->count() }} / {{ $digitalCard->codes->count() }} متاح
        </span>
    </div>
    <div class="card-body">
        @if($digitalCard->codes->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th>#</th>
                            <th>الكود</th>
                            <th>الحالة</th>
                            <th>تاريخ البيع</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($digitalCard->codes as $code)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <code>{{ $code->code }}</code>
                                </td>
                                <td>
                                    @if($code->user_id)
                                        <span class="badge bg-danger dark:bg-red-800 dark:text-white">تم البيع</span>
                                    @else
                                        <span class="badge bg-success dark:bg-green-800 dark:text-white">متاح</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $code->sold_at ? $code->sold_at->format('Y-m-d H:i') : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-warning dark:bg-yellow-900 dark:text-yellow-100">لا توجد أكواد مسجلة لهذه البطاقة</div>
        @endif
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