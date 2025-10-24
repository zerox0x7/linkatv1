@extends('themes.admin.layouts.app')

@section('title', 'تعديل طريقة الدفع')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">تعديل طريقة الدفع</h1>
            <a href="{{ route('admin.payment-methods.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:bg-gray-700 dark:hover:bg-gray-800">
                <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                رجوع
            </a>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 mt-5">
        <form action="{{ route('admin.payment-methods.update', $paymentMethod) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-sm rounded-lg overflow-hidden dark:bg-gray-900">
            @csrf
            @method('PUT')
            <div class="px-4 py-5 sm:p-6 space-y-6">
                <!-- معلومات أساسية -->
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">معلومات أساسية</h3>
                    <div class="mt-5 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">اسم طريقة الدفع <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input type="text" name="name" id="name" value="{{ old('name', $paymentMethod->name) }}" required class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                            </div>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-200">رمز الطريقة <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input type="text" name="code" id="code" value="{{ old('code', $paymentMethod->code) }}" required readonly class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md bg-gray-100 cursor-not-allowed dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                            </div>
                            @error('code')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-200">الوصف</label>
                            <div class="mt-1">
                                <textarea name="description" id="description" rows="2" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">{{ old('description', $paymentMethod->description) }}</textarea>
                            </div>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- بيانات الاعتماد والإعدادات الخاصة -->
                @if($paymentMethod->code == 'myfatoorah')
                <div class="pt-5 border-t border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">إعدادات ماي فاتورة</h3>
                    <div class="mt-5 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                        <div>
                            <label for="apiKey" class="block text-sm font-medium text-gray-700 dark:text-gray-200">API Key (Token ID) <span class="text-red-500">*</span></label>
                            <input type="text" name="config[apiKey]" id="apiKey" value="{{ old('config.apiKey', $paymentMethod->config['apiKey'] ?? '') }}" required class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-200">العملة الرئيسية <span class="text-red-500">*</span></label>
                            <select name="settings[currency]" id="currency" required class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                <option value="SAR" {{ (old('settings.currency', json_decode($paymentMethod->settings, true)['currency'] ?? '') == 'SAR') ? 'selected' : '' }}>ريال سعودي (SAR)</option>
                                <option value="KWD" {{ (old('settings.currency', json_decode($paymentMethod->settings, true)['currency'] ?? '') == 'KWD') ? 'selected' : '' }}>دينار كويتي (KWD)</option>
                                <option value="AED" {{ (old('settings.currency', json_decode($paymentMethod->settings, true)['currency'] ?? '') == 'AED') ? 'selected' : '' }}>درهم إماراتي (AED)</option>
                                <option value="BHD" {{ (old('settings.currency', json_decode($paymentMethod->settings, true)['currency'] ?? '') == 'BHD') ? 'selected' : '' }}>دينار بحريني (BHD)</option>
                                <option value="OMR" {{ (old('settings.currency', json_decode($paymentMethod->settings, true)['currency'] ?? '') == 'OMR') ? 'selected' : '' }}>ريال عماني (OMR)</option>
                                <option value="QAR" {{ (old('settings.currency', json_decode($paymentMethod->settings, true)['currency'] ?? '') == 'QAR') ? 'selected' : '' }}>ريال قطري (QAR)</option>
                                <option value="EGP" {{ (old('settings.currency', json_decode($paymentMethod->settings, true)['currency'] ?? '') == 'EGP') ? 'selected' : '' }}>جنيه مصري (EGP)</option>
                            </select>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="mode" class="block text-sm font-medium text-gray-700 dark:text-gray-200">وضع التشغيل <span class="text-red-500">*</span></label>
                            <select name="mode" id="mode" required class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                <option value="test" {{ old('mode', $paymentMethod->mode ?? 'test') == 'test' ? 'selected' : '' }}>تجريبي (Test)</option>
                                <option value="live" {{ old('mode', $paymentMethod->mode ?? 'test') == 'live' ? 'selected' : '' }}>فعلي (Live)</option>
                            </select>
                        </div>
                    </div>
                </div>
                @endif

                @if($paymentMethod->code == 'clickpay')
                <div class="pt-5 border-t border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">إعدادات كليك باي</h3>
                    <div class="mt-5 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                        <div>
                            <label for="profile_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Profile ID <span class="text-red-500">*</span></label>
                            <input type="text" name="config[profile_id]" id="profile_id" value="{{ old('config.profile_id', $paymentMethod->config['profile_id'] ?? '') }}" required class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                        </div>
                        <div>
                            <label for="server_key" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Server Key <span class="text-red-500">*</span></label>
                            <input type="text" name="config[server_key]" id="server_key" value="{{ old('config.server_key', $paymentMethod->config['server_key'] ?? '') }}" required class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                        </div>
                    </div>
                </div>
                @endif

                <!-- رسوم الدفع -->
                <div class="pt-5 border-t border-gray-200 hidden">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">رسوم الدفع</h3>
                    <div class="mt-5 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                        <div>
                            <label for="fee_percentage" class="block text-sm font-medium text-gray-700 dark:text-gray-200">النسبة المئوية (%)</label>
                            <div class="mt-1">
                                <input type="number" name="fee_percentage" id="fee_percentage" value="{{ old('fee_percentage', $paymentMethod->fee_percentage ?? 0) }}" min="0" step="0.01" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                            </div>
                        </div>
                        <div>
                            <label for="fee_fixed" class="block text-sm font-medium text-gray-700 dark:text-gray-200">مبلغ ثابت (ر.س)</label>
                            <div class="mt-1">
                                <input type="number" name="fee_fixed" id="fee_fixed" value="{{ old('fee_fixed', $paymentMethod->fee_fixed ?? 0) }}" min="0" step="0.01" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- إعدادات إضافية -->
                <div class="pt-5 border-t border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">إعدادات إضافية</h3>
                    <div class="mt-5 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                        <div>
                            <label for="sort_order" class="block text-sm font-medium text-gray-700 dark:text-gray-200">ترتيب العرض</label>
                            <div class="mt-1">
                                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $paymentMethod->sort_order ?? 0) }}" min="0" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                            </div>
                        </div>
                        <div class="flex items-start pt-5">
                            <div class="flex items-center h-5">
                                <input id="is_active" name="is_active" type="checkbox" {{ old('is_active', $paymentMethod->is_active) ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                            </div>
                            <div class="mr-3 text-sm">
                                <label for="is_active" class="font-medium text-gray-700 dark:text-gray-200">تفعيل طريقة الدفع</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-4 py-3 bg-gray-50 text-left sm:px-6">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    حفظ التغييرات
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 