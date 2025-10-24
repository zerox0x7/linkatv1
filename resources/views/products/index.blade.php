@extends('layouts.app')

@section('title', 'منتجات المتجر')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Sidebar - Filters -->
        <div class="w-full lg:w-1/4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 mb-6">
                <h3 class="text-lg font-bold mb-4">تصفية المنتجات</h3>
                
                <form id="filter-form" action="{{ route('products.index') }}" method="GET">
                    <!-- Categories Filter -->
                    <div class="mb-4">
                        <h4 class="font-medium mb-2">الفئات</h4>
                        <div class="space-y-2">
                            @foreach($categories as $category)
                            <div class="flex items-center">
                                <input type="checkbox" name="category_ids[]" value="{{ $category->id }}" 
                                    id="cat-{{ $category->id }}" class="form-checkbox h-4 w-4 text-primary"
                                    {{ in_array($category->id, request()->input('category_ids', [])) ? 'checked' : '' }}>
                                <label for="cat-{{ $category->id }}" class="mr-2 text-gray-700 dark:text-gray-300">
                                    {{ $category->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Price Range Filter -->
                    <div class="mb-4">
                        <h4 class="font-medium mb-2">نطاق السعر</h4>
                        <div class="flex flex-col space-y-2">
                            <div>
                                <label for="min_price" class="text-sm text-gray-600 dark:text-gray-400">من</label>
                                <input type="number" min="0" name="min_price" id="min_price" 
                                    value="{{ request()->input('min_price') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 
                                        dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary focus:ring focus:ring-primary">
                            </div>
                            <div>
                                <label for="max_price" class="text-sm text-gray-600 dark:text-gray-400">إلى</label>
                                <input type="number" min="0" name="max_price" id="max_price"
                                    value="{{ request()->input('max_price') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 
                                        dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary focus:ring focus:ring-primary">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Rating Filter -->
                    <div class="mb-4">
                        <h4 class="font-medium mb-2">التقييم</h4>
                        <div class="space-y-2">
                            @for($i = 5; $i >= 1; $i--)
                            <div class="flex items-center">
                                <input type="radio" name="rating_filter" value="{{ $i }}" 
                                    id="rating-{{ $i }}" class="form-radio h-4 w-4 text-primary"
                                    {{ request()->input('rating_filter') == $i ? 'checked' : '' }}>
                                <label for="rating-{{ $i }}" class="mr-2 flex items-center text-gray-700 dark:text-gray-300">
                                    @for($j = 1; $j <= 5; $j++)
                                        <i class="{{ $j <= $i ? 'ri-star-fill text-yellow-400' : 'ri-star-line text-gray-400' }} text-sm"></i>
                                    @endfor
                                    <span class="mr-1">{{ $i }}+</span>
                                </label>
                            </div>
                            @endfor
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="flex justify-between">
                        <button type="submit" class="bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-md transition duration-300">
                            تطبيق الفلتر
                        </button>
                        <a href="{{ route('products.index') }}" class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 px-4 py-2 rounded-md transition duration-300">
                            إعادة ضبط
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="w-full lg:w-3/4">
            <!-- Sorting and View Options -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                <h1 class="text-2xl font-bold mb-4 md:mb-0">{{ $currentCategory ? $currentCategory->name : 'جميع المنتجات' }}</h1>
                
                <div class="flex items-center space-x-4 space-x-reverse">
                    <div class="flex items-center">
                        <span class="text-gray-700 dark:text-gray-300 ml-2">ترتيب حسب:</span>
                        <select id="sort-select" name="sort" class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-primary">
                            <option value="newest" {{ request()->input('sort') == 'newest' ? 'selected' : '' }}>الأحدث</option>
                            <option value="price_asc" {{ request()->input('sort') == 'price_asc' ? 'selected' : '' }}>السعر: من الأقل للأعلى</option>
                            <option value="price_desc" {{ request()->input('sort') == 'price_desc' ? 'selected' : '' }}>السعر: من الأعلى للأقل</option>
                            <option value="popular" {{ request()->input('sort') == 'popular' ? 'selected' : '' }}>الأكثر مبيعاً</option>
                            <option value="rating" {{ request()->input('sort') == 'rating' ? 'selected' : '' }}>التقييم</option>
                        </select>
                    </div>
                    
                    <div class="flex space-x-2 space-x-reverse">
                        <button id="grid-view" class="bg-primary text-white w-9 h-9 flex items-center justify-center rounded-md">
                            <i class="ri-grid-fill"></i>
                        </button>
                        <button id="list-view" class="bg-gray-200 dark:bg-gray-700 w-9 h-9 flex items-center justify-center rounded-md">
                            <i class="ri-list-check"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Products Grid -->
            <div id="products-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($products as $product)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:shadow-lg hover:-translate-y-1">
                    <a href="{{ route('products.show', $product->share_slug ?? $product->slug) }}" class="block relative">
                        <img src="{{ $product->image_url ?? asset('images/placeholder.jpg') }}" alt="{{ $product->name }}" 
                            class="w-full h-48 object-cover">
                        
                        @if($product->is_on_sale)
                        <div class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                            خصم {{ $product->discount_percentage }}%
                        </div>
                        @endif
                        
                        @if($product->status == 'out-of-stock')
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                            <span class="text-white font-bold text-lg">نفذت الكمية</span>
                        </div>
                        @endif
                    </a>
                    
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <a href="{{ route('products.show', $product->share_slug ?? $product->slug) }}" class="text-lg font-bold hover:text-primary transition-colors">
                                {{ $product->name }}
                            </a>
                            <div class="flex items-center">
                                <span class="text-yellow-400 ml-1">{{ number_format($product->reviews_avg_rating ?? 0, 1) }}</span>
                                <i class="ri-star-fill text-yellow-400"></i>
                            </div>
                        </div>
                        
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-3">
                            <i class="ri-price-tag-3-line ml-1"></i>
                            <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-primary">
                                {{ $product->category->name }}
                            </a>
                        </div>
                        
                        <div class="mb-3 min-h-[40px] line-clamp-2">
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                {{ Str::limit(strip_tags($product->description), 100) }}
                            </p>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <div>
                                @if($product->is_on_sale)
                                <span class="text-lg font-bold text-primary">{{ number_format($product->price, 2) }} ريال</span>
                                <span class="text-sm text-gray-500 line-through mr-2">{{ number_format($product->old_price, 2) }} ريال</span>
                                @else
                                <span class="text-lg font-bold text-primary">{{ number_format($product->price, 2) }} ريال</span>
                                @endif
                            </div>
                            
                            <button type="button" 
                                data-product-id="{{ $product->id }}" 
                                data-product-name="{{ $product->name }}" 
                                data-product-price="{{ $product->price }}" 
                                class="add-to-cart-btn bg-primary hover:bg-primary-dark text-white rounded-full w-10 h-10 flex items-center justify-center transition-colors">
                                <i class="ri-shopping-cart-2-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-center">
                    <i class="ri-inbox-2-line text-5xl text-gray-400 mb-4"></i>
                    <h3 class="text-xl font-bold mb-2">لا توجد منتجات!</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        لم يتم العثور على منتجات مطابقة لمعايير البحث. يرجى تغيير الفلتر أو العودة لاحقاً.
                    </p>
                </div>
                @endforelse
            </div>
            
            <!-- List View (Hidden by Default) -->
            <div id="products-list" class="hidden space-y-4">
                @forelse($products as $product)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                    <div class="flex flex-col md:flex-row">
                        <a href="{{ route('products.show', $product->share_slug ?? $product->slug) }}" class="md:w-1/4 relative">
                            <img src="{{ $product->image_url ?? asset('images/placeholder.jpg') }}" alt="{{ $product->name }}" 
                                class="w-full h-full object-cover">
                            
                            @if($product->is_on_sale)
                            <div class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                خصم {{ $product->discount_percentage }}%
                            </div>
                            @endif
                            
                            @if($product->status == 'out-of-stock')
                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                <span class="text-white font-bold text-lg">نفذت الكمية</span>
                            </div>
                            @endif
                        </a>
                        
                        <div class="md:w-3/4 p-4">
                            <div class="flex justify-between items-start mb-2">
                                <a href="{{ route('products.show', $product->share_slug ?? $product->slug) }}" class="text-xl font-bold hover:text-primary transition-colors">
                                    {{ $product->name }}
                                </a>
                                <div class="flex items-center">
                                    <span class="text-yellow-400 ml-1">{{ number_format($product->reviews_avg_rating ?? 0, 1) }}</span>
                                    <i class="ri-star-fill text-yellow-400"></i>
                                </div>
                            </div>
                            
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-3">
                                <i class="ri-price-tag-3-line ml-1"></i>
                                <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-primary">
                                    {{ $product->category->name }}
                                </a>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-gray-600 dark:text-gray-300">
                                    {{ Str::limit(strip_tags($product->description), 200) }}
                                </p>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <div>
                                    @if($product->is_on_sale)
                                    <span class="text-xl font-bold text-primary">{{ number_format($product->price, 2) }} ريال</span>
                                    <span class="text-sm text-gray-500 line-through mr-2">{{ number_format($product->old_price, 2) }} ريال</span>
                                    @else
                                    <span class="text-xl font-bold text-primary">{{ number_format($product->price, 2) }} ريال</span>
                                    @endif
                                </div>
                                
                                <div class="flex space-x-2 space-x-reverse">
                                    <button type="button" 
                                        data-product-id="{{ $product->id }}" 
                                        data-product-name="{{ $product->name }}" 
                                        data-product-price="{{ $product->price }}" 
                                        class="add-to-cart-btn bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-md transition-colors flex items-center">
                                        <i class="ri-shopping-cart-2-line ml-1"></i>
                                        إضافة للسلة
                                    </button>
                                    
                                    <a href="{{ route('products.show', $product->share_slug ?? $product->slug) }}" 
                                        class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 px-4 py-2 rounded-md transition-colors">
                                        عرض التفاصيل
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-center">
                    <i class="ri-inbox-2-line text-5xl text-gray-400 mb-4"></i>
                    <h3 class="text-xl font-bold mb-2">لا توجد منتجات!</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        لم يتم العثور على منتجات مطابقة لمعايير البحث. يرجى تغيير الفلتر أو العودة لاحقاً.
                    </p>
                </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Grid/List View Toggle
        const gridView = document.getElementById('grid-view');
        const listView = document.getElementById('list-view');
        const productsGrid = document.getElementById('products-grid');
        const productsList = document.getElementById('products-list');
        
        gridView.addEventListener('click', function() {
            productsGrid.classList.remove('hidden');
            productsList.classList.add('hidden');
            gridView.classList.add('bg-primary', 'text-white');
            gridView.classList.remove('bg-gray-200', 'dark:bg-gray-700');
            listView.classList.add('bg-gray-200', 'dark:bg-gray-700');
            listView.classList.remove('bg-primary', 'text-white');
        });
        
        listView.addEventListener('click', function() {
            productsGrid.classList.add('hidden');
            productsList.classList.remove('hidden');
            listView.classList.add('bg-primary', 'text-white');
            listView.classList.remove('bg-gray-200', 'dark:bg-gray-700');
            gridView.classList.add('bg-gray-200', 'dark:bg-gray-700');
            gridView.classList.remove('bg-primary', 'text-white');
        });
        
        // Sort Select Change
        const sortSelect = document.getElementById('sort-select');
        sortSelect.addEventListener('change', function() {
            const url = new URL(window.location);
            url.searchParams.set('sort', this.value);
            window.location = url.toString();
        });
        
        // Add to Cart Functionality
        const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
        addToCartButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.productId;
                const productName = this.dataset.productName;
                const productPrice = this.dataset.productPrice;
                
                // AJAX request to add item to cart
                fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: 1
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        alert(`تمت إضافة ${productName} إلى سلة التسوق`);
                    } else {
                        // Show error message
                        alert(data.message || 'حدث خطأ أثناء إضافة المنتج');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('حدث خطأ أثناء إضافة المنتج');
                });
            });
        });
    });
</script>
@endpush 