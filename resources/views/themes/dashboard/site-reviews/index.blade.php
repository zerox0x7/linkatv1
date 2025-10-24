@extends('themes.admin.layouts.app')

@section('title', 'تقييمات الموقع الرئيسية')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">آراء العملاء - تقييمات الموقع</h1>
        <div>
            <a href="{{ route('admin.site-reviews.create') }}" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition-colors">
                إضافة تقييم جديد
            </a>
            <a href="{{ route('admin.reviews.index') }}" class="mr-2 bg-gray-200 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-300 transition-colors">
                تقييمات المنتجات
            </a>
        </div>
    </div>
    
    @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
        {{ session('success') }}
    </div>
    @endif
    
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b">الاسم</th>
                    <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b">المسمى الوظيفي</th>
                    <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b">التقييم</th>
                    <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b">الحالة</th>
                    <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b">تاريخ الإضافة</th>
                    <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @if($siteReviews->count() > 0)
                    @foreach($siteReviews as $review)
                    <tr class="hover:bg-gray-50">
                        <td class="py-4 px-4 text-sm text-gray-900">{{ $review->name }}</td>
                        <td class="py-4 px-4 text-sm text-gray-500">{{ $review->position ?? '-' }}</td>
                        <td class="py-4 px-4">
                            <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                            </div>
                        </td>
                        <td class="py-4 px-4 text-sm">
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $review->is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $review->is_approved ? 'معتمد' : 'قيد المراجعة' }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-sm text-gray-500">{{ $review->created_at->format('Y-m-d') }}</td>
                        <td class="py-4 px-4 text-sm font-medium space-x-reverse space-x-2">
                            <a href="{{ route('admin.site-reviews.edit', $review->id) }}" class="inline-block text-blue-600 hover:text-blue-900">تعديل</a>
                            
                            <form action="{{ route('admin.site-reviews.toggle-approval', $review->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-{{ $review->is_approved ? 'yellow' : 'green' }}-600 hover:text-{{ $review->is_approved ? 'yellow' : 'green' }}-900">
                                    {{ $review->is_approved ? 'تعليق' : 'اعتماد' }}
                                </button>
                            </form>
                            
                            <form action="{{ route('admin.site-reviews.destroy', $review->id) }}" method="POST" class="inline-block" onsubmit="return confirm('هل أنت متأكد من حذف هذا التقييم؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">حذف</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="py-4 px-4 text-center text-gray-500">لا توجد تقييمات حتى الآن</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $siteReviews->links() }}
    </div>
</div>
@endsection 