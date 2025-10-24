@extends('themes.admin.layouts.app')

@section('title', 'عرض الطلب المخصص #' . $customOrder->id)

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">تفاصيل الطلب المخصص #{{ $customOrder->id }}</h1>
        <div class="flex items-center space-x-4 space-x-reverse">
            <a href="{{ route('admin.custom_orders.index') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                العودة للقائمة
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- تفاصيل الطلب -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="bg-gray-50 px-4 py-3 border-b">
                    <h3 class="text-lg font-medium text-gray-800">معلومات الطلب المخصص</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">رقم الطلب</h4>
                            <p class="mt-1 text-sm text-gray-900">#{{ $customOrder->id }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">الحالة</h4>
                            <p class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($customOrder->status == 'completed') bg-green-100 text-green-800 
                                    @elseif($customOrder->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($customOrder->status == 'processing') bg-blue-100 text-blue-800
                                    @elseif($customOrder->status == 'cancelled') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ trans('orders.status.' . $customOrder->status) ?? $customOrder->status }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">تاريخ الطلب</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $customOrder->created_at->format('Y-m-d H:i') }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">آخر تحديث</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $customOrder->updated_at->format('Y-m-d H:i') }}</p>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-200">
                        <h4 class="text-sm font-medium text-gray-500">وصف الطلب</h4>
                        <div class="mt-2 prose prose-sm max-w-none text-gray-900">
                            {{ $customOrder->description }}
                        </div>
                    </div>

                    @if($customOrder->requirements)
                    <div class="pt-4 border-t border-gray-200">
                        <h4 class="text-sm font-medium text-gray-500">المتطلبات</h4>
                        <div class="mt-2 prose prose-sm max-w-none text-gray-900">
                            {{ $customOrder->requirements }}
                        </div>
                    </div>
                    @endif

                    @if($customOrder->file_path)
                    <div class="pt-4 border-t border-gray-200">
                        <h4 class="text-sm font-medium text-gray-500">الملفات المرفقة</h4>
                        <div class="mt-2">
                            <a href="{{ asset('storage/' . $customOrder->file_path) }}" target="_blank" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                تحميل الملف
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- معلومات السعر والدفع -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="bg-gray-50 px-4 py-3 border-b">
                    <h3 class="text-lg font-medium text-gray-800">معلومات السعر والدفع</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">السعر المقترح</h4>
                            <p class="mt-1 text-xl font-semibold text-gray-900">{{ number_format($customOrder->price, 2) }} ر.س</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">حالة الدفع</h4>
                            <p class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $customOrder->is_paid ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $customOrder->is_paid ? 'مدفوع' : 'غير مدفوع' }}
                                </span>
                            </p>
                        </div>
                    </div>

                    @if($customOrder->payment_method)
                    <div class="pt-4 border-t border-gray-200">
                        <h4 class="text-sm font-medium text-gray-500">طريقة الدفع</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $customOrder->payment_method }}</p>
                    </div>
                    @endif

                    @if($customOrder->payment_id)
                    <div class="pt-4 border-t border-gray-200">
                        <h4 class="text-sm font-medium text-gray-500">رقم معاملة الدفع</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $customOrder->payment_id }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- معلومات العميل والإجراءات -->
        <div class="space-y-6">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="bg-gray-50 px-4 py-3 border-b">
                    <h3 class="text-lg font-medium text-gray-800">معلومات العميل</h3>
                </div>
                <div class="p-6">
                    <div class="flex flex-col items-center pb-4">
                        <img class="h-20 w-20 rounded-full object-cover mb-3" src="{{ $customOrder->user->avatar ? asset('storage/' . $customOrder->user->avatar) : asset('images/default-avatar.png') }}" alt="{{ $customOrder->user->name }}">
                        <h3 class="text-lg font-medium text-gray-900">{{ $customOrder->user->name }}</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ $customOrder->user->email }}</p>
                        @if($customOrder->user->phone)
                        <p class="mt-1 text-sm text-gray-500">{{ $customOrder->user->phone }}</p>
                        @endif
                    </div>
                    
                    <div class="border-t pt-4">
                        <a href="{{ route('admin.users.show', $customOrder->user->id) }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            عرض ملف العميل
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="bg-gray-50 px-4 py-3 border-b">
                    <h3 class="text-lg font-medium text-gray-800">الإجراءات</h3>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('admin.custom_orders.edit', $customOrder) }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        تعديل الطلب
                    </a>
                    
                    @if($customOrder->status == 'pending')
                    <form action="{{ route('admin.custom_orders.update_status', $customOrder) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="processing">
                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            بدء المعالجة
                        </button>
                    </form>
                    @endif
                    
                    @if($customOrder->status == 'processing')
                    <form action="{{ route('admin.custom_orders.update_status', $customOrder) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="completed">
                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            تحديث للاكتمال
                        </button>
                    </form>
                    @endif
                    
                    @if($customOrder->status != 'cancelled' && $customOrder->status != 'completed')
                    <form action="{{ route('admin.custom_orders.update_status', $customOrder) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="cancelled">
                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            إلغاء الطلب
                        </button>
                    </form>
                    @endif
                    
                    <button onclick="if(confirm('هل أنت متأكد من حذف هذا الطلب المخصص؟')) document.getElementById('delete-order').submit();" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 mt-4">
                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        حذف الطلب
                    </button>
                    <form id="delete-order" action="{{ route('admin.custom_orders.destroy', $customOrder) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 