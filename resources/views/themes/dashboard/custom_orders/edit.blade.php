@extends('themes.dashboard.layouts.app')

@section('title', 'تعديل الطلب المخصص #' . $customOrder->id)

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">تعديل الطلب المخصص #{{ $customOrder->id }}</h1>
        <div class="flex items-center space-x-4 space-x-reverse">
            <a href="{{ route('dashboard.custom_orders.show', $customOrder) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                العودة للتفاصيل
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="bg-gray-50 px-4 py-3 border-b">
            <h3 class="text-lg font-medium text-gray-800">معلومات الطلب المخصص</h3>
        </div>
        <div class="p-6">
            <form action="{{ route('dashboard.custom_orders.update', $customOrder) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- معلومات العميل (غير قابلة للتعديل) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">العميل</label>
                        <div class="mt-1 flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full object-cover" src="{{ $customOrder->user->avatar ? asset('storage/' . $customOrder->user->avatar) : asset('images/default-avatar.png') }}" alt="{{ $customOrder->user->name }}">
                            </div>
                            <div class="mr-4">
                                <div class="text-sm font-medium text-gray-900">{{ $customOrder->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $customOrder->user->email }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- السعر المقترح -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">السعر المقترح <span class="text-red-600">*</span></label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 flex items-center">
                                <span class="text-gray-500 sm:text-sm border-0 bg-transparent py-0 pl-4 pr-2">ر.س</span>
                            </div>
                            <input type="number" name="price" id="price" value="{{ old('price', $customOrder->price) }}" min="0" step="0.01" class="mt-1 block w-full pr-3 pl-12 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                        </div>
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- حالة الطلب -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">حالة الطلب <span class="text-red-600">*</span></label>
                        <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                            <option value="pending" {{ old('status', $customOrder->status) == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                            <option value="processing" {{ old('status', $customOrder->status) == 'processing' ? 'selected' : '' }}>قيد المعالجة</option>
                            <option value="completed" {{ old('status', $customOrder->status) == 'completed' ? 'selected' : '' }}>مكتمل</option>
                            <option value="cancelled" {{ old('status', $customOrder->status) == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- حالة الدفع -->
                    <div>
                        <label for="is_paid" class="block text-sm font-medium text-gray-700">حالة الدفع <span class="text-red-600">*</span></label>
                        <select name="is_paid" id="is_paid" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                            <option value="0" {{ old('is_paid', $customOrder->is_paid) == 0 ? 'selected' : '' }}>غير مدفوع</option>
                            <option value="1" {{ old('is_paid', $customOrder->is_paid) == 1 ? 'selected' : '' }}>مدفوع</option>
                        </select>
                        @error('is_paid')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- وصف الطلب -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">وصف الطلب <span class="text-red-600">*</span></label>
                        <textarea name="description" id="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>{{ old('description', $customOrder->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- المتطلبات -->
                    <div class="md:col-span-2">
                        <label for="requirements" class="block text-sm font-medium text-gray-700">المتطلبات</label>
                        <textarea name="requirements" id="requirements" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('requirements', $customOrder->requirements) }}</textarea>
                        @error('requirements')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- معلومات الدفع -->
                    <div class="pt-4 md:col-span-2 border-t border-gray-200">
                        <h4 class="text-lg font-medium text-gray-800 mb-4">معلومات الدفع</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- طريقة الدفع -->
                            <div>
                                <label for="payment_method" class="block text-sm font-medium text-gray-700">طريقة الدفع</label>
                                <input type="text" name="payment_method" id="payment_method" value="{{ old('payment_method', $customOrder->payment_method) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                @error('payment_method')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- رقم معاملة الدفع -->
                            <div>
                                <label for="payment_id" class="block text-sm font-medium text-gray-700">رقم معاملة الدفع</label>
                                <input type="text" name="payment_id" id="payment_id" value="{{ old('payment_id', $customOrder->payment_id) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                @error('payment_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- ملف الطلب -->
                    <div class="md:col-span-2">
                        <label for="file" class="block text-sm font-medium text-gray-700">ملف الطلب</label>
                        
                        @if($customOrder->file_path)
                        <div class="mt-1 flex items-center">
                            <span class="inline-flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 bg-gray-50 border border-gray-300">
                                <svg class="ml-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                                <span>{{ basename($customOrder->file_path) }}</span>
                            </span>
                            <a href="{{ asset('storage/' . $customOrder->file_path) }}" target="_blank" class="mr-3 text-sm text-blue-600 hover:text-blue-500">
                                عرض الملف
                            </a>
                        </div>
                        <div class="mt-2">
                            <input type="checkbox" name="remove_file" id="remove_file" class="rounded text-blue-600 focus:ring-blue-500 border-gray-300">
                            <label for="remove_file" class="mr-2 text-sm text-gray-700">إزالة الملف الحالي</label>
                        </div>
                        @endif
                        
                        <div class="mt-2">
                            <input type="file" name="file" id="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="mt-1 text-sm text-gray-500">PDF، Word، Excel، الصور بحد أقصى 10 ميجا</p>
                        </div>
                        @error('file')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- ملاحظات المسؤول -->
                    <div class="md:col-span-2">
                        <label for="dashboard_notes" class="block text-sm font-medium text-gray-700">ملاحظات المسؤول (غير مرئية للعميل)</label>
                        <textarea name="dashboard_notes" id="dashboard_notes" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('dashboard_notes', $customOrder->dashboard_notes) }}</textarea>
                        @error('dashboard_notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="md:col-span-2 flex justify-end">
                        <a href="{{ route('dashboard.custom_orders.show', $customOrder) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 ml-3">
                            إلغاء
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            حفظ التغييرات
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 