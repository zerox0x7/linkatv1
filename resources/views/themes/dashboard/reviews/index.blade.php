@extends('themes.admin.layouts.app')

@section('title', 'إدارة التقييمات')

@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8  p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">إدارة التقييمات</h1>
        <a href="{{ route('admin.reviews.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded shadow">
            + إنشاء تقييم جديد
        </a>
    </div>
    
    @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
        {{ session('success') }}
    </div>
    @endif
    
    <div class="overflow-x-auto">
        <table class="mpy-6 px-4 sm:px-6 lg:px-8  border border-gray-200 rounded-md">
            <thead>
                <tr class="py-6 px-4 sm:px-6 lg:px-8">
                    <th class="py-3 px-4 text-right border-b">المنتج</th>
                    <th class="py-3 px-4 text-right border-b">المستخدم</th>
                    <th class="py-3 px-4 text-right border-b">التقييم</th>
                    <th class="py-3 px-4 text-right border-b">التقييم</th>
                    <th class="py-3 px-4 text-right border-b">تاريخ الإضافة</th>
                    <th class="py-3 px-4 text-right border-b">الحالة</th>
                    <th class="py-3 px-4 text-right border-b">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($reviews as $review)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-4">
                        @if($review->reviewable)
                            @if(class_basename($review->reviewable) == 'Product')
                                <a href="{{ route('admin.products.edit', $review->reviewable->id) }}" class="text-blue-600 hover:underline">
                                    {{ $review->reviewable->name }}
                                </a>
                            @elseif(class_basename($review->reviewable) == 'DigitalCard')
                                <a href="{{ route('admin.digital-cards.edit', $review->reviewable->id) }}" class="text-blue-600 hover:underline">
                                    {{ $review->reviewable->name }}
                                </a>
                            @else
                                {{ optional($review->reviewable)->name ?? 'منتج محذوف' }}
                            @endif
                        @else
                            <span class="text-red-500">منتج محذوف</span>
                        @endif
                    </td>
                    <td class="py-3 px-4">
                        @if($review->user)
                            <a href="{{ route('admin.users.show', $review->user->id) }}" class="text-blue-600 hover:underline">
                                {{ $review->user->name }}
                            </a>
                        @else
                            <span class="text-red-500">مستخدم محذوف</span>
                        @endif
                    </td>
                    <td class="py-3 px-4">
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endif
                            @endfor
                            <span class="mr-1 text-sm text-gray-600">{{ $review->rating }}/5</span>
                        </div>
                    </td>
                    <td class="py-3 px-4">
                        <div class="max-w-xs truncate">
                            {{ $review->review ?: 'لا يوجد تعليق' }}
                        </div>
                    </td>
                    <td class="py-3 px-4 text-gray-500">
                        {{ $review->created_at->format('Y-m-d H:i') }}
                    </td>
                    <td class="py-3 px-4">
                        @if($review->is_approved)
                            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">معتمد</span>
                        @else
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full">بانتظار الموافقة</span>
                        @endif
                    </td>
                    <td class="py-3 px-4">
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <form action="{{ route('admin.reviews.toggle-approval', $review) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="p-1 {{ $review->is_approved ? 'text-yellow-500 hover:text-yellow-700' : 'text-green-500 hover:text-green-700' }}">
                                    @if($review->is_approved)
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @endif
                                </button>
                            </form>
                            
                            <a href="{{ route('admin.reviews.edit', $review) }}" class="p-1 text-blue-500 hover:text-blue-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            
                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا التقييم؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1 text-red-500 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-6 text-center text-gray-500">لا توجد تقييمات للعرض</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $reviews->links() }}
    </div>
</div>
@endsection 