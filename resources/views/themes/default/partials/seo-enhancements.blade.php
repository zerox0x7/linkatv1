{{-- تحسينات SEO إضافية --}}

@php
    // التحقق من وجود المتغيرات المطلوبة
    $storeName = $storeName ?? \App\Models\Setting::get('store_name', config('app.name'));
    $productName = $product->name ?? '';
    $productDescription = $product->meta_description ?? strip_tags(Str::limit($product->description ?? '', 160));
    $productImage = $product->image_url ? asset($product->image_url) : asset('images/default-product.png');
    $productPrice = $product->discount_price ?? $product->price ?? 0;
    $productStatus = $product->status ?? 'in-stock';
    $productRating = number_format($product->rating ?? 0, 1);
    $reviewsCount = $product->reviews_count ?? ($product->sales_count > 0 ? $product->sales_count : 1);
    $productSlug = $product->slug ?? '';
    $productSku = $product->sku ?? $product->id ?? '';
@endphp

{{-- 1. تحسين هيكل البيانات (Structured Data) --}}
<script type="application/ld+json">
{
    "@context": "https://schema.org/",
    "@type": "Product",
    "name": "{{ $productName }}",
    "image": "{{ $productImage }}",
    "description": "{{ $productDescription }}",
    "sku": "{{ $productSku }}",
    "mpn": "{{ $productSku }}",
    "brand": {
        "@type": "Brand",
        "name": "{{ $storeName }}"
    },
    "offers": {
        "@type": "Offer",
        "url": "{{ route('products.show', $productSlug) }}",
        "priceCurrency": "SAR",
        "price": "{{ $productPrice }}",
        "priceValidUntil": "{{ now()->addMonths(1)->format('Y-m-d') }}",
        "availability": "{{ $productStatus == 'out-of-stock' ? 'https://schema.org/OutOfStock' : 'https://schema.org/InStock' }}",
        "seller": {
            "@type": "Organization",
            "name": "{{ $storeName }}"
        }
    },
    "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "{{ $productRating }}",
        "reviewCount": "{{ $reviewsCount }}"
    },
    "breadcrumb": {
        "@type": "BreadcrumbList",
        "itemListElement": [{
            "@type": "ListItem",
            "position": 1,
            "name": "الرئيسية",
            "item": "{{ route('home') }}"
        }, {
            "@type": "ListItem",
            "position": 2,
            "name": "المنتجات",
            "item": "{{ route('products.index') }}"
        }@if(isset($product->category) && $product->category), {
            "@type": "ListItem",
            "position": 3,
            "name": "{{ $product->category->name }}",
            "item": "{{ route('products.index', ['category' => $product->category->slug]) }}"
        }@endif, {
            "@type": "ListItem",
            "position": {{ isset($product->category) && $product->category ? 4 : 3 }},
            "name": "{{ $productName }}",
            "item": "{{ route('products.show', $productSlug) }}"
        }]
    }
}
</script>

{{-- 2. تحسينات Meta Tags --}}
<meta name="author" content="{{ $storeName }}">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
<meta name="revisit-after" content="7 days">
<meta name="language" content="ar">
<meta name="geo.region" content="SA">
<meta name="geo.placename" content="Saudi Arabia">

{{-- 3. تحسينات Open Graph إضافية --}}
<meta property="og:site_name" content="{{ $storeName }}">
<meta property="og:locale" content="ar_SA">
<meta property="og:type" content="product">
<meta property="product:price:amount" content="{{ $productPrice }}">
<meta property="product:price:currency" content="SAR">
<meta property="product:availability" content="{{ $productStatus == 'out-of-stock' ? 'out of stock' : 'in stock' }}">
<meta property="product:condition" content="new">

{{-- 4. تحسينات Twitter Cards --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@{{ str_replace(' ', '', $storeName) }}">
<meta name="twitter:creator" content="@{{ str_replace(' ', '', $storeName) }}">
<meta name="twitter:title" content="{{ $productName }} - {{ $storeName }}">
<meta name="twitter:description" content="{{ $productDescription }}">
<meta name="twitter:image" content="{{ $productImage }}">

{{-- 5. تحسينات إضافية للصور --}}
<link rel="image_src" href="{{ $productImage }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="{{ $productName }}">

{{-- 6. تحسينات للروابط --}}
<link rel="alternate" hreflang="ar" href="{{ route('products.show', $productSlug) }}">
<link rel="alternate" hreflang="x-default" href="{{ route('products.show', $productSlug) }}">

{{-- 7. تحسينات للتنقل --}}
@if(isset($relatedProducts) && method_exists($relatedProducts, 'nextPageUrl'))
<link rel="next" href="{{ $relatedProducts->nextPageUrl() }}">
<link rel="prev" href="{{ $relatedProducts->previousPageUrl() }}">
@endif

{{-- 8. تحسينات للبيانات المنظمة الإضافية --}}
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebPage",
    "name": "{{ $productName }} - {{ $storeName }}",
    "description": "{{ $productDescription }}",
    "publisher": {
        "@type": "Organization",
        "name": "{{ $storeName }}",
        "logo": {
            "@type": "ImageObject",
            "url": "{{ asset('images/logo.png') }}"
        }
    },
    "mainEntity": {
        "@type": "Product",
        "name": "{{ $productName }}",
        "image": "{{ $productImage }}",
        "description": "{{ $productDescription }}"
    }
}
</script>

{{-- 9. تحسينات للأداء --}}
<link rel="preload" href="{{ $productImage }}" as="image">
<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="dns-prefetch" href="https://fonts.googleapis.com">
<link rel="dns-prefetch" href="https://fonts.gstatic.com">

{{-- 10. تحسينات للتوافق مع الأجهزة المحمولة --}}
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
<meta name="theme-color" content="#000000">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black"> 