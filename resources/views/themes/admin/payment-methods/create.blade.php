@extends('themes.admin.layouts.app')

@section('title', 'إضافة طريقة دفع جديدة')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#0f1623] to-[#162033] py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <!-- Header Section with Modern Styling -->
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-r from-primary to-secondary flex items-center justify-center shadow-lg">
                    <i class="ri-add-line text-black text-xl font-bold"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-white">إضافة طريقة دفع جديدة</h1>
                    <p class="text-gray-400 mt-1">أضف طريقة دفع جديدة للمتجر</p>
                </div>
            </div>
            <a href="{{ route('admin.payment-methods.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-[#121827] to-[#1a2234] border border-[#2a3548] rounded-xl shadow-lg hover:shadow-xl text-white hover:text-primary transition-all duration-300 group">
                <i class="ri-arrow-right-line group-hover:-translate-x-1 transition-transform"></i>
                رجوع
            </a>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <form action="{{ route('admin.payment-methods.store') }}" method="POST" enctype="multipart/form-data" class="bg-gradient-to-br from-[#121827] to-[#1a2234] border border-[#2a3548] rounded-2xl overflow-hidden shadow-2xl">
            @csrf
            
            <div class="px-8 py-8 space-y-8">
                <!-- معلومات أساسية -->
                <div class="bg-gradient-to-r from-[#0f1623] to-[#1a2234] rounded-xl p-6 border border-[#2a3548]">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-primary/20 flex items-center justify-center">
                            <i class="ri-information-line text-primary"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white">معلومات أساسية</h3>
                    </div>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-300 mb-2">الاسم <span class="text-red-400">*</span></label>
                            <div class="relative">
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                                       class="w-full px-4 py-3 bg-[#0f1623] border border-[#2a3548] rounded-xl text-white placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300">
                            </div>
                            @error('name')
                                <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                                    <i class="ri-error-warning-line"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="code" class="block text-sm font-semibold text-gray-300 mb-2">الكود <span class="text-red-400">*</span></label>
                            <div class="relative">
                                <select name="code" id="code" required 
                                        class="w-full px-4 py-3 bg-[#0f1623] border border-[#2a3548] rounded-xl text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300">
                                    <option value="" class="bg-[#0f1623] text-gray-400">اختر طريقة الدفع</option>
                                    <option value="paypal" {{ old('code') == 'paypal' ? 'selected' : '' }} class="bg-[#0f1623] text-white">PayPal</option>
                                    <option value="stripe" {{ old('code') == 'stripe' ? 'selected' : '' }} class="bg-[#0f1623] text-white">Stripe</option>
                                    <option value="myfatoorah" {{ old('code') == 'myfatoorah' ? 'selected' : '' }} class="bg-[#0f1623] text-white">MyFatoorah</option>
                                    <option value="bank_transfer" {{ old('code') == 'bank_transfer' ? 'selected' : '' }} class="bg-[#0f1623] text-white">تحويل بنكي</option>
                                    <option value="cash" {{ old('code') == 'cash' ? 'selected' : '' }} class="bg-[#0f1623] text-white">الدفع نقداً</option>
                                </select>
                            </div>
                            @error('code')
                                <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                                    <i class="ri-error-warning-line"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="description" class="block text-sm font-semibold text-gray-300 mb-2">الوصف</label>
                            <div class="relative">
                                <textarea name="description" id="description" rows="3" 
                                          class="w-full px-4 py-3 bg-[#0f1623] border border-[#2a3548] rounded-xl text-white placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300 resize-none">{{ old('description') }}</textarea>
                            </div>
                            @error('description')
                                <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                                    <i class="ri-error-warning-line"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="mode" class="block text-sm font-semibold text-gray-300 mb-2">وضع التشغيل <span class="text-red-400">*</span></label>
                            <div class="relative">
                                <select name="mode" id="mode" required 
                                        class="w-full px-4 py-3 bg-[#0f1623] border border-[#2a3548] rounded-xl text-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300">
                                    <option value="test" {{ old('mode') == 'test' ? 'selected' : '' }} class="bg-[#0f1623] text-white">تجريبي</option>
                                    <option value="live" {{ old('mode') == 'live' ? 'selected' : '' }} class="bg-[#0f1623] text-white">مباشر</option>
                                </select>
                            </div>
                            @error('mode')
                                <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                                    <i class="ri-error-warning-line"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="logo" class="block text-sm font-semibold text-gray-300 mb-2">الشعار</label>
                            <div class="relative">
                                <div class="flex items-center justify-center w-full">
                                    <label for="logo" class="flex flex-col items-center justify-center w-full h-32 border-2 border-[#2a3548] border-dashed rounded-xl cursor-pointer bg-[#0f1623] hover:bg-[#1a2234] hover:border-primary/50 transition-all duration-300 group">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <i class="ri-upload-cloud-line text-4xl text-gray-400 group-hover:text-primary mb-2"></i>
                                            <p class="mb-2 text-sm text-gray-400 group-hover:text-gray-300">اضغط لرفع الصورة</p>
                                            <p class="text-xs text-gray-500">PNG, JPG أو GIF (MAX. 2MB)</p>
                                        </div>
                                        <input type="file" name="logo" id="logo" accept="image/*" class="hidden">
                                    </label>
                                </div>
                            </div>
                            @error('logo')
                                <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                                    <i class="ri-error-warning-line"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- بيانات الاعتماد والإعدادات -->
                <div id="credentials-container" class="bg-gradient-to-r from-[#0f1623] to-[#1a2234] rounded-xl p-6 border border-[#2a3548]">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-cyan-500/20 flex items-center justify-center">
                            <i class="ri-shield-keyhole-line text-cyan-400"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white">بيانات الاعتماد</h3>
                    </div>
                    <p class="text-gray-400 mb-6">أدخل بيانات الاعتماد الخاصة بطريقة الدفع المختارة</p>
                    
                    <!-- PayPal Credentials -->
                    <div id="paypal-credentials" class="grid grid-cols-1 gap-8 sm:grid-cols-2 hidden">
                        <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548]">
                            <div class="flex items-center gap-2 mb-4">
                                <div class="w-6 h-6 rounded-lg bg-yellow-500/20 flex items-center justify-center">
                                    <i class="ri-flask-line text-yellow-400 text-sm"></i>
                                </div>
                                <h4 class="font-semibold text-white">وضع الاختبار (Sandbox)</h4>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label for="test_client_id" class="block text-sm font-medium text-gray-300 mb-2">Client ID</label>
                                    <input type="text" name="test_client_id" id="test_client_id" value="{{ old('test_client_id') }}" 
                                           class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-xl text-white placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300">
                                </div>
                                <div>
                                    <label for="test_client_secret" class="block text-sm font-medium text-gray-300 mb-2">Client Secret</label>
                                    <input type="password" name="test_client_secret" id="test_client_secret" value="{{ old('test_client_secret') }}" 
                                           class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-xl text-white placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300">
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548]">
                            <div class="flex items-center gap-2 mb-4">
                                <div class="w-6 h-6 rounded-lg bg-green-500/20 flex items-center justify-center">
                                    <i class="ri-rocket-line text-green-400 text-sm"></i>
                                </div>
                                <h4 class="font-semibold text-white">وضع الإنتاج (Live)</h4>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label for="live_client_id" class="block text-sm font-medium text-gray-300 mb-2">Client ID</label>
                                    <input type="text" name="live_client_id" id="live_client_id" value="{{ old('live_client_id') }}" 
                                           class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-xl text-white placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300">
                                </div>
                                <div>
                                    <label for="live_client_secret" class="block text-sm font-medium text-gray-300 mb-2">Client Secret</label>
                                    <input type="password" name="live_client_secret" id="live_client_secret" value="{{ old('live_client_secret') }}" 
                                           class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-xl text-white placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stripe Credentials -->
                    <div id="stripe-credentials" class="grid grid-cols-1 gap-8 sm:grid-cols-2 hidden">
                        <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548]">
                            <div class="flex items-center gap-2 mb-4">
                                <div class="w-6 h-6 rounded-lg bg-yellow-500/20 flex items-center justify-center">
                                    <i class="ri-flask-line text-yellow-400 text-sm"></i>
                                </div>
                                <h4 class="font-semibold text-white">وضع الاختبار (Test)</h4>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label for="test_publishable_key" class="block text-sm font-medium text-gray-300 mb-2">Publishable Key</label>
                                    <input type="text" name="test_publishable_key" id="test_publishable_key" value="{{ old('test_publishable_key') }}" 
                                           class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-xl text-white placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300">
                                </div>
                                <div>
                                    <label for="test_secret_key" class="block text-sm font-medium text-gray-300 mb-2">Secret Key</label>
                                    <input type="password" name="test_secret_key" id="test_secret_key" value="{{ old('test_secret_key') }}" 
                                           class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-xl text-white placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300">
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548]">
                            <div class="flex items-center gap-2 mb-4">
                                <div class="w-6 h-6 rounded-lg bg-green-500/20 flex items-center justify-center">
                                    <i class="ri-rocket-line text-green-400 text-sm"></i>
                                </div>
                                <h4 class="font-semibold text-white">وضع الإنتاج (Live)</h4>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label for="live_publishable_key" class="block text-sm font-medium text-gray-300 mb-2">Publishable Key</label>
                                    <input type="text" name="live_publishable_key" id="live_publishable_key" value="{{ old('live_publishable_key') }}" 
                                           class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-xl text-white placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300">
                                </div>
                                <div>
                                    <label for="live_secret_key" class="block text-sm font-medium text-gray-300 mb-2">Secret Key</label>
                                    <input type="password" name="live_secret_key" id="live_secret_key" value="{{ old('live_secret_key') }}" 
                                           class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-xl text-white placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- MyFatoorah Credentials -->
                    <div id="myfatoorah-credentials" class="grid grid-cols-1 gap-8 sm:grid-cols-2 hidden">
                        <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548]">
                            <div class="flex items-center gap-2 mb-4">
                                <div class="w-6 h-6 rounded-lg bg-yellow-500/20 flex items-center justify-center">
                                    <i class="ri-flask-line text-yellow-400 text-sm"></i>
                                </div>
                                <h4 class="font-semibold text-white">وضع الاختبار (Test)</h4>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label for="test_api_key" class="block text-sm font-medium text-gray-300 mb-2">API Key</label>
                                    <input type="password" name="test_api_key" id="test_api_key" value="{{ old('test_api_key') }}" 
                                           class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-xl text-white placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300">
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548]">
                            <div class="flex items-center gap-2 mb-4">
                                <div class="w-6 h-6 rounded-lg bg-green-500/20 flex items-center justify-center">
                                    <i class="ri-rocket-line text-green-400 text-sm"></i>
                                </div>
                                <h4 class="font-semibold text-white">وضع الإنتاج (Live)</h4>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label for="live_api_key" class="block text-sm font-medium text-gray-300 mb-2">API Key</label>
                                    <input type="password" name="live_api_key" id="live_api_key" value="{{ old('live_api_key') }}" 
                                           class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-xl text-white placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bank Transfer Details -->
                    <div id="bank-transfer-credentials" class="hidden">
                        <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548]">
                            <div class="flex items-center gap-2 mb-6">
                                <div class="w-6 h-6 rounded-lg bg-blue-500/20 flex items-center justify-center">
                                    <i class="ri-bank-line text-blue-400 text-sm"></i>
                                </div>
                                <h4 class="font-semibold text-white">معلومات التحويل البنكي</h4>
                            </div>
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <label for="bank_name" class="block text-sm font-medium text-gray-300 mb-2">اسم البنك</label>
                                    <input type="text" name="bank_name" id="bank_name" value="{{ old('bank_name') }}" 
                                           class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-xl text-white placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300">
                                </div>
                                <div>
                                    <label for="account_name" class="block text-sm font-medium text-gray-300 mb-2">اسم صاحب الحساب</label>
                                    <input type="text" name="account_name" id="account_name" value="{{ old('account_name') }}" 
                                           class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-xl text-white placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300">
                                </div>
                                <div>
                                    <label for="account_number" class="block text-sm font-medium text-gray-300 mb-2">رقم الحساب</label>
                                    <input type="text" name="account_number" id="account_number" value="{{ old('account_number') }}" 
                                           class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-xl text-white placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300">
                                </div>
                                <div>
                                    <label for="iban" class="block text-sm font-medium text-gray-300 mb-2">رقم الآيبان (IBAN)</label>
                                    <input type="text" name="iban" id="iban" value="{{ old('iban') }}" 
                                           class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-xl text-white placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300">
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="swift_code" class="block text-sm font-medium text-gray-300 mb-2">رمز السويفت (SWIFT)</label>
                                    <input type="text" name="swift_code" id="swift_code" value="{{ old('swift_code') }}" 
                                           class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-xl text-white placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- رسوم الدفع -->
                <div class="bg-gradient-to-r from-[#0f1623] to-[#1a2234] rounded-xl p-6 border border-[#2a3548]">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-orange-500/20 flex items-center justify-center">
                            <i class="ri-money-dollar-circle-line text-orange-400"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white">رسوم الدفع</h3>
                    </div>
                    <p class="text-gray-400 mb-6">رسوم إضافية يتم تحصيلها عند استخدام طريقة الدفع هذه</p>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="fee_percentage" class="block text-sm font-semibold text-gray-300 mb-2">النسبة المئوية (%)</label>
                            <div class="relative">
                                <input type="number" name="fee_percentage" id="fee_percentage" value="{{ old('fee_percentage', 0) }}" min="0" step="0.01" 
                                       class="w-full px-4 py-3 bg-[#0f1623] border border-[#2a3548] rounded-xl text-white placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300">
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <i class="ri-percent-line"></i>
                                </div>
                            </div>
                            @error('fee_percentage')
                                <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                                    <i class="ri-error-warning-line"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="fee_fixed" class="block text-sm font-semibold text-gray-300 mb-2">مبلغ ثابت (ر.س)</label>
                            <div class="relative">
                                <input type="number" name="fee_fixed" id="fee_fixed" value="{{ old('fee_fixed', 0) }}" min="0" step="0.01" 
                                       class="w-full px-4 py-3 bg-[#0f1623] border border-[#2a3548] rounded-xl text-white placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300">
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <i class="ri-money-dollar-circle-line"></i>
                                </div>
                            </div>
                            @error('fee_fixed')
                                <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                                    <i class="ri-error-warning-line"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- إعدادات إضافية -->
                <div class="bg-gradient-to-r from-[#0f1623] to-[#1a2234] rounded-xl p-6 border border-[#2a3548]">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-purple-500/20 flex items-center justify-center">
                            <i class="ri-settings-3-line text-purple-400"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white">إعدادات إضافية</h3>
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="sort_order" class="block text-sm font-semibold text-gray-300 mb-2">ترتيب العرض</label>
                            <div class="relative">
                                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" min="0" 
                                       class="w-full px-4 py-3 bg-[#0f1623] border border-[#2a3548] rounded-xl text-white placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300">
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <i class="ri-sort-asc"></i>
                                </div>
                            </div>
                            @error('sort_order')
                                <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                                    <i class="ri-error-warning-line"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <div class="flex items-start gap-4 p-4 bg-[#0f1623] rounded-xl border border-[#2a3548]">
                                <div class="flex items-center">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active') ? 'checked' : '' }} 
                                               class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                    </label>
                                </div>
                                <div class="flex-1">
                                    <label for="is_active" class="block text-sm font-semibold text-white mb-1">تفعيل طريقة الدفع</label>
                                    <p class="text-sm text-gray-400">عند التفعيل، سيتم عرض طريقة الدفع هذه للعملاء أثناء عملية الشراء</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-8 py-6 bg-gradient-to-r from-[#121827] to-[#1a2234] border-t border-[#2a3548]">
                <div class="flex justify-end gap-4">
                    <a href="{{ route('admin.payment-methods.index') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-transparent border border-[#2a3548] rounded-xl text-gray-300 hover:text-white hover:border-gray-500 transition-all duration-300">
                        <i class="ri-close-line"></i>
                        إلغاء
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-primary to-secondary rounded-xl text-black font-semibold hover:shadow-lg hover:shadow-primary/25 transition-all duration-300 transform hover:scale-105">
                        <i class="ri-save-line"></i>
                    حفظ طريقة الدفع
                </button>
                </div>
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
        const credentialsContainer = document.getElementById('credentials-container');

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
                case 'cash':
                    // لا توجد بيانات اعتماد للدفع نقداً
                    break;
            }
        }

        // تنفيذ الدالة عند تغيير طريقة الدفع
        codeSelect.addEventListener('change', showCredentialsForm);

        // تنفيذ الدالة عند تحميل الصفحة
        showCredentialsForm();

        // تحسين تجربة رفع الملفات
        const logoInput = document.getElementById('logo');
        const logoLabel = logoInput.previousElementSibling;
        
        logoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.createElement('img');
                    preview.src = e.target.result;
                    preview.className = 'w-16 h-16 object-cover rounded-lg';
                    
                    // إزالة المحتوى السابق
                    logoLabel.innerHTML = '';
                    logoLabel.appendChild(preview);
                    
                    // إضافة نص توضيحي
                    const text = document.createElement('p');
                    text.textContent = file.name;
                    text.className = 'text-xs text-gray-400 mt-2';
                    logoLabel.appendChild(text);
                };
                reader.readAsDataURL(file);
            }
        });

        // تحسين تأثيرات التركيز على الحقول
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-primary/20');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-primary/20');
            });
        });

        // إضافة تأثيرات تفاعلية للأزرار
        const buttons = document.querySelectorAll('button, a[href]');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-1px)';
            });
            
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
</script>

<style>
    /* تحسينات إضافية للتصميم */
    .form-section {
        transition: all 0.3s ease;
    }
    
    .form-section:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    /* تأثيرات للعناصر التفاعلية */
    input:focus, select:focus, textarea:focus {
        box-shadow: 0 0 0 3px rgba(0, 229, 187, 0.1);
    }
    
    /* تحسين التمرير */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-track {
        background: rgba(42, 53, 72, 0.3);
        border-radius: 3px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #00e5bb, #0f172a);
        border-radius: 3px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #00e5bb, #0f172a);
        opacity: 0.8;
    }
    
    /* تأثيرات متقدمة للأزرار */
    .btn-primary {
        position: relative;
        overflow: hidden;
    }
    
    .btn-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }
    
    .btn-primary:hover::before {
        left: 100%;
    }
</style>
@endpush
@endsection 