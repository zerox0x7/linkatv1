@extends('themes.torganic.layouts.app')

@section('title', $product->name . ' - ' . config('app.name'))
@section('description', $product->description ?? $product->name)

@section('content')
<!-- ================> Page header start here <================== -->
<section class="page-header bg--cover" style="background-image:url({{ asset('themes/torganic/assets/images/header/1.png') }})">
    <div class="container">
        <div class="page-header__content" data-aos="fade-right" data-aos-duration="1000">
            <h1>{{ $product->name }}</h1>
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">المنتجات</a></li>
                    @if($product->category)
                    <li class="breadcrumb-item"><a href="{{ route('category.show', $product->category->slug) }}">{{ $product->category->name }}</a></li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($product->name, 30) }}</li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<!-- ================> Page header end here <================== -->

<!-- ===============>>Product Details section start here <<================= -->
<section class="product-details padding-top padding-bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="product-details">
                    <div class="row g-5">
                        <!-- Product Images -->
                        <div class="col-md-6 col-12">
                            <div class="product-thumb">
                                @php
                                    $images = [];
                                    if ($product->image) {
                                        $images[] = Storage::url($product->image);
                                    }
                                    if ($product->images && is_array($product->images)) {
                                        foreach ($product->images as $img) {
                                            $images[] = Storage::url($img);
                                        }
                                    }
                                    if (empty($images)) {
                                        $images[] = asset('themes/torganic/assets/images/product/details/01.png');
                                    }
                                @endphp

                                @if(count($images) > 1)
                                <!-- Multiple images - show slider -->
                                <div class="swiper pro-single-top">
                                    <div class="swiper-wrapper">
                                        @foreach($images as $image)
                                        <div class="swiper-slide">
                                            <div class="single-thumb">
                                                <img src="{{ $image }}" alt="{{ $product->name }}">
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="swiper pro-single-thumbs">
                                    <div class="swiper-wrapper">
                                        @foreach($images as $image)
                                        <div class="swiper-slide">
                                            <div class="single-thumb">
                                                <img src="{{ $image }}" alt="{{ $product->name }}">
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="pro-single-next"><i class="fas fa-angle-left"></i></div>
                                    <div class="pro-single-prev"><i class="fas fa-angle-right"></i></div>
                                </div>
                                @else
                                <!-- Single image -->
                                <div class="single-thumb">
                                    <img src="{{ $images[0] }}" alt="{{ $product->name }}" class="img-fluid rounded">
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="col-md-6 col-12">
                            <div class="post-content">
                                <h2>{{ $product->name }}</h2>
                                
                                <!-- Rating -->
                                <p class="rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa-solid fa-star {{ $i <= ($product->rating ?? 5) ? '' : 'text-muted' }}"></i>
                                    @endfor
                                    ({{ $reviewsCount ?? 0 }} تقييم)
                                </p>

                                <!-- Price -->
                                <div class="post-content__price">
                                    <h2>{{ number_format($product->price, 2) }} ر.س</h2>
                                    @if($product->old_price && $product->old_price > $product->price)
                                    <del>{{ number_format($product->old_price, 2) }} ر.س</del>
                                    <span>({{ $product->discount_percentage }}% خصم)</span>
                                    @endif
                                </div>

                                <!-- Brand/Category -->
                                @if($product->category)
                                <div class="post-content__brand">
                                    القسم: <span><a href="{{ route('category.show', $product->category->slug) }}">{{ $product->category->name }}</a></span>
                                </div>
                                @endif

                                <!-- Product Benefits/Features -->
                                @if($product->description)
                                <ul class="post-content__list">
                                    @php
                                        // Split description by line breaks or use default features
                                        $features = explode("\n", $product->description);
                                        if (count($features) == 1) {
                                            $features = [
                                                $product->description,
                                                'منتج طبيعي 100%',
                                                'خالٍ من المواد الكيميائية',
                                                'جودة عالية ومضمونة'
                                            ];
                                        }
                                    @endphp
                                    @foreach(array_slice($features, 0, 4) as $feature)
                                        @if(trim($feature))
                                        <li>
                                            <img src="{{ asset('themes/torganic/assets/images/invoice/check.svg') }}" alt="Check">
                                            {{ trim($feature) }}
                                        </li>
                                        @endif
                                    @endforeach
                                </ul>
                                @endif

                                <!-- Add to Cart -->
                                @if($product->stock > 0)
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="product_type" value="product">
                                    <div class="post-content__btn btn-group">
                                        <div class="quantity-button">
                                            <button type="button" class="quantity-button__control quantity-button__control--decrease">-</button>
                                            <span class="quantity-button__display">1</span>
                                            <input type="hidden" name="quantity" class="quantity-input" value="1" min="1" max="{{ $product->stock }}">
                                            <button type="button" class="quantity-button__control quantity-button__control--increase">+</button>
                                        </div>
                                        <button type="submit" class="trk-btn trk-btn--primary">أضف للسلة</button>
                                        <button type="button" class="product-details__fav-btn"><i class="fa-regular fa-heart"></i></button>
                                    </div>
                                </form>
                                @else
                                <div class="alert alert-warning">
                                    <i class="fa-solid fa-triangle-exclamation me-2"></i>
                                    عذراً، هذا المنتج غير متوفر حالياً
                                </div>
                                @endif

                                <!-- Social Share -->
                                <div class="post-content__social">
                                    <h4>مشاركة المنتج:</h4>
                                    <ul class="social">
                                        <li class="social__item">
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="social__link">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        </li>
                                        <li class="social__item">
                                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($product->name) }}" target="_blank" class="social__link">
                                                <i class="fa-brands fa-x-twitter"></i>
                                            </a>
                                        </li>
                                        <li class="social__item">
                                            <a href="https://wa.me/?text={{ urlencode($product->name . ' - ' . url()->current()) }}" target="_blank" class="social__link">
                                                <i class="fab fa-whatsapp"></i>
                                            </a>
                                        </li>
                                        <li class="social__item">
                                            <a href="#" onclick="navigator.clipboard.writeText('{{ url()->current() }}'); alert('تم نسخ الرابط!'); return false;" class="social__link">
                                                <i class="fa-solid fa-link"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Tabs -->
        <div class="row">
            <div class="col-12">
                <div class="product-details__pill">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-description-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-description" type="button" role="tab" aria-controls="pills-description"
                                aria-selected="true">الوصف</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-info-tab" data-bs-toggle="pill" data-bs-target="#pills-info"
                                type="button" role="tab" aria-controls="pills-info" aria-selected="false">معلومات إضافية</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-review-tab" data-bs-toggle="pill" data-bs-target="#pills-review"
                                type="button" role="tab" aria-controls="pills-review" aria-selected="false">التقييمات ({{ $reviewsCount ?? 0 }})</button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="pills-tabContent">
                        <!-- Description Tab -->
                        <div class="tab-pane fade show active" id="pills-description" role="tabpanel"
                            aria-labelledby="pills-description-tab" tabindex="0">
                            <div class="product-details__content">
                                <h3>وصف المنتج</h3>
                                <p>{!! nl2br(e($product->description ?? 'منتج عضوي طبيعي وصحي، خالٍ من المواد الكيميائية والمبيدات الحشرية. نحرص على توفير أفضل جودة لعملائنا الكرام.')) !!}</p>
                                
                                @if($product->long_description)
                                <h3>تفاصيل المنتج</h3>
                                <p>{!! nl2br(e($product->long_description)) !!}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Additional Info Tab -->
                        <div class="tab-pane fade" id="pills-info" role="tabpanel" aria-labelledby="pills-info-tab" tabindex="0">
                            <div class="product-details__content">
                                <h3>المعلومات الإضافية</h3>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td><strong>رقم المنتج</strong></td>
                                            <td>#{{ $product->id }}</td>
                                        </tr>
                                        @if($product->sku)
                                        <tr>
                                            <td><strong>رمز المنتج (SKU)</strong></td>
                                            <td>{{ $product->sku }}</td>
                                        </tr>
                                        @endif
                                        @if($product->category)
                                        <tr>
                                            <td><strong>القسم</strong></td>
                                            <td><a href="{{ route('category.show', $product->category->slug) }}">{{ $product->category->name }}</a></td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td><strong>الحالة</strong></td>
                                            <td>
                                                @if($product->stock > 0)
                                                <span class="badge bg-success">متوفر</span>
                                                @else
                                                <span class="badge bg-danger">غير متوفر</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @if($product->weight)
                                        <tr>
                                            <td><strong>الوزن</strong></td>
                                            <td>{{ $product->weight }}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                                
                                <h3>سياسة الإرجاع</h3>
                                <p>نحن نوفر سياسة إرجاع مرنة خلال 7 أيام من تاريخ الاستلام. يرجى التأكد من أن المنتج في حالته الأصلية مع العبوة الأصلية.</p>
                                
                                <h3>الشحن والتوصيل</h3>
                                <p>نوفر خدمة التوصيل السريع لجميع المناطق. يتم شحن الطلبات خلال 1-3 أيام عمل.</p>
                            </div>
                        </div>

                        <!-- Reviews Tab -->
                        <div class="tab-pane fade" id="pills-review" role="tabpanel" aria-labelledby="pills-review-tab" tabindex="0">
                            <!-- Reviews List -->
                            @if($product->reviews && $product->reviews->count() > 0)
                            <div class="product-details__review section-bg">
                                <div class="product-details__review-title">
                                    <h2>التقييمات</h2>
                                </div>
                                
                                @foreach($product->reviews as $review)
                                <div class="product-details__review-card">
                                    <div class="product-details__review-author">
                                        <div class="product-details__review-thumb">
                                            @if($review->user && $review->user->avatar)
                                                <img src="{{ Storage::url($review->user->avatar) }}" alt="{{ $review->user->name }}">
                                            @else
                                                <img src="{{ asset('default-avatar.png') }}" alt="User">
                                            @endif
                                        </div>
                                        <div class="product-details__review-name">
                                            <h4>{{ $review->user ? $review->user->name : 'عميل' }}</h4>
                                            <p>{{ $review->created_at->format('F d, Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="product-details__review-content">
                                        <div class="rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="fa-solid fa-star"></i>
                                                @else
                                                    <span><i class="fa-solid fa-star"></i></span>
                                                @endif
                                            @endfor
                                        </div>
                                        <p>{{ $review->review }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="product-details__review section-bg">
                                <div class="product-details__review-title">
                                    <h2>التقييمات</h2>
                                </div>
                                <p class="text-muted text-center py-5">لا توجد تقييمات بعد. كن أول من يقيم هذا المنتج!</p>
                            </div>
                            @endif

                            <!-- Add Review Form -->
                            @auth
                            <div class="product-details__review product-details__review--add section-bg mt-4">
                                <div class="product-details__review-title">
                                    <h2>أضف تقييمك</h2>
                                </div>

                                <div class="product-details__review-form">
                                    <form action="{{ route('reviews.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="product_type" value="App\Models\Product">
                                        
                                        <div class="rating mb-3">
                                            <h4>تقييمك</h4>
                                            <div class="star-rating">
                                                <input type="hidden" name="rating" id="rating-input" value="5" required>
                                                <i class="fa-solid fa-star" data-rating="1"></i>
                                                <i class="fa-solid fa-star" data-rating="2"></i>
                                                <i class="fa-solid fa-star" data-rating="3"></i>
                                                <i class="fa-solid fa-star" data-rating="4"></i>
                                                <i class="fa-solid fa-star" data-rating="5"></i>
                                            </div>
                                        </div>
                                        
                                        <div class="row g-4">
                                            <div class="col-md-12">
                                                <div>
                                                    <label for="review" class="form-label">تعليقك</label>
                                                    <textarea cols="30" rows="5" class="form-control" id="review" name="review"
                                                        placeholder="اكتب تعليقك هنا..." required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="trk-btn trk-btn--border trk-btn--primary mt-4">
                                            إرسال التقييم
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @else
                            <div class="alert alert-info mt-4">
                                <i class="fa-solid fa-info-circle me-2"></i>
                                يجب <a href="{{ route('login') }}">تسجيل الدخول</a> لإضافة تقييم
                            </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ===============>>Product Details section end here <<================= -->

<!-- ===============>>Related Products section start here <<================= -->
@if(isset($relatedProducts) && $relatedProducts->isNotEmpty())
<section class="product-feature padding-bottom">
    <div class="container">
        <div class="section-header">
            <div class="section-header__content">
                <h2 class="mb-10">منتجات ذات صلة</h2>
            </div>
            <div class="section-header__action">
                <div class="swiper-nav swiper-nav--style1">
                    <button class="swiper-nav__btn related-product__slider-prev"><i class="fa-solid fa-arrow-left-long"></i></button>
                    <button class="swiper-nav__btn related-product__slider-next active"><i class="fa-solid fa-arrow-right-long"></i></button>
                </div>
            </div>
        </div>
        <div class="product__wrapper">
            <div class="related-product__slider swiper">
                <div class="swiper-wrapper mb-1">
                    @foreach($relatedProducts as $relatedProduct)
                    <div class="swiper-slide">
                        <div class="product__item product__item--style2">
                            <div class="product__item-inner">
                                @if($relatedProduct->discount_percentage > 0)
                                <div class="product__item-badge">-{{ $relatedProduct->discount_percentage }}%</div>
                                @endif
                                <div class="product__item-thumb">
                                    <a href="{{ route('products.show', $relatedProduct->slug ?? $relatedProduct->share_slug ?? $relatedProduct->id) }}">
                                        @if($relatedProduct->image)
                                            <img src="{{ Storage::url($relatedProduct->image) }}" alt="{{ $relatedProduct->name }}">
                                        @else
                                            <img src="{{ asset('themes/torganic/assets/images/product/popular/' . (($loop->index % 10) + 1) . '.png') }}" alt="{{ $relatedProduct->name }}">
                                        @endif
                                    </a>
                                </div>
                                <div class="product__item-content">
                                    <h5><a href="{{ route('products.show', $relatedProduct->slug ?? $relatedProduct->share_slug ?? $relatedProduct->id) }}">{{ $relatedProduct->name }}</a></h5>
                                    <div class="product__item-rating">
                                        <i class="fa-solid fa-star"></i> {{ $relatedProduct->rating ?? 4.5 }} <span>({{ $relatedProduct->reviews_count ?? 0 }})</span>
                                    </div>
                                    <div class="product__item-footer">
                                        <div class="product__item-price">
                                            <h4>{{ number_format($relatedProduct->price, 2) }} ر.س</h4>
                                            @if($relatedProduct->old_price && $relatedProduct->old_price > $relatedProduct->price)
                                            <span><del>{{ number_format($relatedProduct->old_price, 2) }} ر.س</del></span>
                                            @endif
                                        </div>
                                        <div class="product__item-action">
                                            <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $relatedProduct->id }}">
                                                <input type="hidden" name="product_type" value="product">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="trk-btn trk-btn--outline">أضف للسلة</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- ===============>>Related Products section end here <<================= -->

<!-- ===============>> Feature bar section start here <<================= -->
<div class="feature-bar border-top">
    <div class="container">
        <div class="row py-3 g-5 g-lg-4 justify-content-center">
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-3 mb-md-0">
                <div class="feature-bar__item d-flex align-items-center">
                    <img src="{{ asset('themes/torganic/assets/images/feature/bar/1.png') }}" alt="توصيل سريع">
                    <div class="feature-bar__text ms-4">
                        <h3 class="feature-bar__title fs-6 fw-bold mb-0">توصيل سريع</h3>
                        <p class="feature-bar__description fs-7 mb-0">لطلبات أكثر من 40 ريال</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-3 mb-md-0">
                <div class="feature-bar__item d-flex align-items-center">
                    <img src="{{ asset('themes/torganic/assets/images/feature/bar/2.png') }}" alt="دعم 24/7">
                    <div class="feature-bar__text ms-4">
                        <h3 class="feature-bar__title fs-6 fw-bold mb-0">دعم 24/7</h3>
                        <p class="feature-bar__description fs-7 mb-0">تواصل معنا في أي وقت</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-3 mb-md-0">
                <div class="feature-bar__item d-flex align-items-center">
                    <img src="{{ asset('themes/torganic/assets/images/feature/bar/3.png') }}" alt="دفع آمن">
                    <div class="feature-bar__text ms-4">
                        <h3 class="feature-bar__title fs-6 fw-bold mb-0">دفع آمن</h3>
                        <p class="feature-bar__description fs-7 mb-0">100% دفع آمن ومضمون</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-3 mb-md-0">
                <div class="feature-bar__item d-flex align-items-center">
                    <img src="{{ asset('themes/torganic/assets/images/feature/bar/4.png') }}" alt="استرجاع سهل">
                    <div class="feature-bar__text ms-4">
                        <h3 class="feature-bar__title fs-6 fw-bold mb-0">استرجاع سهل</h3>
                        <p class="feature-bar__description fs-7 mb-0">خلال 30 يوم</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ===============>> Feature bar section end here <<================= -->
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quantity Button Functionality
    const quantityDisplay = document.querySelector('.quantity-button__display');
    const quantityInput = document.querySelector('.quantity-input');
    const decreaseBtn = document.querySelector('.quantity-button__control--decrease');
    const increaseBtn = document.querySelector('.quantity-button__control--increase');
    
    if (quantityDisplay && quantityInput && decreaseBtn && increaseBtn) {
        decreaseBtn.addEventListener('click', function() {
            let value = parseInt(quantityInput.value);
            if (value > 1) {
                value--;
                quantityInput.value = value;
                quantityDisplay.textContent = value;
            }
        });
        
        increaseBtn.addEventListener('click', function() {
            let value = parseInt(quantityInput.value);
            let max = parseInt(quantityInput.max);
            if (value < max) {
                value++;
                quantityInput.value = value;
                quantityDisplay.textContent = value;
            }
        });
    }

    // Star Rating Functionality
    const stars = document.querySelectorAll('.star-rating i');
    const ratingInput = document.getElementById('rating-input');
    
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-rating');
            ratingInput.value = rating;
            
            // Update star appearance
            stars.forEach(s => {
                const starRating = s.getAttribute('data-rating');
                if (starRating <= rating) {
                    s.classList.remove('fa-regular');
                    s.classList.add('fa-solid');
                    s.style.color = '#ffc107';
                } else {
                    s.classList.remove('fa-solid');
                    s.classList.add('fa-regular');
                    s.style.color = '#ddd';
                }
            });
        });
        
        // Hover effect
        star.addEventListener('mouseenter', function() {
            const rating = this.getAttribute('data-rating');
            stars.forEach(s => {
                const starRating = s.getAttribute('data-rating');
                if (starRating <= rating) {
                    s.style.color = '#ffc107';
                }
            });
        });
    });
    
    document.querySelector('.star-rating').addEventListener('mouseleave', function() {
        const currentRating = ratingInput.value;
        stars.forEach(s => {
            const starRating = s.getAttribute('data-rating');
            if (starRating <= currentRating) {
                s.style.color = '#ffc107';
            } else {
                s.style.color = '#ddd';
            }
        });
    });

    // Initialize Product Image Slider (if multiple images)
    const proSingleTop = document.querySelector('.pro-single-top');
    if (proSingleTop) {
        const productSliderTop = new Swiper('.pro-single-top', {
            spaceBetween: 10,
            loop: true,
            thumbs: {
                swiper: productSliderThumbs
            }
        });

        const productSliderThumbs = new Swiper('.pro-single-thumbs', {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
            navigation: {
                nextEl: '.pro-single-next',
                prevEl: '.pro-single-prev',
            },
        });
    }

    // Initialize Related Products Slider
    const relatedProductSlider = new Swiper('.related-product__slider', {
        slidesPerView: 2,
        spaceBetween: 20,
        loop: true,
        navigation: {
            nextEl: '.related-product__slider-next',
            prevEl: '.related-product__slider-prev',
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
            1280: {
                slidesPerView: 5,
            },
        },
    });
});
</script>
@endpush

