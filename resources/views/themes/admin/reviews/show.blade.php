@extends('themes.admin.layouts.app')

@section('title', 'تفاصيل التقييم')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">تفاصيل التقييم</h1>
        <div class="flex gap-2">
            <a href="{{ route('admin.reviews.edit', $review) }}" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition-colors">
                تعديل
            </a>
            <a href="{{ route('admin.reviews.index') }}" class="bg-gray-200 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-300 transition-colors">
                رجوع
            </a>
        </div>
    </div>
    
    @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
        {{ session('success') }}
    </div>
    @endif
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gray-50 p-4 rounded-md">
            <h2 class="text-lg font-medium text-gray-700 mb-3 border-b pb-2">معلومات المنتج</h2>
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-500">اسم المنتج</p>
                    @if($review->reviewable)
                        <div class="flex items-center">
                            @if(class_basename($review->reviewable) == 'Product')
                                <a href="{{ route('admin.products.edit', $review->reviewable->id) }}" class="text-blue-600 hover:underline font-medium">
                                    {{ $review->reviewable->name }}
                                </a>
                            @elseif(class_basename($review->reviewable) == 'DigitalCard')
                                <a href="{{ route('admin.digital-cards.edit', $review->reviewable->id) }}" class="text-blue-600 hover:underline font-medium">
                                    {{ $review->reviewable->name }}
                                </a>
                            @else
                                <p class="font-medium">{{ $review->reviewable->name }}</p>
                            @endif
                        </div>
                    @else
                        <p class="text-red-500">منتج محذوف</p>
                    @endif
                </div>
                
                <div>
                    <p class="text-sm text-gray-500">نوع المنتج</p>
                    <p class="font-medium">
                        @if($review->reviewable)
                            @if(class_basename($review->reviewable) == 'Product')
                                منتج
                            @elseif(class_basename($review->reviewable) == 'DigitalCard')
                                بطاقة رقمية
                            @else
                                {{ class_basename($review->reviewable) }}
                            @endif
                        @else
                            غير معروف
                        @endif
                    </p>
                </div>
                
                @if($review->reviewable && isset($review->order_item_id))
                <div>
                    <p class="text-sm text-gray-500">رقم الطلب</p>
                    @if($review->orderItem && $review->orderItem->order)
                        <a href="{{ route('admin.orders.show', $review->orderItem->order->id) }}" class="text-blue-600 hover:underline font-medium">
                            #{{ $review->orderItem->order->order_number }}
                        </a>
                    @else
                        <p class="text-gray-500">غير معروف</p>
                    @endif
                </div>
                @endif
            </div>
        </div>
        
        <div class="bg-gray-50 p-4 rounded-md">
            <h2 class="text-lg font-medium text-gray-700 mb-3 border-b pb-2">معلومات المستخدم</h2>
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-500">اسم المستخدم</p>
                    @if($review->user)
                        <a href="{{ route('admin.users.show', $review->user->id) }}" class="text-blue-600 hover:underline font-medium">
                            {{ $review->user->name }}
                        </a>
                    @else
                        <p class="text-red-500">مستخدم محذوف</p>
                    @endif
                </div>
                
                @if($review->user)
                <div>
                    <p class="text-sm text-gray-500">البريد الإلكتروني</p>
                    <p class="font-medium">{{ $review->user->email }}</p>
                </div>
                @endif
                
                <div>
                    <p class="text-sm text-gray-500">تاريخ التقييم</p>
                    <p class="font-medium">{{ $review->created_at->format('Y-m-d H:i') }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-gray-50 p-4 rounded-md md:col-span-2">
            <h2 class="text-lg font-medium text-gray-700 mb-3 border-b pb-2">تفاصيل التقييم</h2>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-500 mb-1">التقييم</p>
                    <div class="flex items-center">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating)
                                <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            @else
                                <svg class="w-6 h-6 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            @endif
                        @endfor
                        <span class="mr-2 text-sm text-gray-600">{{ $review->rating }}/5</span>
                    </div>
                </div>
                
                <div>
                    <p class="text-sm text-gray-500 mb-1">التعليق</p>
                    <div class="bg-white p-3 rounded-md border border-gray-200">
                        @if($review->review)
                            <p class="whitespace-pre-line">{{ $review->review }}</p>
                        @else
                            <p class="text-gray-500 italic">لا يوجد تعليق</p>
                        @endif
                    </div>
                </div>
                
                <div>
                    <p class="text-sm text-gray-500 mb-1">حالة النشر</p>
                    @if($review->is_approved)
                        <div class="inline-flex items-center px-2.5 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            معتمد ومنشور
                        </div>
                    @else
                        <div class="inline-flex items-center px-2.5 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            بانتظار المراجعة
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="flex justify-between mt-6 pt-4 border-t">
        <form action="{{ route('admin.reviews.toggle-approval', $review) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit" class="{{ $review->is_approved ? 'bg-yellow-600' : 'bg-green-600' }} text-white py-2 px-6 rounded-md hover:{{ $review->is_approved ? 'bg-yellow-700' : 'bg-green-700' }} transition-colors">
                @if($review->is_approved)
                    إلغاء الموافقة على النشر
                @else
                    الموافقة على النشر
                @endif
            </button>
        </form>
        
        <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا التقييم؟');">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white py-2 px-6 rounded-md hover:bg-red-700 transition-colors">
                حذف التقييم
            </button>
        </form>
    </div>
</div>
@endsection 