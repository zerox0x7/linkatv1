@extends('themes.admin.layouts.app')

@section('title', 'الأكواد المخصصة (CSS/JS)')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">الأكواد المخصصة (CSS/JS)</h1>
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('admin.settings.save_custom_code') }}" method="POST">
        @csrf
        <div class="mb-6 p-4 bg-gray-700 rounded border border-gray-600">
            <label for="custom_head_css" class="block font-bold mb-2 text-gray-200">CSS مخصص (الهيدر)</label>
            <textarea 
                name="custom_head_css" 
                id="custom_head_css" 
                rows="6" 
                dir="ltr"
                style="text-align: left; font-family: monospace;"
                class="w-full rounded border-gray-600 bg-gray-800 text-white focus:ring focus:ring-blue-400 transition-shadow duration-300 ease-in-out" 
                placeholder="ضع هنا أكواد CSS بدون وسم &lt;style&gt; ...&lt;/style&gt;">{{ old('custom_head_css', $custom_head_css) }}</textarea>
        </div>
        <div class="mb-6 p-4 bg-gray-700 rounded border border-gray-600">
            <label for="custom_footer_js" class="block font-bold mb-2 text-gray-200">JS مخصص (الفوتر)</label>
            <textarea 
                name="custom_footer_js" 
                id="custom_footer_js" 
                rows="6" 
                dir="ltr"
                style="text-align: left; font-family: monospace;"
                class="w-full rounded border-gray-600 bg-gray-800 text-white focus:ring focus:ring-blue-400 transition-shadow duration-300 ease-in-out" 
                placeholder="ضع هنا أكواد JavaScript بدون وسم &lt;script&gt; ...&lt;/script&gt;">{{ old('custom_footer_js', $custom_footer_js) }}</textarea>
        </div>
        <div class="mb-8 text-gray-500 text-sm">
            <i class="ri-information-line mr-1"></i>
            هذه الأكواد ستُدرج مباشرة في الموقع. يرجى استخدامها بحذر (للمسؤول فقط).
        </div>
        <button 
            type="submit" 
            class="bg-primary hover:bg-primary-dark text-white font-bold py-3 px-8 rounded shadow-lg transition duration-300 ease-in-out transform hover:scale-105"
        >
            حفظ الأكواد
        </button>
    </form>
</div>
@endsection