@push('styles')
<style>
.star-rating i {
    cursor: pointer;
    font-size: 1.5rem;
    color: #ffc107;
    transition: color 0.2s;
}

.star-rating i.fa-regular {
    color: #ddd;
}

.star-rating i:hover {
    transform: scale(1.1);
}

/* Related Products Section - Image Size Adjustment */
.related-product__slider .product__item--style2 .product__item-thumb {
    height: 200px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
}

.related-product__slider .product__item--style2 .product__item-thumb img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center;
    max-width: 180px;
    max-height: 180px;
}

.related-product__slider .product__item--style2 .product__item-content {
    padding: 1rem;
    min-height: 120px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.related-product__slider .product__item--style2 .product__item-content h5 {
    font-size: 0.9rem;
    line-height: 1.3;
    margin-bottom: 0.5rem;
    height: 2.6rem;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.related-product__slider .product__item--style2 .product__item-rating {
    font-size: 0.8rem;
    margin-bottom: 0.5rem;
}

.related-product__slider .product__item--style2 .product__item-footer {
    margin-top: auto;
}

.related-product__slider .product__item--style2 .product__item-price h4 {
    font-size: 1rem;
    margin-bottom: 0.25rem;
}

.related-product__slider .product__item--style2 .product__item-action .trk-btn {
    font-size: 0.8rem;
    padding: 0.4rem 0.8rem;
}
</style>
@endpush
