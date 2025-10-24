@extends('themes.torganic.layouts.app')

@section('title', isset($homePage) ? $homePage->store_name : config('app.name'))
@section('description', isset($homePage) ? $homePage->description : '')

@section('content')
<div dir="rtl" lang="ar">

<style>
    /* Global RTL Styling for Home Page */
    [dir="rtl"] .section-header {
        text-align: right;
    }
    
    [dir="rtl"] .section-header__content {
        text-align: right;
    }
    
    [dir="rtl"] .section-header h2 {
        text-align: right;
    }
    
    [dir="rtl"] .sale-banner__item-content {
        text-align: right;
    }
    
    [dir="rtl"] .blog__content {
        text-align: right;
    }
    
    [dir="rtl"] .blog__admin {
        flex-direction: row-reverse;
    }
    
    /* Better spacing for RTL */
    [dir="rtl"] .me-30 {
        margin-inline-end: 30px !important;
    }
    
    /* Swiper RTL fixes */
    [dir="rtl"] .swiper-button-next {
        left: 10px;
        right: auto;
    }
    
    [dir="rtl"] .swiper-button-prev {
        right: 10px;
        left: auto;
    }
</style>

@php
    // Dump theme data passed from controller
    // Map hero slides by their order key for proper positioning
    $heroSlides = [];
    if (isset($themeData['hero_data']['slides']) && is_array($themeData['hero_data']['slides'])) {
        foreach ($themeData['hero_data']['slides'] as $slide) {
            if (isset($slide['order'])) {
                $heroSlides[$slide['order']] = $slide;
            }
        }
    }
    
    // Get hero slide data from themeData using order key
    $heroSlide = $heroSlides[0] ?? null;
    $heroSlide2 = $heroSlides[1] ?? null;
    $heroSlide3 = $heroSlides[2] ?? null;
    $heroSlide4 = $heroSlides[3] ?? null;
    $heroSlide5 = $heroSlides[4] ?? null;
    $heroSlide6 = $heroSlides[5] ?? null;
    $heroSlide7 = $heroSlides[6] ?? null;
    $heroSlide8 = $heroSlides[7] ?? null;
    $heroSlide9 = $heroSlides[8] ?? null;
    
    // Process sections_data for section visibility control
    $sectionControls = [];
    if (isset($sectionsData) && is_array($sectionsData)) {
        foreach ($sectionsData as $key => $section) {
            $sectionControls[$key] = $section['is_active'] ?? true;
        }
    }
    
    // Default section controls if sections_data is not available
    $defaultSections = [
        'section1' => true,  // Banner Section
        'section2' => true,  // Featured Categories
        'section3' => true,  // Flash Sales
        'section4' => true,  // Sale Banners
        'section5' => true,  // Popular Products
        'section6' => true,  // Sale Banners (Second Section)
        'section7' => true,  // Product Listing Section
        'section8' => true,  // Sale Banner Long Section
        'section9' => true,  // Featured Products Slider
        'section10' => true, // Blog Section
    ];
    
    // Merge with defaults
    $sectionControls = array_merge($defaultSections, $sectionControls);
    
    // Theme data is now properly loaded
    // @dump($themeData) // Uncomment to debug theme data
