@extends('themes.torganic.layouts.app')

@section('title', $category->name . ' - ' . config('app.name'))
@section('description', $category->description ?? 'تصفح منتجات ' . $category->name)

@section('content')
<!-- Page Header -->
<div class="page-header" style="background-color: #f8f9fa; padding: 60px 0 30px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="page-header__title">{{ $category->name }}</h1>
                @if($category->description)
                <p class="page-header__subtitle mt-2">{{ $category->description }}</p>
                @endif
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">المنتجات</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Products Section -->
<section class="product-listing padding-top padding-bottom">
    <div class="container">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="product-sidebar">
                    <!-- Categories Filter -->
                    @if(isset($categories) && $categories->isNotEmpty())
                    <div class="product-sidebar__widget">
                        <h4 class="product-sidebar__title">الأقسام</h4>
                        <ul class="product-sidebar__list">
                            <li>
                                <a href="{{ route('products.index') }}" class="">
                                    جميع الأقسام
                                </a>
                            </li>
                            @foreach($categories as $cat)
                            <li>
                                <a href="{{ route('category.show', $cat->slug) }}" 
                                   class="{{ $cat->id == $category->id ? 'active' : '' }}">
                                    {{ $cat->name }}
                                    <span class="count">({{ $cat->products_count ?? 0 }})</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Price Filter -->
                    <div class="product-sidebar__widget">
                        <h4 class="product-sidebar__title">السعر</h4>
                        <form action="{{ route('category.show', $category->slug) }}" method="GET">
                            <div class="price-range">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <input type="number" name="min_price" class="form-control" placeholder="من" value="{{ request('min_price') }}">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" name="max_price" class="form-control" placeholder="إلى" value="{{ request('max_price') }}">
                                    </div>
                                </div>
                                <button type="submit" class="trk-btn trk-btn--outline w-100 mt-3">تطبيق</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="col-lg-9">
                <!-- Sort & Filter Bar -->
                <div class="product-toolbar mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p class="product-toolbar__results">
                                عرض {{ $products->count() }} من أصل {{ $products->total() }} منتج
                            </p>
                        </div>
                        <div class="col-md-6">
                            <form action="{{ route('category.show', $category->slug) }}" method="GET" class="d-flex justify-content-md-end">
                                @if(request('min_price'))
                                <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                                @endif
                                @if(request('max_price'))
                                <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                                @endif
                                <select name="sort" class="form-select" style="width: auto;" onchange="this.form.submit()">
                                    <option value="">الترتيب الافتراضي</option>
                                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>السعر: من الأقل للأعلى</option>
                                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>السعر: من الأعلى للأقل</option>
                                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>الاسم: أ-ي</option>
                                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>الاسم: ي-أ</option>
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>الأحدث</option>
                                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>الأكثر مبيعاً</option>
                                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>الأعلى تقييماً</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                @if($products->isNotEmpty())
                <div class="row row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-2 g-4">
                    @foreach($products as $product)
                    <div class="col">
                        <div class="product__item product__item--style2">
                            <div class="product__item-inner">
                                @if($product->discount_percentage > 0)
                                <div class="product__item-badge">
                                    -{{ $product->discount_percentage }}%
                                </div>
                                @endif
                                <div class="product__item-thumb">
                                    <a href="{{ route('products.show', $product->slug) }}">
                                        @if($product->image)
                                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                        @else
                                            <img src="{{ asset('themes/torganic/assets/images/product/popular/1.png') }}" alt="{{ $product->name }}">
                                        @endif
                                    </a>
                                </div>
                                <div class="product__item-content">
                                    <h5><a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a></h5>
                                    <div class="product__item-rating">
                                        <i class="fa-solid fa-star"></i> {{ $product->reviews_avg_rating ? number_format($product->reviews_avg_rating, 1) : '5.0' }} 
                                        <span>({{ $product->reviews_count ?? 0 }} تقييم)</span>
                                    </div>
                                    <div class="product__item-footer">
                                        <div class="product__item-price">
                                            <h4>{{ number_format($product->price, 2) }} ر.س</h4>
                                            @if($product->old_price > $product->price)
                                            <span><del>{{ number_format($product->old_price, 2) }} ر.س</del></span>
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

                <!-- Pagination -->
                <div class="pagination-wrapper mt-5">
                    {{ $products->appends(request()->query())->links() }}
                </div>
                @else
                <div class="alert alert-info text-center">
                    <i class="fa-solid fa-info-circle"></i> لا توجد منتجات في هذا القسم حالياً.
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

@if(isset($flashSaleProducts) && $flashSaleProducts->isNotEmpty())
<!-- Flash Sale Section -->
<section class="flash-sale padding-top padding-bottom" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-header__title">عروض خاصة من {{ $category->name }}</h2>
            <p class="section-header__subtitle">منتجات مميزة بأسعار خاصة</p>
        </div>
        <div class="row row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-2 g-4 mt-4">
            @foreach($flashSaleProducts as $product)
            <div class="col">
                <div class="product__item product__item--style2">
                    <div class="product__item-inner">
                        @if($product->discount_percentage > 0)
                        <div class="product__item-badge">
                            -{{ $product->discount_percentage }}%
                        </div>
                        @endif
                        <div class="product__item-thumb">
                            <a href="{{ route('products.show', $product->slug) }}">
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                @else
                                    <img src="{{ asset('themes/torganic/assets/images/product/popular/1.png') }}" alt="{{ $product->name }}">
                                @endif
                            </a>
                        </div>
                        <div class="product__item-content">
                            <h5><a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a></h5>
                            <div class="product__item-rating">
                                <i class="fa-solid fa-star"></i> {{ $product->reviews_avg_rating ? number_format($product->reviews_avg_rating, 1) : '5.0' }} 
                                <span>({{ $product->reviews_count ?? 0 }} تقييم)</span>
                            </div>
                            <div class="product__item-footer">
                                <div class="product__item-price">
                                    <h4>{{ number_format($product->price, 2) }} ر.س</h4>
                                    @if($product->old_price > $product->price)
                                    <span><del>{{ number_format($product->old_price, 2) }} ر.س</del></span>
                                    @endif
                                </div>
                                <div class="product__item-action">
                                    <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
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
</section>
@endif

@endsection

