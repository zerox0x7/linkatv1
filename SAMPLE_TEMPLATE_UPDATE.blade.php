{{-- 
    SAMPLE TEMPLATE UPDATE
    This file shows how to update theme templates to use responsive images.
    Copy the relevant sections to your actual theme files.
--}}

{{-- ============================================= --}}
{{-- EXAMPLE 1: Hero Section Background Image     --}}
{{-- ============================================= --}}

{{-- BEFORE (Old Way) --}}
@php
    $backgroundImage = null;
    if ($heroSlide && isset($heroSlide['image'])) {
        $backgroundImage = asset('storage/' . $heroSlide['image']);
    } else {
        $backgroundImage = asset('themes/torganic/assets/images/banner/home2/1.png');
    }
@endphp
<div class="banner__wrapper" style="background-image: url({{ $backgroundImage }}); background-size: cover; background-position: center;">
    <div class="banner__content">
        <h1>{{ $heroSlide['title'] ?? 'Welcome' }}</h1>
    </div>
</div>

{{-- AFTER (New Way with Responsive Images) --}}
@php
    // The helper function handles both array (responsive) and string (old) formats
    $backgroundImage = $heroSlide['image'] ?? 'themes/torganic/assets/images/banner/home2/1.png';
@endphp
<div class="banner__wrapper" style="{{ getResponsiveBackgroundStyle($backgroundImage, 'background-size: cover; background-position: center; background-repeat: no-repeat;') }}">
    <div class="banner__content">
        <h1>{{ $heroSlide['title'] ?? 'Welcome' }}</h1>
    </div>
</div>


{{-- ============================================= --}}
{{-- EXAMPLE 2: Product/Banner Image Tag          --}}
{{-- ============================================= --}}

{{-- BEFORE (Old Way) --}}
@php
    $slide4Image = $heroSlide4 && isset($heroSlide4['image']) 
        ? asset('storage/' . $heroSlide4['image']) 
        : asset('themes/torganic/assets/images/product/sale-banner/5.png');
@endphp
<img src="{{ $slide4Image }}" 
     alt="{{ $heroSlide4['title'] ?? 'Product' }}" 
     style="width: 220px; height: 167px; object-fit: contain;">

{{-- AFTER (New Way with Responsive Images) --}}
@php
    $slideImage = $heroSlide4['image'] ?? 'themes/torganic/assets/images/product/sale-banner/5.png';
@endphp
{!! responsiveImage(
    $slideImage,
    $heroSlide4['title'] ?? 'Product',
    '',
    'width: 220px; height: 167px; object-fit: contain; object-position: center;'
) !!}


{{-- ============================================= --}}
{{-- EXAMPLE 3: Sale Banner with CSS Class        --}}
{{-- ============================================= --}}

{{-- BEFORE (Old Way) --}}
@php
    $slide9Image = $heroSlide9 && isset($heroSlide9['image']) 
        ? asset('storage/' . $heroSlide9['image']) 
        : asset('themes/torganic/assets/images/product/sale-banner/1.png');
@endphp
<img class="sale-banner__image" 
     src="{{ $slide9Image }}" 
     alt="{{ $heroSlide9['title'] ?? 'Banner' }}">

{{-- AFTER (New Way with Responsive Images) --}}
@php
    $bannerImage = $heroSlide9['image'] ?? 'themes/torganic/assets/images/product/sale-banner/1.png';
@endphp
{!! responsiveImage(
    $bannerImage,
    $heroSlide9['title'] ?? 'Banner',
    'sale-banner__image'
) !!}


{{-- ============================================= --}}
{{-- EXAMPLE 4: Manual Control with srcset         --}}
{{-- For when you need more control over the img tag --}}
{{-- ============================================= --}}

{{-- You can also build the img tag manually if needed --}}
@php
    $slideImage = $heroSlide['image'] ?? null;
@endphp

