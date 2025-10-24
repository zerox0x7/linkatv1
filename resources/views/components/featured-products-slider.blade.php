@props(['products'])

<div {{ $attributes->merge(['class' => 'featured-products-slider bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8']) }}>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">{{ __('المنتجات المميزة') }}</h2>
        <a href="{{ route('products.featured') }}" class="text-primary hover:text-primary-dark transition-colors flex items-center">
            {{ __('عرض الكل') }}
            <i class="ri-arrow-left-line mr-1"></i>
        </a>
    </div>

    @if($products->count() > 0)
        <div class="swiper featuredSwiper">
            <div class="swiper-wrapper">
                @foreach($products as $product)
                <div class="swiper-slide">
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden transition-transform duration-300 hover:shadow-lg">
                        <a href="{{ route('products.show', $product->share_slug ?? $product->slug) }}" class="block relative">
                            <img src="{{ $product->image_url ?? asset('images/placeholder.jpg') }}" alt="{{ $product->name }}" 
                                class="w-full h-48 object-cover">
                            
                            @if($product->is_on_sale)
                            <div class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                خصم {{ $product->discount_percentage }}%
                            </div>
                            @endif
                            
                            @if($product->stock == 0 || $product->status == 'out-of-stock')
                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                <span class="text-white font-bold text-lg">نفذت الكمية</span>
                            </div>
                            @endif
                        </a>
                        
                        <div class="p-4">
                            <div class="flex justify-between items-start mb-2">
                                <a href="{{ route('products.show', $product->share_slug ?? $product->slug) }}" class="text-lg font-bold hover:text-primary transition-colors line-clamp-1">
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
                                <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-2">
                                    {{ Str::limit(strip_tags($product->description), 80) }}
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
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination mt-4"></div>
            <div class="swiper-button-next !text-primary after:content-['']">
                <i class="ri-arrow-right-s-line text-2xl"></i>
            </div>
            <div class="swiper-button-prev !text-primary after:content-['']">
                <i class="ri-arrow-left-s-line text-2xl"></i>
            </div>
        </div>
    @else
        <div class="text-center p-8 bg-gray-50 dark:bg-gray-700 rounded-lg">
            <i class="ri-shopping-bag-line text-4xl text-gray-400 mb-2"></i>
            <p class="text-gray-500 dark:text-gray-400">{{ __('لا توجد منتجات مميزة حالياً') }}</p>
        </div>
    @endif
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<style>
    .swiper-pagination-bullet-active {
        background-color: #2196F3 !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Swiper(".featuredSwiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3,
                },
                1024: {
                    slidesPerView: 4,
                },
            },
        });
        
        // Add to Cart Functionality for slider items
        document.querySelectorAll('.featured-products-slider .add-to-cart-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const productId = this.dataset.productId;
                const productName = this.dataset.productName;
                
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