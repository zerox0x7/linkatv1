@extends('themes.admin.layouts.app')

@section('title', 'إضافة طريقة دفع جديدة')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">إضافة طريقة دفع جديدة</h1>
            <a href="{{ route('admin.payment-methods.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:bg-gray-700 dark:hover:bg-gray-800">
                <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                رجوع
            </a>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 mt-5">
        <form action="{{ route('admin.payment-methods.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-sm rounded-lg overflow-hidden dark:bg-gray-900">
            @csrf
            
            <div class="px-4 py-5 sm:p-6 space-y-6">
                <!-- معلومات أساسية -->
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">معلومات أساسية</h3>
                    <div class="mt-5 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">الاسم <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                            </div>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-200">الكود <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <select name="code" id="code" required class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                    <option value="">اختر طريقة الدفع</option>
                                    <option value="paypal" {{ old('code') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                                    <option value="stripe" {{ old('code') == 'stripe' ? 'selected' : '' }}>Stripe</option>
                                    <option value="myfatoorah" {{ old('code') == 'myfatoorah' ? 'selected' : '' }}>MyFatoorah</option>
                                    <option value="bank_transfer" {{ old('code') == 'bank_transfer' ? 'selected' : '' }}>تحويل بنكي</option>
                                    <option value="cash" {{ old('code') == 'cash' ? 'selected' : '' }}>الدفع نقداً</option>
                                </select>
                            </div>
                            @error('code')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-200">الوصف</label>
                            <div class="mt-1">
                                <textarea name="description" id="description" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">{{ old('description') }}</textarea>
                            </div>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="mode" class="block text-sm font-medium text-gray-700 dark:text-gray-200">وضع التشغيل <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <select name="mode" id="mode" required class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                    <option value="test" {{ old('mode') == 'test' ? 'selected' : '' }}>تجريبي</option>
                                    <option value="live" {{ old('mode') == 'live' ? 'selected' : '' }}>مباشر</option>
                                </select>
                            </div>
                            @error('mode')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="logo" class="block text-sm font-medium text-gray-700 dark:text-gray-200">الشعار</label>
                            <div class="mt-1">
                                <input type="file" name="logo" id="logo" accept="image/*" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                            </div>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">صورة بحجم مناسب لعرضها كشعار لطريقة الدفع</p>
                            @error('logo')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- بيانات الاعتماد والإعدادات -->
                <div id="credentials-container" class="pt-5 border-t border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">بيانات الاعتماد</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">أدخل بيانات الاعتماد الخاصة بطريقة الدفع المختارة</p>
                    
                    <!-- PayPal Credentials -->
                    <div id="paypal-credentials" class="mt-5 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2 hidden">
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-gray-100">وضع الاختبار (Sandbox)</h4>
                            <div class="mt-2 space-y-4">
                                <div>
                                    <label for="test_client_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Client ID</label>
                                    <input type="text" name="test_client_id" id="test_client_id" value="{{ old('test_client_id') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                </div>
                                <div>
                                    <label for="test_client_secret" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Client Secret</label>
                                    <input type="password" name="test_client_secret" id="test_client_secret" value="{{ old('test_client_secret') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-gray-100">وضع الإنتاج (Live)</h4>
                            <div class="mt-2 space-y-4">
                                <div>
                                    <label for="live_client_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Client ID</label>
                                    <input type="text" name="live_client_id" id="live_client_id" value="{{ old('live_client_id') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                </div>
                                <div>
                                    <label for="live_client_secret" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Client Secret</label>
                                    <input type="password" name="live_client_secret" id="live_client_secret" value="{{ old('live_client_secret') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stripe Credentials -->
                    <div id="stripe-credentials" class="mt-5 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2 hidden">
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-gray-100">وضع الاختبار (Test)</h4>
                            <div class="mt-2 space-y-4">
                                <div>
                                    <label for="test_publishable_key" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Publishable Key</label>
                                    <input type="text" name="test_publishable_key" id="test_publishable_key" value="{{ old('test_publishable_key') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                </div>
                                <div>
                                    <label for="test_secret_key" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Secret Key</label>
                                    <input type="password" name="test_secret_key" id="test_secret_key" value="{{ old('test_secret_key') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-gray-100">وضع الإنتاج (Live)</h4>
                            <div class="mt-2 space-y-4">
                                <div>
                                    <label for="live_publishable_key" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Publishable Key</label>
                                    <input type="text" name="live_publishable_key" id="live_publishable_key" value="{{ old('live_publishable_key') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                </div>
                                <div>
                                    <label for="live_secret_key" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Secret Key</label>
                                    <input type="password" name="live_secret_key" id="live_secret_key" value="{{ old('live_secret_key') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- MyFatoorah Credentials -->
                    <div id="myfatoorah-credentials" class="mt-5 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2 hidden">
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-gray-100">وضع الاختبار (Test)</h4>
                            <div class="mt-2 space-y-4">
                                <div>
                                    <label for="test_api_key" class="block text-sm font-medium text-gray-700 dark:text-gray-200">API Key</label>
                                    <input type="password" name="test_api_key" id="test_api_key" value="{{ old('test_api_key') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-gray-100">وضع الإنتاج (Live)</h4>
                            <div class="mt-2 space-y-4">
                                <div>
                                    <label for="live_api_key" class="block text-sm font-medium text-gray-700 dark:text-gray-200">API Key</label>
                                    <input type="password" name="live_api_key" id="live_api_key" value="{{ old('live_api_key') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bank Transfer Details -->
                    <div id="bank-transfer-credentials" class="mt-5 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2 hidden">
                        <div class="sm:col-span-2">
                            <div class="mt-2 space-y-4">
                                <div>
                                    <label for="bank_name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">اسم البنك</label>
                                    <input type="text" name="bank_name" id="bank_name" value="{{ old('bank_name') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                </div>
                                <div>
                                    <label for="account_name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">اسم صاحب الحساب</label>
                                    <input type="text" name="account_name" id="account_name" value="{{ old('account_name') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                </div>
                                <div>
                                    <label for="account_number" class="block text-sm font-medium text-gray-700 dark:text-gray-200">رقم الحساب</label>
                                    <input type="text" name="account_number" id="account_number" value="{{ old('account_number') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                </div>
                                <div>
                                    <label for="iban" class="block text-sm font-medium text-gray-700 dark:text-gray-200">رقم الآيبان (IBAN)</label>
                                    <input type="text" name="iban" id="iban" value="{{ old('iban') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                </div>
                                <div>
                                    <label for="swift_code" class="block text-sm font-medium text-gray-700 dark:text-gray-200">رمز السويفت (SWIFT)</label>
                                    <input type="text" name="swift_code" id="swift_code" value="{{ old('swift_code') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- رسوم الدفع -->
                <div class="pt-5 border-t border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">رسوم الدفع</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">رسوم إضافية يتم تحصيلها عند استخدام طريقة الدفع هذه</p>

                    <div class="mt-5 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                        <div>
                            <label for="fee_percentage" class="block text-sm font-medium text-gray-700 dark:text-gray-200">النسبة المئوية (%)</label>
                            <div class="mt-1">
                                <input type="number" name="fee_percentage" id="fee_percentage" value="{{ old('fee_percentage', 0) }}" min="0" step="0.01" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                            </div>
                            @error('fee_percentage')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="fee_fixed" class="block text-sm font-medium text-gray-700 dark:text-gray-200">مبلغ ثابت (ر.س)</label>
                            <div class="mt-1">
                                <input type="number" name="fee_fixed" id="fee_fixed" value="{{ old('fee_fixed', 0) }}" min="0" step="0.01" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                            </div>
                            @error('fee_fixed')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
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
                                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                            </div>
                            @error('sort_order')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active') ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="is_active" class="font-medium text-gray-700 dark:text-gray-200">تفعيل طريقة الدفع</label>
                                    <p class="text-gray-500 dark:text-gray-300">عند التفعيل، سيتم عرض طريقة الدفع هذه للعملاء أثناء عملية الشراء</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    حفظ طريقة الدفع
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const codeSelect = document.getElementById('code');
        const paypalCredentials = document.getElementById('paypal-credentials');
        const stripeCredentials = document.getElementById('stripe-credentials');
        const myfatoorahCredentials = document.getElementById('myfatoorah-credentials');
        const bankTransferCredentials = document.getElementById('bank-transfer-credentials');

        function showCredentialsForm() {
            // إخفاء جميع النماذج أولاً
            paypalCredentials.classList.add('hidden');
            stripeCredentials.classList.add('hidden');
            myfatoorahCredentials.classList.add('hidden');
            bankTransferCredentials.classList.add('hidden');

            // إظهار النموذج المناسب حسب طريقة الدفع المختارة
            switch (codeSelect.value) {
                case 'paypal':
                    paypalCredentials.classList.remove('hidden');
                    break;
                case 'stripe':
                    stripeCredentials.classList.remove('hidden');
                    break;
                case 'myfatoorah':
                    myfatoorahCredentials.classList.remove('hidden');
                    break;
                case 'bank_transfer':
                    bankTransferCredentials.classList.remove('hidden');
                    break;
            }
        }

        // تنفيذ الدالة عند تغيير طريقة الدفع
        codeSelect.addEventListener('change', showCredentialsForm);

        // تنفيذ الدالة عند تحميل الصفحة
        showCredentialsForm();
    });
</script>
@endpush
@endsection 