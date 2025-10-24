@extends('theme::layouts.app')

@section('title', 'استعادة كلمة المرور - ' . config('app.name'))

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-md mx-auto glass-effect rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-white">استعادة كلمة المرور</h2>
                <p class="text-gray-400 mt-2">أدخل بريدك الإلكتروني لإرسال رابط إعادة تعيين كلمة المرور</p>
            </div>

            @if (session('status'))
                <div class="bg-green-500 bg-opacity-20 border border-green-500 text-green-300 py-2 px-4 rounded-lg mb-6">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-white mb-2">البريد الإلكتروني</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                           class="w-full bg-[#1e1e1e] border border-[#3a3a3a] rounded-lg py-3 px-4 text-white placeholder-gray-400 focus:outline-none focus:border-primary"
                           placeholder="أدخل بريدك الإلكتروني">
                    @error('email')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-primary to-secondary text-white py-3 rounded-button font-medium whitespace-nowrap hover:opacity-90 transition-all neon-glow">
                    إرسال رابط إعادة التعيين
                </button>

                <div class="text-center mt-6">
                    <a href="{{ route('login') }}" class="text-primary hover:underline">
                        العودة لتسجيل الدخول
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 