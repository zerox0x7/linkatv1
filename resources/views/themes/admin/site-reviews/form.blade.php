@extends('themes.admin.layouts.app')

@section('title', isset($siteReview) ? 'تعديل تقييم' : 'إضافة تقييم جديد')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">{{ isset($siteReview) ? 'تعديل تقييم' : 'إضافة تقييم جديد' }}</h1>
        <a href="{{ route('admin.site-reviews.index') }}" class="bg-gray-200 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-300 transition-colors">
            العودة لتقييمات الموقع
        </a>
    </div>
    
    @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
        {{ session('success') }}
    </div>
    @endif
    
    @if($errors->any())
    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <form action="{{ isset($siteReview) ? route('admin.site-reviews.update', $siteReview->id) : route('admin.site-reviews.store') }}" method="POST" class="space-y-6">
        @csrf
        @if(isset($siteReview))
            @method('PUT')
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">الاسم</label>
                <input type="text" name="name" id="name" value="{{ old('name', $siteReview->name ?? '') }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div>
                <label for="position" class="block text-sm font-medium text-gray-700 mb-1">المسمى الوظيفي</label>
                <input type="text" name="position" id="position" value="{{ old('position', $siteReview->position ?? '') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div>
                <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">التقييم</label>
                <select name="rating" id="rating" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ (old('rating', $siteReview->rating ?? '') == $i) ? 'selected' : '' }}>
                            {{ $i }} {{ $i == 1 ? 'نجمة' : 'نجوم' }}
                        </option>
                    @endfor
                </select>
            </div>
            
            <div>
                <label for="is_approved" class="block text-sm font-medium text-gray-700 mb-1">الحالة</label>
                <select name="is_approved" id="is_approved"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="1" {{ (old('is_approved', $siteReview->is_approved ?? '') == 1) ? 'selected' : '' }}>معتمد</option>
                    <option value="0" {{ (old('is_approved', $siteReview->is_approved ?? '') == 0) ? 'selected' : '' }}>قيد المراجعة</option>
                </select>
            </div>
        </div>
        
        <div>
            <label for="review" class="block text-sm font-medium text-gray-700 mb-1">نص التقييم</label>
            <textarea name="review" id="review" rows="4" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('review', $siteReview->review ?? '') }}</textarea>
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700 transition-colors">
                {{ isset($siteReview) ? 'حفظ التغييرات' : 'إضافة التقييم' }}
            </button>
        </div>
    </form>
</div>
@endsection 