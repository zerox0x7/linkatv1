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
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">مثال: مدى، فيزا، تحويل بنكي ...</p>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-200">رمز الطريقة <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input type="text" name="code" id="code" value="{{ old('code', $paymentMethod->code) }}" required readonly class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                            </div>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">أدخل رمزًا فريدًا (مثال: paymob, tap, stripe, ...). يُستخدم هذا الكود في النظام البرمجي لتمييز الطريقة.</p>
                            @error('code')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-200">الوصف</label>
                            <div class="mt-1">
                                <textarea name="description" id="description" rows="2" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">{{ old('description', $paymentMethod->description) }}</textarea>
                            </div>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">وصف مختصر يظهر للمستخدمين عن طريقة الدفع.</p>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="mode" class="block text-sm font-medium text-gray-700 dark:text-gray-200">وضع التشغيل</label>
                            <select name="mode" id="mode" required class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                <option value="test" {{ old('mode', $paymentMethod->mode ?? 'test') == 'test' ? 'selected' : '' }}>تجريبي (Test)</option>
                                <option value="live" {{ old('mode', $paymentMethod->mode ?? 'test') == 'live' ? 'selected' : '' }}>فعلي (Live)</option>
                            </select>
                        </div>
                        <div>
                            <label for="logo" class="block text-sm font-medium text-gray-700 dark:text-gray-200">الشعار</label>
                            <div class="mt-1">
                                <input type="file" name="logo" id="logo" accept="image/*" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                            </div>
                            @if($paymentMethod->logo)
                                <div class="mt-2">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">الشعار الحالي:</p>
                                    <img src="{{ asset('storage/' . $paymentMethod->logo) }}" alt="{{ $paymentMethod->name }}" class="h-12 w-auto mt-2">
                                </div>
                            @endif
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">صورة تظهر بجانب اسم الطريقة في المتجر.</p>
                            @error('logo')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- بيانات الاعتماد والإعدادات -->
                <div id="credentials-container" class="pt-5 border-t border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">بيانات الاعتماد</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">أدخل بيانات الربط الخاصة بطريقة الدفع المختارة حسب الوثائق الرسمية.</p>
                    @if($paymentMethod->code == 'clickpay')
                    <div id="clickpay-credentials" class="mt-5 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <div class="mt-2 space-y-4">
                                <div>
                                    <label for="profile_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">معرف الملف الشخصي (Profile ID)</label>
                                    <input type="text" name="config[profile_id]" id="profile_id" value="{{ old('config.profile_id', $paymentMethod->config['profile_id'] ?? '') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">يمكنك الحصول عليه من لوحة تحكم ClickPay.</p>
                                </div>
                                <div>
                                    <label for="server_key" class="block text-sm font-medium text-gray-700 dark:text-gray-200">مفتاح الخادم (Server Key)</label>
                                    <input type="text" name="config[server_key]" id="server_key" value="{{ old('config.server_key', $paymentMethod->config['server_key'] ?? '') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">مفتاح API السري الخاص بك.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <!-- PayPal Credentials -->
                    <div id="paypal-credentials" class="mt-5 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2 {{ $paymentMethod->code != 'paypal' ? 'hidden' : '' }}">
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-gray-100">وضع الاختبار (Sandbox)</h4>
                            <div class="mt-2 space-y-4">
                                <div>
                                    <label for="test_client_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Client ID</label>
                                    <input type="text" name="test_client_id" id="test_client_id" value="{{ old('test_client_id', $paymentMethod->config['test']['client_id'] ?? '') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">معرف العميل في وضع الاختبار.</p>
                                </div>
                                <div>
                                    <label for="test_client_secret" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Client Secret</label>
                                    <input type="password" name="test_client_secret" id="test_client_secret" value="{{ old('test_client_secret', $paymentMethod->config['test']['client_secret'] ?? '') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">السر الخاص بالعميل في وضع الاختبار.</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-gray-100">وضع الإنتاج (Live)</h4>
                            <div class="mt-2 space-y-4">
                                <div>
                                    <label for="live_client_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Client ID</label>
                                    <input type="text" name="live_client_id" id="live_client_id" value="{{ old('live_client_id', $paymentMethod->config['live']['client_id'] ?? '') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">معرف العميل في وضع الإنتاج.</p>
                                </div>
                                <div>
                                    <label for="live_client_secret" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Client Secret</label>
                                    <input type="password" name="live_client_secret" id="live_client_secret" value="{{ old('live_client_secret', $paymentMethod->config['live']['client_secret'] ?? '') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">السر الخاص بالعميل في وضع الإنتاج.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Stripe Credentials -->
                    <div id="stripe-credentials" class="mt-5 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2 {{ $paymentMethod->code != 'stripe' ? 'hidden' : '' }}">
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-gray-100">وضع الاختبار (Test)</h4>
                            <div class="mt-2 space-y-4">
                                <div>
                                    <label for="test_publishable_key" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Publishable Key</label>
                                    <input type="text" name="test_publishable_key" id="test_publishable_key" value="{{ old('test_publishable_key', $paymentMethod->config['test']['publishable_key'] ?? '') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">المفتاح العام في وضع الاختبار.</p>
                                </div>
                                <div>
                                    <label for="test_secret_key" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Secret Key</label>
                                    <input type="password" name="test_secret_key" id="test_secret_key" value="{{ old('test_secret_key', $paymentMethod->config['test']['secret_key'] ?? '') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">المفتاح السري في وضع الاختبار.</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-gray-100">وضع الإنتاج (Live)</h4>
                            <div class="mt-2 space-y-4">
                                <div>
                                    <label for="live_publishable_key" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Publishable Key</label>
                                    <input type="text" name="live_publishable_key" id="live_publishable_key" value="{{ old('live_publishable_key', $paymentMethod->config['live']['publishable_key'] ?? '') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">المفتاح العام في وضع الإنتاج.</p>
                                </div>
                                <div>
                                    <label for="live_secret_key" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Secret Key</label>
                                    <input type="password" name="live_secret_key" id="live_secret_key" value="{{ old('live_secret_key', $paymentMethod->config['live']['secret_key'] ?? '') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">المفتاح السري في وضع الإنتاج.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- MyFatoorah Credentials -->
                    <div id="myfatoorah-credentials" class="mt-5 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2 {{ $paymentMethod->code != 'myfatoorah' ? 'hidden' : '' }}">
                        <div class="sm:col-span-2">
                            <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-200">العملة الرئيسية</label>
                            <select name="currency" id="currency" required class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                <option value="SAR" {{ old('currency', $paymentMethod->settings['currency'] ?? '') == 'SAR' ? 'selected' : '' }}>ريال سعودي (SAR)</option>
                                <option value="KWD" {{ old('currency', $paymentMethod->settings['currency'] ?? '') == 'KWD' ? 'selected' : '' }}>دينار كويتي (KWD)</option>
                                <option value="AED" {{ old('currency', $paymentMethod->settings['currency'] ?? '') == 'AED' ? 'selected' : '' }}>درهم إماراتي (AED)</option>
                                <option value="BHD" {{ old('currency', $paymentMethod->settings['currency'] ?? '') == 'BHD' ? 'selected' : '' }}>دينار بحريني (BHD)</option>
                                <option value="OMR" {{ old('currency', $paymentMethod->settings['currency'] ?? '') == 'OMR' ? 'selected' : '' }}>ريال عماني (OMR)</option>
                                <option value="QAR" {{ old('currency', $paymentMethod->settings['currency'] ?? '') == 'QAR' ? 'selected' : '' }}>ريال قطري (QAR)</option>
                                <option value="EGP" {{ old('currency', $paymentMethod->settings['currency'] ?? '') == 'EGP' ? 'selected' : '' }}>جنيه مصري (EGP)</option>
                                <!-- أضف عملات أخرى حسب الحاجة -->
                            </select>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">اختر العملة الرئيسية التي تود استقبال المدفوعات بها</p>
                        </div>
                        <div class="sm:col-span-2 flex flex-col gap-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">API Key (Token ID)</label>
                            <input type="password" name="api_key" id="api_key" value="{{ old('api_key', $paymentMethod->config['apiKey'] ?? '') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">أدخل رمز الربط (Token ID) الخاص بحسابك في ماي فاتورة</p>
                        </div>
                        <div class="sm:col-span-2 flex flex-col gap-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">vcCode</label>
                            <input type="text" name="vcCode" id="vcCode" value="{{ old('vcCode', $paymentMethod->config['vcCode'] ?? 'SAU') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">أدخل رمز الدولة (مثال: SAU)</p>
                        </div>
                        <div class="sm:col-span-2 flex items-center gap-4 mt-2">
                            <input type="hidden" name="mode" id="mode" value="{{ old('mode', $paymentMethod->mode ?? 'test') }}">
                            <button type="button" id="toggle-mode" class="w-40 py-2 rounded text-white font-bold focus:outline-none transition-all"
                                :class="mode === 'live' ? 'bg-green-600 hover:bg-green-700' : 'bg-yellow-500 hover:bg-yellow-600">
                                <span x-text="mode === 'live' ? 'LIVE MODE' : 'TEST MODE'"></span>
                            </button>
                            <span class="text-sm text-gray-500 dark:text-gray-400">نوع المحاكاة: اختر بين الوضع التجريبي أو الفعلي</span>
                        </div>
                    </div>
                    <!-- Bank Transfer Details -->
                    <div id="bank-transfer-credentials" class="mt-5 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2 {{ $paymentMethod->code != 'bank_transfer' ? 'hidden' : '' }}">
                        <div class="sm:col-span-2">
                            <div class="mt-2 space-y-4">
                                <div>
                                    <label for="bank_name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">اسم البنك</label>
                                    <input type="text" name="bank_name" id="bank_name" value="{{ old('bank_name', $paymentMethod->config['bank_name'] ?? '') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">اسم البنك الذي سيتم التحويل إليه.</p>
                                </div>
                                <div>
                                    <label for="account_name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">اسم صاحب الحساب</label>
                                    <input type="text" name="account_name" id="account_name" value="{{ old('account_name', $paymentMethod->config['account_name'] ?? '') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">اسم صاحب الحساب البنكي.</p>
                                </div>
                                <div>
                                    <label for="account_number" class="block text-sm font-medium text-gray-700 dark:text-gray-200">رقم الحساب</label>
                                    <input type="text" name="account_number" id="account_number" value="{{ old('account_number', $paymentMethod->config['account_number'] ?? '') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">رقم الحساب البنكي.</p>
                                </div>
                                <div>
                                    <label for="iban" class="block text-sm font-medium text-gray-700 dark:text-gray-200">رقم الآيبان (IBAN)</label>
                                    <input type="text" name="iban" id="iban" value="{{ old('iban', $paymentMethod->config['iban'] ?? '') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">رقم الآيبان الدولي.</p>
                                </div>
                                <div>
                                    <label for="swift_code" class="block text-sm font-medium text-gray-700 dark:text-gray-200">رمز السويفت (SWIFT)</label>
                                    <input type="text" name="swift_code" id="swift_code" value="{{ old('swift_code', $paymentMethod->config['swift_code'] ?? '') }}" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">رمز السويفت الخاص بالبنك.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- رسوم الدفع -->
                <div class="pt-5 border-t border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">رسوم الدفع</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">حدد الرسوم الإضافية (إن وجدت) التي سيتم تحصيلها عند استخدام هذه الطريقة.</p>
                    <div class="mt-5 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                        <div>
                            <label for="fee_percentage" class="block text-sm font-medium text-gray-700 dark:text-gray-200">النسبة المئوية (%)</label>
                            <div class="mt-1">
                                <input type="number" name="fee_percentage" id="fee_percentage" value="{{ old('fee_percentage', $paymentMethod->fee_percentage ?? 0) }}" min="0" step="0.01" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                            </div>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">مثال: 2.5 تعني 2.5% من قيمة الطلب.</p>
                            @error('fee_percentage')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="fee_fixed" class="block text-sm font-medium text-gray-700 dark:text-gray-200">مبلغ ثابت (ر.س)</label>
                            <div class="mt-1">
                                <input type="number" name="fee_fixed" id="fee_fixed" value="{{ old('fee_fixed', $paymentMethod->fee_fixed ?? 0) }}" min="0" step="0.01" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                            </div>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">يضاف هذا المبلغ على كل طلب يستخدم هذه الطريقة.</p>
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
                                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $paymentMethod->sort_order ?? 0) }}" min="0" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                            </div>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">كلما كان الرقم أصغر ظهرت الطريقة أولاً في صفحة الدفع.</p>
                            @error('sort_order')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-start pt-5">
                            <div class="flex items-center h-5">
                                <input id="is_active" name="is_active" type="checkbox" {{ old('is_active', $paymentMethod->is_active) ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                            </div>
                            <div class="mr-3 text-sm">
                                <label for="is_active" class="font-medium text-gray-700 dark:text-gray-200">تفعيل طريقة الدفع</label>
                                <p class="text-gray-500 dark:text-gray-300">عند التفعيل، ستظهر هذه الطريقة للعملاء أثناء عملية الشراء.</p>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const codeSelect = document.getElementById('code');
        const paypalCredentials = document.getElementById('paypal-credentials');
        const stripeCredentials = document.getElementById('stripe-credentials');
        const myfatoorahCredentials = document.getElementById('myfatoorah-credentials');
        const bankTransferCredentials = document.getElementById('bank-transfer-credentials');
        // Toggle mode button
        const modeInput = document.getElementById('mode');
        const apiKeyInput = document.getElementById('api_key');
        const toggleModeBtn = document.getElementById('toggle-mode');
        let config = @json($paymentMethod->config);
        let mode = modeInput.value || 'test';
        function updateApiKeyField() {
            let key = (config[mode] && config[mode]['api_key']) ? config[mode]['api_key'] : '';
            apiKeyInput.value = key;
        }
        if (toggleModeBtn) {
            toggleModeBtn.addEventListener('click', function() {
                mode = (mode === 'live') ? 'test' : 'live';
                modeInput.value = mode;
                toggleModeBtn.textContent = (mode === 'live') ? 'LIVE MODE' : 'TEST MODE';
                toggleModeBtn.className = (mode === 'live') ? 'w-40 py-2 rounded text-white font-bold bg-green-600 hover:bg-green-700' : 'w-40 py-2 rounded text-white font-bold bg-yellow-500 hover:bg-yellow-600';
                updateApiKeyField();
            });
        }
        updateApiKeyField();
        // إظهار/إخفاء الحقول حسب الكود
        codeSelect.addEventListener('change', function() {
            myfatoorahCredentials.classList.toggle('hidden', codeSelect.value !== 'myfatoorah');
        });
    });
</script>
@endpush
