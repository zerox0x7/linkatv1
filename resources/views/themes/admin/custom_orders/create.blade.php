@extends('themes.admin.layouts.app')

@section('title', 'إضافة طلب مخصص جديد')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">إضافة طلب مخصص جديد</h1>
        <div class="flex items-center space-x-4 space-x-reverse">
            <a href="{{ route('admin.custom_orders.index') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                العودة للقائمة
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="bg-gray-50 px-4 py-3 border-b">
            <h3 class="text-lg font-medium text-gray-800">معلومات الطلب المخصص</h3>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.custom_orders.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- اختيار العميل -->
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700">العميل <span class="text-red-600">*</span></label>
                        <select name="user_id" id="user_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                            <option value="">اختر العميل</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- السعر المقترح -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">السعر المقترح <span class="text-red-600">*</span></label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 flex items-center">
                                <span class="text-gray-500 sm:text-sm border-0 bg-transparent py-0 pl-4 pr-2">ر.س</span>
                            </div>
                            <input type="number" name="price" id="price" value="{{ old('price', 0) }}" min="0" step="0.01" class="mt-1 block w-full pr-3 pl-12 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                        </div>
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- حالة الطلب -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">حالة الطلب <span class="text-red-600">*</span></label>
                        <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                            <option value="processing" {{ old('status') == 'processing' ? 'selected' : '' }}>قيد المعالجة</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>مكتمل</option>
                            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- حالة الدفع -->
                    <div>
                        <label for="is_paid" class="block text-sm font-medium text-gray-700">حالة الدفع <span class="text-red-600">*</span></label>
                        <select name="is_paid" id="is_paid" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                            <option value="0" {{ old('is_paid') == 0 ? 'selected' : '' }}>غير مدفوع</option>
                            <option value="1" {{ old('is_paid') == 1 ? 'selected' : '' }}>مدفوع</option>
                        </select>
                        @error('is_paid')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- وصف الطلب -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">وصف الطلب <span class="text-red-600">*</span></label>
                        <textarea name="description" id="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- المتطلبات -->
                    <div class="md:col-span-2">
                        <label for="requirements" class="block text-sm font-medium text-gray-700">المتطلبات</label>
                        <textarea name="requirements" id="requirements" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('requirements') }}</textarea>
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
                                <input type="text" name="payment_method" id="payment_method" value="{{ old('payment_method') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                @error('payment_method')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- رقم معاملة الدفع -->
                            <div>
                                <label for="payment_id" class="block text-sm font-medium text-gray-700">رقم معاملة الدفع</label>
                                <input type="text" name="payment_id" id="payment_id" value="{{ old('payment_id') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                @error('payment_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- ملف الطلب -->
                    <div class="md:col-span-2">
                        <label for="file" class="block text-sm font-medium text-gray-700">ملف الطلب</label>
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
                        <label for="admin_notes" class="block text-sm font-medium text-gray-700">ملاحظات المسؤول (غير مرئية للعميل)</label>
                        <textarea name="admin_notes" id="admin_notes" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('admin_notes') }}</textarea>
                        @error('admin_notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="md:col-span-2 flex justify-end">
                        <a href="{{ route('admin.custom_orders.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 ml-3">
                            إلغاء
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            إضافة الطلب
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 