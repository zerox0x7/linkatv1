@extends('themes.admin.layouts.app')

@section('title', 'إضافة تقييم جديد')

@section('content')
<div class="bg-gray-800 py-6 px-4 sm:px-6 lg:px-8 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-100">إضافة تقييم جديد</h1>
        <a href="{{ route('admin.reviews.index') }}" class="bg-gray-700 text-gray-200 py-2 px-4 rounded-md hover:bg-gray-600 transition-colors">
            العودة للتقييمات
        </a>
    </div>
    
    @if(session('success'))
    <div class="mb-4 p-4 bg-green-900 border border-green-700 text-green-200 rounded-md">
        {{ session('success') }}
    </div>
    @endif
    
    <form action="{{ route('admin.reviews.store') }}" method="POST">
        @csrf
        
        <div class="space-y-4">
            <div>
                <label for="product_id" class="block text-sm font-medium text-gray-300 mb-1">المنتج</label>
                <select name="product_id" id="product_id" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">اختر المنتج</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-300 mb-1">المستخدم</label>
                <select name="user_id" id="user_id" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">اختر المستخدم</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="rating" class="block text-sm font-medium text-gray-300 mb-1">التقييم</label>
                <div class="flex items-center">
                    <div class="flex">
                        @for($i = 1; $i <= 5; $i++)
                        <label class="p-1 cursor-pointer">
                            <input type="radio" name="rating" value="{{ $i }}" class="hidden" {{ old('rating') == $i ? 'checked' : '' }} {{ !old('rating') && $i == 5 ? 'checked' : '' }}>
                            <svg class="w-8 h-8 {{ (old('rating') == $i || (!old('rating') && $i == 5)) ? 'text-yellow-400' : 'text-gray-600' }} star-rating" data-rating="{{ $i }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </label>
                        @endfor
                    </div>
                    <span class="mr-2 text-sm text-gray-400">اختر تقييم من 1 إلى 5</span>
                </div>
                @error('rating')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="comment" class="block text-sm font-medium text-gray-300 mb-1">التعليق</label>
                <textarea id="comment" name="comment" rows="4" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('comment') }}</textarea>
                @error('comment')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex items-center">
                <input type="hidden" name="is_approved" value="0">
                <input type="checkbox" id="is_approved" name="is_approved" value="1" class="h-4 w-4 text-blue-600 border-gray-600 rounded bg-gray-700" {{ old('is_approved') ? 'checked' : '' }}>
                <label for="is_approved" class="mr-2 block text-sm text-gray-300">نشر فوراً</label>
                @error('is_approved')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="pt-4">
                <button type="submit" class="bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700 transition-colors">
                    إضافة التقييم
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const starInputs = document.querySelectorAll('input[name="rating"]');
    const starIcons = document.querySelectorAll('.star-rating');
    
    starInputs.forEach((input, index) => {
        input.addEventListener('change', function() {
            starIcons.forEach((icon, i) => {
                if (i <= index) {
                    icon.classList.remove('text-gray-600');
                    icon.classList.add('text-yellow-400');
                } else {
                    icon.classList.remove('text-yellow-400');
                    icon.classList.add('text-gray-600');
                }
            });
        });
    });
});
</script>
@endpush 