@if($slideImage)
<img 
    src="{{ getResponsiveImageUrl($slideImage, 'large') }}" 
    srcset="{{ getResponsiveImageSrcset($slideImage) }}"
    sizes="{{ getResponsiveImageSizes() }}"
    alt="{{ $heroSlide['title'] ?? '' }}"
    class="custom-class"
    style="custom: styles;"
    loading="lazy"
>
@endif


{{-- ============================================= --}}
{{-- EXAMPLE 5: Conditional Image Display          --}}
{{-- ============================================= --}}

@if(isset($heroSlide['image']))
    <div class="image-wrapper">
        {!! responsiveImage($heroSlide['image'], $heroSlide['title'] ?? '', 'img-fluid rounded shadow') !!}
    </div>
@else
    <div class="placeholder">
        <img src="{{ asset('themes/torganic/assets/images/placeholder.png') }}" alt="Placeholder">
    </div>
@endif


{{-- ============================================= --}}
{{-- EXAMPLE 6: Multiple Images in Loop            --}}
{{-- ============================================= --}}

@foreach($heroSlides as $index => $slide)
    <div class="slide-item" data-index="{{ $index }}">
        @if(isset($slide['image']))
            {!! responsiveImage(
                $slide['image'],
                $slide['title'] ?? 'Slide ' . ($index + 1),
                'slide-image'
            ) !!}
        @endif
        <div class="slide-content">
            <h3>{{ $slide['title'] ?? '' }}</h3>
            <p>{{ $slide['subtitle'] ?? '' }}</p>
        </div>
    </div>
@endforeach


{{-- ============================================= --}}
{{-- EXAMPLE 7: Different Sizes for Different Contexts --}}
{{-- ============================================= --}}

{{-- Thumbnail (use small size) --}}
<div class="thumbnail">
    <img src="{{ getResponsiveImageUrl($product['image'], 'small') }}" 
         alt="{{ $product['name'] }}"
         class="thumbnail-img">
</div>

{{-- Card (use medium size) --}}
<div class="card">
    {!! responsiveImage($product['image'], $product['name'], 'card-img-top') !!}
</div>

{{-- Full width banner (use xl size for background) --}}
<div class="hero-banner" style="{{ getResponsiveBackgroundStyle($banner['image'], 'background-size: cover; min-height: 500px;') }}">
    <div class="hero-content">
        <h1>{{ $banner['title'] }}</h1>
    </div>
</div>


{{-- ============================================= --}}
{{-- EXAMPLE 8: With Fallback to Default Image     --}}
{{-- ============================================= --}}

@php
    // If no custom image is set, use default theme image
    $heroImage = $heroSlide['image'] ?? 'themes/torganic/assets/images/default-hero.jpg';
@endphp

<section class="hero" style="{{ getResponsiveBackgroundStyle($heroImage, 'background-size: cover; background-position: center;') }}">
    <div class="container">
        <h1>{{ $heroSlide['title'] ?? 'Welcome to our store' }}</h1>
    </div>
</section>


{{-- ============================================= --}}
{{-- TIPS AND BEST PRACTICES                       --}}
{{-- ============================================= --}}

{{--
1. Always use {!! !!} for responsiveImage() helper (not {{ }})
   Because it returns HTML that should not be escaped

2. For backgrounds, use getResponsiveBackgroundStyle()
   This automatically uses the XL size for best quality

3. For regular images, use responsiveImage() helper
   This generates proper srcset and sizes attributes

4. The helpers handle both:
   - New format: array of sizes
   - Old format: single path string
   So no need to check the format!

5. For lazy loading, you can still add it manually:
   {!! responsiveImage($image, 'Alt text', 'my-class', 'width: 100%;') !!}
   Then in your CSS or JS, add: loading="lazy"

6. Browser will automatically pick the right size based on:
   - Screen width
   - Device pixel ratio
   - Network speed (in modern browsers)

7. Performance tip: Use 'small' size for thumbnails
   <img src="{{ getResponsiveImageUrl($image, 'small') }}" alt="Thumbnail">
--}}

