@extends('theme::layouts.app')

@php
    $storeName = \App\Models\Setting::get('store_name');
    $storeDescription = \App\Models\Setting::get('store_description');
    $storeKeywords = \App\Models\Setting::get('store_keywords');
@endphp

@if($storeName)
    @section('title', $storeName)
@endif

@if($storeDescription)
    @section('meta_description', $storeDescription)
@endif

@if($storeKeywords)
    @section('meta_keywords', $storeKeywords)
@endif

@section('head_scripts')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Store",
  "name": "{{ $storeName }}",
  "url": "{{ url('/') }}",
  "logo": "{{ asset('storage/' . (\App\Models\Setting::get('store_logo', 'logos/logo.png'))) }}",
  "description": "{{ $storeDescription }}",
  @if(\App\Models\Setting::get('store_phone'))
  "telephone": "{{ \App\Models\Setting::get('store_phone') }}",
  @endif
  @if(\App\Models\Setting::get('store_email'))
  "email": "{{ \App\Models\Setting::get('store_email') }}",
  @endif
  @if(\App\Models\Setting::get('store_address'))
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "{{ \App\Models\Setting::get('store_address') }}"
  },
  @endif
  @if(\App\Models\Setting::get('store_facebook') || \App\Models\Setting::get('store_twitter') || \App\Models\Setting::get('store_instagram'))
  "sameAs": [
    @if(\App\Models\Setting::get('store_facebook'))
      "{{ \App\Models\Setting::get('store_facebook') }}"@if(\App\Models\Setting::get('store_twitter') || \App\Models\Setting::get('store_instagram')), @endif
    @endif
    @if(\App\Models\Setting::get('store_twitter'))
      "{{ \App\Models\Setting::get('store_twitter') }}"@if(\App\Models\Setting::get('store_instagram')), @endif
    @endif
    @if(\App\Models\Setting::get('store_instagram'))
      "{{ \App\Models\Setting::get('store_instagram') }}"
    @endif
  ],
  @endif
  "image": "{{ asset('storage/' . (\App\Models\Setting::get('store_logo', 'logos/logo.png'))) }}"
}
</script>
@endsection

