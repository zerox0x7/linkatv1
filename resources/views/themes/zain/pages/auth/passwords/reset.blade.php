@extends('theme::layouts.app')

@section('title', 'إعادة تعيين كلمة المرور - ' . config('app.name'))

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-md mx-auto glass-effect rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-white">إعادة تعيين كلمة المرور</h2>
                <p class="text-gray-400 mt-2">أدخل كلمة المرور الجديدة</p>
            </div>

            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label for="email" class="block text-white mb-2">البريد الإلكتروني</label>
                    <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus
                           class="w-full bg-[#1e1e1e] border border-[#3a3a3a] rounded-lg py-3 px-4 text-white placeholder-gray-400 focus:outline-none focus:border-primary"
                           placeholder="أدخل بريدك الإلكتروني">
                    @error('email')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-white mb-2">كلمة المرور الجديدة</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           class="w-full bg-[#1e1e1e] border border-[#3a3a3a] rounded-lg py-3 px-4 text-white placeholder-gray-400 focus:outline-none focus:border-primary"
                           placeholder="أدخل كلمة المرور الجديدة">
                    @error('password')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="password-confirm" class="block text-white mb-2">تأكيد كلمة المرور</label>
                    <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password"
                           class="w-full bg-[#1e1e1e] border border-[#3a3a3a] rounded-lg py-3 px-4 text-white placeholder-gray-400 focus:outline-none focus:border-primary"
                           placeholder="أعد إدخال كلمة المرور الجديدة">
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-primary to-secondary text-white py-3 rounded-button font-medium whitespace-nowrap hover:opacity-90 transition-all neon-glow">
                    إعادة تعيين كلمة المرور
                </button>
            </form>
        </div>
    </div>
</div>
@endsection 