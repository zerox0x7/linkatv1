@extends('theme::layouts.app')

@section('title', 'المنتجات المميزة')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumbs -->
    <div class="flex items-center text-sm text-gray-400 mb-6">
        <a href="{{ route('home') }}" class="hover:text-primary">الرئيسية</a>
        <i class="ri-arrow-left-s-line mx-2"></i>
        <a href="{{ route('products.index') }}" class="hover:text-primary">المنتجات</a>
        <i class="ri-arrow-left-s-line mx-2"></i>
        <span class="text-gray-300">المنتجات المميزة</span>
    </div>

    

    <!-- Featured Products Grid -->
    <div class="mb-8">
        <!-- Header with Count and Sort -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <h2 class="text-2xl font-bold text-white mb-2 sm:mb-0">
                منتجات مميزة
                <span class="text-gray-400 text-sm font-normal">({{ $products->total() }} منتج)</span>
            </h2>
            
            <div class="w-full sm:w-auto">
                <select name="sort" id="sort-select" class="bg-[#1a1a1a] border border-gray-700 rounded-lg p-2 text-white w-full sm:w-auto"
                        onchange="document.getElementById('sort-form').submit()">
                    <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>الأحدث</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>السعر: من الأقل إلى الأعلى</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>السعر: من الأعلى إلى الأقل</option>
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>الأكثر مبيعاً</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>أعلى تقييماً</option>
                </select>
                <form id="sort-form" action="{{ route('products.featured') }}" method="GET" class="hidden">
                    <input type="hidden" name="sort" id="sort-input" value="{{ request('sort', 'newest') }}">
                </form>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @if($products->count() > 0)
                @foreach($products as $product)
                <div class="glass-effect rounded-lg overflow-hidden transition-all duration-300 card-hover flex flex-col h-full">
                    <div class="relative">
                        <div class="h-40 sm:h-48 bg-gradient-to-b from-[#1e1e1e] to-[#121212]" style="background-image: url('{{ $product->image_url }}'); background-size: cover; background-position: center;"></div>
                        @if($product->is_featured)
                        <div class="product-card-badge badge-featured">
                            مميز
                        </div>
                        @elseif($product->created_at > now()->subDays(7))
                        <div class="product-card-badge badge-new">
                            جديد
                        </div>
                        @elseif($product->discount_percentage > 0)
                        <div class="product-card-badge badge-sale">
                            خصم {{ $product->discount_percentage }}%
                        </div>
                        @endif
                        
                        @if($product->status == 'out-of-stock')
                        <div class="product-card-badge badge-out-of-stock">
                            نفذت الكمية
                        </div>
                        @endif
                    </div>
                        
                    <div class="p-3 sm:p-4 flex flex-col flex-grow">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between mb-3">
                            <h3 class="text-sm sm:text-base font-bold text-white line-clamp-2 leading-tight min-h-[2.5rem]">{{ $product->name }}</h3>
                            @if($product->reviews_avg_rating)
                            <div class="flex items-center text-yellow-400 text-xs sm:text-sm mt-1 sm:mt-0 sm:ml-2 whitespace-nowrap">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $product->reviews_avg_rating)
                                        <i class="ri-star-fill"></i>
                                    @elseif($i - 0.5 <= $product->reviews_avg_rating)
                                        <i class="ri-star-half-fill"></i>
                                    @else
                                        <i class="ri-star-line"></i>
                                    @endif
                                @endfor
                                <span class="text-gray-400 mr-1 ml-1">{{ number_format($product->reviews_avg_rating, 1) }}</span>
                            </div>
                            @else
                            <div class="flex items-center text-yellow-400 text-xs sm:text-sm mt-1 sm:mt-0 sm:ml-2 whitespace-nowrap">
                                @for($i = 1; $i <= 5; $i++)
                                <i class="ri-star-line"></i>
                                @endfor
                            </div>
                            @endif
                        </div>
                        <div class="space-y-1 sm:space-y-2 mb-4 text-xs sm:text-sm">
                            <div class="flex items-center text-sm text-gray-300">
                                <i class="ri-gamepad-line ml-1"></i>
                                <span>{{ $product->category ? $product->category->name : 'عام' }}</span>
                            </div>
                            @if($product->attributes && isset($product->attributes['features']))
                            <div class="flex items-center text-sm text-gray-300">
                                <i class="ri-vip-crown-line ml-1"></i>
                                <span>{{ $product->attributes['features'] }}</span>
                            </div>
                            @endif
                            
                        </div>
                        <div class="mt-auto">
                            <div class="mb-3">
                                @if($product->has_discount)
                                <div class="text-primary font-bold text-xl">{{ $product->display_price }} ر.س</div>
                                <div class="text-gray-400 text-sm line-through">{{ $product->display_old_price }} ر.س</div>
                                @else
                                <div class="text-primary font-bold text-xl">{{ $product->display_price }} ر.س</div>
                                @endif
                            </div>
                            <a href="{{ route('products.show', $product->slug) }}" 
                               class="block w-full bg-gradient-to-r from-primary to-secondary text-white py-2 rounded-button text-sm font-medium text-center whitespace-nowrap hover:opacity-90 transition-all {{ $product->status == 'out-of-stock' ? 'opacity-50 cursor-not-allowed' : '' }}">
                                {{ $product->status == 'out-of-stock' ? 'نفذت الكمية' : 'شراء الآن' }}
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-span-4 text-center py-8">
                    <div class="text-4xl text-gray-500 mb-3">
                        <i class="ri-shopping-bag-line"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">لا توجد منتجات مميزة حاليًا</h3>
                    <p class="text-gray-400 mb-6">نحن نعمل على إضافة المزيد من المنتجات المميزة، يرجى العودة لاحقًا.</p>
                    <a href="{{ route('products.index') }}" class="bg-primary hover:bg-blue-600 text-white px-6 py-2 rounded-lg inline-block transition-colors">
                        عرض جميع المنتجات
                    </a>
                </div>
            @endif
        </div>
        
        <!-- Pagination -->
        <div class="mt-8">
            {{ $products->appends(request()->query())->links() }}
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // Sort dropdown handler
    $(document).ready(function() {
        $('#sort-select').on('change', function() {
            $('#sort-input').val($(this).val());
            $('#sort-form').submit();
        });
    });
</script>
@endpush 