@endphp
<!-- Banner Section -->
@if($sectionControls['section1'] && ($heroSlide || (isset($homePage) && $homePage->hero_enabled)))
<section class="banner banner--style2">
    <div class="container">
        <div class="banner__inner">
            <div class="row g-4">
                <div class="col-xl-8">
                    @php
                        // Get background image from themeData or fallback to homePage
                        $backgroundImage = null;
                        if ($heroSlide && isset($heroSlide['image'])) {
                            $imageData = $heroSlide['image'];
                            // Handle both array (responsive images) and string (old format)
                            $imagePath = is_array($imageData) 
                                ? ($imageData['large'] ?? $imageData['original'] ?? reset($imageData))
                                : $imageData;
                            $backgroundImage = asset('storage/' . $imagePath);
                        } elseif (isset($homePage)) {
                            $backgroundImage = $homePage->hero_image 
                                ? asset('storage/' . $homePage->hero_image) 
                                : ($homePage->hero_background_image ? asset('storage/' . $homePage->hero_background_image) : asset('themes/torganic/assets/images/banner/home2/1.png'));
                        } else {
                            $backgroundImage = asset('themes/torganic/assets/images/banner/home2/1.png');
                        }
                    @endphp
                    <div class="banner__wrapper" style="background-image: url({{ $backgroundImage }}); background-size: cover; background-position: center center; background-repeat: no-repeat; min-height: 400px; border-radius: 1.5rem; position: relative;">
                        <!-- Overlay for better text readability -->
                        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.3); border-radius: 1.5rem;"></div>
                        <div class="row align-items-center g-5" style="position: relative; z-index: 2; padding: 2rem;">
                            <div class="col-12">
                                <div class="banner__content" data-aos="fade-right" data-aos-duration="800" style="color: white; text-shadow: 2px 2px 4px rgba(0,0,0,0.7);">
                                    <h1 class="banner__content-heading" style="color: white;">
                                        {{ ($heroSlide['title'] ?? null) ?: ($homePage->hero_title ?? 'منتجات طازجة لحياة صحية') }}
                                    </h1>
                                    <p class="banner__content-moto" style="color: rgba(255,255,255,0.9);">
                                        {{ ($heroSlide['subtitle'] ?? null) ?: ($homePage->hero_subtitle ?? $homePage->hero_description ?? 'نوفر لك أفضل المنتجات العضوية الطازجة') }}
                                    </p>
                                    @if($heroSlide && isset($heroSlide['button_text']) && $heroSlide['button_text'])
                                        <a href="{{ $heroSlide['button_link'] ?? route('products.index') }}" class="trk-btn trk-btn--secondary" style="background: white; color: var(--brand-color); border: 2px solid white;">
                                            {{ $heroSlide['button_text'] }} <span><i class="fa-solid fa-arrow-right-long"></i></span>
                                        </a>
                                    @elseif(isset($homePage) && $homePage->hero_button1_text && $homePage->hero_button1_link)
                                        <a href="{{ $homePage->hero_button1_link }}" class="trk-btn trk-btn--secondary" style="background: white; color: var(--brand-color); border: 2px solid white;">
                                            {{ $homePage->hero_button1_text }} <span><i class="fa-solid fa-arrow-right-long"></i></span>
                                        </a>
                                    @else
                                        <a href="{{ route('products.index') }}" class="trk-btn trk-btn--secondary" style="background: white; color: var(--brand-color); border: 2px solid white;">
                                            تسوق الآن <span><i class="fa-solid fa-arrow-right-long"></i></span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="row g-4">
                        <div class="col-md-6 col-xl-12">
                            <div class="sale-banner__item sale-banner__item--home2">
                        @php
                            // Get background image for slide 2
                            if ($heroSlide2 && isset($heroSlide2['image'])) {
                                $imageData = $heroSlide2['image'];
                                // Handle both array (responsive images) and string (old format)
                                $imagePath = is_array($imageData) 
                                    ? ($imageData['large'] ?? $imageData['original'] ?? reset($imageData))
                                    : $imageData;
                                $slide2Background = asset('storage/' . $imagePath);
                            } else {
                                $slide2Background = asset('themes/torganic/assets/images/banner/home2/2.png');
                            }
                        @endphp
                                <div class="sale-banner__item-inner" style="background-image: url({{ $slide2Background }});">
                                    <div class="sale-banner__item-content">
                                        <span class="sale-banner__offer">
                                            {{ $heroSlide2['subtitle'] ?? '30% خصم' }}
                                        </span>
                                        <h3 class="sale-banner__title">
                                            {{ $heroSlide2['title'] ?? 'منتجات عضوية صحية ومتميزة' }}
                                        </h3>
                                        <a href="{{ $heroSlide2['button_link'] ?? route('products.index') }}" class="trk-btn trk-btn--outline">
                                            {{ $heroSlide2['button_text'] ?? 'تسوق الآن' }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-12">
                            <div class="sale-banner__item sale-banner__item--home2">
                        @php
                            // Get background image for slide 3
                            if ($heroSlide3 && isset($heroSlide3['image'])) {
                                $imageData = $heroSlide3['image'];
                                // Handle both array (responsive images) and string (old format)
                                $imagePath = is_array($imageData) 
                                    ? ($imageData['large'] ?? $imageData['original'] ?? reset($imageData))
                                    : $imageData;
                                $slide3Background = asset('storage/' . $imagePath);
                            } else {
                                $slide3Background = asset('themes/torganic/assets/images/banner/home2/3.png');
                            }
                        @endphp
                                <div class="sale-banner__item-inner" style="background-image: url({{ $slide3Background }});">
                                    <div class="sale-banner__item-content">
                                        <span class="sale-banner__offer">
                                            {{ $heroSlide3['subtitle'] ?? '50% خصم' }}
                                        </span>
                                        <h3 class="sale-banner__title">
                                            {{ $heroSlide3['title'] ?? 'حلويات طبيعية ولذيذة' }}
                                        </h3>
                                        <a href="{{ $heroSlide3['button_link'] ?? route('products.index') }}" class="trk-btn trk-btn--outline">
                                            {{ $heroSlide3['button_text'] ?? 'تسوق الآن' }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="banner__shape banner__shape--home2">
        <span class="banner__shape-item banner__shape-item--1"><img src="{{ asset('themes/torganic/assets/images/banner/home2/chilli.png') }}" alt="shape icon"></span>
        <span class="banner__shape-item banner__shape-item--2"><img src="{{ asset('themes/torganic/assets/images/banner/home2/tomato.png') }}" alt="shape icon"></span>
        <span class="banner__shape-item banner__shape-item--5"><img src="{{ asset('themes/torganic/assets/images/banner/home2/radish.png') }}" alt="shape icon"></span>
    </div>
</section>
@endif

<!-- Featured Categories -->
@if($sectionControls['section2'] && isset($homePage) && $homePage->categories_enabled)
<section class="featured-categories padding-top padding-bottom" data-aos="fade-up" data-aos-duration="1000">
    <div class="container">
        <div class="section-header">
            <div class="section-header__content">
                <h2 class="mb-10">{{ $homePage->categories_title ?? 'الأقسام المميزة' }}</h2>
            </div>
            <div class="section-header__action">
                <div class="swiper-nav swiper-nav--style1">
                    <button class="swiper-nav__btn featured-categories__slider-prev"><i class="fa-solid fa-arrow-left-long"></i></button>
                    <button class="swiper-nav__btn featured-categories__slider-next active"><i class="fa-solid fa-arrow-right-long"></i></button>
                </div>
            </div>
        </div>

        @php
            $availableCategories = collect();
            foreach($homePage->categories_data as $categoryData) {
                $category = $categories->firstWhere('id', $categoryData['id'] ?? $categoryData);
                if($category) {
                    $availableCategories->push($category);
                }
            }
        @endphp
        
        @if($availableCategories->count() > 0)
            @if($availableCategories->count() <= 6)
                <!-- Show as grid if 6 or fewer categories -->
                <div class="row g-3 justify-content-center">
                    @foreach($availableCategories as $category)
                    <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                        <div class="featured-categories__item" style="position: relative;">
                            <div class="featured-categories__item-inner">
                                <div class="featured-categories__thumb" style="display: flex; align-items: center; justify-content: center;">
                                    @if($category->icon)
                                        <i class="{{ $category->icon }}" style="font-size: 3.5rem; color: {{ $category->bg_color ?: '#10B981' }}; line-height: 1;"></i>
                                    @elseif($category->image)
                                        <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" style="width: 80px; height: 80px; object-fit: contain;">
                                    @else
                                        <i class="fa-solid fa-folder" style="font-size: 3.5rem; color: var(--brand-color, #10B981); line-height: 1;"></i>
                                    @endif
                                </div>
                                <div class="featured-categories__content">
                                    <h4><a href="{{ route('category.show', $category->slug) }}" class="stretched-link">{{ $category->name }}</a></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <!-- Show as slider if more than 6 categories -->
                <div class="featured-categories__slider swiper">
                    <div class="swiper-wrapper">
                        @foreach($availableCategories as $category)
                        <div class="swiper-slide">
                            <div class="featured-categories__item" style="position: relative;">
                                <div class="featured-categories__item-inner">
                                    <div class="featured-categories__thumb" style="display: flex; align-items: center; justify-content: center;">
                                        @if($category->icon)
                                            <i class="{{ $category->icon }}" style="font-size: 3.5rem; color: {{ $category->bg_color ?: '#10B981' }}; line-height: 1;"></i>
                                        @elseif($category->image)
                                            <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" style="width: 80px; height: 80px; object-fit: contain;">
                                        @else
                                            <i class="fa-solid fa-folder" style="font-size: 3.5rem; color: var(--brand-color, #10B981); line-height: 1;"></i>
                                        @endif
                                    </div>
                                    <div class="featured-categories__content">
                                        <h4><a href="{{ route('category.show', $category->slug) }}" class="stretched-link">{{ $category->name }}</a></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif
    </div>
</section>
@endif

<!-- Flash Sales -->
@if($sectionControls['section3'] && isset($flashSaleProducts) && $flashSaleProducts->isNotEmpty())
<section class="product padding-top padding-bottom section-bg">
    <div class="container">
        <div class="section-header">
            <div class="section-header__content">
                <h2 class="mb-10 me-30">عروض محدودة</h2>
            </div>
            <div class="product-btn order-sm-2 order-lg-3">
                <a class="trk-btn trk-btn--sm" href="{{ route('products.index') }}">عرض الكل</a>
            </div>
        </div>
        <div class="product__wrapper" data-aos="fade-up" data-aos-duration="1000">
            <div class="row g-4">
                @foreach($flashSaleProducts->take(2) as $product)
                <div class="col-lg">
                    <div class="product__item product__item--style11">
                        <div class="product__item-inner">
                            @if($product->discount_percentage > 0)
                            <div class="product__item-badge">
                                -{{ $product->discount_percentage }}%
                            </div>
                            @endif
                            <div class="product__item-thumb">
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                @else
                                    <img src="{{ asset('themes/torganic/assets/images/product/flash/1.png') }}" alt="{{ $product->name }}">
                                @endif
                            </div>
                            <div class="product__item-content">
                                <h4><a href="{{ route('products.show', $product->slug ?? $product->share_slug ?? $product->id) }}">{{ $product->name }}</a></h4>
                                <div class="product__item-rating">
                                    <i class="fa-solid fa-star"></i> {{ $product->rating ?? 5.0 }} <span>({{ $product->reviews_count ?? 0 }} تقييم)</span>
                                </div>
                                <div class="product__item-footer">
                                    <div class="product__item-price">
                                        <h4>{{ number_format($product->price, 2) }} ر.س</h4>
                                        @if($product->original_price > $product->price)
                                        <span><del>{{ number_format($product->original_price, 2) }} ر.س</del></span>
                                        @endif
                                    </div>
                                    <div class="product__item-action">
                                        <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
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
</section>

<style>
    /* RTL Layout Improvements */
    [dir="rtl"] {
        text-align: right;
    }
    
    [dir="rtl"] .banner__content-heading,
    [dir="rtl"] .banner__content-moto,
    [dir="rtl"] .section-header h2,
    [dir="rtl"] h1, [dir="rtl"] h2, [dir="rtl"] h3, [dir="rtl"] h4, [dir="rtl"] h5, [dir="rtl"] h6 {
        text-align: right;
    }
    
    /* Limited Offers Section - Image Size Adjustment */
    .product__item--style11 .product__item-thumb {
        flex: 0 0 35%;
        max-width: 35%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }
    
    .product__item--style11 .product__item-thumb img {
        width: 100%;
        height: auto;
        max-height: 250px;
        object-fit: contain;
    }
    
    .product__item--style11 .product__item-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: right;
    }
    
    /* RTL Arrow Icons */
    [dir="rtl"] .trk-btn .fa-arrow-right-long:before {
        content: "\f177"; /* arrow-left */
    }
    
    [dir="rtl"] .trk-btn .fa-arrow-right:before {
        content: "\f060"; /* arrow-left */
    }
    
    /* Product Cards RTL */
    [dir="rtl"] .product__item-content {
        text-align: right;
    }
    
    [dir="rtl"] .product__item-footer {
        direction: rtl;
    }
    
    [dir="rtl"] .product__item-rating {
        direction: rtl;
    }
    
    @media (max-width: 575px) {
        .product__item--style11 .product__item-thumb {
            flex: 0 0 100%;
            max-width: 100%;
            margin-bottom: 1rem;
        }
    }
</style>

@endif

<!-- Sale Banners -->
@if($sectionControls['section4'])
<section class="sale-banner padding-top padding-bottom">
    <div class="container">
        <div class="sale-banner__wrapper" data-aos="fade-up" data-aos-duration="1000">
            <div class="row g-3">
                <div class="col-xl-3 col-md-6 order-1">
                    <div class="sale-banner__item sale-banner__item--style5">
                        @php
                            // Get image for slide 4
                            if ($heroSlide4 && isset($heroSlide4['image'])) {
                                $imageData = $heroSlide4['image'];
                                // Handle both array (responsive images) and string (old format)
                                $imagePath = is_array($imageData) 
                                    ? ($imageData['large'] ?? $imageData['original'] ?? reset($imageData))
                                    : $imageData;
                                $slide4Image = asset('storage/' . $imagePath);
                            } else {
                                $slide4Image = asset('themes/torganic/assets/images/product/sale-banner/5.png');
                            }
                        @endphp
                        <div class="sale-banner__item-inner">
                            <div class="sale-banner__item-content">
                                <h4 class="sale-banner__title">
                                    {{ $heroSlide4['title'] ?? 'عسل نقي طبيعي' }}
                                </h4>
                                <a href="{{ $heroSlide4['button_link'] ?? route('products.index') }}" class="text-btn">
                                    {{ $heroSlide4['button_text'] ?? 'تسوق الآن' }}
                                </a>
                            </div>
                            <div class="sale-banner__item-thumb">
                                <img src="{{ $slide4Image }}" alt="{{ $heroSlide4['title'] ?? 'عسل طبيعي' }}" style="width: 220px; height: 167px; object-fit: contain; object-position: center;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-12 order-sm-3 order-xl-2">
                    <div class="sale-banner__item sale-banner__item--style4">
                        @php
                            // Get image for slide 5
                            if ($heroSlide5 && isset($heroSlide5['image'])) {
                                $imageData = $heroSlide5['image'];
                                // Handle both array (responsive images) and string (old format)
                                $imagePath = is_array($imageData) 
                                    ? ($imageData['large'] ?? $imageData['original'] ?? reset($imageData))
                                    : $imageData;
                                $slide5Image = asset('storage/' . $imagePath);
                            } else {
                                $slide5Image = asset('themes/torganic/assets/images/product/sale-banner/4.png');
                            }
                        @endphp
                        <div class="sale-banner__item-inner">
                            <div class="sale-banner__item-thumb">
                                <img src="{{ $slide5Image }}" alt="{{ $heroSlide5['title'] ?? 'banner' }}">
                                <div class="sale-banner__item-discount-badge sale-banner__item-discount-badge--style3">
                                    <span class="sale-banner__discount-text">{{ $heroSlide5['discount_text'] ?? 'خصم يصل إلى' }}</span>
                                    <h4 class="sale-banner__discount-amount">{{ $heroSlide5['discount_amount'] ?? '20%' }}</h4>
                                </div>
                            </div>
                            <div class="sale-banner__item-content">
                                <h6>{{ $heroSlide5['subtitle'] ?? 'عرض لفترة محدودة' }}</h6>
                                <h3>{{ $heroSlide5['title'] ?? 'مجموعة البقالة الفاخرة' }}</h3>
                                <a href="{{ $heroSlide5['button_link'] ?? route('products.index') }}" class="trk-btn trk-btn--sm mt-3">
                                    {{ $heroSlide5['button_text'] ?? 'تسوق الآن' }} <span><i class="fa-solid fa-arrow-right-long"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 order-sm-2 order-xl-3">
                    <div class="sale-banner__item sale-banner__item--style52">
                        @php
                            // Get image for slide 6
                            if ($heroSlide6 && isset($heroSlide6['image'])) {
                                $imageData = $heroSlide6['image'];
                                // Handle both array (responsive images) and string (old format)
                                $imagePath = is_array($imageData) 
                                    ? ($imageData['large'] ?? $imageData['original'] ?? reset($imageData))
                                    : $imageData;
                                $slide6Image = asset('storage/' . $imagePath);
                            } else {
                                $slide6Image = asset('themes/torganic/assets/images/product/sale-banner/6.png');
                            }
                        @endphp
                        <div class="sale-banner__item-inner">
                            <div class="sale-banner__item-content">
                                <h4 class="sale-banner__title">{{ $heroSlide6['title'] ?? 'زبدة لوز عضوية' }}</h4>
                                <a href="{{ $heroSlide6['button_link'] ?? route('products.index') }}" class="text-btn text-btn--sm">{{ $heroSlide6['button_text'] ?? 'تسوق الآن' }}</a>
                            </div>
                            <div class="sale-banner__item-thumb">
                                <img src="{{ $slide6Image }}" alt="{{ $heroSlide6['title'] ?? 'زبدة لوز' }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Popular Products with Tabs -->
@if($sectionControls['section5'])
<section class="popular-product padding-top padding-bottom">
    <div class="container">
        <div class="popular-product__wrapper" data-aos="fade-up" data-aos-duration="1000">
            <div class="popular-product__header section-header">
                <h2 class="popular-product__title order-sm-1">المنتجات الشائعة</h2>
                <div class="popular-product__filters order-sm-3 order-lg-2">
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-all-tab" data-bs-toggle="pill" data-bs-target="#pills-all" type="button" role="tab" aria-controls="pills-all" aria-selected="true">الكل</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-new-arrivals-tab" data-bs-toggle="pill" data-bs-target="#pills-new-arrivals" type="button" role="tab" aria-controls="pills-new-arrivals" aria-selected="false">وصل حديثاً</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-features-tab" data-bs-toggle="pill" data-bs-target="#pills-features" type="button" role="tab" aria-controls="pills-features" aria-selected="false">مميز</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-best-sellers-tab" data-bs-toggle="pill" data-bs-target="#pills-best-sellers" type="button" role="tab" aria-controls="pills-best-sellers" aria-selected="false">الأكثر مبيعاً</button>
                        </li>
                    </ul>
                </div>
                <div class="product-btn order-sm-2 order-lg-3">
                    <a class="trk-btn trk-btn--sm" href="{{ route('products.index') }}">عرض الكل</a>
                </div>
            </div>

            <div class="tab-content" id="pills-tabContent">
                <!-- All Products Tab -->
                <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">
                    <div class="row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 justify-content-center g-3">
                        @if(isset($popularProducts) && $popularProducts->isNotEmpty())
                            @foreach($popularProducts as $product)
                            <div class="col">
                                <div class="product__item product__item--style2">
                                    <div class="product__item-inner {{ $loop->index == 1 ? 'active' : '' }}">
                                        @if($product->discount_percentage > 0)
                                        <div class="product__item-badge">-{{ $product->discount_percentage }}%</div>
                                        @endif
                                        <div class="product__item-thumb">
                                            @if($product->image)
                                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                            @else
                                                <img src="{{ asset('themes/torganic/assets/images/product/popular/' . (($loop->index % 10) + 1) . '.png') }}" alt="{{ $product->name }}">
                                            @endif
                                        </div>
                                        <div class="product__item-content">
                                            <h5><a href="{{ route('products.show', $product->slug ?? $product->share_slug ?? $product->id) }}">{{ $product->name }}</a></h5>
                                            <div class="product__item-rating">
                                                <i class="fa-solid fa-star"></i> {{ $product->rating ?? 5.0 }} <span>({{ $product->reviews_count ?? 0 }} تقييم)</span>
                                            </div>
                                            <div class="product__item-footer">
                                                <div class="product__item-price">
                                                    <h4>{{ number_format($product->price, 2) }} ر.س</h4>
                                                    @if(isset($product->original_price) && $product->original_price > $product->price)
                                                    <span><del>{{ number_format($product->original_price, 2) }} ر.س</del></span>
                                                    @endif
                                                </div>
                                                <div class="product__item-action">
                                                    <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
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
                        @endif
                    </div>
                </div>
                
                <!-- New Arrivals Tab -->
                <div class="tab-pane fade" id="pills-new-arrivals" role="tabpanel" aria-labelledby="pills-new-arrivals-tab">
                    <div class="row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 justify-content-center g-3">
                        @if(isset($newArrivals) && $newArrivals->isNotEmpty())
                            @foreach($newArrivals as $product)
                            <div class="col">
                                <div class="product__item product__item--style2">
                                    <div class="product__item-inner">
                                        @if($product->discount_percentage > 0)
                                        <div class="product__item-badge">-{{ $product->discount_percentage }}%</div>
                                        @endif
                                        <div class="product__item-thumb">
                                            @if($product->image)
                                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                            @else
                                                <img src="{{ asset('themes/torganic/assets/images/product/popular/' . (($loop->index % 10) + 1) . '.png') }}" alt="{{ $product->name }}">
                                            @endif
                                        </div>
                                        <div class="product__item-content">
                                            <h5><a href="{{ route('products.show', $product->slug ?? $product->share_slug ?? $product->id) }}">{{ $product->name }}</a></h5>
                                            <div class="product__item-rating">
                                                <i class="fa-solid fa-star"></i> {{ $product->rating ?? 5.0 }} <span>({{ $product->reviews_count ?? 0 }})</span>
                                            </div>
                                            <div class="product__item-footer">
                                                <div class="product__item-price">
                                                    <h4>{{ number_format($product->price, 2) }} ر.س</h4>
                                                </div>
                                                <div class="product__item-action">
                                                    <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
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
                        @elseif(isset($popularProducts))
                            @foreach($popularProducts->take(5) as $product)
                            <div class="col">
                                <div class="product__item product__item--style2">
                                    <div class="product__item-inner">
                                        <div class="product__item-thumb">
                                            @if($product->image)
                                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                            @else
                                                <img src="{{ asset('themes/torganic/assets/images/product/popular/' . (($loop->index % 10) + 1) . '.png') }}" alt="{{ $product->name }}">
                                            @endif
                                        </div>
                                        <div class="product__item-content">
                                            <h5><a href="{{ route('products.show', $product->slug ?? $product->share_slug ?? $product->id) }}">{{ $product->name }}</a></h5>
                                            <div class="product__item-rating">
                                                <i class="fa-solid fa-star"></i> {{ $product->rating ?? 5.0 }}
                                            </div>
                                            <div class="product__item-footer">
                                                <div class="product__item-price">
                                                    <h4>{{ number_format($product->price, 2) }} ر.س</h4>
                                                </div>
                                                <div class="product__item-action">
                                                    <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
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
                        @endif
                    </div>
                </div>
                
                <!-- Featured Tab -->
                <div class="tab-pane fade" id="pills-features" role="tabpanel" aria-labelledby="pills-features-tab">
                    <div class="row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 justify-content-center g-3">
                        @if(isset($featuredProducts) && $featuredProducts->isNotEmpty())
                            @foreach($featuredProducts as $product)
                            <div class="col">
                                <div class="product__item product__item--style2">
                                    <div class="product__item-inner">
                                        <div class="product__item-thumb">
                                            @if($product->image)
                                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                            @else
                                                <img src="{{ asset('themes/torganic/assets/images/product/popular/' . (($loop->index % 10) + 1) . '.png') }}" alt="{{ $product->name }}">
                                            @endif
                                        </div>
                                        <div class="product__item-content">
                                            <h5><a href="{{ route('products.show', $product->slug ?? $product->share_slug ?? $product->id) }}">{{ $product->name }}</a></h5>
                                            <div class="product__item-rating">
                                                <i class="fa-solid fa-star"></i> {{ $product->rating ?? 5.0 }}
                                            </div>
                                            <div class="product__item-footer">
                                                <div class="product__item-price">
                                                    <h4>{{ number_format($product->price, 2) }} ر.س</h4>
                                                </div>
                                                <div class="product__item-action">
                                                    <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
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
                        @elseif(isset($popularProducts))
                            @foreach($popularProducts->take(5) as $product)
                            <div class="col">
                                <div class="product__item product__item--style2">
                                    <div class="product__item-inner">
                                        <div class="product__item-thumb">
                                            @if($product->image)
                                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                            @else
                                                <img src="{{ asset('themes/torganic/assets/images/product/popular/' . (($loop->index % 10) + 1) . '.png') }}" alt="{{ $product->name }}">
                                            @endif
                                        </div>
                                        <div class="product__item-content">
                                            <h5><a href="{{ route('products.show', $product->slug ?? $product->share_slug ?? $product->id) }}">{{ $product->name }}</a></h5>
                                            <div class="product__item-footer">
                                                <div class="product__item-price">
                                                    <h4>{{ number_format($product->price, 2) }} ر.س</h4>
                                                </div>
                                                <div class="product__item-action">
                                                    <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
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
                        @endif
                    </div>
                </div>
                
                <!-- Best Sellers Tab -->
                <div class="tab-pane fade" id="pills-best-sellers" role="tabpanel" aria-labelledby="pills-best-sellers-tab">
                    <div class="row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 justify-content-center g-3">
                        @if(isset($bestSellers) && $bestSellers->isNotEmpty())
                            @foreach($bestSellers as $product)
                            <div class="col">
                                <div class="product__item product__item--style2">
                                    <div class="product__item-inner">
                                        <div class="product__item-thumb">
                                            @if($product->image)
                                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                            @else
                                                <img src="{{ asset('themes/torganic/assets/images/product/popular/' . (($loop->index % 10) + 1) . '.png') }}" alt="{{ $product->name }}">
                                            @endif
                                        </div>
                                        <div class="product__item-content">
                                            <h5><a href="{{ route('products.show', $product->slug ?? $product->share_slug ?? $product->id) }}">{{ $product->name }}</a></h5>
                                            <div class="product__item-rating">
                                                <i class="fa-solid fa-star"></i> {{ $product->rating ?? 5.0 }}
                                            </div>
                                            <div class="product__item-footer">
                                                <div class="product__item-price">
                                                    <h4>{{ number_format($product->price, 2) }} ر.س</h4>
                                                </div>
                                                <div class="product__item-action">
                                                    <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
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
                        @elseif(isset($popularProducts))
                            @foreach($popularProducts->take(5) as $product)
                            <div class="col">
                                <div class="product__item product__item--style2">
                                    <div class="product__item-inner">
                                        <div class="product__item-thumb">
                                            @if($product->image)
                                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                            @else
                                                <img src="{{ asset('themes/torganic/assets/images/product/popular/' . (($loop->index % 10) + 1) . '.png') }}" alt="{{ $product->name }}">
                                            @endif
                                        </div>
                                        <div class="product__item-content">
                                            <h5><a href="{{ route('products.show', $product->slug ?? $product->share_slug ?? $product->id) }}">{{ $product->name }}</a></h5>
                                            <div class="product__item-footer">
                                                <div class="product__item-price">
                                                    <h4>{{ number_format($product->price, 2) }} ر.س</h4>
                                                </div>
                                                <div class="product__item-action">
                                                    <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
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
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Sale Banners (Second Section) -->
@if($sectionControls['section6'])
<section class="sale-banner padding-top padding-bottom">
    <div class="container">
        <div class="sale-banner__wrapper" data-aos="fade-up" data-aos-duration="1000">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="sale-banner__item sale-banner__item--style2">
                        <div class="sale-banner__item-inner">
                            <div class="sale-banner__item-thumb">
                                @php
                                    if ($heroSlide7 && isset($heroSlide7['image'])) {
                                        $imageData = $heroSlide7['image'];
                                        // Handle both array (responsive images) and string (old format)
                                        $imagePath = is_array($imageData) 
                                            ? ($imageData['large'] ?? $imageData['original'] ?? reset($imageData))
                                            : $imageData;
                                        $slide7Image = asset('storage/' . $imagePath);
                                    } else {
                                        $slide7Image = asset('themes/torganic/assets/images/product/sale-banner/2.png');
                                    }
                                @endphp
                                <img src="{{ $slide7Image }}" alt="{{ $heroSlide7['title'] ?? 'منتجات بحرية' }}">
                            </div>
                            <div class="sale-banner__item-content">
                                <span class="sale-banner__offer">{{ $heroSlide7['subtitle'] ?? 'خصم 10%' }}</span>
                                <h3 class="sale-banner__title">{{ $heroSlide7['title'] ?? 'منتجات بحرية مميزة' }}</h3>
                                <p class="sale-banner__description">{{ $heroSlide7['description'] ?? 'اكتشف عالماً من النكهات الرائعة مع منتجاتنا البحرية' }}</p>
                                <a href="{{ $heroSlide7['button_link'] ?? route('products.index') }}" class="trk-btn trk-btn--md">
                                    {{ $heroSlide7['button_text'] ?? 'تسوق الآن' }} <span><i class="fa-solid fa-arrow-right-long"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="sale-banner__item sale-banner__item--style22">
                        <div class="sale-banner__item-inner">
                            <div class="sale-banner__item-thumb">
                                @php
                                    if ($heroSlide8 && isset($heroSlide8['image'])) {
                                        $imageData = $heroSlide8['image'];
                                        // Handle both array (responsive images) and string (old format)
                                        $imagePath = is_array($imageData) 
                                            ? ($imageData['large'] ?? $imageData['original'] ?? reset($imageData))
                                            : $imageData;
                                        $slide8Image = asset('storage/' . $imagePath);
                                    } else {
                                        $slide8Image = asset('themes/torganic/assets/images/product/sale-banner/3.png');
                                    }
                                @endphp
                                <img src="{{ $slide8Image }}" alt="{{ $heroSlide8['title'] ?? 'فواكه طازجة' }}">
                                <div class="sale-banner__item-discount-badge sale-banner__item-discount-badge--style2">
                                    <span class="sale-banner__discount-text">{{ $heroSlide8['badge_text'] ?? 'خصم حتى' }}</span>
                                    <h4 class="sale-banner__discount-amount">{{ $heroSlide8['badge_amount'] ?? '20%' }}</h4>
                                    <span class="sale-banner__discount-text">{{ $heroSlide8['badge_label'] ?? 'خصم' }}</span>
                                </div>
                            </div>
                            <div class="sale-banner__item-content">
                                <span class="sale-banner__offer">{{ $heroSlide8['subtitle'] ?? 'أفضل عرض اليوم' }}</span>
                                <h3 class="sale-banner__title">{{ $heroSlide8['title'] ?? 'فواكه صحية' }}</h3>
                                <p class="sale-banner__description">{{ $heroSlide8['description'] ?? 'استمتع بخيرات الطبيعة مع فواكهنا الطازجة' }}</p>
                                <a href="{{ $heroSlide8['button_link'] ?? route('products.index') }}" class="trk-btn trk-btn--md">
                                    {{ $heroSlide8['button_text'] ?? 'تسوق الآن' }} <span><i class="fa-solid fa-arrow-right-long"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Product Listing Section (Top Selling, Trending, New) -->
@if($sectionControls['section7'])
<section class="product-listing padding-bottom padding-top section-bg">
    <div class="container">
        <div class="product-listing__wrapper" data-aos="fade-up" data-aos-duration="1000">
            <div class="row justify-content-center g-4">
                <!-- Top Selling -->
                <div class="col-lg-4 col-md-6">
                    <div class="product-listing__column">
                        <div class="section-header mb-4">
                            <h2 class="text-center">الأكثر مبيعاً</h2>
                        </div>
                        <div class="row g-3">
                        @if(isset($topSellingProducts) && $topSellingProducts->isNotEmpty())
                            @foreach($topSellingProducts->take(3) as $product)
                            <div class="col-12">
                                <div class="product__item product__item--style3">
                                    <div class="product__item-inner">
                                        @if($loop->index == 1 && isset($product->discount_percentage) && $product->discount_percentage > 0)
                                        <div class="product__item-badge">-{{ $product->discount_percentage }}%</div>
                                        @endif
                                        <div class="product__item-thumb">
                                            @if($product->image)
                                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                            @else
                                                <img src="{{ asset('themes/torganic/assets/images/product/listing/' . ($loop->index + 1) . '.png') }}" alt="{{ $product->name }}">
                                            @endif
                                        </div>
                                        <div class="product__item-content">
                                            <h5><a href="{{ route('products.show', $product->slug ?? $product->share_slug ?? $product->id) }}">{{ $product->name }}</a></h5>
                                            <div class="product__item-rating">
                                                <i class="fa-solid fa-star"></i> {{ $product->rating ?? 5.0 }} <span>({{ $product->reviews_count ?? 0 }})</span>
                                            </div>
                                            <div class="product__item-footer">
                                                <div class="product__item-price">
                                                    <h4>{{ number_format($product->price, 2) }} ر.س</h4>
                                                    @if($loop->index == 1 && isset($product->original_price) && $product->original_price > $product->price)
                                                    <span><del>{{ number_format($product->original_price, 2) }} ر.س</del></span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <div class="product__item product__item--style3">
                                    <div class="product__item-inner">
                                        <div class="product__item-thumb">
                                            <img src="{{ asset('themes/torganic/assets/images/product/listing/1.png') }}" alt="منتج">
                                        </div>
                                        <div class="product__item-content">
                                            <h5><a href="{{ route('products.index') }}">تصفح المنتجات</a></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        </div>
                    </div>
                </div>

                <!-- Trending Products -->
                <div class="col-lg-4 col-md-6">
                    <div class="product-listing__column">
                        <div class="section-header mb-4">
                            <h2 class="text-center">المنتجات الرائجة</h2>
                        </div>
                        <div class="row g-3">
                        @if(isset($trendingProducts) && $trendingProducts->isNotEmpty())
                            @foreach($trendingProducts->take(3) as $product)
                            <div class="col-12">
                                <div class="product__item product__item--style3">
                                    <div class="product__item-inner">
                                        @if($loop->index == 1)
                                        <div class="product__item-badge product__item-badge--new">جديد</div>
                                        @endif
                                        <div class="product__item-thumb">
                                            @if($product->image)
                                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                            @else
                                                <img src="{{ asset('themes/torganic/assets/images/product/listing/' . ($loop->index + 4) . '.png') }}" alt="{{ $product->name }}">
                                            @endif
                                        </div>
                                        <div class="product__item-content">
                                            <h5><a href="{{ route('products.show', $product->slug ?? $product->share_slug ?? $product->id) }}">{{ $product->name }}</a></h5>
                                            <div class="product__item-rating">
                                                <i class="fa-solid fa-star"></i> {{ $product->rating ?? 4.5 }} <span>({{ $product->reviews_count ?? 0 }})</span>
                                            </div>
                                            <div class="product__item-footer">
                                                <div class="product__item-price">
                                                    <h4>{{ number_format($product->price, 2) }} ر.س</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <div class="product__item product__item--style3">
                                    <div class="product__item-inner">
                                        <div class="product__item-thumb">
                                            <img src="{{ asset('themes/torganic/assets/images/product/listing/4.png') }}" alt="منتج">
                                        </div>
                                        <div class="product__item-content">
                                            <h5><a href="{{ route('products.index') }}">تصفح المنتجات</a></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        </div>
                    </div>
                </div>

                <!-- New Products -->
                <div class="col-lg-4 col-md-6">
                    <div class="product-listing__column">
                        <div class="section-header mb-4">
                            <h2 class="text-center">منتجات جديدة</h2>
                        </div>
                        <div class="row g-3">
                        @if(isset($newProducts) && $newProducts->isNotEmpty())
                            @foreach($newProducts->take(3) as $product)
                            <div class="col-12">
                                <div class="product__item product__item--style3">
                                    <div class="product__item-inner">
                                        @if($loop->first && isset($product->discount_percentage) && $product->discount_percentage > 0)
                                        <div class="product__item-badge">-{{ $product->discount_percentage }}%</div>
                                        @endif
                                        <div class="product__item-thumb">
                                            @if($product->image)
                                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                            @else
                                                <img src="{{ asset('themes/torganic/assets/images/product/listing/' . ($loop->index + 7) . '.png') }}" alt="{{ $product->name }}">
                                            @endif
                                        </div>
                                        <div class="product__item-content">
                                            <h5><a href="{{ route('products.show', $product->slug ?? $product->share_slug ?? $product->id) }}">{{ $product->name }}</a></h5>
                                            <div class="product__item-rating">
                                                <i class="fa-solid fa-star"></i> {{ $product->rating ?? 4.5 }} <span>({{ $product->reviews_count ?? 0 }})</span>
                                            </div>
                                            <div class="product__item-footer">
                                                <div class="product__item-price">
                                                    <h4>{{ number_format($product->price, 2) }} ر.س</h4>
                                                    @if($loop->first && isset($product->original_price) && $product->original_price > $product->price)
                                                    <span><del>{{ number_format($product->original_price, 2) }} ر.س</del></span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <div class="product__item product__item--style3">
                                    <div class="product__item-inner">
                                        <div class="product__item-thumb">
                                            <img src="{{ asset('themes/torganic/assets/images/product/listing/7.png') }}" alt="منتج">
                                        </div>
                                        <div class="product__item-content">
                                            <h5><a href="{{ route('products.index') }}">تصفح المنتجات</a></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        .product-listing__column {
            background: #fff;
            padding: 30px 20px;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            height: 100%;
            transition: all 0.3s ease;
        }
        
        .product-listing__column:hover {
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.12);
            transform: translateY(-5px);
        }
        
        .product-listing__column .section-header h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1a202c;
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .product-listing__column .section-header h2:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            right: auto;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, var(--brand-color, #10B981) 0%, #34D399 100%);
            border-radius: 2px;
        }
        
        .product-listing__column .product__item {
            transition: all 0.3s ease;
        }
        
        .product-listing__column .product__item:hover {
            transform: scale(1.02);
        }
        
        .product-listing__column .product__item--style3 .product__item-inner {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: #f9fafb;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
        }
        
        .product-listing__column .product__item--style3 .product__item-inner:hover {
            background: #fff;
            border-color: var(--brand-color, #10B981);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.1);
        }
        
        .product-listing__column .product__item--style3 .product__item-thumb {
            flex-shrink: 0;
            width: 90px;
            height: 90px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .product-listing__column .product__item--style3 .product__item-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .product-listing__column .product__item--style3 .product__item-content {
            flex: 1;
            min-width: 0;
        }
        
        .product-listing__column .product__item--style3 .product__item-content h5 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 8px;
            line-height: 1.4;
            text-align: right;
        }
        
        .product-listing__column .product__item--style3 .product__item-content h5 a {
            color: #1a202c;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .product-listing__column .product__item--style3 .product__item-content h5 a:hover {
            color: var(--brand-color, #10B981);
        }
        
        .product-listing__column .product__item--style3 .product__item-rating {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 8px;
            direction: rtl;
        }
        
        .product-listing__column .product__item--style3 .product__item-rating i {
            color: #fbbf24;
        }
        
        .product-listing__column .product__item--style3 .product__item-price h4 {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--brand-color, #10B981);
            margin: 0;
        }
        
        .product-listing__column .product__item--style3 .product__item-price span del {
            font-size: 0.875rem;
            color: #9ca3af;
            margin-right: 8px;
        }
        
        .product-listing__column .product__item-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            left: auto;
            background: #ef4444;
            color: #fff;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            z-index: 10;
        }
        
        .product-listing__column .product__item-badge--new {
            background: #10B981;
        }
        
        /* RTL Badge Position */
        [dir="rtl"] .product__item-badge {
            right: 10px;
            left: auto;
        }
        
        @media (max-width: 991px) {
            .product-listing__column {
                margin-bottom: 20px;
            }
        }
        
        @media (max-width: 767px) {
            .product-listing__column .section-header h2 {
                font-size: 1.5rem;
            }
            
            .product-listing__column .product__item--style3 .product__item-thumb {
                width: 70px;
                height: 70px;
            }
        }
    </style>
</section>
@endif

<!-- Sale Banner Long Section -->
@if($sectionControls['section8'])
<section class="sale-banner padding-top padding-bottom">
    <div class="container">
        <div class="sale-banner__wrapper" data-aos="fade-up" data-aos-duration="1000">
            <div class="sale-banner__item sale-banner__item--style1">
                <div class="sale-banner__item-inner">
                    <div class="sale-banner__item-thumb">
                        @php
                            if ($heroSlide9 && isset($heroSlide9['image'])) {
                                $imageData = $heroSlide9['image'];
                                // Handle both array (responsive images) and string (old format)
                                $imagePath = is_array($imageData) 
                                    ? ($imageData['large'] ?? $imageData['original'] ?? reset($imageData))
                                    : $imageData;
                                $slide9Image = asset('storage/' . $imagePath);
                            } else {
                                $slide9Image = asset('themes/torganic/assets/images/product/sale-banner/1.png');
                            }
                        @endphp
                        <img class="sale-banner__image" src="{{ $slide9Image }}" alt="{{ $heroSlide9['title'] ?? 'خضروات طازجة' }}">
                        <div class="sale-banner__item-discount-badge">
                            <span>{{ $heroSlide9['badge_text'] ?? 'خصم حتى' }}</span>
                            <h3 class="sale-banner__discount-amount">{{ $heroSlide9['badge_amount'] ?? '20%' }}</h3>
                            <span>{{ $heroSlide9['badge_label'] ?? 'خصم' }}</span>
                        </div>
                    </div>
                    <div class="sale-banner__item-content">
                        <h2>{{ $heroSlide9['title'] ?? 'تخفيضات كبرى على الخضروات' }}</h2>
                        <p>{{ $heroSlide9['description'] ?? 'اكتشف عالماً من المنتجات الطازجة، والأساسيات، والمزيد في متناول يدك.' }}</p>
                        <a href="{{ $heroSlide9['button_link'] ?? route('products.index') }}" class="trk-btn trk-btn--md mt-3">
                            {{ $heroSlide9['button_text'] ?? 'تسوق الآن' }} <span><i class="fa-solid fa-arrow-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- bg-shape -->
    <div class="sale-banner__shape">
        <span class="sale-banner__shape-item sale-banner__shape-item--1"><img src="{{ asset('themes/torganic/assets/images/product/sale-banner/leaf-1.png') }}" alt="shape icon"></span>
        <span class="sale-banner__shape-item sale-banner__shape-item--2"><img src="{{ asset('themes/torganic/assets/images/product/sale-banner/leaf-2.png') }}" alt="shape icon"></span>
    </div>
</section>
@endif

<!-- Featured Products Slider -->
@if($sectionControls['section9'])
<section class="product-feature padding-bottom">
    <div class="container">
        <div class="section-header">
            <div class="section-header__content">
                <h2 class="mb-10">المنتجات المميزة</h2>
            </div>
            <div class="section-header__action">
                <div class="swiper-nav swiper-nav--style1">
                    <button class="swiper-nav__btn product__slider-prev"><i class="fa-solid fa-arrow-left-long"></i></button>
                    <button class="swiper-nav__btn product__slider-next active"><i class="fa-solid fa-arrow-right-long"></i></button>
                </div>
            </div>
        </div>
        <div class="product__wrapper" data-aos="fade-up" data-aos-duration="1000">
            <div class="product-feature__slider swiper">
                <div class="swiper-wrapper">
                    @if(isset($featuredProducts) && $featuredProducts->isNotEmpty())
                        @foreach($featuredProducts as $product)
                        <div class="swiper-slide">
                            <div class="product__item product__item--style2">
                                <div class="product__item-inner">
                                    <div class="product__item-thumb">
                                        @if($product->image)
                                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                        @else
                                            <img src="{{ asset('themes/torganic/assets/images/product/popular/' . (($loop->index % 10) + 1) . '.png') }}" alt="{{ $product->name }}">
                                        @endif
                                    </div>
                                        <div class="product__item-content">
                                            <h5><a href="{{ route('products.show', $product->slug ?? $product->share_slug ?? $product->id) }}">{{ $product->name }}</a></h5>
                                            <div class="product__item-rating">
                                                <i class="fa-solid fa-star"></i> {{ $product->rating ?? 4.9 }} <span>({{ $product->reviews_count ?? 0 }})</span>
                                        </div>
                                        <div class="product__item-footer">
                                            <div class="product__item-price">
                                                <h4>{{ number_format($product->price, 2) }} ر.س</h4>
                                            </div>
                                            <div class="product__item-action">
                                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="trk-btn trk-btn--outline">أضف للسلة</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @elseif(isset($popularProducts))
                        @foreach($popularProducts->take(6) as $product)
                        <div class="swiper-slide">
                            <div class="product__item product__item--style2">
                                <div class="product__item-inner">
                                    <div class="product__item-thumb">
                                        @if($product->image)
                                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                        @else
                                            <img src="{{ asset('themes/torganic/assets/images/product/popular/' . (($loop->index % 10) + 1) . '.png') }}" alt="{{ $product->name }}">
                                        @endif
                                    </div>
                                        <div class="product__item-content">
                                            <h5><a href="{{ route('products.show', $product->slug ?? $product->share_slug ?? $product->id) }}">{{ $product->name }}</a></h5>
                                            <div class="product__item-rating">
                                                <i class="fa-solid fa-star"></i> {{ $product->rating ?? 4.5 }}
                                            </div>
                                        <div class="product__item-footer">
                                            <div class="product__item-price">
                                                <h4>{{ number_format($product->price, 2) }} ر.س</h4>
                                            </div>
                                            <div class="product__item-action">
                                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="trk-btn trk-btn--outline">أضف للسلة</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        @for($i = 6; $i <= 10; $i++)
                        <div class="swiper-slide">
                            <div class="product__item product__item--style2">
                                <div class="product__item-inner">
                                    <div class="product__item-thumb">
                                        <img src="{{ asset('themes/torganic/assets/images/product/popular/' . $i . '.png') }}" alt="منتج مميز">
                                    </div>
                                    <div class="product__item-content">
                                        <h5><a href="{{ route('products.index') }}">منتج مميز {{ $i - 5 }}</a></h5>
                                        <div class="product__item-rating">
                                            <i class="fa-solid fa-star"></i> 4.5 <span>({{ rand(10, 100) }})</span>
                                        </div>
                                        <div class="product__item-footer">
                                            <div class="product__item-price">
                                                <h4>{{ number_format(rand(20, 40), 2) }} ر.س</h4>
                                            </div>
                                            <div class="product__item-action">
                                                <a class="trk-btn trk-btn--outline" href="{{ route('products.index') }}">تصفح</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endfor
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Blog Section -->
@if($sectionControls['section10'])
<section class="blog padding-top padding-bottom section-bg">
    <div class="container">
        <div class="section-header d-md-flex align-items-center justify-content-between">
            <div class="section-header__content">
                <h2 class="mb-10">مقالات منتظمة</h2>
            </div>
            <div class="section-header__action">
                <div class="swiper-nav swiper-nav--style1">
                    <button class="swiper-nav__btn blog__slider-prev"><i class="fa-solid fa-arrow-left-long"></i></button>
                    <button class="swiper-nav__btn blog__slider-next active"><i class="fa-solid fa-arrow-right-long"></i></button>
                </div>
            </div>
        </div>
        <div class="blog__wrapper" data-aos="fade-up" data-aos-duration="1000">
            <div class="blog__slider swiper">
                <div class="swiper-wrapper">
                    @if(isset($blogs) && $blogs->isNotEmpty())
                        @foreach($blogs as $blog)
                        <div class="swiper-slide">
                            <div class="blog__item blog__item--style2">
                                <div class="blog__item-inner">
                                    <div class="blog__thumb">
                                        @if($blog->image)
                                            <img src="{{ Storage::url($blog->image) }}" alt="{{ $blog->title }}">
                                        @else
                                            <img src="{{ asset('themes/torganic/assets/images/blog/' . (($loop->index % 3) + 1) . '.png') }}" alt="{{ $blog->title }}">
                                        @endif
                                    </div>
                                    <div class="blog__content">
                                        <div class="blog__meta">
                                            <a href="#"><span class="blog__meta-tag blog__meta-tag--style{{ ($loop->index % 3) + 1 }}">{{ $blog->category ?? 'مقالات' }}</span></a>
                                        </div>
                                        <h4><a href="{{ route('blog.show', $blog->id) }}">{{ $blog->title }}</a></h4>
                                        <div class="blog__admin">
                                            <div class="blog__admin-name">
                                                <span><i class="fa-regular fa-user"></i></span> {{ $blog->author ?? 'المدير' }}
                                            </div>
                                            <div class="blog__admin-date">
                                                <span><i class="fa-regular fa-calendar-check"></i></span> {{ $blog->created_at->format('M d, Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        @for($i = 1; $i <= 3; $i++)
                        <div class="swiper-slide">
                            <div class="blog__item blog__item--style2">
                                <div class="blog__item-inner">
                                    <div class="blog__thumb">
                                        <img src="{{ asset('themes/torganic/assets/images/blog/' . $i . '.png') }}" alt="مقالة">
                                    </div>
                                    <div class="blog__content">
                                        <div class="blog__meta">
                                            <a href="#"><span class="blog__meta-tag blog__meta-tag--style{{ $i }}">{{ $i == 1 ? 'نصائح صحية' : ($i == 2 ? 'صحة' : 'خضروات') }}</span></a>
                                        </div>
                                        <h4><a href="#">{{ $i == 1 ? 'دليل شامل للتسوق الفعال' : ($i == 2 ? 'نصائح للتسوق الصحي' : 'اختيار المنتجات الطازجة') }}</a></h4>
                                        <div class="blog__admin">
                                            <div class="blog__admin-name">
                                                <span><i class="fa-regular fa-user"></i></span> المدير
                                            </div>
                                            <div class="blog__admin-date">
                                                <span><i class="fa-regular fa-calendar-check"></i></span> {{ date('M d, Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endfor
                    @endif
                </div>
            </div>
        </div>
        <div class="section-btn mt-4 text-center">
            <a class="trk-btn trk-btn--primary" href="#">عرض المزيد</a>
        </div>
    </div>
</section>
@endif

<!-- Feature Bar -->
<div class="feature-bar border-top">
    <div class="container">
        <div class="row py-3 g-5 g-lg-4 justify-content-center">
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-3 mb-md-0">
                <div class="feature-bar__item d-flex align-items-center">
                    <img src="{{ asset('themes/torganic/assets/images/feature/bar/1.png') }}" alt="توصيل سريع">
                    <div class="feature-bar__text me-3">
                        <h3 class="feature-bar__title fs-6 fw-bold mb-0">توصيل سريع</h3>
                        <p class="feature-bar__description fs-7 mb-0 text-muted">لطلبات أكثر من 40 ريال</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-3 mb-md-0">
                <div class="feature-bar__item d-flex align-items-center">
                    <img src="{{ asset('themes/torganic/assets/images/feature/bar/2.png') }}" alt="دعم 24/7">
                    <div class="feature-bar__text me-3">
                        <h3 class="feature-bar__title fs-6 fw-bold mb-0">دعم 24/7</h3>
                        <p class="feature-bar__description fs-7 mb-0 text-muted">تواصل معنا في أي وقت</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-3 mb-md-0">
                <div class="feature-bar__item d-flex align-items-center">
                    <img src="{{ asset('themes/torganic/assets/images/feature/bar/3.png') }}" alt="دفع آمن">
                    <div class="feature-bar__text me-3">
                        <h3 class="feature-bar__title fs-6 fw-bold mb-0">دفع آمن</h3>
                        <p class="feature-bar__description fs-7 mb-0 text-muted">100% دفع آمن ومضمون</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-3 mb-md-0">
                <div class="feature-bar__item d-flex align-items-center">
                    <img src="{{ asset('themes/torganic/assets/images/feature/bar/4.png') }}" alt="استرجاع سهل">
                    <div class="feature-bar__text me-3">
                        <h3 class="feature-bar__title fs-6 fw-bold mb-0">استرجاع سهل</h3>
                        <p class="feature-bar__description fs-7 mb-0 text-muted">خلال 30 يوم</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div><!-- End RTL wrapper -->
@endsection

@push('scripts')
<script>
    // Initialize Featured Categories Slider (only if slider exists)
    const featuredCategoriesSliderElement = document.querySelector('.featured-categories__slider');
    if (featuredCategoriesSliderElement) {
        const featuredCategoriesSlider = new Swiper('.featured-categories__slider', {
            slidesPerView: 2,
            spaceBetween: 20,
            loop: false,
            rtl: true,
            navigation: {
                nextEl: '.featured-categories__slider-next',
                prevEl: '.featured-categories__slider-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 4,
                },
                1024: {
                    slidesPerView: 6,
                },
            },
        });
    }

    // Initialize Featured Products Slider
    const featuredProductsSlider = new Swiper('.product-feature__slider', {
        slidesPerView: 2,
        spaceBetween: 20,
        loop: true,
        rtl: true,
        navigation: {
            nextEl: '.product__slider-next',
            prevEl: '.product__slider-prev',
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

    // Initialize Blog Slider
    const blogSlider = new Swiper('.blog__slider', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        rtl: true,
        navigation: {
            nextEl: '.blog__slider-next',
            prevEl: '.blog__slider-prev',
        },
        breakpoints: {
            768: {
                slidesPerView: 2,
            },
            1024: {
                slidesPerView: 3,
            },
        },
    });
</script>
@endpush