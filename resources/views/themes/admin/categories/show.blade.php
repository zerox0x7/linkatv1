@extends('themes.admin.layouts.app')

@section('title', 'عرض تصنيف')

@section('content')
<div class="card mb-4 bg-white dark:bg-gray-900 rounded-lg shadow">
    <div class="card-header d-flex justify-content-between align-items-center bg-gray-50 dark:bg-gray-800">
        <h5 class="mb-0 text-gray-900 dark:text-gray-100">بيانات التصنيف</h5>
        <div>
            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary btn-sm me-2 bg-blue-600 dark:bg-blue-700 text-white">
                <i class="fas fa-edit"></i> تعديل
            </a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-sm bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                <i class="fas fa-arrow-right"></i> عودة للقائمة
            </a>
        </div>
    </div>
    <div class="card-body text-gray-900 dark:text-gray-100">
        <div class="row">
            <div class="col-md-8">
                <table class="table table-bordered w-full text-sm text-right text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-900">
                    <tr>
                        <th style="width: 200px;">الاسم</th>
                        <td>{{ $category->name }}</td>
                    </tr>
                    <tr>
                        <th>الرابط المختصر</th>
                        <td>{{ $category->slug }}</td>
                    </tr>
                    <tr>
                        <th>التصنيف الأب</th>
                        <td>
                            @if($category->parent)
                                <a href="{{ route('admin.categories.show', $category->parent) }}">{{ $category->parent->name }}</a>
                            @else
                                <span class="badge bg-info dark:bg-blue-900 text-white">تصنيف رئيسي</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>الوصف</th>
                        <td>{{ $category->description ?? 'لا يوجد وصف' }}</td>
                    </tr>
                    <tr>
                        <th>عدد المنتجات</th>
                        <td>{{ $category->products->count() }}</td>
                    </tr>
                    <tr>
                        <th>عدد التصنيفات الفرعية</th>
                        <td>{{ $category->children->count() }}</td>
                    </tr>
                    <tr>
                        <th>ترتيب العرض</th>
                        <td>{{ $category->order ?? $category->sort_order ?? 0 }}</td>
                    </tr>
                    <tr>
                        <th>الحالة</th>
                        <td>
                            @if($category->is_active)
                                <span class="badge bg-success dark:bg-green-800 text-white">نشط</span>
                            @else
                                <span class="badge bg-danger dark:bg-red-800 text-white">غير نشط</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>تاريخ الإنشاء</th>
                        <td>{{ $category->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                    <tr>
                        <th>آخر تحديث</th>
                        <td>{{ $category->updated_at->format('Y-m-d H:i') }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-4">
                @if($category->image)
                    <div class="text-center">
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="img-fluid img-thumbnail mb-3" style="max-height: 250px;">
                        <p class="text-muted">صورة التصنيف</p>
                    </div>
                @else
                    <div class="text-center p-5 bg-light dark:bg-gray-800 rounded">
                        <i class="fas fa-image fa-5x text-muted dark:text-gray-500 mb-3"></i>
                        <p class="text-muted dark:text-gray-400">لم يتم تحميل صورة لهذا التصنيف</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if($category->children->count() > 0)
<div class="card mb-4 bg-white dark:bg-gray-900 rounded-lg shadow">
    <div class="card-header bg-gray-50 dark:bg-gray-800">
        <h5 class="mb-0 text-gray-900 dark:text-gray-100">التصنيفات الفرعية ({{ $category->children->count() }})</h5>
    </div>
    <div class="card-body text-gray-900 dark:text-gray-100">
        <div class="table-responsive">
            <table class="table table-striped table-hover w-full text-sm text-right text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-900">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>عدد المنتجات</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($category->children as $childCategory)
                        <tr>
                            <td>{{ $childCategory->id }}</td>
                            <td>{{ $childCategory->name }}</td>
                            <td>{{ $childCategory->products->count() }}</td>
                            <td>
                                @if($childCategory->is_active)
                                    <span class="badge bg-success dark:bg-green-800 text-white">نشط</span>
                                @else
                                    <span class="badge bg-danger dark:bg-red-800 text-white">غير نشط</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.categories.show', $childCategory) }}" class="btn btn-sm btn-info bg-blue-500 dark:bg-blue-700 text-white">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.categories.edit', $childCategory) }}" class="btn btn-sm btn-warning bg-yellow-400 dark:bg-yellow-600 text-white">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

@if($category->products->count() > 0)
<div class="card bg-white dark:bg-gray-900 rounded-lg shadow">
    <div class="card-header bg-gray-50 dark:bg-gray-800">
        <h5 class="mb-0 text-gray-900 dark:text-gray-100">المنتجات في هذا التصنيف ({{ $category->products->count() }})</h5>
    </div>
    <div class="card-body text-gray-900 dark:text-gray-100">
        <div class="table-responsive">
            <table class="table table-striped table-hover w-full text-sm text-right text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-900">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الصورة</th>
                        <th>الاسم</th>
                        <th>السعر</th>
                        <th>المخزون</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($category->products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="50" class="img-thumbnail">
                                @else
                                    <span class="badge bg-secondary dark:bg-gray-700 text-white">لا توجد صورة</span>
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ number_format($product->price, 2) }} ر.س</td>
                            <td>
                                @if($product->stock > 0)
                                    <span class="badge bg-success dark:bg-green-800 text-white">{{ $product->stock }}</span>
                                @else
                                    <span class="badge bg-danger dark:bg-red-800 text-white">نفذ</span>
                                @endif
                            </td>
                            <td>
                                @if($product->is_active)
                                    <span class="badge bg-success dark:bg-green-800 text-white">نشط</span>
                                @else
                                    <span class="badge bg-danger dark:bg-red-800 text-white">غير نشط</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-info bg-blue-500 dark:bg-blue-700 text-white">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-warning bg-yellow-400 dark:bg-yellow-600 text-white">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection 