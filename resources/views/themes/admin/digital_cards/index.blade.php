@extends('themes.admin.layouts.app')

@section('title', 'إدارة البطاقات الرقمية')

@section('content')
<div class="card bg-white dark:bg-gray-900 rounded-lg shadow">
    <div class="card-header d-flex justify-content-between align-items-center bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <h5 class="mb-0 text-gray-800 dark:text-gray-100">قائمة البطاقات الرقمية</h5>
        <a href="{{ route('admin.digital-cards.create') }}" class="btn btn-primary btn-sm dark:bg-blue-700 dark:text-white">
            <i class="fas fa-plus ms-1"></i> إضافة بطاقة جديدة
        </a>
    </div>
    <div class="card-body">
        @if($digitalCards->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th>#</th>
                            <th>الصورة</th>
                            <th>الاسم</th>
                            <th>السعر</th>
                            <th>الأكواد المتاحة</th>
                            <th>الحالة</th>
                            <th>تاريخ الإنشاء</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($digitalCards as $card)
                            <tr>
                                <td>{{ $card->id }}</td>
                                <td>
                                    @if($card->image)
                                        <img src="{{ asset('storage/' . $card->image) }}" alt="{{ $card->name }}" width="50" height="50" class="img-thumbnail">
                                    @else
                                        <span class="badge bg-secondary dark:bg-gray-700 dark:text-white">لا يوجد صورة</span>
                                    @endif
                                </td>
                                <td>{{ $card->name }}</td>
                                <td>{{ number_format($card->price, 2) }} ريال</td>
                                <td>
                                    <span class="badge bg-{{ $card->available_codes_count > 0 ? 'success dark:bg-green-800 dark:text-white' : 'danger dark:bg-red-800 dark:text-white' }}">
                                        {{ $card->available_codes_count }} / {{ $card->codes_count }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $card->is_active ? 'success dark:bg-green-800 dark:text-white' : 'danger dark:bg-red-800 dark:text-white' }}">
                                        {{ $card->is_active ? 'نشط' : 'غير نشط' }}
                                    </span>
                                </td>
                                <td>{{ $card->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.digital-cards.show', $card) }}" class="btn btn-info btn-sm dark:bg-blue-800 dark:text-white" title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.digital-cards.edit', $card) }}" class="btn btn-warning btn-sm dark:bg-yellow-700 dark:text-white" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm dark:bg-red-700 dark:text-white" 
                                            onclick="if(confirm('هل أنت متأكد من حذف هذه البطاقة؟')) document.getElementById('delete-form-{{ $card->id }}').submit();" 
                                            title="حذف">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $card->id }}" action="{{ route('admin.digital-cards.destroy', $card) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $digitalCards->links() }}
            </div>
        @else
            <div class="alert alert-info text-center dark:bg-blue-900 dark:text-blue-100">
                لا توجد بطاقات رقمية حاليًا.
                <a href="{{ route('admin.digital-cards.create') }}" class="btn btn-sm btn-primary ms-2 dark:bg-blue-700 dark:text-white">
                    <i class="fas fa-plus ms-1"></i> إضافة بطاقة جديدة
                </a>
            </div>
        @endif
    </div>
</div>
@endsection 