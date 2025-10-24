@extends('themes.torganic.layouts.app')

@section('title', 'تفاصيل الطلب #' . $order->id . ' - ' . config('app.name'))

@section('content')
<!-- Page Header -->
<div class="page-header" style="background-color: #f8f9fa; padding: 60px 0 30px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="page-header__title">تفاصيل الطلب #{{ $order->id }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">طلباتي</a></li>
                        <li class="breadcrumb-item active" aria-current="page">الطلب #{{ $order->id }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Order Details Section -->
<section class="order-details padding-top padding-bottom">
    <div class="container">
        <div class="row g-4">
            <!-- Order Info -->
            <div class="col-lg-8">
                <!-- Order Status -->
                <div class="order-details__status mb-4">
                    <div class="alert alert-{{ $statusClasses[$order->status] ?? 'secondary' }}">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-info-circle fa-2x me-3"></i>
                            <div>
                                <h5 class="mb-1">حالة الطلب: {{ $statusLabels[$order->status] ?? $order->status }}</h5>
                                <p class="mb-0">تم إنشاء الطلب بتاريخ: {{ $order->created_at->format('d/m/Y h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="order-details__items">
                    <h4 class="mb-4">المنتجات</h4>
                    <div class="table-responsive">
                        <table class="table order-table">
                            <thead>
                                <tr>
                                    <th>المنتج</th>
                                    <th>السعر</th>
                                    <th>الكمية</th>
                                    <th>المجموع</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="product-thumb me-3">
                                                @if($item->product && $item->product->image)
                                                    <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product_name }}">
                                                @else
                                                    <img src="{{ asset('themes/torganic/assets/images/product/order/1.png') }}" alt="{{ $item->product_name }}">
                                                @endif
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $item->product_name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ number_format($item->price, 2) }} ر.س</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td><strong>{{ number_format($item->price * $item->quantity, 2) }} ر.س</strong></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="order-details__shipping mt-4">
                    <h4 class="mb-3">عنوان الشحن</h4>
                    <div class="address-box p-3 bg-light rounded">
                        <p class="mb-1"><strong>{{ $order->shipping_name ?? $order->user->name }}</strong></p>
                        <p class="mb-1">{{ $order->shipping_address }}</p>
                        <p class="mb-1">{{ $order->shipping_city }}, {{ $order->shipping_country }}</p>
                        @if($order->shipping_postal_code)
                        <p class="mb-1">الرمز البريدي: {{ $order->shipping_postal_code }}</p>
                        @endif
                        <p class="mb-0">الهاتف: {{ $order->shipping_phone ?? $order->user->phone }}</p>
                    </div>
                </div>

                <!-- Order Notes -->
                @if($order->notes)
                <div class="order-details__notes mt-4">
                    <h4 class="mb-3">ملاحظات الطلب</h4>
                    <div class="notes-box p-3 bg-light rounded">
                        <p class="mb-0">{{ $order->notes }}</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="order-details__summary">
                    <h4 class="mb-4">ملخص الطلب</h4>
                    
                    <div class="summary-item">
                        <span>المجموع الفرعي:</span>
                        <span>{{ number_format($order->subtotal, 2) }} ر.س</span>
                    </div>
                    
                    <div class="summary-item">
                        <span>الشحن:</span>
                        <span>{{ number_format($order->shipping_cost, 2) }} ر.س</span>
                    </div>
                    
                    @if($order->discount > 0)
                    <div class="summary-item text-success">
                        <span>الخصم:</span>
                        <span>-{{ number_format($order->discount, 2) }} ر.س</span>
                    </div>
                    @endif
                    
                    @if($order->tax > 0)
                    <div class="summary-item">
                        <span>الضريبة:</span>
                        <span>{{ number_format($order->tax, 2) }} ر.س</span>
                    </div>
                    @endif
                    
                    <div class="summary-item summary-total">
                        <span><strong>المجموع الكلي:</strong></span>
                        <span><strong>{{ number_format($order->total, 2) }} ر.س</strong></span>
                    </div>
                    
                    <!-- Payment Method -->
                    <div class="order-details__payment mt-4">
                        <h5 class="mb-3">طريقة الدفع</h5>
                        <div class="payment-info p-3 bg-light rounded">
                            <p class="mb-0">
                                @switch($order->payment_method)
                                    @case('cod')
                                        <i class="fa-solid fa-money-bill me-2"></i> الدفع عند الاستلام
                                        @break
                                    @case('card')
                                        <i class="fa-solid fa-credit-card me-2"></i> بطاقة ائتمان
                                        @break
                                    @case('bank_transfer')
                                        <i class="fa-solid fa-building-columns me-2"></i> تحويل بنكي
                                        @break
                                    @default
                                        {{ $order->payment_method }}
                                @endswitch
                            </p>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="order-details__actions mt-4">
                        @if($order->status == 'delivered')
                        <a href="{{ route('orders.invoice', $order->id) }}" class="trk-btn trk-btn--primary w-100 mb-2" target="_blank">
                            <i class="fa-solid fa-file-invoice me-2"></i> تحميل الفاتورة
                        </a>
                        @endif
                        
                        @if(in_array($order->status, ['pending', 'processing']))
                        <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="trk-btn trk-btn--outline w-100 text-danger border-danger" onclick="return confirm('هل أنت متأكد من إلغاء هذا الطلب؟')">
                                <i class="fa-solid fa-times me-2"></i> إلغاء الطلب
                            </button>
                        </form>
                        @endif
                        
                        <a href="{{ route('orders.index') }}" class="trk-btn trk-btn--outline w-100 mt-2">
                            <i class="fa-solid fa-arrow-right me-2"></i> العودة إلى الطلبات
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.order-table {
    background: #fff;
}

.order-table thead {
    background: #f8f9fa;
}

.order-table th,
.order-table td {
    padding: 15px;
    vertical-align: middle;
}

.product-thumb {
    width: 60px;
    height: 60px;
    overflow: hidden;
    border-radius: 6px;
}

.product-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.order-details__summary {
    background: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    position: sticky;
    top: 20px;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #f0f0f0;
}

.summary-total {
    font-size: 18px;
    margin-top: 15px;
    padding-top: 15px;
    border-top: 2px solid #333;
    border-bottom: none;
}

.address-box,
.notes-box,
.payment-info {
    border-left: 3px solid #7fad39;
}

@php
    $statusClasses = [
        'pending' => 'warning',
        'processing' => 'info',
        'shipped' => 'primary',
        'delivered' => 'success',
        'cancelled' => 'danger',
    ];
    $statusLabels = [
        'pending' => 'قيد الانتظار',
        'processing' => 'قيد المعالجة',
        'shipped' => 'تم الشحن',
        'delivered' => 'تم التوصيل',
        'cancelled' => 'ملغي',
    ];
@endphp
</style>
@endpush

