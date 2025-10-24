@extends('themes.dashboard.layouts.app')

@section('title', 'إضافة كوبون خصم جديد')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">إضافة كوبون خصم جديد</h1>
        <a href="{{ route('dashboard.coupons.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded shadow">عودة للقائمة</a>
    </div>
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6">
        <form action="{{ route('dashboard.coupons.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">كود الخصم <span class="text-red-600">*</span></label>
                    <div class="flex gap-2">
                        <input type="text" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code') }}" required>
                        <button type="button" class="btn btn-secondary dark:bg-gray-700 dark:text-gray-200" id="generate-code">
                            <i class="fas fa-sync-alt"></i> توليد
                        </button>
                    </div>
                    @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">يجب أن يكون الكود فريداً</small>
                </div>
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">نوع الخصم <span class="text-red-600">*</span></label>
                    <select class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 @error('type') is-invalid @enderror" id="type" name="type" required>
                        <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>مبلغ ثابت</option>
                        <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>نسبة مئوية</option>
                    </select>
                    @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label for="value" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">قيمة الخصم <span class="text-red-600">*</span></label>
                    <div class="flex gap-2">
                        <input type="number" step="0.01" min="0" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 @error('value') is-invalid @enderror" id="value" name="value" value="{{ old('value') }}" required>
                        <span class="inline-flex items-center px-2 text-gray-500 dark:text-gray-400" id="discount-unit">ر.س</span>
                    </div>
                    @error('value')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted" id="discount-help">مبلغ ثابت يتم خصمه من إجمالي الطلب</small>
                </div>
                <div>
                    <label for="min_order_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">الحد الأدنى للطلب</label>
                    <div class="flex gap-2">
                        <input type="number" step="0.01" min="0" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 @error('min_order_amount') is-invalid @enderror" id="min_order_amount" name="min_order_amount" value="{{ old('min_order_amount') }}">
                        <span class="inline-flex items-center px-2 text-gray-500 dark:text-gray-400">ر.س</span>
                    </div>
                    @error('min_order_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">اتركه فارغًا إذا لم يكن هناك حد أدنى</small>
                </div>
                <div>
                    <label for="starts_at" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">تاريخ البدء</label>
                    <input type="date" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 @error('starts_at') is-invalid @enderror" id="starts_at" name="starts_at" value="{{ old('starts_at') }}">
                    @error('starts_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">اتركه فارغًا ليبدأ فوراً</small>
                </div>
                <div>
                    <label for="expires_at" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">تاريخ الانتهاء</label>
                    <input type="date" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 @error('expires_at') is-invalid @enderror" id="expires_at" name="expires_at" value="{{ old('expires_at') }}">
                    @error('expires_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">اتركه فارغًا ليبقى صالحًا دون تاريخ انتهاء</small>
                </div>
                <div>
                    <label for="max_uses" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">الحد الأقصى للاستخدام</label>
                    <input type="number" min="1" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 @error('max_uses') is-invalid @enderror" id="max_uses" name="max_uses" value="{{ old('max_uses') }}">
                    @error('max_uses')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">اتركه فارغًا للاستخدام غير المحدود</small>
                </div>
                <div class="flex items-center mt-6">
                    <input class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                    <label for="is_active" class="mr-2 block text-sm text-gray-700 dark:text-gray-200">الكوبون نشط</label>
                </div>
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mt-8 mb-4">استهداف المنتجات والتصنيفات</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="product_ids" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">المنتجات المستهدفة</label>
                    <select class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 select2" id="product_ids" name="product_ids[]" multiple>
                        @foreach(\App\Models\Product::all() as $product)
                            <option value="{{ $product->id }}" {{ (collect(old('product_ids'))->contains($product->id)) ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">اتركه فارغًا ليشمل جميع المنتجات</small>
                </div>
                <div>
                    <label for="category_ids" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">التصنيفات المستهدفة</label>
                    <select class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 select2" id="category_ids" name="category_ids[]" multiple>
                        @foreach(\App\Models\Category::all() as $category)
                            <option value="{{ $category->id }}" {{ (collect(old('category_ids'))->contains($category->id)) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">اتركه فارغًا ليشمل جميع التصنيفات</small>
                </div>
            </div>
            <div class="flex gap-4 mt-8">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow font-bold">
                    <i class="fas fa-save"></i> حفظ الكوبون
                </button>
                <a href="{{ route('dashboard.coupons.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded shadow font-bold">
                    <i class="fas fa-arrow-left"></i> عودة للقائمة
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.select2-container--default .select2-selection--multiple {
    background-color: #1a202c;
    color: #fff;
    border-color: #374151;
    min-height: 42px;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #2563eb;
    color: #fff;
    border: none;
    margin-top: 6px;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: #fff;
}
.select2-dropdown {
    background-color: #1a202c;
    color: #fff;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $('.select2').select2({
        dir: 'rtl',
        width: '100%',
        placeholder: 'اختر ...',
        allowClear: true,
        dropdownAutoWidth: true,
        language: {
            noResults: function() {
                return "لا توجد نتائج";
            }
        }
    });
    $('#type').on('change', function() {
        const discountType = $(this).val();
        if (discountType === 'percentage') {
            $('#discount-unit').text('%');
            $('#discount-help').text('نسبة مئوية تطبق على إجمالي الطلب');
            const currentValue = parseFloat($('#value').val());
            if (currentValue > 100) {
                $('#value').val(100);
            }
            $('#value').attr('max', 100);
        } else {
            $('#discount-unit').text('ر.س');
            $('#discount-help').text('مبلغ ثابت يتم خصمه من إجمالي الطلب');
            $('#value').removeAttr('max');
        }
    });
    $('#generate-code').on('click', function() {
        $(this).html('<i class="fas fa-spinner fa-spin"></i>');
        $.ajax({
            url: '{{ route("dashboard.coupons.generate-code") }}',
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#code').val(response.code);
                }
                $('#generate-code').html('<i class="fas fa-sync-alt"></i> توليد');
            },
            error: function() {
                $('#generate-code').html('<i class="fas fa-sync-alt"></i> توليد');
                alert('حدث خطأ أثناء توليد الكود');
            }
        });
    });
    $(document).ready(function() {
        $('#type').trigger('change');
    });
</script>
@endpush 