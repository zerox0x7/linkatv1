@extends('themes.torganic.layouts.app')

@section('title', 'نتائج البحث - ' . config('app.name'))

@section('content')
<!-- Page Header -->
<div class="page-header" style="background-color: #f8f9fa; padding: 60px 0 30px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="page-header__title">نتائج البحث</h1>
                @if(request('q'))
                <p class="lead">نتائج البحث عن: <strong>"{{ request('q') }}"</strong></p>
                @endif
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">البحث</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Search Results Section -->
<section class="product-search padding-top padding-bottom">
    <div class="container">
        <!-- Search Box -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8">
                <form action="{{ route('products.search') }}" method="GET">
                    <div class="input-group input-group-lg">
                        <input type="text" name="q" class="form-control" placeholder="ابحث عن منتج..." value="{{ request('q') }}" required>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-magnifying-glass"></i> بحث
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if(isset($products))
        <!-- Results Count -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="mb-0">
                        @if($products->total() > 0)
                        تم العثور على <strong>{{ $products->total() }}</strong> نتيجة
                        @else
                        لم يتم العثور على نتائج
                        @endif
                    </p>
                    
                    @if($products->total() > 0)
                    <form action="{{ route('products.search') }}" method="GET" class="d-flex">
                        <input type="hidden" name="q" value="{{ request('q') }}">
                        <select name="sort" class="form-select" style="width: auto;" onchange="this.form.submit()">
                            <option value="">الترتيب الافتراضي</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>السعر: من الأقل للأعلى</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>السعر: من الأعلى للأقل</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>الاسم: أ-ي</option>
                        </select>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        @if($products->isNotEmpty())
        <div class="row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 g-4">
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
                            <a href="{{ route('products.show', $product->slug ?? $product->share_slug ?? $product->id) }}">
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                @else
                                    <img src="{{ asset('themes/torganic/assets/images/product/popular/1.png') }}" alt="{{ $product->name }}">
                                @endif
                            </a>
                        </div>
                        <div class="product__item-content">
                            <h5><a href="{{ route('products.show', $product->slug ?? $product->share_slug ?? $product->id) }}">{{ $product->name }}</a></h5>
                            <div class="product__item-rating">
                                <i class="fa-solid fa-star"></i> {{ $product->rating ?? 5.0 }} 
                                <span>({{ $product->reviews_count ?? 0 }} تقييم)</span>
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

        <!-- Pagination -->
        <div class="pagination-wrapper mt-5">
            {{ $products->appends(request()->query())->links() }}
        </div>
        @else
        <!-- No Results -->
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info text-center p-5">
                    <i class="fa-solid fa-search fa-3x mb-3"></i>
                    <h4>لم يتم العثور على نتائج</h4>
                    <p class="mb-4">عذراً، لم نتمكن من العثور على منتجات تطابق بحثك. جرب كلمات مختلفة أو تصفح أقسامنا.</p>
                    <a href="{{ route('products.index') }}" class="trk-btn trk-btn--primary">تصفح جميع المنتجات</a>
                </div>
            </div>
        </div>
        @endif
        @endif
    </div>
</section>
@endsection

