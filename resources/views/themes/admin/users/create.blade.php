@extends('themes.admin.layouts.app')

@section('title', 'إضافة مستخدم جديد')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">إضافة مستخدم جديد</h1>
        <div class="flex items-center space-x-4 space-x-reverse">
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-700 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-900">
                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                العودة للقائمة
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-lg shadow overflow-hidden">
        <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100">معلومات المستخدم</h3>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- اسم المستخدم -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">الاسم الكامل <span class="text-red-600">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-100" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- البريد الإلكتروني -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">البريد الإلكتروني <span class="text-red-600">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-100" required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- كلمة المرور -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200">كلمة المرور <span class="text-red-600">*</span></label>
                        <input type="password" name="password" id="password" class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-100" required>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- تأكيد كلمة المرور -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-200">تأكيد كلمة المرور <span class="text-red-600">*</span></label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-100" required>
                    </div>

                    <!-- رقم الهاتف -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-200">رقم الهاتف</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-100">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- الدور -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-200">الدور <span class="text-red-600">*</span></label>
                        <select name="role" id="role" class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-100" required>
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>مستخدم</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>مسؤول</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- الصورة الرمزية -->
                    <div class="md:col-span-2">
                        <label for="avatar" class="block text-sm font-medium text-gray-700 dark:text-gray-200">الصورة الشخصية</label>
                        <div class="mt-1 flex items-center">
                            <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700">
                                <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </span>
                            <div class="mr-4">
                                <div class="relative bg-white dark:bg-gray-800 py-2 px-3 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm flex items-center cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500 dark:focus-within:ring-offset-gray-900">
                                    <label for="avatar" class="relative text-sm font-medium text-gray-700 dark:text-gray-200 pointer-events-none">
                                        <span>تحميل صورة</span>
                                    </label>
                                    <input id="avatar" name="avatar" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer border-gray-300 dark:border-gray-700" accept="image/*">
                                </div>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PNG, JPG حتى 2 ميجا</p>
                            </div>
                        </div>
                        @error('avatar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- حالة النشاط -->
                    <div class="md:col-span-2">
                        <div class="relative flex items-start">
                            <div class="flex items-center h-5">
                                <input id="is_active" name="is_active" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-700 rounded" value="1" {{ old('is_active') ? 'checked' : '' }}>
                            </div>
                            <div class="mr-3 text-sm">
                                <label for="is_active" class="font-medium text-gray-700 dark:text-gray-200">المستخدم نشط</label>
                                <p class="text-gray-500 dark:text-gray-400">سيتمكن المستخدم من تسجيل الدخول إذا كان نشطاً</p>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-2 flex justify-end">
                        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-700 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-900 ml-3">
                            إلغاء
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-900">
                            إضافة المستخدم
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 