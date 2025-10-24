@extends('themes.admin.layouts.app')

@section('title', 'عرض بطاقة رقمية')

@section('content')
<div class="card mb-4 bg-white dark:bg-gray-900 rounded-lg shadow">
    <div class="card-header d-flex justify-content-between align-items-center bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <h5 class="mb-0 text-gray-800 dark:text-gray-100">معلومات البطاقة الرقمية</h5>
        <div>
            <a href="{{ route('admin.digital-cards.edit', $digitalCard) }}" class="btn btn-warning btn-sm dark:bg-yellow-700 dark:text-white">
                <i class="fas fa-edit ms-1"></i> تعديل
            </a>
            <a href="{{ route('admin.digital-cards.index') }}" class="btn btn-secondary btn-sm dark:bg-gray-700 dark:text-gray-200">
                <i class="fas fa-list ms-1"></i> العودة للقائمة
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100">
                    <tr>
                        <th style="width: 30%">رقم التعريف</th>
                        <td>{{ $digitalCard->id }}</td>
                    </tr>
                    <tr>
                        <th>الاسم</th>
                        <td>{{ $digitalCard->name }}</td>
                    </tr>
                    <tr>
                        <th>السعر</th>
                        <td>{{ number_format($digitalCard->price, 2) }} ريال</td>
                    </tr>
                    <tr>
                        <th>الحالة</th>
                        <td>
                            <span class="badge bg-{{ $digitalCard->is_active ? 'success dark:bg-green-800 dark:text-white' : 'danger dark:bg-red-800 dark:text-white' }}">
                                {{ $digitalCard->is_active ? 'نشط' : 'غير نشط' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>تاريخ الإنشاء</th>
                        <td>{{ $digitalCard->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                    <tr>
                        <th>آخر تحديث</th>
                        <td>{{ $digitalCard->updated_at->format('Y-m-d H:i') }}</td>
                    </tr>
                    <tr>
                        <th>تعليمات الاستخدام</th>
                        <td>{{ $digitalCard->instructions }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <div class="text-center mb-3">
                    @if($digitalCard->image)
                        <img src="{{ asset('storage/' . $digitalCard->image) }}" alt="{{ $digitalCard->name }}" class="img-fluid rounded" style="max-height: 250px;">
                    @else
                        <div class="alert alert-secondary dark:bg-gray-800 dark:text-gray-200">لا توجد صورة</div>
                    @endif
                </div>
                <div class="card bg-white dark:bg-gray-900 rounded-lg shadow">
                    <div class="card-header bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                        <h6 class="mb-0 text-gray-800 dark:text-gray-100">وصف البطاقة</h6>
                    </div>
                    <div class="card-body text-gray-800 dark:text-gray-100">
                        {{ $digitalCard->description }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card bg-white dark:bg-gray-900 rounded-lg shadow">
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
                            <th>المستخدم</th>
                            <th>الطلب</th>
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
                                    {{ $code->user ? $code->user->name : '-' }}
                                </td>
                                <td>
                                    @if($code->order_id)
                                        <a href="{{ route('admin.orders.show', $code->order_id) }}">{{ $code->order_id }}</a>
                                    @else
                                        -
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
            <div class="alert alert-info dark:bg-blue-900 dark:text-blue-100">لا توجد أكواد مسجلة لهذه البطاقة</div>
        @endif
    </div>
</div>
@endsection 