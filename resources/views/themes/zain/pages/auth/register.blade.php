@extends('theme::layouts.app')

@section('title', 'إنشاء حساب جديد - ' . config('app.name'))

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-md mx-auto glass-effect rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-white">إنشاء حساب جديد</h2>
                <p class="text-gray-400 mt-2">أدخل بياناتك لإنشاء حساب جديد</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-white mb-2">الاسم الكامل</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full bg-[#1e1e1e] border border-[#3a3a3a] rounded-lg py-3 px-4 text-white placeholder-gray-400 focus:outline-none focus:border-primary"
                        placeholder="أدخل اسمك الكامل">
                    @error('name')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-white mb-2">البريد الإلكتروني</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="w-full bg-[#1e1e1e] border border-[#3a3a3a] rounded-lg py-3 px-4 text-white placeholder-gray-400 focus:outline-none focus:border-primary"
                        placeholder="أدخل بريدك الإلكتروني">
                    @error('email')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-white mb-2">رقم الهاتف</label>
                    <input id="phone" type="text" name="phone" value="{{ $verifiedPhone ? ltrim($verifiedPhone, '+') : old('phone') }}" 
                        {{ $verifiedPhone ? 'readonly' : '' }} required
                        class="w-full border border-[#3a3a3a] rounded-lg py-3 px-4 placeholder-gray-400 focus:outline-none focus:border-primary {{ $verifiedPhone ? 'bg-[#2f2f2f] text-gray-400 cursor-not-allowed' : 'bg-[#1e1e1e] text-white' }}"
                        placeholder="أدخل رقم هاتفك">
                    @error('phone')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-white mb-2">كلمة المرور</label>
                    <input id="password" type="password" name="password" required
                        class="w-full bg-[#1e1e1e] border border-[#3a3a3a] rounded-lg py-3 px-4 text-white placeholder-gray-400 focus:outline-none focus:border-primary"
                        placeholder="أدخل كلمة المرور">
                    @error('password')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="password-confirm" class="block text-white mb-2">تأكيد كلمة المرور</label>
                    <input id="password-confirm" type="password" name="password_confirmation" required
                        class="w-full bg-[#1e1e1e] border border-[#3a3a3a] rounded-lg py-3 px-4 text-white placeholder-gray-400 focus:outline-none focus:border-primary"
                        placeholder="أعد إدخال كلمة المرور">
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="terms" id="terms" required
                        class="text-primary bg-[#1e1e1e] border-[#3a3a3a] rounded focus:ring-0">
                    <label for="terms" class="text-white mr-3">
                        أوافق على <a href="{{ route('terms') }}" class="text-primary hover:underline">الشروط والأحكام</a> و <a href="{{ route('privacy-policy') }}" class="text-primary hover:underline">سياسة الخصوصية</a>
                    </label>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-primary to-secondary text-white py-3 rounded-button font-medium whitespace-nowrap hover:opacity-90 transition-all neon-glow">
                    إنشاء حساب
                </button>

                <div class="text-center mt-6">
                    <p class="text-gray-400">
                        لديك حساب بالفعل؟
                        <a href="{{ route('login') }}" class="text-primary hover:underline">
                            تسجيل الدخول
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 