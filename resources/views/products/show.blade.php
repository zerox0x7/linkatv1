@extends('layouts.app')

@section('title', $product->meta_title ?? $product->name)

@section('meta')
<meta name="description" content="{{ $product->meta_description ?? Str::limit(strip_tags($product->description), 160) }}">
@if(!empty($product->meta_keywords))
<meta name="keywords" content="{{ $product->meta_keywords }}">
@endif
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 space-x-reverse">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary">
                    <i class="ri-home-4-line ml-1"></i>
                    الرئيسية
                </a>
            </li>
            <li class="flex items-center">
                <i class="ri-arrow-left-s-line text-gray-500"></i>
                <a href="{{ route('products.index') }}" class="mr-1 text-gray-500 hover:text-primary">
                    المنتجات
                </a>
            </li>
            @if($product->category)
            <li class="flex items-center">
                <i class="ri-arrow-left-s-line text-gray-500"></i>
                <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="mr-1 text-gray-500 hover:text-primary">
                    {{ $product->category->name }}
                </a>
            </li>
            @endif
            <li class="flex items-center">
                <i class="ri-arrow-left-s-line text-gray-500"></i>
                <span class="mr-1 text-gray-400">
                    {{ $product->name }}
                </span>
            </li>
        </ol>
    </nav>

    <!-- Product Details -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Image Gallery -->
            <div class="w-full lg:w-2/5">
                <div class="swiper productGallerySwiper mb-4">
                    <div class="swiper-wrapper">
                        <!-- Main Image -->
                        <div class="swiper-slide">
                            <div class="relative h-[300px] sm:h-[400px] rounded-lg overflow-hidden">
                                <img src="{{ $product->image_url ?? asset('images/placeholder.jpg') }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            </div>
                        </div>
                        
                        <!-- Additional Gallery Images -->
                        @if(!empty($product->gallery) && is_array($product->gallery))
                            @foreach($product->gallery as $galleryImage)
                            <div class="swiper-slide">
                                <div class="relative h-[300px] sm:h-[400px] rounded-lg overflow-hidden">
                                    <img src="{{ $galleryImage }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                    
                    <div class="swiper-button-next !text-white !bg-gray-800/60 !w-10 !h-10 !rounded-full after:content-['']">
                        <i class="ri-arrow-right-s-line"></i>
                    </div>
                    <div class="swiper-button-prev !text-white !bg-gray-800/60 !w-10 !h-10 !rounded-full after:content-['']">
                        <i class="ri-arrow-left-s-line"></i>
                    </div>
                </div>
                
                <div class="swiper productGalleryThumbs">
                    <div class="swiper-wrapper">
                        <!-- Main Image Thumb -->
                        <div class="swiper-slide">
                            <div class="h-20 rounded-lg overflow-hidden cursor-pointer">
                                <img src="{{ $product->image_url ?? asset('images/placeholder.jpg') }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            </div>
                        </div>
                        
                        <!-- Additional Gallery Thumbs -->
                        @if(!empty($product->gallery) && is_array($product->gallery))
                            @foreach($product->gallery as $galleryImage)
                            <div class="swiper-slide">
                                <div class="h-20 rounded-lg overflow-hidden cursor-pointer">
                                    <img src="{{ $galleryImage }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Product Info -->
            <div class="w-full lg:w-3/5">
                <div class="mb-6">
                    <h1 class="text-2xl sm:text-3xl font-bold mb-2">{{ $product->name }}</h1>
                    
                    <div class="flex flex-wrap items-center gap-4 mb-4">
                        @if($product->category)
                        <span class="text-gray-600 dark:text-gray-400 flex items-center">
                            <i class="ri-price-tag-3-line ml-1"></i>
                            <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-primary">
                                {{ $product->category->name }}
                            </a>
                        </span>
                        @endif
                        
                        <div class="flex items-center">
                            <div class="flex items-center text-yellow-400 ml-1">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= round($averageRating))
                                        <i class="ri-star-fill"></i>
                                    @else
                                        <i class="ri-star-line"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-gray-600 dark:text-gray-400">
                                ({{ number_format($averageRating, 1) }}) {{ $reviewsCount }} تقييمات
                            </span>
                        </div>
                        
                        @if($product->sales_count > 0)
                        <span class="text-gray-600 dark:text-gray-400 flex items-center">
                            <i class="ri-shopping-bag-line ml-1"></i>
                            {{ $product->sales_count }} مبيعات
                        </span>
                        @endif
                    </div>
                    
                    <div class="flex items-center mb-6">
                        @if($product->is_on_sale)
                            <span class="text-2xl font-bold text-primary">{{ number_format($product->price, 2) }} ريال</span>
                            <span class="text-xl text-gray-500 line-through mr-4">{{ number_format($product->old_price, 2) }} ريال</span>
                            <span class="bg-red-500 text-white text-sm font-bold px-2 py-1 rounded mr-4">
                                خصم {{ $product->discount_percentage }}%
                            </span>
                        @else
                            <span class="text-2xl font-bold text-primary">{{ number_format($product->price, 2) }} ريال</span>
                        @endif
                    </div>
                    
                    <div class="prose prose-lg dark:prose-invert mb-6 max-w-none">
                        {!! $product->description !!}
                    </div>
                    
                    @if(!empty($product->features) && is_array($product->features))
                    <div class="mb-6">
                        <h3 class="text-lg font-bold mb-3">المميزات:</h3>
                        <ul class="space-y-2">
                            @foreach($product->features as $feature)
                            <li class="flex items-center">
                                <i class="ri-check-line text-green-500 ml-2"></i>
                                <span>{{ $feature }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                    @if(!empty($product->custom_fields) && is_array($product->custom_fields))
                    <div class="mb-6">
                        <h3 class="text-lg font-bold mb-3">مواصفات المنتج:</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($product->custom_fields as $key => $value)
                            <div class="flex">
                                <span class="font-medium ml-2">{{ $key }}:</span>
                                <span>{{ $value }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <!-- Add to Cart -->
                    <div class="mb-6">
                        @if($product->status === 'active' && $product->stock > 0)
                        <form action="{{ route('cart.add') }}" method="POST" class="flex flex-col sm:flex-row gap-4">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            
                            <div class="w-full sm:w-1/3">
                                <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الكمية</label>
                                <div class="flex border border-gray-300 dark:border-gray-600 rounded-md">
                                    <button type="button" class="decrement-quantity px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded-r-md">
                                        <i class="ri-subtract-line"></i>
                                    </button>
                                    <input type="number" name="quantity" id="quantity" min="1" max="{{ $product->stock }}" value="1" 
                                        class="flex-grow text-center border-0 focus:ring-0 dark:bg-gray-800">
                                    <button type="button" class="increment-quantity px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded-l-md">
                                        <i class="ri-add-line"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="w-full sm:w-2/3">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">التوفر</label>
                                <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white py-2 px-4 rounded-md font-medium flex items-center justify-center">
                                    <i class="ri-shopping-cart-2-line ml-2"></i>
                                    إضافة إلى السلة
                                </button>
                            </div>
                        </form>
                        @elseif($product->status === 'out-of-stock' || $product->stock === 0)
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-md">
                            <p class="text-gray-700 dark:text-gray-300 flex items-center">
                                <i class="ri-information-line text-yellow-500 ml-2"></i>
                                هذا المنتج غير متوفر حالياً. يرجى التحقق مرة أخرى لاحقاً.
                            </p>
                        </div>
                        @else
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-md">
                            <p class="text-gray-700 dark:text-gray-300 flex items-center">
                                <i class="ri-information-line text-yellow-500 ml-2"></i>
                                هذا المنتج غير متاح للشراء حالياً.
                            </p>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Social Share -->
                    <div class="border-t dark:border-gray-600 pt-4">
                        <div class="flex items-center">
                            <span class="text-gray-700 dark:text-gray-300 ml-4">مشاركة:</span>
                            <div class="flex space-x-3 space-x-reverse">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($product->share_url) }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                    <i class="ri-facebook-fill text-xl"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode($product->share_url) }}&text={{ urlencode($product->name) }}" target="_blank" class="text-sky-500 hover:text-sky-700">
                                    <i class="ri-twitter-fill text-xl"></i>
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($product->name . ' - ' . $product->share_url) }}" target="_blank" class="text-green-600 hover:text-green-800">
                                    <i class="ri-whatsapp-fill text-xl"></i>
                                </a>
                                <a href="https://t.me/share/url?url={{ urlencode($product->share_url) }}&text={{ urlencode($product->name) }}" target="_blank" class="text-blue-500 hover:text-blue-700">
                                    <i class="ri-telegram-fill text-xl"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Product Tabs: Description, Details, Reviews -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8">
        <div x-data="{ activeTab: 'details' }">
            <!-- Tabs Navigation -->
            <div class="border-b dark:border-gray-700 mb-6">
                <div class="flex space-x-8 space-x-reverse -mb-px">
                    <button @click="activeTab = 'details'" :class="{'border-b-2 border-primary text-primary': activeTab === 'details'}" class="py-4 px-1 font-medium focus:outline-none transition-colors">
                        التفاصيل
                    </button>
                    <button @click="activeTab = 'reviews'" :class="{'border-b-2 border-primary text-primary': activeTab === 'reviews'}" class="py-4 px-1 font-medium focus:outline-none transition-colors">
                        التقييمات ({{ $reviewsCount }})
                    </button>
                </div>
            </div>
            
            <!-- Tabs Content -->
            <div>
                <!-- Details Tab -->
                <div x-show="activeTab === 'details'">
                    <div class="prose prose-lg dark:prose-invert max-w-none">
                        {!! $product->details ?? 'لا توجد تفاصيل إضافية لهذا المنتج.' !!}
                    </div>
                </div>
                
                <!-- Reviews Tab -->
                <div x-show="activeTab === 'reviews'">
                    <!-- Review Summary -->
                    <div class="flex flex-col md:flex-row justify-between mb-8">
                        <div class="mb-6 md:mb-0">
                            <h3 class="text-xl font-bold mb-2">تقييم العملاء</h3>
                            <div class="flex items-center">
                                <div class="text-4xl font-bold text-yellow-500 ml-3">{{ number_format($averageRating, 1) }}</div>
                                <div>
                                    <div class="flex text-yellow-400 mb-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= round($averageRating))
                                                <i class="ri-star-fill"></i>
                                            @else
                                                <i class="ri-star-line"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <div class="text-gray-600 dark:text-gray-400">{{ $reviewsCount }} تقييمات</div>
                                </div>
                            </div>
                        </div>
                        
                        @auth
                            @if(auth()->user()->hasPurchased($product))
                            <div>
                                <button id="review-toggle-btn" class="bg-primary hover:bg-primary-dark text-white py-2 px-4 rounded-md font-medium">
                                    أضف تقييمك
                                </button>
                            </div>
                            @endif
                        @endauth
                    </div>
                    
                    <!-- Review Form (Toggle) -->
                    @auth
                        @if(auth()->user()->hasPurchased($product))
                        <div id="review-form-container" class="hidden bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-8">
                            <h3 class="text-lg font-bold mb-4">أضف تقييمك</h3>
                            <form action="{{ route('product.rate') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="product_type" value="product">
                                
                                <div class="mb-4">
                                    <label class="block text-gray-700 dark:text-gray-300 mb-2">التقييم</label>
                                    <div class="rating-stars flex">
                                        @for($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="hidden">
                                        <label for="star{{ $i }}" class="cursor-pointer ml-1">
                                            <i class="ri-star-line text-2xl text-yellow-400 hover:text-yellow-500 star-icon"></i>
                                        </label>
                                        @endfor
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="review" class="block text-gray-700 dark:text-gray-300 mb-2">التعليق</label>
                                    <textarea name="review" id="review" rows="4" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 shadow-sm focus:border-primary focus:ring focus:ring-primary"></textarea>
                                </div>
                                
                                <button type="submit" class="bg-primary hover:bg-primary-dark text-white py-2 px-4 rounded-md font-medium">
                                    إرسال التقييم
                                </button>
                            </form>
                        </div>
                        @endif
                    @endauth
                    
                    <!-- Reviews List -->
                    <div class="space-y-6">
                        @if($product->reviews->count() > 0)
                            @foreach($product->reviews as $review)
                            <div class="border-b dark:border-gray-700 pb-6 last:border-0">
                                <div class="flex justify-between mb-2">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-primary to-secondary flex items-center justify-center text-white font-bold">
                                            {{ substr($review->user->name ?? 'مستخدم', 0, 1) }}
                                        </div>
                                        <div class="mr-3">
                                            <h4 class="font-medium">{{ $review->user->name ?? 'مستخدم' }}</h4>
                                            <div class="text-gray-600 dark:text-gray-400 text-sm">{{ $review->created_at->format('d M Y') }}</div>
                                        </div>
                                    </div>
                                    <div class="flex text-yellow-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="ri-star-fill"></i>
                                            @else
                                                <i class="ri-star-line"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <div class="mt-2">
                                    @if(!empty($review->comment))
                                        <p class="text-gray-700 dark:text-gray-300">{{ $review->comment }}</p>
                                    @else
                                        <p class="text-gray-500 dark:text-gray-400 italic">لم يتم إضافة تعليق مع هذا التقييم.</p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="text-center p-8">
                                <i class="ri-star-smile-line text-4xl text-gray-400 mb-2"></i>
                                <p class="text-gray-500 dark:text-gray-400">لا توجد تقييمات لهذا المنتج بعد. كن أول من يقيّم!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <h2 class="text-2xl font-bold mb-6">منتجات مشابهة</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($relatedProducts as $relatedProduct)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:shadow-lg hover:-translate-y-1">
            <a href="{{ route('products.show', $relatedProduct->share_slug ?? $relatedProduct->slug) }}" class="block relative">
                <img src="{{ $relatedProduct->image_url ?? asset('images/placeholder.jpg') }}" alt="{{ $relatedProduct->name }}" 
                    class="w-full h-48 object-cover">
                
                @if($relatedProduct->is_on_sale)
                <div class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                    خصم {{ $relatedProduct->discount_percentage }}%
                </div>
                @endif
                
                @if($relatedProduct->status == 'out-of-stock')
                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                    <span class="text-white font-bold text-lg">نفذت الكمية</span>
                </div>
                @endif
            </a>
            
            <div class="p-4">
                <div class="flex justify-between items-start mb-2">
                    <a href="{{ route('products.show', $relatedProduct->share_slug ?? $relatedProduct->slug) }}" class="text-lg font-bold hover:text-primary transition-colors">
                        {{ $relatedProduct->name }}
                    </a>
                    <div class="flex items-center">
                        <span class="text-yellow-400 ml-1">{{ number_format($relatedProduct->reviews_avg_rating ?? 0, 1) }}</span>
                        <i class="ri-star-fill text-yellow-400"></i>
                    </div>
                </div>
                
                <div class="mb-4">
                    @if($relatedProduct->is_on_sale)
                    <span class="text-lg font-bold text-primary">{{ number_format($relatedProduct->price, 2) }} ريال</span>
                    <span class="text-sm text-gray-500 line-through mr-2">{{ number_format($relatedProduct->old_price, 2) }} ريال</span>
                    @else
                    <span class="text-lg font-bold text-primary">{{ number_format($relatedProduct->price, 2) }} ريال</span>
                    @endif
                </div>
                
                <div class="flex space-x-2 space-x-reverse">
                    <button type="button" 
                        data-product-id="{{ $relatedProduct->id }}" 
                        data-product-name="{{ $relatedProduct->name }}" 
                        data-product-price="{{ $relatedProduct->price }}" 
                        class="add-to-cart-btn bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-md transition-colors flex-grow">
                        <i class="ri-shopping-cart-2-line ml-1"></i>
                        إضافة للسلة
                    </button>
                    
                    <a href="{{ route('products.show', $relatedProduct->share_slug ?? $relatedProduct->slug) }}" 
                        class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 p-2 rounded-md transition-colors">
                        <i class="ri-eye-line"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Product Gallery Thumbs
        const productThumbs = new Swiper('.productGalleryThumbs', {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
        });
        
        // Product Gallery
        const productGallery = new Swiper('.productGallerySwiper', {
            spaceBetween: 10,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            thumbs: {
                swiper: productThumbs,
            },
        });
        
        // Quantity Incrementer/Decrementer
        const quantityInput = document.getElementById('quantity');
        const decrementBtn = document.querySelector('.decrement-quantity');
        const incrementBtn = document.querySelector('.increment-quantity');
        
        if (decrementBtn && incrementBtn && quantityInput) {
            decrementBtn.addEventListener('click', function() {
                const currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });
            
            incrementBtn.addEventListener('click', function() {
                const currentValue = parseInt(quantityInput.value);
                const maxValue = parseInt(quantityInput.getAttribute('max'));
                if (currentValue < maxValue) {
                    quantityInput.value = currentValue + 1;
                }
            });
        }
        
        // Review Form Toggle
        const reviewToggleBtn = document.getElementById('review-toggle-btn');
        const reviewFormContainer = document.getElementById('review-form-container');
        
        if (reviewToggleBtn && reviewFormContainer) {
            reviewToggleBtn.addEventListener('click', function() {
                reviewFormContainer.classList.toggle('hidden');
            });
        }
        
        // Rating Stars
        const ratingStars = document.querySelectorAll('.rating-stars input');
        const starIcons = document.querySelectorAll('.star-icon');
        
        ratingStars.forEach((star, index) => {
            star.addEventListener('change', function() {
                const rating = this.value;
                
                starIcons.forEach((icon, i) => {
                    // Stars are in reverse order (5 to 1)
                    const starValue = 5 - i;
                    
                    if (starValue <= rating) {
                        icon.classList.remove('ri-star-line');
                        icon.classList.add('ri-star-fill');
                    } else {
                        icon.classList.remove('ri-star-fill');
                        icon.classList.add('ri-star-line');
                    }
                });
            });
        });
        
        // Add to Cart for Related Products
        document.querySelectorAll('.add-to-cart-btn').forEach(button => {
            button.addEventListener('click', function() {
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