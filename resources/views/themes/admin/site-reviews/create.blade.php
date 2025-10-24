@extends('themes.admin.layouts.app')

@section('title', 'إضافة تقييم جديد')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">إضافة تقييم للموقع</h1>
        <a href="{{ route('admin.site-reviews.index') }}" class="bg-gray-200 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-300 transition-colors">
            العودة لتقييمات الموقع
        </a>
    </div>
    
    @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
        {{ session('success') }}
    </div>
    @endif
    
    <form action="{{ route('admin.site-reviews.store') }}" method="POST">
        @csrf
        
        <div class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">اسم العميل</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="position" class="block text-sm font-medium text-gray-700 mb-1">المسمى الوظيفي (اختياري)</label>
                <input type="text" id="position" name="position" value="{{ old('position') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('position')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">التقييم</label>
                <div class="flex items-center">
                    <div class="flex">
                        @for($i = 1; $i <= 5; $i++)
                        <label class="p-1 cursor-pointer">
                            <input type="radio" name="rating" value="{{ $i }}" class="hidden" {{ old('rating') == $i ? 'checked' : '' }} {{ !old('rating') && $i == 5 ? 'checked' : '' }}>
                            <svg class="w-8 h-8 {{ (old('rating') == $i || (!old('rating') && $i == 5)) ? 'text-yellow-400' : 'text-gray-300' }} star-rating" data-rating="{{ $i }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </label>
                        @endfor
                    </div>
                    <span class="mr-2 text-sm text-gray-500">اختر تقييم من 1 إلى 5</span>
                </div>
                @error('rating')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="review" class="block text-sm font-medium text-gray-700 mb-1">التعليق</label>
                <textarea id="review" name="review" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('review') }}</textarea>
                @error('review')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex items-center">
                <input type="hidden" name="is_approved" value="0">
                <input type="checkbox" id="is_approved" name="is_approved" value="1" class="h-4 w-4 text-blue-600 border-gray-300 rounded" {{ old('is_approved') ? 'checked' : '' }}>
                <label for="is_approved" class="mr-2 block text-sm text-gray-700">نشر فوراً</label>
                @error('is_approved')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
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
        const stars = document.querySelectorAll('.star-rating');
        const ratingInputs = document.querySelectorAll('input[name="rating"]');
        
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = parseInt(this.dataset.rating);
                
                // تحديث قيمة الراديو بوتون
                ratingInputs.forEach(input => {
                    if (parseInt(input.value) === rating) {
                        input.checked = true;
                    }
                });
                
                // تحديث لون النجوم
                stars.forEach(s => {
                    const starRating = parseInt(s.dataset.rating);
                    if (starRating <= rating) {
                        s.classList.remove('text-gray-300');
                        s.classList.add('text-yellow-400');
                    } else {
                        s.classList.remove('text-yellow-400');
                        s.classList.add('text-gray-300');
                    }
                });
            });
        });
    });
</script>
@endpush 