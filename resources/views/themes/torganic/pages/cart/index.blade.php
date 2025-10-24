@extends('themes.torganic.layouts.app')

@section('title', 'سلة التسوق - ' . config('app.name'))

@section('content')
<!-- Page Header -->
<div class="page-header" style="background-color: #f8f9fa; padding: 60px 0 30px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="page-header__title">سلة التسوق</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">السلة</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Cart Section -->
<section class="cart padding-top padding-bottom">
    <div class="container">
        @if(isset($cartItems) && $cartItems->isNotEmpty())
        <div class="row g-4">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="cart__wrapper">
                    <div class="table-responsive">
                        <table class="table cart__table">
                            <thead>
                                <tr>
                                    <th>المنتج</th>
                                    <th>السعر</th>
                                    <th>الكمية</th>
                                    <th>المجموع</th>
                                    <th>حذف</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $item)
                                <tr>
                                    <td>
                                        <div class="cart__product">
                                            <div class="cart__product-thumb">
                                                @if($item->cartable && $item->cartable->image)
                                                    <img src="{{ Storage::url($item->cartable->image) }}" alt="{{ $item->cartable->name }}">
                                                @else
                                                    <img src="{{ asset('themes/torganic/assets/images/product/cart/1.png') }}" alt="{{ $item->cartable->name ?? 'منتج' }}">
                                                @endif
                                            </div>
                                            <div class="cart__product-content">
                                                <h6><a href="{{ route('products.show', $item->cartable->id ?? $item->cartable_id) }}">{{ $item->cartable->name ?? 'منتج غير محدد' }}</a></h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="cart__price">{{ number_format($item->price, 2) }} ر.س</span>
                                    </td>
                                    <td>
                                        <div class="cart__quantity">
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="quantity-form">
                                                @csrf
                                                @method('PUT')
                                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->cartable->stock ?? 999 }}" class="form-control quantity-input" onchange="this.form.submit()">
                                            </form>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="cart__subtotal">{{ number_format($item->price * $item->quantity, 2) }} ر.س</span>
                                    </td>
                                    <td>
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="cart__remove-btn" onclick="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Cart Actions -->
                    <div class="cart__actions mt-4">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('products.index') }}" class="trk-btn trk-btn--outline">
                                    <i class="fa-solid fa-arrow-right me-2"></i> متابعة التسوق
                                </a>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="trk-btn trk-btn--outline" onclick="return confirm('هل أنت متأكد من تفريغ السلة؟')">
                                        <i class="fa-solid fa-trash-can me-2"></i> تفريغ السلة
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="col-lg-4">
                <div class="cart__summary">
                    <h4 class="cart__summary-title mb-4">ملخص الطلب</h4>
                    
                    <div class="cart__summary-item">
                        <span>المجموع الفرعي:</span>
                        <span>{{ number_format($subtotal ?? 0, 2) }} ر.س</span>
                    </div>
                    
                    <div class="cart__summary-item">
                        <span>الشحن:</span>
                        <span>{{ number_format($shipping ?? 0, 2) }} ر.س</span>
                    </div>

                    @if(isset($discount) && $discount > 0)
                    <div class="cart__summary-item text-success">
                        <span>الخصم:</span>
                        <span>-{{ number_format($discount, 2) }} ر.س</span>
                    </div>
                    @endif

                    <div class="cart__summary-item cart__summary-total">
                        <span>المجموع الكلي:</span>
                        <span>{{ number_format($total ?? 0, 2) }} ر.س</span>
                    </div>

                    <!-- Coupon Code -->
                    <div class="cart__coupon mt-4">
                        <form action="{{ route('cart.apply-coupon') }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="coupon_code" class="form-control" placeholder="رمز الكوبون" value="{{ session('coupon_code') }}">
                                <button type="submit" class="btn btn-primary">تطبيق</button>
                            </div>
                        </form>
                    </div>

                    <!-- Checkout Button -->
                    <div class="cart__checkout mt-4">
                        <a href="{{ route('checkout.index') }}" class="trk-btn trk-btn--primary w-100">
                            متابعة إلى الدفع <i class="fa-solid fa-arrow-left ms-2"></i>
                        </a>
                    </div>

                    <!-- Payment Methods -->
                    <div class="cart__payment-methods mt-4">
                        <p class="text-muted small text-center">طرق الدفع المتاحة:</p>
                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                            <img src="{{ asset('themes/torganic/assets/images/payment/1.png') }}" alt="Visa" style="height: 30px;">
                            <img src="{{ asset('themes/torganic/assets/images/payment/2.png') }}" alt="Mastercard" style="height: 30px;">
                            <img src="{{ asset('themes/torganic/assets/images/payment/3.png') }}" alt="Paypal" style="height: 30px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- Empty Cart -->
        <div class="row">
            <div class="col-12">
                <div class="cart__empty text-center p-5">
                    <i class="fa-solid fa-cart-shopping fa-5x text-muted mb-4"></i>
                    <h3>سلة التسوق فارغة</h3>
                    <p class="text-muted mb-4">لم تقم بإضافة أي منتجات إلى السلة بعد</p>
                    <a href="{{ route('products.index') }}" class="trk-btn trk-btn--primary">
                        ابدأ التسوق الآن
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
.cart__table {
    background: #fff;
}
.cart__table th {
    background: #f8f9fa;
    padding: 15px;
    font-weight: 600;
}
.cart__table td {
    padding: 15px;
    vertical-align: middle;
}
.cart__product {
    display: flex;
    align-items: center;
    gap: 15px;
}
.cart__product-thumb {
    width: 80px;
    height: 80px;
    overflow: hidden;
    border-radius: 8px;
}
.cart__product-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.cart__quantity input {
    width: 80px;
    text-align: center;
}
.cart__remove-btn {
    background: none;
    border: none;
    color: #dc3545;
    font-size: 18px;
    cursor: pointer;
}
.cart__summary {
    background: #f8f9fa;
    padding: 30px;
    border-radius: 8px;
}
.cart__summary-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #dee2e6;
}
.cart__summary-total {
    font-size: 18px;
    font-weight: 700;
    border-bottom: 2px solid #333;
}
.cart__empty {
    background: #f8f9fa;
    border-radius: 8px;
}
</style>
@endpush