@section('content')
<!-- Hero Section with Swiper Slider -->
<div class="container mx-auto px-4 mt-6">
    <div class="swiper hero-swiper rounded-lg overflow-hidden">
        <div class="swiper-wrapper">
            @if($sliders->count() > 0)
                @foreach($sliders as $slider)
                <div class="swiper-slide relative h-[400px]" style="background-image: url('{{ $slider->image_url }}'); background-size: cover; background-position: center;">
                    <div class="absolute inset-0 hero-gradient"></div>
                    <div class="absolute inset-0 flex items-center">
                        <div class="container mx-auto px-8 md:px-12">
                            <div class="max-w-xl">
                                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 text-shadow">{{ $slider->title }}</h1>
                                @if($slider->subtitle)
                                <p class="text-lg text-gray-200 mb-6 text-shadow">{{ $slider->subtitle }}</p>
                                @endif
                                <div class="flex space-x-4 space-x-reverse">
                                    @if($slider->button_text)
                                    <a href="{{ $slider->link ?? route('products.index') }}" class="bg-gradient-to-r from-primary to-secondary text-white px-6 py-3 rounded-button font-medium whitespace-nowrap hover:opacity-90 transition-all neon-glow">
                                        {{ $slider->button_text }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <!-- Default Slide if no sliders in database -->
                <div class="swiper-slide relative h-[400px]" style="background-image: url('https://placehold.co/1200x400/121212/2196F3.png'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 hero-gradient"></div>
        <div class="absolute inset-0 flex items-center">
            <div class="container mx-auto px-8 md:px-12">
                <div class="max-w-xl">
                                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 text-shadow">أفضل حسابات الألعاب والسوشيال ميديا</h1>
                                <p class="text-lg text-gray-200 mb-6 text-shadow">احصل على حسابات متميزة بأسعار تنافسية وضمان الجودة. تسوق الآن واستمتع بتجربة شراء آمنة وسريعة.</p>
                    <div class="flex space-x-4 space-x-reverse">
                        <a href="{{ route('products.index') }}" class="bg-gradient-to-r from-primary to-secondary text-white px-6 py-3 rounded-button font-medium whitespace-nowrap hover:opacity-90 transition-all neon-glow">
                            تصفح الحسابات
                        </a>
                        <a href="{{ route('products.featured') }}" class="bg-[#1e1e1e] bg-opacity-80 text-white border border-gray-600 px-6 py-3 rounded-button font-medium whitespace-nowrap hover:bg-opacity-100 transition-all">
                            عروض خاصة
                        </a>
                    </div>
                </div>
            </div>
        </div>
                </div>
            @endif
        </div>
        
        <!-- Pagination and Navigation -->
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev text-white"></div>
        <div class="swiper-button-next text-white"></div>
    </div>
</div>

<!-- Main Content -->
<div class="container mx-auto px-4 mt-8">
    <!-- عرض الأقسام الديناميكية -->
    @foreach($homeSections as $section)
        @if($section->type == 'custom_content')
            @continue
        @endif
        @if($section->type == 'browse_categories')
            <div class="container mx-auto px-4 mt-16 mb-20">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-2xl font-bold text-white mb-0">{{ $section->title }}</h2>
                    <a href="{{ route('products.index') }}" class="text-primary hover:text-secondary transition-colors">
                        عرض الكل <i class="ri-arrow-left-line align-middle"></i>
                    </a>
                </div>
                @if($section->subtitle && $section->subtitle != $section->title)
                    <p class="text-gray-400 mb-4">{{ $section->subtitle }}</p>
                @endif
                @php
                    $maxCategories = 12;
                    $categoriesToShow = $categories->take($maxCategories);
                @endphp
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                    @foreach($categoriesToShow as $category)
                        <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="glass-effect rounded-lg p-4 text-center transition-all duration-300 card-hover cursor-pointer">
                            <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-gradient-to-r from-primary to-secondary flex items-center justify-center">
                                <i class="{{ $category->icon ?? 'ri-gamepad-line' }} text-white text-2xl"></i>
                            </div>
                            <h3 class="text-white font-bold">{{ $category->name }}</h3>
                        </a>
                    @endforeach
                </div>
            </div>
            @continue
        @endif
        <div class="w-full mb-16">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-white">{{ $section->title }}</h2>
                
                @switch($section->type)
                    @case('featured')
                <a href="{{ route('products.featured') }}" class="text-primary hover:text-secondary transition-colors">
                    عرض الكل <i class="ri-arrow-left-line align-middle"></i>
                </a>
                        @break
                    @case('latest')
                        <a href="{{ route('products.index', ['sort' => 'latest']) }}" class="text-primary hover:text-secondary transition-colors">
                            عرض الكل <i class="ri-arrow-left-line align-middle"></i>
                        </a>
                        @break
                    @case('best_sellers')
                        <a href="{{ route('products.best-sellers') }}" class="text-primary hover:text-secondary transition-colors">
                            عرض الكل <i class="ri-arrow-left-line align-middle"></i>
                        </a>
                        @break
                    @case('category')
                        @if($section->category)
                            <a href="{{ route('products.index', ['category' => $section->category->slug]) }}" class="text-primary hover:text-secondary transition-colors">
                                عرض الكل <i class="ri-arrow-left-line align-middle"></i>
                            </a>
                        @endif
                        @break
                    @case('all')
                        <a href="{{ route('products.index') }}" class="text-primary hover:text-secondary transition-colors">
                            عرض الكل <i class="ri-arrow-left-line align-middle"></i>
                        </a>
                        @break
                    @case('custom')
                        @if($section->getSetting('cta_link'))
                            <a href="{{ $section->getSetting('cta_link') }}" class="text-primary hover:text-secondary transition-colors">
                                {{ $section->getSetting('cta_text', 'عرض المزيد') }} <i class="ri-arrow-left-line align-middle"></i>
                            </a>
                        @endif
                        @break
                    @case('store_features')
                        @if(isset($section->settings['features']) && is_array($section->settings['features']))
                            <a href="{{ route('products.index') }}" class="text-primary hover:text-secondary transition-colors">
                                عرض الكل <i class="ri-arrow-left-line align-middle"></i>
                            </a>
                        @endif
                        @break
                    @case('testimonials')
                        @break
                    @default
                        @break
                @endswitch
                </div>
            
            <!-- عرض المنتجات حسب نوع القسم والنمط المختار -->
            @php
                $products = $section->getProducts($section->getSetting('products_limit', 8),$storeId);
                $displayStyle = $section->getSetting('display_style', 'grid');
            @endphp
            
            @if($section->type == 'custom')
                <div class="relative rounded-lg overflow-hidden bg-[#121212] min-h-[220px] sm:min-h-[300px]">
                    @php
                        $enableCustomSize = $section->getSetting('enable_custom_image_size');
                        $maxHeight = $enableCustomSize ? ($section->getSetting('custom_image_max_height', 400)) : 400;
                    @endphp
                    @if($section->getSetting('background_image'))
                        <img 
                            src="{{ asset('storage/' . $section->getSetting('background_image')) }}" 
                            alt="صورة الخلفية" 
                            class="absolute inset-0 w-full h-full object-cover"
                            style="opacity: {{ number_format(($section->getSetting('image_opacity', 100) / 100), 2) }}; max-height:{{ $maxHeight }}px;"
                        >
                    @endif
                    <!-- طبقة لون الخلفية فوق الصورة بالكامل -->
                    <div class="absolute inset-0" style="
                        background-color: {{ $section->getSetting('background_color', '#121212') }};
                        opacity: {{ number_format(($section->getSetting('bg_opacity', 80) / 100), 2) }};
                        pointer-events: none;
                    "></div>
                    <div class="relative z-10 flex flex-col justify-center items-center h-full p-4 sm:p-8 text-center">
                        <div class="prose prose-invert mx-auto mb-4 w-full">
                            {!! $section->getSetting('custom_content') !!}
                        </div>
                        @if($section->getSetting('cta_link') && $section->getSetting('cta_text'))
                            <a href="{{ $section->getSetting('cta_link') }}"
                               class="bg-gradient-to-r from-primary to-secondary text-white px-6 py-3 rounded-button font-medium inline-block hover:opacity-90 transition-all neon-glow w-full max-w-xs"
                               style="min-width: 120px; text-align: center;">
                                {{ $section->getSetting('cta_text') }}
                            </a>
                        @endif
                    </div>
                </div>
            @elseif($displayStyle === 'slider')
                <!-- عرض السلايدر -->
                <div class="swiper section-swiper-{{ $section->id }}">
                    <div class="swiper-wrapper py-4">
                        @forelse($products as $product)
                            <div class="swiper-slide">
                                <div class="glass-effect rounded-lg overflow-hidden transition-all duration-300 card-hover h-full">
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
                                        @elseif($product->has_discount)
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
                                            @if($product->reviews_avg_rating && $product->reviews_avg_rating > 0)
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
                            </div>
                        @empty
                            <div class="col-span-full text-center p-8">
                                <i class="ri-inbox-2-line text-5xl text-gray-400 mb-4"></i>
                                <p class="text-gray-400">لا توجد منتجات متاحة في هذا القسم حالياً.</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next !text-primary after:content-['']">
                        <i class="ri-arrow-right-s-line text-2xl"></i>
                    </div>
                    <div class="swiper-button-prev !text-primary after:content-['']">
                        <i class="ri-arrow-left-s-line text-2xl"></i>
                    </div>
                </div>
            @elseif($section->type == 'store_features')
                <div class="relative rounded-lg overflow-hidden">
                    @if($section->getSetting('background_image'))
                        <div class="absolute inset-0 bg-cover bg-center" style="
                            background-image: url('{{ asset('storage/' . $section->getSetting('background_image')) }}');
                            opacity: {{ number_format(($section->getSetting('image_opacity', 70) / 100), 2) }};
                        "></div>
                    @endif
                    <div class="absolute inset-0" style="
                        background-color: {{ $section->getSetting('background_color', '#121212') }};
                        opacity: {{ number_format(($section->getSetting('bg_opacity', 80) / 100), 2) }};
                    "></div>
                    <div class="relative z-10 p-8 md:p-12">
                        <div class="container mx-auto px-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                @for($i = 1; $i <= 4; $i++)
                                    @php
                                        $title = $section->settings['feature_'.$i.'_title'] ?? null;
                                        $desc = $section->settings['feature_'.$i.'_description'] ?? null;
                                        $icon = $section->settings['feature_'.$i.'_icon'] ?? null;
                                    @endphp
                                    @if($title || $desc || $icon)
                                        <div class="glass-effect rounded-lg p-6 text-center">
                                            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-r from-primary to-secondary flex items-center justify-center">
                                                <i class="{{ $icon }} text-white text-2xl"></i>
                                            </div>
                                            <h3 class="text-xl font-bold text-white mb-2">{{ $title }}</h3>
                                            <p class="text-gray-400">{{ $desc }}</p>
                                        </div>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($section->type == 'testimonials')
                @if(isset($reviews) && $reviews->count() > 0)
                    <div class="container mx-auto px-4 mt-12">
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-white mb-2">آراء عملائنا</h2>
                            <p class="text-gray-400">تعرف على تجارب عملائنا السابقين مع متجرنا</p>
                        </div>
                        <div class="swiper testimonials-swiper">
                            <div class="swiper-wrapper">
                                @foreach($reviews as $review)
                                    <div class="swiper-slide">
                                        <div class="glass-effect rounded-lg p-5">
                                            <div class="flex text-yellow-400 mb-3">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        <i class="ri-star-fill"></i>
                                                    @elseif($i - 0.5 == $review->rating)
                                                        <i class="ri-star-half-fill"></i>
                                                    @else
                                                        <i class="ri-star-line"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <p class="text-gray-300 mb-4">"{{ $review->review }}"</p>
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center ml-3">
                                                    <span class="text-white font-bold">{{ $review->name ? mb_substr($review->name, 0, 1) : 'م' }}</span>
                                                </div>
                                                <div>
                                                    <h4 class="text-white font-medium">{{ $review->name ?? 'مستخدم' }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                @endif
            @else

            
                <!-- عرض الشبكة -->
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @forelse($products as $product)
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
                            @elseif($product->has_discount)
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
                            @if($product->reviews_avg_rating && $product->reviews_avg_rating > 0)
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
                    @empty
                        <div class="col-span-full text-center p-8">
                            <i class="ri-inbox-2-line text-5xl text-gray-400 mb-4"></i>
                            <p class="text-gray-400">لا توجد منتجات متاحة في هذا القسم حالياً.</p>
                        </div>
                    @endforelse
                </div>
                @endif
        </div>
    @endforeach
    
    <!-- إذا لم تكن هناك أقسام، عرض الأقسام الثابتة الافتراضية -->
    @if($homeSections->isEmpty())
        <!-- الأقسام الثابتة الافتراضية تم إزالتها، الرجاء إضافة أقسام من خلال لوحة التحكم -->
    @endif
</div>

@foreach($homeSections as $section)
    @php
        $products = $section->getProducts($section->getSetting('products_limit', 8),$storeId);
    @endphp

    @if($products && count($products) > 0)
        @push('head_scripts')
        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "ItemList",
          "itemListElement": [
            @foreach($products as $index => $product)
            {
              "@type": "ListItem",
              "position": {{ $index + 1 }},
              "url": "{{ url('/products/' . $product->slug) }}"
            }@if(!$loop->last),@endif
            @endforeach
          ]
        }
        </script>
        @endpush
    @endif
@endforeach

@endsection 

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hero Slider
        const heroSwiper = new Swiper('.hero-swiper', {
            slidesPerView: 1,
            spaceBetween: 0,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.hero-swiper .swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.hero-swiper .swiper-button-next',
                prevEl: '.hero-swiper .swiper-button-prev',
            },
        });
        
        // تهيئة السلايدر لكل قسم ديناميكي
        @foreach($homeSections as $section)
            @if($section->getSetting('display_style', 'grid') === 'slider')
                new Swiper('.section-swiper-{{ $section->id }}', {
                    slidesPerView: 1,
                    spaceBetween: 16,
                    pagination: {
                        el: '.section-swiper-{{ $section->id }} .swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.section-swiper-{{ $section->id }} .swiper-button-next',
                        prevEl: '.section-swiper-{{ $section->id }} .swiper-button-prev',
                    },
                    breakpoints: {
                        640: {
                            slidesPerView: 2,
                        },
                        1024: {
                            slidesPerView: 4,
                        },
                    },
                });
            @endif
        @endforeach
        
        // Best Sellers Slider
        const bestSellersSwiper = new Swiper('.best-sellers-swiper', {
            slidesPerView: 1,
            spaceBetween: 16,
            pagination: {
                el: '.best-sellers-swiper .swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 4,
                },
            },
        });
        
        // Testimonials Slider (مخصص)
        if(document.querySelector('.testimonials-swiper')) {
            new Swiper('.testimonials-swiper', {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: {{ isset($reviews) && $reviews->count() > 1 ? 'true' : 'false' }},
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.testimonials-swiper .swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 24,
                    },
                },
            });
        }
    });
</script>
@endpush 